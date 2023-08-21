<?php


use NBP\Client;

require_once 'vendor/autoload.php';

/**
 * Class ExchangeRatesNBP provides functionality to retrieve exchange rates from NBP API.
 */
class ExchangeRatesNBP{

    // YHB, USD, AUD, HKD, CAD, NZD, SGD, EUR, HUF, CHF, GBP, UAH, JPY, CZK, DKK, ISK, NOK, SEK, RON, BGN, TRY, ILS, CLP, PHP, MXN, ZAR, BRL, MYR, IDR, INR, KRW, CNY, XDR
    private string $code;

    // RRRR-MM-DD (standard ISO 8601)
    private DateTimeImmutable $date;

    /**
     * ExchangeRatesNBP constructor.
     *
     * @param string $code The currency code (ISO 4217).
     * @param DateTimeImmutable $date The date for which the exchange rate is requested (ISO 8601).
     */
    public function __construct(string $code, DateTimeImmutable $date) {
        $this->code = $code;
        $this->date = $date;
    }


    /**
     * Get the exchange rate for the specified currency and date.
     *
     * @return float|null The exchange rate or null if no data is found.
     * @throws Exception If an error occurs during the retrieval process.
     */
    public function getExchangeRates(): ?float {
        $client = new Client();

        $startDate = $this->date->sub(new DateInterval('P60D'));

        while ($startDate <= $this->date) {
            try {
                $value = $client->rates()->date('a', $this->code, $startDate);
                return $value['rates'][0]['mid'];
            } catch (NBP\Exception\NotFoundException $e) {
                $startDate = $startDate->add(new DateInterval('P1D'));
            } catch (Exception $e) {
                throw new Exception('An error occurred: ' . $e->getMessage());
            }
        }

        return null; // no data
    }

}
