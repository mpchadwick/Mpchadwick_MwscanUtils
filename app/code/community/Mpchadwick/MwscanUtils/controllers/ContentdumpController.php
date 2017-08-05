<?php

class Mpchadwick_MwscanUtils_ContentdumpController extends Mage_Core_Controller_Front_Action
{
    protected $configKeys = array(
        'design/head/includes',
        'design/footer/absolute_footer'
    );

    public function indexAction()
    {
        $data = array_merge(
            Mage::getModel('cms/page')
                ->getCollection()
                ->getData(),
            Mage::getModel('cms/block')
                ->getCollection()
                ->getData()
        );

        $content = array();
        foreach ($data as $datum) {
            $content[] = $datum['content'];
        }

        // @codingStandardsIgnoreStart
        // TODO - Fetch for ALL store view...
        // @codingStandardsIgnoreEnd
        $config = Mage::getModel('core/config_data')
            ->getCollection()
            ->addFieldToFilter('path', array('in' => $this->configKeys));

        $content = array_merge($content, $config->getColumnValues('value'));

        $container = new Varien_Object;
        $container->setContent($content);
        Mage::dispatchEvent(
            'mpchadwick_mwscanutils_dump_content_before',
            array('container' => $container)
        );

        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'text/plain', true);
        $response->appendBody(implode(PHP_EOL . PHP_EOL . '----' .  PHP_EOL . PHP_EOL, $container->getContent()));
    }
}
