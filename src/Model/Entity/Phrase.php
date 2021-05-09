<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Phrase Entity
 *
 * @property int $id
 * @property int $content_id
 * @property int $chapter_id
 * @property int $character_id
 * @property string $sentence
 * @property string $picture
 *
 * @property \App\Model\Entity\Content $content
 * @property \App\Model\Entity\Chapter $chapter
 * @property \App\Model\Entity\Character $character
 */
class Phrase extends Entity
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
        'background_id' => true,
        'chapter_id' => true,
        'character_id' => true,
        'object_usage' => true,
        'no' => true,
        'sentence' => true,
        'sentence_kana' => true,
        'sentence_translate' => true,
        'other_sentence_num' => true,
        'speaker_name' => true,
        'speaker_color' => true,
        'html' => true,
        'css' => true,
        'js' => true,
        'picture_content' => true,
        'mime' => true,
        'movie_time' => true,
        'color' => true,
    ];
}
