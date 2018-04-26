<template>
    <div id="MainLeft">
        <div class="first-banner" v-if="!user_info">
            <Carousel loop v-model= "carousel.index" autoplay :autoplay-speed="carousel.autoplay_speed" :trigger="carousel.trigger" :arrow="carousel.arrow" :radius-dot="carousel.radius_dot">
                <CarouselItem v-for="(slide,index) in slideList" :key="index">
                    <a :href="slide.url" target="_blank">
                        <div class="carousel-content">
                            <img :src="slide.image" onerror="this.src='/static/noimg.png'">
                            <div class="carousel-title">{{slide.title}}</div>
                        </div>
                    </a>
                </CarouselItem>
            </Carousel>
        </div>
        <div v-else class="publish-zone">
            <Publish v-on:pubmicro="pubmicro"></Publish>
        </div>    
        <div>
            <slot name = "ad1">

            </slot>
        </div>
        <Falls ref="Falls"></Falls>
    </div>
</template>

<script>
    import '../../../css/icons.css'
    import Falls from './Falls'
    import Publish from './Publish'
    export default {
        name: 'MainLeft',
        components: {Falls,Publish},
        mounted(){
            document.title = '菠菜圈| 首页';
            var v = this;
            this.https.get('/front/home/left_render',{
                }).then((r)=>{
                    v.loading = false;
                    v.slideList = r.data.leftList.slide;
                }).catch((e)=>{
                    v.loading = false;
                    console.log(e)
                });
        },
        data(){
            return {
                carousel:{
                    index:0,
                    height:300,
                    autoplay_speed:5000,
                    trigger:'hover',
                    arrow:'hover'
                },
                slideList:'',
            }
        },
        computed:{
            user_info(){
                return this.$store.state.user_info
            }
        },
        methods:{
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
            changeCat(data){
                this.$refs.Falls.changeCat(data)
            },
            pubmicro(){
                this.$refs.Falls.page = 0
                this.$refs.Falls.loading = true
                this.$refs.Falls.has_more = true
                this.$refs.Falls.getFalls()
            }
        }
    }
</script>

<style lang="scss">
    * {
        box-sizing: border-box;
    }
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .icon-user {
        vertical-align: text-bottom;
    }
    .load-more {
        width: 150px;
        height: 40px;
        line-height: 1;
        font-size: 14px;
        color: #666;
        background: #fff;
        padding:8px 25px;
        margin-top: 30px;
        border: 1px solid #333;
        &:hover {
            color: #28b28a;
            border-color: #28b28a;
        }
    }
    #MainLeft {
        min-height: 100vh;
        .first-banner {
            width: 100%;
            height: 250px;
            border: 1px solid #f2f2f2;
            border-radius: 5px 5px 0 0;
            overflow: hidden;
             #{'/deep/'}.ivu-carousel-dots {
                position: absolute;
                bottom: -1px;
                text-align: right;
                display: flex!important;
                height: 8px;
                >li{
                    display: inline-block;
                    width: 100%;
                    margin: 0;
                    padding:0;
                    button{
                        width:100%;
                        height: 100%;
                    }
                }
                .ivu-carousel-active{
                    button{
                        background-color: #28b28a!important;
                        box-shadow: 0 0 10px #28b28a;
                    }    
                }
            }
            .carousel-content {
                position: relative;
                width: 100%;
                height: 250px;
                overflow: hidden;
                outline: none;
                .carousel-title {
                    text-align: center;
                    font-size: 18px;
                    color: #fff;
                    position: absolute;
                    bottom: 0;
                    left: 0;
                    width: 100%;
                    height: 60px;
                    line-height: 60px;
                    padding: 0 10px;
                    background: rgba(0,0,0,0.6);
                    overflow : hidden;
                    text-overflow: ellipsis;
                    -webkit-text-overflow: ellipsis;
                    -moz-text-overflow: ellipsis;
                    -ms-text-overflow: ellipsis;
                    white-space: nowrap;
                    -moz-white-space: nowrap;
                    -webkit-white-space: nowrap;
                    -o-white-space: nowrap;
                    vertical-align:middle;
                }
                >img {
                    position: absolute;
                    top: 0;
                    left: 0;
                    height: 100%;
                    width: 100%;
                    outline: none;
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -ms-transition: all .5s;
                    -o-transition: all .5s;
                    cursor: pointer;
                    &:hover {
                        transform: scale(1.1);
                        -webkit-transform: scale(1.1);
                        -moz-transform: scale(1.1);
                        -ms-transform: scale(1.1);
                        -o-transform: scale(1.1);
                    }
                }
            }
        } 
        .publish-zone{
            border:1px solid #dddee1;
            height: 240px;
        }
        .panel-content {
            margin-top: 20px;
            #{'/deep/'}.ivu-tabs-ink-bar {
                background-color: #28b28a;
            }
            #{'/deep/'}.ivu-tabs-tab{
                color: #333;
                font-weight:normal;
            }
            #{'/deep/'}.ivu-tabs-bar{
                margin-bottom: 0;
            }
            #{'/deep/'}.ivu-tabs-tab-active {
                color: #28b28a;
            }
            .news-list {
                .news-image-frame {
                    outline: none;
                    border: 1px solid #f2f2f2;
                }
                .news-tag {
                    width: auto;
                    height: auto;
                    padding-left: 10px;
                    padding-right: 10px;
                    padding-top:3px;
                    padding-bottom:3px;
                    position: absolute;
                    top: 3px;
                    left: 3px;
                    background: rgba(0,0,0,.45);
                    color: #fff;
                    font-size: .2rem;
                    border-radius: 12px;
                    -webkit-border-radius: 12px;
                    -moz-border-radius: 12px;
                    -ms-border-radius: 12px;
                }
                .news-content {
                    .news-title {
                        width: 100%;
                        height: 30px;
                        line-height: 30px;
                        font-size: 18px;
                        color: #333;
                        font-weight: bold;
                        a {
                            color: #333;
                            display: block;
                            overflow : hidden;
                            text-overflow: ellipsis;
                            -webkit-text-overflow: ellipsis;
                            -moz-text-overflow: ellipsis;
                            -ms-text-overflow: ellipsis;
                            white-space: nowrap;
                            -moz-white-space: nowrap;
                            -webkit-white-space: nowrap;
                            -o-white-space: nowrap;
                            &:hover {
                                color:#28b28a;
                            }
                        }
                    }
                    .news-brief {
                        margin-top: 15px;
                        font-size: 14px;
                        height: 45px;
                        color: #666;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow:ellipsis;
                        -moz-text-overflow:ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;
                    }
                    .news-info {
                        color: #999;
                        .news-username {
                            a {
                                color: #999;
                                height: 28px;
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
    }
</style>