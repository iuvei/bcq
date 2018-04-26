<template>
    <div id="hours-left">
        <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
            <BreadcrumbItem to="/">首页</BreadcrumbItem>
            <BreadcrumbItem>7*24小时快讯</BreadcrumbItem>
        </Breadcrumb>
        <Row>
            <Col v-if="top" :class-name="'top'">
                <ul>
                    <div class="trend-date">
                        您的<br>
                        关注
                    </div>
                    <li>
                        <div class="img-zone">
                            <div class="img-frame">
                                <img v-bind:src="top.image" onerror="this.src='/static/noimg.png'">
                            </div>   
                        </div>                    
                        <div class="content-zone">
                            <h2 class="hours-title">{{top.title}}</h2>
                            <div class="hours-content">
                                <p>
                                    {{top.brief}}<a :href="top.url" target="_blank">[原文链接]</a>
                                </p>
                                <p class="share">
                                    <span class="pub-time">{{top.date}}</span>
                                    <ShareBtn></ShareBtn>
                                </p>
                            </div>
                        </div>
                    </li>
                </ul>                
            </Col>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'hours-list'">
                <ul v-for="(time,index) in dateList" :key="index">
                    <div class="trend-date">
                        <div class='trend-date-month'>{{time.split('-')[1]}}月</div>
                        <div class='trend-date-day'>{{time.split('-')[2]}}</div>
                    </div>
                    <li v-for="(val,key) in flashList" :key="key" v-if="val.time == time">
                        <h2 class="hours-title">{{val.title}}</h2>
                        <div class="hours-content">
                            <p>
                                {{val.brief}}<a :href="val.url" target="_blank">[原文链接]</a>
                            </p>
                            <p class="share">
                                <span class="pub-time">{{val.date}}</span>
                                <ShareBtn></ShareBtn>
                            </p>
                        </div>
                    </li>
                </ul>
                <div v-if="!loading">
                    <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                    <center>
                        <Button :class="'load-more'" @click="get_more"  v-if="more">浏览更多</Button>
                    </center>
                    </Col>
                </div>
            </Col>
        </Row>
    </div>
</template>


<script>
    import ShareBtn from '../components/shareBtn.vue';
    import $ from 'jquery';

    export default {
        components: {ShareBtn},
        mounted(){
            document.title = '菠菜圈| 7*24小时快讯';
            var v = this;
            var id = v.$route.query.id?v.$route.query.id:''
            this.https.get('/front/flash/render',{
                params:{
                    id:id
                }
            }).then((r)=>{
                v.top = r.data.top
                $.each(r.data.flashList,function (key,val) {
                    v.dateList.push(key);
                    v.flashList = v.flashList.concat(val);
                });
                v.loading = false;
            }).catch((e)=>{
                console.log(e);
            });
        },
        data() {
            return {
                flashList: [],
                dateList: [],
                loading: true,
                page:1,
                more:true,
                top:''
            }
        },
        methods:{
            get_more(){
                var v = this;
                this.https.get('/front/flash/render',{
                    params:{
                        page:v.page,
                    }
                }).then((r)=>{
                    if (!$.isEmptyObject(r.data.flashList)) {
                        $.each(r.data.flashList,function (key,val) {
                            v.dateList.push(key);
                            v.flashList = v.flashList.concat(val);
                        });
                        v.dateList = v.dateList.filter(function (element, index, self) {
                            return self.indexOf(element) === index;
                        });
                        v.page = v.page + 1;
                    }else{
                        v.more = false;
                        v.$Message.warning('已无更多数据');
                    }
                }).catch((e)=>{
                    console.log(e);
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    #hours-left {
        min-height: 10rem;
        .top{
            .img-zone{
                display: inline-block;
                width: 25%;
                vertical-align: middle;
                .img-frame{
                    width: 100%;
                    height: 0;
                    padding-bottom: 62.5%;
                    overflow: hidden;
                    border-radius: 3px;
                    position: relative;
                    img{
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                    }
                }
            }
            .content-zone{
                display: inline-block;
                width: 74%;
                vertical-align: middle;
                padding-left: 20px;
            }
            >ul {
                padding-left: 66px;
                position: relative;
                .trend-date {
                    color: #fff;
                    position: absolute;
                    font-weight: bolder;
                    top: 0;
                    left: 0;
                    width: 46px;
                    height: 56px;
                    background-color: #28b28a;
                    text-align: center;
                    padding-top: 10px;
                }                
                li {
                    padding: 10px 15px 15px 15px;
                    border-bottom: 1px dashed #f2f2f2;
                    &:hover {
                        background: #f2f2f2;
                    }
                    .hours-title {
                        font-size: 16px;
                        color: #333;
                        font-weight: bold;
                        padding: 10px 0 10px 0;
                    }
                    .hours-content {
                        p {
                            font-size: 14px;
                            color: #888;
                            margin-bottom: 10px;
                        }
                        p:first-child>a {
                            margin-left: 10px;
                            font-size: 14px;
                            color: #28b28a;
                            &:hover {
                                color: #149f77;
                            }
                        }
                        .share {
                            line-height: 30px;
                            padding: 5px 0 0 0;
                            position: relative;
                            .pub-time {
                                position: absolute;
                                top: 5px;
                                left: 0;
                                z-index: 0;
                                min-width: 100px;
                                height: 30px;
                                font-size: 14px;
                                color: #999;
                            }
                        }
                    }
                }
            }            
        }
        .hours-list {
            ul, li {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            >ul {
                padding-left: 66px;
                position: relative;
                li {
                    padding: 10px 15px 15px 15px;
                    border-bottom: 1px dashed #f2f2f2;
                    &:hover {
                        background: #f2f2f2;
                    }
                    .hours-title {
                        font-size: 16px;
                        color: #333;
                        font-weight: bold;
                        padding: 10px 0 10px 0;
                    }
                    .hours-content {
                        p {
                            font-size: 14px;
                            color: #888;
                            margin-bottom: 10px;
                        }
                        p:first-child>a {
                            margin-left: 10px;
                            font-size: 14px;
                            color: #28b28a;
                            &:hover {
                                color: #149f77;
                            }
                        }
                        .share {
                            line-height: 30px;
                            padding: 5px 0 0 0;
                            position: relative;
                            .pub-time {
                                position: absolute;
                                top: 5px;
                                left: 0;
                                z-index: 0;
                                min-width: 100px;
                                height: 30px;
                                font-size: 14px;
                                color: #999;
                            }
                        }
                    }
                }
            }
        }
        .trend-date {
            position: absolute;
            top: 0;
            left: 0;
            width: 46px;
            height: 56px;
            background-color: #28b28a;
            text-align: center;
            padding-top: 5px;
            padding-bottom: 5px;
            .trend-date-month{
                font-size: 12px;
                color: #fff;
            }
            .trend-date-day {
                font-size: 18px;
                color: #fff;
            }
        }
        .load-more {
            margin-bottom: 30px;
        }
    }
</style>