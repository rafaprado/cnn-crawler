<?php

namespace CnnExplorer\NewsSearcher;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Searcher {
    private Client $httpClient;
    private Crawler $crawler;
    private string $baseUri;

    public function __construct() 
    {
        $this->baseUri = 'https://www.cnnbrasil.com.br/';
        $this->httpClient = new Client(['base_uri' => $this->baseUri, 'verify' => false]);
        $this->crawler = new Crawler();
    }

    public function getMostRead(): array 
    {
        return $this->searchNews(cssSelector: 'h3.mostread__title');
    }

    public function getFromField(string $field) 
    {
        return $this->searchNews(cssSelector: 'h3.news-item-header__title', field: $field);
    }


    private function searchNews(string $cssSelector, string $field = ''): array|string
    {
        try {
            $response = $this->httpClient->request('GET', $field);
            $html = $response->getBody();
    
            $this->crawler->addHtmlContent($html);
            $elements = $this->crawler->filter($cssSelector);
    
            $results = [];
            foreach ($elements as $element) {
                $results[] = $element->textContent;
            }
    
            return $results;
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return 'Sua URL está inválida!';
        }
    }
}