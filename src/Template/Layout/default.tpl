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
        {$this->Html->css('display')}
        {$this -> Html -> script('jquery-1.8.3')}
        {$this -> Html-> script('anime.min')}
        <title></title>
    </head>
    <body id="body" {if $firstBackground}style="background-color:{$firstBackground->body_color}"{/if}>
        {$this->fetch('content')}
        {$this->Fetch('script')}
    </body>
</html>
