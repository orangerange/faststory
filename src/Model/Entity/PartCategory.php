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
class PartCategory extends Entity
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
        'name' => true,
        'class_name' => true,
        'parts_category_no' => true,
        'z_index' => true,
        'sort_no' => true,
    ];
}
