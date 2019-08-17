{literal}
    <style type="text/css">
    .head {
      z-index: 3;
      position: absolute;
      box-shadow: 0 0 0.8rem #000;
      background-color: #decdbd;
      height: 90%;
      width: 80%;
      border-radius: 40%;
      align-items: center;
    }
    .head:before, .head:after {
      content: "";
      z-index: 0;
      position: absolute;
      bottom: 40%;
      background-color: #decdbd;
      height: 30%;
      width:  30%;
      border-radius: 50%;
    }
    
    .head:before {
      right: 80%;
      border-left: solid 0.2rem #666;
    }
    .head:after {
      left: 80%;
      border-right: solid 0.2rem #666;
    }
    
</style>
{/literal}
<div class="character_box">
    <div class="head"></div>
</div>