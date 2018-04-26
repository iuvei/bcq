@include('Admin.common._meta')
<body>
    <div id="iframe_box" class="Hui-article">
        <div class="show_iframe">
            <div style="display:none" class="loading"></div>
            <div class="page-container">
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
            </div>
        </div>
    </div>
@include('Admin.common._footer')
