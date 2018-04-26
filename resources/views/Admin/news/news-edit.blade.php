@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章标题(title)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->title}}" placeholder="" id="title" name="title">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>分类栏目(cid)：</label>
			<div class="formControls col-xs-8 col-sm-8"> <span class="select-box">
				<select name="cid" class="select">
					<option value="">未选择</option>
					@foreach($category as $val)
						<option value="{{$val->id}}" @if($obj->cid == $val->id) selected @endif>{{$val->cname}}</option>
					@endforeach
				</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>选择作者(uid)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<span class="select-box">
					<select name="uid" class="select">
						<option value="">未选择</option>
						<option value="{{$obj->uid}}" selected>{{$obj->user->username}}</option>
						@foreach($author as $val)
							@if($obj->uid != $val->id)
								<option value="{{$val->id}}">{{$val->username}}</option>
							@endif
						@endforeach
					</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">排序值(sort)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->sort}}" placeholder="" id="sort" name="sort">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">浏览量(view)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->view}}" placeholder="" id="view" name="view">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">封面图片(image)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<div class="uploader-list-container">
					<img class="pointer uplodeimg" onclick="$(this).siblings(':file').click();" src="@if($obj->image) {{$obj->image}} @else /admin/image/cover.png @endif" title="点击上传图片" />
					<input type="file" class="hide" accept="image/*" />
					<input type="hidden" name="image" id="image" value="{{$obj->image}}" />
					<div class="@if(!($obj->image)) hide @endif editImg" onclick="$(this).siblings(':file').click();">编辑</div>
					<div class="uplodeMask hide">图片上传中，请稍后...</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所有关键词(key_all)：</label>
			<div class="formControls col-xs-8 col-sm-8" id="key_all">
				{!!$obj->key_all!!}
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">关键词(keywords)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->keywords}}" placeholder="" id="keywords" name="keywords">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章摘要(brief)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea name="brief" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符">{{$obj->brief}}</textarea>
				<p class="textarea-numberbar"></p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>文章内容(content)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea id="content" name="content" type="text/plain">{{$obj->content}}</textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>推荐(head)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="head-1" value="1" name="head" @if($obj->head == 1) checked @endif>
					<label for="head-1">是</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="head-2" value="0" name="head" @if($obj->head == 0) checked @endif>
					<label for="head-2">否</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>原创(byself)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="byself-1" value="1" name="byself" @if($obj->byself == 1) checked @endif>
					<label for="byself-1">是</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="byself-2" value="0" name="byself" @if($obj->byself == 0) checked @endif>
					<label for="byself-2">否</label>
				</div>
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
				<button type="button" class="btn btn-danger radius" id="admin-return" onclick="message_send('发送私信','/{{config('base.admin')}}/message/message_send_add/{{$obj->uid}}/{{$table}}/{{$obj->id}}/2/产业资讯/{{$obj->created_at}}','500','250')"><i class="icon-ok"></i> 退回通知</button>
			</div>
			@endif
		</div>
	</form>
</article>

@include('Admin.common._footer')

<!--请在下方写此页面业务相关的脚本-->
<style>
	.uploader-list-container .uplodeimg{margin: 10px auto 5px;display: inherit;width: 130px;height: 130px;}
	.uploader-list-container .uplodeMask,.uploader-list-container .ac{text-align: center;}
</style>

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
	layer_show(title,url,w,h);
}

function keyword(key) {
	var keywords = $("#keywords").val();
    var sear1 = new RegExp(',+'+key+',{0}');
    var sear2 = new RegExp(',{0}'+key+',?');
    var sear3 = new RegExp(',{0}'+key+',{0}');
    if(sear1.test(keywords)){
        keywords = keywords.replace(sear1,'');
        $("#keywords").val(keywords+','+key);
    }else if(sear2.test(keywords)){
        keywords = keywords.replace(sear2,'');
        $("#keywords").val(keywords+','+key);
	}else{
        if (keywords.length >=1){
            $("#keywords").val(keywords+','+key);
        }else{
            $("#keywords").val(key);
        }
	}
}

$(function(){
	$("#key_all a").attr('href','javascript:;');

	$('.skin-minimal input').iCheck({
		checkboxClass: 'icheckbox-blue',
		radioClass: 'iradio-blue',
		increaseArea: '20%'
	});

    $(".textarea").Huitextarealength({
        minlength:10,
        maxlength:210
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
                url: '/{{config('base.admin')}}/news/news_edit/{{$obj->id}}', // 需要提交的 url
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

    var ue = UE.getEditor('content', {
        initialFrameWidth: '100%',
        initialFrameHeight: '400'
    });

});

</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>