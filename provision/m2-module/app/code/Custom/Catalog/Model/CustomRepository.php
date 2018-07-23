<?php
namespace Custom\Catalog\Model;
use Custom\Catalog\Api\CustomRepositoryInterface;
use Custom\Catalog\Api\Data\CustomDataInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\InputException;
use Magento\Framework\Exception\CouldNotSaveException;
class CustomRepository implements CustomRepositoryInterface
{

	public function __construct(
			\Custom\Catalog\Api\Data\CustomDataInterfaceFactory $customFactory,
			\Magento\Framework\ObjectManagerInterface $objectManager,
			\Magento\Framework\Api\ExtensibleDataObjectConverter $extensibleDataObjectConverter
	) {
		$this->customFactory=$customFactory;
		$this->_objectManager = $objectManager;
		$this->extensibleDataObjectConverter = $extensibleDataObjectConverter;
	}

	public function update(CustomDataInterface $data){
		$id=$data->getId();
		if(!$this->_objectManager->create('Custom\Catalog\Model\Products')->load($id)->getData()){
			throw new InputException(__("Invalid ID provided",$id));
		}else{

			$customModel=$this->_objectManager->create('Custom\Catalog\Model\Products')->load($id);
			$entityId=$customModel->getEntityId();

			//Check if product id exists
			if(!$entityId){
				throw new InputException(__("Product ID do not exist",$data->getId()));
			}
			$customDataArray = $this->extensibleDataObjectConverter->toNestedArray($data, [], 'Custom\Catalog\Api\Data\CustomDataInterface');
			//Updating custom data in the table
			$customDataArray['entity_id']=$id;
			//$customModel=$this->_objectManager->create('Custom\Catalog\Model\Products')->load($id);
			//return $customDataArray;
			$customModel->setData($customDataArray);
			$customModel->save();
			$customId=$customModel->getId();
		}
		$data->setId($customId);
		return $data;
	}

	public function get($id){
		if(!$this->_objectManager->create('Custom\Catalog\Model\Products')->load($id)->getData()){
			throw new InputException(__("Invalid ID provided",$id));
		}
		else{
			$modelData=$this->_objectManager->create('Custom\Catalog\Model\Products')->load($id)->getData();
		}
		$result=array();
		$result[]=$modelData;
		return $result;
	}

}