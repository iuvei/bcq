<template>
	<div id="micro">
	    <NavHeader ref="header"></NavHeader>
	    <Row type="flex" justify="center">
	    	<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>微动态</BreadcrumbItem>
				</Breadcrumb>	 
				<Row type="flex" justify="space-between">
					<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
						<Row v-if="detail.user" type="flex" align="middle">
							<Col :xs="2" :sm="2" :lg="2">
								<div class="avatar-frame-new" @click="go('/user/userzone/'+detail.user.id)">
									<img :src="detail.user.image" onerror="this.src='/static/noimg.png'">
								</div>
							</Col>
							<Col :xs="12" :sm="12" :lg="12" :class-name="'userinfo'">
								<p>
									<b class="username" v-bind:class="{'username-author':detail.user.is_author}">{{detail.user.username}}</b>
								</p>
								<p class="userdesc">{{detail.user.desc}}</p>
							</Col>
							<Col :xs="{'span':4,'offset':1}" :sm="{'span':4,'offset':1}" :lg="{'span':4,'offset':1}">
							<a href="http://wpa.qq.com/msgrd?v=3&uin=1750182485&site=qq&menu=yes" target="_blank">
								<Button class="common-button2" v-if="detail.utype=='1'">游戏快速接入</Button>
							</a>
							</Col>
							<Col :xs="{'span':4,'offset':1}" :sm="{'span':4,'offset':1}" :lg="{'span':4,'offset':1}">
								<Button class="common-button6" v-if="detail.is_attention=='0'" @click="add_attention(detail.user.id,detail.is_attention)"> ＋ 关 注 </Button>
								<Button class="common-button2" v-if="detail.is_attention=='1'" @click="add_attention(detail.user.id,detail.is_attention)"> 已 关 注 </Button>
							</Col>							
						</Row>
						<Row>
							<Col :xs="24" :sm="24" :lg="24" :class-name="'content'">
								<div v-html="detail.content">
									
								</div>
							</Col>
							<Col :xs="8" :sm="8" :lg="8" v-for="(item,key) in detail.image" :key="key" :class-name="'img-frame-out'">
								<div class="img-frame" v-bind:style="{'background-image':'url('+item+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}" @click="show_image=item;image_key=key">
									<!-- <img v-bind:src="item" @click="show_image=item;image_key=key"> -->
								</div>
							</Col>
						</Row>
						<Row type="flex" align="middle" :class-name="'micro-info-frame'">
							<Col :xs="8" :sm="8" :lg="8">
								<ul class="micro-info"> 
									<li>{{detail.time}}</li>
									<li><i class="icon icon-eye1"></i>&nbsp&nbsp{{detail.f_view}}</li>
									<a href="#comment"><li style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{detail.comment_count}}</li></a>
								</ul>
							</Col>
							<Col :xs="{'span':10,'offset':6}" :sm="{'span':10,'offset':6}" :lg="{'span':10,'offset':6}">
								<ShareBtn></ShareBtn>
							</Col>
						</Row>
						<Row type="flex" align="middle">
				        <Col :class-name="'add-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				            <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
				            	<div class="avatar-frame-new" v-if="detail.avatar">
				            		<img v-bind:src="detail.avatar">
				            	</div>
				            </Col>
				            <Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
				              <textarea class="comment-text" placeholder="随便说点什么吧...." v-model="comment"></textarea>
				            </Col>
				            <Col :xs="{'span':2,'offset':22}" :sm="{'span':2,'offset':22}" :lg="{'span':2,'offset':22}">
				              <Button :disabled="!comment" class="submit-comment" v-bind:class="{'common-button':comment}"
				                      @click="reply(1)">评论
				              </Button>
				            </Col>
				        </Col>	
				        <Col :class-name="'all-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				            <Col>
				              <label class="comment-title" id="comment">全部评论</label>
				              <label class="comment-count">{{detail.comment_count}}</label>
				        </Col>
				        <Col :class-name="'comment-list'" v-for="(item,key) in detail.comment_list" :key="key" :xs="{'span':24}"
				               :sm="{'span':24}" :lg="{'span':24}" v-if="key<=load" v-bind:class="{'first-comment':key==0}">
				            <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'comment-list-left'">
				              <div class="avatar-frame-new" @click="go('/user/userzone/'+item.user.id)">
				                <img :src="item.user.image" onerror="this.src='/static/noimg.png'">
				              </div>
				            </Col>
				          <Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}" :class-name="'comment-list-right'">
				          <div class="comment-frame">
				            <div class="comment-user">
				              <span class="username">{{item.user.username}}
				                <img src='/static/author_confirm.png' v-if="item.user.author_info&&item.user.author_info.status==1">
				              </span><span class="comment-time">{{item.comment_time}}</span><br>
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
				                      </span><span class="comment-time">{{son_comment.comment_time}}</span><br>
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
				                <i class="icon icon-report" style="vertical-align: text-bottom;padding-right: 3px;"></i>举报
				              </span>
				              </Col>
				              <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'reply'">
				              <div @click="show_replay(item.id)">
				                <i class="icon icon-message3"></i>
				              </div>
				              </Col  @click="reply">
				              <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" :class-name="'top'">
				              <div @click="top(item.id,key)">
				                <i class="icon icon-good1" style="vertical-align: text-bottom;padding-right: 3px;"></i>{{item.top}}
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
				                <Button :disabled="!reply_comment" class="submit-comment" v-bind:class="{'common-button' :reply_comment}"
				                        @click="reply(2,item.id)">评论
				                </Button>
				              </Col>
				            </div>
				          </div>
				        </Col>
				          </Col>	
				          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="detail.comment_count">
				          <center>
				            <div @click="load_mode" class="load-more-comment" v-if="has_more">查看更多评论</div>
				          </center>
				          </Col>
				          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-else="detail.comment_count"
				               class="no-more-comment">
				          <center>
				            暂无评论
				          </center>
				          </Col>				          			          						
						</Row>						
					</Col>
					<Col :xs="{'span':7,'offset':1}" :sm="{'span':7,'offset':1}" :lg="{'span':7,'offset':1}" :class-name="'page-right'">
						<RelateMicro :id="id"></RelateMicro>
						<RecommandMicro></RecommandMicro>
					</Col>
				</Row>
			</Col>
	    </Row>	
	    <div class="show-image" v-if="show_image">
	    	<div class="image-mask" @click="hide_image">
 	    		<img v-bind:src="detail.image[image_key]">    	
	    	</div>
	    	<div class="to-back">
	    		<p @click="change_img(-1)"><Icon type="chevron-left" color="white" size="80"></Icon></p>
	    	</div>
	    	<div class="to-forword">
	    		<p @click="change_img(1)"><Icon type="chevron-right" color="white" size="80"></Icon></p>
	    	</div>
	    </div>
		<FooterArea></FooterArea>
    	<FloatSideBar></FloatSideBar>	    
	</div>
</template>
<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import ShareBtn from '../components/shareBtn.vue';
import RelateMicro from './RelateMicro.vue';
import RecommandMicro from './RecommandMicro.vue';
export default{
	components: {NavHeader,FooterArea,FloatSideBar,ShareBtn,RelateMicro,RecommandMicro},
	mounted(){
		var v = this
		this.id = this.$route.query.id
		if (!this.id) {
			this.$router.push('/error/404')
		}
		this.https.get('/front/micro/get_detail',{
			params:{
				id:v.id
			}
		}).then((r)=>{
			if (r.data.code==1) {
				v.detail = r.data.msg
			}else{	
				v.$Message.warning(r.data.msg)
			}
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			id:'',
			detail:'',
			show_image:'',
			comment:'',
			has_more:'',
			comment_id:0,
			reply_comment:'',
			page:1,//加载评论的页数，一页十个
			load:10,
			has_more:true,
			image_key:''
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		change_img(k){
			if (((this.image_key+1)==this.detail.image.length&&k==1) || (this.image_key==0&&k==-1)) {
				console.log(this.image_key)
				return false
			}else{
				this.image_key = this.image_key+k
				console.log(this.image_key)
			}
		},
		hide_image(){
			this.show_image = ''
		},
		load_mode(){
			this.page = this.page + 1
			this.load = this.page*10
			if(this.detail.comment_list.length<=this.load){
				this.$Message.success('已加载全部评论')
				this.has_more = false
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
			var v = this;
			if(type == 1){//一级评论
				var fid = '';
				var content = v.comment
			}
			if (type == 2) {//二级评论
				var fid = v.comment_id;
				var content = v.reply_comment
			}
			this.https.get('/front/micro/add_comment',{
				params:{
					mid:v.id,
					fid:fid,
					content:content
				}
			}).then((r)=>{
				if (r.data.code == 1) {
					if (type == 1) {
    					v.https.get('/common/change_read_status?status=1&model=Micro&id='+v.id)
					}
					v.comment = '';
					v.reply_comment = '';
					v.$Message.success(r.data.msg);
					this.https.get('/front/micro/get_comment_list',{
						params:{
							mid:v.id
						}
					}).then((r)=>{
						v.$set(v.detail,'comment_list',r.data);
						v.detail.comment_count = v.detail.comment_count + 1;
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
			this.https.get('/front/micro/add_complaint',{
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
        		type:'Micro',
        		id:cid
        	}}).then((r)=>{
        		if (r.data == 1) {
        			v.$Message.success('您已赞过该评论')
        			return false
        		}
				v.https.get('/front/micro/add_comment_top',{
					params:{
						cid:cid
					}
				}).then((r)=>{
					v.detail.comment_list[key].top = v.detail.comment_list[key].top + 1;
				}).catch((e)=>{
					console.log(e);
				});
        	}).catch((e)=>{
        		console.log(e)
        	})
        },
        add_attention(uid,status){
            var v = this;
            this.https.get('/common/add_attention',{
                params:{
                    aid : v.detail.user.id
                }
            }).then((r)=>{
                if(r.data.code == 1){
                    v.$Message.success(r.data.msg);
                    if (status == 1) {
                        v.detail.is_attention = 0;
                    }else{
                        v.detail.is_attention = 1;
                    }
                }else{
                    v.$Message.error(r.data.msg);
                }
            }).catch((e)=>{
                console.log(e)
            });
        }		
	}	
}
</script>
<style lang="scss" scoped>
#micro{
	.container{
		width: 1200px;
		min-height: 10rem;
		margin: 20px auto;
		.userinfo{
			padding-left: 15px;
			.username{
				font-size: 16px;
				letter-spacing: 1px;
				line-height: 20px;		
			}
			.userdesc{
				font-weight: lighter;
				color: #999999;
			}
		}
		.content{
			padding: 20px 5px 0 0;
			font-size: 16px;
		}
		.micro-info-frame{
			padding-top: 10px;
			.micro-info{
				display: flex;
				flex-direction:row;
				color: #898989;
				li{
					width: 25%;
				}
			}
		}
		.img-frame-out{
			padding: 5px 10px 5px 0;
			.img-frame{
				width: 100%;
				height: 0;
				padding-top: 62.5%;
				position: relative;
				img{
					position: absolute;
					top: 0;
					left: 0;
					height: 100%;
					width: 100%;
					cursor: pointer;
				}
			}
		}

		.comment-text {
			color: #666;
			font-size: 14px;
			min-height: 30px;
			width: 100%;
			padding: 15px;
			margin-left: 15px;
			border-radius: 3px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			-ms-border-radius: 3px;
			background: #f2f2f2;
            border: 1px solid #e0e0e0;
			&:focus {
				cursor: text;
				border-color: #28b28a;
				transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
				background-color: #fff;
			}
			&::-webkit-input-placeholder { /* Chrome/Opera/Safari */
				color: #999;
			}
			&::-moz-placeholder { /* Firefox 19+ */
				color: #999;
			}
			&:-ms-input-placeholder { /* IE 10+ */
				color: #999;
			}
			&:-moz-placeholder { /* Firefox 18- */
				color: #999;
			}
		}
		.add-comment {
			margin-top: 100px;
			padding-bottom: 50px;
			border-bottom: 1px solid #efefef;
		}
		.all-comment {
			margin-top: 20px;
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
						padding-top: 10px;
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
									padding: 10px;
									margin-top: 20px;
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
						padding: 5px 0 15px 0;
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
		.submit-comment {
			width: 100%;
			margin-top: 20px;
		}
	}
	.show-image{
		position: fixed;
		top: 0;
		left: 0;
		height: 100%;
		width: 100%;
		z-index: 10000;
		.image-mask{
			position: absolute;
			top: 0;
			left: 0;			
			height: 100%;
			width: 100%;
			background-color: rgba(51,51,51,0.5);
			z-index: 99;
			text-align: center;
			display: -webkit-flex; /* Safari */
			display: flex;
		 	flex-direction:row;
			justify-content:center;
			align-items:center;
			img{
				width: auto;
				max-width: 100%;
			}
		}
		.to-forword{
			position: absolute;
			top: 0;
			right: 0;
			width: 100px;
			height: 100%;
			background-color: black;
		}
		.to-back{
			position: absolute;
			top: 0;
			left: 0;
			width: 100px;
			height: 100%;
			background-color: black;
		}
		.to-forword,.to-back{
			cursor: pointer;
			display: table;
			opacity: 0.3;
			z-index: 99;
			p{
				display: table-cell;
				vertical-align: middle;	
				text-align: center;			
			}
		}
	}
}	
</style>