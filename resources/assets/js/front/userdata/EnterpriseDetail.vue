<template>
    <div id="enterprise-detail">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<Row type="flex" justify="space-between">-->
                    <!--<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">-->
                        <!--<div class="bread">-->
                            <!--<div class="bread-text"><a href="/">首页</a>  > <a>资料</a> > <a>企业库</a> > <a>企业详情</a> </div>-->
                        <!--</div>-->
                    <!--</Col>-->
                <!--</Row>-->

                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资料</BreadcrumbItem>
                    <BreadcrumbItem to="/userdata/Enterprise">企业库</BreadcrumbItem>
                    <BreadcrumbItem>企业库详情</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" justify="space-around" :gutter="20" align="top" :class-name="'ents'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" style="margin-bottom:20px;">
                        <Row :class-name="'ent'" type="flex" align="middle">
                            <Col span="11" :class-name="'ent-l'">
                                <img :src="enterpriseDetails.logo" onerror="this.src='/static/noimg.png'">
                            </Col>
                            <Col span="13" :class-name="'ent-r'">
                                <h2>{{enterpriseDetails.title}} <img v-if="enterpriseDetails.famous" src="/static/enp-logo.png" class="Icon-crown"></h2>
                            <p>公司规模：<template v-for="(scale,key) in scaleList" v-if="scale.val == enterpriseDetails.scale">{{scale.name}}</template></p>
                            <p>公司地址：<template v-for="(region,key) in regionList" v-if="region.val == enterpriseDetails.region">{{region.name}}</template></p>
                            </Col>
                        </Row>
                        <Row :class-name="'ent-content'" type="flex" align="middle">
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" style="margin-bottom:20px;">
                                <h2>公司简介：</h2>
                                <div v-html="enterpriseDetails.content"></div>
                                <a v-if="enterpriseDetails.url" class="Icon-jumpTo" :href="enterpriseDetails.url" target="_blank">点此前往博招聘查看该公司在招职位</a>
                                <a v-else href="javascript:;" class="Icon-jumpNot">点此前往博招聘查看该公司在招职位</a>
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
    import Enterprise from './Enterprise.vue'
    import $ from 'jquery';

    export default{
        components: {NavHeader,FooterArea,FloatSideBar,Enterprise},
        mounted(){
            document.title = '菠菜圈| 企业库详情';
            var v = this;
            this.enterprise_id = this.$route.params.enterprise_id;
            this.https.get('/front/enterprise_details/render', {
                params: {
                    eid: v.enterprise_id
                }
            })
            .then((r)=>{
                if (r.data.enterpriseDetails instanceof Array && r.data.enterpriseDetails.length == 0){
                    v.$Message.warning('该信息不存在或已删除!');
                    setTimeout(function () {
                        v.$router.push('/userdata/Enterprise');
                    },2000)
                }
                v.enterpriseDetails = r.data.enterpriseDetails;
                v.scaleList = r.data.scaleList;
                v.regionList = r.data.regionList;
            })
            .catch((e)=>{
                console.log(e);
            });
        },
        data(){
            return {
                enterpriseDetails: '',
                scaleList: '',
                regionList: '',
            }
        },
    }
</script>

<style lang="scss" scoped>
    #enterprise-detail{
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
        .container {
            width: 1200px;
            margin: 20px auto;
            min-height: 10rem;
            .ents {
                margin-top: 30px;
                .ent {
                    width: 390px;
                    height: 140px;
                    border:1px dashed #e0e0e0;
                    border-radius: 5px;
                    .ent-l {
                        img {
                            width: 150px;
                            height: 98px;
                            background: #f2f2f2;
                        }
                    }
                    .ent-r {
                        h2 {
                            font-size: .28rem;
                            color: #333;
                            font-weight: 700;
                            line-height: 1;
                            padding: 0 0 5px 0;
                            img {
                                width: 30px;
                                height: 22px;
                                margin-left: 8px;
                                vertical-align: baseline;
                            }
                        }
                        p {
                            padding-top: 6px;
                            font-size: .24rem;
                            color: #666;
                        }
                    }
                }
                .ent-content {
                    border-top: 1px dashed #28b28a;
                    margin-top: 30px;
                    text-align: left;
                    h2 {
                        font-size: .28rem;
                        color: #333;
                        font-weight: 700;
                        line-height: 1;
                        padding: 20px 0 20px 0;
                    }
                    p {
                        padding: 15px;
                        font-size: .26rem;
                        color: #666;
                    }
                    .Icon-jumpTo {
                        margin: 20px auto;
                        display: block;
                        padding: 15px 40px;
                        text-align: center;
                        background: #28a28b;
                        color: #fff;
                        font-size: .28rem;
                        border-radius: 5px;
                        &:hover {
                            background: #149f77;
                        }
                    }
                    .Icon-jumpNot {
                        margin: 20px auto;
                        display: block;
                        padding: 15px 40px;
                        text-align: center;
                        background: #bbbec4;
                        color: #495060;
                        font-size: .28rem;
                        border-radius: 5px;
                        &:hover {
                             cursor: not-allowed;
                         }
                    }
                }
            }
        }
    }
</style>