var phrases = new Vue({
    delimiters: ['%%', '%%'],
  el: "#phrases",

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
      // 最初のフレーズの高さを取得
      this.allHeight= this.$refs.speak_1.clientHeight;
      // ウィンドウ全体の高さから、「next」ボタンの高さを引いた値
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
            // if (this.num == 5) {
            //     var elem = document.getElementsByClassName ("object_4_10");
            //     anime({
            //         targets: elem,
            //         translateX: 250
            //     })
            // }
            if (this.num == this.phraseNum) {
                this.buttonShow = false;
            }
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
        if (this.num < this.phraseNum) {
            var scroll = this.allHeight - this.displayHeight;
            if (this.background_id != tmp_background_id) {
                axios.get("/backgrounds/axios-change-background?id=" + tmp_background_id)
                    .then(function (response) {
                        // handle success
                        console.log(response);
                        var body = document.body;
                        body.style.backgroundColor = response.data.body_color;
                        document.getElementById("js_html_background").innerHTML = response.data.html;
                        document.getElementById("js_css_background").innerHTML = '<style type="text/css">' + response.data.css;
                    })
                    .catch(function (error) {
                        // handle error
                        console.log(error);
                    })
                    .finally(function () {
                        // always executed
                    });
                this.background_id = tmp_background_id;
            }
            var scroll = this.allHeight - this.displayHeight;
            if (window.scrollY + 5 < scroll) {
                this.buttonShow = false;
            } else {
                this.buttonShow = true;
            }
        }
    },

  },
})
