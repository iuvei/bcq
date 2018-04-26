<template>
	<div id="cash">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<Row type="flex" justify="space-between">-->
                    <!--<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">-->
            		    <!--<div class="bread">-->
							<!--<div class="bread-text"><a href="/">首页</a> > <a>资料</a> > 现金网 </div>-->
						<!--</div>-->
                    <!--</Col>-->
                <!--</Row>-->

				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem>现金网</BreadcrumbItem>
				</Breadcrumb>

				<div :class="'cash-option f14'">
					<Row type="flex" align="top" :class-name="'search'">
						<Col :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}" :class-name="'search-title-box'">
						<input type="text" @focus="focusTitle" @blur="blurTitle" class="search-title" placeholder="请输入关键字">
						</Col>
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
						<button @click="setTitle" type="button" class="btn search-title-button"><Icon type="ios-search"></Icon> 搜索</button>
						</Col>
						<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'submit-cash-box'">
						<button type="button" class="btn submit-cash" @click="addCash">提交现金网</button>
						</Col>
					</Row>
					<Row type="flex" :class-name="'option access-box'">
						<span class="option-name">游戏平台 :</span>
						<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
						<ul class="access">
							<li v-if="access == 0" :class="'act'" @click="setAccess(0)">全部</li>
							<li v-else @click="setAccess(0)">全部</li>
							<template  v-for="(item,key) in accessList">
								<li v-if="access & item.val && access != accessTotal" :class="'act'" @click="setAccess(item.val)">{{item.name}}</li>
								<li v-else @click="setAccess(item.val)">{{item.name}}</li>
							</template>
						</ul>
						</Col>
					</Row>
					<Row type="flex" :class-name="'option game-box'">
						<span class="option-name">主营游戏 :</span>
						<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
							<ul class="game">
								<li v-if="game == 0" :class="'act'" @click="setGame(0)">全部</li>
								<li v-else @click="setGame(0)">全部</li>
								<template  v-for="(item,key) in gameList">
									<li v-if="game & item.val && game != gameTotal" :class="'act'" @click="setGame(item.val)">{{item.name}}</li>
									<li v-else @click="setGame(item.val)">{{item.name}}</li>
								</template>
							</ul>
						</Col>
					</Row>
					<Row type="flex" :class-name="'option region-box'">
						<span class="option-name">所属地区 :</span>
						<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
						<ul class="region">
							<li v-if="region == 0" :class="'act'" @click="setRegion(0)">全部</li>
							<li v-else @click="setRegion(0)">全部</li>
							<template  v-for="(item,key) in regionList">
								<li v-if="region == item.val" :class="'act'" @click="setRegion(item.val)">{{item.name}}</li>
								<li v-else @click="setRegion(item.val)">{{item.name}}</li>
							</template>
						</ul>
						</Col>
					</Row>
					<Row type="flex" :class-name="'option sort common-radio'">
						<RadioGroup v-model="sort" @on-change="setSort">
							<Radio v-for="(val,key) in orderBy" :key="key" :label="val.val" >
								<span v-if="sort == val.val" class="c28">{{val.name}}</span>
								<span v-else>{{val.name}}</span>
							</Radio>
						</RadioGroup>
					</Row>
				</div>
				<Row type="flex" :class-name="'cash-list'">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(val,key) in cashList" :key="key" :class-name="'cash-box'">
						<Row type="flex" align="middle">
							<Col span="10" :class-name="'cash-box-l'">
								<div class="cash-box-l-t">
									<a :href="'/userdata/CashDetail/'+val.id" target="_blank"><img class="logo fl" :src="val.logo" :title="val.title" onerror="this.src='/static/noimg.png'" ></a>
									<div class="base fl">
										<div class="f18 title"><a :href="'/userdata/CashDetail/'+val.id" target="_blank"><h2 class="fl w6">{{val.title}} </h2></a><span class="fen fl w6">{{val.mark}}分</span></div>
										<p><span class="c34">平台：</span> {{val.access_name}}</p>
										<p><span class="c34">游戏：</span> {{val.games_name}}</p>
										<p><span class="c34">地区：</span> {{val.region_name}}</p>
									</div>
								</div>
								<div class="cash-box-l-b cl">
									<div class="fl">专业程度 <Progress :percent="val.mark1" :class="'common-progress'"><span class="fen">{{val.mark1}} 分</span></Progress></div>
									<div class="fl">资金实力 <Progress :percent="val.mark2" :class="'common-progress'"><span class="fen">{{val.mark2}} 分</span></Progress></div>
									<div class="fl">用户体验 <Progress :percent="val.mark3" :class="'common-progress'"><span class="fen">{{val.mark3}} 分</span></Progress></div>
									<div class="fl">业界口碑 <Progress :percent="val.mark4" :class="'common-progress'"><span class="fen">{{val.mark4}} 分</span></Progress></div>
								</div>
							</Col>
							<Col span="14" :class-name="'cash-box-r'">
								<h3 class="f16 w6">公司简介</h3>
								<div class="cash-box-r-l f14 wrap fl" v-html="val.content"></div>
								<div class="cash-box-r-r fr">
									<a :href="'/userdata/CashDetail/'+val.id" target="_blank"><button type="button" class="gBtn greenBtn">查看详情</button></a>
									<a :href="'/userdata/CashDetail/'+val.id" target="_blank"><button type="button" class="gBtn boderGreenBtn">客观评价</button></a>
									<p>已有 {{val.cashmark_count}} 人评价</p>
								</div>
							</Col>
						</Row>
					</Col>
					<div class="cash-page">
						<Page :total="cashCount" :page-size="limit" @on-change="setPage" :class-name="'common-page'"></Page>
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
            document.title = '菠菜圈| 现金网';
            var v = this;
            this.https.get('/front/cash/render').then((r)=>{
                v.accessList = r.data.access;
                let atotal = 0;
                $.each(v.accessList, function(key, val) {
                    atotal += val.val;
                });
                v.accessTotal = atotal;

                v.regionList = r.data.region;

                v.gameList = r.data.gameList;
                let gtotal = 0;
                $.each(v.gameList, function(key, val) {
                    gtotal += val.val;
                });
                v.gameTotal = gtotal;

                v.orderBy = r.data.orderBy;
                v.sort = v.orderBy[0].val;

                v.cashList = r.data.cashList;
                v.cashCount = r.data.cashCount;
                v.limit = r.data.limit;

                $(".ivu-page-prev").html('上一页').siblings(".ivu-page-next").html('下一页');

            }).catch((e)=>{
                console.log(e);
            });
        },
		data(){
			return {
			    title: '',
                accessList: '',
                accessTotal: 0,
                access: 0,
                regionList: '',
                region: 0,
                gameList: '',
                gameTotal: 0,
                game: 0,
                orderBy: '',
                sort: '',
                cashList: '',
                cashCount: 0,
                limit: 10,
                page: 1,
			}
		},
        methods: {
            focusTitle(){
				$(".search-title").css("border-color","#28b28a");
			},
            blurTitle(){
				$(".search-title").css("border-color","#dddee1");
			},
            addCash(){
                window.location.href = '/userdata/addCash';
			},
            setAccess(access){
                if (access != this.access)
                this.access = access;
                this.postOpt();
			},
            setTitle(){
                if($(".search-title").val()){
					this.title = $(".search-title").val();
                    this.postOpt();
				}
			},
            setAccess(access){
                if (access != this.access){
                    if (access == 0){
                        this.access = 0;
					}else if(this.access & access && this.access == this.accessTotal){
                        this.access = parseInt(access);
					}else if(this.access & access && this.access != this.accessTotal){
                        this.access -= parseInt(access);
					}else{
                        this.access += parseInt(access);
                        if (this.access == this.accessTotal)
                            this.access = 0;
                    }
                    this.postOpt();
                }
            },
            setGame(game){
                if (game != this.game){
                    if (game == 0){
                        this.game = 0;
					}else if(this.game & game && this.game == this.gameTotal){
                        this.game = parseInt(game);
					}else if(this.game & game && this.game != this.gameTotal){
                        this.game -= parseInt(game);
					}else{
                        this.game += parseInt(game);
                        if (this.game == this.gameTotal)
                            this.game = 0;
                    }
                    this.postOpt();
                }
            },
            setRegion(region){
                if (region != this.region){
                    this.region = region;
                    this.postOpt();
				}
			},
            setSort(sort){
                this.postOpt();
			},
            setPage(page){
                this.page = page;
                this.postOpt();
			},
            postOpt(){
                var v = this;
                this.https.post('/front/cash/filter', {
                    title: this.title,
                    access: this.access,
                    games: this.game,
                    region: this.region,
                    orderBy: this.sort,
                    page: this.page,
                })
				.then(function (response) {
                    v.cashList = response.data.cashList;
                    v.cashCount = response.data.cashCount;
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
	.wrap{word-wrap:break-word;}
	.f14{font-size: 14px;}
	.f16{font-size: 16px;}
	.f18{font-size: 18px;}
	.w6{font-weight: 600;}
	.fl{float: left;}
	.fr{float: right;}
	.cl{clear: both;}
	.c28{color: #28b28a;}
	#cash {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		.container {
			width: 1200px;
			margin: 20px auto;
			min-height: 10rem;
			.cash-option {
                margin: 40px 0;
				.act{
					background-color: #28b28a;
					color: #FFFFFF;
					&:hover{
						 background-color: #149f77 !important;
					}
				}
				.search{
					margin-bottom: 20px;
					.search-title-box{
						text-align: right;
					}
					.search-title{
						display: inline-block;
						width: 512px;
						height: 40px;
						line-height: 40px;
						padding: 4px 7px;
						border: 1px solid #dddee1;
						border-radius: 4px 0 0 4px;
						color: #495060;
						background-color: #FFFFFF;
						background-image: none;
						position: relative;
						cursor: text;
						transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
					}
					.btn{
						display: inline-block;
						margin-bottom: 0;
						font-weight: 400;
						text-align: center;
						vertical-align: middle;
						-ms-touch-action: manipulation;
						touch-action: manipulation;
						cursor: pointer;
						background-image: none;
						border: 1px solid transparent;
						white-space: nowrap;
						height: 40px;
						padding: 6px 15px;
						transition: color .2s linear,background-color .2s linear,border .2s linear;
						border-color: #28b28a;
						&:hover{
							 border-color: #149f77;
							 transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
							 transition-property: color, background-color, border;
							 transition-duration: 0.2s, 0.2s, 0.2s;
							 transition-timing-function: linear, linear, linear;
							 transition-delay: initial, initial, initial;
						 }
					}
					.search-title-button{
						width: 102px;
						border-radius: 0 4px 4px 0;
						color: #FFFFFF;
						background-color: #28b28a;
						&:hover {
							 background-color: #149f77;
						}
					}
					.submit-cash-box{
						margin-left: 18px;
					}
					.submit-cash{
						width: 115px;
						border-radius: 4px;
						color: #28b28a;
						background-color: #FFFFFF;
                        border: 1px solid #28b28a;
						&:hover{
							color: #fff;
                            background: #149f77;
                            border: 1px solid #149f77;
						 }
					}
				}
				.option{
					margin-top: 15px;
					line-height: 40px;
					.option-name{
						letter-spacing: 2px;
						width: 80px;
					}
					ul li{
						float: left;
						cursor: pointer;
						margin: 0 10px;
						border-radius: 4px;
						padding: 0 8px;
						&:hover{
							background-color: #F2F2F2;
						 }
					}
				}
				.region-box{
					padding-bottom: 20px;
					border-bottom: 1px solid #F2F2F2;
				}
				.sort{
					padding-left: 20px;
					*{
						font-size: 14px;
					}
					margin: 8px 0 3px;
					background-color: #F2F2F2;
				}
			}
			.cash-list{
				*{
					color: #787878;
				}
				.cash-box{
					border: 1px solid #F2F2F2;
					height: 220px;
					margin: 5px 0;
					& > div{
						height: 100%;
					  }
					.cash-box-l{
						height: 100%;
						padding: 28px 25px;
						.fen{
							color: #FA0100;
						}
						.cash-box-l-t{
							height: 114px;
							.logo{
								display: inline-block;
								cursor: pointer;
								background: #f2f2f2;
								width: 100px;
								height: 100px;
								vertical-align: baseline;
							}
							.base{
								padding-left: 25px;
								width: 348px;
								*{
									word-wrap:break-word;
									overflow: hidden;
								}
								.title{
									width: 100%;
									height: 25px;
									margin-bottom: 5px;
									h2{
										color: #343434;
										width: 275px;
										height: 100%;
										cursor: pointer;
										overflow: hidden;
									}
								}
								& > p{
									line-height: 25px;
									height: 25px;
									span{
										color: #656565;
									}
								}
							}
						}
						.cash-box-l-b{
							margin-top: 5px;
							height: 50px;
							& > .fl{
								margin: 0 15px 10px 0;
							}
						}
					}
					.cash-box-r{
						border-left: 1px solid #F2F2F2;
						height: 100%;
						padding: 28px 25px;
						h3{
							color: #343434;
							margin-bottom: 12px;
						}
						.cash-box-r-l{
							width: 520px;
							height: 130px;
							line-height: 27px;
							letter-spacing: 1px;
							overflow: hidden;
						}
						.cash-box-r-r{
							width: 110px;
							height: 130px;
							text-align: center;
							.gBtn{
								border: 1px solid transparent;
								font-size: 14px;
								width: 105px;
								height: 40px;
								border-radius: 2px;
								cursor: pointer;
								&:hover{
									 border-color: #149f77;
									 transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
									 transition-property: color, background-color, border;
									 transition-duration: 0.2s, 0.2s, 0.2s;
									 transition-timing-function: linear, linear, linear;
									 transition-delay: initial, initial, initial;
								}
							}
							.greenBtn{
								background-color: #28b28a;
								color: #FFFFFF;
								margin: 5px 0 18px;
								&:hover {
									 background-color: #149f77;
								}
							}
							.boderGreenBtn{
								border-color: #28b28a;
								background-color: #FFFFFF;
								color: #28b28a;
								margin: 0 0 10px;
								&:hover{
									 color: #149f77;
								}
							}
						}
					}
				}
				.cash-page{
					width: 100%;
					text-align: center;
					margin: 50px;
				}
			}
		}
	}
</style>
