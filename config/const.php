<?php
use Cake\Core\Configure;
return array(
	Configure::write('prefix_type',
		array(
			'1' => '接頭辞',
			'2' => '接尾辞',
		)
	),
	Configure::write('prefix_type_key',
		array(
			'prefix' => '1',
			'suffix' => '2',
		)
	),
	Configure::write('name_color',
		array(
			'1' => '青',
			'2' => '赤',
			'3' => '灰色',
			'4' => '黒',
			'5' => '紫',
		)
	),
	Configure::write('name_color_disp',
		array(
			'1' => 'blue',
			'2' => 'red',
			'3' => 'gray',
			'4' => 'black',
			'5' => 'purple',
		)
	),
	Configure::write('parts',
		array(
			'0' => '帽子',
			'1' => '髪の毛',
			'2' => '顔',
			'3' => '眼鏡',
			'4' => '目',
			'5' => '眉毛',
			'6' => '鼻',
			'7' => '頬',
			'8' => '口',
		)
	),
	Configure::write('parts_class',
		array(
			'0' => 'hat',
			'1' => 'hair',
			'2' => 'head',
			'3' => 'glasses',
			'4' => 'eyes',
			'5' => 'eyebrows',
			'6' => 'nose',
			'7' => 'cheeks',
			'8' => 'mouths',
		)
	),
	Configure::write('object_type',
		array(
			'1'=>'キャラクター顔',
			'2'=>'キャラクター胴体',
		)
	),
	Configure::write('object_type_key',
		array(
			'face'=>'1',
			'body'=>'2',
		)
	),
	Configure::write('object_template',
		array(
			'3'=> array('name' => '顔', 'class_name'=>'face'),
		)
	),
	Configure::write('object_template_key',
		array(
			'face'=>'3',
		)
	),
	define('PHRASE_MUX_NUM', 50),
	define('NotFoundMessage', '不正な遷移です'),
    define('FLG_OFF', 0),
    define('FLG_ON', 1),
    define('OBJECT_TEMPLATE_BODY', 2),
    define('OBJECT_TEMPLATE_FACE', 3),
    define('OBJECT_TEMPLATE_SPEECH', 4),
);
