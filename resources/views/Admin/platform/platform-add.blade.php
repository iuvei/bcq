@extends('Admin.common._meta')
@section('meta')
	<link href="/admin/lib/webuploader/0.1.5/webuploader.css" rel="stylesheet" type="text/css" />
@endsection
<body>
<article class="page-container">
	<form class="form form-horizontal" id="form-admin">
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>标题(title)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="title" name="title">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>选择作者(uid)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<span class="select-box">
					<select name="uid" class="select">
						<option value="">未选择</option>
						@foreach($author as $val)
							<option value="{{$val->id}}">{{$val->username}}</option>
						@endforeach
					</select>
				</span>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">排序值(sort)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="0" placeholder="" id="sort" name="sort">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">点赞量(top)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="0" placeholder="" id="top" name="top">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">浏览量(view)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="0" placeholder="" id="view" name="view">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">产品网址(url)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="url" name="url">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">产品图片(pic)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<div class="uploader-list-container">
					<input type="hidden" name="pic" id="pic" />
					<div class="queueList">
						<div id="dndArea" class="placeholder">
							<div id="filePicker-2"></div>
							<p>或将照片拖到这里，单次最多可选5张</p>
						</div>
					</div>
					<div class="statusBar" style="display:none;">
						<div class="progress"> <span class="text">0%</span> <span class="percentage"></span> </div>
						<div class="info"></div>
						<div class="btns">
							<div id="filePicker2"></div>
							<div class="resetBtn">重新上传</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">简介(brief)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="brief" name="brief">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>详情(content)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<textarea id="content" name="content" type="text/plain"></textarea>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">联系人(contactperson)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="contactperson" name="contactperson">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">电话(phone)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="phone" name="phone">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">SKYPE(skype)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="skype" name="skype">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">QQ(qq)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="qq" name="qq">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">微信(wechat)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="wechat" name="wechat">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">邮件(email)：</label>
			<div class="formControls col-xs-8 col-sm-8">
				<input type="text" class="input-text" value="" placeholder="" id="email" name="email">
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>主营游戏(games)：</label>
			<input type="hidden" name='games' id="games">
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach(config('base.games') as $key => $val)
					<div class="check-box">
						<input type="checkbox" id="game-{{$key}}" value="{{$key}}" name="game">
						<label for="game-{{$key}}">{{$val}}</label>
					</div>
				@endforeach
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>结算周期(settlement)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				@foreach(config('base.settlement') as $key => $val)
					<div class="radio-box">
						<input type="radio" id="settlement-{{$key}}" value="{{$key}}" name="settlement">
						<label for="settlement-{{$key}}">{{$val}}</label>
					</div>
				@endforeach
			</div>
		</div>
		@if($type == 1)
			<div class="row cl">
				<div class="Huialert Huialert-info text-c"><i class="Hui-iconfont">&#xe6a6;</i>以下为认证信息</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>认证(confirm)：</label>
				<div class="formControls col-xs-8 col-sm-8 skin-minimal">
					<div class="radio-box">
						<input type="radio" id="confirm-1" value="0" name="confirm" checked>
						<label for="confirm-1">否</label>
					</div>
					<div class="radio-box">
						<input type="radio" id="confirm-2" value="1" name="confirm">
						<label for="confirm-2">是</label>
					</div>
				</div>
			</div>

			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">有效期(validitytime)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<input type="text" onfocus="WdatePicker({dateFmt: 'yyyy-MM-dd 00:00:00'})" id="validitytime" name="validitytime" class="input-text Wdate" style="width:40%;">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">保证金(money)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<input type="text" class="input-text" value="0" placeholder="" id="money" name="money">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">平台名称(enterprise)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<input type="text" class="input-text" value="" placeholder="" id="enterprise" name="enterprise">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">平台LOGO(logo)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<div class="uploader-list-container">
						<img class="pointer uplodeimg" onclick="$(this).siblings(':file').click();" src="/admin/image/cover.png" title="点击上传图片" />
						<input type="file" style="display:none;" accept="image/*"/>
						<input type="hidden" name="logo" id="logo" />
						<div class="hide editImg" onclick="$(this).siblings(':file').click();">编辑</div>
						<div class="uplodeMask hide">图片上传中，请稍后...</div>
					</div>
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">年限(year)：</label>
				<div class="formControls col-xs-8 col-sm-8 skin-minimal">
					@foreach(config('base.year') as $key => $val)
						<div class="radio-box">
							<input type="radio" id="type-{{$key}}" value="{{$key}}" name="year">
							<label for="type-1">{{$val}}</label>
						</div>
					@endforeach
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">规模(scale)：</label>
				<div class="formControls col-xs-8 col-sm-8 skin-minimal">
					@foreach(config('base.scale') as $key => $val)
						<div class="radio-box">
							<input type="radio" id="scale-{{$key}}" value="{{$key}}" name="scale">
							<label for="scale-{{$key}}">{{$val}}</label>
						</div>
					@endforeach
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">认证人员(personnel)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<input type="text" class="input-text" value="" placeholder="" id="personnel" name="personnel">
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">持有认证(plate)：</label>
				<input type="hidden" name='plate' id="plate">
				<div class="formControls col-xs-8 col-sm-8 skin-minimal">
					@foreach(config('base.plate') as $key => $val)
						<div class="check-box">
							<input type="checkbox" id="pla-{{$key}}" value="{{$key}}" name="pla">
							<label for="pla-{{$key}}">{{$val['title']}}</label>
						</div>
					@endforeach
				</div>
			</div>
			<div class="row cl">
				<label class="form-label col-xs-4 col-sm-3">收费标准(rate)：</label>
				<div class="formControls col-xs-8 col-sm-8">
					<input type="text" class="input-text" value="0" placeholder="" id="rate" name="rate">
				</div>
			</div>
		@endif
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3">推荐(hot)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="hot-1" value="0" name="hot" checked>
					<label for="hot-1">否</label>
				</div>
				<div class="radio-box">
					<input type="radio" id="hot-2" value="1" name="hot">
					<label for="hot-2">是</label>
				</div>
			</div>
		</div>
		<div class="row cl">
			<label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>状态(status)：</label>
			<div class="formControls col-xs-8 col-sm-8 skin-minimal">
				<div class="radio-box">
					<input type="radio" id="status-1" value="1" name="status" checked>
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
			<div class="col-xs-8 col-sm-8 col-xs-offset-4 col-sm-offset-2">
				<button type="submit" class="btn btn-success radius" id="admin-role-save"><i class="icon-ok"></i> 确定</button>
			</div>
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
            var games_total = 0;
            $('input[name=game]').each(function() {
                if ($(this).parent().hasClass('checked')) {
                    games_total = Number($(this).val())+games_total;
                }
            });
            if (games_total){
                $("#games").val(games_total);
            }

            var plate_total = 0;
            $('input[name=pla]').each(function() {
                if ($(this).parent().hasClass('checked')) {
                    plate_total = Number($(this).val())+plate_total;
                }
            });
            $("#plate").val(plate_total);

            $(form).ajaxSubmit({
                type: 'post', // 提交方式 get/post
                url: '/{{config('base.admin')}}/platform/platform_add/{{$type}}', // 需要提交的 url
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

(function( $ ){
    // 当domReady的时候开始初始化
    $(function() {
        var $wrap = $('.uploader-list-container'),

            // 图片容器
            $queue = $( '<ul class="filelist"></ul>' )
                .appendTo( $wrap.find( '.queueList' ) ),

            // 状态栏，包括进度和控制按钮
            $statusBar = $wrap.find( '.statusBar' ),

            // 文件总体选择信息。
            $info = $statusBar.find( '.info' ),

            // 重新上传按钮
            $reUpload = $wrap.find( '.resetBtn' ),

            // 没选择文件之前的内容。
            $placeHolder = $wrap.find( '.placeholder' ),

            $progress = $statusBar.find( '.progress' ).hide(),

            // 添加的文件数量
            fileCount = 0,

            // 添加的文件总大小
            fileSize = 0,

            // 优化retina, 在retina下这个值是2
            ratio = window.devicePixelRatio || 1,

            // 缩略图大小
            thumbnailWidth = 110 * ratio,
            thumbnailHeight = 110 * ratio,

            // 可能有pedding, ready, uploading, confirm, done.
            state = 'pedding',

            // 所有文件的进度信息，key为file id
            percentages = {},
            // 判断浏览器是否支持图片的base64
            isSupportBase64 = ( function() {
                var data = new Image();
                var support = true;
                data.onload = data.onerror = function() {
                    if( this.width != 1 || this.height != 1 ) {
                        support = false;
                    }
                }
                data.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
                return support;
            } )(),

            // 检测是否已经安装flash，检测flash的版本
            flashVersion = ( function() {
                var version;

                try {
                    version = navigator.plugins[ 'Shockwave Flash' ];
                    version = version.description;
                } catch ( ex ) {
                    try {
                        version = new ActiveXObject('ShockwaveFlash.ShockwaveFlash')
                            .GetVariable('$version');
                    } catch ( ex2 ) {
                        version = '0.0';
                    }
                }
                version = version.match( /\d+/g );
                return parseFloat( version[ 0 ] + '.' + version[ 1 ], 10 );
            } )(),

            supportTransition = (function(){
                var s = document.createElement('p').style,
                    r = 'transition' in s ||
                        'WebkitTransition' in s ||
                        'MozTransition' in s ||
                        'msTransition' in s ||
                        'OTransition' in s;
                s = null;
                return r;
            })(),

            // WebUploader实例
            uploader;

        if ( !WebUploader.Uploader.support('flash') && WebUploader.browser.ie ) {

            // flash 安装了但是版本过低。
            if (flashVersion) {
                (function(container) {
                    window['expressinstallcallback'] = function( state ) {
                        switch(state) {
                            case 'Download.Cancelled':
                                alert('您取消了更新！')
                                break;

                            case 'Download.Failed':
                                alert('安装失败')
                                break;

                            default:
                                alert('安装已成功，请刷新！');
                                break;
                        }
                        delete window['expressinstallcallback'];
                    };

                    var swf = 'expressInstall.swf';
                    // insert flash object
                    var html = '<object type="application/' +
                        'x-shockwave-flash" data="' +  swf + '" ';

                    if (WebUploader.browser.ie) {
                        html += 'classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" ';
                    }

                    html += 'width="100%" height="100%" style="outline:0">'  +
                        '<param name="movie" value="' + swf + '" />' +
                        '<param name="wmode" value="transparent" />' +
                        '<param name="allowscriptaccess" value="always" />' +
                        '</object>';

                    container.html(html);

                })($wrap);

                // 压根就没有安转。
            } else {
                $wrap.html('<a href="http://www.adobe.com/go/getflashplayer" target="_blank" border="0"><img alt="get flash player" src="http://www.adobe.com/macromedia/style_guide/images/160x41_Get_Flash_Player.jpg" /></a>');
            }

            return;
        } else if (!WebUploader.Uploader.support()) {
            alert( 'Web Uploader 不支持您的浏览器！');
            return;
        }

        // 实例化
        uploader = WebUploader.create({
            auto: true,
            pick: {
                id: '#filePicker-2',
                label: '点击选择图片'
            },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            dnd: '#dndArea',
            paste: '#uploader',
            swf: '/admin/lib/webuploader/0.1.5/Uploader.swf',
            chunked: false,
            chunkSize: 512 * 1024,
            server: '/{{config('base.admin')}}/tools/file_upload',
            // runtimeOrder: 'flash',

             accept: {
                 title: 'Images',
                 extensions: 'gif,jpg,jpeg,bmp,png',
                 mimeTypes: 'image/*'
             },

            // 禁掉全局的拖拽功能。这样不会出现图片拖进页面的时候，把图片打开。
            disableGlobalDnd: true,
            fileNumLimit: 5,
            fileSizeLimit: 5 * 2 * 1024 * 1024,    // 5 M
            fileSingleSizeLimit: 10 * 1024 * 1024    // 50 M
        });

        // 拖拽时不接受 js, txt 文件。
        uploader.on( 'dndAccept', function( items ) {
            var denied = false,
                len = items.length,
                i = 0,
                // 修改js类型
                unAllowed = 'text/plain;application/javascript ';

            for ( ; i < len; i++ ) {
                // 如果在列表里面
                if ( ~unAllowed.indexOf( items[ i ].type ) ) {
                    denied = true;
                    break;
                }
            }

            return !denied;
        });

//        uploader.on('dialogOpen', function() {
//            console.log('here');
//        });

        // uploader.on('filesQueued', function() {
        //     uploader.sort(function( a, b ) {
        //         if ( a.name < b.name )
        //           return -1;
        //         if ( a.name > b.name )
        //           return 1;
        //         return 0;
        //     });
        // });

        // 添加“添加文件”的按钮，
        uploader.addButton({
            id: '#filePicker2',
            label: '继续添加'
        });

        uploader.on('ready', function() {
            window.uploader = uploader;
        });

        // 文件上传成功，给item添加成功class, 用样式标记上传成功。
        uploader.on( 'uploadSuccess', function( file,data ) {
            $('#'+file.id).attr('imgsrc',data.path);
//            //var fileList = $.parseJSON(callBack);//转换为json对象
//            var hash = file.__hash || (file.__hash = hashString( file.name + file.size + file.lastModifiedDate ));
//
//            file_list_existence[hash] = true;
            var pic = $('#pic').val();
            if (pic) {
                pic = pic+',"'+data.path+'"';
            }else{
                pic = '"'+data.path+'"';
            }
            $('#pic').val(pic);
            $( '#'+file.id ).addClass('upload-state-success');
        });



        // 文件上传失败，显示上传出错。
        uploader.on( 'uploadError', function( file,data ) {
            $( '#'+file.id ).addClass('upload-state-error').find(".state").text("上传出错");
        });


        // 当有文件添加进来时执行，负责view的创建
        function addFile( file ) {
            var $li = $( '<li id="' + file.id + '">' +
                '<p class="title">' + file.name + '</p>' +
                '<p class="imgWrap"></p>'+
                '<p class="progress"><span></span></p>' +
                '</li>' ),

                $btns = $('<div class="file-panel">' +
                    '<span class="cancel">删除</span>' +
                    '<span class="rotateRight">向右旋转</span>' +
                    '<span class="rotateLeft">向左旋转</span></div>').appendTo( $li ),
                $prgress = $li.find('p.progress span'),
                $wrap = $li.find( 'p.imgWrap' ),
                $info = $('<p class="error"></p>'),

                showError = function( code ) {
                    switch( code ) {
                        case 'exceed_size':
                            text = '文件大小超出';
                            break;

                        case 'interrupt':
                            text = '上传暂停';
                            break;

                        default:
                            text = '上传失败，请重试';
                            break;
                    }

                    $info.text( text ).appendTo( $li );
                };

            if ( file.getStatus() === 'invalid' ) {
                showError( file.statusText );
            } else {
                // @todo lazyload
                $wrap.text( '预览中' );
                uploader.makeThumb( file, function( error, src ) {
                    var img;

                    if ( error ) {
                        $wrap.text( '不能预览' );
                        return;
                    }

                    if( isSupportBase64 ) {
                        img = $('<img src="'+src+'">');
                        $wrap.empty().append( img );
                    } else {
                        $.ajax('/admin/lib/webuploader/0.1.5/server/preview.php', {
                            method: 'POST',
                            data: src,
                            dataType:'json'
                        }).done(function( response ) {
                            if (response.result) {
                                img = $('<img src="'+response.result+'">');
                                $wrap.empty().append( img );
                            } else {
                                $wrap.text("预览出错");
                            }
                        });
                    }
                }, thumbnailWidth, thumbnailHeight );

                percentages[ file.id ] = [ file.size, 0 ];
                file.rotation = 0;
            }

            file.on('statuschange', function( cur, prev ) {
                if ( prev === 'progress' ) {
                    $prgress.hide().width(0);
                } else if ( prev === 'queued' ) {
                    $li.off( 'mouseenter mouseleave' );
                    $btns.remove();
                }

                // 成功
                if ( cur === 'error' || cur === 'invalid' ) {
                    showError( file.statusText );
                    percentages[ file.id ][ 1 ] = 1;
                } else if ( cur === 'interrupt' ) {
                    showError( 'interrupt' );
                } else if ( cur === 'queued' ) {
                    percentages[ file.id ][ 1 ] = 0;
                } else if ( cur === 'progress' ) {
                    $info.remove();
                    $prgress.css('display', 'block');
                } else if ( cur === 'complete' ) {
                    $li.append( '<span class="success"></span>' );
                }

                $li.removeClass( 'state-' + prev ).addClass( 'state-' + cur );
            });

            $li.on( 'mouseenter', function() {
                $btns.stop().animate({height: 30});
            });

            $li.on( 'mouseleave', function() {
                $btns.stop().animate({height: 0});
            });

            $btns.on( 'click', 'span', function() {
                var index = $(this).index(),
                    deg;

                switch ( index ) {
                    case 0:
                        uploader.removeFile( file );
                        return;

                    case 1:
                        file.rotation += 90;
                        break;

                    case 2:
                        file.rotation -= 90;
                        break;
                }

                if ( supportTransition ) {
                    deg = 'rotate(' + file.rotation + 'deg)';
                    $wrap.css({
                        '-webkit-transform': deg,
                        '-mos-transform': deg,
                        '-o-transform': deg,
                        'transform': deg
                    });
                } else {
                    $wrap.css( 'filter', 'progid:DXImageTransform.Microsoft.BasicImage(rotation='+ (~~((file.rotation/90)%4 + 4)%4) +')');
                    // use jquery animate to rotation
                    // $({
                    //     rotation: rotation
                    // }).animate({
                    //     rotation: file.rotation
                    // }, {
                    //     easing: 'linear',
                    //     step: function( now ) {
                    //         now = now * Math.PI / 180;

                    //         var cos = Math.cos( now ),
                    //             sin = Math.sin( now );

                    //         $wrap.css( 'filter', "progid:DXImageTransform.Microsoft.Matrix(M11=" + cos + ",M12=" + (-sin) + ",M21=" + sin + ",M22=" + cos + ",SizingMethod='auto expand')");
                    //     }
                    // });
                }


            });

            $li.appendTo( $queue );
        }

        // 负责view的销毁
        function removeFile( file ) {
            var $li = $('#'+file.id);

            delete percentages[ file.id ];
            updateTotalProgress();
            $li.off().find('.file-panel').off().end().remove();
        }

        function updateTotalProgress() {
            var loaded = 0,
                total = 0,
                spans = $progress.children(),
                percent;

            $.each( percentages, function( k, v ) {
                total += v[ 0 ];
                loaded += v[ 0 ] * v[ 1 ];
            } );

            percent = total ? loaded / total : 0;


            spans.eq( 0 ).text( Math.round( percent * 100 ) + '%' );
            spans.eq( 1 ).css( 'width', Math.round( percent * 100 ) + '%' );
            updateStatus();
        }

        function updateStatus() {
            var text = '', stats;

            if ( state === 'ready' ) {
                text = '选中' + fileCount + '张图片，共' +
                    WebUploader.formatSize( fileSize ) + '。';
            } else if ( state === 'confirm' ) {
                stats = uploader.getStats();
                if ( stats.uploadFailNum ) {
                    text = '已成功上传' + stats.successNum+ '张照片，'+
                        stats.uploadFailNum + '张照片上传失败，<a class="retry" href="javascript:;">重新上传</a>失败图片'
                }

            } else {
                stats = uploader.getStats();
                text = '共' + fileCount + '张（' +
                    WebUploader.formatSize( fileSize )  +
                    '），已上传' + stats.successNum + '张';

                if ( stats.uploadFailNum ) {
                    text += '，失败' + stats.uploadFailNum + '张';
                }
            }

            $info.html( text );
        }

        function setState( val ) {
            var file, stats;

            if ( val === state ) {
                return;
            }

            /*$reUpload.removeClass( 'state-' + state );
            $reUpload.addClass( 'state-' + val );*/
            state = val;

            switch ( state ) {
                case 'pedding':
                    $placeHolder.removeClass( 'element-invisible' );
                    $queue.hide();
                    $statusBar.addClass( 'element-invisible' );
                    uploader.refresh();
                    break;

                case 'ready':
                    $placeHolder.addClass( 'element-invisible' );
                    $( '#filePicker2' ).removeClass( 'element-invisible');
                    $queue.show();
                    $statusBar.removeClass('element-invisible');
                    uploader.refresh();
                    break;

                case 'uploading':
                    $( '#filePicker2' ).addClass( 'element-invisible' );
                    $progress.show();
                    /*$upload.text( '暂停上传' );*/
                    break;

                case 'paused':
                    $progress.show();
                    /*$upload.text( '继续上传' );*/
                    break;

                case 'confirm':
                    $progress.hide();
                    $( '#filePicker2' ).removeClass( 'element-invisible' );
                    /*$upload.text( '开始上传' );*/

                    stats = uploader.getStats();
                    if ( stats.successNum && !stats.uploadFailNum ) {
                        setState( 'finish' );
                        return;
                    }
                    break;
                case 'finish':
                    stats = uploader.getStats();
                    if ( stats.successNum ) {
                    } else {
                        // 没有成功的图片，重设
                        state = 'done';
                        location.reload();
                    }
                    break;
            }

            updateStatus();
        }

        uploader.onUploadProgress = function( file, percentage ) {
            var $li = $('#'+file.id),
                $percent = $li.find('.progress span');

            $percent.css( 'width', percentage * 100 + '%' );
            percentages[ file.id ][ 1 ] = percentage;
            updateTotalProgress();
        };

        uploader.onFileQueued = function( file ) {
            fileCount++;
            fileSize += file.size;

            if ( fileCount === 1 ) {
                $placeHolder.addClass( 'element-invisible' );
                $statusBar.show();
            }

            addFile( file );
            setState( 'ready' );
            updateTotalProgress();
        };

        uploader.onFileDequeued = function( file ) {
            fileCount--;
            fileSize -= file.size;

            if ( !fileCount ) {
                setState( 'pedding' );
            }

            removeFile( file );
            updateTotalProgress();

        };

        uploader.on( 'all', function( type ) {
            var stats;
            switch( type ) {
                case 'uploadFinished':
                    setState( 'confirm' );
                    break;

                case 'startUpload':
                    setState( 'uploading' );
                    break;

                case 'stopUpload':
                    setState( 'paused' );
                    break;

            }
        });

        uploader.onError = function( code ) {
            switch(code){
                case "F_DUPLICATE":
                    layer.msg("上传文件重复");
                    break;
                case "Q_TYPE_DENIED":
                    layer.msg("请上传JPG、PNG、GIF、BMP格式文件");
                    break;
                case "F_EXCEED_SIZE":
                    layer.msg("文件大小超出限制");

                    break;
                case "Q_EXCEED_SIZE_LIMIT":
                    layer.msg("文件大小不能超过2M");

                    break;
                case "Q_EXCEED_NUM_LIMIT":
                    layer.msg("上传文件不能超过5张");

                default:
                    layer.msg("上传出错！请检查后重新上传！错误代码"+code);
            }
        };

        /*关闭上传框窗口后恢复上传框初始状态*/
        function closeUploader() {
            // 移除所有缩略图并将上传文件移出上传序列
            for (var i = 0; i < uploader.getFiles().length; i++) {
                // 将图片从上传序列移除
                uploader.removeFile(uploader.getFiles()[i]);
                //uploader.removeFile(uploader.getFiles()[i], true);
                //delete uploader.getFiles()[i];
                // 将图片从缩略图容器移除
                var $li = $('#' + uploader.getFiles()[i].id);
                $li.off().remove();
            }

            setState('pedding');

            // 重置文件总个数和总大小
            fileCount = 0;
            fileSize = 0;
            // 重置uploader，目前只重置了文件队列
			$('#pic').val('');
            uploader.reset();
            // 更新状态等，重新计算文件总个数和总大小
            updateStatus();
        }

        $reUpload.on('click', function() {
            closeUploader();
        });

        $info.on( 'click', '.retry', function() {
            uploader.retry();
        } );

        //$info.on( 'click', '.ignore', function() {

        //} );

        /*$upload.addClass( 'state-' + state );*/
        updateTotalProgress();
    });

})( jQuery );
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>