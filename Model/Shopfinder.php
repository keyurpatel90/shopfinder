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

use Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface;

class Shopfinder extends \Magento\Framework\Model\AbstractModel implements ShopfinderInterface
{

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder');
    }

    /**
     * Get shopfinder_id
     * @return string
     */
    public function getShopfinderId()
    {
        return $this->getData(self::SHOPFINDER_ID);
    }

    /**
     * Set shopfinder_id
     * @param string $shopfinderId
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setShopfinderId($shopfinderId)
    {
        return $this->setData(self::SHOPFINDER_ID, $shopfinderId);
    }

    /**
     * Get shopname
     * @return string
     */
    public function getShopname()
    {
        return $this->getData(self::SHOPNAME);
    }

    /**
     * Set shopname
     * @param string $shopname
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setShopname($shopname)
    {
        return $this->setData(self::SHOPNAME, $shopname);
    }

    /**
     * Get identifier
     * @return string
     */
    public function getIdentifier()
    {
        return $this->getData(self::IDENTIFIER);
    }

    /**
     * Set identifier
     * @param string $identifier
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setIdentifier($identifier)
    {
        return $this->setData(self::IDENTIFIER, $identifier);
    }

    /**
     * Get country
     * @return string
     */
    public function getCountry()
    {
        return $this->getData(self::COUNTRY);
    }

    /**
     * Set country
     * @param string $country
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * Get image
     * @return string
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get storeview
     * @return string
     */
    public function getStoreview()
    {
        return $this->getData(self::STOREVIEW);
    }

    /**
     * Set storeview
     * @param string $storeview
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setStoreview($storeview)
    {
        return $this->setData(self::STOREVIEW, $storeview);
    }

    /**
     * Get status
     * @return string
     */
    public function getStatus()
    {
        return $this->getData(self::STATUS);
    }

    /**
     * Set status
     * @param string $status
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setStatus($status)
    {
        return $this->setData(self::STATUS, $status);
    }

    /**
     * Get created
     * @return string
     */
    public function getCreated()
    {
        return $this->getData(self::CREATED);
    }

    /**
     * Set created
     * @param string $created
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setCreated($created)
    {
        return $this->setData(self::CREATED, $created);
    }

    /**
     * Get modified
     * @return string
     */
    public function getModified()
    {
        return $this->getData(self::MODIFIED);
    }

    /**
     * Set modified
     * @param string $modified
     * @return \Keyurpatel90\Shopfinder\Api\Data\ShopfinderInterface
     */
    public function setModified($modified)
    {
        return $this->setData(self::MODIFIED, $modified);
    }
}
