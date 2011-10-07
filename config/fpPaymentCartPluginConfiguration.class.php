<?php

/**
 * fpPaymentTaxPlugin configuration
 *
 * @package    fpPayment
 * @subpackage Tax
 * @author 	   Ton Sharp <Forma-PRO@66ton99.org.ua>
 */
class fpPaymentTaxPluginConfiguration extends sfPluginConfiguration
{
  
  /**
   * (non-PHPdoc)
   * @see sfPluginConfiguration::initialize()
   */
  public function initialize()
  {
    $configFiles = $this->configuration->getConfigPaths('config/fp_payment_tax.yml');
    $config = sfDefineEnvironmentConfigHandler::getConfiguration($configFiles);
    
    foreach ($config as $name => $value) {
      sfConfig::set("fp_payment_tax_{$name}", $value);  
    }
  }
}