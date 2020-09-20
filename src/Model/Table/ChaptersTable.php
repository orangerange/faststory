<?php

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * Chapters Model
 *
 * @property \App\Model\Table\ContentsTable|\Cake\ORM\Association\BelongsTo $Contents
 * @property \App\Model\Table\PhrasesTable|\Cake\ORM\Association\HasMany $Phrases
 *
 * @method \App\Model\Entity\Chapter get($primaryKey, $options = [])
 * @method \App\Model\Entity\Chapter newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Chapter[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Chapter|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chapter|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Chapter patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Chapter[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Chapter findOrCreate($search, callable $callback = null, $options = [])
 */
class ChaptersTable extends Table {

	/**
	 * Initialize method
	 *
	 * @param array $config The configuration for the Table.
	 * @return void
	 */
	public function initialize(array $config) {
		parent::initialize($config);
		$this->setTable('chapters');
		$this->setDisplayField('title');

		$this->belongsTo('Contents', [
			'foreignKey' => 'content_id',
			'joinType' => 'INNER'
		]);
		$this->hasMany('Phrases', [
			'foreignKey' => 'chapter_id'
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
				->scalar('title')
				->maxLength('title', 256)
				->requirePresence('title', 'create')
				->notEmpty('title')
		;
		return $validator;
	}

	/**
	 * Returns a rules checker object that will be used for validating
	 * application integrity.
	 *
	 * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
	 * @return \Cake\ORM\RulesChecker
	 */
	public function buildRules(RulesChecker $rules) {
		$rules->add($rules->existsIn(['content_id'], 'Contents'));
		return $rules;
	}

	public function getLastChapterNo($content_id) {
		$result = $this->find()->where(['content_id' => $content_id])->order(['no' => 'DESC'])->first();
		return isset($result->no) ? $result->no + 1 : 1;
	}

	public function findById($id) {
		return $this->find()->where(['Chapters.id' => $id])->contain(['Phrases.Characters', 'Contents'])->first();
	}

	public function findByPrefixAndNo($prefix, $no) {
		return $this->find()->where(['Contents.prefix'=>$prefix, 'Chapters.no' => $no])->contain(['Phrases.Characters', 'Contents'])->first();
	}

    public function findPrefixAll(Query $query, array $options = [])
    {
        $query->select(['Contents.name', 'Chapters.no', 'Chapters.title']);
        $query->contain(['Contents']);
        $query->where([
            'Contents.prefix' => Hash::get($options, 'prefix', ''),
        ]);

        return $query;
    }

	public function deleteById($id) {
		if (!$this->deleteAll(['id'=>$id])) {
			return false;
		}
		return true;
	}

}
