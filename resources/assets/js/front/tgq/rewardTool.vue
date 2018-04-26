<template>
    <div id="reward-tool">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">

                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>工具</BreadcrumbItem>
                    <BreadcrumbItem>彩票唯一官方开奖</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" justify="center" align="middle">
                    <Col :xs="{ span: 24}" :lg="{ span: 24}" align="middle" :class-name="'reward-list'">
                        <div class="tab-wrap clearfix">
                            <ul class="tabs">
                                <li class="active">时时彩</li>
                                <li>11选5</li>
                                <li>快3</li>
                                <li>福彩</li>
                                <li>体彩</li>
                                <li>六合彩</li>
                                <li>其他</li>
                            </ul>
                            <ul class="tab-content">
                                <li class="active">
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="cqssc">
                                                <span>重庆时时彩</span>
                                            </Radio>
                                            <Radio label="hljssc">
                                                <span>黑龙江时时彩</span>
                                            </Radio>
                                            <Radio label="tjssc">
                                                <span>天津时时彩</span>
                                            </Radio>
                                            <Radio label="xjssc">
                                                <span>新疆时时彩</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="sd11y">
                                                <span>山东11选5</span>
                                            </Radio>
                                            <Radio label="gd11y">
                                                <span>广东11选5</span>
                                            </Radio>
                                            <Radio label="jx11y">
                                                <span>江西11选5</span>
                                            </Radio>
                                            <Radio label="sh11y">
                                                <span>上海11选5</span>
                                            </Radio>
                                            <Radio label="ah11y">
                                                <span>安徽11选5</span>
                                            </Radio>
                                            <Radio label="js11y">
                                                <span>江苏11选5</span>
                                            </Radio>
                                            <Radio label="sx11y">
                                                <span>山西11选5</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="jsk3">
                                                <span>江苏快3</span>
                                            </Radio>
                                            <Radio label="ahk3">
                                                <span>安徽快3</span>
                                            </Radio>
                                            <Radio label="hbk3">
                                                <span>湖北快3</span>
                                            </Radio>
                                            <Radio label="hnk3">
                                                <span>河南快3</span>
                                            </Radio>
                                            <Radio label="gsk3">
                                                <span>甘肃快3</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="3d">
                                                <span>3D</span>
                                            </Radio>
                                            <Radio label="ssq">
                                                <span>双色球</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="p5">
                                                <span>排列五</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="lhc">
                                                <span>六合彩</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                                <li>
                                    <div class="lotteryNav">
                                        <RadioGroup v-model="actionType" class="common-radio">
                                            <Radio label="bjkl8">
                                                <span>北京快乐8</span>
                                            </Radio>
                                            <Radio label="bjpk10">
                                                <span>北京pk拾赛车</span>
                                            </Radio>
                                            <Radio label="ssl">
                                                <span>上海时时乐</span>
                                            </Radio>
                                        </RadioGroup>
                                    </div>
                                </li>
                            </ul>
                            <div class="lottery-list">
                                <div class="lt-search">
                                    <DatePicker :value="startTime" :options="option" @on-change="setStartTime" format="yyyy-MM-dd" type="date" placeholder="开始时间" style="width: 200px"></DatePicker>
                                    <span>至</span>
                                    <DatePicker :value="endTime" :options="option" @on-change="setEndTime" format="yyyy-MM-dd" type="date" placeholder="结束时间" style="width: 200px"></DatePicker>
                                    <input type="number" name="issue"  v-model="searchIssue" :placeholder="'请输入期号，如：'+issue" class="xx-input">
                                    <button class="lotterySearch pointer" @click="lotterySearch">搜索</button>
                                    <a href="http://www.gem-ds.com/index.html" target="_blank">
                                        <img src="/static/bskj.png" class="logo">
                                    </a>
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>时间</th>
                                            <th>期号</th>
                                            <th>开奖号码</th>
                                            <th>操作</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <template v-for="(lottery,index) in lotteryList">
                                            <tr :class="{search:lotteryId==lottery.id}">
                                                <td>{{lottery.open_time}}</td>
                                                <td>{{lottery.issue}}</td>
                                                <td>
                                                    <template v-for="(red,rindex) in lottery.red">
                                                        <span>{{red}}</span>
                                                    </template>
                                                    <template v-if="lottery.blue" v-for="(blue,bindex) in lottery.blue">
                                                        <span class="blue-ball">{{blue}}</span>
                                                    </template>
                                                </td>
                                                <td>
                                                    <a @click="show_img(lottery.image)" v-if="lottery.image">查看官方开奖图片</a>
                                                    <i v-else>暂无开奖图片(<a @click="refresh(lottery.issue,index)">刷新</a>)</i>
                                                </td>
                                            </tr>
                                        </template>
                                    </tbody>
                                </table>
                            </div>
                            <div class="lottery-page" v-show="pageFlag">
                                <Page :total="lotteryCount" :page-size="limit" @on-change="setPage" :class-name="'common-page'"></Page>
                            </div>
                        </div>
                    </Col>
                </Row>
            </Col>
        </Row>

        <Modal v-model="modal2" @on-cancel="cancel">
            <div style="text-align:center">
                <img :src="img" alt="官方开奖图片" style="width: 100%;max-width: 600px; margin-top: 30px;">
            </div>
            <div slot="footer">
            </div>
        </Modal>

        <FloatSideBar></FloatSideBar>
        <FooterArea></FooterArea>
    </div>
</template>

<script>
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';
    import $ from 'jquery';

    export default {
        components: {NavHeader,FooterArea,FloatSideBar},
        mounted(){
            document.title = '菠菜圈| 彩票唯一官方开奖';
            $('.ivu-modal .ivu-modal-footer').remove();
            var v = this;
            this.https.get('/api/front/lottery/render')
            .then((r)=>{
                v.lotteryList = r.data.lotteryList;
                v.endTime = r.data.endTime;
                v.startTime = r.data.startTime;
                v.issue = r.data.issue;
                v.limit = r.data.limit;
                v.lotteryCount = r.data.lotteryCount;
                v.lotteryId = 0;
                v.pageFlag = true;

                $(".ivu-page-prev").html('上一页').siblings(".ivu-page-next").html('下一页');
            })
            .catch((e)=>{
                console.log(e);
            });
        },
        data () {
            return {
                modal2: false,
                img: '',
                actionType: 'cqssc',
                lotteryList: [],
                page: 1,
                startTime: '',
                endTime: '',
                limit: 50,
                issue: '',
                searchIssue: '',
                lotteryId: 0,
                lotteryCount: 0,
                pageFlag: true,
                refreshFlag:true,
                option: {
                    disabledDate (date) {
                        return date && date.valueOf() > Date.now();
                    }
                },
            }
        },
        methods: {
            setPage(page){
                this.page = page;
                this.selectLottery();
            },
            selectLottery(){
                var v = this;
                this.https.post('/api/front/lottery/render', {
                    page: v.page,
                    actionType: v.actionType,
                })
                    .then((r)=>{
                        v.lotteryList = r.data.lotteryList;
                        v.endTime = r.data.endTime;
                        v.startTime = r.data.startTime;
                        v.limit = r.data.limit;
                        v.issue = r.data.issue;
                        v.lotteryCount = r.data.lotteryCount;
                        v.lotteryId = 0;
                        v.pageFlag = true;
                    })
                    .catch((e)=>{
                        console.log(e);
                    });
            },
            setStartTime(time){
                this.startTime = time;
            },
            setEndTime(time){
                this.endTime = time;
            },
            lotterySearch(){
                var v = this;
                this.https.post('/api/front/lottery/search', {
                    actionType: v.actionType,
                    startTime: v.startTime,
                    endTime: v.endTime,
                    searchIssue: v.searchIssue,
                })
                .then(function (response) {
                    v.lotteryList = response.data.lotteryList;
                    v.lotteryId = response.data.lotteryId;
                    v.pageFlag = false;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            refresh(issue,index){
                var v = this;
                if(v.refreshFlag){
                    v.refreshFlag = false;
                    this.https.get('/service/issue/'+v.actionType+'/'+issue)
                        .then(function (response) {
                            v.refreshFlag = true;
                            if (response.data.length){
                                v.$Message.success('图片刷新成功');
                                v.lotteryList[index].image = response.data;
                            }else{
                                v.$Message.warning('暂无开奖图片');
                            }
                        })
                        .catch(function (error) {
                            v.refreshFlag = true;
                            console.log(error);
                        });
                }
            },
            show_img(img){
                $("html").css('overflow-y','hidden');
                var v = this;
                v.img = img;
                v.modal2 = true;
            },
            cancel(){
                var v = this;
                v.img = '';
                $("html").css('overflow-y','scroll');
            }
    },
    watch: {
    actionType(){
                this.page = 1;
                this.selectLottery();
            },
        }
    }

</script>

<style lang="scss" scoped>
    label>.ivu-radio.ivu-radio-checked {
        margin-right: 0 !important;
    }
    .ivu-radio-wrapper {
        font-size: 14px !important;
        margin-right: 15px !important;
    }
    span.ivu-radio+* {
        /* margin-left: 2px; */
        margin-right: 10px !important;
    }

    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    ul,li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #reward-tool {
        .container {
            width:1200px;
            min-height: 10rem;
            margin: 20px auto;
        }
    }
    /* tab */
    .tab-wrap {
        width:100%;
        min-height: 630px;
        margin:0 auto;
    }
    .tabs {
        width: 100%;
        margin: 0 auto;
        margin-top: 20px;
        font-size: .25rem;
        display: flex;
        justify-content: space-between;
    }
    .tabs>li {
        width: 125px;
        height: 40px;
        margin-right: 35px;
        padding: 8px;
        line-height: 24px;
        color: #666;
        font-size: .28rem;
        text-align: center;
        border-radius: 3px;
        cursor: pointer;
        border: 1px solid #e0e0e0;
        &:last-child {
            margin-right: 0;
        }
        &:hover {
            border: 1px solid #28b28a;
        }
    }
    .tabs>.active {
        color: #fff;
        background: #28b28a;
        border-color: #28b28a;
    }
    .tabs>li:hover {
        border-color: #28b28a;
    }
    .tab-content {
        width: 100%;
        margin: 0 auto;
        height: 100%;
        overflow: auto;
        margin: 15px 0 0;
        text-align: center;
    }
    .lottery-list {
        width: 100%;
        height: 100%;
        overflow: auto;
        margin: 0 auto;
        margin-bottom: 100px;
    table {
            height: 100%;
            width: 1200px;
            color: #495060;
            font-size: .26rem;
            border-bottom: 1px solid #888;
            thead {
                padding-top: 20px;
                border-bottom: 1px solid #888;
                tr {
                    th {
                        height: 40px;
                        white-space: nowrap;
                        overflow: hidden;
                        color: #333;
                        font-size: .26rem;
                        font-weight: bold;
                        box-sizing: border-box;
                        text-align: center;
                        background: #fff;
                        text-overflow: ellipsis;
                        vertical-align: middle;
                    }
                }
            }
            tbody {
                min-height: 640px;
                overflow: auto;
                tr {
                    min-width: 0;
                    height: 48px;
                    box-sizing: border-box;
                    text-align: center;
                    text-overflow: ellipsis;
                    vertical-align: middle;
                    background: #fff;
                    transition: background-color .2s ease-in-out;
                    border-bottom: 1px solid #f2f2f2;
                    &:hover, &:focus {
                        background: #f2f2f2;
                    }
                    td {
                        span {
                            display: inline-block;
                            width: 28px;
                            height: 28px;
                            margin: 0 8px;
                            background: #f03e51;
                            border: 1px solid #f03e51;
                            border-radius: 50%;
                            text-align: center;
                            line-height: .28rem;
                            color: #fff;
                            font-size: .28rem;
                            padding: 6px;
                            cursor: pointer;
                        }
                        .red-ball {
                            background: #f03e51;
                            border: 1px solid #f03e51;
                            border-radius: 50%;
                        }
                        .blue-ball {
                            background: #0390e5;
                            border: 1px solid #0390e5;
                            border-radius: 50%;
                        }
                        a {
                            text-decoration: underline;
                            color: #666;
                            &.active, &:hover, &:focus {
                                color: #28b28a;
                            }
                        }
                    }
                }
                .search{
                    background-color: rgba(40,178,138,0.2);
                }
                @media \0screen\,screen\9 {
                    /* 只支持IE6、7、8 */
                    .search {
                        background-color: #28b28a;
                        filter: Alpha(opacity=20);
                        position: static; /* IE6、7、8只能设置position:static(默认属性) ，否则会导致子元素继承Alpha值 */
                        *zoom: 1; /* 激活IE6、7的haslayout属性，让它读懂Alpha */
                    }
                }
            }
        }
    }
    .lottery-page{
        width: 100%;
        text-align: center;
        margin: 50px;
    }
    .tab-content>li {
        display: none;
        color: #333;
        font-size: .28rem;
    }
    .tab-content>li.active {
        display:block;
    }
    .tab-content>li {
        .lotteryNav {
            width: 100%;
            margin: 0 auto;
            margin-bottom: 20px;
            padding: 15px 20px;
            background: #f2f2f2;
            text-align: left;
            p {
                display: inline-block;
                margin: 5px 20px;
            }
            input[type=radio] {
                margin-right: 10px;
            }
        }
    }
    .lt-search {
        padding: 15px 0 15px 0;
        .logo {
/*             content: url('/static/bskj.png'); */
            display: block;
            width: 100%;
            height: 100%;
            margin-top: 35px;
        }
        span {
            font-size: .25rem;
            padding: 0 18px;
        }
        input[type=number] {
            width: 320px;
            height: 32px;
            display: inline-block;
            line-height: 1.5;
            padding: 4px 7px;
            margin: 0 20px;
            font-size: .25rem;
            border: 1px solid #dddee1;
            border-radius: 4px;
            color: #495060;
            background-color: #fff;
            background-image: none;
            cursor: text;
            transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
            &:hover, &:focus {
                border-color: rgba(0,130,205,.5);
            }
            &::-webkit-input-placeholder {
                color: #c1c1c1;
                font-size: .2rem;
            }
            &::-moz-placeholder {
                color: #c1c1c1;
                font-size: .2rem;
            }
            &:-ms-input-placeholder {
                color: #c1c1c1;
                font-size: .2rem;
            }
            &:-moz-placeholder {
                color: #c1c1c1;
                font-size: .2rem;
            }
        }
        .lotterySearch {
            width: 180px;
            height: 32px;
            padding: 4px 7px;
            line-height: 1.5;
            text-align: center;
            font-size: .28rem;
            color: #fff;
            background: #28b28a;
            outline: none;
            border: 1px solid #28b28a;
            border-radius: 4px;
        }
    }
</style>