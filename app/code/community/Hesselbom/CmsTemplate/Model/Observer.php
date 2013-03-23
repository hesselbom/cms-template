<?php

class Hesselbom_CmsTemplate_Model_Observer
{
    public function saveCmsPageData($observer)
    {
        $page_id = $observer->getDataObject()->getPageId();
        $template = Mage::getModel('cmstemplate/page')
            ->load($page_id, 'cms_page_id')
            ->setCmsPageId($page_id)
            ->setData('data', $observer->getDataObject()->getData('template'))
            ->save();

        // Remove old data
        $old_data = Mage::getModel('cmstemplate/page_data')
            ->getCollection()
            ->addFieldToFilter('cmstemplate_id', $template->getId());
        foreach ($old_data as $data) {
            $data->delete();
        }

        // Save new data
        foreach ($observer->getDataObject()->getData() as $key=>$value) {
            if (preg_match('/^cmstemplate_([A-Za-z0-9]+)/', $key, $matches)) {
                Mage::getModel('cmstemplate/page_data')
                    ->setCmstemplateId($template->getId())
                    ->setVariable($matches[1])
                    ->setValue($value)
                    ->save();
            }
        }
    }
}