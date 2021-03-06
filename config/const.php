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
	define('INDEX_BODY_COLOR', 'lightblue'),
	define('PHRASE_MUX_NUM', 50),
	define('NotFoundMessage', '不正な遷移です'),
    define('FLG_OFF', 0),
    define('FLG_ON', 1),
    define('OBJECT_TEMPLATE_BODY', 2),
    define('OBJECT_TEMPLATE_FACE', 3),
    define('OBJECT_TEMPLATE_SPEECH', 4),
    define('OBJECT_TEMPLATE_BADGE', 6),
    Configure::write('object_character',
        array(
            OBJECT_TEMPLATE_BODY=>'body',
            OBJECT_TEMPLATE_FACE=>'face',
            OBJECT_TEMPLATE_SPEECH=>'speech',
        )
    ),
    Configure::write('admin_ip_addresses',
        array(
            '192.168.33.1',
        )
    ),
    define('VUE_PHRASE_SCRIPT_FIRST', '
      var phrases = new Vue({
      el: "#phrases",
      delimiters: ["%%", "%%"],
      data: {
          num: 1,
          allHeight: 0,
          shadowHeight: 0,
          scroll: 0,
          displayHeight: 0,
          headerHeight: 0,
          buttonHeight: 0,
          buttonShow: true,
          loading:true,
          phraseNum:0,
          backgrounds:{},
          opacityA:{},
          opacityB:{},
          background_id:"",
          isEnd:false,
      },
      mounted() {
          this.headerHeight = this.$refs.header.clientHeight;
          this.buttonHeight = this.$refs.next.clientHeight;
          // 背景オブジェクトの複製
          copyObjects();
          this.phraseNum = document.getElementById("phrase_num").value;
          scrollTo(0, 0);
          if (this.$refs.speak_1.dataset.background_id) {
            this.backgrounds[0] = this.$refs.speak_1.dataset.background_id;
            this.background_id = this.$refs.speak_1.dataset.background_id;
          }
          this.allHeight= this.$refs.speak_1.clientHeight;
          this.displayHeight = window.innerHeight - this.buttonHeight;
          window.addEventListener("scroll", this.handleScroll);
          // ヘッダ押下時の設定
          document.getElementById("header").onclick = function() {
            var popup = document.getElementById("js-popup");
        　　popup.classList.add("is-show");
          var blackBg = document.getElementById("js-black-bg");
        　var closeBtn = document.getElementById("js-close-btn");
        　closePopUp(blackBg);
        　closePopUp(closeBtn);
            　function closePopUp(elem) {
                if (!elem)
                    return;
                elem.addEventListener("click", function () {
                    popup.classList.remove("is-show");
                })
            }
         }
      },
      destroyed: function () {
        window.removeEventListener("scroll", this.handleScroll);
      },
      methods: {
      header: function (e) {
           this.isEnd = false;
            this.showPopUp();
      },
      showPopUp: function (e) {
            var popup = document.getElementById("js-popup");
        　　popup.classList.add("is-show");
          var blackBg = document.getElementById("js-black-bg");
        　var closeBtn = document.getElementById("js-close-btn");
        　closePopUp(blackBg);
        　closePopUp(closeBtn);
            　function closePopUp(elem) {
                if (!elem)
                    return;
                elem.addEventListener("click", function () {
                    popup.classList.remove("is-show");
                })
            }
      },
        next: function (e) {
            if (this.num < this.phraseNum) {
                this.num++;
                var _this = this;
                setTimeout(function () {_this.addHeight()}, 10);
            '),

    define('VUE_PHRASE_SCRIPT_LAST', '
            } else {
            // 全フレーズ表示後のnextボタン押下
            this.isEnd = true;
              this.isEnd = true;
              this.showPopUp();
            }
        },
        addHeight: function (e) {
            var speak = "speak_" + this.num;

            // 背景変更時のスクロール
            if (this.$refs[speak].dataset.background_id) {
                if (this.$refs[speak].dataset.background_id.match(/^[0-9]*$/)){
                    this.backgrounds[this.allHeight] = this.$refs[speak].dataset.background_id;
                    // 一番上までスクロール
                    this.shadowHeight = this.displayHeight - this.headerHeight - this.$refs[speak].clientHeight;
                    var scroll = this.allHeight;
                    setTimeout(function () {scrollTo(0, scroll)}, 10);

                    this.allHeight += this.$refs[speak].clientHeight;
                }
            } else {
                 // 調整用要素の高さを減らす
                if (this.shadowHeight > 0) {
                    this.shadowHeight -= this.$refs[speak].clientHeight;
                }
                if (this.shadowHeight < 0) {
                    this.shadowHeight = 0;
                }
                this.allHeight += this.$refs[speak].clientHeight;
                // 通常のスクロール
                var scroll = this.allHeight + this.headerHeight + this.shadowHeight - this.displayHeight;
                if (scroll > 0) {
//                    scrollTo(0, scroll);
                     setTimeout(function () {scrollTo(0, scroll)}, 10);
                 }
            }
        },
        handleScroll: function(e) {
            // ヘッダーと被ったフレーズの透明化
            var speaks = document.querySelectorAll(".speak");
            for(var spksIndex = 0; spksIndex < speaks.length; spksIndex++) {
                var speak = speaks[spksIndex];
                var top = speak.getBoundingClientRect().top
                if (top + speak.clientHeight * 3/4 < this.headerHeight) {
                    speak.style.opacity = 0;
                } else if (top + speak.clientHeight/3 < this.headerHeight) {
                    speak.style.opacity = 0.3;
                } else if (top < this.headerHeight) {
                    speak.style.opacity = 0.5;
                } else {
                    speak.style.opacity = 1;
                }
            }
            // 背景切り替え
            var tmp_background_id = "";
            for (let key in this.backgrounds) {
                if (window.scrollY >= key) {
                    tmp_background_id = this.backgrounds[key];
                }
            }
            if (this.background_id != tmp_background_id) {
                var body_color = document.getElementById("css_background_" + tmp_background_id).dataset.body_color;
                document.body.style.backgroundColor = body_color;
                this.background_id = tmp_background_id;
            }
            // ボタン表示非表示設定
            var scroll = this.allHeight  + this.shadowHeight - this.displayHeight;
            if(window.scrollY < scroll) {
                this.buttonShow = false;
            } else {
                this.buttonShow = true;
            }
        },
      },
    })
'),

);
