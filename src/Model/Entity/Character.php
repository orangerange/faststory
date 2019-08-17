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
class Character extends Entity
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
        'content_id' => true,
        'name' => true,
        'name_color' => true,
        'picture' => true,
        'dir' => true,
        'type' => true,
        'size' => true,
        'html' => true,
        'css' => true,
        'created' => true,
        'modified' => true,
        'deleted' => true,
        'character_parts' => true,
    ];
}
