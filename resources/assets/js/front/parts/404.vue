<template>
    <div class="page">
        <Row type="flex" justify="center" align="middle">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <div class="error-page">
                    <img src="/static/404.jpg" alt="404 can not be found">
                    <p class="tip">诶哟，你的页面已偏离地球，去火星看看吧~</p>
                    <p class="button-group">
                        <a @click="go('/')" class="button">返回首页</a>
                    </p>
                </div>
            </Col>
        </Row>
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
            document.title = '菠菜圈| 404 not found';
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
html,body {

    font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
}
.page {
    background: #fff;
    height: 100%;
    .container {
        width: 1200px;
        height: 100%;
        text-align: center;
        margin:0px;
        .error-page {
            width: 800px;
            margin: 20px auto;
            text-align: center;
            img {
                width: 100%;
                height: 100%;
                vertical-align: middle;
            }
            p.tip {
                font-size: .35rem;
                color: #28b28a;
                font-weight: 400;
                text-align: center;
                margin: 30px 0 60px 0;
            }
            p.button-group {
                width: 400px;
                margin: 0 auto;
                display: flex;
                display: -webkit-flex;
                align-items: center;
                justify-content: center;
                a.button {
                    display: block;
                    width: 176px;
                    height: 38px;
                    font-size: .28rem;
                    line-height: .28rem;
                    text-align: center;
                    color: #28b28a;
                    background: #fff;
                    border: 1px solid #28b28a;
                    padding: 10px 15px;
                    outline: none;
                    border-radius: 3px;
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    -ms-transition: all .5s;
                    &:hover {
                        background: #28b28a;
                        color: #fff;
                    }
                }
            }
        }
    }
}
</style>