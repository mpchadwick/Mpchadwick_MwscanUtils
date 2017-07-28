<?php

class Mpchadwick_MwscanUtils_Model_Observer
{
    public function allowRendering()
    {
        if (!Mage::app()->getRequest()->getParam('mwscanutils_force')) {
            return;
        }

        $product = Mage::getModel('catalog/product')->loadByAttribute('sku', 'mwscanutils-test-product');

        /**
         * loadByAttribute doesn't call _beforeLoad and _afterLoad which is required here
         * so we now call load()
         */
        $product->load();

        Mage::getSingleton('checkout/cart')
            ->addProduct($product, array('qty' => 1))
            ->save();
    }
}
