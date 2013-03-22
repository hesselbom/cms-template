<?php

class Hesselbom_CmsTemplate_Block_Adminhtml_Cms_Tab
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    protected function _prepareForm()
    {
        /** @var $model Mage_Cms_Model_Page */
        $model = Mage::registry('cms_page');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $content_fieldset = $form->addFieldset('cmstemplate_content_fieldset', array('legend'=>Mage::helper('cms')->__('Content'),'class'=>'fieldset-wide'));
        $template_fieldset = $form->addFieldset('cmstemplate_template_fieldset', array('legend'=>Mage::helper('cms')->__('Template'),'class'=>'fieldset-wide'));

        $content_fieldset->addField('content_label', 'label', array(
            'name'      => 'content_label',
            'label'     => Mage::helper('cms')->__('No fields in template'),
            'disabled'  => $isElementDisabled
        ));

        $template_fieldset->addField('template', 'textarea', array(
            'name'      => 'template',
            'label'     => Mage::helper('cms')->__('Template'),
            'title'     => Mage::helper('cms')->__('Template'),
            'value'     => 'Test{{Test:textarea}}{{Titel}}',
            'disabled'  => $isElementDisabled,
        ));

        $template_fieldset->addField('update_template', 'button', array(
            'name'      => 'update_template',
            'value'     => Mage::helper('cms')->__('Update Template'),
            'disabled'  => $isElementDisabled,
            'onclick'   => 'CmsTemplate.updateCmsTemplateFields();',
        ));

        $this->setForm($form);

        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_cmstemplate_prepare_form', array('form' => $form));

        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return $this->__('Template');
    }

    public function getTabTitle()
    {
        return $this->__('Template');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $action
     * @return bool
     */
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }
}