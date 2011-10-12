<?php

/**
 * Doctrine extension fpPaymentTaxable listener
 *
 * @package    fpPayment
 * @subpackage Tax
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class Doctrine_Template_Listener_fpPaymentTaxable extends Doctrine_Record_Listener
{

  /**
   * Constructor
   *
   * @param array $options
   */
  public function __construct($options = array())
  {
    $this->_options = $options;
  }
}