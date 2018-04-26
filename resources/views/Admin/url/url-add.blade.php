@include('Admin.common._meta')
<body>
<article class="page-container">
  <form action="" method="post" class="form form-horizontal" id="form-admin">
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>网址标题(title)：</label>
      <div class="formControls col-xs-8 col-sm-8">
        <input type="text" class="input-text" value="" placeholder="" id="title" name="title">
      </div>
    </div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>排序(sort)：</label>
      <div class="formControls col-xs-8 col-sm-8">
        <input type="text" class="input-text" value="0" placeholder="" id="sort" name="sort">
      </div>
    </div>

    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>网址(url)：</label>
      <div class="formControls col-xs-8 col-sm-8">
        <input type="text" class="input-text" value="" placeholder="" id="url" name="url">
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-3">网址分类(ucid)：</label>
      <div class="formControls col-xs-8 col-sm-8">
				<span class="select-box">
					<select name="ucid" class="select">
						<option value="">未选择</option>
                      @foreach($category as $val)
                        <option value="{{$val->id}}">{{$val->cname}}</option>
                      @endforeach
					</select>
				</span>
      </div>
    </div>
    <div class="row cl">
      <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态(status)：</label>
      <div class="formControls col-xs-8 col-sm-8 skin-minimal">
        <div class="radio-box">
          <input type="radio" id="status-1" value="1" name="status">
          <label for="status-1">启用</label>
        </div>
        <div class="radio-box">
          <input type="radio" id="status-2" value="0" name="status">
          <label for="status-2">禁用</label>
        </div>
        <div class="radio-box">
          <input type="radio" id="status-3" value="-1" name="status">
          <label for="status-3">删除</label>
        </div>
      </div>
    </div>
    <div class="row cl">
      <div class="Huialert Huialert-danger hide" id="form_msg"></div>
    </div>
    <div class="row cl">
      <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
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

        var ajaxStatus=1;
        $("#form-admin").validate({
            rules:{
                title:{
                    required:true,
                },
                min:{
                    required:true,
                    number:true,
                },
                max:{
                    required:true,
                    number:true,
                },
            },
            onkeyup:false,
            focusCleanup:true,
            success:"valid",
            submitHandler:function(form){
				if(ajaxStatus==0){return false;}ajaxStatus=0;
                $(form).ajaxSubmit({
                    type: 'post', // 提交方式 get/post
                    url: '/{{config('base.admin')}}/url/url_add', // 需要提交的 url
                    success: function(data) { // data 保存提交后返回的数据，一般为 json 数据
                        // 此处可对 data 作相关处理
                        $("#form_msg").hide().html('');
                        ajaxStatus=1;
                        var index = parent.layer.getFrameIndex(window.name);
                        window.parent.location.reload();
                        parent.layer.close(index);
                    },
                    error: function(data) {
                        console.log(data);
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