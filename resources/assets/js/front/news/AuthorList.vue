<template>
 <div id="author-list">
   <NavHeader></NavHeader>
   <Row type="flex" justify="center">
	   <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
		 	 <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				 <BreadcrumbItem to="/">首页</BreadcrumbItem>
				 <BreadcrumbItem>资讯</BreadcrumbItem>
				 <BreadcrumbItem>专栏作者</BreadcrumbItem>
			 </Breadcrumb>
	     <Row type="flex" justify="space-between">
	       <Col :xs="24" :sm="24" :lg="24" :class-name="'author-intro'">
	         <div class="author-intro-text">
             <img src="/static/game-notice.png">
	           <p>
	             菠菜圈开放【作者互利计划】，成为菠菜圈作者，获得商业机会，共享菠菜圈每日万级产业精准流量，点此 <a href="/news/beAuthor" target="_blank">查看详情</a> 并成为菠菜圈作者
	           </p>
	         </div>
	       </Col>
	       <Col :xs="12" :sm="12" :lg="12" :class-name="'author-tab'">
	         <span @click="change_tab(1)" v-bind:class="{'active-tab':activeTab==1}">最热门作者</span>
	         <span @click="change_tab(2)" v-bind:class="{'active-tab':activeTab==2}">最新作者</span>
	       </Col>
	       <Col :xs="12" :sm="12" :lg="12" :class-name="'author-tab-right'">
	         感谢以下作者为菠菜圈的前进及行业进步做出贡献
	       </Col>
	     </Row>
	     <Row type="flex" justify="start" :class-name="'author-list-frame'">
	       <Col :xs="7" :sm="7" :lg="7" :class-name="'author-list'" v-bind:class="{'right-list':(key+1)%3==0}" v-for="(item,key) in activeList" :key="key">
				   <Card>
			       <Row type="flex" align="middle" justify="center">
			         <Col :xs="5" :sm="5" :lg="5">
								 <center>
                    <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
  									 <div class="avatar-frame-new">
  										 <img v-bind:src="item.image" onerror="this.src='/static/noimg.png'">
  									 </div>
                    </a>
								 </center>
			         </Col>
			         <Col :xs="19" :sm="19" :lg="19">
								 <div class="user-info">
									 <div class="username-frame" v-bind:title="item.username">
                      <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
    										<span class="username">{{item.username}}</span>
                      </a>
  										<img src="/static/author_confirm.png">
                       <div v-if="item.is_attention!=-1" class="attention-frame">
                        <Button class="common-button5-attention" v-if="item.is_attention==1"
                                @click="add_attention(item.uid,1,key)">
                          已关注
                        </Button>
                        <Button class="common-button5" v-else @click="add_attention(item.uid,0,key)">
                          十 关注
                        </Button>
                      </div>                      
									 </div>
                   <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
  									 <div class="publish">
                        <span class="user-desc">{{item.desc}}</span>                 
  									 </div>
                   </a>
								 </div>
			         </Col>
			         <Col :xs="24" :sm="24" :lg="24">
                 <div class="brief">
                   简介：{{item.brief}}
                 </div>
					     </Col>
					     <Col :xs="24" :sm="24" :lg="24" :class-name="'recent-news'">
					       最近文章
					     </Col>
					     <Col :xs="24" :sm="24" :lg="24" :class-name="'recent-title'" v-bind:title="item.recent_news[0]?item.recent_news[0].title:'暂无发表文章'">
                 <span v-if="item.recent_news[0]" @click="go('/news/newspage/'+item.recent_news[0].id)" class="pointer">
                   {{item.recent_news[0].title}}
                 </span>
                 <span v-else>
                   暂无发表文章
                 </span>
					     </Col>
					     <Col :xs="12" :sm="12" :lg="12" :class-name="'news-info time'">
					       {{item.recent_news[0]?item.recent_news[0].time:''}}&nbsp
					     </Col>
               <Col :xs="12" :sm="12" :lg="12" :class-name="'news-info cat'">
                 <a>{{item.recent_news[0]?item.recent_news[0].cname:''}}</a>&nbsp
               </Col>
               <Button class="common-button3" @click="go('/user/userzone/'+item.uid)">阅读更多，点击这里</Button>
				     </Row>
				   </Card>
	       </Col>
	     </Row>
	   </Col>
   </Row>
   <Row v-if="loading">
     <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
       <Spin fix>
         <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
         <div>Loading</div>
       </Spin>
     </Col>
   </Row>
   <Row v-if="!loading">
     <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
       <center>
         <Button class="load-more" @click="get_list(activeTab)" v-if="has_more">浏览更多</Button>
       </center>
     </Col>
   </Row>
   <div style="height:30px;"></div>
   <FloatSideBar></FloatSideBar>
   <FooterArea></FooterArea>
   <AccountPannel ref="AccountPannel"></AccountPannel>
 </div>
</template>

<script>
    import PageRight from '../components/MainRight.vue';
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';
    import JQ from 'jquery';
    import AccountPannel from '../components/AccountPanel.vue';
	export default {
		mounted(){
			document.title = '菠菜圈| 专栏作者';
			var v = this;
			this.get_list(1)
		},
		components: {NavHeader,FooterArea,FloatSideBar,AccountPannel},
		data(){
			return {
        activeList:[],
        activeTab:1,
        page:0,
        loading:false,
        has_more:true
			}
		},
		methods: {
			go(path){
				this.$router.push(path)
			},
      add_attention(uid,status,key){
        if (!this.$store.state.user_info) {
          this.$refs.AccountPannel.show()
          return false
        }
        var v = this
        this.https.get('/common/add_attention',{
            params:{
              aid : uid
            }
        }).then((r)=>{
            if(r.data.code == 1){
              if (status == 1){
                v.activeList[key].is_attention = 0
              }else{
              	v.activeList[key].is_attention = 1
              }
            }else{
              v.$Message.error(r.data.msg)
            }
        }).catch((e)=>{   
            console.log(e)
        })
      },
      change_tab(type){
      	if (type == 1) {
          this.activeList = []
          this.page = 0
      		this.get_list(1)
      		this.activeTab = 1
      	}else{
          this.activeList = []
          this.page = 0
      		this.get_list(2)
      		this.activeTab = 2
      	}
      },
      get_list(type){
				var v = this
        v.loading = true
				this.https.get('/front/auth_list/render',{
						params:{
							type:type,
              page:v.page
						}
          }).then((r)=>{
              v.loading = false
              v.page = v.page + 1
              if (r.data.authorList.length) {
                v.activeList = v.activeList.concat(r.data.authorList)
              }else{
                v.has_more = false
              }
            }).catch((e)=>{   
              console.log(e)
		        })
          }                 
      } 
	}
</script>

<style lang="scss" scoped>
#author-list {
	.container {
		width:1200px;
    min-height: 100vh;
    margin: 20px auto;
    .author-intro {
      padding-top:30px;
      .author-intro-text {
        		padding:10px;
            border: 1px solid #9bc3ff;
            background: #f4f8ff;
            text-align: left;
        		font-size: 14px;
        		display: table;
        		width: 100%;
        		border-radius: 5px;
        		a{
        			font-weight: bold;
        		}
        		img,p{
        			display: table-cell;
        			vertical-align: middle;
        		}
        		p{
        			padding-left: 10px;
        		}
        	}      	
        }
	    .author-tab{
        	padding-top: 30px;
        	font-size: 16px;
        	font-weight: bold;
        	color: #333333;
        	cursor: pointer;
        	.active-tab{
        		color: #28b28a;
        	}
        	>span{
        		padding:0px 20px 0px 10px;
        	}
        }
        .author-tab-right{
        	padding-top: 30px;
        	text-align: right;
        	font-size: 14px;
        }         
        .author-list-frame {
        	padding-top: 10px;
          .author-list {
            padding: 15px 0px 15px 0px;
            margin-right: 70px;
          }
          .right-list {
            margin-right: 0px;
          }
          .user-info {
            padding-left: 10px;
            font-size: 18px;
            .username-frame {
              width: 100%;
              position: relative;
              .username{
                display: inline-flex;
                max-width: 120px;
                height: 27px;
                overflow: hidden;
                color: #333;
              }
              img{
                display: inline-flex;
              }
              .attention-frame{
                position: absolute;
                width: 80px;
                right: 0;
                top: 0px;
              }
            }
          }
          .publish{
            padding-top: 5px;
            font-size: 12px;
          }
          .brief {
            margin-top: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            font-size: 12px;
            height: 38px;
            font-color: #666666;
          }
          .recent-news {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #f2f2f2;
            color: #666666;
          }
          .recent-title {
            margin-top: 10px;
            overflow: hidden;
            text-overflow: ellipsis;
            -o-text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            font-size: 14px;
            height: 20px;
            font-weight: bold;
            font-color: #333333;
            &:hover {
              color: #28b28a;
            }
          }
          .news-info {
            padding-top: 10px;
            height: 20px;
          }
          .time {
            font-size: 12px;
            color: #999999;
          }
          .cat {
            font-size: 12px;
            text-align: right;
          }
          .common-button3 {
            height: 42px;
            margin-top: 30px;
            font-size: 16px;
          }
    }
	}
}
</style>