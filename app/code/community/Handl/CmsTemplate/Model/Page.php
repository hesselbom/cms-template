<?php

class Handl_CmsTemplate_Model_Page extends Handl_CmsTemplate_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('cmstemplate/page');
    }

    public function getDataModel()
    {
        return Mage::getModel('cmstemplate/page_data');
    }
}