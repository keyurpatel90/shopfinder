<?php
/**
 * Shopfinder module
 * Copyright (C) 2017  
 * 
 * This file is part of Keyurpatel90/Shopfinder.
 * 
 * Keyurpatel90/Shopfinder is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 * 
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

namespace Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder;

use Magento\Store\Model\Store;

class Collection extends  \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $storeManager;

    public function __construct(\Magento\Framework\Data\Collection\EntityFactoryInterface $entityFactory, \Psr\Log\LoggerInterface $logger, \Magento\Framework\Data\Collection\Db\FetchStrategyInterface $fetchStrategy, \Magento\Framework\Event\ManagerInterface $eventManager, \Magento\Store\Model\StoreManagerInterface $storeManager, \Magento\Framework\DB\Adapter\AdapterInterface $connection = null, \Magento\Framework\Model\ResourceModel\Db\AbstractDb $resource = null) {
        $this->storeManager = $storeManager;
        parent::__construct($entityFactory, $logger, $fetchStrategy, $eventManager, $connection, $resource);
    }

    
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Keyurpatel90\Shopfinder\Model\Shopfinder',
            'Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder'
        );     
      
    }
    
    
    /**
     * Perform operations after collection load
     *
     * @param string $tableName
     * @param string|null $linkField
     * @return void
     */
    protected function performAfterLoad($tableName, $linkField)
    {
        $linkedIds = $this->getColumnValues($linkField);

        if (count($linkedIds)) {
            $connection = $this->getConnection();
            $select = $connection->select()->from(['shopfinder_store' => $this->getTable($tableName)])
                ->where('shopfinder_store.' . $linkField . ' IN (?)', $linkedIds);
            $result = $connection->fetchAll($select);
            
            if ($result) {
                $storesData = [];
                foreach ($result as $storeData) {
                    $storesData[$storeData[$linkField]][] = $storeData['store_id'];
                }

                foreach ($this as $item) {
                    $linkedId = $item->getData($linkField);
                    if (!isset($storesData[$linkedId])) {
                        continue;
                    }
                    $storeIdKey = array_search(Store::DEFAULT_STORE_ID, $storesData[$linkedId], true);
                    if ($storeIdKey !== false) {
                        $stores = $this->storeManager->getStores(false, true);
                        $storeId = current($stores)->getId();
                        $storeCode = key($stores);
                    } else {
                        $storeId = current($storesData[$linkedId]);
                        $storeCode = $this->storeManager->getStore($storeId)->getCode();
                    }
                    $item->setData('_first_store_id', $storeId);
                    $item->setData('store_code', $storeCode);
                    $item->setData('store_id', $storesData[$linkedId]);
                }
                
                
                
            }
        }
    }
    
     /**
     * Perform operations after collection load
     *
     * @return $this
     */
    protected function _afterLoad()
    {              
        $this->performAfterLoad('shopfinder_store', 'shopfinder_id');
        $this->_previewFlag = false;
        return parent::_afterLoad();
    }
    
    
     /**
     * Add filter by store
     *
     * @param int|array|\Magento\Store\Model\Store $store
     * @param bool $withAdmin
     * @return $this
     */
    public function addStoreFilter($store, $withAdmin = true)
    {
        if ($store) {

            //$this->performAddStoreFilter($store, $withAdmin);
            $this->getSelect()->join(
                    ["ss" => $this->getTable('shopfinder_store')], 'main_table.shopfinder_id = ss.shopfinder_id', array()
            );
            $this->getSelect()->where('ss.store_id =' . $store);
        }
        return $this;
    }

    /* Perform adding filter by store
     *
     * @param int|array|Store $store
     * @param bool $withAdmin
     * @return void
     */
    protected function performAddStoreFilter($store, $withAdmin = true)
    {
        if ($store instanceof Store) {
            $store = [$store->getId()];
        }

        if (!is_array($store)) {
            $store = [$store];
        }

        if ($withAdmin) {
            $store[] = Store::DEFAULT_STORE_ID;
        }

        $this->addFilter('store', ['in' => $store], 'public');
    }
    
}
