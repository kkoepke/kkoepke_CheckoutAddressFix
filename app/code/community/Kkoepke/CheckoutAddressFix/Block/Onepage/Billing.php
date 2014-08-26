<?php
class Kkoepke_CheckoutAddressFix_Block_Onepage_Billing extends Mage_Checkout_Block_Onepage_Billing
{
    protected $_address;
    protected $_taxvat;

    public function getAddress() {
        if(is_null($this->_address)) {
            if($this->isCustomerLoggedIn()) {
                $this->_address = $this->getQuote()->getBillingAddress();
                if(!$this->_address->getFirstname()) {
                    $this->_address->setFirstname($this->getQuote()->getCustomer()->getFirstname());
                }
                if(!$this->_address->getLastname()) {
                    $this->_address->setLastname($this->getQuote()->getCustomer()->getLastname());
                }
            } else {
                $this->_address = $this->getQuote()->getBillingAddress();
            }
        }

        return $this->_address;
    }
}
