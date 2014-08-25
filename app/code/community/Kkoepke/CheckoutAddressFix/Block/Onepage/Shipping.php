<?php
class Kkoepke_CheckoutAddressFix_Block_Onepage_Shipping extends Mage_Checkout_Block_Onepage_Shipping
{
    public function getAddress()
    {
        if (is_null($this->_address)) {
            $this->_address = $this->getQuote()->getShippingAddress();
        }

        return $this->_address;
    }
}
