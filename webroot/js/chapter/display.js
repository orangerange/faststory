var phrases = new Vue({
  el: '#phrases',
  
  data: {
      num: 1,
      allHeight: 0,
      scroll: 0,
      displayHeight: 0,
      buttonShow: true,
      loading:true,
      chapterId:null,
      phraseNum:0,
  },

  mounted() {
      this.chapterId = document.getElementById('chapter_id').value;
      this.phraseNum = document.getElementById('phrase_num').value;
      scrollTo(0, 0);
      this.allHeight= this.$refs.speak_1.clientHeight;
      this.displayHeight = window.innerHeight - this.$refs.next.clientHeight;
      window.addEventListener('scroll', this.handleScroll);
  },
  destroyed: function () {
    window.removeEventListener('scroll', this.handleScroll);
  },
  methods: {
    next: function (e) {
        if (this.num < this.phraseNum) {
            this.num++;
            var speak = 'speak_' + this.num;
            var _this = this;
            setTimeout(function () {_this.addHeight()}, 10);
        }
    },
        addHeight: function (e) {
            var speak = 'speak_' + this.num;
            this.allHeight += this.$refs[speak].clientHeight;
            if (this.allHeight > this.displayHeight) {
                var scroll = this.allHeight - this.displayHeight;
                scrollTo(0, scroll);
            }
        },
//    getOnePhrase: function (e) {
//        axios.post('/ajax/phrases/getOne', {
//            no: this.no,
//            chapter_id: this.chapterId,
//        })
//                .then(response => {
//                    console.log(response.data);
//                    this.phrases.push(response.data);
//                    this.no++;
//                });
//
//    },
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