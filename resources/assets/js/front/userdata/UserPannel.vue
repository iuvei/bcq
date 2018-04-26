<template>
<div v-if="show">
<Row type="flex" justify="space-between" :class-name="'login-panel'" v-if="user">
	<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
		<Row>							
			<Col :xs="{'span':5,'offset':3}" :sm="{'span':5,'offset':3}" :lg="{'span':5,'offset':3}">
				<div class='avatar-frame-new pointer'>
					<a v-bind:href="'/user/userzone/'+user.id" target="_blank">
						<img v-bind:src="user.image" onerror="this.src='/static/noimg.png'">
					</a>
				</div>
			</Col>
			<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'user-info'">
				<div class="user-name" v-bind:title="user.username">{{user.username}}</div>
				<div class="user-data">
					<Icon type="ios-color-filter-outline" size="14"></Icon>
					&nbsp{{user.price}}颗&nbsp&nbsp &nbsp&nbsp 
					<a href="/parts/Help#help" target="_blank"><Icon type="ios-help-outline" size="14" style="cursor: pointer;"></Icon></a>
				</div>
			</Col>
			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-question'">
				<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'my-question'">
					<div class="flag">我上传的</div>
					<div class="my-count pointer" @click="go('/userdata/MyData?type=my_upload');ChangePannel('my_upload')">{{upload}}</div>
				</Col>
				<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'my-answer'">
					<div class="flag">我下载的</div>
					<div class="my-count pointer" @click="go('/userdata/MyData?type=my_download');ChangePannel('my_download')">{{download}}</div>
				</Col>
			</Col>
		</Row>
	</Col>
</Row>
<Row type="flex" justify="space-between" :class-name="'no-login-panel'" v-else="user">
	<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
		<h2 class="panel-title">分享资源，促使产业进步</h2>
	</Col>
	<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'tx-top'">
		<p>还能赚菠菜种子</p>
	</Col>
	<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
		<Col  :xs="{'span':8,'offset':2}" :sm="{'span':8,'offset':2}" :lg="{'span':8,'offset':2}">
			<Button :class="'common-button2'" @click="go('/account?t=login')">登录</Button>
		</Col>
		<Col :xs="{'span':8,'offset':4}" :sm="{'span':8,'offset':4}" :lg="{'span':8,'offset':4}">
			<Button :class="'common-button2'" @click="go('/account?t=register')">注册</Button>
		</Col>
	</Col>
</Row>	
</div>
</template>

<script>
export default{
	mounted(){
		var v = this
		this.https.get('/front/mydata/get_count').then((r)=>{
			if (r.data.code == 1) {
				v.user = r.data.mydata.user
				v.download = r.data.mydata.download
				v.upload = r.data.mydata.upload
			}
			v.show = true
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			show:false,
			user:'',
			download:'',
			upload:''
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		ChangePannel(type){
			this.$emit('ChangePannel',type)
		}
	}	
}
</script>

<style lang="scss" scoped>
  * {
    box-sizing: border-box;
  }
  html,body {
    font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
  }
.user-info {
	padding: 10px 0 0 10px;
	.user-name {
		font-size: 18px;
		font-weight: bold;
		color: #333;
		padding-bottom: 5px;
	  overflow: hidden;
		text-overflow: ellipsis;
		-o-text-overflow:ellipsis;
		display: -webkit-box;
		-webkit-line-clamp: 1;
		-webkit-box-orient: vertical;
	}
  .user-data {
    font-size: 12px;
    color: #333;
    font-weight: 500;
    a {
      color: #333;
      cursor: pointer;
      vertical-align: middle;
      &:hover {
        color: #28b28a;
      }
    }
  }
}
.user-question{
	text-align: center;
	padding: 20px 0 0 0;
	.my-question {
		border-right: 1px solid #b5b5b5;
	}
	.my-count {
		padding-top: 15px;
		font-size: 40px;
		color: #498dce;
    font-weight: bold;
	}
}
.flag {
	font-size: 14px;
  color: #333;
}
.login-panel{
  margin-bottom:30px;
  padding: 0 30px 20px 30px;
  border: 1px dashed #e2e2e2;
  border-radius: 3px;
	background: #fbfbfb;
}				
.no-login-panel {
	margin-bottom:30px; 
	padding-bottom: 25px;
  border: 1px dashed #e2e2e2;
  border-radius: 3px;
	text-align: center;
	background: #fbfbfb;
}
.tx-top {
  padding: 15px 0 0 0;
  p {
    text-align: center;
    font-size: 14px;
    color: #333;
  }
}
.panel-col {
	padding-top: 25px;
}
.common-button2{
	border:1px solid #333333;
	font-size: 14px;
	padding-top: 0px!important;
	padding-bottom: 0px!important;		
	height: 35px!important;					
} 
.panel-title {
	font-size: 26px;
	color: #478dce;
  font-weight: 400;
}
</style>