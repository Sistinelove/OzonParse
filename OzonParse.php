<?php

declare(strict_types=1);

require_once __DIR__ . '/Provider.php';

class OzonParse
{
    private Provider $_provider;

    public function __construct(string $url)
    {
        $this->_provider = new Provider($url);
    }

    public function getParsedData(): array
    {
        $html = $this->_provider->requests();

        if (!$html) {
            return [];
        }

        return $this->parseHtml($html);
    }

    private function parseHtml(string $html): array
    {
        $data = [];

        preg_match('#<script[^>]*type="application/ld\+json"[^>]*>(.*?)</script>#s', $html, $matchesJson);

        $jsonProduct = [];
        if (isset($matchesJson[1])) {
            $jsonProduct = json_decode($matchesJson[1], true) ?? [];
        }
        var_dump($jsonProduct);
        echo 'kasjdlas';
        die;

        $data['name'] = $jsonProduct['name'] ?? null;
        $data['brand'] = $jsonProduct['brand'] ?? null;
        $data['sku'] = $jsonProduct['sku'] ?? null;
        $data['description'] = $jsonProduct['description'] ?? null;
        $data['price'] = $jsonProduct['offers']['price'] ?? null;
        $data['currency'] = $jsonProduct['offers']['priceCurrency'] ?? 'RUB';

        $images = [];
        if (isset($jsonProduct['image'])) {
            $images = is_array($jsonProduct['image']) ? $jsonProduct['image'] : [$jsonProduct['image']];
        }

        preg_match_all('#https://ir-\d+\.ozone\.ru/s3/multimedia[^"\'\s]+\.jpg#', $html, $mImages);
        if (!empty($mImages[0])) {
            foreach ($mImages[0] as $imgUrl) {
                if (strpos($imgUrl, 'wc50') === false && strpos($imgUrl, 'c50') === false) {
                    $images[] = $imgUrl;
                }
            }
        }
        $data['images'] = array_values(array_unique($images));

        preg_match('#Партномер.*?tsBody400Small[^>]*>(.*?)</span>#su', $html, $mPart);
        $data['part_number'] = isset($mPart[1]) ? trim(strip_tags($mPart[1])) : null;

        $country = null;
        if (preg_match('#Страна(?:-изготовитель)?.*?tsBody400Small[^>]*>(.*?)</span>#su', $html, $m)) {
            $country = trim(strip_tags($m[1]));
        } elseif (preg_match('#"key":"Страна(?:-изготовитель)?".*?"text":"(.*?)"#su', $html, $m)) {
            $country = json_decode('"' . $m[1] . '"');
        }
        $data['country'] = $country;

        preg_match('#Тип(?:(?!Тип).)*?tsBody400Small[^>]*>(.*?)<#su', $html, $mType);
        $data['type'] = isset($mType[1]) ? trim(strip_tags($mType[1])) : null;

        preg_match('#<ol[^>]*>(.*?)</ol>#su', $html, $matchesOl);
        if (isset($matchesOl[1])) {
            preg_match_all('#<span[^>]*>(.*?)</span>#su', $matchesOl[1], $crumbs);
            $data['category'] = isset($crumbs[1]) ? array_map('trim', array_map('strip_tags', $crumbs[1])) : [];
        } else {
            $data['category'] = [];
        }

        return $data;
    }
}

