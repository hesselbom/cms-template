<?php
class Handl_CmsTemplate_Model_Mysql4_Page_Data extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('cmstemplate/page_data', 'cmstemplate_data_id');
    }
}