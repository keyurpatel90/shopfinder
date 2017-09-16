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

namespace Keyurpatel90\Shopfinder\Controller\Adminhtml\Shopfinder;

use Magento\Framework\Exception\LocalizedException;


class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;
    protected $uploader;
    protected $resourceShopfinder;

        
    
    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Keyurpatel90\Shopfinder\Model\Uploader $uploader,
        \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder $resourceShopfinder
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->uploader = $uploader;
        $this->resourceShopfinder = $resourceShopfinder;
        
        parent::__construct($context);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
      
        if ($data) {
            $id = $this->getRequest()->getParam('shopfinder_id');

            $model = $this->_objectManager->create('Keyurpatel90\Shopfinder\Model\Shopfinder')->load($id);
            if (!$model->getShopfinderId() && $id) {
                $this->messageManager->addErrorMessage(__('This Shopfinder no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
                      
             $image = $this->uploader->uploadFileAndGetName('image', $data);
             $data['image'] = $image;
             $model->setData($data);
        
            try {
                $model->save();
                if(!empty($model->getShopfinderId())){
                    // code to save stores 
                    $oldStores = $this->resourceShopfinder->lookupStoreIds((int)$model->getShopfinderId());    
                    $newStores = (array) $data["storeview"];
                    $this->resourceShopfinder->saveStores($oldStores,$newStores,$model->getShopfinderId());

                }
                $this->messageManager->addSuccessMessage(__('You saved the Shopfinder.'));
                $this->dataPersistor->clear('keyurpatel90_shopfinder_shopfinder');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Shopfinder.'));
            }
        
            $this->dataPersistor->set('keyurpatel90_shopfinder_shopfinder', $data);
            return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $this->getRequest()->getParam('shopfinder_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
    
   
}
