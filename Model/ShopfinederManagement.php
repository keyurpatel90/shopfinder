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
use Magento\Framework\Exception\NoSuchEntityException;

 use Magento\Framework\Api\SortOrder;


class ShopfinederManagement implements \Keyurpatel90\Shopfinder\Api\ShopfinederManagementInterface 
{

         /**
         * @var \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory
         */
        protected $collectionFactory;
        /**
         * @var \Magento\Framework\Api\SearchCriteriaBuilder
         */
        protected $searchCriteriaBuilder;
        /**
         * @var \Keyurpatel90\Shopfinder\Api\Data\ShopfinderSearchResultsInterfaceFactory
         */
        protected $searchResultsFactory;
        /**
         * @var \Magento\Store\Model\StoreManagerInterface
         */
        protected $storeManager;
        /**
         * @var \Magento\Framework\App\Request\Http
         */
        protected $request;
    
    /**
     * {@inheritdoc}
     */
        
        
        /**
         * ShopfinderManagement constructor.
         *
         * @param \Keyurpatel90\Shopfinder\Api\Data\ShopfinderSearchResultsInterfaceFactory $searchResultsFactory
         * @param \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory $collectionFactory
         * @param \Magento\Framework\Api\SearchCriteriaBuilder                 $searchCriteriaBuilder
         * @param \Magento\Store\Model\StoreManagerInterface                   $storeManager
         * @param \Magento\Framework\App\Request\Http                          $request
         * @SuppressWarnings(PHPMD.ExcessiveParameterList)
         * @SuppressWarnings(PHPMD.UnusedFormalParameter)
         */
        public function __construct(
            \Keyurpatel90\Shopfinder\Api\Data\ShopfinderSearchResultsInterfaceFactory $searchResultsFactory,
            \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\CollectionFactory $collectionFactory, 
            \Magento\Framework\Api\SearchCriteriaBuilder $searchCriteriaBuilder, 
            \Magento\Store\Model\StoreManagerInterface $storeManager, 
            \Magento\Framework\App\Request\Http $request ) {
            $this->collectionFactory = $collectionFactory;
            $this->searchCriteriaBuilder = $searchCriteriaBuilder;
            $this->searchResultsFactory = $searchResultsFactory;
            $this->storeManager = $storeManager;
            $this->request = $request;
        }
        
        
    public function getShopfineder()
    {
         try{
           $storeId = $this->storeManager->getStore()->getId();
          
            /** @var \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder\Collection $collection */
            $collection = $this->collectionFactory->create();
            if ( $storeId != 1 ) {
                $collection->addStoreFilter($storeId);
            }
            
            $this->searchCriteriaBuilder->create();
            $searchResults = $this->searchResultsFactory->create();
            $criteria = $this->request->get('searchCriteria');
            
            if ( isset( $criteria ) && !empty( $criteria ) ) {
                if ( isset( $criteria['filterGroups'][0]['filters'] ) && !empty( $criteria['filterGroups'][0]['filters'] ) ) {
                    foreach ( $criteria['filterGroups'][0]['filters'] as $filter ) {
                        $condition = ( isset( $filter['condition_type'] ) && !empty( $filter['condition_type'] ) ) ? $filter['condition_type'] : 'eq';
                        if ( $condition == 'like' ) {
                            $filter['value'] = '%' . $filter['value'] . '%';
                        }
                        $collection->addFieldToFilter($filter['field'], [ $condition => $filter['value'] ]);
                        $this->searchCriteriaBuilder->addFilter($filter['field'], $filter['value'], $condition);
                    }
                }
                
                if ( isset( $criteria['current_page'] ) && !empty( $criteria['current_page'] ) ) {
                    $collection->setCurPage($criteria['current_page']);
                    $this->searchCriteriaBuilder->setCurrentPage($criteria['current_page']);
                }
                if ( isset( $criteria['page_size'] ) && !empty( $criteria['page_size'] ) ) {
                    $collection->setPageSize($criteria['current_page']);
                    $this->searchCriteriaBuilder->setPageSize($criteria['page_size']);
                }
                if ( isset( $criteria['sort_orders'] ) && !empty( $criteria['sort_orders'] ) ) {
                    foreach ( $criteria['sort_orders'] as $sort ) {
                        $collection->addOrder($sort['field'], ( $sort['direction'] == SortOrder::SORT_ASC ) ? 'ASC' : 'DESC');
                        $this->searchCriteriaBuilder->addSortOrder($sort['field'], ( $sort['direction'] == SortOrder::SORT_ASC ) ? 'ASC' : 'DESC');
                    }
                }
                $searchResults->setSearchCriteria($this->searchCriteriaBuilder->create());
            }
            $collection->load();
           
            $searchResults->setItems($collection->getItems());
            $searchResults->setTotalCount($collection->getSize());
            return $searchResults;
         }catch(\Exception $ex){
               throw new NoSuchEntityException(__('Requested data not found'.$ex->getMessage()));
         }
    }
}
