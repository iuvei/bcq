@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>企业名称(title)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->title}}" placeholder="" id="title" name="title">
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
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>接入平台(access)：</label>
			<input type="hidden" name='access' id="access">
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach(config('base.access') as $key => $val)
					<div class="check-box">
						<input type="checkbox" id="acc-{{$key}}" value="{{$key}}" name="acc" @if($obj->access & $key) checked @endif>
						<label for="acc-{{$key}}">{{$val}}</label>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>主营游戏(games)：</label>
			<input type="hidden" name='games' id="games">
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach(config('base.games') as $key => $val)
					<div class="check-box">
						<input type="checkbox" id="game-{{$key}}" value="{{$key}}" name="game" @if($obj->games & $key) checked @endif>
						<label for="game-{{$key}}">{{$val}}</label>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>地区(region)：</label>
			<input type="hidden" name='region' id="region">
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach(config('base.region') as $key => $val)
					<div class="check-box">
						<input type="radio" id="region-{{$key}}" value="{{$key}}" name="region" @if($obj->region == $key) checked @endif>
						<label for="region-{{$key}}">{{$val}}</label>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>简介(content)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea id="content" name="content" type="text/plain">{{$obj->content}}</textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网址1(url1)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->url1}}" placeholder="" id="url1" name="url1">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网址2(url2)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->url2}}" placeholder="" id="url2" name="url2">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网址3(url3)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->url3}}" placeholder="" id="url3" name="url3">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">网址4(url4)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->url4}}" placeholder="" id="url4" name="url4">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>总分(mark)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->mark}}" placeholder="" id="mark" name="mark">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评分1(mark1)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->mark1}}" placeholder="" id="mark1" name="mark1">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评分2(mark2)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->mark2}}" placeholder="" id="mark2" name="mark2">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评分3(mark3)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->mark3}}" placeholder="" id="mark3" name="mark3">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>评分4(mark4)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->mark4}}" placeholder="" id="mark4" name="mark4">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">LOGO(logo)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<div class="uploader-list-container">
					<img class="pointer uplodeimg" onclick="$(this).siblings(':file').click();" src="@if($obj->logo) {{$obj->logo}} @else /admin/image/cover.png @endif" title="点击上传图片" />
					<input type="file" class="hide" accept="image/*" />
					<input type="hidden" name="logo" id="logo" value="{{$obj->logo}}" />
					<div class="@if(!($obj->logo)) hide @endif editImg" onclick="$(this).siblings(':file').click();">编辑</div>
					<div class="uplodeMask hide">图片上传中，请稍后...</div>
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
			<div class="col-xs-8 col-sm-8 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
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
                var game_total = 0;
                $('input[name=game]').each(function() {
                    if ($(this).parent().hasClass('checked')) {
                        game_total = Number($(this).val())+game_total;
                    }
                });
                $("#games").val(game_total);

                var acc_total = 0;
                $('input[name=acc]').each(function() {
                    if ($(this).parent().hasClass('checked')) {
                        acc_total = Number($(this).val())+acc_total;
                    }
                });
                $("#access").val(acc_total);

                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: '/{{config('base.admin')}}/cash/cash_edit/{{$obj->id}}', // 需要提交的 url
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
            toolbars: [
                ['undo','redo','bold','indent','italic','underline','strikethrough','subscript','fontborder','superscript','pasteplain','selectall','preview' ]
            ],
            initialFrameWidth: '100%',
            initialFrameHeight: '400',
            enableContextMenu: false,
            pasteplain: true
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>