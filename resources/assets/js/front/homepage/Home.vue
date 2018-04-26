<template>
    <div class="page">
        <NavHeader class="header"></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="18" :sm="18" :lg="18" :class-name="'container'">
                <Row type="flex" justify="space-between">
                    <Col :xs="3" :sm="3" :lg="3">
                        <div class='container-left'>
                            <Income></Income>
                            <Cat @changeCat = "changeCat"></Cat>
                        </div>
                    </Col>
                    <Col :xs="{'span':13}" :sm="{'span':13}" :lg="{'span':13}">                   
                       <MainLeft @changeCat = "changeCat" ref="MainLeft">
                           <div slot="ad1" v-if="adList">
                                <Carousel loop v-model= "carousel.index" autoplay :autoplay-speed="carousel.autoplay_speed" :arrow="carousel.arrow" :dots="carousel.dots">
                                    <CarouselItem v-for="(item,index) in adList" :key="index">
                                        <a :href="item.url" :title="item.title" target="_blank">
                                            <div class="abcd-frame abcd1-frame">
                                                <img :src="item.image" class="abcd-image-frame">
                                                <span class="abcd-tag">广告</span>
                                            </div>
                                        </a>
                                    </CarouselItem>
                                </Carousel>                            
                           </div>
                       </MainLeft>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'home-right'">
                        <MainRight :page-id="page_id" class='page-right'></MainRight>
                        <div class="container-right">
                            <RightNav></RightNav>
                        </div>
                    </Col>
                </Row>
            </Col>
        </Row>
        <FloatSideBar></FloatSideBar>
    </div>
</template>

<script>
    import 'normalize.css/normalize.css';
    import '../../../css/reset.css';
    import '../../../css/reset_alex.scss';
    import $ from 'jquery';
    import MainLeft from './HomeLeft.vue';
    import MainRight from '../components/MainRight.vue';
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';
    import Income from './Income.vue'
    import Cat from './Cat.vue'   
    import RightNav from './RightNav.vue'    
    export default {
        mounted(){
            var v = this;
            this.https.get('/front/home/render',{
                }).then((r)=>{
                    /*v.adList = r.data.adList;*/
                }).catch((e)=>{   
                    console.log(e)
                });
            $(window).bind('scroll',function(e){
                if (($(this).scrollTop() - 90 - $(".container-left").height()> 0)&&!v.container_left_top) {
                    v.container_left_top = true
                    $(".container-left").addClass('container_left_top')
                }else if(($(this).scrollTop() - 90 - $(".container-left").height() < 0)&&v.container_left_top){
                    v.container_left_top = false
                    $(".container-left").removeClass('container_left_top')
                }
                if (($(this).scrollTop() - 180 - $(".page-right").height() > 0)&&!v.container_right_top) {
                    v.container_right_top = true
                    $(".container-right").addClass('container-right-top')
                }else if(($(this).scrollTop() - 180 - $(".page-right").height() < 0)&&v.container_right_top){
                    v.container_right_top = false
                    $(".container-right").removeClass('container-right-top')
                }
            }) 
            v.carousel.index = Math.round(Math.random()*3)                                 
        },
        destroyed(){
            $(window).unbind('scroll')
        },        
        data(){
            return {
                page_id :1,
                adList : [{image:'/static/bcqad/fastpay.png',url:'https://www.bcquan.com/trade/BusinessDetail/2609'},{image:'/static/bcqad/BCQ.jpg',url:'https://bcquan.com/news/beAuthor'},{image:'/static/bcqad/bet.jpg',url:'http://refpagaz.top/L?tag=d_62111m_1260c_&site=62111&ad=1260'},{image:'/static/bcqad/shicai.jpg',url:'http://glipromotion.com/?from=波菜园'},{image:'/static/bcqad/g2e1.jpg',url:'https://ishk.infosalons.biz/reg/gaming18/registeren/index.aspx'}],
                on_the_top:false,
                container_left_top:false,
                container_right_top:false,
                carousel:{
                    index:0,
                    height:120,
                    autoplay_speed:7000,
                    dots:'none',
                    arrow:'never'
                }                
            }
        },
        methods: {
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
            changeCat(data){
                this.$refs.MainLeft.changeCat(data)
            }
        },
        components: {MainLeft, MainRight,NavHeader,FooterArea,FloatSideBar,Income,Cat,RightNav}
    }
</script>

<style lang="scss" scoped>
* {
    box-sizing: border-box;
}
html,body{
    height: 100%;
    font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
}
.page {
    position: relative;
    .container{
        height: 100%;
        width: 1200px;
        margin-top: 20px;
        .home-right{
            .right-frame{
                display: block;
            }
            .page-right{
                padding-bottom: 20px;
            }
            .container-right-top{
                position: fixed;
                width: 350px;
                top: 20px;
            }
        }
        .container_left_top{
            position: fixed;
            width: 150px;
            top: 20px;
        }
    }
    height: 100%;
    background: #fff;
}
</style>