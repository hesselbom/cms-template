<?php

class Hesselbom_CmsTemplate_Model_Block extends Hesselbom_CmsTemplate_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('cmstemplate/block');
    }

    public function getDataModel()
    {
        return Mage::getModel('cmstemplate/block_data');
    }
}