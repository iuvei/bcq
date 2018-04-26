<template>
	<div id="enterprise">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<Row type="flex" justify="space-between">-->
                    <!--<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">-->
            		    <!--<div class="bread">-->
							<!--<div class="bread-text"><a href="/">首页</a> > <a>资料</a> > 企业库 </div>-->
						<!--</div>-->
                    <!--</Col>-->
                <!--</Row>-->

				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem>企业库</BreadcrumbItem>
				</Breadcrumb>

				<Row type="flex"  justify="start" :gutter="20" align="top" :class-name="'ents'">
					<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" v-for="(val,key) in enterpriseList" :key="key"
						 style="margin-bottom:20px;">
						<Row :class-name="'ent'" type="flex" align="middle">
							<Col span="11" :class-name="'ent-l'">
								<a :href="'/userdata/EnterpriseDetail/'+val.id"><img :src="val.logo" :title="val.title" onerror="this.src='/static/noimg.png'" ></a>
							</Col>
							<Col span="13" :class-name="'ent-r'">
                                <h2><a :href="'/userdata/EnterpriseDetail/'+val.id">{{val.title}}</a> <img v-if="val.famous" src="/static/enp-logo.png" class="Icon-crown"></h2>
                                <p>公司规模：<template v-for="(scale,key) in scaleList" v-if="scale.val == val.scale">{{scale.name}}</template></p>
                                <p>公司地址：<template v-for="(region,key) in regionList" v-if="region.val == val.region">{{region.name}}</template></p>
							</Col>
						</Row>
					</Col>
					<div class="enterprise-page">
						<Page :total="enterpriseCount" :page-size="limit" @on-change="setPage" :class-name="'common-page'"></Page>
					</div>
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
import $ from 'jquery';

	export default{
		components: {NavHeader,FooterArea,FloatSideBar},
		mounted(){
            document.title = '菠菜圈| 企业库';
		    var v = this;
			this.https.get('/front/enterprise/render')
			.then((r)=>{
				v.enterpriseList = r.data.enterpriseList;
                v.scaleList = r.data.scaleList;
                v.regionList = r.data.regionList;

                v.enterpriseCount = r.data.enterpriseCount;
                v.limit = r.data.limit;

                $(".ivu-page-prev").html('上一页').siblings(".ivu-page-next").html('下一页');
			}).catch((e)=>{
				console.log(e);
			});
		},
		data(){
			return {
                enterpriseList: '',
                scaleList: '',
                regionList: '',
                enterpriseCount: 0,
                limit: 10,
                page: 1,
			}
		},
		methods:{
            setPage(page){
                this.page = page;
                this.postOpt();
            },
            postOpt(){
                var v = this;
                this.https.post('/front/enterprise/filter', {
                    page: this.page,
                })
				.then(function (response) {
					v.enterpriseList = response.data.enterpriseList;
					v.enterpriseCount = response.data.enterpriseCount;
					v.page = 1;
				})
				.catch(function (error) {
					console.log(error);
				});
            },
		}
	}	
</script>
<style lang="scss" scoped>
#enterprise{
    font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	.container {
		width: 1200px;
        margin: 20px auto;
        min-height: 10rem;
		.ents {
			margin-top: 15px;
			.ent {
				height: 140px;
				border:1px dashed #e0e0e0;
				border-radius: 5px;
				.ent-l {
					img {
						width: 150px;
						height: 98px;
                        background: #f2f2f2;
					}
				}
                .ent-r {
                    h2 {
						a{
							font-size: .28rem;
							color: #333;
							font-weight: 700;
							line-height: 1;
							padding: 0 0 5px 0;
						}
                        img {
                            width: 30px;
                            height: 22px;
                            margin-left: 8px;
                            vertical-align: baseline;
                        }
                    }
                    p {
                        padding-top: 6px;
                        font-size: .24rem;
                        color: #666;
                    }
                }
			}
			.enterprise-page{
				width: 100%;
				text-align: center;
				margin: 50px;
			}
		}
	}	
}
</style>
