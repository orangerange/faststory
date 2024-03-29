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
class Rank extends Entity
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
        'badge_left_id' => true,
        'badge_right_id' => true,
        'name' => true,
        'sort_no' => true,
    ];
}
