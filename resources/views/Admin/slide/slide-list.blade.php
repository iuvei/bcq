@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 首页轮播管理 <span class="c-gray en">&gt;</span> 首页轮播列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form method="POST" id="list_form" action="/{{config('base.admin')}}/slide/slide_list">
        {{ csrf_field() }}
        <div class="text-c">
            <button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
            <span class="select-box inline">
                <select name="slide_type" class="select">
                        <option  value="" selected>信息类型</option>
                        <option value="news">资讯</option>
                        <option value="report">报告</option>
                        <option value="business">供应</option>
                        <option value="platform">招募</option>
                        <option value="data">资料</option>
                </select>
            </span> 日期范围：
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            <input type="text" class="input-text" style="width:250px" placeholder="输入会关键字查找" id="sSearch" name="sSearch">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜首页轮播</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span>
            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/slide/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/slide/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
            <a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/slide/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span>
        <span class="dropDown dropDown_hover">
            <a class="btn btn-primary radius" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加首页轮播</a>
            <ul class="dropDown-menu menu radius box-shadow">
                <li class=""><a href="javascript:;" onclick="slide_add('添加 资讯 到首页轮播','/{{config('base.admin')}}/slide/slide_add/news','1200','')" href="javascript:;">添加 资讯</a></li>
                <li class=""><a href="javascript:;" onclick="slide_add('添加 报告 到首页轮播','/{{config('base.admin')}}/slide/slide_add/report','1200','')" href="javascript:;">添加 报告</a></li>
                <li class=""><a href="javascript:;" onclick="slide_add('添加 商讯 到首页轮播','/{{config('base.admin')}}/slide/slide_add/business','1200','')" href="javascript:;">添加 供应</a></li>
                <li class=""><a href="javascript:;" onclick="slide_add('添加 代理 到首页轮播','/{{config('base.admin')}}/slide/slide_add/platform','1200','')" href="javascript:;">添加 招募</a></li>
                <li class=""><a href="javascript:;" onclick="slide_add('添加 资料 到首页轮播','/{{config('base.admin')}}/slide/slide_add/data','1200','')" href="javascript:;">添加 资料</a></li>
            </ul>
        </span>
        <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="200">信息名称</th>
                <th width="80">信息ID</th>
                <th width="80">信息类型</th>
                <th width="80">信息链接</th>
                <th width="80">排序</th>
                <th width="120">添加时间</th>
                <th width="120">状态</th>
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
            "sAjaxSource": "/{{config('base.admin')}}/slide/slide_ajax_list",
            "aaSorting": [
                [0, "desc"],
            ],
            "aoColumns": [
                {"mData": "id","mRender": function ( data, type, full )
                {
                    return "<input type='checkbox' value='"+data+"' name='id' linenum='"+data+"' />";
                }
                },
                {"mData": "title"},
                {"mData": "slide_id"},
                {"mData": "slide_type", "mRender": function ( data, type, full )
                {
                    var str = '';
                    switch(data)
                    {
                        case 'news':
                            str = '资讯';
                            break;
                        case 'report':
                            str = '报告';
                            break;
                        case 'business':
                            str = '供应';
                            break;
                        case 'platform':
                            str = '招募';
                            break;
                        case 'notice':
                            str = '公告';
                            break;
                        case 'data':
                            str = '资料';
                            break;
                        case 'banner':
                            str = '广告';
                            break;
                        default:
                            str = '未知';
                    }
                    return str;
                }
                },
                {"mData": "url"},
                {"mData": "sort"},
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
                    return "<a title='编辑' href='javascript:;' onclick=\"slide_edit('编辑','/{{config('base.admin')}}/slide/slide_edit/"+data+"','1200','')\" class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a>";
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

    /*首页轮播-添加*/
    function slide_add(title,url,w,h){
        layer_show(title,url,w,h);
    }

    /*首页轮播-添加*/
    function slide_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }

</script>
</body>
</html>
