<template>
	<div id="trend-info">
    <NavHeader></NavHeader>
		<Row type="flex" justify="center">
			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资讯</BreadcrumbItem>
					<BreadcrumbItem>产品动态</BreadcrumbItem>
				</Breadcrumb>

				<Row type="flex" justify="space-between">
					<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
						<Row type="flex" justify="space-between" v-if="top_trend">
							<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
								<div class='trend-date' style="font-weight:bolder;padding-top:10px;color:#fff">
									您的<br>关注
								</div>
							</Col>	
							<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
								<div>
									<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-frame'">
										<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
											<div class="trend-title">
												<a :href="top_trend.product_url" @click="add_view(top_trend.id)" target="_blank">{{top_trend.title}}</a>
											</div>
										</Col>
										<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'trend-type'">
											<span v-for="(type1,key2) in top_trend.type" :key="key2" class="Icon-frame">
												<img src="/static/web.png" v-if="type1==1" class="type-icon">
												<img src="/static/android.png" v-if="type1==2" class="type-icon">
												<img src="/static/ios.png" v-if="type1==4" class="type-icon">
											</span>
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-content'">
											{{top_trend.content}}
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-info'">
											<Col :class-name="'trend-views'" :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
												<i class="icon icon-eye1"></i>
												{{top_trend.f_view}}
											</Col>
											<Col :class-name="'trend-views'" :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
												{{top_trend.created_at}}
											</Col>
											<Col :class-name="'trend-username'" :xs="{'span':10,'offset':7}" :sm="{'span':10,'offset':7}"
													 :lg="{'span':10,'offset':7}">
												<i class="icon icon-user"></i>
												<a @click="go('/user/userzone/'+top_trend.uid)">{{top_trend.username}}</a>
											</Col>
										</Col>
									</Col>
								</div>
							</Col>							
						</Row>
						<Row type="flex" justify="space-between" v-for="(item,key,index) in trendList" :key="key">
							<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
								<div class='trend-date'>
									<div class='trend-date-month'>{{item[0].month}} 月</div>
									<div class='trend-date-day'>{{item[0].day}}</div>
								</div>
							</Col>
							<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
								<div v-for="(item1,key1,index1) in item" :key="key1">
									<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-frame'">
										<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
											<div class="trend-title">
												<a :href="item1.product_url" @click="add_view(item1.id)" target="_blank">{{item1.title}}</a>
											</div>
										</Col>
										<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'trend-type'">
											<span v-for="(type1,key2) in item1.type" :key="key2" class="Icon-frame">
												<img src="/static/web.png" v-if="type1==1" class="type-icon">
												<img src="/static/android.png" v-if="type1==2" class="type-icon">
												<img src="/static/ios.png" v-if="type1==4" class="type-icon">
											</span>
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-content'">
											{{item1.content}}
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-info'">
											<Col :class-name="'trend-views'" :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
												<i class="icon icon-eye1"></i>
												{{item1.view}}
											</Col>
											<Col :class-name="'trend-views'" :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
												{{item1.created_at}}
											</Col>
											<Col :class-name="'trend-username'" :xs="{'span':10,'offset':7}" :sm="{'span':10,'offset':7}"
													 :lg="{'span':10,'offset':7}">
												<i class="icon icon-user"></i>
												<a @click="go('/user/userzone/'+item1.uid)">{{item1.username}}</a>
											</Col>
										</Col>
									</Col>
								</div>
							</Col>
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
								<Button class="load-more" @click="get_more" v-if="more_trend">浏览更多</Button>
							</center>
							</Col>
						</Row>
					</Col>
					<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
						<Row :class-name="'trend-deal'">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<Button :class="'common-button3'" @click="share_trend=true" id="share_new">分享新产品</Button>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<div class="info-pannel">
									<h2 class="title">我们的初衷</h2>
									<p>互联网行业变幻莫测，他的瞬息万变让我们措手不及。再加上产业太过于封闭，导致我们根本无法了解产业动向，或知晓每天产业发生的变化</p>
									<p>无法知己知彼、不知道外面的世界，我们又如何做出正确的应对及决策？</p>
									<p>于是，我们决定召集作为“产业爱好者、产业人士”的你，来干一票大的！</p>
									<p class="intro">
										如果你有一天发现这些有关菠菜业的产品：<br/>
										1、具有产业代表性<br/>
										2、有意思<br/>
										3、够创新<br/>
									</p>
									<p>你都可以通过“<a href="#share_new"><span>分享新产品</span></a>”按钮分享给我们，步骤很简单，但意义却很深远。</p>
								</div>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-collection'">
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
									<h2 class="title">我们已经累计搜集：</h2>
								</Col>
								<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'collection-logo'">
									<center>
										<img src="/static/web_trend.png">
										<b class="count">{{trend_count.web}}</b><span>款</span>
									</center>
								</Col>
								<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'collection-logo'">
									<center>
										<img src="/static/ios_trend.png">
										<b class="count">{{trend_count.ios}}</b><span>款</span>
									</center>
								</Col>
								<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'collection-logo'">
									<center>
										<img src="/static/adriod_trend.png">
										<b class="count">{{trend_count.ard}}</b><span>款</span>
									</center>
								</Col>
							</Col>
						</Row>
					</Col>
				</Row>
			</Col>
		</Row>
		<Modal title="分享新产品" v-model="share_trend" class-name="vertical-center-modal">
			<div class="trend-share">
				<div class="trend-frame">
					<p class="trend-label"><label style="color:red;font-size10px;">*</label>&nbsp产品名称</p>
					<input class='common-input' v-model="trend_title">
				</div>
				<div class="trend-frame">
					<p class="trend-label"><label style="color:red;font-size10px;">*</label>&nbsp产品官网</p>
					<Input v-model="trend_url" class="common-iview-input">
					<Select v-model="http" slot="prepend" style="width: 80px">
						<Option value="http://">http://</Option>
						<Option value="https://">https://</Option>
					</Select>
					</Input>
					<!-- <input class='common-input' v-model="trend_url" placeholder=""> -->
				</div>
				<div class="trend-frame">
					<p class="trend-label"><label style="color:red;font-size10px;">*</label>&nbsp产品终端</p>
					<CheckboxGroup v-model="trend_type" class="common-checkbox">
						<Checkbox label="1">web</Checkbox>
						<Checkbox label="2">android</Checkbox>
						<Checkbox label="4">ios</Checkbox>
					</CheckboxGroup>
				</div>
				<div class="trend-frame">
					<p class="trend-label"><label style="color:red;font-size10px;">*</label>&nbsp一句话描述这个产品</p>
					<textarea v-model="trend_content" class="common-textarea" placeholder="请以精短描述，36字以内"></textarea>
				</div>
			</div>
			<center slot="footer">
				<Button class="common-button submit-share" @click="submit_share" :disabled="sub_lock">提交</Button>
			</center>
	  </Modal>
    <FooterArea></FooterArea>
    <FloatSideBar></FloatSideBar>
	</div>
</template>

<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';

	export default{
		components: {NavHeader,FooterArea,FloatSideBar},
		data(){
			return {
				authorList:[],
				trendList:[],
				page:1,
				loading:true,
				more_trend:true,
				share_trend:false,
				trend_title:'',
				http:'http://',
				trend_url:'',
				trend_type:[],
				trend_content:'',
				sub_lock:false,
				trend_count:'',
				top_trend:''
			}
		},
		mounted(){
			document.title = '菠菜圈| 产品动态'
	    	var v = this
	    	var id = this.$route.query.id?this.$route.query.id:''
	        this.https.get('/front/trend/render',{
	        		params:{
	        			id:id
	        		}
	            }).then((r)=>{
	            	v.authorList = r.data.authorList
	            	v.trendList = r.data.trendList
	            	v.loading = false
	            	v.trend_count = r.data.trend_count
	            	v.top_trend = r.data.top_trend
	            }).catch((e)=>{   
	                console.log(e)
	        });			
		},
		methods:{
            go(path){
                this.$router.push(path)
            },
			submit_share(){
				if (!this.trend_title.trim()) {
					this.$Message.warning('请输入产品名称');
					return false;
				}
				if (!this.trend_url) {
					this.$Message.warning('请输入正确产品地址不得为空')
					return false;
				}
				var url = this.http + this.trend_url
				if (this.trend_type.length == 0) {
					this.$Message.warning('请输入产品类型');
					return false;
				}
				if (!this.trend_content.trim()) {
					this.$Message.warning('请输入产品介绍');
					return false;
				}
				var v = this; 

				this.sub_lock = true;
				this.https.post('/front/trend/add_trend',{
					title : v.trend_title,
					type : v.trend_type,
					url : url,
					content : v.trend_content
				}).then((r)=>{
					v.share_trend = false
					if(r.data.code == 1){

						v.trend_count = r.data.count	

						this.$Message.success(r.data.msg);

/*                    	var key = Object.keys(r.data.trend)[0];

          				if (typeof v.trendList[key] == 'undefined') {

          					var arr = new Array();

          					arr[0] = r.data.trend[key];

          					var merge = {key:arr};

           					v.trendList = Object.assign(merge,v.trendList);

           				}else{

                			v.trendList[key].unshift(r.data.trend[key]);//插入数组头部
           				}*/
            
					}else{
						this.$Message.warning(r.data.msg);
						return false;
					}
					v.sub_lock = false;
				}).catch((e)=>{
					console.log(e);
				});
			},
			add_view(id){
				this.https.get('/front/trend/add_view',{params:{id:id}})
			},
			get_more(){
        		this.loading = true;
        		var v = this;
		        this.https.get('/front/trend/get_trend_list',{
			        	params:{
	                        page : v.page
	                    }
		            }).then((r)=>{
		                v.loading = false;
		                v.page = v.page + 1;
                        if (r.data.length !== 0) {

                        	for(var i in r.data){

                  				if (typeof v.trendList[i] == 'undefined') {

                   					v.trendList[i] = [];
                   				}
                        		v.trendList[i] = v.trendList[i].concat(r.data[i])
                        	}
                        }else{
                            v.more_trend = false;
                            v.$Message.warning('已无更多数据');    
                        }
	                        
		            }).catch((e)=>{   
		                console.log(e)
		        });
			},
		}	
   }
</script>

<style lang='scss' scoped>
	.icon {
		font-size: .3rem;
		font-style: normal;
		vertical-align: middle;
		color: #999;
		cursor: pointer;
		&:hover, &:focus {
			color: #28b28a;
		}
	}
	.icon-user {
		vertical-align: text-bottom;
	}
	a {
		color: #333;
	}
	.load-more {
		margin-bottom: 30px;
	}
	.submit-share {
		font-size:16px; 
	}
	.trend-share {
		.trend-frame {
			.trend-label {
				font-size: 14px;
				padding: 10px 0 10px 0;
			}
			margin-top: 10px;
		}
	}
	#trend-info {
		.container {
			width: 1200px;
			min-height: 10rem;
      margin: 20px auto;
			.page-left {
				.trend-date {
					position: absolute;
					top: 0;
					left: 0;
					width: 46px;
					height: 56px;
					background-color: #28b28a;
					text-align: center;
					padding-top: 5px;
					padding-bottom: 5px;
					/*background-color: #28b28a;*/
					/*width: 70%;*/
					/*text-align: center;*/
					/*padding-top: 5px;*/
					/*padding-bottom: 5px; */
					.trend-date-month {
						font-size: 12px;
						color: #fff;
					}
					.trend-date-day {
						font-size: 18px;
						color: #fff;
					}
				}
				.trend-frame {
					padding: 20px 15px 25px 15px;
					height: 155px;
					border-bottom: 1px dashed #f2f2f2;
					&:hover {
						.Icon-frame {
							display: inline;
						}
						background: #f2f2f2;
					}
					.trend-title {
						width: 100%;
						font-size: 16px;
						font-weight: bold;
						color: #333;
						&:hover {
							color:#28b28a;
						}
						a {
							cursor: pointer;
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
					.trend-type {
						margin-top: 4px;
						.Icon-frame {
							display:none;
							margin-left:6px;
							.type-icon {
								width:18px;
								height:18px;
							}
						}
					}
					.trend-content {
						padding: 15px 0 0 0;
						color: #999;
						font-size: 14px;
						height: 60px;
						overflow: hidden;
						text-overflow: ellipsis;
						-o-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						-webkit-line-clamp: 2;
						display: -webkit-box;
						-webkit-box-orient: vertical;
					}
					.trend-info {
						color: #999;
						font-size: 12px;
						margin-top: 15px;
						text-align: left;
						.trend-views {
							color: #999;
							font-size: 12px;
							cursor: pointer;
							&:hover {
								color:#28b28a;
							}
						}
						.trend-username {
							color: #666;
							font-size: 12px;
							cursor: pointer;
							text-align: right;
							overflow: hidden;
							text-overflow: ellipsis;
							-o-text-overflow:ellipsis;
							-webkit-line-clamp: 1;
							display: -webkit-box;
							-webkit-box-orient: vertical;
							&:hover {
								color:#28b28a;
							}
							a {
								color: #666;
								font-size: 12px;
								&:hover {
									color:#28b28a;
								}
							}
						}
					}
				}
			}
			.page-right {
				.trend-deal {
					text-align: center;
					margin: 0 auto;
					.common-button3 {
						font-size: 18px;
						line-height: 18px;
						font-weight: bold;
						color: #fff;
						width: 350px;
						height: 60px;
						text-align: center;
						padding: 15px 20px;
					}
						.info-pannel {
							margin-top: 25px;
							padding: 30px 18px 24px 18px;
							border: 1px solid #e9e9e9;
							border-radius: 3px;
							.title {
								font-size: 18px;
								color: #333;
								font-weight: bold;
								text-align: left;
							}
							p {
								color: #333;
								font-size: 14px;
								padding-top: 22px;
								/*line-height: 26px;*/
								line-height: 1.5;
								text-align: justify;
							}
							.intro {
								font-size: 14px;
								color: #478dce;
								text-align: left;
								padding-top: 30px;
							}
							span {
								color: #28b28a;
							}
						}
						.trend-collection {
							background-color: #fbfbfb;
							margin-top: 20px;
							padding: 26px 20px 22px 20px;
							h2.title {
								font-size: 18px;
								color: #333;
								font-weight: bold;
								text-align: left;
							}
							.collection-logo {
								padding: 15px 10px 0 10px;
								text-align: center;
								b.count {
									font-size: 30px;
									font-weight: bold;
									color: #333;
									margin-left: 10px;
									cursor: pointer;
								}
								span {
									font-size: 14px;
									color: #333;
									font-weight: normal;
									margin-left: 3px;
								}
							}
						}
				}
			}
		}
	}
</style>