<template>  
    <Row id="Footer">
<!--         <Row type="flex" justify="center" align="middle">
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'ad-position'">
                <img src="/ad/1200-80.gif">
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'ad-position'">
                <img src="/ad/1200-81.png">
            </Col>
        </Row>   -->
        <Row :class-name="'foot-box2'" type="flex" justify="center" align="middle">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Row :class-name="'friend-title'">
                    <Col :xs=8 :sm=8 :lg=8>
                        <h2 class="rt-title">战略合作伙伴</h2>
                    </Col>
                    <Col :xs=8 :sm=8 :lg=8 offset="8" style="text-align: right;">
                        <a href="http://wpa.qq.com/msgrd?v=3&uin=1750182485&site=qq&menu=yes" target="_blank">成为菠菜圈合作伙伴，共享万级精准产业流量>></a>
                    </Col>
                </Row>
                <Row type="flex" justify="start" :class-name="'friend-links'">
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href=" http://www.maya-gaming.com"><i class="partners ptn1"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="http://www.boniu365.com"><i class="partners ptn2"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="http://www.gem-ds.com/index.html"><i class="partners ptn3"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="https://www.bomao88.com/auth/signin"><i class="partners ptn4"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="https://www.1396bo.com/app"><i class="partners ptn5"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="https://www.g2easia.com/"><i class="partners ptn6"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="http://www.haoyunlai.ph/"><i class="partners ptn7"></i></a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 :class-name="'friend-li'">
                        <a target="_blank" href="https://bbs.boniu3658.com/thread-179439-1-1.html"><i class="partners ptn8"></i></a>
                    </Col>
                </Row>
            </Col>
        </Row>
        <Row :class-name="'foot-box'" type="flex" justify="center" align="middle">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Row type="flex" justify="space-between">
                    <Col :xs=4 :sm=4 :lg=4 :class-name="'ct1'">
                        <h2 class="rt-title">相关产品</h2>
                        <a class="calc-tool" @click="calcModal()">
                            <!--<img src="/static/calc.png" style="width: 45px; height: 45px;" alt="打码量计算工具">-->
                            <i class="ft-img calc"></i>
                            <span>
                                <b>打码计算工具</b>
                                <i>合理分配让利流水</i>
                            </span>
                        </a>
                        <a target="_blank" href="/rewardpage#reward-tool">
                            <!--<img src="/static/reward.png" style="width: 45px; height: 45px;" alt="开奖号码对比">-->
                            <i class="ft-img caipiao"></i>
                            <span>
                                <b>彩票唯一官方开奖</b>
                                <i>数据对照准确无误</i>
                            </span>
                        </a>
                        <a target="_blank" href="/gamepage#platform">
                            <!--<img src="/static/games.png" style="width: 45px; height: 45px;" alt="游戏接口">-->
                            <i class="ft-img games"></i>
                            <span>
                                <b>游戏接口</b>
                                <i>知名提供商信用首选</i>
                            </span>
                        </a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 style="padding-left: 15px;">
                        <h2 class="rt-title">资讯</h2>
                        <a target="_blank" href="/7x24h#NewsFlashes">7*24小时快讯</a>
                        <a target="_blank" href="/news#industry-news">产业资讯</a>
                        <a target="_blank" href="/news/author#author-list">专栏作者</a>
                        <a target="_blank" href="/news/trend#trend-info">产品动态</a>
                        <a target="_blank" href="/news/report#report">数据报告</a>
                        <a target="_blank" href="/parts/exbition#exbition-list">展会信息</a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 style="padding-left: 15px;">
                        <h2 class="rt-title">资料</h2>
                        <a target="_blank" href="/userdata/datalist#userdata-list">产业资源下载</a>
                        <a target="_blank" href="/userdata/Navigation#navigation">优质网址导航</a>
                        <a target="_blank" href="/userdata/Cash#cash">现金网</a>
                        <a target="_blank" href="/userdata/Enterprise#enterprise">企业库</a>
                    </Col>
                    <Col :xs=2 :sm=2 :lg=2>
                        <h2 class="rt-title">交易</h2>
                        <a target="_blank" href="/trade/platform#platform">代理招商</a>
                        <a target="_blank" href="/trade/business#business">供求商讯</a>
                    </Col>
                    <Col :xs=2 :sm=2 :lg=2>
                        <h2 class="rt-title">工具</h2>
                        <a class="calc-tool"  @click="calcModal()">打码计算</a>
                        <a target="_blank" href="/rewardpage#reward-tool">彩票官方开奖</a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3>
                        <h2 class="rt-title">服务</h2>
                        <a target="_blank" href="/gamepage#platform">游戏视角渠道商</a>
                    </Col>
                    <Col :xs=2 :sm=2 :lg=2>
                        <h2 class="rt-title">互动</h2>
                        <a target="_blank" href="/questionpage#question">问答</a>
                    </Col>
                    <Col :xs=2 :sm=2 :lg=2>
                        <h2 class="rt-title">关于菠菜圈</h2>
                        <a target="_blank" href="/parts/about#about">关于我们</a>
                        <a target="_blank" href="/news/beAuthor#author">申请作者</a>
                        <a target="_blank" href="/parts/about#public">广告投放</a>
                        <a target="_blank" href="/parts/about#feedback">用户反馈</a>
                    </Col>
                    <Col :xs=3 :sm=3 :lg=3 style="padding-left: 30px;">
                        <h2 class="rt-title">关于博咨询</h2>
                        <a target="_blank" href="http://www.boniu365.com">博牛门户</a>
                        <a target="_blank" href="http://www.365zhaopin.co/">博招聘</a>
                        <a target="_blank" href="http://www.waimai.ph/">博牛外卖</a>
                        <a>
                            <img src="/static/weixin.png" alt="博牛外卖微信公众号">
                            <i class="wx-txt">关注微信公众号</i>
                        </a>
                    </Col>
                </Row>
            </Col>
        </Row>
        <Row :class-name="'copy-rt'" type="flex" justify="center" align="middle">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">Power By Betconsult &copy;2016-2020 Betconsut Consulting Inc</Col>
        </Row>
    </Row>
</template>
<script>
    import $ from 'jquery'
    export default {
        name: 'FooterArea',
        data() {
            return {

            }
        },
        methods: {
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
        },
        mounted(){
        }
    }
</script>

<style lang="scss" scoped>
    .container{
         width: 1200px;
     }
    #Footer {
        color: #fff;
        background: #2e3136;
        font-size: 14px;
        text-align: center;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
        .ad-position{
            img{
                width: 100%;
            }
        }
        .foot-box {
            text-align: left;
            padding: 10px 0 30px 0;
            border-top: 1px solid #3f4247;
            box-shadow: 0 0 1px 1px #121212;
            -webkit-box-shadow: 0 0 1px 1px #121212;
            -moz-box-shadow: 0 0 1px 1px #121212;
            -o-box-shadow: 0 0 1px 1px #121212;
            -ms-box-shadow: 0 0 1px 1px #121212;
            h2 {
                font-size: 16px;
                color: rgba(255,255,255,.8);
                font-weight: bold;
                margin: 30px 0 24px 0;
            }
            a {
                display: block;
                line-height: 1.2;
                padding: 5px 0;
                color: #8e8f93;
                margin-top: 6px;
                vertical-align: middle;
                cursor: pointer;
                &:hover, &:focus {
                    color: rgba(255,255,255,.8);
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    -ms-transition: all .5s;
                }
            }
            .wx-txt {
                display: block;
                font-size: 12px;
                color: #8e8f93;
                margin-top: 6px;
                font-style: normal;
                cursor: pointer;
                &:hover, &:focus {
                    color: rgba(255,255,255,.8);
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    -ms-transition: all .5s;
                }
            }
            .ct1 {
                img {
                    display: inline-block;
                    width: 46px;
                    height: 46px;
                    vertical-align: middle;
                }
                span {
                    display: inline-block;
                    padding: 5px;
                    vertical-align: middle;
                    b {
                        display: block;
                        font-size: 14px;
                        margin-bottom: 10px;
                    }
                    i {
                        font-size: 12px;
                        color: #8e8f93;
                        margin-top: 10px;
                        font-style: normal;
                    }
                }
            }
        }
        .copy-rt {
            background: #25292c;
            color: #ccc;
            font-size: 13px;
            line-height: 42px;
            text-align: center;
            border-top: 1px solid #3f4247;
            box-shadow: 0 0 1px 1px #121212;
            -webkit-box-shadow: 0 0 1px 1px #121212;
            -moz-box-shadow: 0 0 1px 1px #121212;
            -o-box-shadow: 0 0 1px 1px #121212;
            -ms-box-shadow: 0 0 1px 1px #121212;
        }
        .foot-box2 {
            padding: 30px 0 25px 0;
            .friend-title {
                padding-bottom: 15px;
                .rt-title {
                    font-size: 17px;
                    color: rgba(255,255,255,.8);
                    font-weight: bold;
                    text-align: left;
                }
                a {
                    text-align: right;
                    font-size: 14px;
                    color: #b3b5b4;
                    &:hover {
                        color: #fff;
                    }
                }
            }
            .friend-links {
                .friend-li {
                    padding: 5px 0;
                    text-align: left;
                    font-size: 16px;
                    color: #9c9d9f;
                    font-weight: 700;
                    margin: 5px 0;
                    a {
                        display: block;
                        line-height: 36px;
                        vertical-align: middle;
                        margin-right: 10px;
                        font-style: normal;
                        .partners {
                            display: block;
                            vertical-align: middle;
                            font-style: normal;
                        }
                        .ptn1 {
                            width: 102px; height: 36px;
                            background: url('/static/partner-logo.png') -170px -10px;
                        }
                        .ptn2 {
                            width: 78px; height: 36px;
                            background: url('/static/partner-logo.png') -10px -178px;
                        }
                        .ptn3 {
                            width: 100px; height: 36px;
                            background: url('/static/partner-logo.png') -170px -66px;
                        }
                        .ptn4 {
                            width: 102px; height: 36px;
                            background: url('/static/partner-logo.png') -10px -66px;
                        }
                        .ptn5 {
                            width: 78px; height: 36px;
                            background: url('/static/partner-logo.png') -108px -178px;
                        }
                        .ptn6 {
                            width: 100px; height: 36px;
                            background: url('/static/partner-logo.png') -10px -122px;
                        }
                        .ptn7 {
                            width: 80px; height: 36px;
                            background: url('/static/partner-logo.png') -130px -122px;
                        }
                        .ptn8 {
                            width: 140px; height: 36px;
                            background: url('/static/partner-logo.png') -10px -10px;
                        }
                        .ptn1:hover {
                            background: url('/static/friend-color.png') -132px -122px;
                        }
                        .ptn2:hover {
                            background: url('/static/friend-color.png') -10px -122px;
                        }
                        .ptn3:hover {
                            background: url('/static/friend-color.png') -8px -12px;
                        }
                        .ptn4:hover {
                            background: url('/static/friend-color.png') -10px -66px;
                        }
                        .ptn5:hover {
                            margin-top: -2px;
                            background: url('/static/partner-logo-hover.png') -108px -178px;
                        }
                        .ptn6:hover {
                            background: url('/static/friend-color.png') -132px -10px;
                        }
                        .ptn7:hover {
                            background: url('/static/friend-color.png') -132px -66px;
                        }
                        .ptn8:hover {
                            background: url('/static/partner-logo-hover.png') -10px -10px;
                        }
                        img {
                            display: inline-block;
                            width: 30px;
                            height: 27px;
                            vertical-align: middle;
                            margin-right: 3px;
                        }
                    }
                }
            }
        }
        .ft-img {
            display: inline-block;
            width: 45px;
            height: 45px;
            text-align: center;
            vertical-align: middle;
        }
        .ft-img.calc {
            background: url("/static/tool_icons.png") -10px -10px;
        }
        .ft-img.caipiao {
            background: url("/static/tool_icons.png") -75px -10px;
        }
        .ft-img.games {
            background: url("/static/tool_icons.png") -10px -75px;
        }
    }
</style>





























