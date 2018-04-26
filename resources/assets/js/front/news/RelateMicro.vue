<template>
	<div id='relate-micro'>
		<ul class="micro-list" v-if="relate_list.length">
			<li class="title">其他微动态</li>
			<li v-for="(relate,key) in relate_list" :key="key">
				<a v-bind:href="'/news/micro?id='+relate.id" target="_blank"><p v-html="relate.content" class="line1"></p></a>
				<p class="time">{{relate.time}}</p>
			</li>
		</ul>
	</div>
</template>
<script>
	export default{
		props:['id'],
		data(){
			return {
				relate_list:[]
			}
		},
		mounted(){
			var v = this
			v.$nextTick(()=>{
				v.https.get('/front/micro/get_relate_micro',{
					params:{
						id:v.id
					}
				}).then((r)=>{
					v.relate_list = r.data
				}).catch((e)=>{
					console.log(e)
				})
			})
		}
	}
</script>
<style lang="scss" scoped>
#relate-micro{
	padding-bottom: 20px;
	.micro-list{
		font-size: 14px;
		color: #333;
		.title{
			font-weight: bold;
		}
		li{
			padding: 0 0 15px 0;
			.time{
				padding-top: 5px;
				font-size: 12px;
				color: #bbbbbb;
				font-weight: lighter;
			}
		}
		a{
			color: #333;
			&:hover{
				color: #28b28a;
			}
		}	
	}	
}
</style>