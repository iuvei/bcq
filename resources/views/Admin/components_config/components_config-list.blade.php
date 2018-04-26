@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 组件管理 <span class="c-gray en">&gt;</span> 组件列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/components_config/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/components_config/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
        </span>
		<span class="r">共有数据：<strong>{{count($object)}}</strong> 条</span>
	</div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-hover table-bg table-sort">
			<thead>
			<tr>
				<th scope="col" colspan="8">组件管理</th>
			</tr>
			<tr class="text-c">
				<th width="25"><input type="checkbox" value="" name=""></th>
				<th width="40">ID</th>
				<th width="200">组件名称</th>
				<th width="80">排序</th>
				<th width="120">创建时间</th>
				<th width="120">修改时间</th>
				<th width="200">状态</th>
				<th width="70">操作</th>
			</tr>
			</thead>
			<tbody>
			@foreach($object as $key => $val)
				<tr class="text-c">
					<td><input type="checkbox" value="{{$val['id']}}" name='id' linenum="{{$val['id']}}"></td>
					<td>{{$val['id']}}</td>
					<td>{{$val['title']}}</td>
					<td>{{$val['sort']}}</td>
					<td>{{$val['created_at']}}</td>
					<td>{{$val['updated_at']}}</td>
					@switch($val['status'])
						@case(0)
						<td class="td-status"><span class="label label-defaunt radius">禁用</span></td>
						@break

						@case(1)
						<td class="td-status"><span class="label label-success radius">启用</span></td>
						@break

						@default
						<td class="td-status"><span class="label label-warning radius">未知</span></td>
					@endswitch
					<td class="f-14"><a title="编辑" href="javascript:;" onclick="components_config_edit('编辑','components_config_edit/{{$val['id']}}','','400')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a></td>
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


/*组件-编辑*/
function components_config_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
</script>
</body>
</html>