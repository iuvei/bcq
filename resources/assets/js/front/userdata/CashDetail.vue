<template>
    <div id="cash-detail">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<Row type="flex" justify="space-between">-->
                    <!--<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">-->
                        <!--<div class="bread">-->
                            <!--<div class="bread-text"><a href="/">首页</a> > <a>资料</a>  > <router-link :to="{path: '/userdata/Cash'}" >现金网</router-link> > 现金网详情页 </div>-->
                        <!--</div>-->
                    <!--</Col>-->
                <!--</Row>-->

                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资料</BreadcrumbItem>
                    <BreadcrumbItem to="/userdata/Cash">现金网</BreadcrumbItem>
                    <BreadcrumbItem>现金网详情</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" :class-name="'cash-detail'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'cash-box'">
                        <Row type="flex" align="middle">
                            <Col span="10" :class-name="'cash-box-l'">
                            <div class="cash-box-l-t">
                                <img class="logo fl" :src="cash.logo" :title="cash.title" onerror="this.src='/static/noimg.png'" >
                                <div class="base fl">
                                    <div class="f18 title"><h2 class="fl w6">{{cash.title}} </h2><span class="fen fl w6">{{cash.mark}}分</span></div>
                                    <p><span class="c34">平台：</span> {{cash.access_name}}</p>
                                    <p><span class="c34">游戏：</span> {{cash.games_name}}</p>
                                    <p><span class="c34">地区：</span> {{cash.region_name}}</p>
                                </div>
                            </div>
                            <div class="cash-box-l-b cl">
                                <div class="fl">专业程度 <Progress :percent="cash.mark1" :class="'common-progress'"><span class="fen">{{cash.mark1}} 分</span></Progress></div>
                                <div class="fl">资金实力 <Progress :percent="cash.mark2" :class="'common-progress'"><span class="fen">{{cash.mark2}} 分</span></Progress></div>
                                <div class="fl">用户体验 <Progress :percent="cash.mark3" :class="'common-progress'"><span class="fen">{{cash.mark3}} 分</span></Progress></div>
                                <div class="fl">业界口碑 <Progress :percent="cash.mark4" :class="'common-progress'"><span class="fen">{{cash.mark4}} 分</span></Progress></div>
                            </div>
                            </Col>
                            <Col span="14" :class-name="'cash-box-r'">
                                <h3 class="f16 w6">公司简介</h3>
                                <div class="cash-content f14 wrap fl"  v-html="cash.content"></div>
                            </Col>
                        </Row>
                    </Col>
                </Row>
                <Row type="flex" :class-name="'cash-mark'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'mark-box'">
                        <h3 class="f16 w6">客观评论</h3><span>已有 {{cash.cashmark_count}} 人评价</span>
                        <div class="mark cl">
                            <div class="fl f14">专业程度 <Rate allow-half v-model="mark1" :class="'common-rate'"></Rate></div>
                            <div class="fl f14">资金实力 <Rate allow-half v-model="mark2" :class="'common-rate'"></Rate></div>
                            <div class="fl f14">用户体验 <Rate allow-half v-model="mark3" :class="'common-rate'"></Rate></div>
                            <div class="fl f14">业界口碑 <Rate allow-half v-model="mark4" :class="'common-rate'"></Rate></div>
                        </div>
                        <div class="markBtnBox">
                            <button @click="postOpt" type="button" class="markBtn">提 交</button>
                        </div>
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
    import Enterprise from './Enterprise.vue'
    import $ from 'jquery';

    export default{
        components: {NavHeader,FooterArea,FloatSideBar,Enterprise},
        mounted(){
            document.title = '菠菜圈| 现金网详情页';
            var v = this;
            this.cash_id = this.$route.params.cash_id;
            this.https.get('/front/cash_details/render', {
                params: {
                    cid: v.cash_id
                }
            })
            .then((r)=>{
                if (r.data.cashDetails instanceof Array && r.data.cashDetails.length == 0){
                    v.$Message.warning('该信息不存在或已删除!');
                    setTimeout(function () {
                        v.$router.push('/userdata/Cash');
                    },2000)
                }
                v.cash = r.data.cashDetails;
                v.mark1 = v.cash.mark1/20;
                v.mark2 = v.cash.mark2/20;
                v.mark3 = v.cash.mark3/20;
                v.mark4 = v.cash.mark4/20;
            })
            .catch((e)=>{
                console.log(e);
            });
        },
        data(){
            return {
                cash: '',
                mark: 0,
                mark1: 0,
                mark2: 0,
                mark3: 0,
                mark4: 0,
            }
        },
        methods: {
            postOpt(){
                var v = this;
                this.https.post('/front/cash_details/add_mark', {
                    cid: this.cash.id,
                    mark1: this.mark1,
                    mark2: this.mark2,
                    mark3: this.mark3,
                    mark4: this.mark4,
                })
                .then(function (response) {
                    if (response.data.code){
                        v.$Message.success(response.data.msg);
                        v.cash = response.data.cashDetails;
                    }else{
                        v.$Message.warning(response.data.msg);
                    }
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
    #cash-detail{
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
        .container {
            width: 1200px;
            margin: 20px auto;
            min-height: 10rem;
			.cash-detail{
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
						.cash-content{
							width: 100%;
							height: 130px;
							line-height: 27px;
							letter-spacing: 1px;
							overflow: hidden;
						}
					}
				}
				.cash-page{
					width: 100%;
					text-align: center;
					margin: 50px;
				}
			}
			.cash-mark{
				*{
					color: #787878;
				}
				.mark-box{
					border: 1px solid #F2F2F2;
					height: 235px;
					margin: 5px 0;
                    padding: 28px 25px;
                    h3{
                        width: 70px;
                        display: inline-block;
                    }
                    .mark{
                        height: 40px;
                        line-height: 40px;
                        .f14{
                            margin: 20px 48px 0 0;
                        }
                        .f14:last-child{
                            margin-right: 0;
                        }
                    }
                    .markBtnBox{
                        width: 100%;
                        text-align: center;
                        margin-top: 60px;
	                    .markBtn{
	                        font-size: 16px;
	                        width: 190px;
	                        height: 45px;
	                        border-radius: 4px;
	                        cursor: pointer;
                            color: #fff;
	                        background-color: #28b28a;
                            border: 1px solid #28b28a;
	                        &:hover {
	                             background-color: #149f77;
	                             border-color: #149f77;
	                             transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
	                             transition-property: color, background-color, border;
	                             transition-duration: 0.2s, 0.2s, 0.2s;
	                             transition-timing-function: linear, linear, linear;
	                             transition-delay: initial, initial, initial;
	                        }
	                    }
                    }
			  	}
		  	}
        }
    }
</style>