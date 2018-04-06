<?php

class msInformMeItemCreateProcessor extends modObjectCreateProcessor
{
    public $objectType = 'msInformMeItem';
    public $classKey = 'msInformMeItem';
    public $languageTopics = array('msinformme');
    //public $permission = 'create';


    /**
     * @return bool
     */
    public function beforeSet()
    {
        $name = trim($this->getProperty('name'));
        if (empty($name)) {
            $this->modx->error->addField('name', $this->modx->lexicon('msinformme_item_err_name'));
        } elseif ($this->modx->getCount($this->classKey, array('name' => $name))) {
            $this->modx->error->addField('name', $this->modx->lexicon('msinformme_item_err_ae'));
        }

        return parent::beforeSet();
    }

}

return 'msInformMeItemCreateProcessor';