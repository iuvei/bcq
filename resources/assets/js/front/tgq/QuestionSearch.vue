<template>
<div id="search">
	<NavHeader></NavHeader>
	<Row type="flex" justify="center">
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
				<BreadcrumbItem>互动</BreadcrumbItem>
				<BreadcrumbItem to="/questionpage">问答</BreadcrumbItem>
				<BreadcrumbItem>搜索问答</BreadcrumbItem>
			</Breadcrumb>

			<Row type="flex" justify="space-between">
				<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">

						<Row :class-name="'search'">
							<Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}">
								<input class='search-frame button-height' placeholder="请输入您要查找的问题" v-model="keywords">
							</Col>
							<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
								<div class='search-button button-height' @click="search">
									<i class="icon icon-search2"></i>搜索
								</div>
							</Col>
						</Row>
						<Row :class-name="'content'">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'search-result'">
								<p>
									共为您找到相关结果 <b>{{search_list.length}}</b>个
								</p>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'list-frame'">
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in search_list" :key="key"  :class-name="'search-list'">
									<Col :class-name="'list-title'">
										<a @click="go(item.id)">{{item.title}}</a>
									</Col>
									<Col :class-name="'list-brief'">
										{{item.brief}}
									</Col>
									<Col :class-name="'list-info'">
										<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
											<span> {{item.time}} </span>
											<span><i class="icon icon-message3"></i>{{item.comment}}</span>
										</Col>
										<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'list-username'">
											<i class="icon icon-user"></i>{{item.username}}
										</Col>
									</Col>
								</Col>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'no-result'">
								<div v-if="no_serch" class="no-serch">
									<p>未找到与"<b>{{no_serch_keywords}}</b>"的相关问题</p>
								</div>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<div v-if="loading">
									<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
										<Spin fix>
											<Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
											<div>努力搜索中</div>
										</Spin>
									</Col>
								</div>
							</Col>
						</Row>
				</Col>
				<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
					<PageRight :page-id="page_id"></PageRight>
				</Col>
			</Row>
        </Col>
	</Row>
	<FooterArea></FooterArea>
    <FloatSideBar></FloatSideBar>
</div>

</template>

<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import PageRight from '../components/MainRight.vue';
export default{
	components: {NavHeader,FooterArea,FloatSideBar,PageRight},
	mounted(){
        document.title = '菠菜圈| 搜索问答';
		this.keywords = this.$route.query.keywords
		this.search()
	},
	data(){
		return {
            page_id: 2,
			keywords:'',
			search_list:'',
			loading:true,
			no_serch:false,
			no_serch_keywords:''
		}
	},
	methods:{
		go(id){
			this.$router.push('/questiondetail/' + id)
		},
		search(model,keywords){
			var keywords = this.keywords
			var v = this
			v.https.get('/front/components/search',{
				params:{
					keywords:keywords,
					model:'Question'
				}
			}).then((r)=>{
				v.search_list = r.data
				if (!v.search_list.length) {
					v.no_serch = true
					v.no_serch_keywords = v.keywords
				}else{
					v.no_serch = false
				}
				v.loading = false
				console.log(r.data)
			}).catch((e)=>{
				console.log(e)
			})
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
	.icon-message3 {
		margin-right: 5px;
		vertical-align: text-bottom;
	}
	.icon-user {
		margin-right: 5px;
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
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
    .common-button3 {
        color: white!important;
        background-color: #28b28a !important;
        width: 100%;
        padding: 0px;
        border-radius: 3px;
        text-align: center;
        border: 1px solid #28b28a;
        &:hover{
            color: white;
            background-color: #149f77 !important;
            border-color: #149f77 !important;
            transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
            transition-property: color, background-color, border;
            transition-duration: 0.2s, 0.2s, 0.2s;
            transition-timing-function: linear, linear, linear;
            transition-delay: initial, initial, initial;
        }
    }
    .button-height {
        height: 40px;
        line-height: 40px;
    }

#search {
	.container{
		width: 1200px;
		min-height: 10rem;
		margin: 20px auto;
		.search {
			margin-top: 20px;
			width: 100%;
			text-align: left;
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
				font-size:16px;
				border-radius: 0 3px 3px 0;
				&:hover {
					background-color: #149f77;
				}
			}
		}
		.content {
			width: 100%;
			height: auto;
			margin: 0 auto;
			padding: 10px 0 30px 0;
			.search-result {
				text-align: left;
				padding: 10px 0;
				p {
					color: #999;
					font-size: 14px;
					padding: 10px 0;
					b {
						margin: 3px;
						font-size: 14px;
						font-weight: bold;
						color: #777;
					}
				}
			}
			.no-result {
				.no-serch {
					text-align: left;
					letter-spacing: 1px;
					padding: 15px 20px;
					background-color: #eaf3fe;
					border: 1px solid #eaeaea;
					p {
						color: #333;
						font-size: 16px;
						padding: 10px 0;
						b {
							font-size: 16px;
							font-weight: bold;
							color: #e4393c;
						}
					}
				}
			}
			.question-frame {
				position: relative;
				.answer-img {
					position: absolute;
					right: 0;
					top: 50%;
					margin-top: -14px;
					a {
						display: block;
						text-align: center;
						width: 27px;
						height: 27px;
						img {
							width: 100%;
							height: 100%;
							vertical-align: middle;
						}
					}
					.common-button2 {
						margin-top: 20px;
						height: 30px!important;
					}
				}
				&:hover{
					background-color: #f2f2f2;
				}
				padding: 10px 0px 10px 5px;
				border-bottom: 1px solid #f2f2f2;
			}
		}
		.list-frame {
			.search-list {
				padding:10px;
				border-top: 1px solid #efefef;
				&:hover {
					background-color: #f2f2f2;
				}
				.list-title {
					width: 100%;
					height: 30px;
					line-height: 30px;
					font-size: 18px;
					color: #333;
					font-weight: bold;
					cursor: pointer;
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
				.list-brief {
					cursor: pointer;
					margin-top: 15px;
					font-size: 14px;
					height: 45px;
					color: #666;
					overflow: hidden;
					text-overflow: ellipsis;
					-o-text-overflow:ellipsis;
					-moz-text-overflow:ellipsis;
					display: -webkit-box;
					-webkit-line-clamp: 2;
					-webkit-box-orient: vertical;
				}
				.list-info {
					font-size: 12px;
					padding-top: 20px;
					color: #999;
					overflow: hidden;
					cursor: pointer;
					.list-username {
						cursor: pointer;
						font-size: 12px;
						color: #666;
						text-align: right;
						padding-right: 10px;
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
					span {
						padding-right: 15px;
					}
				}
			}
				.user-info {
					padding: 10px 0 0 0;
					.user-name {
						font-size: 14px;
						padding-bottom: 5px;
						overflow: hidden;
						text-overflow: ellipsis;
						-o-text-overflow:ellipsis;
						display: -webkit-box;
						-webkit-line-clamp: 1;
						-webkit-box-orient: vertical;
					}
				}
		}
	}
}
</style>