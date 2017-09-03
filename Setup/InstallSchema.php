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

use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

class InstallSchema implements InstallSchemaInterface
{

    /**
     * {@inheritdoc}
     */
    public function install(
        SchemaSetupInterface $setup,
        ModuleContextInterface $context
    ) {
        $installer = $setup;
        $installer->startSetup();

        $table_keyurpatel90_shopfinder = $setup->getConnection()->newTable($setup->getTable('keyurpatel90_shopfinder'));

        
        $table_keyurpatel90_shopfinder->addColumn(
            'shopfinder_id',
            \Magento\Framework\DB\Ddl\Table::TYPE_INTEGER,
            null,
            array('identity' => true,'nullable' => false,'primary' => true,'unsigned' => true,),
            'Entity ID'
        );
        

        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'shopname',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'shopname'
        );
        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'identifier',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            ['nullable' => False],
            'identifier'
        );
        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'country',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            100,
            ['nullable' => False],
            'country'
        );
        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'image',
            \Magento\Framework\DB\Ddl\Table::TYPE_TEXT,
            null,
            [],
            'image'
        );
        
        $table_keyurpatel90_shopfinder->addColumn(
            'status',
            \Magento\Framework\DB\Ddl\Table::TYPE_BOOLEAN,
            null,
            ['nullable' => False],
            'status'
        );
        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'created',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => False,
             'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT],
            'created'
        );
        

        
        $table_keyurpatel90_shopfinder->addColumn(
            'modified',
            \Magento\Framework\DB\Ddl\Table::TYPE_TIMESTAMP,
            null,
            ['nullable' => False,
             'default' => \Magento\Framework\DB\Ddl\Table::TIMESTAMP_INIT_UPDATE],
            'modified'
        );
        

        $setup->getConnection()->createTable($table_keyurpatel90_shopfinder);

        $setup->endSetup();
    }
}
