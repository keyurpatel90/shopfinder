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

namespace Keyurpatel90\Shopfinder\Setup;

use Magento\Framework\Setup\UpgradeSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class UpgradeSchema implements UpgradeSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function upgrade(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $setup->startSetup();
        if (version_compare($context->getVersion(), '1.0.2') < 0) {
        
            /**
        * Drop column storeview
        **/
        $setup->getConnection()->dropColumn($setup->getTable('keyurpatel90_shopfinder'), 'storeview');
        }

         if (version_compare($context->getVersion(), '1.0.3') < 0) {
        /**
         * Create table 'shopfinder_store'
         */
        $shopfinder_store_table = $setup->getConnection()->newTable(
            $setup->getTable('shopfinder_store')
        )->addColumn(
            'shopfinder_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            10,
            ['identity' => true,'nullable' => false, 'primary' => true,'unsigned' => true],
            'Shopfinder ID'
        )->addColumn(
            'store_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            null,
            ['unsigned' => true, 'nullable' => false, 'primary' => true],
            'Store ID'
        )->addIndex(
            $setup->getIdxName('shopfinder_store', ['store_id']),
            ['store_id']
        )
        ->addForeignKey(
            $setup->getFkName('shopfinder_store', 'shopfinder_id', 'keyurpatel90_shopfinder', 'shopfinder_id'),
            'shopfinder_id',
            $setup->getTable('keyurpatel90_shopfinder'),
            'shopfinder_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )
        ->addForeignKey(
            $setup->getFkName('shopfinder_store', 'store_id', 'store', 'store_id'),
            'store_id',
            $setup->getTable('store'),
            'store_id',
            \Magento\Framework\DB\Ddl\Table::ACTION_CASCADE
        )->setComment(
            'Shopfinder To Store Linkage Table'
        );
        $setup->getConnection()->createTable($shopfinder_store_table);

        

        }
        $setup->endSetup();
    }
}
