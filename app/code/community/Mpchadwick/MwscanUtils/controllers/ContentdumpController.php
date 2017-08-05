<?php

class Mpchadwick_MwscanUtils_ContentdumpController extends Mage_Core_Controller_Front_Action
{
    const SEPARATOR = PHP_EOL . PHP_EOL . '----' . PHP_EOL . PHP_EOL;

    protected $configKeys = array(
        'design/head/includes',
        'design/footer/absolute_footer'
    );

    public function indexAction()
    {
        $content = array_merge(
            Mage::getModel('cms/page')
                ->getCollection()
                ->getColumnValues('content'),
            Mage::getModel('cms/block')
                ->getCollection()
                ->getColumnValues('content'),
            Mage::getModel('core/config_data')
                ->getCollection()
                ->addFieldToFilter('path', array('in' => $this->configKeys))
                ->getColumnValues('value')
        );

        $container = new Varien_Object;
        $container->setContent($content);
        Mage::dispatchEvent(
            'mpchadwick_mwscanutils_dump_content_before',
            array('container' => $container)
        );

        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'text/plain', true);
        $response->appendBody(implode(self::SEPARATOR, $container->getContent()));
    }
}
