<?php

namespace nez\EuroinvestorClient\instruments\factSheet;

use nez\EuroinvestorClient\ReadOnlyPropertyContainer;

/**
 * Class FactSheet
 *
 * @property-read AboutList $aboutList
 * @property-read Balance $balance
 * @property-read CashFlow $cashFlow
 * @property-read Dividend $dividend
 * @property-read OperativePerformance $operativePerformance
 * @property-read Profibility $profibility
 * @property-read Valuation $valuation
 *
 * @package nez\EuroinvestorClient\instruments
 */
class FactSheet extends ReadOnlyPropertyContainer
{
    private AboutList $_aboutList;
    private Balance $_balance;
    private CashFlow $_cashFlow;
    private Dividend $_dividend;
    private OperativePerformance $_operativePerformance;
    private Profibility $_profibility;
    private Valuation $_valuation;

    /**
     * Magic method for translation $this->aboutList into hitting this method
     *
     * @return AboutList
     */
    public function getAboutListProperty(): AboutList
    {
        return $this->_aboutList ?? $this->_aboutList = new AboutList($this->properties['aboutList']);
    }

    /**
     * Magic method for translation $this->about into hitting this method
     *
     * @return Balance
     */
    public function getBalanceProperty(): Balance
    {
        return $this->_balance ?? $this->_balance = new Balance($this->properties['balance']);
    }

    /**
     * Magic method for translation $this->cashFlow into hitting this method
     *
     * @return CashFlow
     */
    public function getCashFlowProperty(): CashFlow
    {
        return $this->_cashFlow ?? $this->_cashFlow = new CashFlow($this->properties['cashFlow']);
    }

    /**
     * Magic method for translation $this->dividend into hitting this method
     *
     * @return Dividend
     */
    public function getDividendProperty(): Dividend
    {
        return $this->_dividend ?? $this->_dividend = new Dividend($this->properties['dividend']);
    }

    /**
     * Magic method for translation $this->dividend into hitting this method
     *
     * @return OperativePerformance
     */
    public function getOperativePerformanceProperty(): OperativePerformance
    {
        return $this->_operativePerformance ?? $this->_operativePerformance = new OperativePerformance($this->properties['operativePerformance']);
    }

    /**
     * Magic method for translation $this->dividend into hitting this method
     *
     * @return Profibility
     */
    public function getProfibilityProperty(): Profibility
    {
        return $this->_profibility ?? $this->_profibility = new Profibility($this->properties['profibility']);
    }

    /**
     * Magic method for translation $this->dividend into hitting this method
     *
     * @return Valuation
     */
    public function getValuationProperty(): Valuation
    {
        return $this->_valuation ?? $this->_valuation = new Valuation($this->properties['valuation']);
    }
}
