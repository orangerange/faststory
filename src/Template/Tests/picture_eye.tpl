{literal}
    <style type="text/css">
    .eyes {
      position: relative;
    }
    .eyes > div{
      border: solid 0.2rem #666;
      background-color: #FFF;
      width: 12vh;
      height: 12vh;
      border-radius: 30vh;
      position: relative;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .eyes > div:before {
      content: "●";
      /*animation: lookAround 5s ease-in-out alternate infinite;*/
      position: absolute;
      top: 20%;
      left: 35%;
      font-size: 6vh;
      height: 4rem;
      line-height: 6rem;
      text-align: center;
      font-weight: bold;
    }
    .eyes > div:after {
      content: "";
      position: absolute;
      top: 100%;
      height: 1vh;
      width: 6vh;
      border-bottom: solid 0.2rem #666;
      border-radius: 50%;
    }
    </style>
{/literal}
<div class="eyes eyes_1 row">
    <div class="eye--right"></div>
    <div class="nose"></div>
    <div class="eye--left"></div>
</div>
