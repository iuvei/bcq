<template>
	<Row id='pub'>
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>交易</BreadcrumbItem>
                    <BreadcrumbItem>免费发布信息</BreadcrumbItem>
                </Breadcrumb>
                <Row type="flex" :class-name="'listBox'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'tagList'">
                        <div @click="setOpt(1,'/trade/PubPlatform_daili')">
                            <Row type="flex" justify="center" align="middle" :class-name="'pubLi'" v-bind:class="{'act':tag == 1}">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="'tag-l'">
                                    <label class="radio"></label>
                                </Col>
                                <Col :xs="{'span':23}" :sm="{'span':23}" :lg="{'span':23}" :class-name="'tag-r'">
                                    <p class="f16">我是代理，我来登记代理信息</p>
                                    <p class="f14">代理信息填写的越全面越方便平台了解您，更加方便的建立信任感，合作的基础是建立在信任的基础上哦～</p>
                                </Col>
                            </Row>
                        </div>
                        <div @click="setOpt(2,'/trade/PubPlatform_pingtai')">
                            <Row type="flex" justify="center" align="middle" :class-name="'pubLi'" v-bind:class="{'act':tag == 2}">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="'tag-l'">
                                    <label class="radio"></label>
                                </Col>
                                <Col :xs="{'span':23}" :sm="{'span':23}" :lg="{'span':23}" :class-name="'tag-r'">
                                    <p class="f16">我是平台，我来发布招募信息</p>
                                    <p class="f14">招募信息中贵平台的简介以及平台的图片是取得代理们对您的第一印象，所以越详细越好哦～</p>
                                </Col>
                            </Row>
                        </div>
                        <div @click="setOpt(3,'/trade/PubBusiness_fwgys')">
                            <Row type="flex" justify="center" align="middle" :class-name="'pubLi'" v-bind:class="{'act':tag == 3}">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="'tag-l'">
                                    <label class="radio"></label>
                                </Col>
                                <Col :xs="{'span':23}" :sm="{'span':23}" :lg="{'span':23}" :class-name="'tag-r'">
                                    <p class="f16">我是服务供应商，我来发布供应信息</p>
                                    <p class="f14">作为服务提供商的您，可以发布系统接入、解决方案、支付方案、传媒推广、企业服务等信息，服务说明越全面越容易促进您的生意哦～</p>
                                </Col>
                            </Row>
                        </div>
                        <div @click="setOpt(4,'/trade/PubBusiness_qgxqf')">
                            <Row type="flex" justify="center" align="middle" :class-name="'pubLi'" v-bind:class="{'act':tag == 4}">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="'tag-l'">
                                    <label class="radio"></label>
                                </Col>
                                <Col :xs="{'span':23}" :sm="{'span':23}" :lg="{'span':23}" :class-name="'tag-r'">
                                    <p class="f16">我是求购需求方，我来发布信息让更多供应商找到我</p>
                                    <p class="f14">作为需求方的您，发布的求购信息越全面越好，这样才会吸引精准的服务供应商与您联系。</p>
                                </Col>
                            </Row>
                        </div>
                    </Col>
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                        <Row type="flex" justify="center" align="middle">
                            <Button class="submit-button" disabled v-if="flag">下一步</Button>
                            <Button class="submit-button next-button" @click="goto" v-else>下一步</Button>
                        </Row>
                    </Col>
                </Row>
            </Col>
		</Row>
		<FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>				
	</Row>
</template>

<script>
import PageRight from '../components/MainRight.vue';	
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import $ from 'jquery';
import lrz from 'lrz';
import Vue from 'vue';

export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar},
	mounted(){
		document.title = '菠菜圈| 免费发布信息';
	},
	data(){
		return {
		    tag: '',
            url: '',
            flag: true,
		}
	},
	methods: {
        setOpt(tag,url) {
            this.tag = tag;
            this.url = url;
            this.flag = false;
        },
        goto() {
            this.$router.push(this.url);
        }
	}
}
</script>
<style lang='scss' scoped>
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    #pub {
        .container {
            width:1200px;
            min-height:10rem;
            margin: 20px auto;
            .listBox {
                margin: 50px 0 30px 0;
                .tagList {
                    font-size: .28rem;
                    width: 80%;
                    margin: 0 auto;
                    .pubLi {
                        width: 950px;
                        background: #fbfbfb;
                        margin: 20px 0;
                        padding: 20px 10px 15px 20px;
                        &:hover {
                            background: #f2f2f2;
                            box-shadow: 1px 1px 5px 1px rgba(0,0,0,.3);
                        }
                        .tag-l{
                            .radio{
                                display: inline-block;
                                width: 20px;
                                height: 20px;
                                margin: 0 8px;
                                border: 1px solid #cacece;
                                border-radius: 50%;
                                text-align: center;
                                line-height: .28rem;
                            }
                        }
                        .tag-r{
                            padding: 0 15px;
                            line-height: 30px;
                            p {
                                color: #333;
                            }
                            .f16{
                                font-style: normal;
                                font-size: .33rem;
                                font-weight: bold;
                            }
                            .f14{
                                font-size: .26rem;
                                font-weight: normal;
                            }
                        }
                    }
                    .act{
                        .tag-l{
                            .radio{
                                border: 5px solid #28b28a;
                            }
                        }
                    }
                }
                .submit-button {
                    font-size: .34rem;
                }
                .next-button {
                    color: #FFFFFF;
                    background-color: #28b28a;
                }
            }
        }
    }
</style>