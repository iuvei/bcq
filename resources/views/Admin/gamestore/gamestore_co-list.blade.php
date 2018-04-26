@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 游戏接口商管理 <span class="c-gray en">&gt;</span> 排序管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="r">共有数据：<strong>{{count($object)}}</strong> 条</span>
	</div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
			<tr>
				<th scope="col" colspan="9">等级管理</th>
			</tr>
			<tr class="text-c">
				<th width="40">ID</th>
				<th width="300">分类名称</th>
				<th width="200">排序</th>
				<th width="70">操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($object as $key => $val)
				<tr class="text-c">
					<td>{{$val['id']}}</td>
					<td>{{$val['category']['gname']}}</td>
					<td>{{$val['sort']}}</td>
					<td class="f-14"><a title="编辑" href="javascript:;" onclick="level_edit('排序编辑','/{{config('base.admin')}}/gamestore/gamestore_co_edit/{{$val['id']}}','400','200')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a></td>
				</tr>
			@endforeach
			</tbody>
		</table>
	</div>
</div>
@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "bAutoWidth": false,//自动宽度
        "pading":false,
//	"aoColumnDefs": [
//		//{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
//		{"orderable":false,"aTargets":[0,8]}// 不参与排序的列
//	]
    });


/*排序-编辑*/
function level_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
</body>
</html>