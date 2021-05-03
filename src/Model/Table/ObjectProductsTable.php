<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Filesystem\File;
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
class ObjectProductsTable extends Table
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
//        $this->setDisplayField('name');
        $this->addBehavior('Timestamp');

        $this->belongsTo('ObjectTemplates', [
            'foreignKey' => 'template_id'
        ]);
        $this->hasMany('ObjectParts', [
            'foreignKey' => 'object_id'
        ]);
        $this->hasMany('ActionLayouts', [
            'foreignKey' => 'object_id'
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
            ->notEmpty('name');
        return $validator;
    }

    public function findById($id)
    {
        return $this->find()->where(['ObjectProducts.id' => $id])->contain(['ObjectParts', 'ObjectTemplates', 'ActionLayouts'])->first();
    }

    public function findNameById($id)
    {
        return $this->find()->where(['ObjectProducts.id' => $id])->first()->name;
    }

    public function findRankBadges($character)
    {
        $badgeLeft = false;
        if (isset($character->rank->badge_left_id)) {
            $badgeLeft = $this->find()->where(
                [
                    'ObjectProducts.id' => $character->rank->badge_left_id,
                ]
            )
                ->contain(['ObjectTemplates'])
                ->first();
        }
        $badgeRight = false;
        if (isset($character->rank->badge_right_id)) {
            $badgeRight = $this->find()->where(
                [
                    'ObjectProducts.id' => $character->rank->badge_right_id,
                ]
            )
                ->contain(['ObjectTemplates'])
                ->first();
        }
        $result = array('badge_left' => $badgeLeft, 'badge_right' => $badgeRight);

        return $result;
    }

    public function moldGetData($data)
    {
        $moldData = array();
        $data['character_id'] = array_filter(explode(',', $data['character_id']));
        $data['object_usage'] = array_filter(explode(',', $data['object_usage']));
        if (isset($data['object_parts'])) {
            foreach ($data['object_parts'] as $_key => $_value) {
                $moldData['object_parts'][$_value['parts_category_no']] = $_value;
            }
            if (isset($moldData['object_parts'])) {
                $data['object_parts'] = $moldData['object_parts'];
            }
        }

        return $data;
    }

    public function findPictureCOntentById($id) {
        $result = $this->find()->where(['id' => $id])->first();

        return $result->get('picture_content');
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        if (isset($options['character_id']) && is_array($options['character_id']) && count($options['character_id'] > 0)) {
            $entity->set('character_id', ',' . implode(',', $options['character_id']) . ',');
        } else {
            $entity->set('character_id', null);
        }
        if (isset($options['object_usage']) && is_array($options['object_usage']) && count($options['object_usage'] > 0)) {
            $entity->set('object_usage', ',' . implode(',', $options['object_usage']) . ',');
        } else {
            $entity->set('object_usage', null);
        }

        // 画像登録
        if (!empty($options['picture']['tmp_name'])) {
            $file = new File($options['picture']['tmp_name']);
            $pictureContent = $file->read();
            $mime = $file->mime();
            $entity->set('picture_content', $pictureContent);
            $entity->set('mime', $mime);
        } elseif(!empty($options['picture_content_id']) && empty($options['picture_del'])) {
            $options['picture_content'] = $this->findPictureContentByID($options['picture_content_id']);
        }
    }

    public function unsetEmptyDatum($data) {
        foreach ($data['object_parts'] as $_key => $_value) {
            if (!isset($_value['parts_no']) || $_value['parts_no'] == '') {
                unset($data['object_parts'][$_key]);
            }
        }
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
