<template>
	<div id="income">
         <ul class="income">
            <li class="title">我的收益</li>
            <li class="mount line1"><b>￥</b>{{money}}</li>
            <li class="action pointer" @click="go('/user/userpage/8')" v-if="is_login">我要提成</li>
            <li class="action pointer" @click="go('/account')" v-else>登陆查看收益金额</li>            
        </ul>
	</div>
</template>
<script>
	export default{
		mounted(){
			var v = this
			v.https.get('/common/is_login').then((r)=>{
				if (r.data.code==1) {
					v.is_login = 1
					if (r.data.user_info.is_author == 1) {
						v.is_author = 1
						v.https.get('/front/components/get_income').then((r)=>{
							v.money = r.data
						}).catch((e)=>{
							console.log(e)
						})
					}
				}
			}).catch((e)=>{
				console.log(e)
			})
		},
		methods:{
			go(path){
				this.$router.push(path)
			}
		},
		data(){
			return {
				money:0,
				is_login:0,
				is_author:0
			}
		}
	}
</script>
<style lang="scss" scoped>
#income{
	padding-bottom: 20px;
	.income{
		border-top: 2px solid #28b28a;
		padding:15px 3px 15px 3px;
		background-color: #f7f7f7;
		.title{
			font-size: 18px;
			font-weight: bold;
			padding-left: 20px;
		}
		.mount{
			font-size: 42px;
			font-weight: bolder;
			color: #28b28a;
			text-align: center;
			padding-top: 10px;
			b{
				font-size: 26px;
			}
		}
		.action{
			font-size: 14px;
			color: #478dce;
			text-align: center;
			padding-top: 5px;
		}
	}	
}

</style>