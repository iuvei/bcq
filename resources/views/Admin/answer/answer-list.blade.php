@include('Admin.common._meta')
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 互动管理 <span class="c-gray en">&gt;</span> 回答列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="datastatus(1,'/{{config('base.admin')}}/answer/datastatus')" class="btn btn-success radius"><i class="Hui-iconfont">&#xe6e1;</i> 批量启用</a>
            <a href="javascript:;" onclick="datastatus(0,'/{{config('base.admin')}}/answer/datastatus')" class="btn btn-warning radius"><i class="Hui-iconfont">&#xe631;</i> 批量禁用</a>
            <a href="javascript:;" onclick="datastatus(-1,'/{{config('base.admin')}}/answer/datastatus')" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
            <a class="btn btn-primary radius" onclick="answer_add('添加回答','/{{config('base.admin')}}/answer/answer_add/{{$qid}}','1000','')" href="javascript:;"><i class="Hui-iconfont">&#xe600;</i> 添加回答</a>
            <a class="btn btn-primary radius" onclick="answer_adoption('/{{config('base.admin')}}/question/question_adoption/{{$qid}}')" href="javascript:;" style="background-color: #81F0ED;"><i class="Hui-iconfont">&#xe600;</i> 采纳</a>
        </span>
        <span class="r">共有数据：<strong id="total">{{count($object)}}</strong> 条</span>
    </div>
    <div class="mt-20">
        <table class="table table-border table-bordered table-bg table-hover table-sort table-responsive">
            <thead>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="80">用户名</th>
                <th width="80">排序</th>
                <th width="200">回答内容</th>
                <th width="120">发布状态</th>
                <th width="120">更新时间</th>
                <th width="70">状态</th>
                <th width="120">操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach($object as $key => $val)
                <tr class="text-c">
                    <td><input type="checkbox" value="{{$val['id']}}" linenum="{{$val['id']}}" name="id"></td>
                    <td>{{$val['user']['username']}}</td>
                    <td>{{$val['sort']}}</td>
                    <td>{{str_limit($val['content'],30,'...')}}</td>
                    <td>{{$val['created_at']}}</td>
                    <td>{{$val['updated_at']}}</td>
                    @switch($val['status'])
                        @case(0)
                        <td class="td-status"><span class="label label-defaunt radius">禁用</span></td>
                        @break

                        @case(1)
                        <td class="td-status"><span class="label label-success radius">启用</span></td>
                        @break

                        @default
                        <td class="td-status"><span class="label label-warning radius">未知</span></td>
                    @endswitch
                    <td class="f-14"><a title="编辑" href="javascript:;" onclick="answer_edit('编辑','/{{config('base.admin')}}/answer/answer_edit/{{$val['id']}}','1000','')" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a></td>
                </tr>
            @endforeach
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
    $('.table-sort').dataTable({
        "aaSorting": [[ 1, "desc" ]],//默认第几个排序
        "bStateSave": true,//状态保存
        "bAutoWidth": false,//自动宽度
        "pading":false,
        "aoColumnDefs": [
            //{"bVisible": false, "aTargets": [ 3 ]} //控制列的隐藏显示
            {"orderable":false,"aTargets":[0]}// 不参与排序的列
        ]
    });

    /*回答-添加*/
    function answer_add(title,url,w,h){
        layer_show(title,url,w,h);
    }

    /*回答-编辑*/
    function answer_edit(title,url,w,h){
        layer_show(title,url,w,h);
    }

    /*评论-列表*/
    function comment_list(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*回答-采纳*/
    function answer_adoption(url){
        var id_array=new Array();
        $('input[name="id"]:checked').each(function(){
            id_array.push($(this).val());//向数组中添加元素
        });
        if (id_array.length){
            if (id_array.length == 1){
                var _options={id:id_array[0]};
                layer.confirm('确认要采纳吗？',function(index){
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: _options,
                        dataType: 'json',
                        success: function(data){
                            if(data.code){
                                layer.msg('已采纳!',{icon: 6,time:1000});
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
                layer.msg('只能采纳一个答案!',{icon: 5,time:1000});
            }
        }else{
            layer.msg('未选择数据!',{icon: 5,time:1000});
        }
    }

</script>
</body>
</html>
