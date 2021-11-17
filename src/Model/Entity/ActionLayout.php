<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Action Entity
 *
 * @property int $id
 * @property int $character_id
 * @property int $object_id
 * @property int $action_id
 * @property int $is_character
 * @property int $magnification
 * @property int $left_perc
 * @property int $top_perc
 * @property int $right_perc
 * @property int $bottom_perc
 * @property int $rotate
 */
class ActionLayout extends Entity
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
        'character_id' => true,
        'object_id' => true,
        'action_id' => true,
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
        'object_products' => true,
    ];
}
