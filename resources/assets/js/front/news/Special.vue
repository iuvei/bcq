<template>
	<div id="special">
    <NavHeader></NavHeader>
		<Row type="flex" justify="center">
      <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资讯</BreadcrumbItem>
					<BreadcrumbItem>产业专题</BreadcrumbItem>
				</Breadcrumb>
        <Row type="flex" justify="space-between">
          <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
						<Row type="flex" justify="center" align="middle" :class-name="'special-frame'" v-for="(special,key) in specialList" :key="key">
							<Col :class-name="'special-list-left'" :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
								<img :src="special.image" onerror="this.src='/static/noimg.png'" :title="special.title">
							</Col>
							<Col :class-name="'special-list-right'" :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
                <a :href="'/news/SpecialDetail/'+special.id" target="_blank"><h2 class="special-title">{{special.title}}</h2></a>
                <div class="special-brief">{{special.content.substring(0,70)}}
                  <span v-if="special.content.length>70">...</span>
                  <a :href="'/news/SpecialDetail/'+special.id" target="_blank">[详情]</a>
                </div>
                <div class="special-info">
									<span>{{special.time}}</span>
								</div>
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
					        <Button :class="'load-more'" @click="get_more" v-if="more_special">浏览更多</Button>
					      </center>
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
import PageRight from '../components/MainRight.vue';
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';

export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar},
    mounted(){
        document.title = '菠菜圈| 产业专题';
        var v = this;
        this.https.get('/front/special/render',{
        }).then((r)=>{
            v.loading = false;
            v.specialList = r.data.specialList;
        }).catch((e)=>{
            console.log(e)
        });
    },
	data(){
		return {
			page:1,
			loading:true,
			specialList:[],
			more_special:true,
            page_id:19
		}
	},
	methods:{
		get_more(){
    		this.loading = true;
    		var v = this;
	        this.https.get('/front/special/get_special_list',{
		        	params:{
                        page : v.page
                    }
	            }).then((r)=>{
	                v.loading = false;
	                v.page = v.page + 1;
                    if (r.data.length>0) {
                        v.specialList = v.specialList.concat(r.data);
                    }else{
                        v.more_special = false;
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
  .load-more {
    margin-bottom: 30px;
  }
	#special{
		.container {
			width: 1200px;
			min-height: 80vh;
			margin: 20px auto;
			.special-frame {
				height: 150px;
				padding: 10px 10px;
				border-bottom: 1px solid #efefef;
				display: -webkit-flex;
				justify-content: flex-start;
				align-items: center;
				&:hover {
					background-color: #f2f2f2;
				}
				.special-list-left {
					width: 210px;
					height: 131.25px;
					overflow: hidden;
					border-radius: 3px;
					text-align: center;
          			border: 1px solid #f2f2f2;
					&:hover img, &:focus img {
						transform: scale(1.1);
						-webkit-transform: scale(1.1);
						-moz-transform: scale(1.1);
						-o-transform: scale(1.1);
						-ms-transform: scale(1.1);
					}
					img {
						width: 100%;
						height: 100%;
						transition: all .5s;
						-webkit-transition: all .5s;
						-moz-transition: all .5s;
						-o-transition: all .5s;
						-ms-transition: all .5s;
					}
				}
				.special-list-right {
					width: 70%;
					height: 120px;
					padding: 0 0 0 10px;
					.special-title {
						font-size: 18px;
						color: #333333;
						font-weight: bold;
						overflow: hidden;
						text-overflow: ellipsis;
						-o-text-overflow:ellipsis;
						-moz-text-overflow:ellipsis;
						white-space: nowrap;
						cursor: pointer;
						&:hover {
							 color:#28b28a;
						 }
					}
					.special-brief {
						font-size: 14px;
						height: 60px;
						color: #666;
						padding: 15px 0;
						margin-bottom: 10px;
						overflow: hidden;
						text-overflow: ellipsis;
						-o-text-overflow: ellipsis;
						-webkit-line-clamp: 2;
						display: -webkit-box;
						-webkit-box-orient: vertical;
						a {
							color: #28b28a;
							&:hover {
								color: #149f77;
							}
						}
					 }
					.special-info {
						font-size: 12px;
						color: #999;
					 }
				}
			}
		}
	}
</style>