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

namespace Keyurpatel90\Shopfinder\Model\ResourceModel;

class Shopfinder extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    protected  $_resource;
    protected  $_linkField;
    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('keyurpatel90_shopfinder', 'shopfinder_id');
        $this->_linkField = "shopfinder_id";
    }
    
     public function lookupStoreIds($entityId){
        // function to fetch all store associated with shop
        
       
        $select = $this->getConnection()->select()
            ->from(['cps' => $this->getTable('shopfinder_store')], 'store_id')
            ->join(
                ['cp' => $this->_resources->getTableName('keyurpatel90_shopfinder')],
                'cps.' . $this->_linkField. ' = cp.' . $this->_linkField,
                []
            )
            ->where('cp.shopfinder_id = :shopfinder_id');
      
        return $this->getConnection()->fetchCol($select, ['shopfinder_id' => (int)$entityId]);
    }
    
    public function saveStores($oldStores,$newStores,$shofinderId){
            
       
                $table = $this->getTable('shopfinder_store');

                $delete = array_diff($oldStores, $newStores);
                if ($delete) {
                    $where = [
                        $this->_linkField . ' = ?' => (int) $shofinderId,
                        'store_id IN (?)' => $delete,
                    ];
                    $this->getConnection()->delete($table, $where);
                }
                
                $insert = array_diff($newStores, $oldStores);
                if ($insert) {
                    $data = [];
                    foreach ($insert as $storeId) {
                        $data[] = [
                             $this->_linkField => (int) $shofinderId,
                            'store_id' => (int) $storeId
                        ];
                    }
                    $this->getConnection()->insertMultiple($table, $data);
                }
                
    }
    
    public function deleteStores($shopfinderId){
                    $table = $this->getTable('shopfinder_store'); 
               
                    $where = [
                        $this->_linkField . ' = ?' => (int) $shopfinderId
                    ];
                    $this->getConnection()->delete($table, $where);
                
    }
    
     
}
