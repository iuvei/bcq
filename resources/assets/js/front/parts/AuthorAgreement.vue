<template>
    <div id="authorAgreement">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>作者协议</BreadcrumbItem>
                </Breadcrumb>

                <div style="padding: 20px;">
                    <Card :bordered="false">
                        <p slot="title" style="text-align: center; font-size: 18px; color: #333; font-weight: bold;">
                            菠菜圈专栏作者申请要求及遵守条款
                        </p>
                        <p style="text-align: justify; font-size: 16px;">
                            菠菜圈（https://bcquan.com/）是博咨询集团下的互联网平台，菠菜圈认证作者是旨在履行一定义务的前提下，可以在菠菜圈平台享有各种权益的菠菜圈认证作者，包括但不限于获得更多曝光机会、植入广告于文章中、以及开设课程获得收益等。菠菜圈认证作者将与菠菜圈共同成长进步。
                            <br><br>
                            你可以是平台主、可以是卖支付接口的、可以是游戏开发商、也可以是行业媒体、更可以只是一个普通的一线工作人员，甚至可以是一个行业的旁观者；总之，我们都欢迎你。
                        </p>
                        <div class="content">
                            <h2>成为“菠菜圈”作者，可以获得什么？</h2>
                            <b>
                                成为作者后，您将拥有“菠菜圈”文章发布权限，在严格遵守 <a style="color: #478dce;">《菠菜圈作者条款》</a>的基础上可以发布任何有关产业的资讯及内容。您发布的内容一旦审核通过即可获得“菠菜圈”每日首页、专题、杂志推荐，与我们共享 <span style="color: #e4393c;">每日万级的产业精准流量</span>。
                                <br><br>
                                我们允许您在作者信息 <span style="color: #28b28a;">“个人介绍”</span>或<span style="color: #28b28a;">“文章正文”</span>中加入您的商业或广告信息、联系方式；并在文章内页及作者介绍页最显眼位置展示其，助您提升知名度及广告曝光，进而获得商业转化。
                                <br><br>
                                <img src="/static/zzxy1.png" alt="示例图1" style="display: block;width: 100%; height: 100%;">
                                <img src="/static/zzxy2.png" alt="示例图2" style="display: block;width: 100%; height: 100%;">
                                <br>
                                我们希望获得彼此共赢，因此我们对于您的广告展示永久不收取任何费用；即您坚持在这里每天写文章，我们就每天帮您免费打广告！！
                            </b>

                            <h2>我能写的范围有哪些？</h2>
                            <b>首先，这是最重要的一条！也是唯一一条。你写的内容一定要与“产业或从业者生存、产业发展”相关，否则，视为无效内容。<br>
                               首先，这是最重要的一条！也是唯一一条。你写的内容一定要与“产业或从业者生存、产业发展”相关，否则，视为无效内容。<br>
                               首先，这是最重要的一条！也是唯一一条。你写的内容一定要与“产业或从业者生存、产业发展”相关，否则，视为无效内容。<br>
                               （重要的事情说三遍）<br><br>
                                示例稿件：<br>
                                官方示例：<a href="http://bcquan.com/user/userzone/1574" target="_blank">新浪彩通官方主页</a> <br>
                                示例稿件1：<a href="http://bcquan.com/news/newspage/2545" target="_blank">彩票公益金，我国养老事业的重要力量！</a> <br>
                                示例稿件2：<a href="http://bcquan.com/news/newspage/2543" target="_blank">彩票行业上市公司动作频频，涉猎不同产业领域</a> <br>
                                示例稿件3：<a href="http://bcquan.com/news/newspage/2544" target="_blank">分析：我国离网彩解禁还远吗？</a> <br>
                            </b>

                            <h2>我有没有可能被撤除作者身份？</h2>
                            <b>
                                我们对菠菜圈作者的要求是，每月至少有5篇原创有效内容产出，如果您......<br>
                                1、每月未产出5篇有效内容 <br>
                                2、违反下列必要条款项目 <br>
                                3、身份伪造、涉嫌诈欺 <br>
                                则有可能会被撤除作者身份。
                            </b>

                            <h2>我还有哪些需要遵守的必要条款？</h2>
                            <p>当用户提交申请成为专栏作者的同时，包括但不限于博牛社区、博招聘、多博社区等集团相关网站(以下称“本站”) 请您仔细阅读并同意以下条款。凡在本站申请成为专栏作者并发表或上传作品的，应按照本站公布的相关规则进行申请、操作和使用。除非您已阅读并接受本协议所有条款，否则您无权成为菠菜圈认证作者。您申请成为菠菜圈认证作者即视为您已阅读并同意本协议的约束。</p>
                            <h2>一、菠菜圈使用协议的接受</h2>
                            <b>当您在申请成为作者的过程中在“已阅读，同意本站《认证作者申请要求及条件》”处打勾“√”并按照注册程序成功注册为菠菜圈网站用户，或您以其他本站允许的方式实际使用菠菜圈网站服务时，即表示您已充分阅读、理解并接受本协议的全部内容，并与菠菜圈达成作者协议。</b>
                            <h2>二、本协议的变更和修改</h2>
                            <b>菠菜圈有权随时对本协议进行修改，并且一旦发生协议条款的变动，菠菜圈将在相关页面上提示修改的内容；作者如果不同意本协议的修改，可以放弃使用或访问本网站或取消已经获得的服务；如果作者选择在本协议变更后继续访问或使用本网站，则视为该作者已经接受本协议的修改。</b>
                            <h2>三、认证作者申请要求及条件</h2>
                            <ul class="level1">
                                <li>1、凡符合共享知识精神，由作者本人创作的作品，均可在本站或发表或转载，并将被视为本站的“专栏作者”。</li>
                                <li>2、自身作品成熟，文章内容质量高。</li>
                                <li>3、在博彩领域内具有一定优势或经验者优先，如运营、营销、管理、行政、职场等各领域知识者。</li>
                                <li>4、具有明确的写作定位及未来写作计划，并且有长期、高频率在发文的计划。</li>
                                <li>5、明白透过稳定发布、长期坚持且有文章高质的知识共享，可以带来双赢效果。</li>
                                <li>6、凡在本站发表或转载的作品，根据作品授权的不同级别，其版权归作者所有或作者与菠菜圈共同享有。本站对经授权的作品享有在网络上刊登、转载、排版、宣传等权力。</li>
                                <li>7、本站一经核实作者作品属于非原创作品且造成纠纷的同时，将删除或停止用户使用权限。而此类作品所产生的一切后果责任由投稿人自负。</li>
                                <li>8、本站拒绝一切诸如违反社会公德、造成反动、或政治色彩强烈的作品，本站不予发表。</li>
                                <li>9、本站谢绝任何不符合菠菜圈发展方向的文章发布。</li>
                                <li>10、任何非本站相关工作人员或未征得原作者或本站同意，请不要转载本站作品内容，违者自负法律责任！如欲转载本站发表之原创作品，必须请作者或本站联系，并且在转载时应保留本站信息。</li>
                            </ul>

                            <h2>四、认证作者投稿</h2>
                            本站作者在发表、上传作品时，应遵守以下规定：
                            <ul class="level1">
                                <li>
                                    1、作品禁止包含下列内容：
                                    <ul class="level2">
                                        <li>
                                            （1）危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；
                                        </li>
                                        <li>
                                            （2）煽动民族仇恨、民族歧视，破坏民族团结的；
                                        </li>
                                        <li>
                                            （3）破坏国家宗教政策，宣扬邪教和封建迷信的；
                                        </li>
                                        <li>
                                            （4）散布谣言，扰乱社会秩序，破坏社会稳定的；
                                        </li>
                                        <li>
                                            （5）散布暴力、凶杀、恐怖或者教唆犯罪的；
                                        </li>
                                        <li>
                                            （6）侮辱或者诽谤他人，侵害他人合法权益的；
                                        </li>
                                        <li>
                                            如作者违反上述规定的，本站有权立即无条件删除该账号及其账号下发表的任何内容，不另行通知。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    2、作品内容要求：
                                    <ul class="level2">
                                        <li>
                                            （1）作品确系署名作者本人所创作，谢绝转载，严禁剽窃、抄袭，文责自负；
                                        </li>
                                        <li>
                                            （2）发表上传的作品如非产业新闻/动态，其馀本站尽可能要求专栏作者提供须为作者原创，谢绝转载。一经发现作者发表上传作品为转载他人作品，本站有权立即删除该账号及其发表的任何内容。作者转载行为的法律责任由其本人承担。
                                        </li>
                                        <li>
                                            （3）除特别规定外，本站作品在未经作者或本站同意的情况下，一律不得转载。
                                        </li>
                                        <li>
                                            您有责任自行备份存储相关作品稿件。如果您的服务被终止，菠菜圈平台可以从服务器上永久地删除您的数据。服务终止后，菠菜圈平台没有义务向您返还数据。
                                        </li>
                                    </ul>
                                </li>
                            </ul>

                            <h2>五、免责声明</h2>
                            <ul class="level1">
                                <li>
                                    1、菠菜圈有权限制有损害本站利益行为的作者在本站的一切活动。
                                </li>
                                <li>
                                    2、菠菜圈不保证收录作品稿件的安全性，请作者自行留存原稿。
                                </li>
                                <li>
                                    3、菠菜圈有权将上述作品推荐给合作伙伴宣传或转载，不另行告知。
                                </li>
                                <li>
                                    4、作者文责自负，任何作者及其发布内容的文字，不代表本站观点。
                                </li>
                            </ul>
                        </div>
                    </Card>
                </div>
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
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';

    export default {
        mounted(){
            document.title = '菠菜圈| 专栏作者协议';
        },
        data(){
            return {

            }
        },
        methods: {
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
        },
        components: {NavHeader,FooterArea,FloatSideBar}
    }
</script>

<style lang="scss" scoped>
    * {
        box-sizing: border-box;
    }
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    ul, li {
        list-style: none;
        margin: 0;
        padding: 0;
    }
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        background: #f0efe9;
    }
#authorAgreement {
    background: #f0efe9;
    .container{
        width: 1200px;
        margin: 20px auto;
        min-height: 8rem;
        .content {
            padding: 10px 15px 30px 15px;
            h2 {
                font-size: .3rem;
                font-weight: bold;
                color: #333;
                padding: 15px 0 10px 0;
            }
            b {
                display: block;
                font-weight: normal;
                font-size: .3rem;
                color: #666;
                padding: 10px 0 15px 0;
                border-bottom: 1px solid #efefef;
            }
            .level1 {
                padding-bottom: 15px;
                border-bottom: 1px solid #efefef;
                >li {
                    padding: 10px 0 0 0;
                    font-size: .3rem;
                    color: #666;
                }
            }
            .level2 {
                padding: 0 15px;
                >li {
                    padding: 10px 0 0 0;
                    font-size: .28rem;
                    color: #666;
                }
            }
            .level3 {
                padding: 0 0 0 20px;
                >li {
                    padding: 0 0 10px 0;
                    font-size: .28rem;
                    color: #888;
                }
            }
        }
    }
}
</style>