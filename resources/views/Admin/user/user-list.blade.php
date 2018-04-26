@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 用户中心 <span class="c-gray en">&gt;</span> 用户管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form method="POST" id="list_form" action="/{{config('base.admin')}}/user/user_list">
		{{ csrf_field() }}
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入会员名称、电话、城市" id="sSearch" name="sSearch">
			<button type="submit" class="btn btn-success radius" id="list_form_btn" name=""><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/user/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
			<a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/user/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
			<a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/user/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
			<a href="javascript:;" onclick="user_add('添加用户','/{{config('base.admin')}}/user/user_add','','')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加用户</a>
		</span>
		<span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
	</div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="120">电话</th>
				<th width="60">用户等级</th>
				<th width="120">注册ip</th>
				<th width="120">最后登录ip</th>
				<th width="120">注册时间</th>
				<th width="120">操作时间</th>
				<th width="70">状态</th>
				<th width="100">操作</th>
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
$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
$(function(){
    var data = @json($object);
    $('.table-sort').dataTable({
        "bServerSide": {{empty($object)?'true':'false'}},
        'bPaginate': true, //是否分页
        "bProcessing": true, //datatable获取数据时候是否显示正在处理提示信息。
        'bFilter': true, //是否使用内置的过滤功能
        "bSort": {{!empty($object)?'true':'false'}}, //是否支持排序功能
        "pagingType": "full_numbers",//分页
        "data": data,
        "initComplete": function( ettings, json ) {
            if(json.iTotalDisplayRecords && json.iTotalRecords){
				$('#total').html(json.iTotalDisplayRecords);
			}
        },
        "sAjaxSource": "/{{config('base.admin')}}/user/user_ajax_list",
        "aaSorting": [
            [0, "desc"],
        ],
        "aoColumns": [
            {"mData": "id","mRender": function ( data, type, full )
				{
					return "<input type='checkbox' value='"+data+"' name='id' linenum='"+data+"' />";
				}
            },
            {"mData": "id"},
            {"mData": "username"},
            {"mData": "phone"},
            {"mData": "level_id"},
            {"mData": "regip"},
            {"mData": "lastloginip"},
            {"mData": "created_at"},
            {"mData": "updated_at"},
            {"mData": "status" ,"sClass": "td-status" ,"mRender": function ( data, type, full )
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
					return "<a title='编辑' href='javascript:;' onclick=\"user_edit('编辑','user_edit/"+data+"','','','510')\" class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a>";
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

/*用户-添加*/
function user_add(title,url,w,h){
	layer_show(title,url,w,h);
}
/*用户-编辑*/
function user_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*用户-查看*/
function user_show(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-停用*/
function user_stop(obj,id){
	layer.confirm('确认要停用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="user_start(this,id)" href="javascript:;" title="启用"><i class="Hui-iconfont">&#xe6e1;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-defaunt radius">已停用</span>');
				$(obj).remove();
				layer.msg('已停用!',{icon: 5,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}

/*用户-启用*/
function user_start(obj,id){
	layer.confirm('确认要启用吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").find(".td-manage").prepend('<a style="text-decoration:none" onClick="user_stop(this,id)" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a>');
				$(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
				$(obj).remove();
				layer.msg('已启用!',{icon: 6,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
/*密码-修改*/
function change_password(title,url,id,w,h){
	layer_show(title,url,w,h);
}
/*用户-删除*/
function user_del(obj,id){
	layer.confirm('确认要删除吗？',function(index){
		$.ajax({
			type: 'POST',
			url: '',
			dataType: 'json',
			success: function(data){
				$(obj).parents("tr").remove();
				layer.msg('已删除!',{icon:1,time:1000});
			},
			error:function(data) {
				console.log(data.msg);
			},
		});
	});
}
</script>
</body>
</html>