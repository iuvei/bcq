<template>
    <div id="upload">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资料上传/下载协议</BreadcrumbItem>
                </Breadcrumb>

                <div style="padding: 30px;">
                    <Card :bordered="false">
                        <p slot="title" style="text-align: center; font-size: 18px; color: #333; font-weight: bold;">
                            菠菜圈资料上传/下载协议
                        </p>
                        <p style="text-align: justify; font-size: 16px;">
                            <h2 style="text-align: center; font-size: 16px; color: #333; font-weight: bold;">用户信任声明：</h2><br>
                            产业资料下载，是菠菜圈（https://bcquan.com/）互联网平台下的一个项目功能，其立意良好、用意美善，在于给予博彩从业者或对博彩有兴趣、研究之使用者(以下称”用户”)交换资讯及分享资料的一个地方，而当用户提交同意 菠菜圈 资料上传协议 的同时，包括但不限于博牛社区、博招聘、多博社区等集团相关网站(以下称“本站”) 请您仔细阅读并同意以下条款。
                        </p>
                        <div class="content">
                            <h2>用户不得利用此功能或以任何方式传播、散播敏感信息和违反国家法律、政策的信息，包括但不限于下列信息：</h2>
                            <ul class="level1">
                                <li>1、危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；</li>
                                <li>2、煽动民族仇恨、民族歧视，破坏民族团结的；</li>
                                <li>3、破坏国家宗教政策，宣扬邪教和封建迷信的；</li>
                                <li>4、散布谣言，扰乱社会秩序，破坏社会稳定的；</li>
                                <li>5、散布暴力、凶杀、恐怖或者教唆犯罪的；</li>
                                <li>6、侮辱或者诽谤他人，侵害他人合法权益的；</li>
                                <li>7、恶意入侵他人终端机之木马程式；</li>
                                <li>8、有意图侵取他人财产之讯息。</li>
                                <li>
                                    如果用户提供的注册资料不准确，不真实，不合法，本站有权终止向该用户提供服务，并有权注销其帐号。因此产生的一切损失由用户自行承担。
                                </li>
                            </ul>

                            <h2>服务中止：</h2>
                            <b>由于本站网络服务的特殊性，用户同意本站有权随时变更、中断或终止部分或全部的网络服务。如变更、中断或终止的网络服务属于免费服务项目，本站无需提前通知用户，也无需对任何用户或任何第三方承担任何责任。一旦服务取消或终止，用户使用本服务的权利立即终止，且在本服务中储存的任何信息可能无法恢复。</b>

                            <h2>免责和不保证：</h2>
                            <b>
                                本站在任何情况下不对用户因使用或不能使用本站提供的服务所发生的特殊的、意外的、直接或间接的损失承担任何责任。
                                <br><br>
                                本站亦不对由非本站认可的第三方用户提供的服务或资讯、资料作任何明示或暗示的保证，也不保证服务是否会中断，以及其及时性、安全性。
                            </b>
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
            document.title = '菠菜圈| 资料上传/下载协议';
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
#upload {
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