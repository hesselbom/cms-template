<?php

class Hesselbom_CmsTemplate_Model_Abstract extends Mage_Core_Model_Abstract
{
    public function generateContent($content, $data)
    {
        $content = $this->_replaceLabelsWithIds($content);
        foreach ($data as $key => $value) {
            $content = str_replace('{{'.$key.'}}', $value, $content);
        }
        return $content;
    }

    public function getDataModel()
    {
        return null;
    }

    public function getDataCollection()
    {
        return $this->getDataModel()
            ->getCollection()
            ->addFieldToFilter('cmstemplate_id', $this->getCmstemplateId());
    }

    protected function _replaceLabelsWithIds($text)
    {
        $ids = array();
        preg_match_all('/\{\{([\w\s:]+)\}\}/', $text, $matches);
        foreach ($matches[1] as $result) {
            $result_exploded = explode(':', $result);
            $label = $result_exploded[0];
            $id = $this->_generateId($label, $ids);
            $text = str_replace('{{'.$result.'}}', '{{'.$id.'}}', $text);
            $ids[] = $id;
        }
        return $text;
    }

    protected function _generateId($label, $ids)
    {
        $id = preg_replace('/[^A-Za-z0-9]/', '_', strtolower($label));
        if (!$id) $id = 'input';
        $original_id = $id;
        for ($i = 1; $i; $i++) {
            if (!$this->_idExists($id)) break;
            $id = $original_id . '_' . $i;
        }
        return $id;
    }

    protected function _idExists($id, $ids) {
        foreach ($ids as $existing_id) {
            if ($existing_id === $id) {
                return true;
            }
        }
        return false;
    }
}