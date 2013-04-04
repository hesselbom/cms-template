<?php
class Handl_CmsTemplate_Model_Mysql4_Block_Data extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('cmstemplate/block_data', 'cmstemplate_data_id');
    }
}