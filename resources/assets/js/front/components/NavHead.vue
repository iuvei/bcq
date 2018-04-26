<template>
<div id="nav-header">
    <div id="TopBar" v-bind:class="{'serch-mask':show_search}">
        <Row :class-name="'top-bar'" type="flex" justify="center" align="middle">
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'container'">
                <Row type="flex" justify="space-between">
                        <Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
                            <ul class="t1">
                                <li class="has-dropdown">
                                    <a href="javascript:;">
                                        商讯导航<Icon type="arrow-down-b" class="Icon-arrows"></Icon>
                                    </a>
                                    <ul class="dropdown">
                                        <template v-for="(cat,key) in catList">
                                            <li v-if="cat.fid == 0"><a :href="'/trade/business/'+cat.id+'/0'">{{cat.cname}}</a></li>
                                            <li v-else><a :href="'/trade/business/'+cat.fid+'/'+cat.id">{{cat.cname}}</a></li>
                                        </template>
                                    </ul>
                                </li>
                                <li><a @click="go('/trade/Publish')" class="txt-orange"> <b>|</b> 免费发布信息 </a></li>
                                <li><a href="/parts/about#public" target="_blank"> <b>|</b> 投放渠道 </a></li>
                                <li><a target="_blank" href="/gamepage#platform" class="txt-orange"> <b>|</b> 获取游戏接口 </a></li>
                                <li><a href="/parts/Help#help" target="_blank"> <b>|</b> 帮助中心 </a></li>
                            </ul>
                        </Col>
                        <Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
                            <ul class="t1 t3">
                                <li><a href="/parts/Help#help" target="_blank"> 什么是菠菜种? </a></li>
                                <li @click="tobe_author"><a class="txt-orange"> <b>|</b> 成为作者，获得商业机会 </a></li>
                                <li class="be-report" v-on:click="reportModal()"><a> <b>|</b> 寻求报道 </a></li>
                            </ul>
                        </Col>
                </Row>
            </Col>
        </Row>
        <!--主导航-->
        <Row :class-name="'m-funcTab'" type="flex" justify="center" align="middle">
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'container'">
                <nav>
                    <a @click="go('/')" class="logo-zone">
                        <img src="/static/logo.png">
                    </a>
                    <ul class="tab-nav" v-if="!show_search">
                        <li class="nav-items" @mouseover="show_panel='news'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='news'}">
                            <a class="topLevel">资讯<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
<!--                         <li class="nav-items" @mouseover="show_panel='flash'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='flash'}">
                            <a class="topLevel" @click="go('/7x24h')">7*24h快讯</a>
                        </li> -->
                        <li class="nav-items" @mouseover="show_panel='trade'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='trade'}">
                            <a class="topLevel" href="#">交易<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
                        <li class="nav-items" @mouseover="show_panel='data'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='data'}">
                            <a class="topLevel" href="#">资料<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
                        <li class="nav-items" @mouseover="show_panel='tool'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='tool'}">
                            <a class="topLevel" href="#">工具<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
                        <li class="nav-items" @mouseover="show_panel='game'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='game'}">
                            <a class="topLevel service" href="#"><img src="/static/guanfangzhifu.png">服务<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
                        <li class="nav-items" @mouseover="show_panel='question'" @mouseout="show_panel=''" v-bind:class="{'active':show_panel=='question'}">
                            <a class="topLevel" href="#">互动<Icon type="arrow-down-b" class="Icon-arrows"></Icon></a>
                        </li>
                    </ul>
                    <ul v-if="show_search">
                        <li>
                            <div class="search-wrapper">
                                <i class="icon icon-search1"></i>
                                <input type="text" class="search-input"  v-bind:class="{'animated slideInRight':show_search}" v-model="keywords" placeholder="搜索什么你说了算" @keyup.enter="search"/>
                                <span @click="close_search_frame" class="s-close" v-bind:class="{'animated zoomIn':show_search}">
                                    <Icon type="close-round"></Icon>
                                </span>
                            </div>
                        </li>
                    </ul>
                </nav>
                <ul class="userAction" v-if="!show_search">
                    <li class="vip-site"><a href="http://zhaoshang.haoyunlai.ph/" target="_blank"><img src="/static/bcqad/haoyunlai.png"></a></li>
                        <div class="post-button-frame">
                            <a class="post-button">
                                <span class="occupy" @mouseover="show_post_pannel=true" @mouseout="show_post_pannel=false"></span>
                                <div class="position-tag" v-if="show_post_pannel||on_post_pannel"></div>
                                <Button class="common-button2">Post</Button>
                                <div class="post-frame" v-if="show_post_pannel||on_post_pannel" @mouseover="on_post_pannel=true" @mouseout="on_post_pannel=false">
                                    <ul class="post-frame-flex">
                                        <li class="'post-zone'">
                                            <div @click="publish_micro">
                                                <img src="/static/micro.png" style="margin-top:1px">
                                                <h2 class="post-title">发布微动态</h2>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/user/write')">
                                                <i class="round fbwz"></i>
                                                <h2 class="post-title">发布文章</h2>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/trade/Publish')">
                                                <i class="round jyxx"></i>
                                                <h2 class="post-title">发布交易信息</h2>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/news/trend')">
                                                <i class="round xcp"></i>
                                                <h2 class="post-title">分享新产品</h2>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/userdata/UserDataUpload')">
                                                <i class="round xzzy"></i>
                                                <h2 class="post-title">分享下载资源</h2>
                                                <b style="font-weight:normal; color:#28b28a; font-size:12px; vertical-align: middle; padding-top: 8px;cursor: pointer;">(赚菠菜种)</b>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/newquestion')">
                                                <i class="round wd"></i>
                                                <h2 class="post-title">提产业问题</h2>
                                            </div>
                                        </li>
                                        <li class="'post-zone'">
                                            <div @click="go('/userdata/addCash')">
                                                <i class="round xjw"></i>
                                                <h2 class="post-title">提交现金网</h2>
                                            </div>
                                        </li>    
                                    </ul>
                                </div>
                            </a>                            
                        </div>
                    <li v-if="user_info">
                        <div class="login-info">
                            <a @click="show_search_frame">
                                <i class="icon icon-search1"></i>
                                <b>搜索</b>
                            </a>
                            <span class="user-detail" @mouseover="show_user_pannel=true" @mouseout="show_user_pannel=false">
                                <img v-bind:src="user_info.image" class="avatar" onerror="this.src='/static/noimg.png'">
                                <div class="user-detail-occupy"></div>
                                <Icon class="mail-dot" type="record" size="10" color="red" v-if="mail_count"></Icon>
                                <Row class="user-pannel" v-if="show_user_pannel||user_pannel" @mouseover="user_pannel=true" @mouseout="user_pannel=false">
                                    <Col>
                                        <div class="position-tag"></div>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                            <div class="avatar-frame-new">
                                                <img v-bind:src="user_info.image" @click="go('/user/userpage')" onerror="this.src='/static/noimg.png'">
                                            </div>
                                        </Col>
                                        <Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
                                            <a class="logout" @click="logout">退出</a>
                                        </Col>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-name'">
                                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                            <a class='user-name-frame'>{{user_info.username}}</a>
                                        </Col>
                                        <Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'user-ctf'">
                                            <a v-if="user_info.is_author">
                                                <img src="/static/author_confirm.png" title="认证作者">
                                            </a>
                                            <a v-else="user_info.is_author" class="apply-author" @click="go('/news/beAuthor')">(申请成为作者)</a>
                                        </Col>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-mail'">
                                        <div @click="go('/user/userpage/5')" class="mail">
                                            <Icon type="ios-email-outline" size="22" style="vertical-align: middle"></Icon>
                                            <Icon class="mail-dot" type="record" size="10" color="red" v-if="mail_count"></Icon>
                                            <span>我的私信</span>
                                        </div>
                                        <div @click="go('/user/userpage')" class="set">
                                            <Icon type="ios-gear-outline" size="22" style="vertical-align: middle"></Icon>
                                            <span>设置</span>
                                        </div>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-price'">
                                        <div class="mail">
                                            <Icon type="ios-color-filter-outline" size="20" style="vertical-align: middle"></Icon>
                                            <span>菠菜种子</span>
                                        </div>
                                        <div class="set">
                                            <a href="/parts/Help#help" target="_blank">什么是菠菜种？</a>
                                        </div>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"
                                         :class-name="'user-price-count'">
                                                <span @click="go('/user/userpage/6')">{{user_info.price}}</span><b>颗</b>
                                    </Col>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-button'">
                                        <Button class="common-button3"><a href="/parts/Help#help" target="_blank" style="color:white">获得菠菜种</a></Button>
                                    </Col>
                                </Row>
                            </span>
                        </div>
                    </li>
                    <li v-if="!user_info&&show_loading" class="no-login">
                        <a @click="show_search_frame">
                            <i class="icon icon-search1"></i>
                            <b>搜索</b>
                        </a>
                        <a @click="go('/account?t=login')">
                            <i class="icon icon-login"></i>
                            <b>登录</b>
                        </a>
                         <a @click="go('/account?t=register')">
                             <i class="icon icon-signup"></i>
                             <b>注册</b>
                        </a>
                    </li>
                </ul>              
            </Col>
        </Row>

        <!-- 下拉导航 -->
        <div class="nav-dropdown" @mouseover="show_panel='news'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='news'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                    <li class="item">
                        <a class="nav-subCate"  @click="go('/news')">
                            <i class="nt-img cyzx"></i>
                            <h2 class="nt-title">产业资讯</h2>
                            <p class="nt-intro">一手资讯尽在掌握</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate" @click="go('/news/special')">
                            <i class="nt-img cyzt"></i>
                            <h2 class="nt-title">产业专题</h2>
                            <p class="nt-intro">热门焦点资讯不过时</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate"  @click="go('/news/author')">
                            <i class="nt-img zlzz"></i>
                            <h2 class="nt-title">专栏作者</h2>
                            <p class="nt-intro">权威作家专业点评</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate"  @click="go('/news/trend')">
                            <i class="nt-img cpdt"></i>
                            <h2 class="nt-title">产品动态</h2>
                            <p class="nt-intro">产业产品率先得知</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate" @click="go('/news/report')">
                            <i class="nt-img sjbg"></i>
                            <h2 class="nt-title">数据报告</h2>
                            <p class="nt-intro">数据驱动产业</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate" @click="go('/parts/exbition')">
                            <img class="nt-img" src="/static/zhanhui.png">
                            <h2 class="nt-title">行业展会</h2>
                            <p class="nt-intro">关注展会了解产业</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="nav-dropdown" @mouseover="show_panel='data'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='data'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                <li class="item">
                    <a class="nav-subCate" @click="go('/userdata/datalist')">
                        <i class="nt-img zlxz"></i>
                        <h2 class="nt-title">产业资源下载</h2>
                        <p class="nt-intro">产业资源汇聚其中</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" @click="go('/userdata/Navigation')">
                        <i class="nt-img wzdh"></i>
                        <h2 class="nt-title">优质网址导航</h2>
                        <p class="nt-intro">泛博彩网址收录其中</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" @click="go('/userdata/Cash')">
                        <img class="nt-img" src="/static/xianjinwang.png">
                        <h2 class="nt-title">现金网</h2>
                        <p class="nt-intro">菠菜现金网评分</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" @click="go('/userdata/Enterprise')">
                        <img class="nt-img" src="/static/qiyeku.png">
                        <h2 class="nt-title">企业库</h2>
                        <p class="nt-intro">企业资料尽在掌握</p>
                    </a>
                </li>
            </ul>
            </div>
        </div>
        <div class="nav-dropdown" @mouseover="show_panel='tool'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='tool'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                    <li class="item">
                        <a class="nav-subCate calc-tool" @click="calcModal()">
                            <img class="nt-img" src="/static/jisuangongju.png">
                            <h2 class="nt-title">打码计算工具</h2>
                            <p class="nt-intro">合理分配让利流水</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate" @click="go('/rewardpage')">
                            <img class="nt-img" src="/static/kaijiang.png">
                            <h2 class="nt-title">彩票唯一官方开奖</h2>
                            <p class="nt-intro">数据对照准确无误</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="nav-dropdown" @mouseover="show_panel='game'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='game'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                <li class="item">
                    <a class="nav-subCate" @click="go('/gamepage')">
                        <img class="nt-img" src="/static/youxijiekou.png">
                        <h2 class="nt-title">游戏接口</h2>
                        <p class="nt-intro">认证渠道商推荐</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" @click="go('/trade/BusinessDetail/2609')">
                        <img class="nt-img" src="/static/payment.png">
                        <h2 class="nt-title">支付接口</h2>
                        <p class="nt-intro">官方合作三方支付</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" href="https://bbs.boniu3658.com/thread-179439-1-1.html" target="_blank">
                        <i class="nt-img ujob"></i>
                        <h2 class="nt-title">人才服务</h2>
                        <p class="nt-intro">专业猎头人才服务</p>
                    </a>
                </li>
                <li class="item">
                    <a class="nav-subCate" href="#" title="频道优化中，请静候佳音...">
                        <i class="nt-img app"></i>
                        <h2 class="nt-title" style="opacity: .3;">APP流量分发</h2>
                        <p class="nt-intro" style="opacity: .3;">一手渠道助力推广</p>
                    </a>
                </li>
            </ul>
            </div>
        </div>
        <div class="nav-dropdown" @mouseover="show_panel='question'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='question'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                <li class="item">
                    <a class="nav-subCate" @click="go('/questionpage')">
                        <i class="nt-img wd"></i>
                        <h2 class="nt-title">问答</h2>
                        <p class="nt-intro">群策群力的智慧</p>
                    </a>
                </li>
            </ul>
            </div>
        </div>
        <div class="nav-dropdown" @mouseover="show_panel='trade'"  @mouseout="show_panel=''" v-bind:class="{'nav-dropdown-show animated slideInDown':show_panel=='trade'}">
            <div class="nav-cateCard">
                <ul class="card-list">
                    <li class="item">
                        <a class="nav-subCate" @click="go('/trade/platform')">
                            <i class="nt-img dlzs"></i>
                            <h2 class="nt-title">代理招商</h2>
                            <p class="nt-intro">代理+平台=财富</p>
                        </a>
                    </li>
                    <li class="item">
                        <a class="nav-subCate" @click="go('/trade/business')">
                            <i class="nt-img gqsx"></i>
                            <h2 class="nt-title">供求商讯</h2>
                            <p class="nt-intro">帮您卖掉好产品</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div class="global-search-mask" v-if="show_search" @click="show_search=false"></div>
    <CalcTool></CalcTool>
    <BeReport></BeReport>
</div>
</template>

<script>
    import 'normalize.css/normalize.css';
    import '../../../css/reset.css';
    import 'animate.css';
    import '../../../css/icons.css';
    import $ from 'jquery';
    import CalcTool from '../tgq/calcTool.vue';
    import BeReport from '../tgq/beReport.vue';
    export default {
        components: { CalcTool,BeReport },
        mounted(){
            var v = this;
            if (!this.$store.state.user_info) {
                this.https.get('/common/is_login').then((r)=>{
                    if (r.data.code == 1) {
                        v.user_info_init = r.data.user_info;
                        v.$store.commit('authCheck',{user_info:r.data.user_info});
                    }
                    v.show_loading = true
                }).catch((e)=>{
                    console.log(e);
                });   
            }else{
                v.user_info_init = this.$store.state.user_info;
            } 
            v.https.get('/front/components/get_cat_list').then((r)=>{
                v.catList = r.data.catList;
            }).catch((e)=>{
                console.log(e);
            });              
            
            v.mail_count = v.$store.state.mail_count
            if (this.$store.state.user_info) {
                setInterval(function(){ 
                    v.https.get('/front/components/get_mail_count').then((r)=>{
                        v.mail_count = r.data.mail_count
                        v.$store.commit('mailCheck',{mail_count:v.mail_count});
                    }).catch((e)=>{
                        console.log(e);
                    }); 
                },10000)                
            }
        },
        data() {
            return {
                calcModal: function () {

                },
                reportModal: function () {
                    
                },
                user_info_init:'',
                show_loading:false,
                news: {
                    title: false,
                    nav: false,
                },
                show_panel:'',
                show_search:false,
                show_user_pannel:false,
                user_pannel:false,
                show_post_pannel:false,
                on_post_pannel:false,
                mail_count:0,
                catList:[],
                keywords:'',
                calcModal: function () {

                },
                authorModal: function () {

                },
                reportModal: function () {

                },
            }
        },
        computed:{
            user_info(){
                if (this.user_info_init) {
                    return this.user_info_init;
                }else if (this.$store.state.user_info) {
                    return this.$store.state.user_info
                }
            }
        },
        methods: {
            publish_micro(){
                if (!this.$store.state.user_info) {
                    this.go('/account?t=login')
                }else{
                    this.go('/')      
                }
            },
            go: function (path) {
                var path = path
                var href = window.location.href
                var is_userpage = href.indexOf('/user/userpage')
                this.$router.push({path: path})
                if(path.indexOf('/user/userpage')>=0&&is_userpage>=0){                   
                    this.$router.go(0)
                }
            },
            logout(){
                this.https.get('/common/logout')
                this.user_info_init = ''
                this.$store.state.user_info = ''
                this.$router.push('/')
                this.show_loading=true
                location.reload()
            },
            show_search_frame(){
                this.show_search = true
                this.$nextTick(function(){
                    $(".search-input").focus()
                })
            },
            close_search_frame(){
                this.show_search = false
            },
            search(){
                var keywords = this.keywords.trim()
                if (!keywords) {
                    this.$Message.warning('请输入搜索内容')
                    return false
                }
                this.$router.push({ path: '/search', query: { keywords: keywords }})
                if(this.$route.path == '/search'){                   
                    this.$router.go(0)
                }
            },  
            tobe_author(){
                var v = this
                if (v.$store.state.user_info.is_author == 1) {
                    v.$Message.success('您已经是认证作者')
                    return false
                }else{
                    v.https.get('/common/is_author').then((r)=>{
                        if (r.data.code == 1) {
                            v.$Message.success('您已经是认证作者')
                            return false
                        }else{
                            v.$router.push('/news/beAuthor')
                        }
                    }).catch((e)=>{
                        console.log(e)
                    })
                }
            },       
        },

    }
</script>

<style lang="scss" scoped>
    * {
        box-sizing: border-box;
    }
    html, body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    #nav-header {
        display: block;
        height: 100px;
    }
    #TopBar {
        width: 100%;
        height: 100%;
        background: #fff;
        position: relative;
    }
    .serch-mask{
        height: 100px!important;
        position: fixed!important;
        z-index: 1;
    }
    .container{
        width: 1200px;
        margin: 0 auto;
    }
    .Icon-arrows {
        margin-left: 5px;
        color: #666;
    }
    .icon {
        font-size: .43rem;
        font-style: normal;
        color: #666;
        vertical-align: middle;
        &:hover, &:focus {
            color: #28b28a;
        }
    }
        /*  头部导航条 */
    .top-bar {
        position: absolute;
        width: 100%;
        background: #2e3237;
        line-height: 30px;
        height: 30px;
        z-index:1000;
    }
    .top-bar a {
        display: inline-block;
        font-size: 12px; /*12px*/
        color: #666;
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
        &:hover , &:focus, &:active {
            color: #28b28a;
        } 
    }
    .top-bar .t1 {
        text-align: left;
        li {
            list-style: none;
            display: inline-block;
            &:hover , &:focus, &:active {
                color: #28b28a;
            }
            a {
                display: inline-block;
                font-size: 12px;
                color: #c1c2c3;
                -webkit-transition: 0.3s;
                -o-transition: 0.3s;
                -moz-transition: 0.3s;
                -ms-transition: 0.3s;
                transition: 0.3s;
                &:hover , &:focus, &:active {
                    color: #fff;
                }
            }
            b {
                color: #666;
            }
            a.txt-orange {
                color: #ff7b34;
                transition: 0.5s;
                font-size: 12px;
                -webkit-transition: 0.3s;
                -o-transition: 0.3s;
                -moz-transition: 0.3s;
                -ms-transition: 0.3s;
                &:hover , &:focus, &:active {
                    color: #28b28a;
                }
            }
        }
    }
    /* 主导航 */
    .m-funcTab {
        position: absolute;
        top: 30px;
        z-index: 100;
        width: 100%;
        margin: 0 auto;
        line-height: 1;
        height: 70px;
        background: #fff;
        -webkit-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
        -moz-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
        box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
        > .container {
            width: 1200px;
            margin: 0 auto;
            &:after, &:before {
                content: '';
                display: block;
                clear: both;
                }
            }
        }
        nav, .userAction {
            height: 70px;
        }
        nav {
            width: 75%;
            line-height: 70px;
            float: left;
        }
        .logo-zone img {
            height: 100%;
            width: 100%;
            vertical-align: middle;
        }
        .logo-zone {
            float: left;
            width: 140px;
            height: 48px;
            margin: 10px 0;
            margin-right: 20px;
            text-align: center;
            line-height: 1;
            overflow: hidden;
        }
        .tab-nav {
            text-align: left;
            font-weight: 400;
            color: #333;
            overflow: hidden;
            height: 70px;
        }
        .nav-items {
            display: inline-block;
            padding: 0 8px;
            text-align: center;
            height: 100%;
            cursor: pointer;
        }
         .tab-nav .nav-items .topLevel {
            display: inline-block;
            font-size: 16px;
            color: #444;
            letter-spacing: 1px;
            font-weight: 500;
            text-align: center;
            position: relative;
            top: 8px;
            line-height: 1;
            padding: 0 10px 18px 10px;
             border-bottom: 3px solid transparent;
            transition: color 0.3s, border .3s;
            transition-duration: .3s;
            transition-timing-function: ease;
            transition-delay: 0.2s; 
        } 
        .service{
            position: relative;
            img{
                position: absolute;
                top: -20px;
                left: -5px;
                cursor: default;
            }
        }
         .nav-items.active .topLevel {
            color: #28b28a;
            border-bottom: 3px solid #28b28a;
        } 
        .nav-items.active .Icon-arrows, .nav-items:hover .Icon-arrows {
            transform: rotate(180deg);
            -webkit-transform: rotate(180deg);
            -moz-transform: rotate(180deg);
            -o-transform: rotate(180deg);
            -moz-transition: all .5s;
            -webkit-transition: all .5s;
            -o-transition: all .5s;
        }
        .userAction {
            float: right;
            padding: 5px 0;
            line-height: 1;
            position: relative;
            padding-left: 100px;
            .vip-site{
                position: absolute;
                top: 1px;
                left: -150px;
            }
            .no-login{
                color: #2e3136;
                width: 180px;
                text-align: center;
                display: flex;
                display: -webkit-flex;
                justify-content: space-between;
                align-items: center;
                >a {
                    display: block;
                    text-align: center;
                    padding: 6px 10px;
                    cursor: pointer;
                    color: #2e3136;
                    &:hover .icon, &:focus .icon {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    &:hover b, &:focus b {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    b {
                        display: block;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 12px;
                        color: #2e3136;
                        padding-top: 3px;
                        transition: color .3s;
                    }
                }                
            }
            .post-button-frame{
                width: 100px;
                display: block;
                position: absolute;
                left: 0;
                top: 15px;
                .post-button {
                    position: relative;
                    .occupy {
                        position: absolute;
                        width: 68px;
                        height: 60px;
                        background-color: transparent;
                        top: 5px;
                        left: 10px;
                        z-index: 100;
                    }
                    .position-tag {
                        position: absolute;
                        bottom: -10px;
                        left: 40px;
                        height: 0;
                        width: 0;
                        pointer-events: none;
                        border: solid transparent;
                        border-bottom-color: #f2f2f2;
                        border-width: 8px;
                        margin-left: -8px;
                    }
                    .post-frame {
                        position: absolute;
                        top: 58px;
                        left: -530px;
                        width: 880px;
                        height: 150px;
                        background: #fff;
                        -webkit-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        -moz-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        -webkit-border-bottom-left-radius: 3px;
                        -webkit-border-bottom-right-radius: 3px;
                        -moz-border-bottom-left-radius: 3px;
                        -moz-border-bottom-right-radius: 3px;
                        -o-border-bottom-left-radius: 3px;
                        -o-border-bottom-right-radius: 3px;
                        -ms-border-bottom-left-radius: 3px;
                        -ms-border-bottom-right-radius: 3px;
                        -webkit-transition: .3s;
                        -moz-transition: .3s;
                        -ms-transition: .3s;
                        -o-transition: .3s;
                        transition: .3s;
                        .post-frame-flex{
                            display: flex;
                            display: -webkit-flex;
                            flex-direction:row;
                            flex-wrap:wrap;
                            justify-content:space-around;
                            padding-top: 30px;
                            .post-zone {
                                padding-top: 20px;
                                text-align: center;
                                p {
                                    margin-top: 10px;
                                    font-size: 14px;
                                    color: #666;
                                    font-weight: bold;
                                }
                            } 
                        }                    
                    }
                }
                >a {
                    display: block;
                    text-align: center;
                    padding: 6px 10px;
                    cursor: pointer;
                    color: #2e3136;
                    margin-right: 30px;
                    &:hover .icon, &:focus .icon {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    &:hover b, &:focus b {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    b {
                        display: block;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 12px;
                        color: #2e3136;
                        padding-top: 3px;
                        transition: color .3s;
                    }
                }   
                .common-button2 {
                    border-radius: 15px;
                    font-size: 14px;
                    width: 68px;
                    padding: 0 !important;
                    height: 32px;
                    color: #28b28a;
                    border: 1px solid #28b28a;
                    background: #fff;
                }
                             
            }
            .login-info {
                display: flex;
                display: -webkit-flex;
                justify-content: flex-start;
                align-items: center;
                text-align: center;
                margin-right: 20px;
                padding-top: 5px;
                .common-button2 {
                    border-radius: 15px;
                    font-size: 14px;
                    width: 68px;
                    padding: 0 !important;
                    height: 32px;
                    color: #28b28a;
                    border: 1px solid #28b28a;
                    background: #fff;
                }

                >a {
                    display: block;
                    text-align: center;
                    padding: 6px 10px;
                    cursor: pointer;
                    color: #2e3136;
                    margin-right: 30px;
                    &:hover .icon, &:focus .icon {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    &:hover b, &:focus b {
                        color: #28b28a;
                        transition: color .3s;
                    }
                    b {
                        display: block;
                        font-style: normal;
                        font-weight: normal;
                        font-size: 12px;
                        color: #2e3136;
                        padding-top: 3px;
                        transition: color .3s;
                    }
                }
                .avatar {
                    vertical-align: middle;   
                    width: 40px;
                    height: 40px;
                    border-radius: 50%;
                    outline: none;
                    border:1px solid #efefef;
                }
                .user-detail {
                    position: relative;
                    .user-detail-occupy {
                        position: absolute;
                        width: 60px;
                        height: 70px;
                        top: -5px;
                        left: -10px;
                        border: none;
                        background: transparent;
                        cursor: pointer;
                    }
                    .mail-dot{
                        position: absolute;
                        top: 30px;
                        left: 30px;
                    }
                    .position-tag {
                        content: '';
                        position: absolute;
                        top: -40px;
                        right: 16px;
                        height: 0;
                        width: 0;
                        pointer-events: none;
                        border: solid transparent;
                        border-bottom-color: #f2f2f2;
                        border-width: 8px;
                        margin-left: -8px;
                    }
                    .user-pannel {
                        width: 280px;
                        min-height: 354px;
                        position: absolute;
                        right: -20px;
                        top: 56px;
                        background: #fff;
                        padding: 20px 15px;
                        -webkit-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        -moz-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.45);
                        -webkit-border-bottom-left-radius: 3px;
                        -webkit-border-bottom-right-radius: 3px;
                        -moz-border-bottom-left-radius: 3px;
                        -moz-border-bottom-right-radius: 3px;
                        -o-border-bottom-left-radius: 3px;
                        -o-border-bottom-right-radius: 3px;
                        -ms-border-bottom-left-radius: 3px;
                        -ms-border-bottom-right-radius: 3px;
                        -webkit-transition: .3s;
                        -moz-transition: .3s;
                        -ms-transition: .3s;
                        -o-transition: .3s;
                        transition: .3s;
                        .avatar-frame-new { //圆形头像 以后就用个，限制大小的话用外层div
                            width: 88px;
                            height: 88px;
                            border-radius: 50%;
                            text-align: center;
                            overflow: hidden;
                            border: 1px solid #f2f2f2;
                            cursor: pointer;
                            img {
                                width: 100%;
                                height: 100%;
                                border-radius: 50%;
                                vertical-align: middle;
                            }
                        }
                        .logout {
                            margin-left: 35px;
                            margin-top: 5px;
                            font-size: 12px;
                            color: #666;
                            display: block;
                            cursor: pointer;
                            &:hover {
                                text-decoration: underline;
                                color: #28b28a;
                            } 
                        }
                        .user-name ,.user-mail ,.user-price,.user-price-count ,.user-button {
                            padding-top: 22px;
                            cursor: pointer;
                            &:hover {
                               color: #28b28a;
                            }
                        }
                        .user-price {
                            border-bottom: 0;
                        }
                        .user-mail, .user-price {
                            border-bottom: 1px solid #efefef;
                            padding-bottom: 10px;
                            display: flex;
                            display: -webkit-flex;
                            justify-content: space-between;
                            align-items: center;
                            position: relative;
                            .mail-dot {
                                position: absolute;
                                left: 30px;
                                top:26px;
                            }
                            span {
                                font-size: 13px;
                                color: #333;
                                vertical-align: middle;
                                margin-right: 6px;
                                cursor: pointer;
                                &:hover {
                                   color: #28b28a;
                                }
                            }
                            a {
                                display: block;
                                color: #478dce;
                                &:hover {
                                    color: #28b28a;
                                    text-decoration: underline;
                                }
                            }
                            .mail {
                                width: 50%;
                                text-align: left;
                                margin-left: 20px;
                                padding: 5px 0;
                                vertical-align: middle;
                            }
                            .set {
                                width: 50%;
                                text-align: right;
                                margin-right: 20px;
                                padding: 5px 0;
                                vertical-align: middle;
                            }

                        }

                        .user-name {
                            .user-name-frame {
                                width: 80px;
                                height: 18px;
                                font-size: 16px;
                                font-weight: bold;
                                color: #333;
                                display: inline-block;
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
                            .user-ctf {
                                text-align: left;
                                a {
                                    display: inline-block;
                                    cursor: pointer;

                                    &:hover {
                                        color: #28b28a;
                                        text-decoration: underline;
                                    }
                                }
                                .apply-author {
                                    font-size: 12px;
                                    color: #333;
                                    font-weight: 400;
                                }
                            }
                        }
                        .user-price-count {
                            span {
                                font-size: 32px;
                                color: #333;
                                font-weight: bold;
                                &:hover {
                                    color: #28b28a;
                                    cursor: pointer;
                                }
                            }
                            b {
                                font-size: 12px;
                                color: #333;
                                font-weight: normal;
                                margin-left: 7px;
                            }
                        }
                        .user-button {
                            .common-button3 {
                                font-size: 14px;
                                font-weight: 500;
                                color: #fff;
                                background: #28b28a;
                                width: 200px;
                                height: 38px;
                                line-height: 14px;
                                text-align: center;
                                padding: 5px 0;
                                border-radius: 3px;
                                outline: none;
                                border: 1px solid #28b28a;
                                &:hover{
                                    color: #fff;
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
        .userAction>li {
            margin: 3px 0;
        }
        .nav-dropdown {
            display: none;
            min-height: 3rem;
            position: absolute;
            top: 98px;
            left: 0;
            right: 0;
            width: 100%;
            margin: 0 auto;
            background: #fff;
            padding-left: 50%;
            z-index:10;
        }
        .nav-dropdown-show {
            display: block;
        }
        .nav-cateCard {
            position: relative;
            left: -1500px;
            width: 3000px;
            padding-top: 20px;
            background-color: #fff;
            text-align: center;
            /*border-bottom: 1px solid #eaeaea;*/
            -webkit-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
            -moz-box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
            box-shadow: 0 0 3px 1px rgba(51, 51, 51, .1);
        }
        .card-list {
            width: 1200px;
            margin: 0 auto;
            white-space: nowrap;
        }
        .item {
            display: inline-block;
            margin: 0 30px 30px 30px;
            vertical-align: middle;
            min-width: 110px;
            text-align: center;
        }
        a.nav-subCate {
            display: inline-block;
            text-align: center;
            color: #666;
            padding: 10px;
        }
        .nt-img {
            display: inline-block;
            width: 60px;
            height: 60px;
            text-align: center;
            vertical-align: middle;
        }
        .nt-img.cyzx {
            background: url('/static/nav_icons.png') -170px -90px;
        }
        .nt-img.cyzt {
            background: url('/static/nav_icons.png') -250px -170px;
        }
        .nt-img.zlzz {
            background: url('/static/nav_icons.png') -250px -10px;
        }
        .nt-img.cpdt {
            background: url('/static/nav_icons.png') -90px -10px;
        }
        .nt-img.sjbg {
            background: url('/static/nav_icons.png') -10px -10px;
        }
        .nt-img.zlxz {
            background: url('/static/nav_icons.png') -250px -90px;
        }
        .nt-img.wzdh {
            background: url('/static/nav_icons.png') -10px -170px;
        }
        .nt-img.dlzs {
            background: url('/static/nav_icons.png') -10px -90px;
        }
        .nt-img.gqsx {
            background: url('/static/nav_icons.png') -90px -90px;
        }
        .nt-img.wd {
            background: url("/static/nav_icons.png") -90px -170px;
        }
        .nt-img.ujob {
            background: url("/static/nav_icons.png") -10px -250px;
        }
        .nt-img.app {
            background: url("/static/nav_icons.png") -90px -250px;
            opacity: .3;
        }
        /* post下拉框 */
        .round {
            display: inline-block;
            width: 56px;
            height: 56px;
            overflow: hidden;
            border-radius: 50%;
            vertical-align: middle;
        }
        .round.fbwz {
            background: url('/static/post_icons.png') -162px -10px;
        }
        .round.jyxx {
            background: url('/static/post_icons.png') -86px -10px;
        }
        .round.xcp {
            background: url('/static/post_icons.png') -10px -10px;
        }
        .round.xzzy {
            background: url('/static/post_icons.png') -162px -86px;
        }
        .round.wd {
            background: url('/static/post_icons.png') -10px -86px;
        }
        .round.xjw {
            background: url('/static/post_icons.png') -86px -86px;
        }
        .post-title {
            margin-top: 15px;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            line-height: 1;
            min-width: 100px;
            transition: all .3s;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            -o-transition: all .3s;
        }
        .nt-title {
            margin-top: 20px;
            font-size: 15px;
            font-weight: bold;
            line-height: 1;
            min-width: 100px;
            transition: all .3s;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            -o-transition: all .3s;
            color: #666;
        }
        .nt-intro {
            font-size: 13px;
            margin-top: 15px;
            color: #666;
        }
        .pointer {
            cursor: pointer;
        }

    .has-dropdown {
        position: relative;
        cursor: pointer;
    }
    .has-dropdown .dropdown {
        min-width: 604px;
        -webkit-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.35);
        -moz-box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.35);
        box-shadow: 0 10px 20px -9px rgba(0, 0, 0, 0.35);
        z-index: 100000002;
        position: absolute;
        display: none;
        top: 29px;
        left: 0;
        text-align: left;
        background: #fff;
        padding: 15px;
        -webkit-border-bottom-left-radius: 4px;
        -webkit-border-bottom-right-radius: 4px;
        -moz-border-bottom-left-radius: 4px;
        -moz-border-bottom-right-radius: 4px;
        -o-border-bottom-left-radius: 4px;
        -o-border-bottom-right-radius: 4px;
        -ms-border-bottom-left-radius: 4px;
        -ms-border-bottom-right-radius: 4px;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .has-dropdown .dropdown:before {
        bottom: 100%;
        left: 40px;
        border: solid transparent;
        content: " ";
        height: 0;
        width: 0;
        position: absolute;
        pointer-events: none;
        border-bottom-color: #fff;
        border-width: 4px;
        margin-left: -4px;
    }
    .has-dropdown .dropdown li {
        display: inline-block;
        margin-bottom: 7px;
        padding: 6px 10px;
        transition: all .3s;
        -webkit-transition: all .3s;
        -moz-transition: all .3s;
        -o-transition: all .3s;
        cursor: pointer;
        &:hover, &:focus {
            color: #28b28a;
            background: #f1f1f1;
        }
        a {
            display: block;
            padding: 6px 10px;
            color: #666;
            line-height: 1.2;
            text-transform: none;
            font-size: 14px; /*14px*/
            transition: all .3s;
            -webkit-transition: all .3s;
            -moz-transition: all .3s;
            -o-transition: all .3s;
            &:hover, &:focus {
                color: #28b28a;
                background: #f1f1f1;
            }
        }
    }
    .has-dropdown:hover .dropdown {
        display: block;
    }
    .has-dropdown:hover .Icon-arrows {
        transform: rotate(180deg);
        transition: all .5s;
        -webkit-transition: all .5s;
        -moz-transition: all .5s;
        -o-transition: all .5s;
        -ms-transition: all .5s;
    }
    .has-dropdown .dropdown li:last-child {
        margin-bottom: 0;
    }
    .top-bar .t2 {
        text-align: center;
        span {
            display: inline-block;
        }
        >.has-dropdown .dropdown {
            z-index: 100000002;
            position: absolute;
            top: 30px;
            left: -205px;
            padding: 15px;
            &:before {
                bottom: 100%;
                left: 50%;
                border: solid transparent;
                content: " ";
                height: 0;
                width: 0;
                position: absolute;
                pointer-events: none;
                border-bottom-color: #fff;
                border-width: 4px;
                margin-left: -4px;
            }
            >li {
                border-left: none;
                border-right: none;
                padding: 0;
                margin: 0;
                list-style: none;
                &:hover, &:focus {
                    background: #fff;
                }
            }
        }
    }
    .top-bar .t3 {
        text-align: right;
    }
    .top-bar b {
        margin: 0 6px 0 6px;
        font-size: 16px; /*16px*/
        color: #999;
    }
    .top-bar Icon {
        font-size: 16px; /*16px*/
        cursor: pointer;
        color: #666;
        vertical-align: middle;
    }
    .top-bar span {
        margin: 0 0 0 5px;
        color: #999;
    }
    a.txt-orange {
        color: #ff7b34;
        -webkit-transition: 0.3s;
        -o-transition: 0.3s;
        transition: 0.3s;
        &:hover , &:focus, &:active {
            color: #478dce;
        }
    }

    /*  top search */
    .top-search>a {
        display: block;
        width: 30px;
        height: 30px;
        vertical-align: middle;
        text-align: center;
    }
    .search-wrapper {
        text-align: left;
        position: relative;
        padding: 1px 0;
        .animated {
            animation-duration: 0.5s;
        }
        .icon-search1{
            position: absolute;
            left: 230px;
            top: 25px;
        }
    }
    .search-input {
        font-size: 14px;
        margin-left: 100px;
        width: 480px;
        right: 300px;
        outline: none;
        text-indent: .2rem;
        color: #333333;
        background: transparent;
        border: 0;
        padding: 0;
    }
    .search-wrapper .s-close {
        cursor: pointer;
        font-size: 14px;
        color: #888;
        display: inline-block;
        text-align: center;
        vertical-align: middle;
        position:absolute;
        left: 790px;
        top: 0;
    }
    a{
        color: #495060;
        &:hover{
            color:#28b28a;
        }
    }
    .global-search-mask {
        background-color: rgba(0, 0, 0, 0.4); 
        width: 100%;
        height: 100%; 
        position: fixed; 
        top: 100px; 
        left: 0;
        z-index: 100000; 
        display: block;
    }
</style>