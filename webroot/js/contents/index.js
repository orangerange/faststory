var contents = new Vue({
    delimiters: ['%%', '%%'],
  el: "#contents",

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
  },
  destroyed: function () {
  },
  methods: {
      showPopUp: function (e) {
          var id = e.currentTarget.getAttribute('data-id');
          axios.get(`/chapters/axios-list/?content_id=` + id)
              .then(function (response) {
                  var html = response.data.html;
                  var popupOutside = document.getElementById("popup_outside");
                  popupOutside.innerHTML = html;
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
                          popupOutside.innerHTML = '';
                      })
                  }
              })
              .catch(function (response) {
                  console.log(response);
              });
      },
  },
})
