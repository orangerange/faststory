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
class ObjectsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('objects');
        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');

		$this->belongsTo('ObjectTemplates', [
			'foreignKey' => 'template_id'
		]);
		$this->hasMany('ObjectParts', [
			'foreignKey' => 'object_id'
		]);
	}

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator) {
		$validator
			->notEmpty('name')
		;
		return $validator;
	}

	public function findById($id) {
		return $this->find()->where(['Objects.id' => $id])->contain(['ObjectParts', 'ObjectTemplates'])->first();
	}

	public function moldGetData($data) {
		$moldData = array();
		if (isset($data['object_parts'])) {
			foreach ($data['object_parts'] as $_key => $_value) {
				$moldData['object_parts'][$_value['parts_category_no']] = $_value;
			}
			$data['object_parts'] = $moldData['object_parts'];
		}
		return $data;
	}
}