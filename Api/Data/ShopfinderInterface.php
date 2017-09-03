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

namespace Keyurpatel90\Shopfinder\Api\Data;

interface ShopfinderInterface
{

    const SHOPFINDER_ID = 'shopfinder_id';
    const COUNTRY = 'country';
    const MODIFIED = 'modified'; 
    const IDENTIFIER = 'identifier';
    const STOREVIEW = 'storeview';
    const CREATED = 'created';
    const STATUS = 'status';
    const IMAGE = 'image';
    const SHOPNAME = 'shopname';


    /**
     * Get shopfinder_id
     * @return string|null
     */
    
    public function getShopfinderId();

    /**
     * Set shopfinder_id
     * @param string $shopfinder_id
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setShopfinderId($shopfinderId);

    /**
     * Get shopname
     * @return string|null
     */
    
    public function getShopname();

    /**
     * Set shopname
     * @param string $shopname
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setShopname($shopname);

    /**
     * Get identifier
     * @return string|null
     */
    
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setCountry($country);

    /**
     * Get image
     * @return string|null
     */
    
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setImage($image);

    /**
     * Get storeview
     * @return string|null
     */
    
    public function getStoreview();

    /**
     * Set storeview
     * @param string $storeview
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setStoreview($storeview);

    /**
     * Get status
     * @return string|null
     */
    
    public function getStatus();

    /**
     * Set status
     * @param string $status
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setStatus($status);

    /**
     * Get created
     * @return string|null
     */
    
    public function getCreated();

    /**
     * Set created
     * @param string $created
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setCreated($created);

    /**
     * Get modified
     * @return string|null
     */
    
    public function getModified();

    /**
     * Set modified
     * @param string $modified
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    
    public function setModified($modified);
}
