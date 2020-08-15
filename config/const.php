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
    Configure::write('object_usage',
        array(
            '1'=>'発話',
            '2'=>'紹介',
            '3'=> 'アクション',
        )
    ),
    Configure::write('object_usage_key',
        array(
            'speak'=>'1',
            'introduction'=>'2',
            'action'=>'3',
        )
    ),
    Configure::write('object_layout',
        array(
            'speak' =>
                array(
                    'face' => 'top:12%;',
                    'body' => 'bottom:0%; left:0%;',
//                    'speech' => 'top:10%; right:5%;',
                ),
            'introduction' =>
                array(
                    'face' => 'top:12%;',
                    'body' => 'bottom:0%; left:0%;',
//                    'speech' => 'bottom:10%; right:5%;',
                ),
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
    define('OBJECT_TEMPLATE_BADGE', 6),
    define('VUE_PHRASE_SCRIPT_FIRST', '
        var phrases = new Vue({
      el: "#phrases",
      delimiters: ["%%", "%%"],
      data: {
          num: 1,
          allHeight: 0,
          scroll: 0,
          displayHeight: 0,
          buttonShow: true,
          loading:true,
          phraseNum:0,
      },

      mounted() {
          this.phraseNum = document.getElementById("phrase_num").value;
          scrollTo(0, 0);
          this.allHeight= this.$refs.speak_1.clientHeight;
          this.displayHeight = window.innerHeight - this.$refs.next.clientHeight;
          window.addEventListener("scroll", this.handleScroll);
      },
      destroyed: function () {
        window.removeEventListener("scroll", this.handleScroll);
      },
      methods: {
        next: function (e) {
            if (this.num < this.phraseNum) {
                this.num++;
                var _this = this;
                setTimeout(function () {_this.addHeight()}, 10);
            '),

    define('VUE_PHRASE_SCRIPT_LAST', '
            }
        },
        addHeight: function (e) {
            var speak = "speak_" + this.num;
            this.allHeight += this.$refs[speak].clientHeight;
            if (this.allHeight > this.displayHeight) {
                var scroll = this.allHeight - this.displayHeight;
                scrollTo(0, scroll);
            }
        },
        handleScroll: function(e) {
            var scroll = this.allHeight - this.displayHeight;
            if(window.scrollY +5 < scroll) {
                this.buttonShow = false;
            } else {
                this.buttonShow = true;
            }
        },

      },
    })
'),

);
