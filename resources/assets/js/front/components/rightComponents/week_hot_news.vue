<!-- 一周热读 -->
<template>
<div id="week_hot_news" v-if="hot_week_news.length">
    <div class="components-title">
        {{title}}
        <a v-bind:href="'/news'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
    </div>
    <div>
    	<ul>
    		<li v-for="(item,key) in hot_week_news" :key="key" class="news">
    			<b class="record"></b>
    			<span class="title title-hidden">
    				<a :href="'/news/newspage/'+item.id" target="_blank">{{item.title}}</a>
    			</span>
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
	    this.https.get('/front/components/get_week_hot_news').then((r)=>{
	        v.hot_week_news = r.data
	    }).catch((e)=>{   
	        console.log(e)
	    });
	},
	data(){
		return {
			hot_week_news:''
		}
	},
    methods:{
        go: function (path) {
            var path = path;
            this.$router.push({path: path});
        }
    }
}
</script>
<style lang="scss" scoped>
	.news {
		padding-top: 15px;
		margin: 15px 0;
		height: 30px;
		font-size: 14px;
		color: #333;
		a {
			font-size: 14px;
			color: #333;
			&:hover{
				color: #28b28a;
			}
		}
		span {
			display: inline-block;
			vertical-align: middle;
		}
		.record {
      display: inline-block;
			width: 5px;
      height: 5px;
      background: #28b28a;
      border-radius: 50%;
      vertical-align: middle;
      margin-right: 10px;
		}
		.title{
			width: 90%;
		}
	}
</style>