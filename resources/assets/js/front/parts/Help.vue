<template>
    <div id="help">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>帮助中心</BreadcrumbItem>
                </Breadcrumb>
                <Collapse :class="'accordion-panel'" v-model="value2" accordion>
                    <Panel name="1">
                        什么是菠菜种？可以干嘛？
                        <p slot="content">
                            菠菜种是可以在菠菜圈进行消费的虚拟货币。目前可以用来进行如下消费：
                            <ul class="order-list">
                                <li>在“数据报告”频道购买下载产业数据报告</li>
                                <li>在“产业资源下载”购买下载产业资源/资料</li>
                                <li>其他消费方式敬请期待</li>
                            </ul>
                        </p>
                    </Panel>
                    <Panel name="2">
                        如何获得菠菜种？
                        <p slot="content">
                            <Table border :columns="columns1" :data="data1" :stripe="true" :width="600"></Table>
                        </p>
                    </Panel>
                    <Panel name="3">
                        种子可以充值吗？
                        <p slot="content">暂时不考虑采用付费方式。</p>
                    </Panel>
                    <Panel name="4">
                        种子与人民币（RMB）抵扣使用比例？
                        <p slot="content">目前版本种子不能够折现</p>
                    </Panel>
                    <Panel name="5">
                        种子可以赠送提现吗？
                        <p slot="content">菠菜种子暂时不能赠送提现</p>
                    </Panel>

                </Collapse>
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
            document.title = '菠菜圈| 帮助中心';
        },
        data(){
            return {
                value2: '1',
              columns1: [
                {
                  title: '获得方式',
                  key: 'method'
                },
                {
                  title: '获得数量',
                  key: 'number'
                }
              ],
              data1: [
                {
                  method: '在“产业资源下载”区出售产业资源/资料',
                  number: '越多人下载，获得的菠菜种越多',
                },
                {
                  method: '在“问答区”回答产业问题',
                  number: '被采纳为最佳答案获得10菠菜种/每次',
                },
                {
                  method: '敬请期待更多获得方式',
                  number: '敬请期待更多获得方式',
                },
              ]
            }
        },
        methods: {

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
#help {
    height: 100%;
    background: #fff;
    .container {
        width: 1200px;
        margin: 20px auto;
        min-height: 8rem;
        .accordion-panel {
            font-size: .28rem;
            font-weight: 500;
            color: #333;
            p {
                font-size: .26rem;
                color: #666;
                font-weight: normal;
                padding-left: 25px;
            }
        }
        ul, li {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .order-list {
            li {
                padding: 8px 15px;
                color: #333;
                font-size: 14px;
                font-weight: 500;
                position: relative;
            }
            li::before {
                content: '';
                display: inline-block;
                width: 6px;
                height: 6px;
                position: absolute;
                left: 0;
                top: 50%;
                margin-top: -3px;
                border-radius: 50%;
                background: #28b28a;
                margin-right: 10px;
            }
        }
    }
}
</style>