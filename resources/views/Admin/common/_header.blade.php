<header class="navbar-wrapper">
	<div class="navbar navbar-fixed-top">
		<div class="container-fluid cl"> <a class="logo navbar-logo f-l mr-10 hidden-xs" href="/{{config('base.admin')}}/index">菠菜圈管理系统</a>
			<span class="logo navbar-slogan f-l mr-10 hidden-xs">v2.0</span>
			<a aria-hidden="false" class="nav-toggle Hui-iconfont visible-xs" href="javascript:;">&#xe667;</a>
			<nav class="nav navbar-nav">
				<ul class="cl">
					<li class="dropDown dropDown_hover"><a href="javascript:;" class="dropDown_A"><i class="Hui-iconfont">&#xe600;</i> 新增 <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" onclick="layerAlert('添加新闻资讯','/{{config('base.admin')}}/news/news_add','1200','')"><i class="Hui-iconfont">&#xe616;</i> 资讯</a></li>
							<li><a href="javascript:;" onclick="layerAlert('添加产品资讯','/{{config('base.admin')}}/trends/trends_add','1200','')"><i class="Hui-iconfont">&#xe620;</i> 产品</a></li>
							<li><a href="javascript:;" onclick="layerAlert('添加用户','/{{config('base.admin')}}/user/user_add','','')"><i class="Hui-iconfont">&#xe60d;</i> 用户</a></li>
						</ul>
					<li class="navbar-levelone current"><a href="javascript:;">资讯</a></li>
					<li class="navbar-levelone"><a href="javascript:;">7*24小时快讯</a></li>
					<li class="navbar-levelone"><a href="javascript:;">资料</a></li>
					<li class="navbar-levelone"><a href="javascript:;">交易</a></li>
					<li class="navbar-levelone"><a href="javascript:;">服务</a></li>
					<li class="navbar-levelone"><a href="javascript:;">互动</a></li>
					<li class="navbar-levelone"><a href="javascript:;">用户管理</a></li>
					<li class="navbar-levelone"><a href="javascript:;">系统管理</a></li>
					</li>
				</ul>
			</nav>
			<nav id="Hui-userbar" class="nav navbar-nav navbar-userbar hidden-xs">
				<ul class="cl">
					<li>超级管理员</li>
					<li class="dropDown dropDown_hover">
						<a href="#" class="dropDown_A">{{\Auth::user()->name}} <i class="Hui-iconfont">&#xe6d5;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="/{{config('base.admin')}}/login">切换账户</a></li>
							<li><a href="/{{config('base.admin')}}/logout">退出</a></li>
						</ul>
					</li>
					<li id="Hui-msg"> <a href="javascript:;" title="消息" onclick="layerAlert('消息','/{{config('base.admin')}}/index/tips','1200','330')"><span class="badge badge-danger" id="review-total">0</span><i class="Hui-iconfont" style="font-size:18px">&#xe68a;</i></a> </li>
					<li id="Hui-skin" class="dropDown right dropDown_hover"> <a href="javascript:;" class="dropDown_A" title="换肤"><i class="Hui-iconfont" style="font-size:18px">&#xe62a;</i></a>
						<ul class="dropDown-menu menu radius box-shadow">
							<li><a href="javascript:;" data-val="default" title="默认（黑色）">默认（黑色）</a></li>
							<li><a href="javascript:;" data-val="blue" title="蓝色">蓝色</a></li>
							<li><a href="javascript:;" data-val="green" title="绿色">绿色</a></li>
							<li><a href="javascript:;" data-val="red" title="红色">红色</a></li>
							<li><a href="javascript:;" data-val="yellow" title="黄色">黄色</a></li>
							<li><a href="javascript:;" data-val="orange" title="橙色">橙色</a></li>
						</ul>
					</li>
				</ul>
			</nav>
		</div>
	</div>
</header>
<script type="text/javascript">
    function layerAlert(title,url,w,h){
        layer_show(title,url,w,h);
    }
</script>