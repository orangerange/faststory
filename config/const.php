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
            '4'=> '紙芝居',
        )
    ),
    Configure::write('object_usage_key',
        array(
            'speak'=>'1',
            'introduction'=>'2',
            'action'=>'3',
            'story_show'=>'4',
        )
    ),
    Configure::write('object_layout',
        array(
            'speak' =>
                array(
                    'character_speak' => 'left:10%; width:100%; height:100%; position:absolute; overflow:hidden',
                    'face' => 'top:8%;',
                    'body' => 'bottom:0%; left:0%;',
                ),
            'introduction' =>
                array(
                    'character_speak' => 'left:10%; width:100%; height:100%; position:absolute;',
                    'face' => 'top:12%;',
                    'body' => 'bottom:0%; left:0%;',
                ),
            'action' =>
                array(
                    'character_speak' => 'left:30%; width:100%; height:100%; position:absolute;',
                    'face' => 'top:12%;',
                    'body' => 'bottom:0%; left:0%;',
                    'right_arm' => 'top:40%; right:85%; transform:rotate(35deg);',
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
	define('PHRASE_MUX_NUM', 100),
	define('NotFoundMessage', '不正な遷移です'),
    define('FLG_OFF', 0),
    define('FLG_ON', 1),
    define('OBJECT_TEMPLATE_BODY', 2),
    define('OBJECT_TEMPLATE_FACE', 3),
    define('OBJECT_TEMPLATE_SPEECH', 4),
    define('OBJECT_TEMPLATE_BADGE', 6),
    define('OBJECT_TEMPLATE_RIGHT_ARM', 12),
    define('OBJECT_TEMPLATE_CHARACTER_SPEECH', 15),
    Configure::write('object_character',
        array(
            OBJECT_TEMPLATE_BODY=>'body',
            OBJECT_TEMPLATE_FACE=>'face',
            OBJECT_TEMPLATE_RIGHT_ARM=>'right_arm',
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
          currentMovie:false,
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

    define('VUE_MOVIE_SCRIPT_FIRST', '
      var movies = new Vue({
      el: "#movies",
      delimiters: ["%%", "%%"],
      data: {
          num: 0,
          phraseNum:0,
          isEnd:false,
      },
      mounted() {
          this.phraseNum = document.getElementById("phrase_num").value;
          this.showMovie();
      },
      destroyed: function () {
      },
      methods: {
        showMovie: function (e) {
            if (this.num < this.phraseNum) {
                var currentMovieCheck = document.getElementById("js_movie_" + this.num);
                if (currentMovieCheck) {
                    this.currentMovie = currentMovieCheck;
                }
                this.num ++;
                var nextMovie = document.getElementById("js_movie_" + this.num);
                if (nextMovie) {
                    if (this.currentMovie) {
                        this.currentMovie.style.display = "none";
                    }
                    nextMovie.style.visibility = "visible";
                    var movieTime = nextMovie.dataset.time * 1000;
                    setTimeout(this.showMovie, movieTime);
                } else {
                    var nextSentence = document.getElementById("js_sentence_" + this.num);
                    if (nextSentence) {
                        var sentence = nextSentence.dataset.sentence;
                        var other_sentence_num = nextSentence.dataset.other_sentence_num;
                        var movieTime = nextSentence.dataset.time * 1000;
                        // 一旦全ての字幕を非表示
                        var speech_div_all = this.currentMovie.getElementsByClassName("speech");
                        for(var i = 0; i < speech_div_all.length; i++){
                            speech_div_all[i].style.display = "none";
                        }

                        if (other_sentence_num) {
                            var story_show = this.currentMovie.getElementsByClassName("story_show_other" + other_sentence_num);
                        } else {
                            var story_show = this.currentMovie.getElementsByClassName("story_show");
                        }

                        // 該当字幕を表示
                        if (story_show) {
                            var story_show_div = story_show[0];
                            var speech_div = story_show_div.parentNode;
                            speech_div.style.display = "block";
                            // ダジャレ(bタグあり)の場合、光らせる
                            var speech_sentence = speech_div.firstChild;
                            if (sentence.indexOf("<b>") != -1) {
                                story_show_div.style.background = "rgba(255,192,203,0.8)";
                            } else {
                                story_show_div.style.background = "rgba(248,248,255,0.8)";
                            }
                        }
                        var sentence_div = story_show_div.firstChild;
                        if (sentence_div) {
                            sentence_div.innerHTML = sentence;
                        }
                        setTimeout(this.showMovie, movieTime);
                    }
                }
            '),

    define('VUE_MOVIE_SCRIPT_LAST', '
            } else {
            // 全件表示後
              this.isEnd = true;
                }
            },
        },
    })
'),
);
