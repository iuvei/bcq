<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
    })

    function uplodeStart(e){
        $(e).attr("disabled","disabled").siblings(".uplodeMask").show();
    }
    function uplodeEnd(e){
        $(e).removeAttr("disabled").siblings(".uplodeMask").hide();
    }
    $(function(){
        var imagestatus = 1;
        $(":file[accept='image/*']").change(function(){
            if (imagestatus == 0) {
                return false;
            }
            imagestatus = 0;
            var self = $(this);
            //创建FormData对象
            var data = new FormData();
            // 判断是否有文件
            if($(this)[0].files.length == 0){
                return false;
            }

            //为FormData对象添加数据
            $.each($(this)[0].files, function(i, file){
                data.append('file', file);
            });

            uplodeStart(self);
            $.ajax({
                url:"/{{config('base.admin')}}/tools/file_upload",
                type:'POST',
                data:data,
                dataType:'json',
                cache: false,
                contentType: false,    // 告诉$不要去处理发送的数据
                processData: false,    // 告诉$不要去设置Content-Type请求头
                success:function(data){
                    if(data.code){
                        self.next(":hidden").val(data.path);
                        self.prev("img").attr("src",data.path).attr("onclick","").removeClass("pointer");
                        self.siblings(".editImg").show();
                    }else{
                        layer.msg(data.msg,{icon:5,time:3000});
                        self.val("");
                    }
                    imagestatus = 1;
                    uplodeEnd(self);
                },error:function (data) {
                    layer.msg(data.statusText,{icon:5,time:3000});
                    imagestatus = 1;
                }
            });
        });

        var filestatus = 1;
        $(":file[class='input-file']").change(function(){
            if (filestatus == 0) {
                return false;
            }
            filestatus = 0;
            var self = $(this);
            //创建FormData对象
            var data = new FormData();
            // 判断是否有文件
            if($(this)[0].files.length == 0){
                return false;
            }

            //为FormData对象添加数据
            $.each($(this)[0].files, function(i, file){
                data.append('file', file);
            });

            uplodeStart(self);

            $.ajax({
                url:"/{{config('base.admin')}}/tools/file_upload",
                type:'POST',
                data:data,
                dataType:'json',
                cache: false,
                contentType: false,    // 告诉$不要去处理发送的数据
                processData: false,    // 告诉$不要去设置Content-Type请求头
                success:function(data){
                    if(data.code){
                        self.siblings(":hidden[name^='file']").val(data.file_id).siblings(":hidden[name^='suffix']").val(self.val().replace(/.+\./,""));
                        layer.msg('上传成功!',{icon:6,time:3000});
                    }else{
                        layer.msg(data.msg,{icon:5,time:3000});
                        self.val('').siblings("input").each(function (a,b) {
                            $(b).val('');
                        });
                    }
                    filestatus = 1;
                    uplodeEnd(self);
                },error:function (data) {
                    layer.msg(data.statusText,{icon:5,time:3000});
                    self.val('').siblings("input").each(function (a,b) {
                        $(b).val('');
                    });
                    filestatus = 1;
                }
            });
            self.removeAttr('disabled');
        });
    });

    /*状态-批量操作*/
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
                    display = '禁用';
                    break;
                case 1:
                    message = '确认要启用吗？';
                    css = 'label-success';
                    display = '启用';
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

    /*批量添加-添加*/
    function data_insert(url){
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
            layer.msg('未选择数据!',{icon: 5,time:1000});
        }
    }

</script>