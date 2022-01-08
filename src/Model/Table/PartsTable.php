<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Core\Configure;

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
class PartsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config) {
		parent::initialize($config);

		$this->setTable('parts');
		$this->belongsTo('PartCategories', [
			'foreignKey' => 'parts_category_no'
		]);
		$this->setDisplayField('html');
		$this->setDisplayField('css');
		$this->addBehavior('Timestamp');
	}

    public function findPictureContentById($id) {
        $result = $this->find()->where(['id' => $id])->first();

        return $result->get('picture_content');
    }

    public function beforeSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        // 画像登録
        if (!empty($options['picture']['tmp_name'])) {
            $file = new File($options['picture']['tmp_name']);
            $pictureContent = $file->read();
            $mime = $file->mime();
            $entity->set('picture_content', $pictureContent);
            $entity->set('mime', $mime);
        } elseif(!empty($options['picture_content_id']) && empty($options['picture_del'])) {
            $options['picture_content'] = $this->findPictureContentById($options['picture_content_id']);
        }
    }

    public function afterSave(Event $event, EntityInterface $entity, ArrayObject $options)
    {
        $id = $entity->get('id');
        $pictureContent = $entity->get('picture_content');
        if (isset($pictureContent)) {
            $css = $entity->get('css');
            $cssPicture = 'background-image: url(/parts/picture/' . $id . '); background-size: cover; ';
            $pattern= "/^.*?{/";
            // 背景画像に合わせたcssの上書き
            if(strpos($css, $cssPicture) === false) {
            if (preg_match_all($pattern, $css, $matches)) {
                $cssHead = $matches[0][0];
                    $css = str_replace($cssHead, $cssHead . $cssPicture, $css);
                    $entity->set('css', $css);

                    $this->save($entity);
                }
            }
        }
    }

	public function findById($id) {
		return $this->find()->where(['Parts.id' => $id])->first();
	}

	public function findForCopy($partsCategoryNo, $partsNo) {
		return $this->find()->where(['Parts.parts_category_no' => $partsCategoryNo, 'Parts.parts_no' => $partsNo])->contain('PartCategories')->first();
	}

	public function findNextPartsNoByPartsCategoryNo($partsCategoryNo) {
		$result =  $this->find()->where(['Parts.parts_category_no' => $partsCategoryNo])->order(['Parts.parts_no'=>'DESC'])->first();
		if ($result) {
			return $result['parts_no'] + 1;
		} else {
			return 1;
		}
	}

	public function findByTemplateId($templateId = null) {
		$conditions = array();
		if (!empty($templateId)) {
			$conditions = array(
				'Parts.template_id' => $templateId
			);
		}
		$result = $this->find()
				->contain('PartCategories')
				->where($conditions)
				->order('PartCategories.sort_no')
				->order('Parts.id')
				->all();
		return $result;
	}

	public function moldGetData($data) {
		if (isset($data->parts_category_no)) {
			$partsNo = $this->findNextPartsNoByPartsCategoryNo($data->parts_category_no);
			$class = $data->class_name;
			$replacement = $class . '_' . $partsNo;
			$data->html = preg_replace('/' . $class . '_\d/', $replacement, $data->html);
			$data->css = preg_replace('/' . $class . '_\d/', $replacement, $data->css);
		}

		return $data;
	}
	public function moldSetData($data, $inputFlg=false) {
		$data['html'] = str_replace('　', '', $data['html']);
		$data['css'] = str_replace('　', '', $data['css']);
		$data['keyframe'] = str_replace('　', '', $data['keyframe']);
		if (isset($data['parts_category_no']) && $inputFlg) {
			$data['parts_no'] = $this->findNextPartsNoByPartsCategoryNo($data['parts_category_no']);
		}
		return $data;
	}

	public function addPreClassToCss($css, $preClass) {
		$css = $preClass . ' ' . $css;
		$css = str_replace('}', '} ' . $preClass, $css);
		$css = rtrim($css, $preClass);
	}
}
