<template>
    <div class="page">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资讯</BreadcrumbItem>
                    <BreadcrumbItem to="/parts/exbition">行业展会</BreadcrumbItem>
                    <BreadcrumbItem>展会详情</BreadcrumbItem>
                </Breadcrumb>
                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                        <ul class="dropdown">
                            <li class="zh-info">
                                <a class="imgCove">
                                    <img :src="exhibitionDetails.image" onerror="this.src='/static/noimg.png'">
                                </a>
                                <div class="zh-details">
                                    <h2>{{exhibitionDetails.title}}</h2>
                                    <P>主办方：{{exhibitionDetails.sponsor}} </P>
                                    <P>展会日期：{{exhibitionDetails.starttime}}~{{exhibitionDetails.endtime}} </P>
                                    <P>展会地址：{{exhibitionDetails.address}} </P>
                                    <P>官方网站：{{exhibitionDetails.url}} </P>
                                </div>
                            </li>
                        </ul>
                        <p class="zh-intro">
                            {{exhibitionDetails.content}}
                        </p>
                        <ul class="zh-list">
                            <li v-for="(news,index) in exhibition_news"><a :href="'/news/newspage/'+news.nid" target="_blank">{{news.title}}</a><span>{{news.time}}</span></li>
                        </ul>
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
                                <Button :class="'load-more'" @click="get_more" v-if="more_news">浏览更多</Button>
                            </center>
                            </Col>
                        </Row>
                    </Col>

                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'home-right'">
                        <MainRight :page-id="page_id" :class-name="'page-right'"></MainRight>
                    </Col>
                </Row>
            </Col>
        </Row>
        <FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>
    </div>
</template>

<script>
    import 'normalize.css/normalize.css';
    import '../../../css/reset.css';
    import '../../../css/reset_alex.scss';
    import $ from 'jquery';
    import MainRight from '../components/MainRight.vue';
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';

    export default {
        mounted(){
            document.title = '菠菜圈| 展会详情';
            var v = this;
            this.eid = this.$route.params.eid;
            this.https.get('/front/exhibition_details/render',{
                params: {
                    eid: v.eid
                }
            }).then((r)=>{
                v.adList = r.data.adList;
                v.exhibitionDetails = r.data.exhibitionDetails;
                v.exhibition_news = r.data.exhibition_news;
            }).catch((e)=>{
                console.log(e)
            });
        },
        data(){
            return {
                page_id :22,
                eid :'',
                adList : [],
                exhibitionDetails : {},
                exhibition_news : [],
                page:1,
                loading:false,
                more_news:true
            }
        },
        methods: {
            get_more(){
                this.loading = true;
                var v = this;
                this.https.get('/front/exhibition_details/get_exhibition_news',{
                    params:{
                        page : v.page,
                        eid: v.eid
                    }
                }).then((r)=>{
                    v.loading = false;
                    v.page = v.page + 1;
                    if (r.data.exhibition_news.length>0) {
                        v.exhibition_news = v.exhibition_news.concat(r.data.exhibition_news);
                    }else{
                        v.more_news = false;
                        v.$Message.warning('已无更多数据');
                    }
                }).catch((e)=>{
                    console.log(e)
                });
            }
        },
        components: {MainRight,NavHeader,FooterArea,FloatSideBar}
    }
</script>

<style lang="scss" scoped>
    html,body{
        height: 100%;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .page {
        background: #fff;
        .container{
            min-height: 10rem;
            width: 1200px;
            margin: 20px auto;
            ul, li {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            .dropdown {
                width: 100%;
                text-align: left;
                background: #fff;
                margin: 0 0 30px 0;
                li.zh-info {
                    display: block;
                    text-align: left;
                    line-height: 1;
                    padding: 15px 0;
                    &:after {
                        content: '';
                        display: block;
                        clear: both;
                    }
                    .zh-details {
                        float: left;
                        text-align: left;
                        h2 {
                            text-align: left;
                            font-size: 20px;
                            font-weight: 700;
                            color: #333;
                            padding: 10px 0 15px 0;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                        p {
                            text-align: left;
                            color: #333;
                            font-size: 14px;
                            padding: 6px 0;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    }
                    >a.imgCove {
                        float: left;
                        width: 228px;
                        height: 142px;
                        border-radius: 3px;
                        margin-right: .25rem;
                        border: 1px solid #f2f2f2;
                        display: inline-block;
                        overflow: hidden;
                        text-align: center;
                        line-height: 112px;
                        vertical-align: middle;
                        position: relative;
                        color: #fff;
                        padding-left: 0;
                        padding-right: 0;
                        >img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            cursor: pointer;
                            outline: none;
                            transition: all .5s;
                            -webkit-transition: all .5s;
                            -moz-transition: all .5s;
                            -o-transition: all .5s;
                            -ms-transition: all .5s;
                        }
                    }
                }
            }
            .zh-intro {
                width:100%;
                font-size: 16px;
                padding: 34px 28px;
                color: #333;
                background: #f5f5f5;
                text-align: justify;
                border: 1px solid #efefef;
            }
            .zh-list {
                margin-top: 42px;
                li {
                    padding: 0 12px 18px 12px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    position: relative;
                    &::before {
                        content: '';
                        display: inline-block;
                        width: 4px;
                        height: 4px;
                        border-radius: 50%;
                        background: #28b28a;
                        position: absolute;
                        left: 10px;
                        z-index: 2;
                    }
                    a {
                        padding-left: 10px;
                        text-align: left;
                        color: #666;
                        font-size: 16px;
                        cursor: pointer;
                        transition: color .3s;
                        -webkit-transition: color .3s;
                        -moz-transition: color .3s;
                        -o-transition: color .3s;
                        &:hover {
                            color: #28b28a;
                        }
                    }
                    span {
                        text-align: right;
                        color: #999;
                        font-size: 14px;
                    }
                }

            }
            .home-right{
                .right-frame{
                    display: block;
                }
                .page-right{
                    margin-top: 1rem;
                }
            }
        }
    }
</style>