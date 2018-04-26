<template>
	<div id='BusinessDetail'>
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>交易</BreadcrumbItem>
                    <BreadcrumbItem to="/trade/business">供求商讯</BreadcrumbItem>
                    <BreadcrumbItem>供求商讯详情</BreadcrumbItem>
                </Breadcrumb>
                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
						<Row :class-name="'bns-detail'">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<h2 class="bns-title">{{business_info.title}}</h2>
								<p class="bns-author">
                                    <span class="bns-name title-hidden" @click="go('/user/userzone/'+business_info.user.id)">{{business_info.user.username}}</span>
                                    <span class="bns-pubdate">{{business_info.updated_at}}</span>
                                </p>
                                <div class="bns-type">
                                    <ul class="marks">
                                        <li><a>业务类型</a></li>
                                        <li><a :href="'/trade/business/'+business_info.category.fid+'/'+business_info.category.id" target="_blank">{{business_info.category.cname}}</a></li>
                                    </ul>
                                    <ul class="links">
                                        <li>平台名称：<a :href="business_info.url" target="_blank">{{business_info.enterprise}}</a></li>
                                    </ul>
                                </div>
                                <div class="bns-content">
                                    <ul v-viewer>
                                        <li v-for="(img,index) in imgList"><img :src="img" @error="remove(index)"></li>
                                    </ul>
                                    <div class="bns-article" v-html="business_info.content">
                                    </div>
                                </div>
                                <p class="bns-notice">
                                    <b>免责声明：</b>此信息由会员发布，请自行核实内容真实性，如产生任何纠纷本站对此不承担责任，官方认证信息除外。
                                </p>
								<Tabs v-model="tab">
								    <TabPane label="供应信息" name="supply">
                                        <div class="trade-panel">
                                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(supply,key) in supplyList" :key="key" :class-name="'list-frame'">
                                                <div class='list-header'>
                                                    <span class="list-label confirm-logo" v-if="supply.confirm">官方认证</span>
                                                    <span class="list-label unconfirm-logo" v-else>跳蚤信息</span>
                                                    <a class="title" :href="'/trade/BusinessDetail/'+supply.id" target="_blank">
                                                        <span>{{supply.title}}</span>
                                                    </a>
                                                </div>
                                                <div class='list-body'>
                                                    <span class="brief">{{supply.brief?supply.brief.substring(0,100):''}}
                                                        <span v-if="supply.brief&&supply.brief.length>100">...</span>
                                                        <a :href="'/trade/BusinessDetail/'+supply.id" target="_blank">[详情]</a>
                                                    </span>
                                                </div>
                                                <div class='list-footer'>
                                                    <Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
                                                        <span class="game-name">
                                                            {{supply.category.cname}}
                                                        </span>
                                                    </Col>
                                                    <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}"  :class-name="'list-time'">
                                                        {{supply.time}}
                                                    </Col>
                                                </div>
                                            </Col>
                                        </div>
                                        <div v-if="!loading">
                                            <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                                <center>
                                                    <Button class="load-more" @click="get_more"  v-if="more_supply">浏览更多</Button>
                                                </center>
                                            </Col>
                                        </div>
								    </TabPane>
								    <TabPane label="求购信息" name="buy">
                                        <div class="proxy-panel">
                                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(buy,key) in buyList" :key="key" :class-name="'list-frame'">
                                                <div class='list-header'>
                                                    <span class="list-label unconfirm-logo">跳蚤信息</span>
                                                    <a class="title" :href="'/trade/BusinessDetail/'+buy.id" target="_blank">
                                                        <span>{{buy.title}}</span>
                                                    </a>
                                                </div>
                                                <div class='list-body'>
                                                    <span class="brief">{{buy.brief?buy.brief.substring(0,100):''}}
                                                        <span v-if="buy.brief&&buy.brief.length>100">...</span>
                                                        <a :href="'/trade/BusinessDetail/'+buy.id" target="_blank">[详情]</a>
                                                    </span>
                                                </div>
                                                <div class='list-footer'>
                                                    <Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
                                                        <span class="game-name">
                                                            {{buy.category.cname}}
                                                        </span>
                                                    </Col>
                                                    <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}"  :class-name="'list-time'">
                                                        {{buy.time}}
                                                    </Col>
                                                </div>
                                            </Col>
                                        </div>
                                        <div v-if="!loading">
                                            <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                                <center>
                                                    <Button class="load-more" @click="get_more"  v-if="more_buy">浏览更多</Button>
                                                </center>
                                            </Col>
                                        </div>
								    </TabPane>
								</Tabs>
							</Col>
						</Row>			
					</Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'" v-if="init">
						<Row type="flex" justify="center">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<div class="attention-frame" v-if="business_info.confirm && business_info.type == 1">
									<Row type="flex" justify="space-between">
										<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'attention'">
											认证项目公示
										</Col>
										<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'reader'">
                                        <a class="kf" href="javascript:;" onclick="window.open('http://wpa.b.qq.com/cgi/wpa.php?ln=1&amp;key=XzgwMDE4Njg5NF80NTE0NDNfODAwMTg2ODk0XzJf');">信息认证在线咨询入口></a>
										</Col>
										<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
											<ul class="bns-certification">
												<li v-for="(plate,key) in plateList" v-if="business_info.plate & key">
                                                    <i class="ctfimg" :class="plate.class" :alt="plate.title"></i>
                                                    <div class="ctfintro">
                                                        <h2 :style="'color: '+plate.color+';'">{{plate.title}}认证 <a :href="'/front/business_details/confirm/'+business_info.id+'/'+key" target="_blank">查看认证证书</a></h2>
                                                        <p>
                                                            该企业已经过{{plate.title}}认证，并成功获得认证标识。
                                                        </p>
                                                    </div>
                                                </li>

											</ul>
										</Col>
									</Row>
								</div>
                                <div class="attention-frame-public" v-else>
                                    该信息为跳蚤信息，交易请注意进行自我判别
                                </div>
								<div class='bns-contact' v-if="business_info.qq || business_info.skype || business_info.phone || business_info.wechat || business_info.email">
									<h2 class="cntTitle">联系方式</h2>
                                    <ul>
                                        <li v-if="business_info.qq">
                                            <template v-if="isLogin">
                                                <i class="sns-img qq1"></i>
                                                <h2>{{business_info.qq}}</h2>
                                                <p>
                                                    <a class="text-copy" :data-clipboard-text="business_info.qq">快速复制</a>
                                                    <!-- <a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&key=XzgwMDE4Njg5NF80NTE0NDNfODAwMTg2ODk0XzJf" target="_blank">在线联系</a> -->
                                                </p>
                                            </template>
                                            <template v-else>
                                                <i class="sns-img qq1"></i>
                                                <h2 class="loginMsg">请先<a @click="go('/account')" href="javascript:;" class="login-info">登录</a>方可查看</h2>
                                            </template>
                                        </li>
                                        <li v-if="business_info.skype">
                                            <template v-if="isLogin">
                                                <i class="sns-img skype2"></i>
                                                <h2>{{business_info.skype}}</h2>
                                                <p>
                                                    <a class="text-copy" :data-clipboard-text="business_info.skype">快速复制</a>
                                                    <!-- <a href="http://wpa.b.qq.com/cgi/wpa.php?ln=1&key=XzgwMDE4Njg5NF80NTE0NDNfODAwMTg2ODk0XzJf" target="_blank">在线联系</a> -->
                                                </p>
                                            </template>
                                            <template v-else>
                                                <i class="sns-img skype2"></i>
                                                <h2 class="loginMsg">请先<a @click="go('/account')" href="javascript:;" class="login-info">登录</a>方可查看</h2>
                                            </template>
                                        </li>
                                        <li v-if="business_info.phone">
                                            <template v-if="isLogin">
                                                <i class="sns-img phone3"></i>
                                                <h2>{{business_info.phone}}</h2>
                                                <p>
                                                    <a class="text-copy" :data-clipboard-text="business_info.phone">快速复制</a>
                                                </p>
                                            </template>
                                            <template v-else>
                                                <i class="sns-img phone3"></i>
                                                <h2 class="loginMsg">请先<a @click="go('/account')" href="javascript:;" class="login-info">登录</a>方可查看</h2>
                                            </template>
                                        </li>
                                        <li v-if="business_info.wechat">
                                            <template v-if="isLogin">
                                                <i class="sns-img weixin4"></i>
                                                <h2>{{business_info.wechat}}</h2>
                                                <p>
                                                    <a class="text-copy" :data-clipboard-text="business_info.wechat">快速复制</a>
                                                </p>
                                            </template>
                                            <template v-else>
                                                <i class="sns-img weixin4"></i>
                                                <h2 class="loginMsg">请先<a @click="go('/account')" href="javascript:;" class="login-info">登录</a>方可查看</h2>
                                            </template>
                                        </li>
                                        <li v-if="business_info.email">
                                            <template v-if="isLogin">
                                                <i class="sns-img email5"></i>
                                                <h2>{{business_info.email}}</h2>
                                                <p>
                                                    <a class="text-copy" :data-clipboard-text="business_info.email">快速复制</a>
                                                </p>
                                            </template>
                                            <template v-else>
                                                <i class="sns-img email5"></i>
                                                <h2 class="loginMsg">请先<a @click="go('/account')" href="javascript:;" class="login-info">登录</a>方可查看</h2>
                                            </template>
                                        </li>
                                    </ul>
								</div>
								<div v-if="ad_list[1]" class="ad-zone">
	                            	<a :href="ad_list[1].url" :title="ad_list[1].title" target="_blank">
	                                <div class="ad-frame" :title="ad_list[1].title">
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
import Clipboard from 'clipboard';
import Viewer from 'v-viewer'
import $ from 'jquery';
export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar},
	mounted(){
		document.title = '菠菜圈| 供求商讯详情';
		var v = this;
        this.business_id = this.$route.params.business_id;
		this.https.get('/front/business_details/render', {
            params: {
                bid: v.business_id
            }
        }).then((r)=>{
            if (r.data.business_info instanceof Array && r.data.business_info.length == 0){
                v.$Message.warning('该信息不存在或已删除!');
                setTimeout(function () {
                    v.$router.push('/trade/business');
                },2000)
            }else{
                v.business_info = r.data.business_info;
                try {
                    v.imgList = $.parseJSON(v.business_info.pic);
                } catch(err) {
                    v.imgList = [];
                }
                v.supplyList = r.data.supplyList;
                v.buyList = r.data.buyList;
                v.catList = r.data.catList;
                v.gameList = r.data.gameList;
                v.plateList = r.data.plateList;
                v.loading = false;
                v.init = true
                v.isLogin = r.data.isLogin;
            }
		}).catch((e)=>{
			console.log(e);
		});
        const clipboard = new Clipboard('.text-copy');
        clipboard.on('success', e => {
          v.$Message.success(e.text + ' 已复制到剪贴板！');
        });         
	},
	data(){
		return {
			page_id:'',
			ad_list:'',
            business_info:{
			    user:{},
                category:{},
            },
			settlementList:'',
			gameCatList:'',
			supplyList:'',
			buyList:'',
			gameList:'',
            imgList:[],
			catList:'',
            plateList:'',
			cat1_id:'',
			cat2_id:[],
			cat2_list:[],
			cat1_checkall:0,
			cat2_checkall:false,
            tab:'supply',
            confirm_only:false,
            supply_page:1,
            buy_page:1,
            loading:true,
            more_supply:true,
            more_buy:true,
            isLogin:'',
            init:false
        }
	},
	methods:{
		get_more(){
			var v = this;
			if (v.tab == 'supply') {
				var page = v.supply_page;
			}else{
				var page = v.buy_page;
			}
			this.https.get('/front/business/get_more',{
				params:{
					confirm:v.confirm_only,
					bid:v.cat2_id,
					type:v.tab,
					page:page
				}
			}).then((r)=>{
				if (v.tab == 'supply') {
				    if (r.data.length>0) {
                        v.supplyList = v.supplyList.concat(r.data);
                    }else{
                        v.more_supply = false;
                        v.$Message.warning('已无更多数据');    
                    }
					v.supply_page = v.supply_page + 1;
				}else{
				    if (r.data.length>0) {
                        v.buyList = v.buyList.concat(r.data);
                    }else{
                        v.more_buy = false;
                        v.$Message.warning('已无更多数据');    
                    }
					v.buy_page = v.buy_page + 1;

				}
			}).catch((e)=>{
				console.log(e);
			});		
		},
        remove(index){
            var v = this;
            v.imgList = $.grep(v.imgList,function(n,i){
                return i != index;
            });
        },
        go(path) {
            var path = path;
            this.$router.push({path: path});
        }
	}
}
</script>

<style lang='scss' scoped>
    ul, li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
	.container{
		width: 1200px;
		min-height: 80vh;
        margin: 20px auto;
		.page-left {
            .bns-detail {
                .bns-title {
                    font-size: .6rem;
                    color: #333;
                    font-weight: bold;
                }
                .bns-author {
                    display: flex;
                    justify-content: flex-start;
                    align-items: center;
                    padding: 10px 0;
                    margin-bottom: 20px;
                    >span {
                        display: inline-block;
                        font-size: .28rem;
                        color: #888;
                        margin-right: 15px;
                    }
                    .bns-name {
                        cursor: pointer;
                        max-width: 220px;
                    }
                }
                .bns-type {
                    border: 1px solid #f2f2f2;
                    background: #fbfbfb;
                    padding: 15px 20px;
                    margin-bottom: 20px;
                    ul:after {
                        content: '';
                        display: block;
                        clear: both;
                    }
                    .marks {
                        display: block;
                        li {
                            float: left;
                            a {
                                color: #666;
                                font-size: .26rem;
                                display: block;
                                background: #ebf2fb;
                                text-decoration: none;
                                position: relative;
                                height: 26px;
                                line-height: 26px;
                                padding: 0 10px 0 10px;
                                text-align: center;
                                margin-right: 15px;
                                border: 1px dashed #a4c2ec;
                                border-radius: 3px;
                                /*z-index: 2;*/
                            }
                        }
                        li:nth-child(1) a {
                            padding-left: 15px;
                            -webkit-border-radius: 3px 0 0 3px;
                            -moz-border-radius: 3px 0 0 3px;
                            -ms-border-radius: 3px 0 0 3px;
                            -o-border-radius: 3px 0 0 3px;
                            border-radius: 3px 0 0 3px;
                            background: #dae5f4;
                            color: #555;
                            font-weight: bold;
                            border: 1px solid #dae5f4;
                        }
                        li:nth-child(1) a:before {
                            content: "";
                            position: absolute;
                            right: -11px;
                            top: -1px;
                            width: 0;
                            height: 0;
                            border-top: 13px solid transparent;
                            border-left: 10px solid #dae5f4;
                            border-bottom: 13px solid transparent;
                        }
                        li:nth-child(2) a {
                            padding-left: 15px;
                            -webkit-border-radius: 0 3px 3px 0;
                            -moz-border-radius: 0 3px 3px 0;
                            -ms-border-radius: 0 3px 3px 0;
                            -o-border-radius: 0 3px 3px 0;
                            border-radius: 0 3px 3px 0;
                            border-color: #a4c2ec;
                            border-left-color: transparent;
                        }
                        li:nth-child(2) a:before {
                            content: "";
                            position: absolute;
                            left: -1px;
                            top: -1px;
                            width: 0;
                            height: 0;
                            border-top: 14px solid transparent;
                            border-left: 10px solid #fbfbfb;
                            border-bottom: 14px solid transparent;
                        }
                    }
                    .links {
                        display: block;
                        padding-top: 10px;
                        >li {
                            float: left;
                            padding: 8px 10px 0 0;
                            text-align: left;
                            font-size: .28rem;
                            margin-right: 15px;
                            a {
                                display: inline-block;
                                font-size: .28rem;
                                color: #478dce;
                            }
                        }
                    }
                }
                .bns-content {
                    ul {
                        display: flex;
                        flex-wrap: wrap;
                        justify-content: flex-start;
                        align-items: center;
                        padding: 10px 0;
                        li{
                            margin-right: 10px;
                            img{
                                width: 150px;
                                height: 105px;
                                cursor: pointer;
                            }
                        }
                        li:last-child {
                            margin-right: 0;
                        }
                    }
                    .bns-article {
                        font-size: .28rem;
                        color: #444;
                        text-indent: .28rem;
                        white-space: pre-wrap;
                        text-align: justify;
                        padding: 10px;
                        overflow: hidden;
                        overflow-wrap: break-word;
                    }
                }
                .bns-notice {
                    margin: 30px 0 40px 0;
                    width: 100%;
                    line-height: 36px;
                    border: 1px solid #c59f5e;
                    background: #fcf8e3;
                    text-align: left;
                    padding: 5px 10px;
                    border-radius: 5px;
                    font-size: .26rem;
                    color: #c59f5e;
                    b {
                        color: #555;
                        font-weight: bold;
                        margin-right: 3px;
                    }
                }
            }
            /*底部tab*/
            .tab-extra{
                margin-top: 12px;
            }
            .list-frame {
                padding: 20px 10px 20px 10px;
                border-bottom: 1px solid #f2f2f2;
                &:hover {
                    background-color: #f2f2f2;
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
                        &:hover {
                            color: #28b28a;
                        }
                        span {
                            display: block;
                            overflow: hidden;
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
                .list-body {
                    margin-top: 20px;
                    .brief {
                        font-size: 14px;
                        color: #b1b1b1;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow: ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                    }
                }
                .list-footer {
                    margin-top: 20px;
                    .game-name {
                        padding: 1px 5px 1px 5px;
                        color: #596681;
                        background-color: #ebf2fb;
                        border: 1px dashed #9ca7b9;
                        margin-right: 10px;
                        border-radius: 3px;
                    }
                    .list-time {
                        color: #b1b1b1;
                        text-align: right;
                    }
                }
            }
		}
		.page-right {
            margin-top: -0.3rem;
            .bns-certification {
                li {
                    padding: 10px 5px 10px 10px;
                    background: #fdfdfd;
                    margin: 10px 0;
                    display: flex;
                    align-items: center;
                    justify-content: flex-start;
                    .ctfimg {
                        display: block;
                        width: 123px;
                        height: 100px;
                        vertical-align: middle;
                        margin-right: 10px;
                        font-style: normal;
                    }
                    .ctfimg.chengxin {
                        background: url('/static/business_detail_icons.png') -10px -10px;
                    }
                    .ctfimg.hefa {
                        background: url('/static/business_detail_icons.png') -118px -10px;
                    }
                    .ctfimg.zizhi {
                        background: url('/static/business_detail_icons.png') -228px -10px;
                    }
                    .ctfintro {
                        height: 100px;
                        text-align: left;
                        h2 {
                            display: block;
                            font-size: .3rem;
                            font-weight: bold;
                            padding: 5px 0;
                            position: relative;
                            a {
                                position: absolute;
                                top: 10px;
                                right: 0;
                                font-size: .23rem;
                                color: #0082cd;
                                font-weight: normal;
                            }
                        }
                        p {
                            font-size: .26rem;
                            color: #333;
                            padding: 5px 0;
                        }
                    }
                }
            }
			.bns-contact {
                margin: 20px 0 15px 0;
                .cntTitle {
                    font-size: .3rem;
                    color: #333;
                    font-weight: bold;
                    text-align: left;
                }
                ul {
                    li {
                        padding: 10px 10px 10px 20px;
                        height: 76px;
                        line-height: 1;
                        display: flex;
                        justify-content: space-between;
                        align-items: center;
                        text-align: left;
                        background: #fdfdfd;
                        margin: 10px 0;
                        .sns-img {
                            display: block;
                            font-style: normal;
                            width: 35px;
                            height: 35px;
                            vertical-align: middle;
                            margin-right: 10px;
                        }
                        .sns-img.qq1 {
                            background: url('/static/business_detail_icons.png') -10px -186px;
                        }
                        .sns-img.skype2 {
                            background: url('/static/business_detail_icons.png') -66px -130px;
                        }
                        .sns-img.phone3 {
                            background: url('/static/business_detail_icons.png') -176px -130px;
                        }
                        .sns-img.weixin4 {
                            background: url('/static/business_detail_icons.png') -122px -130px;
                        }
                        .sns-img.email5 {
                            background: url('/static/business_detail_icons.png') -10px -130px;
                        }
                        h2 {
                            display: block;
                            width: 180px;
                            text-align: left;
                            font-size: .3rem;
                            font-weight: bold;
                            color: #333;
                            overflow: hidden;
                            text-overflow:ellipsis;
                            white-space: nowrap;
                        }
                        .loginMsg {
                            margin-right: 25px;
                        }
                        p {
                            text-align: right;
                            a {
                                display: block;
                                padding: 5px 10px;
                                color: #478dce;
                                font-size: .26rem;
                            }
                        }
                    }
                }
            }
			.attention-frame{
				margin-top: 30px;
				.attention{
					font-size: 16px;
					color: #333333;
					font-weight: bold;
				}
				.reader{
					font-size: .25rem;
					color: #333;
					text-align: right; 
					padding-top: 5px;
                    .kf{
                        color: #333;
                    }
				}
				.attention-brief{
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
            .attention-frame-public{
                margin-top: 30px;
                height: 60px;
                line-height: 60px;
                text-align: center;
                border-radius: 2px;
                border: 1px solid #ffc3b4;
                color: #f5785c;
                background: #ffe5de;
                font-size: .26rem;
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
                        color: #28b28a;
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
						border-radius: 50%;
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
</style>