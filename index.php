<?php


$code = 'usd';
$date = new DateTimeImmutable('2022-05-14');
$exchangeRatesNBP = new ExchangeRatesNBP($code, $date);
echo $exchangeRatesNBP->getExchangeRates() !== null ? $exchangeRatesNBP->getExchangeRates() : 'null';

