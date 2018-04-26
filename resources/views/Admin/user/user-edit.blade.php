@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户名(username)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->username}}" placeholder="" id="username" name="username">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>用户等级(level_id)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<span class="select-box">
					<select name="level_id" class="select">
						<option value="">未选择</option>
						@foreach($level as $val)
							<option value="{{$val->id}}" @if($obj->level_id == $val->id) selected @endif>{{$val->title}}</option>
						@endforeach
					</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">持有种子(price)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->price}}" placeholder="" id="price" name="price">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">用户头像(image)：</label>
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
			<label class="form-label col-xs-4 col-sm-3">个人简介(brief)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea name="brief" cols="" rows="" class="textarea"  placeholder="说点什么...最少输入10个字符">{{$obj->brief}}</textarea>
				<p class="textarea-numberbar"></p>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">SKYPR(skype)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->skype}}" placeholder="" id="skype" name="skype">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">EMAIL(email)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->email}}" placeholder="" id="email" name="email">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">微信(wechat)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->wechat}}" placeholder="" id="wechat" name="wechat">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">QQ(qq)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->qq}}" placeholder="" id="qq" name="qq">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">从事工作(job)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->job}}" placeholder="" id="job" name="job">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">掌握资源(grasp)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->grasp}}" placeholder="" id="grasp" name="grasp">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">所在城市(city)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="{{$obj->city}}" placeholder="" id="city" name="city">
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
			<div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
				<input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
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

		var ajaxStatus=1;
		$("#form-admin").validate({
            /*        rules:{
                        cname:{
                            required:true,
                        },
                    },*/
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
				if(ajaxStatus==0){return false;}ajaxStatus=0;
                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: '/{{config('base.admin')}}/user/user_edit/{{$obj->id}}', // 需要提交的 url
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