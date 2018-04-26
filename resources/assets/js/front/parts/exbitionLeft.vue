<template>
    <div id="hours-left">
        <Row>
            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'hours-list'">
                <ul class="dropdown">
                    <li class="zh-info" v-for="(exhibition,index) in exhibitionList">
                        <a class="imgCove" :href="'/parts/ExbitionDetail/'+exhibition.id" target="_blank">
                            <img :src="exhibition.image" onerror="this.src='/static/noimg.png'" :title="exhibition.title">
                        </a>
                        <div class="zh-details">
                            <a class="imgCove" :href="'/parts/ExbitionDetail/'+exhibition.id" target="_blank">
                                <h2>{{exhibition.title}}</h2>
                            </a>
                            <P>主办方：{{exhibition.sponsor}} </P>
                            <P>展会日期：{{exhibition.starttime}}~{{exhibition.endtime}} </P>
                            <P>展会地址：{{exhibition.address}} </P>
                            <P>官方网站：{{exhibition.url}} </P>
                        </div>
                    </li>
                </ul>
                <Row v-if="loading">
                    <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                    <Spin fix>
                        <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
                        <div>Loading</div>
                    </Spin>
                    </Col>
                </Row>
                <Row>
                    <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                    <center>
                        <Button :class="'load-more'" @click="get_more" v-if="more_exhibition">浏览更多</Button>
                    </center>
                    </Col>
                </Row>
            </Col>
        </Row>
    </div>
</template>


<script>

    export default {
        data() {
            return {
                page:1,
                loading:true,
                exhibitionList:[],
                more_exhibition:true,
            }
        },
        mounted() {
            document.title = '菠菜圈| 更多展会';
            var v = this;
            this.https.get('/front/exhibition/render').then((r)=>{
                v.exhibitionList = r.data.exhibitionList;
                v.loading = false;
            }).catch((e)=>{
                console.log(e);
            });
        },
        methods: {
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
            get_more(){
                this.loading = true;
                var v = this;
                this.https.get('/front/exhibition/get_exhibition_list',{
                    params:{
                        page : v.page
                    }
                }).then((r)=>{
                    v.loading = false;
                    v.page = v.page + 1;
                    if (r.data.length>0) {
                        v.exhibitionList = v.exhibitionList.concat(r.data);
                    }else{
                        v.more_exhibition = false;
                        v.$Message.warning('已无更多数据');
                    }
                }).catch((e)=>{
                    console.log(e)
                });
            }
        },
    }
</script>

<style lang="scss" scoped>
    .load-more {
        margin-top: 0;
        margin-bottom: 30px;
    }
    #hours-left {
        min-height: 10rem;
        .hours-list {
            ul, li {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            ul.dropdown {
                width: 100%;
                text-align: left;
                background: #fff;
                margin: 0 0 30px 0;
                li.zh-info {
                    display: block;
                    border-bottom: 1px solid #f2f2f2;
                    text-align: left;
                    line-height: 1;
                    padding: 15px 0;
                    &:after {
                        content: '';
                        display: block;
                        clear: both;
                    }
                    .zh-details {
                        float: left;
                        text-align: left;
                        h2 {
                            cursor: pointer;
                            text-align: left;
                            font-size: 20px;
                            font-weight: 700;
                            color: #333;
                            padding: 10px 0 15px 0;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            -webkit-text-overflow: ellipsis;
                            -o-text-overflow: ellipsis;
                            -moz-text-overflow: ellipsis;
                            &:hover {
                                color: #28b28a;
                            }
                        }
                        p {
                            text-align: left;
                            color: #333;
                            font-size: 14px;
                            padding: 6px 0;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    }
                    >a.imgCove {
                        float: left;
                        width: 228px;
                        height: 142px;
                        border-radius: 3px;
                        margin-right: .25rem;
                        border: 1px solid #f2f2f2;
                        display: inline-block;
                        overflow: hidden;
                        text-align: center;
                        line-height: 112px;
                        vertical-align: middle;
                        position: relative;
                        color: #fff;
                        padding-left: 0;
                        padding-right: 0;
                        &:hover img, &:focus img {
                            transform: scale(1.1);
                            -webkit-transform: scale(1.1);
                            -moz-transform: scale(1.1);
                            -o-transform: scale(1.1);
                            -ms-transform: scale(1.1);
                        }
                        >img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            cursor: pointer;
                            outline: none;
                            transition: all .5s;
                            -webkit-transition: all .5s;
                            -moz-transition: all .5s;
                            -o-transition: all .5s;
                            -ms-transition: all .5s;
                        }
                        >div {
                            position: absolute;
                            bottom: 0;
                            left: 0;
                            width: 100%;
                            height: 40px;
                            color: #fff;
                            font-size: .27rem;
                            font-weight: bold;
                            text-align: center;
                            line-height: 40px;
                            padding: 0 8px;
                            background: rgba(0,0,0,.45);
                            cursor: pointer;
                            &:hover {
                                color: #28b28a;
                            }
                        }
                    }
                }
            }
        }
    }
</style>