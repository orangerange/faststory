<?php
namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Filesystem\File;
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

		$this->belongsTo('Characters', [
			'foreignKey' => 'character_id'
		]);
        $this->belongsTo('Chapters', [
            'foreignKey' => 'chapter_id',
//            'joinType' => 'INNER'
        ]);
		$this->addBehavior('Josegonzalez/Upload.Upload', [
            'picture' => [
				'nameCallback' => function ($data, $settings) {
                    return uniqid().'-'.strtolower($data['name']);
                }
			]
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
			->allowEmpty('picture');
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
    public function buildRules(RulesChecker $rules)
    {
        return $rules;
    }

	public function isEmpty($data) {

		return  empty($data['sentence']) && empty($data['picture']['tmp_name']) && empty($data['html']) && empty($data['css']) && empty($data['js'])&& (empty($data['picture_content']) && empty($data['mime'] && !empty($data['picture_del'])));
	}

	public function unsetEmptyDatum($datum) {
		$result = array();
		$openFlg = array();
		$deleteIds = array();
		$i = 1;
		foreach($datum as $key => $data) {
			if (!$this->isEmpty($data)) {
				$data['no'] = $i;
				// 画像登録
				if (!empty($data['picture']['tmp_name'])) {
                    $file = new File($data['picture']['tmp_name']);
                    $pictureContent = $file->read();
                    $mime = $file->mime();
                    $data['picture_content'] = $pictureContent;
                    $data['mime'] = $mime;
                } elseif(!empty($data['picture_content_id']) && empty($data['picture_del'])) {
                    $data['picture_content'] = $this->findPictureContentByID($data['picture_content_id']);
                }
				$result[] = $data;
				$openFlg[] = true;
				$i ++;
			} else {
				if (!empty($data['id'])) {
					$deleteIds[] = $data['id'];
				}
			}
		}
		return array('datum'=>$result, 'open_flg'=>$openFlg, 'delete_ids'=>$deleteIds);
	}

	public function deleteByChapterId($cahpterId) {
		if (!$this->deleteAll(['chapter_id'=>$cahpterId])) {
			return false;
		}
		return true;
	}

	public function deleteByIds($ids) {
		if (!$this->deleteAll(['id in'=>$ids])) {
			return false;
		}
		return true;
	}
	public function getOneByChapterId($chapterId, $no) {
		return $this->find()->where(['chapter_id' => $chapterId, 'no' => $no])->first();
	}
	public function findFiratByChapterId($chapterId) {
		return $this->find()->where(['chapter_id' => $chapterId])->contain(['Characters'])->order(['no' => 'ASC'])->first();
	}

    public function findPictureCOntentById($id) {
        $result = $this->find()->where(['id' => $id])->first();

        return $result->get('picture_content');
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
//        var_dump($entity);
//        var_dump($options);
//        if (isset($options['picture']['tmp_name'])) {
//            $file = new File($options['picture']['tmp_name']);
//            $pictureContent = $file->read();
//            $pictureContent = 'aaa';
//            $entity->set('picture_content', $pictureContent);
//        } else {
//            $entity->set('picture_content', null);
//        }
    }
}
