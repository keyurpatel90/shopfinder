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

class Delete extends \Keyurpatel90\Shopfinder\Controller\Adminhtml\Shopfinder
{
    
    protected  $uploader;
    
    protected  $resourceShopfinder;


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Keyurpatel90\Shopfinder\Model\Uploader $uploader,
        \Keyurpatel90\Shopfinder\Model\ResourceModel\Shopfinder $resourceShopfinder
    ) {
        $this->uploader = $uploader;
        $this->resourceShopfinder = $resourceShopfinder;
         parent::__construct($context,$coreRegistry);
    }


    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('shopfinder_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Keyurpatel90\Shopfinder\Model\Shopfinder');
                $model->load($id);
                $imageName = $model->getImage();
                $this->uploader->removeFile($imageName);
                $this->resourceShopfinder->deleteStores($id);
                $model->delete();
                //delete stores
                
                // display success message
                $this->messageManager->addSuccessMessage(__('You deleted the Shopfinder.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addErrorMessage($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['shopfinder_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addErrorMessage(__('We can\'t find a Shopfinder to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
