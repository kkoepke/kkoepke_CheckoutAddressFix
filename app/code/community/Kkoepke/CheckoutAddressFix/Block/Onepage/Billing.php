<?php
class Kkoepke_CheckoutAddressFix_Block_Onepage_Billing extends Mage_Checkout_Block_Onepage_Billing
{

    protected $_address;
    protected $_taxvat;

    /**
     * get Shipping Address
     * 
     * @return Mage_Sales_Model_Quote_Address
     */
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

    /**
     * 
     * get Select Box with the customer addresses
     * 
     * @return string
     */
    public function getAddressesHtmlSelect($type)
    {
        if ($this->isCustomerLoggedIn()) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value' => $address->getId(),
                    'label' => $address->format('oneline')
                );
            }

            $addressId = $this->getAddress()->getCustomerAddressId();
            // set default value as empty string
            if (is_null($addressId)) {
                $addressId = '';
            }

            $select = $this->getLayout()->createBlock('core/html_select')
                ->setName($type.'_address_id')
                ->setId($type.'-address-select')
                ->setClass('address-select')
                ->setExtraParams('onchange="'.$type.'.newAddress(!this.value)"')
                ->setValue($addressId)
                ->setOptions($options);
            $select->addOption('', Mage::helper('checkout')->__('New Address'));
            return $select->getHtml();
        }
        return '';
    }
}
