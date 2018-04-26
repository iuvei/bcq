<template>
<div id="hot-special" v-if="special.length">
    <div class="components-title">
        {{title}}
        <a v-bind:href="'/news/special'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
    </div>
    <div>
    	<ul class="special-list">
    		<li v-for="(item,key) in special" :key="key">
    			<p><span>{{key+1}}</span>&nbsp&nbsp&nbsp&nbsp<a :href="'/news/SpecialDetail/'+item.id" target="_blank">{{item.title}}</a></p>
    		</li>
    	</ul>
    </div>
</div>	
</template>
<script>
export default{
	props:['title'],
	mounted(){
	    var v = this;
	    this.https.get('/front/components/get_hot_special').then((r)=>{
	        v.special = r.data
	    }).catch((e)=>{   
	        console.log(e)
	    });
	},
	data(){
		return {
			special:''
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		}
	}
}
</script>
<style lang="scss" scoped>
#hot-special{
	padding-bottom: 50px;
	.special-list{
		li{
			padding:10px 10px 10px 0px;
			font-size: 14px;
			p{
				span{
					width: 20px;
					display: inline-block;
					background-color: #28b28a;
					color: white;
					text-align: center;
					border-radius: 3px;
					display: inline-block;			
				}		
				font-weight: bold;	
				overflow: hidden;
	            text-overflow: ellipsis;
	            -o-text-overflow:ellipsis;
	            display: -webkit-box;
	            -webkit-line-clamp: 1;
	            -webkit-box-orient: vertical;	
	            a{
	            	color: #333333;	
		            &:hover{
		            	color: #28b28a;
		            	cursor: pointer;
		            }		            	
	            }	
			}
		}
	}
}	
</style>