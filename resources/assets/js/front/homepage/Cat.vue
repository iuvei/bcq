<template>
	<div id="cat">
		<ul class="cat">
			<li @click="changeCat('')" v-bind:class="{'active':active==''}">即时快讯</li>
			<li v-for="(cat,key) in cats" @click="changeCat('News',cat.id)" v-bind:class="{'active':active=='News-'+cat.id}">{{cat.cname}}</li>
			<li @click="changeCat('Platform')" v-bind:class="{'active':active=='Platform'}">代理招商</li>
			<li @click="changeCat('Business')" v-bind:class="{'active':active=='Business'}">供求商讯</li>
			<li @click="changeCat('Question')" v-bind:class="{'active':active=='Question'}">互动问答</li>
		</ul>
	</div>
</template>
<script type="text/javascript">
	export default{
		mounted(){
			var v= this
			v.https.get('/front/components/get_cats').then((r)=>{
				v.cats = r.data
			}).catch((e)=>{
				console.log(e)
			})
		},
		data(){
			return {
				active:'',
				cats:[],
				type:'',
				id:''
			}
		},
		methods:{
			changeCat(type,id = ''){
				if (this.type == type&&this.id == id&&type) {
					return false
				}
				this.type = type
				this.id = id
				if (type == 'News') {
					this.active = type + '-' + id
				}else{
					this.active = type
				}
				this.$emit('changeCat',{'type':type,'id':id})
			}
		}
	}
</script>
<style lang="scss" scoped>
#cat{
	padding-bottom: 20px;
	.cat{
		font-size: 16px;
		letter-spacing: 2px;
		li{
			padding: 10px 0 10px 0;
			text-align: center;
			cursor: pointer;
		}
		.active{
			background-color: #28b28a;
			border-radius: 3px;
			color: white;
		}
	}
}	
</style>