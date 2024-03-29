<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Character Entity
 *
 * @property int $id
 * @property string $name
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $updated
 * @property bool $deleted
 */
class ObjectProduct extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
		'id' => true,
		'template_id' => true,
		'content_id' => true,
		'character_id' => true,
		'default_speak_flg' => true,
		'name' => true,
		'html' => true,
		'css' => true,
		'keyframe' => true,
		'created' => true,
		'modified' => true,
		'deleted' => true,
		'object_parts' => true,
		'action_layouts' => true,
		'object_templates' => true,
		'picture_content' => true,
		'mime' => true,
	];

}
