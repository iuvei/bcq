@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">点赞量(top)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->top}}" placeholder="" id="top" name="top">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">投诉量(complaint)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->complaint}}" placeholder="" id="complaint" name="complaint">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">内容(content)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea name="content" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符"></textarea>
				<p class="textarea-numberbar"></p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态(status)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="status-1" value="1" name="status" @if($obj->status == 1) checked @endif>
					<label for="status-1">启用</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="status-2" value="0" name="status" @if($obj->status == 0) checked @endif>
					<label for="status-2">禁用</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="status-3" value="-1" name="status" @if($obj->status == -1) checked @endif>
					<label for="status-3">删除</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<div class="Huialert Huialert-danger hide" id="form_msg"></div>
		</div>
		<div class="row cl">
			<div class="col-xs-1 col-sm-1 col-xs-offset-2 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
			@if(!$obj->status)
				<div class="col-xs-1 col-sm-1">
					<button type="button" class="btn btn-danger radius" id="admin-return" onclick="message_send('发送私信','/{{config('base.admin')}}/message/message_send_add/{{$obj->uid}}/{{$table}}/{{$obj->id}}/2/报告评论/{{$obj->created_at}}','500','250')"><i class="icon-ok"></i> 退回通知</button>
				</div>
			@endif
		</div>
	</form>
</article>

@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/admin/lib/webuploader/0.1.5/webuploader.min.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.config.js"></script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/ueditor.all.min.js"> </script>
<script type="text/javascript" src="/admin/lib/ueditor/1.4.3/lang/zh-cn/zh-cn.js"></script>
<script type="text/javascript">
    function message_send(title,url,w,h){
        var index = parent.layer.getFrameIndex(window.name);
        url = url+'?index='+index;
        layer_show(title,url,w,h);
    }

    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });

        $(".textarea").Huitextarealength({
            minlength:10,
            maxlength:100
        });

        //表单验证
        var ajaxStatus=1;
        $("#form-admin").validate({
            rules:{
                title:{
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
                    url: '/{{config('base.admin')}}/report_comment/report_comment_edit/{{$obj->id}}', // 需要提交的 url
                    success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                        // 此处可对 data 作相关处理
                        $("#form_msg").hide().html('');
                        ajaxStatus=1;
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.location.reload();
                        parent.layer.close(index);
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