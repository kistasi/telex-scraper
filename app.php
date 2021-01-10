<?php

require './vendor/autoload.php';
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

const BASE_URL = 'https://telex.hu/';
$client = new Client();

$latest_page = $client->request('GET', BASE_URL . 'legfrissebb');
$last_page = $latest_page->filter('.pagination .page:last-child')->attr('href');
$last_page = (int) explode('=', $last_page)[1];

$article_urls = [];
for ($i = 1; $i <= $last_page; $i++) {
    $page = $client->request('GET', BASE_URL . 'legfrissebb?oldal=' . $i);
    $page->filter('.article .article_img .article_title')->each(function (Crawler $node) use ($client, &$article_urls) {
        $article_url = BASE_URL . $node->attr('href');
        array_push($article_urls, $article_url);
    });
}

foreach ($article_urls as $url) {

}
