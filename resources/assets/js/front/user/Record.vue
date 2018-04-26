<template>
<div>
	<Tabs>
	    <TabPane label="记录" name="Record">
	    	<Row :class-name="'news-frame'">
	    		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'title-name'">时间</Col>
	    		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'title-name'">行为名称</Col>
	    		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'title-name'">获得/消耗种子</Col>
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in record"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'title'">
	    				<span @click="go('/news/newspage/' + item.nid)">{{item.created_at}}</span>
	    			</Col>
	    			<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'brief'">
	    				<span v-if="item.type==1" class="brief-title" @click="go('/userdata/UserDataDetail/'+item.tid)">用户资料上传/下载</span>
	    				<span v-if="item.type==2" class="brief-title" @click="go('/news/reportDetail/'+item.tid)">数据报告</span>
	    				<span v-if="item.type==3" class="brief-title" @click="go('/questiondetail/'+item.tid)">问答回答</span>
	    			</Col>
	    			<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'time'">
	    				{{item.price}}
	    			</Col>
	    		</Col>
	    	</Row>
	    	<Row>
	    		<Col :xs="{'span':16,'offset':4}" :sm="{'span':16,'offset':4}" :lg="{'span':16,'offset':4}" :class-name="'page-footer'">
	    		<center>
	        		<Page :total="count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
	        		</Page>
	        	</center>
	        	</Col>	    		
	    	</Row>
	    </TabPane>				        
	</Tabs>
</div>	
</template>
<script>
export default{
	mounted(){
		var page = this.page
		this.setMessagePage(page)
	},
	data(){
		return {
			record:'',
			page:1,
			count:0,
			limit:10
		} 
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		setMessagePage(page){
			var v = this;
			this.https.get('/front/user_center/user_record',{
				params:{
					page:page-1
				}
			}).then((r)=>{
				v.count = r.data.count
				v.record = r.data.record
			}).catch((e)=>{
				console.log(e);
			});				
		}
	}
}
</script>
<style lang="scss" scoped>
.page-footer{
	margin-top: 20px;
}
.news-frame{
	padding:0px 10px 20px 10px; 
	min-height: 700px; 	
	border-bottom: 1px solid #f2f2f2; 
	.title-name{
		padding:15px 0px 15px 0px;
		font-size: 16px;
		font-weight: bold;
	}
	.list-frame{
		padding:10px 5px 20px 5px; 
		&:hover{
			background-color: #f2f2f2; 
		}
		border-bottom: 1px solid #f2f2f2;
		.title{
			font-size: 16px;
			font-weight: bold;
			padding:10px 0px 10px 0px;
			span{
				cursor: pointer;
				&:hover{
					color: #28b28a;
				}
			}
		}	
		.brief{
			line-height: 44px;
			font-size: 14px;
			font-weight: bold;
			.brief-title{
				&:hover{
					color: #28b28a;
					cursor: pointer;
				}
			}
		}
		.time{
			padding-top: 10px;
			padding-right: 30px;
		}	
	}
}
</style>