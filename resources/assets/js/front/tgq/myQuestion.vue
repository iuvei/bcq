<template>
	<div id="question">
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
            	<!--<div class="bread">-->
					<!--<div class="bread-text"><a href="/">首页</a>  > 互动 > 问答</div>-->
				<!--</div>-->

                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>互动</BreadcrumbItem>
                    <BreadcrumbItem to="/questionpage">问答</BreadcrumbItem>
                    <BreadcrumbItem>我的问答</BreadcrumbItem>
                </Breadcrumb>

				<Row type="flex" justify="space-between">
            	<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
					<div class="content">
					    <Tabs v-model="tab">
					        <TabPane label="我的提问" name="question">
				        		<Row :class-name="'question-frame'" v-for="(item,key) in question" :key="key">
					        		<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
					  					<div class="question_title">
					  						<span class="change-color" @click="go('/questiondetail/' + item.id)">{{item.title}}</span></div>
					  					<div class="question_info">
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="android-star-outline" size="12"></Icon>
					  							{{item.collection}}
					  						</Col>
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="chatbox-working" size="12"></Icon>
					  							{{item.comment}}
					  						</Col>
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="ios-color-filter-outline" size="12"></Icon>
					  							{{item.price}}
					  						</Col>
					  					</div>					  						
					        		</Col>
					        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
					        			<div class="publish-time">{{item.created_at}}</div>
					        			<div class="trash">
											<span @click="go_trash(key)">
												<Icon type="trash-a" size="20"></Icon>
											</span>
                    					</div>
					        		</Col>
				        		</Row>			        		
							    <Row v-if="!loading">
							        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
							            <center>
							                <Button class="load-more" @click="get_more('question')"  v-if="more_question">浏览更多</Button>
							            </center>
							        </Col>
							    </Row>	
							    <Row v-if="loading">
					            	<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'	span':8,'offset':8}">
					            	    <Spin fix>
					            	        <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
					            	        <div>Loading</div>
					            	    </Spin>
					            	</Col>
				        		</Row>
					        </TabPane>					    	
					        <TabPane label="我的回答" name="answer">
				        		<Row :class-name="'question-frame'" v-for="(item,key) in answer" :key="key">
					        		<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}">
					  					<div class="question_title">
					  						<span class="change-color" @click="go('/questiondetail/' + item.question.id)">{{item.question.title}}</span>
					  					</div>
					  					<div class="question_info">
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="android-star-outline" size="12"></Icon>
					  							{{item.question.collection}}
					  						</Col>
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="chatbox-working" size="12"></Icon>
					  							{{item.question.comments}}
					  						</Col>
					  						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
					  							<Icon type="ios-color-filter-outline" size="12"></Icon>
					  							{{item.question.price}}
					  						</Col>
					  					</div>
					        		</Col>
					        		<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'answer-img'">
					        			<Button class="common-button2" @click="go('/questiondetail/' + item.question.id)">查看<img src="/static/accept.png" v-if="item.accept==1"></Button>
					        		</Col>
				        		</Row>
				        		<Row v-if="!loading">
							        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
							            <center>
							                <Button class="load-more" @click="get_more('answer')"  v-if="more_answer">浏览更多</Button>
							            </center>
							        </Col>
							    </Row>	
							    <Row v-if="loading">
					            	<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'	span':8,'offset':8}">
					            	    <Spin fix>
					            	        <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
					            	        <div>Loading</div>
					            	    </Spin>
					            	</Col>
				        		</Row>
					        </TabPane>
					    </Tabs>
					</div>
				</Col>
				<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">	
					<PageRight :page-id="page_id">
                    </PageRight>
                    <div v-if="ad_list[1]" class="ad-zone">
                        <a :href="ad_list[1].url" :title="ad_list[1].title" target="_blank">
                            <div class="ad-frame" :title="ad_list[1].title">
                                <img :src="ad_list[1].image" class="ad-image-frame">
                                <span class="ad-tag">广告</span>
                                <div class="ad-title ad1-title">
                                    <div class="ad-title-content">
                                        {{ad_list[1].title}}
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div> 
				</Col>
			</Row>
            </Col>
		</Row>
		<FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>	
	</div>
</template>
<script>
import PageRight from '../components/MainRight.vue';
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar},
	mounted(){
        document.title = '菠菜圈| 我的问答';
		this.tab = this.$route.params.type
		var v = this;
		this.get_more('question');
		this.get_more('answer');		
	},
	data(){
		return {
			page_id:14,
			ad_list:'',
			tab:'',
			question:[],
			answer:[],
			loading:true,
			more_question:true,
			more_answer:true,
			question_page:0,
			answer_page:0,
			question_key:''
		}
	},
	methods:{
		go_trash(key) {
			this.question_key = key
            this.$Modal.confirm({
                title: '注意：',
                content: '<p style="font-size:14px">删除提问  <label style="color:red">'+this.question[key].title+'</label></p>',
                onOk: () => {
                	this.delete_question()
                }
            });
        },
		go(path){
			this.$router.push(path);
		},
		delete_question(){
			var v = this
			var qid = v.question[v.question_key].id
	        this.https.get('/front/question_details/delete_question',{
	        	params:{
	        		qid:qid
	        	}
	        }).then((r)=>{
	        	if (r.data.code==1) {
	        		v.$Message.success(r.data.msg)
	        		v.question.splice(v.question_key,1)
	        	}else{
	        		v.$Message.error(r.data.msg)
	        	}
			}).catch((e)=>{
				console.log(e);
			});			
		},
        get_more(tab){
        	var v = this;
        	v.loading = true;
        	if (tab == 'question') {
        		var page = v.question_page;
        	}else{
        		var page = v.answer_page;
        	}
	        this.https.get('/front/question_details/user_questions',{
	        	params:{
	        		page:page,
	        		type:tab
	        	}
	        }).then((r)=>{
	        	if (r.data.length > 0) {
		        	if (tab == 'question') {
		        		v.question = v.question.concat(r.data);
		        		v.question_page = v.question_page + 1;
		        	}else{
		        		v.answer = v.answer.concat(r.data);
		        		v.answer_page = v.answer_page + 1;
		        	}        		
	        	}else{
	        		if (tab == 'question') {
	        			v.more_question = false;
	        		}else{
	        			v.more_answer = false;
	        		}   		
	        	}
				v.loading = false;
			}).catch((e)=>{
				console.log(e);
			});
        }
	}
}
</script>
<style lang="scss" scoped>
	#question{
		.container{
			width:1200px;
			min-height:10rem;
            margin: 20px auto;
			.button-height{
				height: 40px;
				line-height: 40px;
			}
			.question_title{
				font-size: 18px;
				color: #333333;
				cursor: pointer;
			}
			.question_info{
				padding-top: 20px;
				font-size: 12px;
				color:#b8b8b8;
			}
			.img-frame1{
				img{
					margin-top: 8px;
				}
			}
			.user-info{
				padding: 10px 0px 0px 10px;
				.user-name{
					font-size: 16px;
					font-weight: bold;
					padding-bottom: 5px;
				}
			}
			.user-question{
				text-align: center;
				padding: 20px 0px 0px 0px;
				.my-question{
					border-right: 1px solid #ebebeb;
				}
				.my-count{
					padding-top:15px;
					font-size: 30px;
					color: #498dce;
				}
			}
			.publish-time{
				color:#b8b8b8;
			}
			.best-answer{
				margin-top: 5px;
				font-size: 14px;
				overflow: hidden;
	            text-overflow: ellipsis;
	            -o-text-overflow:ellipsis;
	            display: -webkit-box;
	            -webkit-line-clamp: 1;
	            -webkit-box-orient: vertical;
			}
			.trash{
				padding-top:20px;
				padding-left:80px;
				color:#b8b8b8;	
				&:hover{
					cursor: pointer;
					color: #28b28a;
				}
			}

			.collected{
                color: #27b48a;
                border-color: #27b48a;
            }
			.page-left{
				.search{
					margin-top: 20px;
					width: 100%;
					.search-frame{
		                width: 100%;
		                border: 1px solid #28b28a;   
		                padding-left: 5px; 
		                border-radius: 3px 0px 0px 3px;
		            }
		            .search-button{
		                width: 100%;
		                background-color: #28b28a;
		                cursor: pointer;
		                color: white;
		                text-align: center;
		                vertical-align: middle;
		                letter-spacing: 4px;
		                font-size:16px; 
		                border-radius: 0px 3px 3px 0px;
		                &:hover{
		                    background-color:#53caa4;
		                }
		            }
				}
				.content{
					margin-top: 20px;
					.question-frame{
						.answer-img{
							.common-button2{
								margin-top: 20px;
								height: 30px!important;
								position: relative;
								img{
									width: 80px;
									position: absolute;
									left: -200px;
									top: -20px;
								}						
							}
						}
						&:hover{
							background-color: #f2f2f2;
						}
						padding: 10px 0px 10px 5px; 
						border-bottom: 1px solid #f2f2f2;
					}
				}

			}
			.page-right{
				.login-panel{
					margin-top: 25px;
					padding: 20px 30px 20px 30px;  
					border-bottom: 1px dashed gray;
					border-top: 1px dashed silver;
					background-color: #fbfbfb;						
					.img-frame{
						position: relative;
						width: 100%;
						height: 0px;
						padding-top: 100%;					
						img{
							position: absolute;
							border-radius: 50%;
							top: 0px;
							left: 0px;
							width: 100%;
							height: 100%;
						}
					}
				}				
			}	
		}
	}
</style>