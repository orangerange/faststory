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
		)
	),
	Configure::write('parts_class',
		array(
			'0' => 'hat',
			'1' => 'hair',
			'2' => 'head',
			'3' => 'glasses',
			'4' => 'eyes',
		)
	),
	define('PHRASE_MUX_NUM', 50),
	define('NotFoundMessage', '不正な遷移です'),
);