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
class RanksTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->setTable('ranks');
		$this->belongsTo('Organizations', [
			'foreignKey' => 'organization_id'
		]);
	}

    public function findNextSortNo($organizationId = null) {
        $conditions = array();
        if (isset($organizationId)) {
            $conditions = array(
                'organization_id' => $organizationId
            );
        }
        $result = $this->find()->where($conditions)->order(['sort_no' => 'DESC'])->first();
        if ($result) {
            return $result['sort_no'] + 1;
        } else {
            return 1;
        }
    }

    public function findByOrganizationId($organizationId = null) {
        $conditions = array();
        if (isset($organizationId)) {
            $conditions = array(
                'organization_id' => $organizationId,
            );
        }
        $result = $this->find()
            ->where($conditions)
            ->order('Ranks.sort_no')
            ->order('Ranks.id')
            ->all();
        return $result;
    }
}
