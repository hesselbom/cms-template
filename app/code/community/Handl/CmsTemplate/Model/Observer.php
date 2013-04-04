<?php

class Handl_CmsTemplate_Model_Observer
{
    public function setCmsPageContent($observer)
    {
        // Set CMS content based on template and template data
        $content = $observer->getDataObject()->getData('template');
        $data = array();
        foreach ($observer->getDataObject()->getData() as $key=>$value) {
            if (preg_match('/^cmstemplate_([A-Za-z0-9]+)/', $key, $matches)) {
                $data[$matches[1]] = $value;
            }
        }
        $observer
            ->getDataObject()
            ->setContent(Mage::getSingleton('cmstemplate/page')
                ->generateContent($content, $data));
    }

    public function saveCmsPageTemplate($observer)
    {
        $page_id = $observer->getDataObject()->getPageId();
        $content = $observer->getDataObject()->getData('template');
        $template = Mage::getModel('cmstemplate/page')
            ->load($page_id, 'cms_page_id')
            ->setCmsPageId($page_id)
            ->setContent($content)
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