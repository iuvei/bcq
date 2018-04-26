@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 通讯管理 <span class="c-gray en">&gt;</span> 站内信接受者<a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	<form method="POST" id="list_form" action="/{{config('base.admin')}}/mail_send/mail_send_list/{{$mid}}">
		{{ csrf_field() }}
		<div class="text-c">
			<button onclick="removeIframe()" class="btn btn-primary radius">关闭选项卡</button>
			日期范围：
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="datemin" name="datemin" class="input-text Wdate" style="width:120px;">
			-
			<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 23:59:59'})" id="datemax" name="datemax" class="input-text Wdate" style="width:120px;">
			<input type="text" class="input-text" style="width:250px" placeholder="输入会关键字查找" id="sSearch" name="sSearch">
			<button name="" id="" class="btn btn-success" type="submit"><i class="Hui-iconfont">&#xe665;</i> 搜用户</button>
		</div>
	</form>
	<div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/mail_send/datastatus')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量用户未读</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/mail_send/datastatus')" class="btn btn-default radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
            <a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/mail_send/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a href="javascript:;" onclick="mail_send_add('未接收者列表','/{{config('base.admin')}}/mail_send/mail_send_add/{{$mid}}',1000,'')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe600;</i> 未接收者列表</a>
        </span>
		<span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
	</div>
	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
			<thead>
			<tr class="text-c">
				<th width="25"><input type="checkbox" name="" value=""></th>
				<th width="80">ID</th>
				<th width="200">收件人</th>
				<th width="120">接收状态</th>
				<th width="120">状态变更时间</th>
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
            "sAjaxSource": "/{{config('base.admin')}}/mail_send/mail_send_ajax_list/{{$mid}}",
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
                {"mData": "user.username"},
                {"mData": "created_at"},
                {"mData": "updated_at"},
                {"mData": "status" ,"sClass": "td-status", "mRender": function ( data, type, full )
                {
                    var cla,str = '';
                    switch(parseInt(data))
                    {
                        case 0:
                            cla = 'label-defaunt';
                            str = '管理员禁用';
                            break;
                        case 1:
                            cla = 'label-primary';
                            str = '用户未读';
                            break;
                        case 2:
                            cla = 'label-success';
                            str = '用户已读';
                            break;
                        case 3:
                            cla = 'label-warning';
                            str = '用户删除';
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

    /*站内信接受者-添加*/
    function mail_send_add(title,url,w,h){
        layer_show(title,url,w,h);
    }



    /*站内信接受者-添加*/
    function news_insert(url){
        var id_array = new Array();
        $('input[name="id"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素
        });
        if(id_array.length){
            var _options={id_list:id_array.join(',')};
            layer.confirm('确认要批量添加吗？',function(index){
                $.ajax({
                    type: 'POST',
                    url: url,
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
            layer.msg('未选择新闻!',{icon: 5,time:1000});
        }
    }

    /*状态-批量操作  复写*/
    function datastatus(status,url){
        var id_array=new Array();
        $('input[name="id"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素
        });
        if(id_array.length){
            var _options={id_list:id_array.join(','),status:status};
            var message = '';
            var css = '';
            var display = '';
            switch(status){
                case -1:
                    message = '确认要删除吗？';
                    css = 'label-danger';
                    display = '删除';
                    break;
                case 0:
                    message = '确认要禁用吗？';
                    css = 'label-defaunt';
                    display = '管理员禁用';
                    break;
                case 1:
                    message = '确认要使用户未读吗？';
                    css = 'label-primary';
                    display = '用户未读';
                    break;
                default:
                    return false;
            }

            layer.confirm(message,function(index){
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: _options,
                    dataType: 'json',
                    success: function(data){
                        $.each(id_array,function(index,value){
                            $('input[linenum="'+value+'"]').parents('tr').find('.td-status').html('<span class="label '+css+' radius">'+display+'</span>');
                        });
                        layer.msg('已'+display+'!',{icon:1,time:1000});
                        if(status == -1){
                            window.location.reload();
                            //$('tr[linenum="'+value+'"]').remove();
                        }
                    },
                    error:function(data) {
                        layer.msg('系统错误，请稍候再试！',{icon:2,time:1000});
                    },
                });
            });
        }else{
            layer.msg('未选择数据!',{icon: 5,time:1000});
        }
    }
</script>
</body>
</html>