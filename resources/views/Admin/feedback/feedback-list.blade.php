@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 意见反馈管理 <span class="c-gray en">&gt;</span> 意见反馈列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">

            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/feedback/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量设为已读</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/feedback/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量设为未读</a>
            <a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/feedback/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span>
        <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="60">ID</th>
                <th width="80">用户名</th>
                <th width="80">标题</th>
                <th width="200">内容</th>
                <th width="130">IP</th>
                <th width="120">发布状态</th>
                <th width="120">更新时间</th>
                <th width="70">状态</th>
                <th width="100">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($object as $key => $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$val['id']}}" linenum="{{$val['id']}}" name="id"></td>
                    <td>{{$val['id']}}</td>
                    <td>{{$val['user']['username']}}</td>
                    <td>{{$val['title']}}</td>
                    <td><div title="{{$val['content']}}">{{str_limit($val['content'],30,'...')}}</div></td>
                    <td>{{$val['addip']}}</td>
                    <td>{{$val['created_at']}}</td>
                    <td>{{$val['updated_at']}}</td>
                    @switch($val['status'])
                        @case(0)
                        <td class="td-status"><span class="label label-defaunt radius">未读</span></td>
                        @break
                        @case(1)
                        <td class="td-status"><span class="label label-success radius">已读</span></td>
                        @break
                        @default
                        <td class="td-status"><span class="label label-warning radius">未知</span></td>
                    @endswitch
                    <td class="f-14"><a title="编辑" href="javascript:;" onclick="feedback_edit('意见反馈编辑','/{{config('base.admin')}}/feedback/feedback_edit/{{$val['id']}}','','300')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a></td>
                </tr>
            @endforeach
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
    /*意见反馈-编辑*/
    function feedback_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }


    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "bAutoWidth": false,//自动宽度
        "pading":false,
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0]}// 不参与排序的列
        ]
    });

</script>
</body>
</html>
