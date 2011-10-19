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
   * Customer
   *
   * @var sfGuardUser
   */
  protected $customer;

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
    
    if ($this->customer = $this->getContext()->getCustomer()) {
      if (!($this->customer instanceof sfDoctrineRecord)) {
        throw new sfException('The "' . get_class($this->customer) . '" is not model');
      }
      if (!$this->customer->getTable()->hasTemplate('fpPaymentProfileble')) {
        throw new sfException('The "' . get_class($this->customer) . '" model must implement fpPaymentProfileble behavior');
      }
    }
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
   * Get customer
   *
   * @return sfGuardUser
   */
  public function getCunstomer()
  {
    return $this->customer;
  }
  
	/**
   * Get product item
   *
   * @return Product
   */
  public function getItem()
  {
    return $this->item;
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
    if (!$this->getCunstomer() || !($profile = $this->getCunstomer()->getCurrentBillingProfile())) return 0.00;
    
    if ($tax = fpPaymentTaxDataTable::getInstance()->getTaxByProfileAndProduct($profile, $this->getItem())) {
      return $tax->getTaxFromValue($this->getItem()->getPrice() * $quntity);
    }
    return 0.00;
  }
}
