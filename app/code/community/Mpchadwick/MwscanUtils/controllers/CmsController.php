<?php

class Mpchadwick_MwscanUtils_CmsController extends Mage_Core_Controller_Front_Action
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

        $response = $this->getResponse();
        $response->setHeader('Content-Type', 'text/plain', true);
        $response->appendBody(implode(PHP_EOL . PHP_EOL . '----' .  PHP_EOL . PHP_EOL, $content));
    }
}
