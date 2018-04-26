<template>
    <div id="hot-news" v-if="hot_news_list"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a @click="go('/news')"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row>
            <Col v-for="(item,key) in hot_news_list" :key="key">
                <Col :xs="24" :sm="24" :lg="24" v-if="key==0||key==1" :class-name="'news-frame'">
                    <a v-bind:href="'/news/newspage/'+item.id" target="_blank">
                        <div class='img-frame'>
                            <div class="frame-tab">
                                <img src="/static/hot_news_top1.png" v-if="key==0">
                                <img src="/static/hot_news_top2.png" v-if="key==1">
                            </div>
                            <img v-bind:src="item.image" onerror="this.src='/static/noimg.png'">
                            <a>
                                <div class="title-frame">
                                    <span>
                                        <p>
                                            <em>{{item.title}}</em>
                                        </p> 
                                    </span>
                                </div>
                            </a>
                        </div>
                    </a>
                </Col>
                <Col :xs="24" :sm="24" :lg="24" v-else :class-name="'news-frame2'">
                    <Col :xs="6" :sm="6" :lg="6">                  
                        <div class='img-frame2'>
                            <div class="frame-tab">
                                {{key+1}}
                            </div>                              
                            <img v-bind:src="item.image" onerror="this.src='/static/noimg.png'">
                        </div>
                    </Col>
                    <Col :xs="18" :sm="18" :lg="18" :class-name="'news-info'">
                        <div class="news-title"><a v-bind:href="'/news/newspage/'+item.id" target="_blank">{{item.title}}</a></div>
                        <div class="news-brief">{{item.brief}}</div>
                    </Col>
                </Col>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        props:['title'],
        data(){
            return {
                hot_news_list:''
            }
        },
        mounted(){
            this.get_list();
        },
        methods:{
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
            get_list(){
                var v = this;
                this.https.get('/front/components/get_hot_news').then((r)=>{
                    v.hot_news_list = r.data
                }).catch((e)=>{   
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>

#hot-news {
    margin-top: 35px;
    .news-frame {
        padding-bottom: 50px;
        .img-frame {
            width: 100%;
            height: 0;
            padding-bottom:55%;
            overflow: hidden;
            border-radius: 3px;
            border: 1px solid #f2f2f2;
            position: relative;
            z-index: 0;
            .frame-tab {
                position: absolute;
                top: 0;
                left: 15px;
                z-index: 1;
            }
            >a {
            .title-frame {
                position: absolute;
                width: 100%;
                left: 0;
                bottom:0;
                height: 60px;
                background: rgba(0,0,0,0.4);
                display: table;
                padding:0 10px 0 10px;
                >span {
                    color: white;
                    font-size: 14px;
                    display: table-cell;
                    text-align: center;
                    vertical-align: middle;
                        >p {
                            display: inline-block;
                            text-align: left;
                            em {
                                overflow: hidden;
                                text-overflow: ellipsis;
                                -o-text-overflow:ellipsis;
                                display: -webkit-box;
                                -webkit-line-clamp: 2;
                                -webkit-box-orient: vertical;
                            }
                        }
                    }
                }
            }
            >img{
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                transition-duration: .5s;
                cursor: pointer;
                border-radius: 4px;
                &:hover {
                    transform: scale(1.1);
                }
            }
        }
    }
    .news-frame2 {
        margin-top:15px;
        .img-frame2 {
            width: 100%;
            height: 0;
            padding-bottom:80%;
            overflow: hidden;
            border-radius: 3px;
            border: 1px solid #f2f2f2;
            position: relative;
            .frame-tab {
                background: rgba(0,0,0,0.4);
                position: absolute;
                left: 0;
                top: 0;
                width: 20px;
                height: 20px;
                font-size: 15px;
                color: white;
                font-weight: bold;
                text-align: center;
                border-radius: 3px;
                z-index: 1;
            }
            >img {
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                transition-duration: .5s;
                cursor: pointer;
                border-radius: 4px;
                &:hover {
                    transform: scale(1.1);
                }
            }
        }
        .news-info {
            padding:3px 0 3px 15px;
            .news-title{
                overflow: hidden;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                font-size: 14px;
                font-weight: bold;
                cursor: pointer;
                a{
                    color: #333;
                    &:hover{
                        color: #28b28a;
                    }
                }
            }
            .news-brief {
                padding-top: 5px;
                overflow: hidden;
                color: #b1b1b1;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }
        }
    }
}
</style>