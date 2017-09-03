<?php
namespace Keyurpatel90\Shopfinder\Model\ResourceModel;

class Store extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('shopfinder_store', 'shopfinder_id');
    }
}
?>