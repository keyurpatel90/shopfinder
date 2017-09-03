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

namespace Keyurpatel90\Shopfinder\Model;

use Magento\Framework\Api\DataObjectHelper;
use Keyurpatel90\Shopfinder\Api\ShopfinderRepositoryInterface;
use Magento\Store\Model\StoreManagerInterface;
use Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterfaceFactory;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Reflection\DataObjectProcessor;
use Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory as ShopfinderCollectionFactory;
use Keyurpatel90\Shopfinder\Api\Data\ShopfinderSearchResultsInterfaceFactory;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Api\SortOrder;
use Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder as ResourceShopfinder;

class ShopfinderRepository implements ShopfinderRepositoryInterface
{

    protected $searchResultsFactory;

    protected $resource;

    protected $dataObjectProcessor;

    private $storeManager;

    protected $dataObjectHelper;

    protected $shopfinderCollectionFactory;

    protected $shopfinderFactory;

    protected $dataShopfinderFactory;


    /**
     * @param ResourceShopfinder $resource
     * @param ShopfinderFactory $shopfinderFactory
     * @param ShopfinderInterfaceFactory $dataShopfinderFactory
     * @param ShopfinderCollectionFactory $shopfinderCollectionFactory
     * @param ShopfinderSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceShopfinder $resource,
        ShopfinderFactory $shopfinderFactory,
        ShopfinderInterfaceFactory $dataShopfinderFactory,
        ShopfinderCollectionFactory $shopfinderCollectionFactory,
        ShopfinderSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->shopfinderFactory = $shopfinderFactory;
        $this->shopfinderCollectionFactory = $shopfinderCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataShopfinderFactory = $dataShopfinderFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
    ) {
        /* if (empty($shopfinder->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $shopfinder->setStoreId($storeId);
        } */
        try {
            $shopfinder->getResource()->save($shopfinder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the shopfinder: %1',
                $exception->getMessage()
            ));
        }
        return $shopfinder;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($shopfinderId)
    {
        $shopfinder = $this->shopfinderFactory->create();
        $shopfinder->getResource()->load($shopfinder, $shopfinderId);
        if (!$shopfinder->getId()) {
            throw new NoSuchEntityException(__('Shopfinder with id "%1" does not exist.', $shopfinderId));
        }
        return $shopfinder;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $criteria
    ) {
        $collection = $this->shopfinderCollectionFactory->create();
        foreach ($criteria->getFilterGroups() as $filterGroup) {
            foreach ($filterGroup->getFilters() as $filter) {
                if ($filter->getField() === 'store_id') {
                    $collection->addStoreFilter($filter->getValue(), false);
                    continue;
                }
                $condition = $filter->getConditionType() ?: 'eq';
                $collection->addFieldToFilter($filter->getField(), [$condition => $filter->getValue()]);
            }
        }
        
        $sortOrders = $criteria->getSortOrders();
        if ($sortOrders) {
            /** @var SortOrder $sortOrder */
            foreach ($sortOrders as $sortOrder) {
                $collection->addOrder(
                    $sortOrder->getField(),
                    ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                );
            }
        }
        $collection->setCurPage($criteria->getCurrentPage());
        $collection->setPageSize($criteria->getPageSize());
        
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setTotalCount($collection->getSize());
        $searchResults->setItems($collection->getItems());
        return $searchResults;
    }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
    ) {
        try {
            $shopfinder->getResource()->delete($shopfinder);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the Shopfinder: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($shopfinderId)
    {
        return $this->delete($this->getById($shopfinderId));
    }
}
