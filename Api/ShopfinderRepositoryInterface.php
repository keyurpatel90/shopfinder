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

namespace Keyurpatel90\Shopfinder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ShopfinderRepositoryInterface
{


    /**
     * Save Shopfinder
     * @param \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
    );

    /**
     * Retrieve Shopfinder
     * @param string $shopfinderId
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($shopfinderId);

    /**
     * Retrieve Shopfinder matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete Shopfinder
     * @param \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface $shopfinder
    );

    /**
     * Delete Shopfinder by ID
     * @param string $shopfinderId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($shopfinderId);
}
