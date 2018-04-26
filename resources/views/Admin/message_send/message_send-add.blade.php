@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<div class="formControls col-xs-12 col-sm-12">
				<textarea name="content" id="content" class="textarea"  placeholder="说点什么...最少输入10个字符">{{$str}}</textarea>
			</div>
		</div>
		<div class="row cl">
			<div class="col-xs-8 col-sm-8">
				<button type="submit" class="btn btn-success radius" id="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
		</div>
	</form>
</article>

@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript">
$(function(){
	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

	//表单验证
	var ajaxStatus=1;
	$("#form-admin").validate({
		rules:{
            content:{
				required:true,
			}
		},
		onkeyup:false,
		focusCleanup:true,
		success:"valid",
        submitHandler:function(form){
			if(ajaxStatus==0){return false;}ajaxStatus=0;
            $(form).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: '/{{config('base.admin')}}/message/message_send_add/{{$uid}}/{{$table}}/{{$id}}/null/null/null', // 需要提交的 url
                success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                    // 此处可对 data 作相关处理
                    ajaxStatus=1;
                    window.parent.parent.location.reload();
                },
                error: function(data) {
                    var json=JSON.parse(data.responseText);
                    var str = '';
                    $.each(json.errors,function(key,val){
                        str += val + '\r\n';  //到这里终于拿到返回name字段的错误信息了
                    });
                    $("#form_msg").show().html(str);
                    ajaxStatus=1;
                }
            });
        }
	});
});
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>