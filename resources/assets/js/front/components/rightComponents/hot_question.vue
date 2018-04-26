<template>
<div id="hot-question">
    <div class="components-title">
        {{title}}
        <a @click="go('/questionpage')"><span><img src="/static/down_row.png" class="title-image"></span></a>
    </div>
    <div>
    	<ul>
    		<li v-for="(item,key) in question" :key="key" class="news">
          <b class="record"></b>
          <span class="title title-hidden">
            <a :href="'/questiondetail/'+item.id" target="_blank">{{item.title}}</a>
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
	    this.https.get('/front/components/get_hot_question').then((r)=>{
	        v.question = r.data
	    }).catch((e)=>{   
	        console.log(e)
	    });
	},
	data(){
		return {
			question:''
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
#hot-question {
	padding-bottom: 50px;
	ul {
		margin-top: 10px;
		list-style: none;
    li.news {
      padding-top: 15px;
      margin: 15px 0;
      height: 30px;
      font-size: 14px;
      color: #333;
      a {
        color: #333;
        font-size: 14px;
        &:hover {
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
      .title {
        width: 90%;
      }
		}
	}
}	
</style>