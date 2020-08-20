<?php


namespace app\Services\Converter;
use app\Services\Converter\CurrencyConverter as Converter;
use RedBeanPHP\R;


class ConversionHistorySaver
{
    protected $fromCurrency;
    protected $toCurrency;
    protected $table = "history";
    
    public function __construct() {
        $fromCurrency = Converter::make()->getFromCurrency();
        $this->fromCurrency = R::findOne("currency", "WHERE `bank_code` = ?", [$fromCurrency]);
    
        $toCurrency = Converter::make()->getToCurrency();
        $this->toCurrency = R::findOne("currency", "WHERE `bank_code` = ?", [$toCurrency]);
    }
    
    public static function make(): ConversionHistorySaver
    {
        return new static();
    }
    
    public function save() {
        $history = R::dispense($this->table);
        $history->from_currency_id = $this->fromCurrency->id;
        $history->to_currency_id = $this->toCurrency->id;
        R::store($history);
    }
}