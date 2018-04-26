<template>
	<div id="report_detail">
    <NavHeader></NavHeader>
		<Row type="flex" justify="center">
			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
				<BreadcrumbItem>资讯</BreadcrumbItem>
				<BreadcrumbItem to="/news/report">数据报告</BreadcrumbItem>
				<BreadcrumbItem>数据报告详情</BreadcrumbItem>
			</Breadcrumb>

			<Row type="flex" justify="space-between">
				<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
				  <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
            <Row type="flex" justify="space-between" align="bottom" :class-name="'report-frame'">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'report-description'">
                <div class="report-title">
                  {{report_detail.title}}
                </div>
                <Row :class-name="'report-info-frame'">
                  <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                    <Row>
                      <Col :xs="{'span':11}" :sm="{'span':11}" :lg="{'span':11}" :class-name="'report-info'">
                        <span>{{report_detail.created_at}}</span>
                        <span><i class="icon icon-eye1"></i> {{report_detail.view}}</span>
                        <a href="#comment" style="color:#999">
                        	<span><i class="icon icon-message3"></i> {{report_detail.comment}}</span>
                    	</a>
                        <span><i class="icon icon-download"></i> {{report_detail.down}}</span>
                      </Col>
                      <Col :xs="{'span':11,'offset':2}" :sm="{'span':11,'offset':2}" :lg="{'span':11,'offset':2}"
                           :class-name="'btn-share'">
                        <ShareBtn></ShareBtn>
                      </Col>
                    </Row>
                  </Col>
                </Row>
                <div class="report-brief">
                  {{report_detail.brief}}
                </div>
                <div class="report-content" v-html="report_detail.content">

                </div>
              </Col>
            </Row>
				  </Col>
				<Col :class-name="'download-frame'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}" :class-name="'download-intro'">
				<Col :class-name="'download-title'">
				{{report_detail.title}}
        </Col>
				<Col :class-name="'download-brief'">
				{{report_detail.brief}}
        </Col>
				</Col>
				<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
				<div class="download-button-frame">
					<center class="report-download">
						<div class="report-suffix">
							<img src="/static/suffix_pdf1.png">
						</div>
						<Button type="ghost" class="button report-download-botton" icon="icon icon-download">下载</Button>
						<Button type="ghost" class="button report-price-botton" icon="ios-color-filter-outline"
										@click="download_report">{{report_detail.price}}
						</Button>
					</center>
				</div>
				</Col>
				</Col>
				<Col :class-name="'add-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				<textarea class="comment-text" placeholder="随便说点什么吧...." v-model="comment"></textarea>
				</Col>
				<Col :xs="{'span':2,'offset':22}" :sm="{'span':2,'offset':22}" :lg="{'span':2,'offset':22}">
				<Button :disabled="!comment" class="submit-comment" v-bind:class="{'common-button':comment}" @click="reply(1)">
					评论
				</Button>
				</Col>
				</Col>
				<Col :class-name="'all-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				<Col>
				<label class="comment-title" id="comment">全部评论</label>
				<label class="comment-count">{{report_detail.comment}}</label>
				</col>
				<Col :class-name="'comment-list'" v-for="(item,key) in report_detail.comment_list" :key="key" :xs="{'span':24}"
						 :sm="{'span':24}" :lg="{'span':24}" v-if="key<=load" v-bind:class="{'first-comment':key==0}">
				<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'comment-list-left'">
				<a v-bind:href="'/user/userzone/'+item.user.id" target="_blank">
					<div class="avatar-frame-new">
						<img :src="item.user.image" onerror="this.src='/static/noimg.png'">
					</div>
				</a>
				</Col>
				<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}" :class-name="'comment-list-right'">
				<div class="comment-frame">
					<div class="comment-user">
						<span class="username">{{item.user.username}}
                        <img src='/static/author_confirm.png' v-if="item.user.author_info&&item.user.author_info.status==1">
						</span><br>
						<span class="user-desc">{{item.user.desc}}</span>
						<span class="comment-time">{{item.comment_time}}</span>
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
										<span class="username">{{son_comment.user.username}}</span>
										<img src='/static/author_confirm.png' v-if="son_comment.user.author_info&&son_comment.user.author_info.status==1">
										<span class="comment-time">{{son_comment.comment_time}}</span><br>
 										<span class="user-desc">{{son_comment.user.desc}}</span>
									</div>
									<div class="comment-content">
										{{son_comment.content}}
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="comment-oper">
						<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
						&nbsp</Col>
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
						&nbsp
						<span class='complaint' @click="complaint(item.id,key)">
													<i class="icon icon-report"></i>举报
												</span>
						</Col>
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'reply'">
						<div @click="show_replay(item.id)">
							<i class="icon icon-message3"></i>
						</div>
						</Col  @click="reply">
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'top'">
						<div @click="top(item.id,key)">
							<i class="icon icon-good1"></i>{{item.top}}
						</div>
						</Col>
					</div>
				</div>
				</Col>
				<div class="comment-reply" v-if="comment_id == item.id">
					<div>
										<textarea class="comment-text" :placeholder="'回复  ' + item.user.username + ' :'"
															v-model="reply_comment">
										</textarea>
					</div>
					<div>
						<Col :xs="{'span':2,'offset':22}" :sm="{'span':2,'offset':22}" :lg="{'span':2,'offset':22}">
						<Button :disabled="!reply_comment" class="submit-comment" v-bind:class="{'common-button' :reply_comment}"
										@click="reply(2,item.id)">评论
						</Button>
						</Col>
					</div>
				</div>
				</Col>
				</Col>
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="report_detail.comment">
				<center>
					<div @click="load_mode" class="load-more-comment" v-if="has_more">查看更多评论</div>
				</center>
				</Col>
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-else="report_detail.comment"
						 class="no-more-comment">
				<center>
					暂无评论
				</center>
				</Col>
				</Col>
				<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'report-more-frame'"
						 v-if="report_more.length">
				<div class="report-more">更多数据报告</div>
				<ul class="report-ul">
					<li v-for="(item,key) in report_more" :key="key" class="report-more-title">
						<a v-bind:href="'/news/reportDetail/'+item.id" target="_blank" v-bind:title="item.title">{{item.title}}</a>
					</li>
				</ul>
				</Col>
				<!-- 						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'report-next'">
                      <h2>下一篇</h2>
                      <div class="report-title">
                        无印良品在日大幅降价以对抗电商，中国或很快跟进
                      </div>
                      <div class="report-info">
                        <p class="day">{{report_detail.created_at}}</p>
                        <p class="right-icons">
                          <span><i class="icon icon-eye1"></i>{{report_detail.view}}</span>
                          <span><i class="icon icon-message3"></i>{{report_detail.comment}}</span>
                          <span><i class="icon icon-download"></i>{{report_detail.down}}</span>
                        </p>
                      </div>
                    </Col> -->
				</Col>
			</Row>
			</Col>
		</Row>
		<FooterArea></FooterArea>
    <FloatSideBar></FloatSideBar>
    <AccountPannel ref="AccountPannel" :fresh="fresh"></AccountPannel>    
	</div>
</template>

<script>
	import PageRight from '../components/MainRight.vue';
	import NavHeader from '../components/NavHead.vue';
	import FooterArea from '../components/FooterArea.vue';
	import FloatSideBar from '../components/FloatSideBar.vue';
    import ShareBtn from '../components/shareBtn.vue';
    import AccountPannel from '../components/AccountPanel.vue';
	export default{
		components: {NavHeader,FooterArea,FloatSideBar,PageRight,ShareBtn,AccountPannel},
		data(){
			return {
				page_id:16,
				report_id:'',
				report_detail:'',
				report_more:'',
				report_next:'',
				ad_list:'',
				comment:'',
				reply_comment:'',
				comment_id:0,
				page:1,//加载评论的页数，一页十个
				load:10,
				has_more:true,
				fresh:0
			}
		},
		mounted(){
			document.title = '菠菜圈| 数据报告详情';
			var v = this;
			this.report_id = this.$route.params.report_id;
			this.https.get('/front/report_details/render',{
				params:{
					rid:v.report_id
				}
			}).then((r)=>{
                if (r.data.reportDetails instanceof Array && r.data.reportDetails.length == 0){
                    v.$Message.warning('该信息不存在或已删除!');
                    setTimeout(function () {
                        v.$router.push('/news/report');
                    },2000)
                }
				v.report_detail = r.data.reportDetails
				v.ad_list = r.data.adList
				v.report_more = r.data.report_more
			}).catch((e)=>{
				console.log(e);
			});
		},
		methods:{
			load_mode(){
				this.page = this.page + 1;
				this.load = this.page*10;
				if(this.report_detail.comment_list.length<=this.load){
					this.$Message.success('已加载全部评论');
					this.has_more = false;
				}
			},
			download_report(key){
				if (!this.$store.state.user_info) {
		          this.fresh = 1
		          this.$refs.AccountPannel.show()
		          return false
		        } 
                var id = this.report_detail.id;
                var file = this.report_detail.file;
                var price = this.report_detail.price;
                var v = this;
                this.https.get('/common/download_test',{
                    params:{
                    	did:id,
                        price : price,
                        file : file
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
            	this.report_detail.down = this.report_detail.down + 1;
                var elemIF = document.createElement("iframe");
                elemIF.src = url;
                elemIF.style.display = "none";
                document.body.appendChild(elemIF);
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
				this.https.get('/front/report_details/add_comment',{
					params:{
						rid:v.report_id,
						fid:fid,
						content:content
					}
				}).then((r)=>{
					if (r.data.code == 1) {
						v.comment = '';
						v.reply_comment = '';
						v.$Message.success(r.data.msg);		
						this.https.get('/front/report_details/get_comment_list',{
							params:{
								rid:v.report_id
							}
						}).then((r)=>{
								v.$set(v.report_detail,'comment_list',r.data);
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
            complaint(cid,key){
            	var v = this;
				this.https.get('/front/report_details/add_complaint',{
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
            		type:'Report',
            		id:cid
            	}}).then((r)=>{
            		if (r.data == 1) {
            			v.$Message.success('您已赞过该评论')
            			return false
            		}
					v.https.get('/front/report_details/add_comment_top',{
						params:{
							cid:cid
						}
					}).then((r)=>{
						v.report_detail.comment_list[key].top = v.report_detail.comment_list[key].top + 1;
					}).catch((e)=>{
						console.log(e);
					})
            	}).catch((e)=>{
            		console.log(e)
            	})            	
            },
		}
	}
</script>

<style lang="scss" scoped>
	.icon-download {
		padding: 0;
		font-size: .23rem;
		vertical-align: text-bottom;
	}
	* {
		box-sizing: border-box;
	}
	#report_detail {
		.container {
			width: 1200px;
			min-height: 10rem;
			margin: 20px auto;
			.comment-text {
				padding: 15px 20px;
				margin-top: 94px;
				border-radius: 3px;
				background-color: #f4f4f4;
                border-color: #ddd;
				min-height: 30px;
				width: 100%;
				font-size: 14px;
				color: #333;
				&:focus{
					cursor: text;
					border-color: #28b28a;
					transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
					background-color: #fff;
				}
			}
			::-webkit-input-placeholder { /* Chrome/Opera/Safari */
				color: #999;
			}
			::-moz-placeholder { /* Firefox 19+ */
				color: #999;
			}
			:-ms-input-placeholder { /* IE 10+ */
				color: #999;
			}
			:-moz-placeholder { /* Firefox 18- */
				color: #999;
			}
			.report-suffix {
				width: 50px;
				height: 50px;
				margin: 0 auto;
				text-align: center;
				margin-bottom: 10px;
				img {
					width: 100%;
					height: 100%;
					vertical-align: middle;
				}
			}
			.button {
				color: #666;
				width: 70px;
				margin: 0 auto;
				height: 24px;
				padding: 5px 2px;
				text-align: center;
				line-height: 1;
			}
			.download-frame {
				margin-top: 20px;
				background-color: #fbfbfb;
				padding: 15px;
				border-left: 6px solid #28b28a;
				.download-intro {
					.download-title {
						color: #333;
						font-size: 18px;
						font-weight: bold;
						padding: 0 0 15px 0;
						width: 100%;
						overflow : hidden;
						text-overflow: ellipsis;
						-webkit-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						-ms-text-overflow: ellipsis;
						white-space: nowrap;
						-moz-white-space: nowrap;
						-webkit-white-space: nowrap;
						-o-white-space: nowrap;
					}
					.download-brief {
						font-size: 14px;
						color: #666;
						overflow: hidden;
		        text-overflow: ellipsis;
		        -o-text-overflow:ellipsis;
						-moz-text-overflow:ellipsis;
		        -webkit-line-clamp: 2;
		        display: -webkit-box;
		        -webkit-box-orient: vertical;
						text-align: justify;
					}					
				}
			}
			.report-frame {
				.report-description {
					.report-title {
						font-size: 35px;
						color: #333333;
						padding-top: 10px;
						padding-bottom: 20px;
						text-align: justify;
					}
					.report-brief {
						margin-top: 25px;
						padding: 20px;
						font-size: 16px;
						color: #999;
						background-color: #f7f7f7;
						border-radius: 3px;
						line-height: 1.5;
					}
					.report-content {
						padding: 40px 0;
						font-size: 16px;
						color: #333;
						text-align: justify;
						white-space: pre-wrap;
					}
				}
				.report-info-frame {
					.report-info {
						font-size: 14px;
						padding-bottom: 15px;
						color: #666;
						span {
							display: inline-block;
							vertical-align: middle;
							margin-right: 15px;
						}
					}
				}
				.download {
					cursor: pointer;
					width: 100%;
					height: 50px;
					color: #fff;
					background-color: #28b28a;
				}
			}
			.add-comment{
				padding-bottom: 50px;
				border-bottom: 1px solid #f4f4f4;
				border-weight:lighter;
			}

			.all-comment {
				margin: 20px 0;
				.comment-title {
					font-size: 16px;
					font-weight: bold;
					color: #333;
					margin-right: 18px;
				}
				.comment-count{
					font-size: 14px;
					color: #666;
					font-weight: 400;
				}
				.comment-list {
					margin-top: 20px;
					padding-top: 20px;
					border-top:1px dashed #efefef;
					.comment-list-left {
						.avatar-frame-new {
							width: 100%;
							height: 100%;
							border-radius: 50%;
							overflow: hidden;
							text-align: center;
							border:1px solid #e0e0e0;
							img {
								cursor: pointer;
								border-radius: 50%;
								width: 100%;
								height: 100%;
								background: #e9e9e9;
							}
						}
					}
					.comment-list-right {
						padding-left: 20px;
						.comment-user {
							.username {
								font-size: 14px;
								font-weight: bold;
								color: #444;
							}
							.comment-time {
								font-size: 12px;
								color: #888;
								margin-left: 12px;
							}
						}
						.comment-frame {
							.son-comment{
								.son-comment-frame{
									display: block;
									.son-comment-zone{
										width: 100%;
										border-radius: 3px;
										position: relative;
										background-color: #f2f2f2;
										margin-top: 10px;
										padding: 10px;
										.son-comment-tag{
											position: absolute;
											left: 30px;
											top: -10px;
											width: 0;
											height: 0;
											border-right: 10px solid transparent;
											border-bottom: 10px solid #efefef;
											border-left: 10px solid transparent;
										}
									}
								}
							}
							.comment-oper {
								padding-top: 20px;
								text-align: right;
								color: #888;
								font-size: 14px;
								.complaint{
									display: none;
								}
								.top,.reply,.complaint{
									&:hover{
										color: #28b28a;
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
						.comment-content {
							padding: 5px 0 10px 0;
							font-size: 14px;
							color: #555;
							text-align: left;
							min-height: 28px;
							overflow: hidden;
							word-wrap: break-word;
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
	.report-more-frame {
	padding: 20px 0 30px 0;
	.report-more {
		text-align: left;
		font-size: 14px;
		color: #333;
		font-weight: bold;
	}
	ul, li {
		margin: 0;
		padding: 0;
		list-style: none;
	}
	ul.report-ul {
		overflow: auto;
		padding: 10px 0 50px 0;
	}
	li.report-more-title::before {
		content: '';
		display: inline-block;
		width: 5px;
		height: 5px;
		background: #28b28a;
		border-radius: 50%;
		position: absolute;
		top: 50%;
		left: 0;
		margin-top: -2.5px;
	}
	.report-more-title {
		position: relative;
		width: 100%;
		color: #333;
		font-size: 14px;
		cursor: pointer;
		margin: 0 0 10px 0;
		padding: 8px 10px 8px 15px;
		&:hover {
			color:#28b28a;
		}
		a {
			display: block;
			color: #333;
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
}
	.report-next {
		padding: 20px 15px;
		border: 1px solid #e9e9e9;
		border-radius: 3px;
		h2 {
			font-size: 14px;
			color: #999;
		}
		.report-title {
			font-size: 18px;
			color: #333;
			font-weight: bold;
			padding: 10px 0 15px 0;
			height: 60px;
			overflow: hidden;
			text-overflow: ellipsis;
			-o-text-overflow:ellipsis;
			-moz-text-overflow:ellipsis;
			-webkit-line-clamp: 2;
			display: -webkit-box;
			-webkit-box-orient: vertical;
			text-align: justify;
		}
		.report-info {
			font-size: 12px;
			color: #999;
			padding: 20px 0 0 0;
			display: -webkit-flex;
			align-items: center;
			justify-content: space-between;
			p {
				display: inline-block;
			}
			.day {
				text-align: left;
			}
			.right-icons {
				text-align: right;
				span {
					display: inline-block;
					vertical-align: middle;
					margin-left: 15px;
				}
			}

		}
	}
</style>