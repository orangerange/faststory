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
class ObjectTemplatesTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->setTable('object_templates');

        $this->hasMany('ActionLayouts', [
            'foreignKey' => 'object_template_id'
        ]);
	}

    public function findById($id)
    {
        return $this->find()->where(['ObjectTemplates.id' => $id])->contain(['ActionLayouts']);
    }

    public function unsetEmptyDatum($data) {
        $actionLayouts = [];
        $actionLayoutsNum = 0;
        if (isset($data['action_layouts'] )) {
            foreach ($data['action_layouts'] as $_key => $_value) {
                if (isset($_value['action_id']) && $_value['action_id'] != '') {
                    $actionLayouts[$actionLayoutsNum] = $_value;
                    $actionLayoutsNum++;
                }
            }
        }
        $data['action_layouts'] = $actionLayouts;

        return $data;
    }
}
