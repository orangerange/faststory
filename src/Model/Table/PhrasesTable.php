<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Phrases Model
 *
 * @property \App\Model\Table\ContentsTable|\Cake\ORM\Association\BelongsTo $Contents
 * @property \App\Model\Table\ChaptersTable|\Cake\ORM\Association\BelongsTo $Chapters
 * @property \App\Model\Table\CharactersTable|\Cake\ORM\Association\BelongsTo $Characters
 *
 * @method \App\Model\Entity\Phrase get($primaryKey, $options = [])
 * @method \App\Model\Entity\Phrase newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Phrase[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Phrase|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Phrase|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Phrase patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Phrase[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Phrase findOrCreate($search, callable $callback = null, $options = [])
 */
class PhrasesTable extends Table
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

        $this->setTable('phrases');

        $this->belongsTo('Contents', [
            'foreignKey' => 'content_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Chapters', [
            'foreignKey' => 'chapter_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Characters', [
            'foreignKey' => 'character_id',
            'joinType' => 'LEFT'
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
            ->integer('id')
            ->requirePresence('id', 'create')
            ->notEmpty('id');

        $validator
            ->scalar('sentence')
            ->maxLength('sentence', 1000)
            ->requirePresence('sentence', 'create')
            ->notEmpty('sentence');

        $validator
            ->scalar('picture')
            ->requirePresence('picture', 'create')
            ->notEmpty('picture');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['content_id'], 'Contents'));
        $rules->add($rules->existsIn(['chapter_id'], 'Chapters'));
        $rules->add($rules->existsIn(['character_id'], 'Characters'));

        return $rules;
    }
}
