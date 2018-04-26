@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont"><a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="author_insert()" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量成为作者</a></span>  <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">ID</th>
				<th width="100">用户名</th>
				<th width="120">电话</th>
				<th width="120">注册时间</th>
				<th width="120">操作时间</th>
				<th width="70">状态</th>
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
		"sAjaxSource": "/{{config('base.admin')}}/author/user_ajax_list",
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

/*用户-成为作者*/
function author_insert(){
	var id_array = new Array();
	$('input[name="id"]:checked').each(function(){
		id_array.push($(this).val());//向数组中添加元素
	});
	if(id_array.length){
        var _options={id_list:id_array.join(',')};
        layer.confirm('确认要批量启用作者吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/{{config('base.admin')}}/author/author_add',
                data: _options,
                dataType: 'json',
                success: function(data){
                    if(data.code){
                        layer.msg('已启用!',{icon: 6,time:1000});
                    }else{
                        layer.msg('服务器错误!',{icon: 5,time:1000});
					}
                    setTimeout(function(){
                        window.parent.location.reload();
                        parent.layer.close(index);
                    },1000);
                },
                error:function() {
                    layer.msg('服务器错误!',{icon: 5,time:1000});
                    setTimeout(function(){
                        window.parent.location.reload();
                        parent.layer.close(index);
                    },1000);
                }
            });
        });
    }else{
        layer.msg('未选择用户!',{icon: 5,time:1000});
    }
}

</script>
</body>
</html>