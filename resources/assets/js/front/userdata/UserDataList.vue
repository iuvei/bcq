<template>
	<div id="userdata-list">
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
      <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem>产业资源下载</BreadcrumbItem>
				</Breadcrumb>

        <Row type="flex" justify="space-between">
          <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
						<Row>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'userdata-list'" v-for="(item,key) in userdata_list" :key="key">
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-title line1'">
									<a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank">{{item.title}}</a>
								</Col>
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-tag'">
									<!--<tag :color="'green'" class="data-cat">{{item.type}}</tag>-->
									<span class="userdata-type pointer" @click="filter_data(item.type_id)">{{item.type}}</span>
									<label v-for="(tag,key1) in item.keywords" :key="key1" class="data-keywords" >
										<span v-if="tag">·&nbsp&nbsp{{tag}}</span>
									</label>
								</Col>
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-info'">
									<Row type="flex" align="middle" >
										<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
											<a v-bind:href="'/user/userzone/'+item.uid" target="_blank" style="color:#999">
												<div class="username change-color line1" :title="item.username">
													<i class="icon icon-user"></i>
													{{item.username}}
												 </div>
											</a>
										</Col> 
										<Col :xs="{'span':3,'offset':1}" :sm="{'span':3,'offset':1}" :lg="{'span':3,'offset':1}">
											 <label>
											 {{item.publish_time}}
											</label>
										</Col> 
										<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
											<label>
												<i class="icon icon-download"></i>
											 	{{item.down}}
											 </label>
										</Col> 
										<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
											<a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank" style="color:#999">
												<label class="change-color">
													<i class="icon icon-message3"></i>
												 	{{item.comment}}</label>
											 </a>
										</Col> 
										<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">								
											<label>
												<Icon type="ios-color-filter-outline" size="18" style="vertical-align: text-bottom"></Icon>&nbsp
												{{item.price}}
											</label>
										</Col> 
										<Col :xs="{'span':3,'offset':8}" :sm="{'span':3,'offset':8}" :lg="{'span':3,'offset':8}">
											<Button type="ghost" class="common-button2" @click="download_report(key)">下载</Button>
										</Col> 
									</Row>	
								</Col>
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
					        <Button class="load-more" @click="get_more"  v-if="more_datas">浏览更多</Button>
					      </center>
					    </Col>
					  </Row>
				  </Col>
          <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
            <Row class="my-data" type="flex" align="middle">
              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                <Button class="common-button3 upload-button" @click="upload">资料上传</Button>
              </Col>
<!--                     		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
                    			<label class="my-data-button pointer" @click="gotopath('/userdata/MyData')">我的资料</label>
                    		</Col> -->
            </Row>
            <UserPannel></UserPannel>
	          <PageRight :page-id="page_id"></PageRight>
	          <div v-if="ad_list[1]" class="ad-zone">
				<a :href="ad_list[1].url" :title="ad_list[1].title" target="_blank">
					<div class="ad2-frame" :title="ad_list[1].title">
						<img :src="ad_list[1].image" class="ad-image-frame" onerror="this.src='/static/noimg.png'">
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
    <AccountPannel ref="AccountPannel"></AccountPannel>
	</div>
</template>

<script>
import PageRight from '../components/MainRight.vue'
import NavHeader from '../components/NavHead.vue'
import FooterArea from '../components/FooterArea.vue'
import FloatSideBar from '../components/FloatSideBar.vue'
import auth from '../common/auth'
import $ from 'jquery'
import UserPannel from './UserPannel'
import AccountPannel from '../components/AccountPanel.vue';
	export default{
		components: {PageRight,NavHeader,FooterArea,FloatSideBar,UserPannel,AccountPannel},
		data(){
			return {
				page_id:7,
				page : 1,
				userdata_list:'',
				ad_list:'',
				loading:false,
				more_datas:true,
				type:''
			}
		},
		mounted(){
            document.title = '菠菜圈| 产业资源';
			this.loading = true;
			var v = this;
			if (v.$route.query.type) {
				this.filter_data(v.$route.query.type)
			}else{
				this.https.get('/front/userdata/render').then((r)=>{
					v.userdata_list = r.data.userDataList;
					v.ad_list = r.data.adList;
					v.loading = false;
				}).catch((e)=>{
					console.log(e);
				});	
			}
		},
		methods:{
			go(path){
				this.$router.push(path);
			},
			filter_data(type){
				this.page = 0
				this.userdata_list = []
				this.type = type
				this.get_more()
			},
			get_more(){
				this.loading = true;
        		var v = this;
		        this.https.get('/front/userdata/get_userdata_list',{
			        	params:{
	                        page : v.page,
	                        type:v.type
	                    }
		            }).then((r)=>{
		                v.loading = false;
		                v.page = v.page + 1;
	                        if (r.data.length>0) {
	                            v.userdata_list = v.userdata_list.concat(r.data);
	                        }else{
	                            v.more_datas = false;
	                            v.$Message.warning('已无更多数据');    
	                        }
		            }).catch((e)=>{   
		                console.log(e)
		        });
			},
			download_report(key){
				if (!this.$store.state.user_info) {
					this.$refs.AccountPannel.show()
					return false
				}
                var v = this;
                var id =  v.userdata_list[key].id;                
                var price = v.userdata_list[key].price;
                var file = v.userdata_list[key].file;
                var uid =  v.userdata_list[key].uid;              
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
            upload(){
            	this.$router.push('/userdata/UserDataUpload');
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
.icon {
  font-size: .3rem;
  font-style: normal;
  vertical-align: middle;
  color: #888;
  &:hover, &:focus {
    color: #28b28a;
  }
}
.load-more {
	margin-bottom: 30px;
}
	.common-button2 {
		font-size: 16px;
		height: 30px;
		width: 100px;
		line-height: 16px;
		border-radius: 3px;
		color: #666;
		text-align: center;
		cursor: pointer;
		border: 1px solid #555;
		&:hover{
			color: #28b28a;
			border-color: #28b28a;
			transition: #28b28a .2s linear,background-color .2s linear,border-color .2s linear;
			transition-property: color, background-color, border-color;
			transition-duration: 0.2s, 0.2s, 0.2s;
			transition-timing-function: linear, linear, linear;
			transition-delay: initial, initial, initial;
		}
	}
	#userdata-list{
		.container{
			width: 1200px;
			margin: 20px auto;
			min-height: 10rem;
			.userdata-list{
				display: block;
				padding: 5px 10px 10px 10px;
				border-bottom: 1px solid #efefef;
				&:hover{
					background-color: #f4f4f4;
				}
				.data-title{
					font-size: 18px;
					font-weight: bold;
					padding-bottom: 10px;
					padding-top: 10px;
					a{
						color: #323232;
						&:hover{
							cursor: pointer;
							color: #27b48a;
						}
					}
				}
				.data-tag{
					padding-top: 10px;
					padding-bottom: 10px;
					font-size: 12px;
					.userdata-type {
						font-size: 12px;
						padding: 5px 5px;
						border-radius: 3px;
						color: #0b74ff;
						background: #d9e9ff;
					}
					.data-keywords {
						font-size: 12px;
						padding-left: 5px;
						padding-right: 5px;
						color: #666;
						&:hover, &:focus {
							color: #28b28a;
							text-decoration: underline;
						}
					}
				}
				.data-info{
					display: block;
					padding-top: 10px;
					padding-bottom: 10px;
					color: #858585;
					.username{
						height: 17px;
					}
					.common-button{
						width: 100%;
					}
				}
			}
		}
		.page-right{
			.my-data{
				font-size:14px; 
				font-weight:bold; 
				.upload-button {
					padding: 10px 15px 10px 15px;
					font-size: 18px;
          color: #333;
          font-weight: bold;
					margin-bottom: 20px;
				}
				.my-data-button{
					cursor: pointer;
					color: #27b48a;
				}
			}
		}
	}
</style>