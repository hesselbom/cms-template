<?php
class Hesselbom_CmsTemplate_Model_Mysql4_Block extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('cmstemplate/block', 'cmstemplate_id');
    }
}