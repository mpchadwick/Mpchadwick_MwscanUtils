<?php

// https://magento.stackexchange.com/questions/43370/adding-a-product-by-upgrade-script#answer-43372

$websiteIds = Mage::getModel('core/website')->getCollection()
    ->addFieldToFilter('website_id', array('neq'=>0))
    ->getAllIds();


$product = Mage::getModel('catalog/product');
$product->setStoreId(0);
$product->setWebsiteIds($websiteIds);
$product->setTypeId('simple');
$product->addData(array(
    'name' => 'Mwscanutils Test Product',
    'attribute_set_id' => $product->getDefaultAttributeSetId(), //use the default attribute set or an other id if needed.
    'status' => Mage_Catalog_Model_Product_Status::STATUS_ENABLED, //set product as enabled
    'visibility' => Mage_Catalog_Model_Product_Visibility::VISIBILITY_NOT_VISIBLE, //set visibility in catalog and search
    'meta_title' => 'Meta title here',
    'weight' => 1,
    'sku' => 'mwscanutils-test-product',
    'price' => 10.00,
    'tax_class_id' => 2, //could not find a non-hardcoded value for this
    'description' => 'Description here',
    'short_description' => 'Short description here',
    'stock_data' => array( //set stock data
        'manage_stock' => 1,
        'qty' => 999, //set the qty
        'use_config_manage_stock' => 1,
        'use_config_min_sale_qty' => 1,
        'use_config_max_sale_qty' => 1,
        'use_config_enable_qty_increments' => 1,
        'is_in_stock' => 1
    ),

));
$product->save();
