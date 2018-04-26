<!doctype html>
<html>
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="Shortcut Icon" href="/static/favicon.png">
    <title>菠菜圈</title>
</head>
<body>
    <div class="plate">
        <h1>{{$info['enterprise']}}</h1>
    </div>
</body>
</html>
<style>
    html {
        height: 100%;
    }

    body {
        display: -webkit-box;  /* 老版本语法: Safari,  iOS, Android browser, older WebKit browsers.  */
        display: -moz-box;    /* 老版本语法: Firefox (buggy) */
        display: -ms-flexbox;  /* 混合版本语法: IE 10 */
        display: -webkit-flex;  /* 新版本语法： Chrome 21+ */
        display: flex;       /* 新版本语法： Opera 12.1, Firefox 22+ */

        /*垂直居中*/
        /*老版本语法*/
        -webkit-box-align: center;
        -moz-box-align: center;
        /*混合版本语法*/
        -ms-flex-align: center;
        /*新版本语法*/
        -webkit-align-items: center;
        align-items: center;

        /*水平居中*/
        /*老版本语法*/
        -webkit-box-pack: center;
        -moz-box-pack: center;
        /*混合版本语法*/
        -ms-flex-pack: center;
        /*新版本语法*/
        -webkit-justify-content: center;
        justify-content: center;

        margin: 0;
        height: 100%;
        width: 100%; /* needed for Firefox */
        background: url('/static/{{$plate['class']}}_bg.png') no-repeat;

    }
    /*实现文本垂直居中*/
    .plate {
        width: 605px;
        height: 829px;

        display: -webkit-box;
        display: -moz-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;

        -webkit-box-align: center;
        -moz-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;

        background: url('/static/{{$plate['class']}}.png') no-repeat;
    }
    .plate h1{
        margin: 90px auto 0;
        color: #333333;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
        font-size: 48px;
    }
</style>