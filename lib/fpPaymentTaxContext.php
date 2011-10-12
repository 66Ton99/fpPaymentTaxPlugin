<?php

/**
 * Tax context
 *
 * @package    fpPayment
 * @subpackage Tax
 * @author     Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentTaxContext
{
  
  /**
   * Product item
   *
   * @var Product
   */
  protected $item;

  /**
   * Constructor
   *
   * @param Product $item
   */
  public function __construct(sfDoctrineRecord $item)
  {
    if (!$item->getTable()->hasTemplate('fpPaymentProduct')) {
      throw new sfException('The "' . get_class($item) . '" model item must implement fpPaymentProduct behavior');
    }
    if (!$item->getTable()->hasTemplate('fpPaymentTaxable')) {
      throw new sfException('The "' . get_class($item) . '" model item must implement fpPaymentTaxable behavior');
    }
    $this->item = $item;
  }
  
  /**
   * Get payment context
   *
   * @return fpPaymentContext
   */
  protected function getContext()
  {
    return fpPaymentContext::getInstance();
  }
  
  /**
   * Get tax value
   *
   * @param int $quntity
   *
   * @return double
   */
  public function getValue($quntity = 1)
  {
    if(!($customer = $this->getContext()->getCustomer())) return 0.0;
    if (!($customer instanceof sfDoctrineRecord)) {
      throw new sfException('The "' . get_class($customer) . '" is not model');
    }
    if (!$customer->getTable()->hasTemplate('fpPaymentProfileble')) {
      throw new sfException('The "' . get_class($customer) . '" model must implement fpPaymentProfileble behavior');
    }
    
    $tax = fpPaymentTaxDataTable::getInstance()->getTaxByProfileAndProduct($customer->getCusrrentProfile(), $this->item);
    
    return $tax->addTaxToValue($this->item->getPrice() * $quntity);
  }
}
