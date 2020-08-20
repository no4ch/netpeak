<?php

namespace app\Controllers;

use app\Services\Converter\ConversionHistorySaver;
use RedBeanPHP\R;
use app\Services\Converter\CurrencyConverter as Converter;

class MainController extends AppController
{
    public function indexAction()
    {
        $currencies = R::findAll('currency');

        $selectedFrom = Converter::make()->getFromCurrency();
        $selectedTo = Converter::make()->getToCurrency();
        $amountFrom = Converter::make()->getAmountFrom();
        $amountTo = Converter::make()->setAmountTo();
        
        if (isset($_GET['saveHistory'])) {
            if ($_GET['saveHistory'] == 'on'){
                if (gettype($amountTo) != 'string')
                ConversionHistorySaver::make()->save();
            }
        }
        unset($_GET['saveHistory']);
        
        $this->setMeta('Главная', 'Описание');
        $this->set(compact('currencies', 'selectedFrom', 'selectedTo', 'amountFrom', 'amountTo'));
    }
    
    public function __construct($route)
    {
        parent::__construct($route);
    }
}