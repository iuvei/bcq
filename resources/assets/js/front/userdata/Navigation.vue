<template>
	<div id="navigation">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem>优质网址导航</BreadcrumbItem>
				</Breadcrumb>
				<ul class="wrapper">
					<li v-for="(cat,key) in navlist" :key="key">
						<div class="left"><label class="label-name">{{key}}</label></div>
						<div class="right">
							<a v-for="(nav,key) in cat.navs" v-bind:href="nav.url" target="_blank">{{nav.title}}</a>
						</div>
					</li>
					<!--<Row type="flex" align="top" v-for="(cat,key) in navlist" :key="key" :class-name="'navs'">-->
						<!--<Col  :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'nav-cat'">-->
							<!--<span class="cat-name">{{key}}</span>-->
						<!--</Col>-->
						<!--<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}">-->
							<!--<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" v-for="(nav,key) in cat.navs" :key="key" :class-name="'nav-detail'">-->
								<!--<a v-bind:href="nav.url" target="_blank">-->
									<!--{{nav.title}}-->
								<!--</a>-->
							<!--</Col>-->
						<!--</Col>-->
					<!--</Row>-->
				</ul>
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
		components: {NavHeader,FooterArea,FloatSideBar},
		mounted(){
            document.title = '菠菜圈| 优质网址导航';
		    var v = this;
			this.https.get('/api/front/navigation/render')
			.then((r)=>{
				v.navlist = r.data.navList;
			}).catch((e)=>{
				console.log(e);
			});
		},
		data(){
			return {
                navlist:''
			}
		}
	}	
</script>

<style lang="scss" scoped>
#navigation {
	.container {
		width: 1200px;
		min-height: 10rem;
		margin: 20px auto;
		.wrapper {
			border: 1px solid #efefef;
			border-radius: 10px;
			padding: 40px 30px;
			&:hover, &:focus {
				-webkit-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
				-moz-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
				box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
			}
		}
		ul {
			li {
				width: 100%;
				min-height: 52px;
				display: flex;
				display: -webkit-flex;
				align-items: flex-start;
				justify-content: flex-start;
				margin-bottom: 25px;
				.left {
					width: 15%;
					height: 52px;
					overflow : hidden;
					text-overflow: ellipsis;
					-webkit-text-overflow: ellipsis;
					-moz-text-overflow: ellipsis;
					-ms-text-overflow: ellipsis;
					white-space: nowrap;
					-moz-white-space: nowrap;
					-webkit-white-space: nowrap;
					-o-white-space: nowrap;
					.label-name {
						font-size: 18px;
						color: #28b28a;
						font-weight: bold;
						padding: 0 10px 0 10px;
						border-left: 3px solid #28b28a;
					}
				}
				.right {
					width: 85%;
					height: auto;
					display: flex;
					display: -webkit-flex;
					align-items: flex-start;
					justify-content: flex-start;
					flex-wrap: wrap;
					align-content: flex-start;
					margin-left: 20px;
					a {
						font-size: 16px;
						font-weight: 500;
						color: #666;
						margin-right: 30px;
						margin-bottom: 20px;
						&:hover {
							color: #28b28a;
							text-decoration: underline;
						}
					}
				}
			}
		}
	}	
}
</style>