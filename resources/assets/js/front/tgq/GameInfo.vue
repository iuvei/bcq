<template>
	<div id="gameinfo">
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
            	<Row type="flex" justify="space-between">
            		<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-left'">
            			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
							<BreadcrumbItem to="/">首页</BreadcrumbItem>
							<BreadcrumbItem>游戏公司消息公告</BreadcrumbItem>
						</Breadcrumb>
						<div class='game-store'>
							<div class="store-title">游戏平台</div>
							<ul class="store-list">
								<li @click="store=0;get_more(0,store,1)" v-bind:class="{'store-active':store==0}">全部</li>
								<li v-for="(item,index,key) in gameStore" :key="key" @click="store=index;get_more(0,store,1)" v-bind:class="{'store-active':store==index}">{{item}}</li>
							</ul>
						</div>
						<div class='game-service'>
							<Row>
								<Col class="service-title" :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
									官方游戏接口服务
								</Col>
								<Col class="service-inter" :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
									<a @click="go('/gamepage')">进入频道>></a>
								</Col>
								<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
									<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" v-for="(game,key) in gameList" :key="key" :class-name="'game-detail'">
										<Row type="flex" justify="center">
											<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
												<div class="game-image-frame">
													<img v-bind:src="game.image+'-01.png'">
												</div>
											</Col>
											<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'game-name'">
												{{game.gname}}
											</Col>
										</Row>
									</Col>	
								</Col>								
							</Row>
						</div>
					</Col>
					<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-right'">
						<div class="content-zone" v-for="(item,key) in gameInfo" :key="key">
							<div class="content-fame">
								<div class="avatar">
									<div class="avatar-frame-new">
										<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
											<img v-bind:src="item.user.image">
										</a>
									</div>
								</div>
								<div class="username">&nbsp&nbsp<span class="username-author">{{item.user.username}}</span><br>&nbsp&nbsp<span class="userdesc">{{item.user.desc}}</span></div>
								<div class="line1 pointer micro-content"><a class="title" v-bind:href="'/news/micro?id='+item.id" target="blank"><div v-html="item.content"></div></a></div>
								<div class="content-info">
									<div class="tags">微动态</div>&nbsp&nbsp⋅
									<div class="time">{{item.time}}</div>
									<div style="width:500px;display:inline-block"></div>
									<div class="view"><i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}&nbsp&nbsp⋅</div>
									<div class="comment"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment_count}}&nbsp&nbsp</div>
								</div>
							</div>
						</div>
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
					          <Button class="load-more" @click="get_more(page,store)" v-if="more_info">浏览更多</Button>
					        </center>
					      </Col>
					    </Row>												
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
export default{
	components: {NavHeader,FooterArea,FloatSideBar},
	mounted(){
		var v = this
		v.https.get('/front/gameinfo/render').then((r)=>{
			v.gameList = r.data.gameList
			v.gameStore = r.data.gameStore
			v.gameInfo = r.data.gameInfo
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			gameList:'',
			gameStore:'',
			gameInfo:'',
			store:0,
			loading:false,
			more_info:true,
			page:1
		}
	},
	methods:{
		go: function (path) {
            var path = path;
            this.$router.push({path: path});
        },
        get_more(page,store,choice=0){
        	var v = this
        	v.loading = true
        	v.https.get('/front/gameinfo/get_more',{params:{
        		page:page,
        		store:store
        	}}).then((r)=>{
        		v.loading = false
        		if (choice) {
        			v.page = 1
        			v.gameInfo = r.data
	        		if (!r.data.length) {
	        			v.more_info = false
	        		}else{
	        			v.more_info = true
	        		}
        		}else{
	        		if (!r.data.length) {
	        			v.more_info = false
	        		}else{
	        			v.gameInfo = v.gameInfo.concat(r.data)
	        			v.page = v.page + 1
	        			v.more_info = true
	        		}        			
        		}
        	}).catch((e)=>{
        		console.log(e)
        	})
        }
	}
}
</script>
<style lang="scss" scoped>
#gameinfo{
	.container {
		width: 1200px;
		min-height: 80vh;
  		margin: 20px auto;
  		.page-left{
  			.game-store{
  				.store-title{
  					color: #5c5c5c;
					font-size: 16px;
					font-weight:bold; 
  				}
  				.store-list{
  					display: flex;
  					flex-direction:row;
  					flex-wrap:wrap;
  					li{
  						width: 20%;
  						text-align: center;
  						font-size: 16px;
  						line-height: 30px;
  						margin-top: 10px;
  						cursor: pointer;
  						&:hover{
  							background-color: #28b28a;
  							color: #fff;
  							border-radius: 3px;
  						}
  					}
  					.store-active{
  						background-color: #28b28a;
						color: #fff;
						border-radius: 3px;
  					}
  				}
  			}
			.game-service{
				margin-top: 30px;
				.service-title{
					color: #5c5c5c;
					font-size: 16px;
					font-weight:bold; 
				}
				.service-inter{
					text-align: right;
					color: #7a7a7a;
					cursor: pointer;
					padding-top: 5px;
					a{
						color: #333;
						font-weight: bold;
					}
					&:hover{
						color: #28b28a;
					}
				}
				.game-detail{
					margin-top: 10px;
					padding: 5px 0px 5px 0px;
					&:hover{
						background-color: #f2f2f2;
					}
					.game-image-frame{
						position: relative;
						width: 100%;
						height: 0px;
						padding-top: 100%;
						cursor: pointer;
						img{
							position: absolute;
							top: 0px;
							left: 0px;
							width: 100%;
							height: 100%;
						}
					}
					.game-name{
						padding-top: 10px;
						text-align: center;
						font-size:14px;
						color: #333333;
						font-weight: bold; 
					}
				}
			}  			
  		}
		.page-right{
		 	.content-zone{
		 		padding: 10px 0 10px 0;
				display: block;
				vertical-align: middle;
				padding-left: 15px;
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}
				.title{
					font-size: 20px;
					line-height: 25px;
					height: 25px;
					overflow: hidden;
					font-weight: bolder;
					color: #333333;
					&:hover{
						color: #28b28a;
					}
				}
				.avatar{
					display: inline-block;
					width: 40px;
				}
				.username{
					font-size: 14px;
					.userdesc{
						font-size: 12px;
						color: #999999;
					}
				}
				.tags,.avatar,.username,.comment,.time,.view,.collection{
					display: inline-block;
					vertical-align: middle;
				}
				.micro-content{
					line-height: 30px;
					height: 30px;
					a{
						font-size: 14px;	
						font-weight: normal;			
					}
				}
				.content-info{
					font-size: 14px;
					padding-top: 5px;
					.tags{
						border:1px solid #f22284;
						color: #f22284;
						padding-left:5px;
						padding-right: 5px; 
					}
				}
			} 					
		}  		
	}
}
</style>