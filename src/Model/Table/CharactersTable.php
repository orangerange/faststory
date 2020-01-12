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
class CharactersTable extends Table
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

        $this->setTable('characters');
        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');
		// Upload Plugin
        $this->addBehavior('Josegonzalez/Upload.Upload', [
            'picture' => [
				'nameCallback' => function ($data, $settings) {
                    return uniqid().'-'.strtolower($data['name']);
                }
			]
        ]);

		$this->hasMany('CharacterParts', [
			'foreignKey' => 'character_id'
		]);
	}

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
        {
        $validator
				->notEmpty('name')
				->notEmpty('name_color')
				->allowEmpty('picture')
		;
		return $validator;
    }

	public function findById($id) {
		return $this->find()->where(['Characters.id' => $id])->contain(['CharacterParts'])->first();
    }

	public function moldGetData($data) {
		$moldData = array();
		foreach ($data['character_parts'] as $_key => $_value) {
			$moldData['character_parts'][$_value['parts_category_no']] = $_value;
		}
		$data['character_parts'] = $moldData['character_parts'];

		return $data;
	}

	public function moldSetData($data) {
		$data['html'] = str_replace('　', '', $data['html']);
		$data['css'] = str_replace('　', '', $data['css']);
		return $data;
	}
}