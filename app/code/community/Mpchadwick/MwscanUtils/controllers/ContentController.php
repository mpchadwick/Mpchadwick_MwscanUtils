<?php

class Mpchadwick_MwscanUtils_ContentController extends Mage_Core_Controller_Front_Action
{
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

        // TODO - Fetch for ALL store view...
        $content[] = Mage::getStoreConfig('design/head/includes');
        $content[] = Mage::getStoreConfig('design/footer/absolute_footer');

        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'text/plain', true);
        $response->appendBody(implode(PHP_EOL . PHP_EOL . '----' .  PHP_EOL . PHP_EOL, $content));
    }
}
