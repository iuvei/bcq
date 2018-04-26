<template>
<div id="question">
	<NavHeader></NavHeader>
	<div>
	<Row type="flex" justify="center">
		<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
				<BreadcrumbItem>互动</BreadcrumbItem>
				<BreadcrumbItem>问答</BreadcrumbItem>
			</Breadcrumb>
			<Row type="flex" justify="space-between">
				<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
					<div class="search">
						<Row type="flex" justify="center">
							<Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}">
								 <input class='search-frame button-height' placeholder="请输入您要查找的问题" v-model="keywords">
							</Col>
							<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
								<div class='search-button button-height' @click="search">
									<i class="icon icon-search2"></i>搜索
								</div>
							</Col>
						</Row>
					</div>
					<div class="content">
						<Tabs v-model="tab">
							<TabPane label="等我的回答" name="unsolved">
								<Row :class-name="'question-frame'" v-for="(item,key) in unsolved" :key="key">
									<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}">
										<div class="question_title">
											<a v-bind:href="'/questiondetail/' + item.id" target="_blank">{{item.title}}</a>
										</div>
										<div class="question_info">
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
												<span @click="get_collect(item.id,key,'unsolved')">
													<i class="icon icon-shoucang" v-bind:class="{'is_collect':item.is_collected}"></i>
													{{item.collection}}
												</span>
											</Col>
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'change-color'">
												<a v-bind:href="'/questiondetail/' + item.id" target="_blank" style="color:#999">
													<i class="icon icon-message3"></i>
													{{item.comments}}
												</a>
											</Col>
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
												<Icon type="ios-color-filter-outline" size="18" style="vertical-align: text-bottom;"></Icon>
												{{item.price}}
											</Col>
										</div>
									</Col>
									<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'answer-img'">
										<!--<a @click="go('/questiondetail/' + item.id)"><img src="static/answer1.png" alt="回答问题"></a>-->
										<Button :class="'common-button2'" @click="go('/questiondetail/' + item.id)">回答</Button>
									</Col>
								</Row>
								<Row v-if="!loading">
									<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
									<center>
										<Button :class="'load-more'" @click="get_more" v-if="more_unsolve">浏览更多</Button>
									</center>
									</Col>
								</Row>
								<Row v-if="loading">
									<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}"
											 :lg="{'	span':8,'offset':8}">
										<Spin fix>
											<Icon type="load-c" size=18 :class="'demo-spin-icon-load'"></Icon>
											<div>Loading</div>
										</Spin>
									</Col>
								</Row>
							</TabPane>
							<TabPane label="已采纳的问题" name="solved">
								<Row :class-name="'question-frame'" v-for="(item,key) in solved" :key="key">
									<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
									<div class="question_title">
										<a v-bind:href="'/questiondetail/' + item.id" target="_blank">{{item.title}}</a>
									</div>
									<div class="question_info">
										<Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class="'img-frame1'">
										<img src="/static/question_answer.png">
										</Col>
										<Col :class-name="'change-color best-answer'">
											<a v-bind:href="'/questiondetail/' + item.id" target="_blank" style="color:#999">{{item.best_answer}}</a>
										</Col>
									</div>
									</Col>
									<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
									<div class="publish-time">{{item.created_at}}</div>
									<div class="collection">
										<Button icon="star" class="collection-button" v-bind:class="{'collected':item.is_collected == 1}"
														@click="get_collect(item.id,key)"><font v-if="item.is_collected==1">已收藏</font><font v-else>收藏</font>
										</Button>
									</div>
									</Col>
								</Row>
								<Row v-if="!loading">
									<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
									<center>
										<Button :class="'load-more'" @click="get_more" v-if="more_solve">浏览更多</Button>
									</center>
									</Col>
								</Row>
								<Row v-if="loading">
									<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}"
											 :lg="{'	span':8,'offset':8}">
									<Spin fix>
										<Icon type="load-c" size=18 :class="'demo-spin-icon-load'"></Icon>
										<div>Loading</div>
									</Spin>
									</Col>
								</Row>
							</TabPane>
						</Tabs>
					</div>
			  </Col>
          <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
            <Button class="common-button3 free-question" @click="go('/newquestion')">免费提问</Button>
            <Row type="flex" justify="space-between" :class-name="'login-panel'" v-if="user">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
                <Row>
                  <Col :xs="{'span':5,'offset':3}" :sm="{'span':5,'offset':3}" :lg="{'span':5,'offset':3}">
                    <div class='avatar-frame-new pointer'>
                      <img v-bind:src="user.image" @click="go('/user/userzone/'+user.id)" onerror="this.src='/static/noimg.png'">
                    </div>
                  </Col>
                  <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'user-info'">
                    <div class="user-name" v-bind:title="user.username">{{user.username}}</div>
                    <div class="user-data">
                      <Icon type="ios-color-filter-outline" size="14"></Icon>
                      <b style="margin: 0 15px 0 2px;vertical-align: baseline;font-weight: normal;">{{user.price}}颗</b>
                      <a href="/parts/Help#help" target="_blank"><Icon type="ios-help-outline" size="14" style='cursor: pointer;'></Icon></a>
                    </div>
                  </Col>
                  <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-question'">
                    <Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'my-question'">
                      <div class="flag">我的提问</div>
                      <div class="my-count pointer" @click="go('/myquestion/question')">{{user.my_question}}</div>
                    </Col>
                    <Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'my-answer'">
                      <div class="flag">我的回答</div>
                      <div class="my-count pointer" @click="go('/myquestion/answer')">{{user.my_answer}}</div>
                    </Col>
                  </Col>
                </Row>
              </Col>
            </Row>
            <Row type="flex" justify="space-between" :class-name="'no-login-panel'" v-else="user">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
                <span class="panel-title">赠人玫瑰，手有余香</span>
              </Col>
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'tx-top'">
                还能赚菠菜种子
              </Col>
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'panel-col'">
                <Col  :xs="{'span':8,'offset':2}" :sm="{'span':8,'offset':2}" :lg="{'span':8,'offset':2}">
                  <Button :class="'common-button2'" @click="go('/account?t=login')">登录</Button>
                </Col>
                <Col :xs="{'span':8,'offset':4}" :sm="{'span':8,'offset':4}" :lg="{'span':8,'offset':4}">
                  <Button :class="'common-button2'" @click="go('/account?t=register')">注册</Button>
                </Col>
              </Col>
            </Row>
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
	</div>
	<FooterArea></FooterArea>
    <FloatSideBar></FloatSideBar>
    <AccountPannel ref="AccountPannel"></AccountPannel>
</div>
</template>

<script>
import PageRight from '../components/MainRight.vue';
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import AccountPannel from '../components/AccountPanel.vue';
export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar,AccountPannel},
	mounted(){
		document.title = '菠菜圈| 互动问答';
		var v = this;
		this.https.get('/front/question/render').then((r)=>{
			v.unsolved = r.data.getUnsolvedList;
			v.solved = r.data.getSolvedList;
			v.loading = false;
			v.ad_list = r.data.adsList;
			if (!v.user) {
				v.user = r.data.user;
			}
			if (v.user) {
				v.user['my_question'] = r.data.questionCount;
				v.user['my_answer'] = r.data.answerCount;				
			}
		}).catch((e)=>{
			console.log(e);
		});
		v.user = this.$store.state.user_info;
	},
	data(){
		return {
			page_id:14,
			ad_list:'',
			tab:'unsolved',
			unsolved:'',
			solved:'',
			loading:true,
			more_solve:true,
			more_unsolve:true,
			solved_page:1,
			unsolved_page:1,
			user:'',
			keywords:''

		}
	},
	methods:{
		go(path){
			this.$router.push(path);
		},
		to_login(){
			if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}			
		},
	    get_collect(id,key,type=''){//添加收藏
			if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}		    	
            var v = this;
            this.https.get('/common/add_collection',{
                params:{
                    cid : id,//该收藏模型的主键
                    model : 'Question'
                }
            }).then((r)=>{
                if (r.data.code == 0) {
                    v.$Message.error(r.data.msg);
                    return false;
                }
                if (type == 'unsolved') {
	                if (v.unsolved[key].is_collected == 1) {
		                v.unsolved[key].is_collected = 0
		                v.unsolved[key].collection--
		                v.$Message.success('取消收藏')
	                }else{
	                    v.unsolved[key].is_collected = 1
	                    v.unsolved[key].collection++
	                    v.$Message.success('已收藏')
	                } 
                }else{
	                if (v.solved[key].is_collected == 1) {
		                v.solved[key].is_collected = 0
		                v.$Message.success('取消收藏')
	                }else{
	                    v.solved[key].is_collected = 1
	                    v.$Message.success('已收藏')
	                }                	
                }
            }).catch((e)=>{   
                console.log(e)
            });
        },
        get_more(){
        	var v = this;
        	v.loading = true;
        	if (v.tab == 'solved') {
        		var page = v.solved_page;
        	}else{
        		var page = v.unsolved_page;
        	}
	        this.https.get('/front/question/get_more',{
	        	params:{
	        		page:page,
	        		type:v.tab
	        	}
	        }).then((r)=>{
	        	if (r.data.length > 0) {
		        	if (v.tab == 'solved') {
		        		v.solved = v.solved.concat(r.data);
		        		v.solved_page = v.solved_page + 1;
		        	}else{
		        		v.unsolved = v.unsolved.concat(r.data);
		        		v.unsolved_page = v.unsolved_page + 1;
		        	}        		
	        	}else{
	        		if (v.tab == 'solved') {
	        			v.more_solve = false;
	        		}else{
	        			v.more_unsolve = false;
	        		}
					v.$Message.warning('已无更多数据');	        		
	        	}
				v.loading = false;
			}).catch((e)=>{
				console.log(e);
			});
        },
        search(){
            var keywords = this.keywords.trim()
            if (!keywords) {
                this.$Message.warning('请输入搜索内容')
                return false
            }
            this.$router.push({ path: '/questionsearch', query: { keywords: keywords }})
        }        
	}
}
</script>

<style lang="scss" scoped>
  .icon {
    font-size: .3rem;
    font-style: normal;
    color: #999;
    &:hover, &:focus {
      color: #28b28a;
    }
  }
  .icon-shoucang {
    vertical-align: text-bottom;
  }
	.icon-search2 {
		font-size: .35rem;
		font-style: normal;
		color: #fff;
		vertical-align: text-bottom;
		&:hover, &:focus {
			color: #28b28a;
		}
	}
  html, body {
    font-family: "PingFang SC", "Helvetica Neue", Helvetica, "Hiragino Sans GB", "Microsoft YaHei", "微软雅黑", Arial, sans-serif;
  }
    .common-button3 {
      font-size: 18px;
      font-weight: bold;
      color: #fff;
      background: #28b28a;
      border: 1px solid #28b28a;
      width: 100%;
      border-radius: 3px;
      text-align: center;
      &:hover {
        color: #fff;
        background-color: #149f77;
        border-color: #149f77;
        transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
        transition-property: color, background-color, border;
        transition-duration: 0.2s, 0.2s, 0.2s;
        transition-timing-function: linear, linear, linear;
        transition-delay: initial, initial, initial;
      }
    }
	#question {
		.container {
			width: 1200px;
			min-height: 80vh;
      		margin: 20px auto;
			.button-height{
				height: 40px;
				line-height: 40px;
			}
			.question_title {
				width: 100%;
				height: 30px;
				line-height: 30px;
				font-size: 18px;
				color: #333;
				font-weight: bold;
				a {
					color: #333;
					display: block;
					overflow : hidden;
					text-overflow: ellipsis;
					-webkit-text-overflow: ellipsis;
					-moz-text-overflow: ellipsis;
					-ms-text-overflow: ellipsis;
					white-space: nowrap;
					-moz-white-space: nowrap;
					-webkit-white-space: nowrap;
					-o-white-space: nowrap;
					&:hover {
						color:#28b28a;
					}
				}
			}
			.question_info{
				padding-top: 20px;
				font-size: 12px;
				color: #666;
			}
			.img-frame1 {
				img {
					margin-top: 8px;
				}
			}
      .user-info {
        padding: 10px 0 0 10px;
        .user-name {
          font-size: 18px;
          font-weight: bold;
          color: #333;
          padding-bottom: 5px;
          overflow: hidden;
          text-overflow: ellipsis;
          -o-text-overflow:ellipsis;
          display: -webkit-box;
          -webkit-line-clamp: 1;
          -webkit-box-orient: vertical;
        }
        .user-data {
          font-size: 12px;
          color: #333;
          font-weight: 500;
          a {
            color: #333;
            cursor: pointer;
            vertical-align: middle;
            &:hover {
              color: #28b28a;
            }
          }
        }
      }
      .user-question{
        text-align: center;
        padding: 20px 0 0 0;
        .my-question {
          border-right: 1px solid #b5b5b5;
        }
        .my-count {
          padding-top: 15px;
          font-size: 40px;
          color: #498dce;
          font-weight: bold;
        }
      }
      .flag {
        font-size: 14px;
        color: #333;
      }
			.publish-time {
				font-size: 13px;
				color: #999;
				margin-top: 7px;
			}
			.best-answer {
				color: #666;
				margin-top: 5px;
				font-size: 14px;
				overflow: hidden;
        text-overflow: ellipsis;
        -o-text-overflow:ellipsis;
				-moz-text-overflow:ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
			}
			.collection-button {
				width: 80px;
				margin-top: 14px;
				margin-left: 25px;
				height: 30px !important;
        .ivu-icon-star {
          color: #666;
        }
			}
			.collected {
        color: #28b28a;
        border-color: #28b28a;
      }
			.page-left {
				.search {
					margin-top: 20px;
					width: 100%;
					.search-frame {
            width: 100%;
            border: 1px solid #e0e0e0;
						border-right: 0;
            padding-left: 5px;
            border-radius: 3px 0 0 3px;
						transition: color .3s;
						-webkit-transition: color .3s;
						-moz-transition: color .3s;
						-o-transition: color .3s;
						-ms-transition: color .3s;
						&:focus {
							border-color: #28b28a;
						}
          }
          .search-button {
            width: 100%;
            background-color: #28b28a;
            cursor: pointer;
            color: white;
            text-align: center;
            vertical-align: middle;
            letter-spacing: 4px;
            font-size: 16px;
            border-radius: 0 3px 3px 0;
            &:hover {
              background-color: #149f77;
            }
          }
				}
				.content {
					margin-top: 20px;
					.question-frame {
						position: relative;
            padding: 10px 0 10px 10px;
            border-bottom: 1px solid #f2f2f2;
            &:hover {
              background: #f2f2f2;
            }
						.answer-img {
							position: absolute;
							right: 10px;
							top: 50%;
							margin-top: -13px;
							/*a {*/
								/*display: block;*/
								/*text-align: center;*/
								/*width: 27px;*/
								/*height: 27px;*/
								/*img {*/
									/*width: 100%;*/
									/*height: 100%;*/
									/*vertical-align: middle;*/
								/*}*/
							/*}*/
							.common-button2 {
								font-size: 14px;
								color: #666;
								border: 1px solid #7c7c7c;
                width: 60px;
								height: 26px;
								/*width: 100%;*/
								line-height: 14px;
								border-radius: 3px;
								text-align: center;
								cursor: pointer;
								background: #fff;
								&:hover {
									color: #28b28a !important;
									border-color: #28b28a !important;
									transition: #28b28a .2s linear,background-color .2s linear,border-color .2s linear;
									transition-property: color, background-color, border-color;
									transition-duration: 0.2s, 0.2s, 0.2s;
									transition-timing-function: linear, linear, linear;
									transition-delay: initial, initial, initial;
								}
							}
						}
					}
				}

			}
			.page-right{
				.free-question{
					font-size: 16px;
					padding-top: 12px;
					padding-bottom: 12px;	
					margin-top: 10px;					 
				}
				.login-panel {
          margin: 30px 0;
          padding: 20px 30px 20px 30px;
          border: 1px dashed #e2e2e2;
          border-radius: 3px;
          background: #fbfbfb;
				}
        .no-login-panel {
					margin-bottom:30px; 
					margin-top: 25px;
					padding-bottom: 25px;
          background: #fbfbfb;
          border: 1px dashed #e2e2e2;
          border-radius: 3px;
          text-align: center;
					.panel-col {
						padding-top:25px;
						.common-button2 {
							font-size: 16px;
              color: #333;
              width: 115px;
              height: 36px;
              line-height: 16px;
							border: 1px solid #7c7c7c;
              text-align: center;
              background: #fff;
						} 
					}
					.panel-title {
						font-size: 32px;
						color: #478dce;
            font-weight: bold;
					}
          .tx-top {
            padding: 15px 0 0 0;
            p {
              text-align: center;
              font-size: 14px;
              color: #333;
              cursor: pointer;
            }
          }
				}
			}	
		}
	}
</style>