<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Action Entity
 *
 * @property int $id
 * @property string $name
 * @property string $name_en
 * @property int $sort_no
 */
class Action extends Entity
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
        'name_en' => true,
        'name' => true,
        'is_character' => true,
        'no_character' => true,
        'magnification' => true,
        'left_perc' => true,
        'top_perc' => true,
        'right_perc' => true,
        'bottom_perc' => true,
        'rotate' => true,
        'z_index' => true,
        'is_reverse' => true,
        'sort_no' => true,
    ];
}
