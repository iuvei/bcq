<template>
    <div id="userAgreement">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>用户注册协议</BreadcrumbItem>
                </Breadcrumb>

                <div style="padding: 20px;">
                    <Card :bordered="false">
                        <p slot="title" style="text-align: center; font-size: 18px; color: #333; font-weight: bold;">
                            菠菜圈用户协议
                        </p>
                        <p style="text-align: center; font-size: 16px;">
                            欢迎您使用菠菜圈（bcquan）服务（下称：本服务），您在使用本服务前请认真阅读以下协议（下称：本协议）。
                        </p>
                        <div class="content">
                            <h2>一、菠菜圈使用协议的接受</h2>
                            <b>当您在注册程序过程中在“已阅读，同意本站《用户协议》”处打勾“√”并按照注册程序成功注册为菠菜圈网站用户，或您以其他本站允许的方式实际使用菠菜圈网站服务时，即表示您已充分阅读、理解并接受本协议的全部内容，并与菠菜圈达成用户协议。</b>

                            <h2>二、本协议的变更和修改</h2>
                            <b>菠菜圈有权随时对本协议进行修改，并且一旦发生协议条款的变动，菠菜圈将在相关页面上提示修改的内容；用户如果不同意本协议的修改，可以放弃使用或访问本网站或取消已经获得的服务；如果用户选择在本协议变更后继续访问或使用本网站，则视为用户已经接受本协议的修改。</b>

                            <h2>三、服务说明</h2>
                            <ul class="level1">
                                <li>1、菠菜圈是一个向广大用户提供信息资讯，供用户上传、分享资讯和商业服务的交流平台。</li>
                                <li>2、菠菜圈运用自己的系统通过互联网向用户提供服务，除非另有明确规定，增强或强化目前服务的任何新功能，包括新产品以及新增加的服务，均无条件地适用本协议。</li>
                            </ul>

                            <h2>四、用户行为</h2>
                            <b style="border-bottom: none;">用户需要实名认证完成账号注册，才能正常使用网站提供的服务。任何机构或个人注册和使用的互联网用户账号名称，必须符合《互联网用户账号名称管理规定》，用户必须承诺遵守法律法规、社会主义制度、国家利益、公民合法权益、公共秩序、社会道德风尚和信息真实性等七条底线。</b>
                            <ul class="level1">
                                <li>
                                    1、用户帐号、密码和安全：
                                    <ul class="level2">
                                        <li>
                                            （1）您在注册账号时必须通过实名认证，才能成为菠菜圈的合法用户，得到一个密码和账号。您可以利用该用户账号，合法正当地使用平台提供的各项服务功能。
                                        </li>
                                        <li>
                                            （2）用户须对在菠菜圈的注册信息的真实性、合法性、有效性承担全部责任，用户不得使用他人的名义发布任何信息；当被发现用户冒用他人或机构的名义恶意注册帐号，菠菜圈有权立即停止提供服务，收回其帐号并由该用户承担由此而产生的一切法律及其他责任。
                                        </li>
                                        <li>
                                            （3）您应采取合理措施维护其密码和帐号的安全。用户对利用该密码和帐号所进行的一切活动负全部责任；由该等活动所导致的任何损失或损害由用户承担，菠菜圈不承担任何责任。
                                        </li>
                                        <li>
                                            （4）用户的密码和帐号遭到未授权的使用或发生其他任何安全问题，用户可以立即通知菠菜圈，并且用户在每次连线结束，应结束帐号使用，否则用户可能得不到菠菜圈及所属公司的安全保护。
                                        </li>
                                        <li>
                                            （5）对于用户长时间未使用的帐号，菠菜圈有权予以关闭。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    2、用户发布内容的传播：
                                    <ul class="level2">
                                        <li>
                                            （1）您同意授权菠菜圈，有权通过本服务将您所上传的内容向全世界范围内不特定的网络用户展示。并授权菠菜圈以宣传为目的，在署名作者的前提下传播和使用您上传的内容。当任何第三方未经菠菜圈同意，转载、抓取、盗链包含用户内容在内的菠菜圈任何资料等行为时，用户同意并授权菠菜圈有权以菠菜圈的名义代表自己采取任何法律措施。
                                        </li>
                                        <li>
                                            （2）您理解并同意，您上传至菠菜圈的内容，若在上传过程中勾选了“禁止个人使用”，则未经您或菠菜圈的正式授权，任何个人或组织不得转载、保存或采集至任何第三方空间。若您在上传过程中勾选了“禁止匿名转载”，则任何个人及组织不得匿名转载您上传的内容至任何第三方空间。否则菠菜圈对前述行为有权要求第三方断开链接、删除并有权以菠菜圈的名义提起诉讼，以维护您的合法权益。
                                        </li>
                                        <li>
                                            （3）如果您通过本服务分享作品，则您保证：
                                            <ul class="level3">
                                                <li>
                                                    a. 您所分享的作品均由您本人原创或已经依法获得原始权利人合法授权。
                                                </li>
                                                <li>
                                                    b. 您有权授权菠菜圈依据本服务的相关规则使用您的作品，包括但不限于将您上传的图片向其他用户推荐或推广。
                                                </li>
                                                <li>
                                                    c. 您所上传的图片符合国家相关法律法规和公序良俗，不会损害任何他方的合法权益或造成不良社会影响。
                                                </li>
                                                <li>
                                                    d. 菠菜圈依照本服务的规则使用您的作品，无须另行获得第三方同意或对第三方承担任何责任。
                                                </li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    3、禁止用户从事以下行为：
                                    <ul class="level2">
                                        <li>
                                            （1）反对宪法所确定的基本原则的；
                                        </li>
                                        <li>
                                            （2）危害国家安全，泄露国家秘密，颠覆国家政权，破坏国家统一的；
                                        </li>
                                        <li>
                                            （3）损害国家荣誉和利益的；
                                        </li>
                                        <li>
                                            （4）煽动民族仇恨、民族歧视，破坏民族团结的；
                                        </li>
                                        <li>
                                            （5）破坏国家宗教政策，宣扬邪教和封建迷信的；
                                        </li>
                                        <li>
                                            （6）散布谣言，扰乱社会秩序，破坏社会稳定的；
                                        </li>
                                        <li>
                                            （7）散布淫秽、赌博、暴力、凶杀、自残、恐怖或者教唆犯罪的；
                                        </li>
                                        <li>
                                            （8）侮辱或者诽谤他人，侵害他人合法权益（如名誉权、肖像权等）的；
                                        </li>
                                        <li>
                                            （9）侵害他人知识产权、商业秘密等合法权利的；
                                        </li>
                                        <li>
                                            （10）虚构事实、隐瞒真相以误导、欺骗他人的；
                                        </li>
                                        <li>
                                            （11）发布、传送、传播广告信息及垃圾信息的；
                                        </li>
                                        <li>
                                            （12）其他法律法规禁止的行为。
                                        </li>
                                        <li>
                                            如果您上传、发布或传输的内容含有以上违反法律法规的信息或内容，或者侵犯任何第三方的合法权益，您将直接承担以上导致的一切不利后果。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    4、用户对经由本网站上载、张贴、发送电子邮件或传送的内容承担全部责任：
                                    <ul class="level2">
                                        <li>
                                            （1）对于用户经由菠菜圈传送的内容，菠菜圈不保证其合法性、正当性、准确性、完整性或品质。用户在接受本网站服务后，在任何情况下，菠菜圈均不对任何内容承担任何责任，包括但不限于任何内容发生任何错误或纰漏以及衍生的任何损失或损害。菠菜圈有权（但无义务）自行拒绝或删除经由本网站提供的任何内容。
                                        </li>
                                        <li>
                                            （2）菠菜圈有权利在下述情况下，对内容进行保存或披露：
                                            <ul class="level3">
                                                <li>a 法律程序所规定；</li>
                                                <li>b 本服使用协议规定；</li>
                                                <li>c 被侵害的第三人提出权利主张；</li>
                                                <li>d 为保护菠菜圈、其使用者及社会公众的权利、财产或人身安全；</li>
                                                <li>e 其他菠菜圈认为有必要的情况。</li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    5、对用户发布信息的存储和披露
                                    <p>菠菜圈不对用户所发布信息的删除或储存失败承担责任。菠菜圈有权判断用户的行为是否符合本协议规定，如果菠菜圈认为用户违背了协议条款规定，有终止向其提供网站服务的权利。</p>
                                </li>
                            </ul>

                            <h2>五、关于隐私</h2>
                            <ul class="level1">
                                <li>
                                    1、当您注册使用本服务时，需要自愿提供个人信息。在您的同意及确认下，菠菜圈将通过注册表格等形式要求您提供一些个人资料，您有权拒绝提供这些信息。
                                </li>
                                <li>
                                    2、在未经用户授权同意的情况下，菠菜圈不会公开、编辑或透露用户个人或企业信息，以下情况除外：
                                    <ul class="level2">
                                        <li>
                                            （1）根据执法单位之要求或为公共之目的向相关单位提供个人资料；
                                        </li>
                                        <li>
                                            （2）由于用户将用户密码告知他人或与他人共享注册帐户，由此导致的任何个人资料泄露；
                                        </li>
                                        <li>
                                            （3）由于黑客攻击、计算机病毒侵入或发作、因政府管制而造成的暂时性关闭等影响网络正常经营之不可抗力而造成的个人资料泄露、丢失、被盗用或被窜改等；
                                        </li>
                                        <li>
                                            （4）由于与本网站链接的其他网站所造成之个人资料泄露及由此而导致的任何法律争议和后果；
                                        </li>
                                        <li>
                                            （5）为免除访问者在生命、身体或财产方面之急迫危险；
                                        </li>
                                        <li>
                                            （6）为维护菠菜圈公司的合法权益。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    3、在以下（包括但不限于）几种情况下，菠菜圈有权搜集、使用用户的个人信息，收集信息是为了向您提供更好、更优、更个性化的服务：
                                    <ul class="level2">
                                        <li>
                                            （1）企业会员所提供的资料将会被本网站统计、汇总，本网站会不定期地通过企业会员留下的信息资料同该企业会员保持联系。
                                        </li>
                                        <li>
                                            （2）菠菜圈可以将用户信息与第三方数据匹配。
                                        </li>
                                        <li>
                                            （3）菠菜圈会通过透露合计用户统计数据向第三方描述菠菜圈的服务。
                                        </li>
                                        <li>
                                            （4）菠菜圈所提供的服务会自动收集有关访问者的信息，这些信息包括访问者人数、访问时间、访问页面、来访地址等，菠菜圈使用这些信息来对我们的服务器进行分析和对网站进行管理。
                                        </li>
                                        <li>
                                            （5）将遵循由中国广告协会互动网络分会颁布的《中国互联网定向广告用户信息保护框架标准》，基于合法、合理和诚实信用的法定原则妥善处理或使用用户的个人信息。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    4、cookie是一个标准的互联网技术，它可以使我们存储和获得用户登录信息。菠菜圈使用cookie 来确保您不会重复浏览到相同的内容并可以获得最新的信息，并确认您是菠菜圈的成员之一。我们并不使用cookie来跟踪任何个人信息。
                                </li>
                            </ul>

                            <h2>六、版权声明</h2>
                            <ul class="level1">
                                <li>
                                    1、菠菜圈会员所发布展示的“原创作品”、“原创文章”等原创内容，版权由作者享有和解释，任何商业用途均须联系原作者。临摹作品，同人作品原型版权归原作者所有。
                                </li>
                                <li>
                                    2、原创内容的发布者必须确保其拥有发布内容的全部原创版权，或已经获得版权所有者及相关法律的授权，且不得侵犯他人著作权，肖像权，商标权等，不违背商业保密协议。菠菜圈默认所有原创类的内容的发布者已经获得发表、演绎等版权授权。若因发布内容产生法律纠纷，全部责任在于用户本人，菠菜圈不承担任何法律责任。
                                </li>
                                <li>
                                    3、会员在菠菜圈上发布的内容，视作授权其作品使用在菠菜圈平台上，授予菠菜圈免费的、非独家使用许可，菠菜圈有权将该内容用于菠菜圈各种形态的产品和服务上，包括但不限于菠菜圈网站以及菠菜圈官方发布的适用于手持终端设备的应用或其他互联网产品。
                                </li>
                                <li>
                                    4、如果任何第三方侵犯了菠菜圈用户相关的权利，用户同意授权菠菜圈或其指定的代理人代表菠菜圈自身或用户对该第三方提出警告、投诉、发起行政执法、诉讼、进行上诉（但非义务），或谈判和解，并且用户同意在菠菜圈认为必要的情况下参与共同维权。
                                </li>
                                <li>
                                    5、在未得到著作权人的授权时，也请不要将他人的作品全部或部分复制发表到菠菜圈，如转载站外信息到菠菜圈请署名和注明出处；否则，用户应承担相应的不利后果，菠菜圈对此不承担任何责任。
                                </li>
                                <li>
                                    6、如个人或单位发现菠菜圈上存在侵犯其自身合法权益的内容，请及时与菠菜圈取得联系，并提供具有法律效应的证明材料，以便菠菜圈作出处理。菠菜圈有权（无义务）根据实际情况删除相关的内容，并追究相关用户的法律责任。给菠菜圈或任何第三方造成损失的，侵权用户应负全部责任。
                                </li>
                                <li>
                                    7、未经菠菜圈许可，任何人不得复制、转载、盗链、上载、下载、展示菠菜圈上的任何资源、；不得复制或仿造本站或者在非菠菜圈所属服务器上建立镜像。否则，菠菜圈将依法追究法律责任。
                                </li>
                                <li>
                                    8、菠菜圈的标识（包括但不限于bcquan，菠菜，bcquan.com等）、源代码、及所有页面的版式设计等，版权归菠菜圈所有。未经授权，不得用于除菠菜圈之外的任何站点。
                                </li>
                            </ul>

                            <h2>七、免责声明</h2>
                            <ul class="level1">
                                <li>
                                    1、除菠菜圈注明的服务条款外，其它因使用菠菜圈而导致任何意外、疏忽、合约毁坏、诽谤、版权或知识产权侵犯及其所造成的各种损失（包括因下载而感染电脑病毒），菠菜圈概不负责，亦不承担任何法律责任。
                                </li>
                                <li>
                                    2、菠菜圈不保证（包括但不限于）：
                                    <ul class="level2">
                                        <li>
                                            （1）本网站适合用户的使用要求；
                                        </li>
                                        <li>
                                            （2）本网站不受干扰，及时、安全、可靠或不出现错误；
                                        </li>
                                        <li>
                                            （3）用户经由本网站取得的任何产品、服务或其他材料符合用户的期望。
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    3、本服务可能会包含与其他网站或资源的链接，即第三方链接。菠菜圈对于前述网站或资源的内容、隐私政策和活动，无权控制、审查或修改，因而也不承担任何责任。建议您在离开菠菜圈服务，访问其他网站或资源前仔细阅读其服务条款和隐私政策。
                                </li>
                                <li>
                                    4、因用户内容在本网站的上载或发布，而导致任何第三方提出索赔要求或衍生的任何损害或损失，由用户承担全部责任，菠菜圈不承担任何责任。
                                </li>
                                <li>
                                    5、菠菜圈内会员所发言论仅代表网友自己，并不反映任何菠菜圈之意见及观点。
                                </li>
                                <li>
                                    6、菠菜圈认为，一切网民在进入菠菜圈主页及各层页面时已经仔细看过本条款并完全同意。
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
            document.title = '菠菜圈| 用户注册协议';
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
#userAgreement {
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