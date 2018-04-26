@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 作者中心 <span class="c-gray en">&gt;</span> 作者管理 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form method="POST" id="list_form" action="/{{config('base.admin')}}/applicant/applicant_list">
		{{ csrf_field() }}
		<div class="text-c"> 日期范围：
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入作者名称" id="sSearch" name="sSearch">
			<button type="submit" class="btn btn-success radius" id="list_form_btn" name=""><i class="Hui-iconfont">&#xe665;</i> 搜作者</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
		<span class="l">
			<a href="javascript:;" onclick="audit_add()" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
{{--
			<a href="javascript:;" onclick="audit_del()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
--}}
		</span>
		<span class="r">共有数据：<strong id="user_total">{{count($object)}}</strong> 条</span> </div>
	<div class="mt-20">
	<table class="table table-border table-bordered table-hover table-bg table-sort">
		<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">用户ID</th>
				<th width="60">称呼</th>
				<th width="80">联系电话</th>
				<th width="100">所在领域</th>
				<th width="100">申请IP</th>
				<th width="200">文章链接</th>
				<th width="200">申请理由</th>
				<th width="120">申请时间</th>
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
        "bAutoWidth": false,//自动宽度
        "bProcessing": true, //datatable获取数据时候是否显示正在处理提示信息。
        'bFilter': true, //是否使用内置的过滤功能
        "bSort": {{!empty($object)?'true':'false'}}, //是否支持排序功能
        "pagingType": "full_numbers",//分页
        "data": data,
        "initComplete": function( ettings, json ) {
            if(json.iTotalDisplayRecords && json.iTotalRecords){
				$('#user_total').html(json.iTotalDisplayRecords);
			}
        },
        "sAjaxSource": "/{{config('base.admin')}}/applicant/applicant_ajax_list",
        "aaSorting": [
            [0, "desc"],
        ],
        "aoColumns": [
            {"mData": "uid","mRender": function ( data, type, full )
				{
					return "<input type='checkbox' value='"+data+"' name='id' linenum='"+data+"' />";
				}
            },
            {"mData": "uid","mRender": function ( data, type, full )
            {
                var str = '';
                if(full.user){
                    str = full.user.username;
				}else{
                    str = data;
				}
                return str;
            }
            },
            {"mData": "name"},
            {"mData": "phone"},
            {"mData": "interest"},
            {"mData": "addip"},
            {"mData": "desc"},
            {"mData": "links"},
            {"mData": "created_at"},
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
                    return "<a title='编辑' href='javascript:;' onclick=\"applicant_list_edit('编辑','applicant_list_edit?id="+data+"','','','510')\" class='ml-5' style='text-decoration:none'><i class='Hui-iconfont'>&#xe6df;</i></a>";
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

/*用户-查看*/
function user_show(title,url,w,h){
    layer_show(title,url,w,h);
}
function applicant_list_edit(title,url,w,h){
    layer_show(title,url,w,h);
}
/*通过申请*/
function audit_add(){
    var id_array = new Array();
    $('input[name="id"]:checked').each(function(){
        id_array.push($(this).val());//向数组中添加元素
    });
    if(id_array.length){
        var _options={id_list:id_array.join(',')};
        layer.confirm('确认要批量通过申请吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/{{config('base.admin')}}/applicant/audit_add',
                data: _options,
                dataType: 'json',
                success: function(data){
                    if(data.code){
                        layer.msg('已批量通过申请!',{icon: 6,time:1000});
                        setTimeout(function(){
                            location.replace(location.href);
                        },1000);
                    }else{
                        layer.msg('服务器错误!',{icon: 5,time:1000});
                    }
                },
                error:function() {
                    layer.msg('服务器错误!',{icon: 5,time:1000});
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