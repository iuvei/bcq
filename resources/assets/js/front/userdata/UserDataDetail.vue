<template>
	<div id="user_data_detail">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">

				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem to="/userdata/datalist">产业资源下载</BreadcrumbItem>
					<BreadcrumbItem>产业资源详情</BreadcrumbItem>
				</Breadcrumb>

                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
						<Col  :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
							<Row  type="flex" justify="space-between" :class-name="'report-frame'">
								<Col :xs="{'span':13}" :sm="{'span':13}" :lg="{'span':13}" :class-name="'report-description'">
									<div class="report-title">
										{{user_data_detail.title}}
									</div>
									<div class="report-brief" v-html="user_data_detail.brief">
										
									</div>
								</Col>
								<Col :xs="{'span':10,'offset':1}" :sm="{'span':10,'offset':1}" :lg="{'span':10,'offset':1}">
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
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'userdata-deal'">
									<Row type="flex" align="middle">
										<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'report-info-frame'">
											<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'report-info'">
												<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
													{{user_data_detail.created_at}}
												</Col>
												<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
                                                    <i class="icon icon-eye1"></i>
													{{user_data_detail.view}}&nbsp&nbsp&nbsp
													<span class="shoucang-modify" @click="collection">
	                                                    <i class="icon icon-shoucang" v-bind:class="{'is_collect':user_data_detail.is_collected}"></i>
														{{user_data_detail.collection}}
													</span>
													&nbsp&nbsp&nbsp
													<a href="#comment" style="color:#999">
	                                                    <i class="icon icon-message3"></i>
														{{user_data_detail.comment}}
													</a>
													&nbsp&nbsp&nbsp
												</Col>
												<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
													<a v-bind:href="'/userdata/datalist?type='+user_data_detail.type_id" target="_blank">
														<span class="userdata-type pointer">{{user_data_detail.type}}</span>
													</a>
												</Col>
											</Col>
										</Col>
										<Col :xs="{'span':4,'offset':3}" :sm="{'span':4,'offset':3}" :lg="{'span':4,'offset':3}" :class-name="'download-count'">
											已被下载{{user_data_detail.down}}次								
										</Col>
										<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
											<Button class="download" @click="download_report">
												<span class="flag">立刻下载</span>
												<span class="price line1"><Icon type="ios-color-filter-outline"></Icon>&nbsp&nbsp{{user_data_detail.price}}</span>
											</Button>
										</Col>
									</Row>	
								</Col>
							</Row>
						</Col>
						<Col :class-name="'add-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<textarea class="comment-text" placeholder="随便说点什么吧...." v-model="comment"></textarea>
							</Col>
							<Col :xs="{'span':2,'offset':22}" :sm="{'span':2,'offset':22}" :lg="{'span':2,'offset':22}">
								<Button :disabled="!comment" class="submit-comment" v-bind:class="{'common-button':comment}"  @click="reply(1)">评论</Button>
							</Col>
						</Col>
						<Col :class-name="'all-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
							<Col>
								<label class="comment-title" id="comment">全部评论</label> &nbsp&nbsp&nbsp&nbsp&nbsp
								<label class="comment-count">{{user_data_detail.comment}}</label>
							</col>
							<Col :class-name="'comment-list'" v-for="(item,key) in user_data_detail.comment_list" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="key<=load" v-bind:class="{'first-comment':key==0}">
								<Col  :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'comment-list-left'">
									<div class="avatar-frame-new" @click="go('/user/userzone/' + item.user.id)">
										<img :src="item.user.image">	
									</div>
								</Col>
								<Col  :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}" :class-name="'comment-list-right'">
									<div class="comment-frame">
										<div class="comment-user">
											<span class="username">{{item.user.username}}
                        						<img src='/static/author_confirm.png' v-if="item.user.author_info&&item.user.author_info.status==1">
                        						<span class="comment-time">{{item.comment_time}}</span>
											</span><br>
											<span class="user-desc">{{item.user.desc}}</span>
										</div>
										<div class="comment-content">
											{{item.content}}
										</div>
										<div class="son-comment" v-if="item.son_comment.length">
											<div class="son-comment-frame">
												<div class="son-comment-zone">									
													<div class="son-comment-tag"></div>
													<div v-for="(son_comment,key) in item.son_comment" :key="key">
														<div class="comment-user">
															<span class="username">{{son_comment.user.username}}
															<img src='/static/author_confirm.png' v-if="son_comment.user.author_info&&son_comment.user.author_info.status==1">
															<span class="comment-time">{{son_comment.comment_time}}</span>
															</span><br>
															<label class="user-desc">{{son_comment.user.desc}}</label>
														</div>
														<div class="comment-content">
															{{son_comment.content}}
														</div>											
													</div>
												</div>
											</div>
										</div>
										<div class="comment-oper">
											<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">&nbsp</Col>
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
											&nbsp
												<span class='complaint' @click="complaint(item.id,key)">
													<Icon type="android-warning" size="16"></Icon>&nbsp举报</span>
											</Col>
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'reply'">
												<div @click="show_replay(item.id)">
													<i class="icon icon-message3"></i>
												</div>
											</Col  @click="reply">
											<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'top'">
												<div @click="top(item.id,key)">
													<Icon type="thumbsup" size="16"></Icon>&nbsp{{item.top}}
												</div>
											</Col>
										</div>	
									</div>
								</Col>	
								<div class="comment-reply" v-if="comment_id == item.id">
									<div>
										<textarea class="comment-text" :placeholder="'回复  ' + item.user.username + ' :'" v-model="reply_comment">			
										</textarea>
									</div>
									<div>
										<Col :xs="{'span':2,'offset':22}" :sm="{'span':2,'offset':22}" :lg="{'span':2,'offset':22}">
											<Button :disabled="!reply_comment" class="submit-comment" v-bind:class="{'common-button' :reply_comment}"  @click="reply(2,item.id)">评论</Button>
										</Col>
									</div>
								</div>							
							</Col>
						</Col>
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="user_data_detail.comment">
							<center>
								<div @click="load_mode" class="load-more-comment" v-if="has_more">查看更多评论</div>
							</center>
						</Col>
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-else="user_data_detail.comment" class="no-more-comment">
							<center>
								暂无评论
							</center>
						</Col>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
	                    <UserPannel :user="user_data_detail.user"></UserPannel>
	                    <PageRight :page-id="page_id">
	                   		
	                    </PageRight>  
	        			<div v-if="ad_list[2]" class="ad-zone">
						    <a :href="ad_list[2].url" :title="ad_list[2].title" target="_blank">
						        <div class="ad2-frame" :title="ad_list[2].title">
						            <img :src="ad_list[2].image" class="ad-image-frame">
						            <span class="ad-tag">广告</span>
						            <div class="ad-title ad1-title">
						                <div class="ad-title-content">
						                    {{ad_list[2].title}}
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
		<AccountPannel ref="AccountPannel" :fresh="fresh" :action="action" @collection="collection"></AccountPannel>
	</div>
</template>

<script>
import PageRight from '../components/MainRight.vue';	
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import UserPannel from '../components/UserPannel.vue';
import AccountPannel from '../components/AccountPanel.vue';
	export default{
		components: {NavHeader,FooterArea,FloatSideBar,PageRight,UserPannel,AccountPannel},
		data(){
			return {
				page_id:17,
				userdata_id:'',
				user_data_detail:'',
				ad_list:'',
				comment:'',
				comment_id:0,
				reply_comment:'',
				page:0,//加载评论的页数，一页十个
				load:10,
				has_more:true,
				action:'',
				fresh:0
			}
		},
		mounted(){
			document.title = '菠菜圈| 产业资源详情';
			var v = this;
			this.userdata_id = this.$route.params.userdata_id;
			this.https.get('/front/user_data_details/render',{
				params:{
					did:v.userdata_id
				}
			}).then((r)=>{
                if (r.data.user_data_details instanceof Array && r.data.user_data_details.length == 0){
                    v.$Message.warning('该信息未通过审核或已删除!');
                    setTimeout(function () {
                        v.$router.push('/userdata/datalist');
                    },500)
                }
				v.user_data_detail = r.data.user_data_details;
				v.ad_list = r.data.adList;
			}).catch((e)=>{
				console.log(e);
			});
		},
		methods:{
			go(path){
				this.$router.push(path)
			},
			load_mode(){
				this.page = this.page + 1;
				this.load = this.page*10 + this.load;
				if(this.user_data_detail.comment_list.length<=this.load){
					this.$Message.success('已加载全部评论');
					this.has_more = false;
				}
			},	
            show_replay(key){
            	if (this.comment_id) {
            		this.comment_id = 0;
            		this.reply_comment = '';
            	}else if (!this.comment_id) {        		
            		this.comment_id = key;
            	}
            },	
            reply(type,cid = ''){
            	if (!this.$store.state.user_info) {
		          this.fresh = 1
		          this.action = ''
		          this.$refs.AccountPannel.show()
		          return false
		        }  
				var v = this;
				if(type == 1){//一级评论
					var fid = '';
					var content = v.comment
				}
				if (type == 2) {//二级评论
					var fid = v.comment_id;
					var content = v.reply_comment					
				}
				this.https.get('/front/user_data_details/add_comment',{
					params:{
						did:v.userdata_id,
						fid:fid,
						content:content
					}
				}).then((r)=>{
					if (r.data.code == 1) {
						v.https.get('/common/change_read_status?status=1&model=data&id='+v.userdata_id)
						v.comment = '';
						v.reply_comment = '';
						v.$Message.success(r.data.msg);		
						this.https.get('/front/user_data_details/get_comment_list',{
							params:{
								did:v.userdata_id
							}
						}).then((r)=>{
								v.$set(v.user_data_detail,'comment_list',r.data);
								if (type == 1) {
									v.user_data_detail.comment = v.user_data_detail.comment + 1;
								}
							}).catch((e)=>{
							console.log(e);
						});
					}else{
						v.$Message.warning(r.data.msg);
					}
				}).catch((e)=>{
					console.log(e);
				});
            }, 
            collection(){
				if (!this.$store.state.user_info) {
					this.action = 'collection'
					this.fresh = 1
					this.$refs.AccountPannel.show()
					return false
				}	            	
            	var v = this;
  				this.https.get('/common/add_collection',{
  					params:{
  						cid:v.user_data_detail.id,
  						model:'UserData'
  					}
  				}).then((r)=>{
  					if (r.data.code == 1) {
	                  if (v.user_data_detail.collection==1) {
	                    v.$Message.success('已取消收藏');
	                    v.user_data_detail.collection = v.user_data_detail.collection - 1;
	                    v.user_data_detail.is_collected = 0;                      
	                  }else{
	                    v.$Message.success('已收藏');
	                    v.user_data_detail.collection = v.user_data_detail.collection + 1;
	                    v.user_data_detail.is_collected = 1;                    
	                  }
  					}
  				}).catch((e)=>{
  					console.log(e);
  				});
            },                       				
			download_report(key){
				if (!this.$store.state.user_info) {
					this.action = ''
					this.$refs.AccountPannel.show()
					return false
				}				
                var id = this.user_data_detail.id;
                var file = this.user_data_detail.file;
                var price = this.user_data_detail.price;
                var uid = this.user_data_detail.uid;
                var v = this;
                this.https.get('/common/download_test',{
                    params:{
                        price : price,
                        file : file,
                        did : id,
                        uid : uid,
                        type : 1
                    }
                }).then((r)=>{
                    if (r.data.code == 0) {
                        v.$Message.error(r.data.msg);
                        return false;
                    }else{
                        var down_href='/common/data_download?file=' + file;
                        v.download(down_href);
                        }
                }).catch((e)=>{   
                    console.log(e)
                });
            },
            download(url){
                var elemIF = document.createElement("iframe");
                elemIF.src = url;
                elemIF.style.display = "none";
                document.body.appendChild(elemIF);
            },
            complaint(cid,key){
            	var v = this;
				this.https.get('/front/user_data_details/add_complaint',{
					params:{
						cid:cid
					}
				}).then((r)=>{
					if(r.data.code == 1){
						v.$Message.success('举报成功');
					}
				}).catch((e)=>{
					console.log(e);
				});
            },            
            top(cid,key){
				var v = this;
				v.https.get('/common/flush_limit_by_ip',{params:{
            		type:'UserData',
            		id:cid
            	}}).then((r)=>{
            		if (r.data == 1) {
            			v.$Message.success('您已赞过该评论')
            			return false
            		}
					v.https.get('/front/user_data_details/add_comment_top',{
						params:{
							cid:cid
						}
					}).then((r)=>{
						v.user_data_detail.comment_list[key].top = v.user_data_detail.comment_list[key].top + 1;
					}).catch((e)=>{
						console.log(e);
					})
            	}).catch((e)=>{
            		console.log(e)
            	})   
            }
		}
	}
</script>

<style lang="scss" scoped>
	.icon-eye1 {
		vertical-align: middle;
	}
	.icon-message3 {
		vertical-align: middle;
	}
	.icon-answer {
		font-size: .4rem;
		vertical-align: middle;
	}
	#user_data_detail{
		.container{
			width: 1200px;
			min-height: 10rem;
            margin: 20px auto;
			.comment-text{
				padding:10px 5px;
				margin-top: 100px;
				border-radius: 3px;
				background-color: #f2f2f2;
                border: 1px solid #e0e0e0;
				min-height: 30px;
				width: 100%;
				font-size: 14px;
				&:focus{
					cursor: text;
					border-color: #53caa4; 
					transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
					background-color: #ffffff;			    
				}
			}
			.report-frame{
                padding-top: 10px;
				padding-bottom: 20px;
				border-bottom: 1px solid #f4f4f4;
				border-weight:lighter;
				.report-description{
					.report-title{
						font-size:24px;
						color: #333333; 
						/*padding-top: 20px;*/
						padding-bottom: 20px;
					}
					.report-brief{
						min-height: 100px;
						font-size: 14px;
					}
				}
				.userdata-deal{
					margin-top: 10px;
				}
				.report-info-frame{
					.report-keywords,.report-info{
						font-size: 12px;
						margin-top: 15px;
						color: #999;
						cursor: pointer;
						.userdata-type {
							padding: 5px 5px;
							border-radius: 3px;
							color: #0b74ff;
							background: #d9e9ff;
						}
					}
				}
				.download-count{
					font-size: 13px;
					text-align: center;
					color: #666;
				}
				.download{
					font-size: 16px;
					cursor: pointer;
					width: 100%;
					height: 50px;
					color: white;
					background-color: #27b48a;
					.flag{
						display: block;
					}
					.price{
						display: none;
					}
					&:hover{
						.flag{
							display: none;
						}
						.price{
							display: block;
						}						
					}
				}
			}
			.add-comment{
				padding-bottom: 50px;
				border-bottom: 1px solid #f4f4f4;
				border-weight:lighter;
			}
			.all-comment{
				margin-top: 20px;
				.comment-title{
					font-size:16px;
					font-weight: bold;

				}
				.comment-count{
					font-size:16px;
					color:gray;
					font-weight: 100;
				}
				.comment-list{
					margin-top: 20px;
					padding-top: 20px;
					border-top:1px dashed silver;
					display: block;
					.comment-list-left{
						display: block;
					}
					.comment-list-right{
						padding-left: 20px;
						.comment-user{
							.username{
								font-size: 14px;
								font-weight: bold;
							}
							.comment-time{
								font-weight: lighter;
								font-size: 12px;
								color: gray;
								margin-left: 10px;
							}
						}						
						.comment-frame{							
							.son-comment{
								.son-comment-frame{;
									display: block;
									.son-comment-zone{
										width: 100%;
										border-radius: 3px;
										position: relative;
										background-color: #f4f4f4;
										padding: 10px;
										.son-comment-tag{
											position: absolute;
											left: 30px;
											top: -10px;
										    width: 0;
										    height: 0;
										    border-right: 10px solid transparent;
										    border-bottom: 10px solid #f4f4f4;
										    border-left: 10px solid transparent;
										}
									}
								}
							}
							.comment-oper{
								padding-top: 20px;
								text-align: right;	
								color:#c2c2c2; 		
								font-size: 14px;					
								.complaint{
									display: none;
								}
								.top,.reply,.complaint{
									&:hover{
										color: #27b48a;
										cursor: pointer;
									}
								}
							}
							&:hover{
								.complaint{
									display: inline-block;
								}
							}						
						}
						.comment-content{
							padding: 5px 0 15px 0;
							font-size: 14px;
						}
					}
					.comment-reply{
						.comment-text{
							margin-top:20px;
						}
					}
				}
				.first-comment{
					border:0px;
				}				
			}
			.submit-comment{
				width: 100%;
				margin-top: 20px;
			}
		}
	}
</style>