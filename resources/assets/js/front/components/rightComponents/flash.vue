<template>
<div id="flash" v-if="show_flash">
    <Row>
        <Col :xs="24" :sm="24" :lg="24">
            <div class="components-title">
                {{title}}
                <a @click="go('/7x24h')"><span><img src="/static/down_row.png" class="title-image"></span></a>
            </div>
        </Col>
    </Row>
    <Row>
        <Col :xs="24" :sm="24" :lg="24">
	        <div v-for="(item,key) in flash" :key="key">
	        	<div class="title">
	        		<p class="title-row">
	        			<Icon type="arrow-down-b" color="#28b28a" v-if="item.is_actve"></Icon>
	        			<Icon type="arrow-right-b" color="#28b28a" v-else="item.is_actve"></Icon>
	        		</p>
	        		<p class="title-text" @click="show_brief(item,$event)">{{item.title}}</p>
	        	</div>
	        	<div class="brief-frame" v-bind:class="{'brief-show':item.is_actve,'brief-hidden':!item.is_actve}">
	        		<div class="brief">{{item.brief}}</div>
	        	</div>
	        	<div class="time">{{item.time}}</div>
	        </div>
        </Col>    	
    </Row>
</div>
</template>
<script>
import 'animate.css';
export default{
	props:['title'],
	mounted(){
		var v = this
		v.https.get('/front/components/get_flash').then((r)=>{
			if (!r.data) {
				return false
			}
			v.show_flash = true
			v.flash = r.data
		}).catch((e)=>{
			console.log(e)
		}) 
	},
	data(){
		return {
			show_flash:false,
			flash:''
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		show_brief(item,event){
/*			var current_obj = event.currentTarget.parentNode.nextSibling.nextSibling
			console.log(current_obj.offsetHeight)*/
			item.is_actve==1?item.is_actve=0:item.is_actve=1
		}
	}
}
</script>
<style lang="scss" scoped>
#flash{
	padding-bottom: 50px;
	.title {
		font-size: 14px;
		padding-top:20px;
		padding-bottom: 10px;
		display: table;
		p{
			display: table-cell;
			vertical-align: top;
		}
		.title-row{
			width: 15px;
		}
		.title-text {
      font-size: 14px;
			color: #5d5d5d;
			padding-left: 5px;
			cursor: pointer;
			&:hover{
				color: #28b28a;
			}
		}
	}
	.brief-frame{
		padding-left: 20px;
 		height: auto; 
		overflow: hidden;
		.brief{
			border:1px solid #f2f2f2;
			padding: 10px 10px 15px 10px;
			font-size: 14px;
			color: #777777;
			letter-spacing: 1px;
		}
	}
	.brief-show{
		max-height: 500px;
		height: auto;
		transition: max-height 0.8s;
		-moz-transition: max-height 0.8s;		
		-webkit-transition: max-height 0.8s;	
		-o-transition: max-height 0.8s; 	
	}
	.brief-hidden{
		height: 0px;
		max-height: 0px;
		transition: max-height 0.8s;
		-moz-transition: max-height 0.8s;		
		-webkit-transition: max-height 0.8s;	
		-o-transition: max-height 0.8s; 
	}
	.time{
    font-size: 12px;
		padding-top: 10px;
		padding-left: 20px;
		color: #999;
	}
}	
</style>