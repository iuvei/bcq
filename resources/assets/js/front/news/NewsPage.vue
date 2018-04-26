<template>
	<div id="news_detail">
    <NavHeader></NavHeader>
    <Row type="flex" justify="center">
      <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
      <Breadcrumb separator=">" style="margin: 15px 0;">
        <BreadcrumbItem to="/">首页</BreadcrumbItem>
        <BreadcrumbItem>资讯</BreadcrumbItem>
        <BreadcrumbItem to="/news">产业资讯</BreadcrumbItem>
        <BreadcrumbItem>产业资讯详情</BreadcrumbItem>
      </Breadcrumb>

      <Row type="flex" justify="space-between">
        <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
        <div class="news-detail">
          <Row>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
              <span class="news-title">{{news_details.title}}</span>
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-infos'">
            <Row type="flex" justify="space-between" :class="'news-info-frame'">
              <Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}" :class-name="'pubInfo'">
                <span class="byself" v-if="news_details.byself">原创</span><span v-if="news_details.byself">&nbsp&nbsp&nbsp</span>
                <span class="news-info title-hidden">{{news_details.origin}}</span>
                <span class="news-info">{{news_details.updated_at}}</span>
                <span class="news-info">
                  <i class="icon icon-eye1"></i>
                  {{news_details.view}}
                </span>
                <a  href="#comment">
                  <span class="news-info">
                    <i class="icon icon-message3"></i>
                    {{news_details.comment}}
                  </span>
                </a>
              </Col>
              <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}" :class-name="'share'">
                <ShareBtn></ShareBtn>
              </Col>
            </Row>
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-brief'">
              {{news_details.brief}}
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
              <div class="v-html-content" v-bind:class="{'noselect':news_details.locked}" v-html="news_details.content"></div>
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-footer'">
            <Row type="flex" justify="center">
              <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}">
                <a v-bind:href="'https://t.me/bcquan'" target="_blank" style="color:#333">
                  <div class="news-footer-content">· END ·</div>
                  <div class="news-footer-content">本文由菠菜圈-作者刊登，版权归原作者所有，</div>
                  <div class="news-footer-content">未经授权，请勿转载，谢谢！</div>
                </a>
              </Col>
            </Row>
            <Row type="flex" justify="center">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                <div class="signature">
                    <img v-bind:src="news_details.author_signature?news_details.author_signature:'/static/official.jpg'">
                    <div v-if="news_details.author_sign_url&&news_details.author_signature" class="sign_url pointer" @click="open_signurl(news_details.author_sign_url)">
                    </div>
                    <div v-if="!news_details.author_signature" class="sign_url pointer" @click="open_signurl('https://t.me/bcquan')">
                    </div>
                </div>
              </Col>
            </Row>
            <Row type="flex" justify="center">
              <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'deal-frame'">
              <Col :xs="{'span':9,'offset':3}" :sm="{'span':9,'offset':3}" :lg="{'span':9,'offset':3}"
                   :class-name="'news-deal'">
              <div class="top" v-bind:class="{'button-active':active}" @click="add_top">
                <div>
                  <i class="icon icon-good2" style="color: #333; font-size: .35rem;"></i>
                </div>
                <div>{{news_details.top}}</div>
              </div>
              </Col>
              <Col :xs="{'span':9}" :sm="{'span':9}" :lg="{'span':9}" :class-name="'news-deal'">
              <div class="collect" v-bind:class="{'button-active':news_details.is_collected == 1}" @click="collection">
                <div>
                  <i class="icon icon-shoucang2" style="color: #333; font-size: .35rem;"></i>
                </div>
                <div>{{news_details.collection}}</div>
              </div>
              </Col>
              </Col>
              </Col>
            </Row>
            </Col>
          </Row>

          <Col :class-name="'add-comment'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
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
              <label class="comment-count">{{news_details.comment}}</label>
            </Col>
          <Col :class-name="'comment-list'" v-for="(item,key) in news_details.comment_list" :key="key" :xs="{'span':24}"
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
              <a v-bind:href="'/user/userzone/'+item.user.id" target="_blank">
                <span class="username">{{item.user.username}}
                  <img src='/static/author_confirm.png' v-if="item.user.author_info&&item.user.author_info.status==1">
                </span>
              </a>
              <span class="comment-time">{{item.comment_time}}</span><br>
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
          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="news_details.comment">
          <center>
            <div @click="load_mode" class="load-more-comment" v-if="has_more">查看更多评论</div>
          </center>
          </Col>
          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-else="news_details.comment"
               class="no-more-comment">
          <center>
            暂无评论
          </center>
          </Col>
        </div>
        </Col>
        <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
        <Row :class-name="'authorList'">
          <Col :xs="24" :sm="24" :lg="24" :class-name="'author'">
              <Col :xs="5" :sm="5" :lg="5" :class-name="'author-avatar'">
              <a v-bind:href="'/user/userzone/' + news_details.uid" target="_blank">
                <div class="avatar-frame-new">                
                    <img :src="news_details.author_image" onerror="this.src='/static/noimg.png'"/>                
                </div>
              </a>
              </Col>
              <Col :xs="19" :sm="19" :lg="19" :class-name="'author-info'">
              <Col :xs="24" :sm="24" :lg="24">
              <Row>
                <a v-bind:href="'/user/userzone/' + news_details.uid" target="_blank">
                  <Col :xs="16" :sm="16" :lg="16" :class-name="'author-username-frame'">
                      <div class="author-name">
                        <span>{{news_details.author_username}}</span>
                      </div>                 
                  <img src="/static/author_confirm.png"><br>
                  <span class="user-desc">{{news_details.author_desc}}</span>
                  </Col>
                </a>
                <Col :xs="8" :sm="8" :lg="8">
                  <Button v-if="news_details.is_attention !== -1 && news_details.is_attention !== 1" class="common-button5"
                          @click="add_attention(news_details.uid,news_details.is_attention)"> + 关注
                  </Button>
                  <Button v-if="news_details.is_attention == 1" class="common-button5-attention"
                          @click="add_attention(news_details.uid,news_details.is_attention)">已关注
                  </Button>
                </Col>
<!--                 <Col :xs="24" :sm="24" :lg="24">
                  <a v-bind:href="'/user/userzone/' + news_details.uid" target="_blank">
                    
                  </a>
                </Col> -->
              </Row>
              </Col>
              </Col>
          <Col :xs="24" :sm="24" :lg="24" :class-name="'author-brief'">
          <div class="author-brief-inner">
            简介：{{news_details.author_brief}}
          </div>
          </Col>
          <Col :xs="24" :sm="24" :lg="24" :class-name="'occupy'">

          </Col>
          <Col :xs="24" :sm="24" :lg="24" :class-name="'author-news'">
          <div class="author-news">最新文章</div>
          <div v-for="(item,key) in news_details.author_news" :key="key" class="author-news-list">
            <div class="author-news-title">
              <a v-bind:href="'/news/newspage/'+ item.id" target="_blank" v-bind:title="item.title">
                {{item.title}}
              </a>
            </div>
            <div>
              <Row>
                <Col :xs="12" :sm="12" :lg="12" :class-name="'author-news-time'">
                {{item.updated_at}}
                </Col>
                <Col :xs="12" :sm="12" :lg="12" :class-name="'author-news-cname'">
                {{item.category_name}}
                </Col>
              </Row>
            </div>
          </div>
          <div class="more-news">
            <Button :class="'readmore-button'" @click="go('/user/userzone/' + news_details.uid)">
              阅读更多，点击这里
            </Button>
          </div>
          </Col>
          </Col>
        </Row>
        <Row>
          <Col :xs="24" :sm="24" :lg="24">
          <div class="relate-news">相关文章</div>
          <ul class="relate-news-title">
            <li v-for="(item,key) in relate_news" :key="key" class="title-hidden">
              <a v-bind:href="'/news/newspage/'+ item.id" target="_blank" v-bind:title="item.title">
                <b class="record"></b><span class="title">{{item.title}}</span>
              </a>
            </li>
          </ul>
          </Col>
        </Row>
        <Row v-if="news_details.next_news" :class-name="'next-news-frame'">
          <Col :xs="24" :sm="24" :lg="24">
          <div class="next-news">下一篇</div>
          <div class="next-news-title line2">
            <a v-bind:href="news_details.next_news.id" target="_blank" v-bind:title="news_details.next_news.title">{{news_details.next_news.title}}</a>
          </div>
          <div class="next-news-info">
				        			<span class="next-news-time">
				        				{{news_details.next_news.time}}
				        			</span>
            <span class="next-news-cat">
				        				{{news_details.next_news.cname}}
				        			</span>
          </div>
          </Col>
        </Row>
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
    <AccountPannel ref="AccountPannel" :fresh="fresh" :action="action" @collection="collection"></AccountPannel>
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
		mounted(){
			document.title = '菠菜圈| 产业资讯详情';
			var v = this;
			v.news_id = v.$route.params.news_id;
			v.https.get('/front/news_details/render',{
				params:{
					nid:v.news_id
				}
			}).then((r)=>{
			    if (!r.data.newsDetails){
                    v.$Message.warning('该信息不存在或已删除!');
                    setTimeout(function () {
						v.$router.push('/news');
                    },2000)
                    return false
				}
				v.news_details = r.data.newsDetails
				v.relate_news = r.data.relateNews
				v.ad_list = r.data.ad_list
			}).catch((e)=>{
				console.log(e);
			});
		},
		data(){
			return {
				page_id: 15,
				news_id:'',
				ad_list:'',
				news_details:'',
				relate_news:'',
				comment:'',
				reply_comment:'',
				comment_id:0,
				page:1,//加载评论的页数，一页十个
				load:10,
				has_more:true,
				active:false,
        action:'',
        fresh:0
			}
		},
		methods:{
			go(path){
				this.$router.push(path)
			},
      open_signurl (url) {
          var v = this
          this.$Modal.confirm({
              title: '该链接为菠菜圈用户提供链接，菠菜圈不能保证其安全性',                    
              okText: '就是要去！',
              cancelText: '好吧，那算了。。。',
              onOk: () => {
                  window.open(url)
              }
          });
      },      
			load_mode(){
				this.page = this.page + 1;
				this.load = this.page*10;
				if(this.news_details.comment_list.length<=this.load){
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
				this.https.get('/front/news_details/add_comment',{
					params:{
						nid:v.news_id,
						fid:fid,
						content:content
					}
				}).then((r)=>{
					if (r.data.code == 1) {
            v.https.get('/common/change_read_status?status=1&model=news&id='+v.news_id)
						v.comment = '';
						v.reply_comment = '';
						v.$Message.success(r.data.msg);
						this.https.get('/front/news_details/get_comment_list',{
							params:{
								nid:v.news_id
							}
						}).then((r)=>{
							v.$set(v.news_details,'comment_list',r.data);
							v.news_details.comment = v.news_details.comment + 1;
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
				this.https.get('/front/news_details/add_complaint',{
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
            		type:'News',
            		id:cid
            	}}).then((r)=>{
            		if (r.data == 1) {
            			v.$Message.success('您已赞过该评论')
            			return false
            		}
					v.https.get('/front/news_details/add_comment_top',{
						params:{
							cid:cid
						}
					}).then((r)=>{
						v.news_details.comment_list[key].top = v.news_details.comment_list[key].top + 1;
					}).catch((e)=>{
						console.log(e);
					});
            	}).catch((e)=>{
            		console.log(e)
            	})
            },
            add_top(){
            	if (this.active == true) {
            		return false;
            	}
            	var v = this;
            	v.https.get('/front/news_details/add_top?nid=' + v.news_id)
            	v.news_details.top = v.news_details.top + 1
            	v.active = true
              v.$Message.success('谢谢支持，已点赞')
            },
            collection(){
            	var v = this;
      				this.https.get('/front/news_details/collection',{
      					params:{
      						nid:v.news_id,
      						model:'News'
      					}
      				}).then((r)=>{
      					if (r.data.code == 1) {
                  if (v.news_details.collection==1) {
                    v.$Message.success('已取消收藏');
                    v.news_details.collection = v.news_details.collection - 1;
                    v.news_details.is_collected = 0;                      
                  }else{
                    v.$Message.success('已收藏');
                    v.news_details.collection = v.news_details.collection + 1;
                    v.news_details.is_collected = 1;                    
                  }
      					}else{
                  v.action = 'collection'
                  v.fresh = 1
      						v.$refs.AccountPannel.show()
      					}
      				}).catch((e)=>{
      					console.log(e);
      				});
            },
            add_attention(uid,status){
                if (!this.$store.state.user_info) {
                  this.action = ''
                  this.$refs.AccountPannel.show()
                  return false
                }              
                var v = this;
                this.https.get('/common/add_attention',{
                    params:{
                        aid : uid
                    }
                }).then((r)=>{
                    if(r.data.code == 1){
                        v.$Message.success(r.data.msg);
                        if (status == 1) {
                            v.news_details.is_attention = 0;
                        }else{
                            v.news_details.is_attention = 1;
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
* {
		box-sizing: border-box;
	}
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
  .icon-answer {
      font-size: .4rem;
  }
	#news_detail{
		.container{
			width: 1200px;
			min-height: 80vh;
            margin: 10px 0 30px 0;
			.news-detail{
				.news-title{
					font-size: 28px;
					color: #333333;
					font-weight: bold;
				}
				.news-infos{
					padding: 20px 0;
					height: 80px;
            .pubInfo {
							display: flex;
							display: -webkit-flex;
              justify-content: flex-start;
              align-items: center;
              .news-info {
                display: inline-block;
                font-size: 14px;
                color: #666;
                padding-right: 12px;
              }
              .title-hidden {
                max-width: 90px;
								color: #4b4b4b;
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
            }
					.share {
						margin-top: 3px;
					}
				}
				.news-brief {
					font-size: 16px;
					color: #999;
					background-color: #f7f7f7;
					text-align: justify;
					padding: 22px;
					border-radius: 3px;
					-webkit-border-radius: 3px;
					-moz-border-radius: 3px;
					-khtml-border-radius: 3px;
				}
				.news-content {
					padding-top: 30px;
					font-size: 16px;
					color: #333;
					white-space: pre-wrap;
					text-align: justify;
				}
				.news-footer{
					padding-top: 50px;
					.news-footer-content{
						text-align: center;
						font-size: 14px;
						margin-top: 15px;
					}
					.qrcode{
						margin-top: 20px;
						position: relative;
						padding-top: 100%;
						img{
							position: absolute;
							width: 100%;
							height: 100%;
							top: 0px;
							left: 0px;
						}
					}
          .signature{
              padding-top: 20px;
              position: relative;
              img{
                width: 100%;
                height: 100%;
              }
              .sign_url{
                  position: absolute;
                  top: 0;
                  left: 0;
                  height: 100%;
                  width: 100%;
                  opacity:0;  
              }
          }
					.deal-frame{
						padding-top: 50px;
						.news-deal{
							padding-left: 10px;
							padding-right: 10px;
						}
						.top,.collect{
							padding-top: 5px;
							height: 52px;
							border-radius: 25px;
							font-size: 14px;
							text-align: center;
							cursor: pointer;
						}
						.top{
							background-color: #ffd100;
							&:hover{
								background-color: #ffe056;
							}
						}
						.collect{
							background-color: #18bec4;
							&:hover{
								background-color: #3dcfd4;
							}
						}
						.button-active{
						    color: #999999;
						    background-color: #ededed;
						    &:hover{
								background-color: #ededed;
							}
						}
					}
				}
			}
	        .components-title {
	            text-align: center;
	            font-size: 16px;
	            font-weight: bold;
	            border-top: 2px solid #28b28a;
	            border-bottom:1px solid #e0e0e0;
	            border-style: solid none dashed none;
	            height: 1rem;
	            line-height: 1rem;
	            position: relative;
	            .title-image{
	                position: absolute;
	                right: 0.5rem;
	                top: 45%;
	                cursor: pointer;
	            }
	        }
			.authorList {
		      .author {
            text-align: left;
            border: 1px solid #efefef;
  		      padding: 15px;
            height: 100%;
	        .author-avatar {
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
								background: #ccc;
							}
						}
	      }
        .author-info {
        	padding-top: 10px;
        	padding-left: 10px;
          .author-username-frame{
            .author-name {
                width: auto;
                max-width: 120px;
                display: inline-block;
                overflow: hidden;
              span{
                height: 20px;
                overflow: hidden;
                display: block;
                font-size: 14px;
                font-weight: bold;
                color: #444;
                cursor: pointer;
              }
            }
            img{
              padding:0px 3px 0px 3px;
            }
          }
	      }
            .author-brief {
                margin-top: 15px;
                overflow : hidden;
                .author-brief-inner {
                    font-size: 12px;
                    color: #888;
                    line-height: 2;
			              text-align: justify;
                }
            }
            .occupy{
            	height: 20px;
            	border-bottom: 1px solid #efefef;
            }
            .author-news{
            	font-size: 14px;
            	color: #888;
            	padding-top:10px;
            	.author-news-list{
            		margin-top: 10px;
              	.author-news-title {
				          width: 100%;
              		color: #333333;
              		font-size: 14px;
              		font-weight: bold;
				          line-height: 14px;
              		height: 30px;
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
            	.author-news-time {
            		font-size: 12px;
            		color: #b8b8b8;
            	}
            	.author-news-cname {
            		font-size: 12px;
            		color: #84b3de;
            		text-align: right;
            	}
          	}
          	.more-news {
          		padding: 20px 0 10px 0;
          		.readmore-button {
								height: 40px;
								width: 100%;
								font-size: 14px;
								line-height: 14px;
								padding: 8px 20px;
								border-radius: 3px;
								text-align: center;
								cursor: pointer;
								background: #28b28a;
								border: 1px solid #28b28a;
								color: #fff;
								letter-spacing: 2px;
								&:hover {
									color: #fff;
									background: #149f77;
									border-color: #149f77 !important;
									transition: #149f77 .2s linear,background-color .2s linear,border-color .2s linear;
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
			.comment-text {
				color: #666;
				font-size: 14px;
				min-height: 30px;
				width: 100%;
				padding: 15px;
				margin-top: 100px;
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
		.relate-news {
	    	margin-top: 35px;
	    	font-size: 14px;
	    	color: #333;
	    	font-weight: bold;
	    }
    	.relate-news-title{
    		li {
    			margin-top: 20px;
    			height: 20px;
	    		a {
	    			font-size: 14px;
	    			color: #333;
	    			&:hover {
	    				color: #28b28a;
	    			}
            .title {
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
	    		}	    			
    		}
    	}	
    	.next-news-frame{
    		margin-top: 30px;
    		padding:15px 15px 15px 15px;
    		border:1px solid #f2f2f2;
    		.next-news{
    			font-size:14px;
    			color: #999999; 
    		}
    		.next-news-title{
    			padding-top: 15px;
    			a{
    				color: #333333;
	    			font-size: 18px;
	    			font-weight: bold;
	    			cursor: pointer;
	    			&:hover{
	    				color: #28b28a;
	    			}
    			}
    		}
    		.next-news-info{
    			color: #999999;
    			padding-top: 15px;
    			span{
    				display: inline-block;
    				width: 50%;
    				float: left;
    			}
    		}	
    		.next-news-time{
    			text-align: left;
    		}
    		.next-news-cat{
    			text-align: right;
    			color: #84b3de;
    		}
    	}    
	}
</style>