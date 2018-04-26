<template>
    <div id="about">
        <NavHeader></NavHeader>
        <div class="banner">
            <div class="banner-animation animated fadeInUp">
                <img src="/static/logo-35.png" style="width: 274px; height: 84px;"/>
                <p>亚太菠菜产业第一领导者</p>
            </div>
        </div>
        <div id="about_us" class="about_us animated fadeInUp">
            <b></b>
            <div class="abs_intro">
                <h2>关于我们</h2>
                <h4>About us</h4>
                <p>
                    菠菜圈由业界知名公司高管及核心成员组成，旨在为所有菠菜产业人士提供
                    最新的产业新闻，最真实的代理招商、展会信息，最迅捷的供求商讯，最全
                    面的企业库、现金网黄页，最优秀的产业专题。
                </p>
            </div>
        </div>
        <div id="product" class="animated fadeInUp">
            <p class="cp-intro product">
                菠菜圈立志打造一个垂直的菠菜产业门户网站，专业服务菠菜产业人士，打通产业上下游，方便菠菜人士快速获取所需需求；打造一个开放的菠菜产业生态平台，去服务最众多的菠菜产业人士，去覆盖最广大的菠菜产业疆域。
                <br><br>
                让菠菜产业之间的交流更便捷，让菠菜相关信息的输出更高速，让菠菜产业信息的不透明、不对称等乱象都烟消云散，这一切，就是菠菜圈的初心。
                <span></span>
            </p>
        </div>
        <div id="culture" class="animated fadeInUp">
            <p class="cp-intro culture">
                菠菜圈隶属于博咨询旗下产品，皆是由资深博娛从业人士与咨询行业人士組成的博娱产业咨询公司。
                <br><br>
                博咨询团队始終抱著“以用戶为本”的心态“用心”智造；我們旨在智造产业游戏规则、汇集产业数据、抛悉产业方向、并最終具备为企业以及企业团队乃至产业把脉的能力。
                <br><br>
                我們將在相互尊重、相互理解和共同新人的基礎上，與您一起度過在公司工作的歲月。這種尊重、理解和新人是愉快地進行共同奮鬥的橋樑與紐帶。
                <span></span>
            </p>
        </div>
        <div id="public" class="animated fadeInUp">
            <p class="cp-intro public">
                100%垂直流量，100%精准人群。
                <br><br>
                我们是业界第一大媒介，集资讯、黄页、展会为一体。
                <br><br>
                我们是业界第一大交易集市，代理招募、产品分发、商业求购都可以在此完成。
                <br><br>
                我们是千锤百炼的知名品牌，安全、贴心。我们品牌影响覆盖两岸三地、东南亚之业界人群。
                <br><br>
                我们为你提供每一个有价值的精准流量，让你的广告投放实现利益最大化，有效提升您的营业额及品牌宣传。
                <span></span>
            </p>
        </div>
        <div id="advertise" class="animated fadeInUp">
            <div class="contact_us">
                <h2>联系我们</h2>
                <h4>Contact us</h4>
                <ul>
                    <li>广告投放Email：bcquan@betconsult.me</li>
                    <li>广告投放QQ：1927568670</li>
                    <li>广告投放Skype：julia_10252</li>
                </ul>
            </div>
        </div>
        <div id="feedback" class="animated fadeInUp">
            <Form :class-name="'contact_form'" ref="formValidate" :model="formValidate" :rules="ruleValidate" style="width: 620px;height: 500px;margin: 0 auto;padding-top: 50px;">
                <FormItem prop="title">
                    <Input :class-name="'msg-title'" v-model="formValidate.title" size="large" placeholder="请输入反馈意见标题" ></Input>
                </FormItem>
                <FormItem prop="content">
                    <Input v-model="formValidate.content" type="textarea" :autosize="{minRows: 10,maxRows: 12}" placeholder="请详细说明反馈的问题，以便我们可以理解更好的处理该问题" style="s"></Input>
                </FormItem>
                <FormItem style="margin-bottom: 0;">
                    <button type="button" class="submit-button" @click="handleSubmit('formValidate')">提交</button>
                </FormItem>
            </Form>
        </div>
        <FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>
    </div>
</template>

<script>
    import 'normalize.css/normalize.css';
    import '../../../css/reset.css';
    import 'animate.css';
    import $ from 'jquery';

    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';

    export default {
        data() {
            return {
                formValidate: {
                    title: '',
                    content: '',
                },
                ruleValidate: {
                    title: [
                        { required: true, message: '标题不能为空', trigger: 'blur' },
                        { type: 'string', max: 20, message: '标题不能大于20个字', trigger: 'blur' }
                    ],
                    content: [
                        { required: true, message: '详细说明不能为空', trigger: 'blur' },
                        { type: 'string', min: 20, message: '详细说明不能少于20个字', trigger: 'blur' },
                        { type: 'string', max: 100, message: '详细说明不能大于100个字', trigger: 'blur' },
                    ],
                }
            }
        },
        methods: {
            page_animate: $(document).ready(function () {
                setTimeout(function () {
                    $('.company_info>li').addClass('animated fadeInUp');
                },1000)
            }),
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        var v = this;
                        this.https.post('/front/feedback/add_feedback',{
                            title: v.formValidate.title,
                            content: v.formValidate.content,
                        }).then((r)=>{
                            if(r.data.code){
                                v.$Message.success(r.data.msg);
                                setTimeout(function () {
                                    v.$router.push(`/`);
                                },2000);
                            }else {
                                v.$Message.warning(r.data.msg);
                            }
                        }).catch(function (error) {
                            let replace = {
                                title: '标题',
                                content: '详细说明',
                            };
                            if (error.response.status == 422){
                                $.each(error.response.data.errors,function (index,val) {
                                    v.$Message.warning(val[0].replace(index,replace[index]));
                                })
                            }else {
                                v.$Message.warning('服务器错误!');
                            }
                        });
                    }
                })
            },
        },
        components: {NavHeader,FooterArea,FloatSideBar},
        mounted(){
            document.title = '菠菜圈| 关于我们';
        },
    }
</script>

<style lang="scss" scoped>
    html,body{
        height: 100%;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    #about {
        .banner {
            width: 100%;
            height: 430px;
            background: url("/static/ab-1.png") center center no-repeat;
            background-size: cover;
            background-color: #f7f7f7;
            position: relative;
            .banner-animation {
                position: absolute;
                top: 50%;
                left: 50%;
                margin-top: -72px;
                margin-left: 30px;
                p {
                    font-size: .6rem;
                    color: #fff;
                }
            }
        }
        .about_us {
            width: 100%;
            height: 594px;
            padding: 94px 0 112px 0;
            text-align: center;
            position: relative;
            b {
                display: block;
                width: 400px;
                height: 390px;
                background: #f2f2f2;
                margin: 0 auto;
            }
            .abs_intro {
                width: 580px;
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 1;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -50%);
                text-align: center;
                h2 {
                    font-size: 45px;
                    font-weight: bold;
                    color: #333;
                }
                h4 {
                    font-size: 30px;
                    font-weight: lighter;
                    color: #333;
                }
                p {
                    padding-top: .3rem;
                    font-size: 18px;
                    line-height: 2;
                    color: #444;
                    text-align: justify;
                }
            }
        }
        .cp-intro {
            width: 320px;
            font-size: .3rem;
            color: #666;
            line-height: 2;
            letter-spacing: 2px;
            text-align: justify;
            span {
                display: block;
                width: 162px;
                height: 6px;
                background: #efefef;
                margin-top: 14px;
            }
        }

        @media (max-width: 1920px) {
            .product, .public {
                position: absolute;
                top: 50%;
                left: 25%;
                z-index: 1;
                transform: translate(-50%, -40%);
                -webkit-transform: translate(-50%, -40%);
                -moz-transform: translate(-50%, -40%);
                -o-transform: translate(-50%, -40%);
            }
            .culture {
                position: absolute;
                top: 50%;
                right: 25%;
                z-index: 1;
                transform: translate(50%, -40%);
                -webkit-transform: translate(50%, -40%);
                -moz-transform: translate(50%, -40%);
                -o-transform: translate(50%, -40%);
            }
        }
        @media (max-width: 1440px) {
            .product, .public {
                position: absolute;
                top: 50%;
                left: 0;
                z-index: 1;
                transform: translate(30%, -40%);
                -webkit-transform: translate(30%, -40%);
                -moz-transform: translate(30%, -40%);
                -o-transform: translate(30%, -40%);
            }
            .culture {
                position: absolute;
                top: 50%;
                right: 0;
                z-index: 1;
                transform: translate(-30%, -40%);
                -webkit-transform: translate(-30%, -40%);
                -moz-transform: translate(-30%, -40%);
                -o-transform: translate(-30%, -40%);
            }
        }
        @media (max-width: 1366px) {
            .product, .public {
                position: absolute;
                top: 50%;
                left: 0;
                transform: translate(25%, -40%);
                -webkit-transform: translate(25%, -40%);
                -moz-transform: translate(25%, -40%);
                -o-transform: translate(25%, -40%);
            }
            .culture {
                position: absolute;
                top: 50%;
                right: 0;
                transform: translate(-25%, -40%);
                -webkit-transform: translate(-25%, -40%);
                -moz-transform: translate(-25%, -40%);
                -o-transform: translate(-25%, -40%);
            }
        }
        @media (max-width: 1024px) {
            .product, .public {
                position: absolute;
                top: 50%;
                left: 0;
                transform: translate(12%, -40%);
                -webkit-transform: translate(12%, -40%);
                -moz-transform: translate(12%, -40%);
                -o-transform: translate(12%, -40%);
            }
            .culture {
                position: absolute;
                top: 50%;
                right: 0;
                transform: translate(-12%, -40%);
                -webkit-transform: translate(-12%, -40%);
                -moz-transform: translate(-12%, -40%);
                -o-transform: translate(-12%, -40%);
            }
        }
        @media (max-width: 975px) {
            .product, .public {
                position: absolute;
                top: 50%;
                left: 0;
                z-index: 222;
                transform: translate(12%, -40%);
                -webkit-transform: translate(12%, -40%);
                -moz-transform: translate(12%, -40%);
                -o-transform: translate(12%, -40%);
            }
            .culture {
                position: absolute;
                top: 50%;
                right: 0;
                z-index: 222;
                transform: translate(-12%, -40%);
                -webkit-transform: translate(-12%, -40%);
                -moz-transform: translate(-12%, -40%);
                -o-transform: translate(-12%, -40%);
            }

        }

        #product {
            position: relative;
            width: 100%;
            height: 624px;
            background: url("/static/ab1.jpg") center center no-repeat;
            background-size: cover;
        }
        #culture {
            position: relative;
            width: 100%;
            height: 660px;
            background: url("/static/ab2.jpg") center center no-repeat;
            background-size: cover;
        }
        #public {
            position: relative;
            width: 100%;
            height: 662px;
            background: url("/static/ab3.jpg") center center no-repeat;
            background-size: cover;
        }
        #advertise {
            width: 100%;
            height: 400px;
            text-align: center;
            margin-bottom: 104px;
            position: relative;
            &::before {
                content: '';
                display: inline-block;
                width: 400px;
                height: 100%;
                background: #f2f2f2;
                position: absolute;
                top: 0;
                left: 50%;
                margin-left: -200px;
            }
            .contact_us {
                width: 580px;
                padding: 94px 0;
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                -webkit-transform: translate(-50%, -49%);
                -moz-transform: translate(-50%, -49%);
                -o-transform: translate(-50%, -49%);
                z-index: 5;
                h2 {
                    font-size: 45px;
                    font-weight: bold;
                    color: #333;
                }
                h4 {
                    font-size: 30px;
                    font-weight: lighter;
                    color: #333;
                }
                ul {
                    width: 580px;
                    margin: 0 auto;
                    text-align: left;
                    padding: 0 140px;
                    li {
                        padding: 10px 0;
                        font-size: 18px;
                        list-style-type: disc;
                    }
                }
            }
        }
        #feedback {
            width:100%;
            height: 100%;
            text-align: center;
            background: #f2f2f2;
        }
        .contact_form {
            width: 614px;
            margin:0 auto;
            padding: 50px 0 30px 0;
            text-align:center;
        }
        .contact_form>input[type="text"] {
            display: inline-block;
            width: 100%;
            height: 46px;
            font-size:14px;
            padding:5px 10px;
            margin-bottom: 25px;
            border: 1px solid #999;
            background: #fff;
            border-radius: 3px;
            &:hover, &:focus {
                color: #333;
            }
        }
        ::-webkit-input-placeholder { /* Chrome/Opera/Safari */
            color: #999;
        }
        ::-moz-placeholder { /* Firefox 19+ */
            color: #999;
        }
        :-ms-input-placeholder { /* IE 10+ */
            color: #999;
        }
        :-moz-placeholder { /* Firefox 18- */
            color: #999;
        }
        .contact_form>textarea {
            outline: none;
            border: 1px solid #999;
            border-radius: 3px;
            font-size: 14px;
            color: #666;
            width: 100%;
            padding: 10px;
            background-color: #fff;
            &:hover, &:focus {
                color: #333;
            }
        }
        .contact_form>input[type="submit"] {
            display:block;
            width: 170px;
            color: #fff;
            font-size: 16px;
            margin: 26px auto;
            padding: 8px 30px;
            outline: none;
            border-radius: 3px;
            border: 1px solid #28b28a;
            background-color: #28b28a;
            cursor: pointer;
            &:hover, &:focus {
                background: #149f77;
                border: 1px solid #149f77;
            }
        }
    }
</style>