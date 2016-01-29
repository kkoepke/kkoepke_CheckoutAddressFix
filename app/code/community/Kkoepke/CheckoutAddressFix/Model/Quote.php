<?php

class Kkoepke_CheckoutAddressFix_Model_Quote
extends Mage_Sales_Model_Quote
{
    /**
     * Assign customer model to quote with billing and shipping address change
     *
     * @param  Mage_Customer_Model_Customer    $customer
     * @param  Mage_Sales_Model_Quote_Address  $billingAddress
     * @param  Mage_Sales_Model_Quote_Address  $shippingAddress
     * @return Kkoepke_CheckoutAddressFix_Model_Quote
     */
    public function assignCustomerWithAddressChange(
        Mage_Customer_Model_Customer    $customer,
        Mage_Sales_Model_Quote_Address  $billingAddress  = null,
        Mage_Sales_Model_Quote_Address  $shippingAddress = null
    )
    {
        // customer has id
        if ($customer->getId()) {

            // indiviual billing address and shipping address has been defined
            if (!is_null($billingAddress) && !is_null($shippingAddress))
            {
                return parent::assignCustomerWithAddressChange($customer, $billingAddress, $shippingAddress);
            }

            // if billing address is not set
            if (is_null($billingAddress))
            {
                $tmpBillingAddress = $this->getBillingAddress();
                /* @var $tmpBillingAddress Mage_Sales_Model_Quote_Address */
                $caid = (int) $tmpBillingAddress->getCustomerAddressId();
                if (
                    // check if address is not set
                    ( is_null($tmpBillingAddress->getCustomerAddressId())
                        && is_null($tmpBillingAddress->getCity()))
                    ||
                    // check if address is default address
                    ( $caid > 0 && $customer->getDefaultBillingAddress()
                        && $caid == $customer->getDefaultBillingAddress()->getId())
                )
                {
                    $billingAddress = null;
                } else {
                    // set billing address from quote
                    $billingAddress = $tmpBillingAddress;
                }
            }

            // if shipping address is not set
            if (is_null($shippingAddress))
            {
                $tmpShippingAddress = $this->getShippingAddress();
                /* @var $tmpShippingAddress Mage_Sales_Model_Quote_Address */
                $caid = (int) $tmpShippingAddress->getCustomerAddressId();
                if (
                    // check if address is not set
                    ( is_null($tmpShippingAddress->getCustomerAddressId())
                        && is_null($tmpShippingAddress->getCity()))
                    ||
                    // check if address is default address
                    ( $caid > 0 && $customer->getDefaultShippingAddress()
                        && $caid == $customer->getDefaultShippingAddress()->getId())
                )
                {
                    $shippingAddress = null;
                } else {
                    // set billing address from quote
                    $shippingAddress = $tmpShippingAddress;
                }
                return parent::assignCustomerWithAddressChange($customer, $billingAddress, $shippingAddress);
            }
        // on else use origin magento model
        } else {
            return parent::assignCustomerWithAddressChange($customer, $billingAddress, $shippingAddress);
        }
        return $this;
    }
}
