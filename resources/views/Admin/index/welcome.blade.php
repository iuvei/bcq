@extends('Admin.common.layout')
@section('content')
    <section class="Hui-article-box">
        <div id="Hui-tabNav" class="Hui-tabNav hidden-xs">
            <div class="Hui-tabNav-wp">
                <ul id="min_title_list" class="acrossTab cl">
                    <li class="active">
                        <span title="我的桌面" data-href="welcome.html">我的桌面</span>
                        <em></em></li>
                </ul>
            </div>
            <div class="Hui-tabNav-more btn-group"><a id="js-tabNav-prev" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d4;</i></a><a id="js-tabNav-next" class="btn radius btn-default size-S" href="javascript:;"><i class="Hui-iconfont">&#xe6d7;</i></a></div>
        </div>
        <div id="iframe_box" class="Hui-article">
            <div class="show_iframe">
                <div style="display:none" class="loading"></div>
                <div class="page-container">
                    <p class="f-20 text-success">欢迎使用菠菜圈<span class="f-14">v2.0</span>后台！</p>
                    <p>上次登录IP：{{$user->lastloginip}}  上次登录时间：{{$user->updated_at}}</p>
                    <table class="table table-border table-bordered table-bg">
                        <thead>
                        <tr>
                            <th colspan="15" scope="col">信息统计</th>
                        </tr>
                        <tr class="text-c">
                            <th rowspan="2">文章审核</th>
                            <th rowspan="2">产品动态审核</th>
                            <th rowspan="2">产业资源审核</th>
                            <th colspan="4">交易审核</th>
                            <th rowspan="2">问答互动审核</th>
                            <th colspan="5">评论举报</th>
                            <th rowspan="2">作者申请</th>
                            <th rowspan="2">意见反馈</th>
                        </tr>
                        <tr class="text-c">
                            <th>供应信息</th>
                            <th>求购信息</th>
                            <th>平台信息</th>
                            <th>代理信息</th>
                            <th>资料评论</th>
                            <th>资讯评论</th>
                            <th>问答评论</th>
                            <th>报告评论</th>
                            <th>产品评论</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="text-c">
                            <td><a data-href="/{{config('base.admin')}}/news/news_review" data-title="文章审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['news']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/trends/trends_review" data-title="产品动态审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['trends']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/data/data_review" data-title="产业资源审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['data']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/business/business_review/1" data-title="供应信息审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['business1']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/business/business_review/2" data-title="求购信息审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['business2']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/platform/platform_review/1" data-title="平台信息审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['platform1']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/platform/platform_review/2" data-title="代理信息审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['platform2']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/question/question_review" data-title="问答互动审核" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['question']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/data_comment/data_comment_review" data-title="资料评论举报" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['data_comment']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/news_comment/news_comment_review" data-title="资讯评论举报" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['news_comment']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/answer_comment/answer_comment_review" data-title="问答评论举报" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['question_answer_comment']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/report_comment/report_comment_review" data-title="报告评论举报" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['report_comment']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/trends_comment/trends_comment_review" data-title="产品评论举报" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['trends_comment']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/applicant/applicant_review" data-title="作者申请" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['applicant_author']}}</a></td>
                            <td><a data-href="/{{config('base.admin')}}/feedback/feedback_review" data-title="意见反馈" href="javascript:;" onclick="Hui_admin_tab(this)">{{$count['feedback']}}</a></td>
                        </tr>
                        </tbody>
                    </table>
                    <table class="table table-border table-bordered table-bg mt-20">
                        <thead>
                        <tr>
                            <th colspan="2" scope="col">服务器信息</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <th width="30%">客户端IP地址</th>
                            <td><span id="lbServerName">{{$_SERVER['REMOTE_ADDR']}}</span></td>
                        </tr>
                        <tr>
                            <td>服务器IP地址</td>
                            <td>{{GetHostByName($_SERVER['SERVER_NAME'])}}</td>
                        </tr>
                        <tr>
                            <td>服务器域名</td>
                            <td>{{$_SERVER['SERVER_NAME']}}</td>
                        </tr>
                        <tr>
                            <td>服务器端口 </td>
                            <td>{{$_SERVER['SERVER_PORT']}}</td>
                        </tr>
                        <tr>
                            <td>服务器版本 </td>
                            <td>{{$_SERVER ['SERVER_SOFTWARE']}}</td>
                        </tr>
                        <tr>
                            <td>本文件所在文件夹 </td>
                            <td>{{dirname(__FILE__)}}</td>
                        </tr>
                        <tr>
                            <td>服务器操作系统 </td>
                            <td>{{php_uname()}}</td>
                        </tr>
                        <tr>
                            <td>系统所在文件夹 </td>
                            <td>{{$_SERVER['DOCUMENT_ROOT']}}</td>
                        </tr>
                        <tr>
                            <td>服务器的语言种类 </td>
                            <td>{{$_SERVER['HTTP_ACCEPT_LANGUAGE']}}</td>
                        </tr>
                        <tr>
                            <td>服务器当前时间 </td>
                            <td>{{date('Y-m-d H:i:s',$_SERVER['REQUEST_TIME'])}}</td>
                        </tr>
                        <tr>
                            <td>当前浏览器版本 </td>
                            <td>{{$_SERVER['HTTP_USER_AGENT']}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <audio id="player">
            <source src="/admin/static/hint.mp3"/>
        </audio>
    </section>

    <script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
    <script type="text/javascript">
        function playMusic() {
            var player = $("#player")[0]; /*jquery对象转换成js对象*/
            if (player.paused){ /*如果已经暂停*/
                player.play(); /*播放*/
            }
        }
        $("#review-total").html({{$total}});
        var timeStatus = 1;
        setInterval(function () {
            if (timeStatus == 0){
                return false;
            }
            timeStatus = 0;
            $.ajax({
                type: 'get',
                url: "/{{config('base.admin')}}/index/getCount",
                dataType: 'json',
                success: function(data){
                    if ($.cookie('dataCount')){
                        if (parseInt($.cookie('dataCount'))>=parseInt(data)){
                            $.cookie('dataCount',parseInt(data));
                        }else{
                            playMusic();
                            $.cookie('dataCount',parseInt(data));
                        }
                    }else{
                        playMusic();
                        $.cookie('dataCount',parseInt(data));
                    }
                    $("#review-total").html(parseInt(data));
                    timeStatus = 1;
                },
                error: function(data){
                    timeStatus = 1;
                },
            });
        },5000)
    </script>
@endsection