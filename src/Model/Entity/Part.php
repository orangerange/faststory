<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Chapter Entity
 *
 * @property int $id
 * @property string $title
 * @property int $content_id
 *
 * @property \App\Model\Entity\Content $content
 * @property \App\Model\Entity\Phrase[] $phrases
 */
class Part extends Entity
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
		'object_type' => true,
		'template_id' => true,
		'html' => true,
		'css' => true,
        'picture_content' => true,
        'mime' => true,
		'parts_category_no' => true,
		'parts_no' => true,
		'created' => true,
		'modified' => true,
	];
}
