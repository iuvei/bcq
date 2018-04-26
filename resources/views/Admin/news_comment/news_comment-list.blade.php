@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 资讯管理 <span class="c-gray en">&gt;</span> 资讯评论列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form method="POST" id="list_form" action="/{{config('base.admin')}}/news_comment/news_comment_list">
        {{ csrf_field() }}
        <div class="text-c">
            <button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
            日期范围：
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会关键字查找" id="sSearch" name="sSearch">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜资讯评论</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/news_comment/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/news_comment/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
            <a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/news_comment/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span>
        <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">用户名</th>
                <th width="80">资讯ID</th>
                <th width="80">关联评论ID</th>
                <th width="60">点赞量</th>
                <th width="60">举报量</th>
                <th width="300">评论内容</th>
                <th width="120">添加时间</th>
                <th width="80">状态</th>
                <th width="80">操作</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>
</div>
@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    $(function(){
        var data = @json($object);
        $('.table-sort').dataTable({
            "bServerSide": {{empty($object)?'true':'false'}},
            'bPaginate': true, //是否分页
            "bAutoWidth": false,//自动宽度
            "bProcessing": true, //datatable获取数据时候是否显示正在处理提示信息。
            "iDisplayLength": 10, //每页显示10条记录
            'bFilter': true, //是否使用内置的过滤功能
            "bSort": {{!empty($object)?'true':'false'}}, //是否支持排序功能
            "pagingType": "full_numbers",//分页
            "data": data,
            "initComplete": function( ettings, json ) {
                if(json.iTotalDisplayRecords && json.iTotalRecords){
                    $('#total').html(json.iTotalDisplayRecords);
                }
            },
            "sAjaxSource": "/{{config('base.admin')}}/news_comment/news_comment_ajax_list",
            "aaSorting": [
                [0, "desc"],
            ],
            "aoColumns": [
                {"mData": "id","mRender": function ( data, type, full )
                {
                    return "<input type='checkbox' value='"+data+"' name='id' linenum='"+data+"' />";
                }
                },
                {"mData": "uid" , "mRender": function ( data, type, full )
                {
                    var username = data;
                    if(full.user){
                        username = full.user.username;
                    }
                    return username;
                }
                },
                {"mData": "nid" , "mRender": function ( data, type, full )
                {
                    var title = data;
                    if(full.news){
                        title = full.news.title;
                    }
                    return "<div class='label radius' title='"+title+"'>"+data+"</div>";
                }
                },
                {"mData": "ncid" , "mRender": function ( data, type, full )
                {
                    var content = data;
                    if(full.comment){
                        content = full.comment.content;
                    }
                    return "<div class='label radius' title='"+content+"'>"+data+"</div>";
                }
                },
                {"mData": "top"},
                {"mData": "complaint"},
                {"mData": "content" , "mRender": function ( data, type, full )
                {
                    var str = data.substr(0,50);
                    if (data.length != str.length){
                        str += '...';
                    }
                    return "<span title='"+data+"'>"+str+"</span>";
                }
                },
                {"mData": "created_at"},
                {"mData": "status" ,"sClass": "td-status", "mRender": function ( data, type, full )
                {
                    var cla,str = '';
                    switch(data)
                    {
                        case 0:
                            cla = 'label-defaunt';
                            str = '禁用';
                            break;
                        case 1:
                            cla = 'label-success';
                            str = '启用';
                            break;
                        default:
                            cla = 'label-danger';
                            str = '未知';
                    }
                    return "<span class='label "+cla+" radius'>"+str+"</span>";
                }
                },
                {"mData": "id","mRender": function ( data, type, full )
                {
                    return "<a title='编辑' href='javascript:;' onclick=\"news_comment_edit('编辑','/{{config('base.admin')}}/news_comment/news_comment_edit/"+data+"','1200','')\" class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a>";
                }
                }
            ],
            "oLanguage": {
                'sSearch': '数据筛选:',
                "sInfoEmtpy": "找不到相关数据",
                "sLengthMenu": "每页显示 _MENU_ 项记录",
                "sZeroRecords": "没有符合项件的数据...",
                "sInfo": "当前数据为从第 _START_ 到第 _END_ 项数据",
                "sInfoFiltered": "(总共有 _TOTAL_ 项记录)"
            }
        });
    });

    /*资讯评论-编辑*/
    function news_comment_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }

</script>
</body>
</html>
