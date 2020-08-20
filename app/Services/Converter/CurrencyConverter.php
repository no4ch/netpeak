<?php

namespace app\Services\Converter;

use RedBeanPHP\R;

class CurrencyConverter
{
    protected $table = "currency";
    
    protected $token = "uqbbuuZZPuRMYh3hh1aBMwBrIRTESBoTihLr";
    
    public static function make(): CurrencyConverter
    {
        return new static();
    }
    
    public function getFromCurrency()
    {
        return isset($_GET['from']) ? $_GET['from'] : 'USD';
    }
    
    public function getToCurrency()
    {
        return isset($_GET['to']) ? $_GET['to'] : 'USD';
    }
    
    //количество валюты для конвертации
    public function getAmountFrom()
    {
        return (isset($_GET['amountFrom']) && $_GET['amountFrom'] != '') ? $_GET['amountFrom'] : 0;
    }
    
    public function setAmountTo()
    {
        if ($this->getFromCurrency() == $this->getToCurrency()) {
            return $this->getAmountFrom();
        }
        
        $currencies = R::findLike($this->table, [
            'bank_code' => [$this->getFromCurrency(), $this->getToCurrency()]
        ]);
        
        if (count($currencies) < 2) {
            return "Указанные валюта(ы) не найдены";
        }
        
        $href = "https://currencyapi.net/api/v1/rates?key=$this->token&base={$this->getFromCurrency()}";
        //$exchangeRates = json_decode(file_get_contents($href));
        $exchangeRates = json_decode($this->exchangeRates);
        if ($exchangeRates->valid != true) {
            return 'Нет доступа к АПИ';
        }
        
        $currency = $this->getToCurrency();
        
        if ($exchangeRates->rates->$currency) {
            return $exchangeRates->rates->$currency * $this->getAmountFrom();
        }
        
        return 'Произошла ошибка';
    }
    
    public $exchangeRates = "{\"valid\":true,\"updated\":1597865331,\"base\":\"USD\",\"rates\":{\"AED\":3.67312,\"AFN\":77.92772,\"ALL\":103.66889,\"AMD\":484.325,\"ANG\":1.79454,\"AOA\":577.179,\"ARS\":73.48173,\"AUD\":1.38933,\"AWG\":1.8,\"AZN\":1.7,\"BAM\":1.63792,\"BBD\":2.01857,\"BCH\":0.003481348674476492,\"BDT\":84.77329,\"BGN\":1.65034,\"BHD\":0.37701,\"BIF\":1928.61845,\"BMD\":1,\"BND\":1.36335,\"BOB\":6.89317,\"BRL\":5.53258,\"BSD\":0.99978,\"BTC\":0.00008560749647725153,\"BTG\":0.09596928982725528,\"BWP\":11.61134,\"BZD\":2.01513,\"CAD\":1.32041,\"CDF\":1950.1,\"CHF\":0.91324,\"CLP\":783.53,\"CNH\":6.92044,\"CNY\":6.9195,\"COP\":3764.368,\"CRC\":594.95565,\"CUC\":1,\"CUP\":0.99995,\"CVE\":92.34227,\"CZK\":22.0182,\"DASH\":0.011375270162666365,\"DJF\":177.729,\"DKK\":6.282,\"DOP\":58.30502,\"DZD\":128.09421,\"EGP\":15.9346,\"EOS\":0.30553009471432935,\"ETB\":35.94008,\"ETH\":0.0024983448465391678,\"EUR\":0.84366,\"FJD\":2.12286,\"GBP\":0.7627,\"GEL\":3.09,\"GHS\":5.76869,\"GIP\":0.7627,\"GMD\":51.805,\"GNF\":9650.2745,\"GTQ\":7.69799,\"GYD\":208.99195,\"HKD\":7.7499,\"HNL\":24.65024,\"HRK\":6.35412,\"HTG\":112.31542,\"HUF\":294.17,\"IDR\":14737.035,\"ILS\":3.399,\"INR\":74.94685,\"IQD\":1193.50365,\"IRR\":42107.1,\"ISK\":136.587,\"JMD\":150.44492,\"JOD\":0.70905,\"JPY\":105.94,\"KES\":108.505,\"KGS\":77.70509,\"KHR\":4087.44935,\"KMF\":412.9705,\"KRW\":1182.59415,\"KWD\":0.30541,\"KYD\":0.83312,\"KZT\":418.61153,\"LAK\":9080.651,\"LBP\":1511.8096,\"LKR\":186.1024,\"LRD\":199.31,\"LSL\":17.351,\"LTC\":0.016626485992185552,\"LYD\":1.36782,\"MAD\":9.16296,\"MDL\":16.59029,\"MKD\":51.59995,\"MMK\":1361.41305,\"MOP\":7.98069,\"MUR\":39.7,\"MVR\":15.411,\"MWK\":748.60345,\"MXN\":22.0808,\"MYR\":4.17271,\"MZN\":71.26855,\"NAD\":17.351,\"NGN\":385.4095,\"NIO\":34.79152,\"NOK\":8.8831,\"NPR\":119.48538,\"NZD\":1.5197,\"OMR\":0.38502,\"PAB\":0.9997,\"PEN\":3.56605,\"PGK\":3.53018,\"PHP\":48.62145,\"PKR\":168.45692,\"PLN\":3.7081,\"PYG\":6944.2602,\"QAR\":3.6412,\"RON\":4.08471,\"RSD\":99.185,\"RUB\":73.0796,\"RWF\":965.5823,\"SAR\":3.75034,\"SBD\":8.26598,\"SCR\":17.83095,\"SDG\":55.305,\"SEK\":8.6838,\"SGD\":1.36925,\"SLL\":9762.99,\"SOS\":582.53,\"SRD\":7.45835,\"SVC\":8.7475,\"SZL\":17.21461,\"THB\":31.2915,\"TJS\":10.31455,\"TMT\":3.51,\"TND\":2.72764,\"TOP\":2.27942,\"TRY\":7.2898,\"TTD\":6.77542,\"TWD\":29.39245,\"TZS\":2320.1,\"UAH\":27.36719,\"UGX\":3674.1577,\"USD\":1,\"UYU\":42.7238,\"UZS\":10267.0735,\"VND\":23176.15,\"XAF\":549.37067,\"XAG\":0.037192003719200374,\"XAU\":0.0005135355122645118,\"XCD\":2.70269,\"XLM\":10.040160642570282,\"XOF\":549.37067,\"XRP\":3.4989503149055285,\"YER\":250.3625,\"ZAR\":17.2073,\"ZMW\":18.77071}}";
}