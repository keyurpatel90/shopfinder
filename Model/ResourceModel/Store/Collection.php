<?php

namespace Keyurpatel90\Shopfinder\Model\ResourceModel\Store;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Keyurpatel90\Shopfinder\Model\Store', 'Keyurpatel90\Shopfinder\Model\ResourceModel\Store');
        $this->_map['fields']['page_id'] = 'main_table.page_id';
    }

}
?>