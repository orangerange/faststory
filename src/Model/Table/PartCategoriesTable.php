<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Characters Model
 *
 * @method \App\Model\Entity\Content get($primaryKey, $options = [])
 * @method \App\Model\Entity\Content newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Content[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Content|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Content patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Content[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Content findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class PartCategoriesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->setTable('part_categories');
		$this->hasMany('Parts', [
			'foreignKey' => 'parts_category_no'
		]);
	}

	public function findNextSortNo($templateId = 0, $objectType = 0) {
		$conditions = array();
		if (isset($templateId)) {
			$conditions = array(
				'template_id' => $templateId
			);
		} else {
			$conditions = array(
				'object_type' => $objectType
			);
		}
		$result = $this->find()->where($conditions)->order(['sort_no' => 'DESC'])->first();
		if ($result) {
			return $result['sort_no'] + 1;
		} else {
			return 1;
		}
	}

	public function findByType($templateId = 0, $objectType = 0) {
		$conditions = array();
		if (!empty($templateId)) {
			$conditions = array(
				'template_id' => $templateId
			);
		} elseif(!empty($objectType)) {
			$conditions = array(
				'object_type' => $objectType
			);
		}
		$result = $this->find()
				->where($conditions)
				->order('PartCategories.sort_no')
				->order('PartCategories.id')
				->all();
		return $result;
	}

	public function findListByType($templateId = 0, $objectType = 0) {
		$conditions = array();
		if (!empty($templateId)) {
			$conditions = array(
				'template_id' => $templateId
			);
		} else {
			$conditions = array(
				'object_type' => $objectType
			);
		}
		$result = $this->find('list', ['keyField'=>'id', 'valueField'=>'name'])
				->where($conditions)
				->order('PartCategories.sort_no')
				->order('PartCategories.id')
				->all();
		return $result;
	}
}
