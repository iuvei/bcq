<template>
	<div id="hot-download" v-if="hot_download">
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a @click="go('/userdata/datalist')"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>	
        <Row>
        	<ul>
        		<li v-for="(item,key) in hot_download" :key="key" class="hot-download">
              <b class="record"></b>
              <span class="title">
                <a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank" v-bind:title="item.title">{{item.title}}</a>
              </span>
        		</li>
        	</ul>
        </Row>		
	</div>
</template>
<script>
	export default{
		props:['title'],
		mounted(){
			var v = this
			v.https.get('/front/components/get_hot_download').then((r)=>{
				v.hot_download = r.data
			}).catch((e)=>{
				console.log(e)
			})
		},
		data(){
			return {
				hot_download:''
			}
		}
	}
</script>
<style lang="scss" scoped>
#hot-download {
	margin-bottom: 20px;
	.hot-download {
		margin-top: 15px;
		a {
			font-size: 14px;
			color: #333;
			&:hover {
				color: #28b28a;
			}
		}
    .title {
      display: inline-block;
      vertical-align: middle;
      width: 300px;
      height: 20px;
      overflow: hidden;
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
	}
}
</style>