<?php

declare(strict_types=1);

require_once __DIR__ . '/OzonParse.php';

// Что такое OZON SKU не понял, предположил, что этоп росто ссылка с id на товра, пример ссылки ниже
// Для запуска заменить cookie в Provider на свои куки с сайта озона,

$ozonParse = new OzonParse('https://www.ozon.ru/product/byustgalter-dalsong-bazovaya-model-1790217736');

$result = $ozonParse->getParsedData();

var_dump($result);;
