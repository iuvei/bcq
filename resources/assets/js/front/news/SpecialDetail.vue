<template>
	<div id="SpecialDetail">
    <NavHeader></NavHeader>
		<Row type="flex" justify="center">
			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">

			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
				<BreadcrumbItem>资讯</BreadcrumbItem>
				<BreadcrumbItem to="/news/special">产业专题</BreadcrumbItem>
				<BreadcrumbItem>专题详情</BreadcrumbItem>
			</Breadcrumb>

			<Row type="flex" justify="space-between">
				<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
				<Row type="flex" justify="start" align="middle" :class-name="'special-frame'">
					<h2 class="special-title">{{special.title}}</h2>
					<p class="special-info">
						{{special.created_at}}
					</p>
					<div class="special-brief">
						<div class="brief-box">
							<p class="brief-label">事件回顾：</p>
							<p class="brief-content">{{special.content}}</p>
						</div>
					</div>
				</Row>
				<Row type="flex" justify="start" align="middle" :class-name="'special-news'">
					<p class="news-label">事件相关新闻</p>
					<Row type="flex" justify="space-between" align="middle" :class-name="'news'"
							 v-for="(news,key) in special_news" :key="key">
						<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}" :class-name="'news-title'">
						<b class="dot"></b>
						<a :href="'/news/newspage/'+news.nid" target="_blank">{{news.title}}</a>
						</Col>
						<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'news-author'">
						<a @click="go('/user/userzone/'+news.uid)">{{news.authorName}}</a>
						</Col>
					</Row>
				</Row>
				<Row v-if="loading">
					<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}"
							 :lg="{'span':8,'offset':8}">
					<Spin fix>
						<Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
						<div>Loading</div>
					</Spin>
					</Col>
				</Row>
				<Row v-if="!loading">
					<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
					<center>
						<Button :class="'load-more'" @click="get_more" v-if="more_news">浏览更多</Button>
					</center>
					</Col>
				</Row>
				</Col>
				<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
				<PageRight :page-id="page_id">
				</PageRight>
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
        document.title = '菠菜圈| 专题详情';
        var v = this;
        this.special_id = this.$route.params.special_id;
        this.https.get('/front/special_details/render',{
            params: {
                sid: v.special_id
            }
        }).then((r)=>{
            if (r.data.special instanceof Array && r.data.special.length == 0){
                v.$Message.warning('该信息不存在或已删除!');
                setTimeout(function () {
                    v.$router.push('/news/special');
                },2000)
            }
            v.loading = false;
            v.special = r.data.special;
            v.special_news = r.data.special_news;
        }).catch((e)=>{
            console.log(e)
        });
    },
	data(){
		return {
            page_id:20,
            special_id:'',
			page:1,
			loading:true,
			special:'',
            special_news:'',
			more_news:true
		}
	},
	methods:{
        go: function (path) {
            var path = path;
            this.$router.push({path: path});
        },
		get_more(){
    		this.loading = true;
    		var v = this;
	        this.https.get('/front/special_details/get_special_news',{
		        	params:{
                        page : v.page + 1,
                        sid: v.special_id
                    }
	            }).then((r)=>{
	                v.loading = false;
	                v.page = v.page + 1;
                    if (r.data.special_news.length>0) {
                        v.special_news = v.special_news.concat(r.data.special_news);
                    }else{
                        v.more_news = false;
                        v.$Message.warning('已无更多数据');
                    }
	            }).catch((e)=>{
	                console.log(e)
	        });
		}
	}
}
</script>

<style lang="scss" scoped>
	#SpecialDetail {
		.container{
			width: 1200px;
			min-height: 80vh;
			margin: 20px auto;
			.special-frame{
				margin-bottom: 15px;
				.special-title {
					width: 100%;
					font-size: 34px;
					color: #333333;
					font-weight: bold;
					overflow: hidden;
					text-overflow: ellipsis;
					-o-text-overflow:ellipsis;
					-moz-text-overflow:ellipsis;
					white-space: nowrap;
					cursor: pointer;
					&:hover{
						color:#28b28a;
					}
				}
				.special-info {
					width: 100%;
					font-size: 14px;
					color: #666;
					margin-top: 15px;
				}
				.special-brief {
					width: 100%;
					height: 100%;
					font-size: 16px;
					margin-top: 30px;
					background-color: #f7f7f7;
					.brief-box {
						width: 100%;
						min-height: 98px;
						line-height: 1;
						border-left: 6px solid #28b28a;
						padding: 15px 15px;
						letter-spacing: 2px;
						.brief-label {
							padding: 0 0 10px 0;
							margin-bottom: 10px;
							font-size: 16px;
							font-weight: bold;
							color: #333;
						}
						.brief-content {
							width: 100%;
							min-height: 32px;
							font-size: 16px;
							line-height: 1.5;
							color: #666;
							font-weight: normal;
							text-align: justify;
							overflow: hidden;
							text-overflow: ellipsis;
							-o-text-overflow:ellipsis;
							-moz-text-overflow:ellipsis;
							-moz-line-clamp: 2;
							-webkit-line-clamp: 2;
							line-clamp: 2;
							display: -webkit-box;
							-webkit-box-orient: vertical;
						}
					}
				}
			}
			.special-news {
				margin-top: 40px;
				.news-label{
					font-size: 20px;
					color: #333;
					margin-bottom: 22px;
					font-weight: bold;
					width: 100%;
				}
				.news{
					width: 100%;
					padding: 5px 10px;
					&:hover{
						 background-color: #f2f2f2;
					}
					div {
						overflow: hidden;
						height: 30px;
						line-height: 30px;
					}
					.news-title {
						color: #333;
						font-size: 16px;
						font-weight: bold;
						overflow: hidden;
						text-overflow: ellipsis;
						-o-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						white-space: nowrap;
						.dot {
							display: inline-block;
							width:4px;
							height: 4px;
							border-radius: 50%;
							background: #28b28a;
							margin-right: 7px;
							vertical-align: middle;
						}
						a {
							color: #333;
							cursor: pointer;
							&:hover{
								color: #28b28a;
							}
						}
					}
					.news-author {
						text-align: right;
						cursor: pointer;
						a {
							font-size: 14px;
							text-align: right;
							color: #666;
							&:hover, &:focus {
								color: #28b28a;
							}
						}
					}
				}
			}
		}
	}
</style>