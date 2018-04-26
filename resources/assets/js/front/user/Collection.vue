<template>
<div>
	<Tabs v-model="model">
	    <TabPane label="资讯" name="NewsCollection">
	    	<Row :class-name="'news-frame'" v-if="NewsCollection.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in NewsCollection"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span @click="go('/news/newspage/' + item.nid)">{{item.title}}</span>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'time'">{{item.updated_at}}
	    			</Col>
	    		</Col>
	    		<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'page-footer'">
	        		<Page :total="news_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
	        		</Page>
	        	</Col>	 
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_collection.png">
	    			</center>
	    			<div class="default-font">暂时没有收藏过任何资讯喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/news')">去逛逛</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>
	    </TabPane>
	    <TabPane label="数据报告" name="ReportCollection">
	    	<Row :class-name="'report-frame'" v-if="ReportCollection.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in ReportCollection"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span @click="go('/news/reportDetail/' + item.rid)">{{item.title}}</span>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'time'">{{item.updated_at}}
	    			</Col>
	    		</Col>	
	    		<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'page-footer'">
	        		<Page :total="report_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
	        		</Page>
	        	</Col>	    			    		    			
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_collection.png">
	    			</center>
	    			<div class="default-font">暂时没有收藏过任何数据报告喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/news/report')">去逛逛</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>	    	
	    </TabPane>
	    <TabPane label="供求商讯" name="PbCollection">
	    	<Row :class-name="'business-frame'"  v-if="PbCollection.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in PbCollection"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span @click="go('/trade/BusinessDetail/' + item.pbid)">{{item.title}}</span>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
	    			</Col>
	    			<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'cname'"><span>{{item.category.cname}}</span>
	    			</Col>	    			
	    			<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'time'">{{item.updated_at}}
	    			</Col>	    			
	    		</Col>	
    			<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'page-footer'">
        			<Page :total="buiness_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
        			</Page>
        		</Col>		    		
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_collection.png">
	    			</center>
	    			<div class="default-font">暂时没有收藏过任何商讯喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/trade/business')">去逛逛</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>	    	
	    </TabPane>
	    <TabPane label="问答" name="QuestionCollection">
	    	<Row :class-name="'question-frame'"  v-if="QuestionCollection.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in QuestionCollection"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span @click="go('/questiondetail/' + item.qid)">{{item.title}}</span>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.describe}}
	    			</Col>
	    			<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'comment'">回答数量：{{item.comment}}
	    			</Col>	    			
	    			<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'time'">{{item.updated_at}}
	    			</Col>	    			
	    		</Col>	
    			<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'page-footer'">
        			<Page :total="question_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
        			</Page>
        		</Col>		    		    			
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_collection.png">
	    			</center>
	    			<div class="default-font">暂时没有收藏过任何问答喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/questionpage')">去逛逛</Button>
		    			</div>
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
		var v = this
		v.https.get('/front/user_collection/render').then((r)=>{
			v.NewsCollection = r.data.NewsCollection['list']
			v.news_count = r.data.NewsCollection['count']
			v.PbCollection = r.data.PbCollection['list']
			v.business_count = r.data.PbCollection['count']
			v.QuestionCollection = r.data.QuestionCollection['list']
			v.question_count = r.data.QuestionCollection['count']
			v.ReportCollection = r.data.ReportCollection['list']
			v.report_count = r.data.ReportCollection['count']
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			NewsCollection:'',
			news_page:1,
			news_count:0,
			PbCollection:'',
			buiness_count:0,
			pb_page:1,
			QuestionCollection:'',
			question_page:1,
			question_count:0,
			ReportCollection:'',
			report_count:0,
			report_page:1,
			model:'NewsCollection',
			limit:10
		} 
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		setMessagePage(page){
			var v = this;
			this.https.get('/front/user_collection/get_more',{
				params:{
					page:page-1,
					model:v.model
				}
			}).then((r)=>{
				if (v.model == 'NewsCollection') {
					v.NewsCollection = r.data['list']
					console.log(r.data['list']);
				}else if(v.model == 'PbCollection'){
					v.PbCollection = r.data['list']
				}else if(v.model == 'ReportCollection'){
					v.ReportCollection = r.data['list']
				}else{
					v.QuestionCollection = r.data['list']
				}
			}).catch((e)=>{
				console.log(e);
			});				
		}
	}
}
</script>
<style lang="scss" scoped>
.brief{
    overflow: hidden;
    text-overflow: ellipsis;
    -o-text-overflow:ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.page-footer{
	margin-top: 20px;
}
.news-frame{
	padding:0px 10px 20px 10px; 
	min-height: 700px; 	
	border-bottom: 1px solid #f2f2f2; 
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
		.time{
			padding-top: 10px;
			padding-right: 10px;
		}	
	}
}
.report-frame{
	padding:0px 10px 20px 10px; 
	min-height: 700px; 	
	border-bottom: 1px solid #f2f2f2; 
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
		.time{
			padding-top: 10px;
			padding-right: 10px;
		}	
	}	
}
.business-frame{
	padding:0px 10px 20px 10px; 
	min-height: 700px; 	
	border-bottom: 1px solid #f2f2f2; 
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
		.cname{
			padding-top: 10px;
			span{
				border:1px dashed #525976;
				background-color: #e8eff9;
				padding:3px 5px 3px 5px;
				border-radius: 3px; 
			}
		}
		.time{
			padding-top: 10px;
			padding-right: 10px;
			text-align: right;
		}	
	}		
}
.question-frame{
	padding:0px 10px 20px 10px;
	min-height: 700px; 
	border-bottom: 1px solid #f2f2f2; 
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
		.comment{
			padding-top: 10px;
		}
		.time{
			padding-top: 10px;
			padding-right: 10px;
			text-align: right;
		}	
	}		
}
</style>