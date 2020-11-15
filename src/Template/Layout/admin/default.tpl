<html>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <meta http-equiv="Cache-Control" content="no-cache">
        <meta http-equiv="Content-Script-Type" content="text/javascript">
        <meta http-equiv="Content-Style-Type" content="text/css">
        <meta name="description" content="">
        <meta name="keywords" content="" />
        {$this -> Html -> script('jquery-1.8.3')}
        {$this -> Html-> script('anime.min')}
        {$this -> Html -> script('admin/common')}
        {$this->fetch('script')}
        {$this->Display->baseClassCss()}
        {$this->Html->css('display')}
        {$this->Html->css('admin')}
        {$this->Html->css('config_admin')}
        {$this->fetch('css')}
        <title></title>
    </head>
    <body id="body" {if $bodyColor}style="background-color:{$bodyColor}"{/if}>
        {$this->fetch('content')}
    </body>
</html>
