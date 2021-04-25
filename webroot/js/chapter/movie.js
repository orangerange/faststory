var movies = new Vue({
    el: "#movies",
    delimiters: ["%%", "%%"],
    data: {
        num: 1,
        phraseNum: 0,
        isEnd: false,
    },
    mounted() {
        this.phraseNum = document.getElementById("phrase_num").value;
    },
    destroyed: function () {
        window.removeEventListener("scroll", this.handleScroll);
    },
    methods: {
        next: function (e) {
            if (this.num < this.phraseNum) {
                this.num++;
                var _this = this;
                var nextMovie = document.getElementById("js_movie_" + this.num);
                setTimeout(function () {
                    _this.addHeight()
                }, 10);
            } else {
                // 全フレーズ表示後のnextボタン押下
                this.isEnd = true;
                this.isEnd = true;
            }
        },
    },
})
