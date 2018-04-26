<template>
<div id="publish">
	<Tabs v-model="model">
		<TabPane label="微动态" name="Micro">
	    	<Row :class-name="'frame'" v-if="MicroPublish.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in MicroPublish"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span class="pointer line1" @click="read('Micro',item.id);go('/news/micro?id=' + item.id)" v-if="item.status==1"
	    				v-html="item.content" style="font-weight:normal"></span>
	    				<span class="line1" v-else v-html="item.content" style="font-weight:normal"></span>
	    				<label class="unread" v-if="item.unread"><Icon type="record" color="red" size="2"></Icon>&nbsp&nbsp&nbsp有新评论,立即查看</label>
	    			</Col>
	    			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'time'">{{item.updated_at}}
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('Micro',item.id)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('Micro',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>
					<template v-for="(val,key) in status">
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'status'" v-if="item.status == key"><span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
						</Col>
					</template>
	    		</Col>
	    		<Col :class-name="'page-footer'"  :xs="24" :sm="24" :lg="24">
        			<Page :total="micro_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
        			</Page>
	        	</Col>
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过任何微动态喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/')">立即发布</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>	    	
		</TabPane>
	    <TabPane label="资讯" name="NewsPublish">
	    	<Row :class-name="'frame'" v-if="NewsPublish.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in NewsPublish"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span class="pointer" @click="read('news',item.id);go('/news/newspage/' + item.id)" v-if="item.status==1">{{item.title}}</span>
	    				<span v-else>{{item.title}}</span>
	    				<label class="unread" v-if="item.unread"><Icon type="record" color="red" size="2"></Icon>&nbsp&nbsp&nbsp有新评论,立即查看</label>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
	    			</Col>
	    			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'time'">{{item.updated_at}}
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('News',item.id)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('News',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>
					<template v-for="(val,key) in status">
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'status'" v-if="item.status == key"><span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
						</Col>
					</template>
	    		</Col>
	    		<Col :class-name="'page-footer'" :xs="24" :sm="24" :lg="24">
        			<Page :total="news_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
        			</Page>
	        	</Col>	 	    		
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过任何资讯喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/user/write')">立即发布</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>
	    </TabPane>
		<TabPane label="问答" name="QuestionPublish">
			<Row :class-name="'frame'" v-if="QuestionPublish.length">
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in QuestionPublish"  :class-name="'list-frame'" :key="key">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
					<span class="pointer" v-if="item.status==1" @click="read('question',item.id);go('/questiondetail/' + item.id)">{{item.title}}</span>
					<span v-else>{{item.title}}</span>					
					<label class="unread" v-if="item.unread"><Icon type="record" color="red" size="2"></Icon>&nbsp&nbsp&nbsp有新评论,立即查看</label>
					</Col>
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.describe}}
					</Col>
					<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'time'">{{item.updated_at}}
					</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('Question',item.id)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('Question',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>					
					<template v-for="(val,key) in status">
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'status'" v-if="item.status == key"><span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
						</Col>
					</template>
				</Col>
				<Col :class-name="'page-footer'" :xs="24" :sm="24" :lg="24">
					<Page :total="question_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
					</Page>
				</Col>
			</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过任何问答喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/newquestion')">立即发布</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>
		</TabPane>
		<TabPane label="产业资源下载" name="UserDataPublish">
	    	<Row :class-name="'frame'" v-if="UserDataPublish.length">
	    		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in UserDataPublish"  :class-name="'list-frame'" :key="key">
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
	    				<span class="pointer" v-if="item.status==1" @click="read('data',item.id);go('/userdata/UserDataDetail/' + item.id)">{{item.title}}</span>
	    				<span v-else>{{item.title}}</span>	
	    				<label class="unread" v-if="item.unread"><Icon type="record" color="red" size="2"></Icon>&nbsp&nbsp&nbsp有新评论,立即查看</label>
	    			</Col>
	    			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
	    			</Col>
	    			<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'time'">{{item.updated_at}}
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('UserData',item.id)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('UserData',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>		    			
					<template v-for="(val,key) in status">
						<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'status'" v-if="item.status == key"><span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
						</Col>
					</template>
	    		</Col>
	    		<Col :class-name="'page-footer'" :xs="24" :sm="24" :lg="24">
        			<Page :total="data_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
        			</Page>
	        	</Col>	    		
	    	</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过任何产业资源喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/userdata/UserDataUpload')">立即发布</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>
	    </TabPane>		
		<TabPane label="供求商讯" name="BusinessPublish">
			<Row :class-name="'frame'" v-if="BusinessPublish.length">
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in BusinessPublish"  :class-name="'list-frame'" :key="key">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
					<span class="pointer" v-if="item.status==1" @click="go('/trade/BusinessDetail/' + item.id)">{{item.title}}</span>
					<span v-else>{{item.title}}</span>
					</Col>
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
					</Col>
					<Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}" :class-name="'time'">{{item.updated_at}}
					</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('Business',item.id,item.type)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('Business',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>					
					<template v-for="(val,key1) in status">
						<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'status'" v-if="item.status == key1">
						<span class="pointer" v-if="item.status==1">
							<tag v-if="item.flush==1">今日已擦亮</tag>
							<tag color="#28b28a" v-else><span class="pointer" @click="flushOrder('Business',item.id,key)">擦亮</span></tag>
						</span>
							</span>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
							
						</Col>
					</template>
				</Col>
				<Col :class-name="'page-footer'" :xs="24" :sm="24" :lg="24">
					<Page :total="business_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
					</Page>
				</Col>
			</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过任何供求商讯喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/trade/Publish')">立即发布</Button>
		    			</div>
	    			</center>
	    		</Col>	
	    	</Row>
		</TabPane>
		<TabPane label="代理招商" name="PlatformPublish">
			<Row :class-name="'frame'" v-if="BusinessPublish.length">
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in PlatformPublish"  :class-name="'list-frame'" :key="key">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'title'">
					<span class="pointer" v-if="item.status==1" @click="go('/trade/PlatformDetail/' + item.id)">{{item.title}}</span>
					<span v-else>{{item.title}}</span>	
					</Col>
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'brief'">{{item.brief}}
					</Col>
					<Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}" :class-name="'time'">{{item.updated_at}}
					</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status==-2" @click="edit('Platform',item.id,item.type)"><Icon type="edit" size="14"></Icon>&nbsp&nbsp编辑</span>
	    			</Col>
	    			<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'time'">
	    				<span class="pointer" v-if="item.status" @click="go_trash('Platform',item.id,key)"><Icon type="trash-b" size="14"></Icon>&nbsp&nbsp删除</span>
	    			</Col>					
					<template v-for="(val,key1) in status">
						<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'status'" v-if="item.status == key1">
						<span  v-if="item.status==1">
							<tag v-if="item.flush==1">今日已擦亮</tag>
							<tag color="#28b28a" v-else><label class="pointer" @click="flushOrder('Platform',item.id,key)">擦亮</label></tag>
						</span>
							&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<span :class="{'t-s':item.status,'f-s':!item.status||item.status==-2}">{{val}}</span>
							
						</Col>
					</template>
				</Col>
				<Col :class-name="'page-footer'" :xs="24" :sm="24" :lg="24">
					<Page :total="platform_count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
					</Page>
				</Col>				
			</Row>
	    	<Row v-else :class-name="'default-frame'">   
	    		<Col :xs="24" :sm="24" :lg="24">
	    			<center>
	    				<img src="/static/no_news.png">
	    			</center>
	    			<div class="default-font">暂时没有发布过代理招商喔~</div>
	    			<center>
		    			<div class="button-frame">
		    				<Button class="common-button3" @click="go('/trade/Publish')">立即发布</Button>
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
		v.https.get('/front/user_publish/render').then((r)=>{

            v.MicroPublish = r.data.MicroPublish['list'];
            v.micro_count = r.data.MicroPublish['count'];			

            v.NewsPublish = r.data.NewsPublish['list'];
            v.news_count = r.data.NewsPublish['count'];

            v.QuestionPublish = r.data.QuestionPublish['list'];
            v.question_count = r.data.QuestionPublish['count'];

            v.BusinessPublish = r.data.BusinessPublish['list'];
            v.business_count = r.data.BusinessPublish['count'];

            v.PlatformPublish = r.data.PlatformPublish['list'];
            v.platform_count = r.data.PlatformPublish['count'];

            v.UserDataPublish = r.data.UserDataPublish['list'];
            v.data_count = r.data.UserDataPublish['count'];

		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
            MicroPublish:'',
			micro_page:1,
            micro_count:0,

            NewsPublish:'',
			news_page:1,
            news_count:0,

            QuestionPublish:'',
            question_page:1,
            question_count:0,

            BusinessPublish:'',
            business_page:1,
            business_count:0,

            PlatformPublish:'',
            platform_page:1,
            platform_count:0,

            UserDataPublish:'',
            data_page:1,
            data_count:0,

			model:'Micro',
			limit:10,
			status:{
                0: '审核中',1: '已发布','-2':'退回通知'
			},
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		read(model,id){
			this.https.get('/common/change_read_status?status=0&model='+model+'&id='+id)
		},
		setMessagePage(page){
			var v = this;
			this.https.get('/front/user_publish/get_more',{
				params:{
					page:page-1,
					model:v.model
				}
			}).then((r)=>{
				if (v.model == 'NewsPublish') {
					v.NewsPublish = r.data['list']
				}else if(v.model == 'QuestionPublish'){
					v.QuestionPublish = r.data['list']
				}else if(v.model == 'BusinessPublish'){
					v.BusinessPublish = r.data['list']
				}else if(v.model == 'PlatformPublish'){
					v.PlatformPublish = r.data['list']
				}else if(v.model == 'UserDataPublish'){
					v.UserDataPublish = r.data['list']
				}else{
					v.MicroPublish = r.data['list']
				}
			}).catch((e)=>{
				console.log(e);
			});				
		},
		flushOrder(type,id,key){
			if (type=='Business') {
				this.BusinessPublish[key].flush = 1
			}else{
				this.PlatformPublish[key].flush = 1
			}
			this.https.get('/common/flush_trade_order',{
				params:{
					type:type,
					id:id
				}
			})
		},
		edit(model,id,type){
			var v = this
            this.$Modal.confirm({
                title: '页面跳转提示',
                content: '<p>您即将跳转到编辑页面，是否继续？</p>',
                onOk: () => {
                	if (model == 'News') {
                    	v.go('/user/write')
                	}else if(model == 'UserData'){
                		v.go('/userdata/UserDataUpload?id='+id)
                	}else if(model == 'Question'){
                		v.go('/newquestion?id='+id)
                	}else if(model == 'Business'){
                		if (type == 1) {
                			v.go('/trade/PubBusiness_fwgys?id='+id)
                		}else{
                			v.go('/trade/PubBusiness_qgxqf?id='+id)
                		}
                	}else if(model == 'Platform'){
                		if (type == 1) {
                			v.go('/trade/PubPlatform_pingtai?id='+id)
                		}else{
                			v.go('/trade/PubPlatform_daili?id='+id)
                		}
                	}else if (model == 'Micro') {
						v.go('/news/micro?id='+id)
                	}
                }
            });
		},
		go_trash(model,id,key){
			var v = this
            this.$Modal.confirm({
                title: '删除确认',
                content: '<p>删除内容不可恢复，确认您删除？</p>',
                onOk: () => {
                    v.https.get('/front/user_publish/delete',{
                    	params:{
                    		model:model,
                    		id:id
                    	}
                    }).then((r)=>{
                    	if (r.data.code == 1) {
                    		if (model == 'News') {
                    			v.NewsPublish.splice(key,1)
                    		}else if(model == 'Question'){
                    			v.QuestionPublish.splice(key,1)                    			
                    		}else if(model == 'UserData'){
                    			v.UserDataPublish.splice(key,1)
                    		}else if(model == 'Business'){
                    			v.BusinessPublish.splice(key,1)
                    		}else if(model == 'Platform'){
                    			v.PlatformPublish.splice(key,1)
                    		}else if(model == 'Micro'){
                    			v.MicroPublish.splice(key,1)
                    		}
                    	}else{
                    		v.$Message.error(r.data.msg)
                    	}
                    }).catch((e)=>{
                    	console.log(e)
                    })
                }
            });
		}
	}
}
</script>
<style lang="scss" scoped>
	#publish{
		.unread{
			margin-left:20px;
			font-size: 10px;
			color: silver; 
			font-weight: lighter;
		}
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
			text-align: center;
		}
		.frame{
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
						&:hover{
							color: #28b28a;
						}
					}
				}
				.time{
					padding-top: 10px;
					padding-right: 10px;
				}
				.status{
					padding-top: 10px;
					padding-right: 10px;
					text-align: right;
					.t-s{
						color: #28b28a;
					}
					.f-s{
						color: #FA0100;
					}
				}
			}	
		}
	}


</style>