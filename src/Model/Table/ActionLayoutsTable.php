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
class ActionLayoutsTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->setTable('action_layouts');
        $this->belongsTo('ObjectProducts', [
            'foreignKey' => 'object_id'
        ]);
	}

    public function deleteByObjectId($objectId) {
        if (!$this->deleteAll(['object_id'=>$objectId])) {
            return false;
        }
        return true;
    }

    public function findSpeak($characterId, $actionId) {
        $result = $this->find()
            ->where(
                [
                    'ActionLayouts.action_id' => $actionId,
                    'OR' => [
                        'ActionLayouts.character_id' => $characterId,
                        [
                            'ActionLayouts.character_id IS' => NULL,
                            'ActionLayouts.no_character' => FLG_ON,
                        ],
                    ],
                ]
            )
            ->contain(['ObjectProducts.ObjectTemplates'])
            ->order(['ObjectTemplates.id' => 'ASC'])
            ->all();

        return $result;
    }
}
