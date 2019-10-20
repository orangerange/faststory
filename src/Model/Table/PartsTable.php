<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
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
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('parts');
        $this->setDisplayField('html');
        $this->setDisplayField('css');
        $this->addBehavior('Timestamp');
    }

	public function findById($id) {
		return $this->find()->where(['Parts.id' => $id])->first();
	}

	public function findNextPartsNoByPartsCategoryNo($partsCategoryNo) {
		$result =  $this->find()->where(['Parts.parts_category_no' => $partsCategoryNo])->order(['Parts.parts_no'=>'DESC'])->first();
		if ($result) {
			return $result['parts_no'] + 1;
		} else {
			return 1;
		}
	}

	public function moldSetData($data) {
		if (isset($data->parts_category_no)) {
			$partsNo = $this->findNextPartsNoByPartsCategoryNo($data->parts_category_no);
			$class = Configure::read('parts_class')[$data->parts_category_no];
			$replacement = $class . '_' . $partsNo;
			$data->html = preg_replace('/' . $class . '_\d/', $replacement, $data->html);
			$data->css = preg_replace('/' . $class . '_\d/', $replacement, $data->css);
		}

		return $data;
	}
	public function moldGetData($data) {
		$data['html'] = str_replace('　', '', $data['html']);
		$data['css'] = str_replace('　', '', $data['css']);
		if (isset($data['parts_category_no'])) {
			$data['parts_no'] = $this->findNextPartsNoByPartsCategoryNo($data['parts_category_no']);
		}
		return $data;
	}
}