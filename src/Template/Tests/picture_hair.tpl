{literal}
<style type="text/css">
.hair {
  position: absolute;
  z-index: 1;
  background: black;
  width: 80%;
  height: 80%;
  margin: auto;
  -webkit-transform: rotate(45deg);
  -moz-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  -o-transform: rotate(45deg);
}
.hair:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  -webkit-transform: rotate(145deg);
  -moz-transform: rotate(145deg);
  -ms-transform: rotate(145deg);
  -o-transform: rotate(145deg);
}
.hair:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: black;
  -webkit-transform: rotate(-65deg);
  -moz-transform: rotate(-65deg);
  -ms-transform: rotate(-65deg);
  -o-transform: rotate(-65deg);
}

 </style>
{/literal}
   <div class="character_box">
    <div class="hair"></div>
</div>