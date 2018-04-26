@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 订单管理 <span class="c-gray en">&gt;</span> 订单列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form method="POST" id="list_form" action="/{{config('base.admin')}}/order/order_list">
        {{ csrf_field() }}
        <div class="text-c">
            <button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
            <span class="select-box inline">
                <select name="type" class="select">
                        <option  value="" selected>消费类型</option>
                        <option value="1">扣除</option>
                        <option value="2">增加</option>
                </select>
                <select name="pay_type" class="select">
                        <option  value="" selected>商品类型</option>
                        <option value="data">资料</option>
                        <option value="task">任务</option>
                        <option value="report">报告</option>
                        <option value="question">问答</option>
                </select>
            </span> 日期范围：
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
            -
            <input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
            &nbsp;
            <input type="text" class="input-text" style="width:150px" placeholder="输入商品名称" id="sSearch" name="sSearch">
            <input type="text" class="input-text" style="width:150px" placeholder="输入用户名或手机号" id="suname" name="suname">
            <button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜订单</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="200">名称</th>
                <th width="80">价格</th>
                <th width="80">消费类型</th>
                <th width="80">商品类型</th>
                <th width="80">商品ID</th>
                <th width="80">消费者</th>
                <th width="120">消费时间</th>
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
            "sAjaxSource": "/{{config('base.admin')}}/order/order_ajax_list",
            "aaSorting": [
                [0, "desc"],
            ],
            "aoColumns": [
                {"mData": "id","mRender": function ( data, type, full )
                {
                    return "<input type='checkbox' value='"+data+"' name='id' linenum='"+data+"' />";
                }
                },
                {"mData": "pay.title"},
                {"mData": "pay.price"},
                {"mData": "type" , "mRender": function ( data, type, full )
                {
                    str = '';
                    switch(parseInt(data))
                    {
                        case 1:
                            str = '扣除';
                            break;
                        case 2:
                            str = '增加';
                            break;
                        default:
                            str = '未知';
                    }
                    return str;
                }
                },
                {"mData": "pay_type", "mRender": function ( data, type, full )
                {
                    var str = '';
                    switch(data)
                    {
                        case 'data':
                            str = '资料';
                            break;
                        case 'task':
                            str = '任务';
                            break;
                        case 'report':
                            str = '报告';
                            break;
                        case 'question':
                            str = '问答';
                            break;
                        default:
                            str = '未知';
                    }
                    return str;
                }
                },
                {"mData": "pay.id"},
                {"mData": "user.username"},
                {"mData": "created_at"}
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

</script>
</body>
</html>
