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

namespace Keyurpatel90\Shopfinder\Model\Shopfinder;

use Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Keyurpatel90\Shopfinder\Model\Uploader;
use Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{

    protected $dataPersistor;

    protected $loadedData;
    protected $collection;
    protected $uploader;
    protected $resourceShopfinder;


    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct($name, $primaryFieldName, $requestFieldName, CollectionFactory $collectionFactory, DataPersistorInterface $dataPersistor, Uploader $uploader, Shopfinder $resourceShopfinder, array $meta = array(), array $data = array()) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->uploader = $uploader;
        $this->resourceShopfinder = $resourceShopfinder;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            $itemData = $model->getData();
            $itemData["storeview"]= $this->resourceShopfinder->lookupStoreIds($itemData["shopfinder_id"]);
            $imageName = $itemData['image']; 
            $baseUrl = $this->uploader->getBaseUrl();
            $basePath = $this->uploader->getBasePath();
            $imageUrl = $baseUrl.'/'.$basePath.'/'.$imageName;
            unset($itemData['image']);
            $itemData['image'] = array(
                array(
                    'name'  =>  $imageName,
                    'url'   =>  $imageUrl // Should return a URL to view the image. For example, http://domain.com/pub/media/../../imagename.jpeg
                )
            );
            
            $this->loadedData[$model->getShopfinderId()] = $itemData;
        }
        $data = $this->dataPersistor->get('keyurpatel90_shopfinder_shopfinder');
        
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            
            
            $model->setData($data);
            $this->loadedData[$model->getShopfinderId()] = $model->getData();
            $this->dataPersistor->clear('keyurpatel90_shopfinder_shopfinder');
        }
        
        return $this->loadedData;
    }
}
