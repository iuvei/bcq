<template>
	<div id='platform'>
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<div class="bread">-->
                    <!--<div class="bread-text"><a href="/">首页</a> > <a>交易</a> > 代理招商</div>-->
                <!--</div>-->
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>交易</BreadcrumbItem>
                    <BreadcrumbItem>代理招商</BreadcrumbItem>
                </Breadcrumb>
                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
						<div class="filter">	
							<Row type="flex" align="top">
								<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'filter-title'">
									<span>主营游戏 :</span>
								</Col>
								<Col :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}">
								<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
									<Checkbox v-model="game_checkall" class="common-checkbox check-all" @on-change="check('game',1)"  :class-name="'filter-list check-all'">
							            <span>全选</span>
							        </Checkbox>
							    </Col>
								<CheckboxGroup v-model="game_cat" class="common-checkbox" @on-change="check('game',0)">
									<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" v-for="(game,key) in gameCatList" :key="key"  :class-name="'filter-list'">
								        <Checkbox :label="game.val">
								            <span>{{game.name}}</span>
								        </Checkbox>
									</Col>
								</CheckboxGroup>
								</Col>
							</Row>	
							<Row type="flex" align="top">
								<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'filter-title'">
									<span>结算周期 :</span>
								</Col>
								<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
                                    <Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}"  :class-name="'filter-list'">
                                        <Checkbox  v-model="settlement_checkall" class="common-checkbox check-all" @on-change="check('settlement',1)">
                                            <span>全选</span>
                                        </Checkbox>
                                    </Col>
                                    <CheckboxGroup v-model="settlement" class="common-checkbox"  @on-change="check('settlement',0)">
                                        <Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" v-for="(settlement,key) in settlementList" :key="key" :class-name="'filter-list'">
                                            <Checkbox :label="settlement.val">
                                                <span>{{settlement.name}}</span>
                                            </Checkbox>
                                        </Col>
                                    </CheckboxGroup>
								</Col>
							</Row>
						</div>
						<Row>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<Tabs v-model="tab" @on-click="filter">
									<TabPane label="平台招募" name="proxy">
										<div class="proxy-panel">
											<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(proxy,key) in proxyList" :key="key" :class-name="'list-frame'">
											<div class='list-header'>
												<span class="list-label confirm-logo" v-if="proxy.confirm">官方认证</span>
												<span class="list-label unconfirm-logo" v-else>跳蚤信息</span>
												<a class="title" :href="'/trade/PlatformDetail/'+proxy.id" target="_blank">
                                                    <span>{{proxy.title}}</span>
                                                </a>
											</div>
											<div class='list-body'>
								    			<span class="brief" v-if="proxy.brief">
								    				{{proxy.brief.substring(0,100)}}
								    				<span v-if="proxy.brief.length>100">...</span>
								    				<a :href="'/trade/PlatformDetail/'+proxy.id" target="_blank">[详情]</a>
												</span>
											</div>
											<div class='list-footer'>
												<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
												<span class="game-name" v-for="(game,key) in proxy.games" :key="key">
									    				{{game.name}}
									    			</span>
												</Col>
												<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}"  :class-name="'list-time'">
												{{proxy.time}}
												</Col>
											</div>
											</Col>
										</div>
										<div v-if="!loading">
											<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
											<center>
												<Button class="load-more" @click="get_more"  v-if="more_proxy">浏览更多</Button>
											</center>
											</Col>
										</div>
									</TabPane>
									<TabPane label="代理寻商" name="trade">
                                        <div class="trade-panel">
                                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(trade,key) in tradeList" :key="key" :class-name="'list-frame'">
                                                <div class='list-header'>
                                                    <span class="list-label unconfirm-logo">跳蚤信息</span>
                                                    <a class="title" :href="'/trade/PlatformDetail/'+trade.id" target="_blank">
														<span>{{trade.title}}</span>
													</a>
                                                </div>
                                                <div class='list-body'>
                                                    <span class="brief" v-if="trade.brief">
                                                        {{trade.brief.substring(0,100)}}
                                                        <span v-if="trade.brief.length>100">...</span>
                                                        <a :href="'/trade/PlatformDetail/'+trade.id" target="_blank">[详情]</a>
                                                    </span>
                                                </div>
                                                <div class='list-footer'>
                                                    <Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
                                                        <span class="game-name" v-for="(game,key) in trade.games" :key="key">
                                                            {{game.name}}
                                                        </span>
                                                    </Col>
                                                    <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}"  :class-name="'list-time'">
                                                        {{trade.time}}
                                                    </Col>
                                                </div>
                                            </Col>
                                        </div>
                                        <div v-if="!loading">
                                            <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                                <center>
                                                    <Button class="load-more" @click="get_more"  v-if="more_trade">浏览更多</Button>
                                                </center>
                                            </Col>
                                        </div>
								    </TabPane>
                                    <Checkbox v-model="confirm_only" class="common-checkbox tab-extra" size="small" slot="extra" @on-change="filter">
                                        只看官方认证
                                    </Checkbox>
								</Tabs>
								<div v-if="loading">
						            <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
						                <Spin fix>
						                    <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
						                    <div>Loading</div>
						                </Spin>
						            </Col>
						    	</div>
							</Col>
						</Row>			
					</Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
						<Row type="flex" justify="center">
							<Col :xs="{'span':23}" :sm="{'span':23}" :lg="{'span':23}">
								<div class='common-button publish-button' @click="go('/trade/Publish')">
									免费发布信息
								</div>
								<div class="attention-frame">
									<Row type="flex" justify="space-between">
										<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'attention'">
											注意事项
										</Col>
										<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'reader'">
											请务必仔细阅读
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
											<div class="attention-brief">
												<p>
													信息前自带 “<label style="color:#27b48a">官方认证</label>”图标的信息均为经过本站认证的可信信息，请放心选择。 
												</p>
												<p>
													信息前自带 “<label style="color:#b1b1b1">跳蚤信息</label>”图标的信息均未通过任何认证，请您选择务必谨慎！在“跳蚤信息”区选择合作对象，则意味着您必须自行承担因此造成的任何后果、纠纷及责任。 
												</p>
												<p>
													本站仅做以上声明！
												</p>
											</div>
										</Col>
									</Row>
								</div>
								<a target="_blank" href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&amp;key=XzgwMDE4Njg5NF80NTE0NDNfODAwMTg2ODk0XzJf'">
									<div class='contact-button'>
											信息认证在线咨询
									</div>
								</a>
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
								<div v-if="ad_list[1]" class="ad-zone">
	                            	<a :href="ad_list[1].url" :title="ad_list[1].title" target="_blank">
	                                <div class="ad2-frame" :title="ad_list[1].title">
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
        document.title = '菠菜圈| 代理招商';
        var v = this;
		this.https.get('/front/platform/render').then((r)=>{
			v.ad_list = r.data.adsList;
			v.settlementList = r.data.settlementList;
			v.gameCatList = r.data.gameCatList;
			v.tradeList = r.data.tradeList;
			v.proxyList = r.data.proxyList;
			v.gameList = r.data.gameList;
			v.loading = false;

            let game = parseInt(this.$route.params.game);
            let sett = parseInt(this.$route.params.settlement);
            if (game){this.game_cat.push(game);}
            if (sett){this.settlement.push(sett);}
            v.setCategory();
		}).catch((e)=>{
			console.log(e);
		});
	},
	data(){
		return {
			page_id:'',
			ad_list:'',
			settlementList:'',
			gameCatList:'',
			tradeList:'',
			proxyList:'',
			gameList:'',
			game_cat:[],
			settlement:[],
			game_checkall:false,
			settlement_checkall:false,
			tab:'proxy',
			confirm_only:false,
			trade_page:1,
			proxy_page:1,
			loading:true,
			more_trade:true,
			more_proxy:true
		}
	},
    watch: {
        tab: function () {
            this.setCategory();
        }
    },
	methods:{
        go: function (path) {
            var path = path;
            this.$router.push({path: path});
        },
		check(type,val){
			if (type == 'game') {
				if (val == 1 && this.game_checkall == true) {
					for (var i = 0; i < this.gameCatList.length; i++) {
						this.game_cat.push(this.gameCatList[i].val);
					}
				}else if(val == 1 && this.game_checkall == false){
					this.game_cat = [];
				}else if(val == 0 && this.game_checkall == true){
					this.game_checkall = false;
				}
			}else{
				if (val == 1 && this.settlement_checkall == true) {
					for (var i = 0; i < this.settlementList.length; i++) {
						this.settlement.push(this.settlementList[i].val);
					}
				}else if(val == 1 && this.settlement_checkall == false){
					this.settlement = [];
				}else if(val == 0 && this.settlement_checkall == true){
					this.settlement_checkall = false;
				}
			}
			if (this.tab == 'trade') {
				this.trade_page = 1,
				this.more_trade = true			
			}else{ 
				this.proxy_page = 1,
				this.more_proxy = true
			}
			this.filter();
		},
        setCategory(){
            if (this.game_cat.length){this.check('game',0);}
            if (this.settlement.length){this.check('settlement',0);}
        },
		filter(){
			var v = this;
			this.https.get('/front/platform/filter',{
				params:{
					confirm:v.confirm_only,
					games:v.game_cat,
					settlement:v.settlement,
					type:v.tab
				}
			}).then((r)=>{
				if (v.tab == 'trade') {
					v.tradeList = r.data
					v.more_trade = true
				}else{
					v.proxyList = r.data
					v.more_proxy = true
				}
			}).catch((e)=>{
				console.log(e);
			});			
		},
		get_more(){
			var v = this;
			if (v.tab == 'trade') {
				var page = v.trade_page;
			}else{
				var page = v.proxy_page;
			}
			this.https.get('/front/platform/get_more',{
				params:{
					confirm:v.confirm_only,
					games:v.game_cat,
					settlement:v.settlement,
					type:v.tab,
					page:page
				}
			}).then((r)=>{
				if (v.tab == 'trade') {
				    if (r.data.length>0) {
                        v.tradeList = v.tradeList.concat(r.data);
                    }else{
                        v.more_trade = false;
                        v.$Message.warning('已无更多数据');    
                    }
					v.trade_page = v.trade_page + 1;
				}else{
				    if (r.data.length>0) {
                        v.proxyList = v.proxyList.concat(r.data);
                    }else{
                        v.more_proxy = false;
                        v.$Message.warning('已无更多数据');    
                    }
					v.proxy_page = v.proxy_page + 1;

				}
			}).catch((e)=>{
				console.log(e);
			});		
		}
	}
}
</script>
<style lang='scss' scoped>
	* {
		box-sizing: border-box;
	}
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
#platform {
	height: 100%;
	.container {
		width: 1200px;
		min-height: 80vh;
        margin: 20px auto;
        .page-right {
            margin-top: -0.8rem;
        }
		.page-left {
			.ivu-tabs .ivu-tabs-tabpane {
				overflow: auto !important;
				margin-bottom: 50px !important;
			}
			.tab-extra{
				margin-top: 12px;
			}
			.filter {
                padding: 20px 0;
				.filter-title{
					text-align: center;
					color: #404040;
					font-size:14px; 
					font-weight: bold;
				}
				.filter-list{
					padding-bottom: 20px;
				}
				.check-all{
					margin-top: 3px;
				}
			}	
			.list-frame{
				padding:20px 10px 20px 10px; 
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color:#f2f2f2; 
				}
				.list-header {
					display: flex;
					display: -webkit-flex;
					justify-content: flex-start;
					align-items: center;
					.list-label {
						cursor: pointer;
						display: inline-block;
						width: 10%;
						color: #fff;
						font-size: .25rem;
						text-align: center;
						padding: 8px 8px;
						line-height: .25rem;
						border-radius: 3px;
						-webkit-border-radius: 3px;
						-moz-border-radius: 3px;
						-khtml-border-radius: 3px;

					}
					.confirm-logo {//就是官方认证那个东西
						background-color: #22c596;
					}
					.unconfirm-logo {
						background-color: #999999;
					}
					.title {
						display: inline-block;
						width: 90%;
						text-align: left;
						font-size: .35rem;
						color: #333;
						font-weight: bold;
						padding-left: 10px;
						cursor: pointer;
						&:hover{
							color:#28b28a;
						}
						span {
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
						}
					}
				}
				.list-body{
					margin-top: 20px;
					.brief{
						font-size: 14px;
						color: #888;
			            overflow: hidden;
			            text-overflow: ellipsis;
			            -o-text-overflow:ellipsis;
			            display: -webkit-box;
			            -webkit-line-clamp: 2;
			            -webkit-box-orient: vertical;
					}
				}
				.list-footer{
					margin-top: 20px;				
					.game-name{
						padding:1px 5px 1px 5px;
						color: #596681;
						background-color: #ebf2fb;
						border:1px dashed #9ca7b9;
						margin-right: 10px;
						border-radius: 3px;
					}
					.list-time{
						color: #999;
						text-align: right;
					}
				}
			}
		}
		.page-right{
			.publish-button{
				margin-top: 50px;
				height: 50px;
				line-height: 50px;
				border-radius: 3px;
				text-align: center;
				font-size: 18px;
				padding: 0px;
				cursor: pointer;
			}
			.attention-frame{
				margin-top: 30px;
				.attention{
					font-size: 16px;
					color: #333333;
					font-weight: bold;
				}
				.reader {
					font-size: 12px;
					color: #e4393c;
					text-align: right; 
					padding-top: 5px
				}
				.attention-brief {
					margin-top: 10px;
					padding:10px;
					border:1px dashed #ababab;
					background-color: #fbfbfb;
					border-radius: 3px;
					font-size: 14px;
					p{
						padding-top:5px;
						padding-bottom:5px;
						line-height: 30px;
						letter-spacing: 1px; 
					}
				}
			}
			.contact-button{
				margin-top: 20px;
				color:#ff7b34;
				border:1px solid #ff7b34;
				border-radius: 3px;
				font-size: 16px;	
				text-align: center;
				cursor: pointer;
				padding-top: 10px;
				padding-bottom: 10px;	
				font-weight:bolder;		
				a{
					color:#ff7b34;
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
					&:hover{
						color: #27b48a;
					}
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
}
</style>