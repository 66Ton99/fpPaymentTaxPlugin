<?php

/**
 * Doctrine extension fpPaymentTaxable
 *
 * @package    fpPayment
 * @subpackage Tax
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class Doctrine_Template_fpPaymentTaxable extends Doctrine_Template
{

  /**
   * Array of options
   *
   * @var array
   */
  protected $_options = array( // TODO optimise 
    'tax_id' => array(
    	'name' => 'tax_id',
      'alias' => null,
      'type' => 'integer',
      'options' => array('notnull' => false),
      'relations' => array('fpPaymentTax as Tax' => array('local' => 'tax_id',
      																										'foreign' => 'id',
      																										'onDelete' => 'SET NULL'))
    )
  );

  /**
   * Set table definition for the behavior
   *
   * @return void
   */
  public function setTableDefinition()
  {
    $this->_options = array_merge($this->_options, sfConfig::get('fp_payment_tax_extra_fields', array()));
    
    foreach ($this->_options as $option) {
      if ($option['alias']) {
        $option['name'] .= ' as ' . $option['alias'];
      }
      if (empty($option['length'])) {
        $option['length'] = null;
      }
      $this->hasColumn($option['name'], $option['type'], $option['length'], $option['options']);
      if (!empty($option['relations'])) {
        foreach ($option['relations'] as $name => $relOptions) {
          if (empty($relOptions['type'])) {
            $relOptions['type'] = 'One';
          }
          $type = 'has' . ucfirst(strtolower($relOptions['type']));
          unset($relOptions['type']);
          $this->$type($name, $relOptions);
        }
      }
    }
  }
  
  /**
   * Get product (item) tax
   *
   * @return double
   */
  public function getTaxValue($quntity = 1)
  {
    $tax = new fpPaymentTaxContext($this->getInvoker());
    return $tax->getValue($quntity);
  }
}

