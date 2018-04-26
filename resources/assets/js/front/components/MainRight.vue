<template>
    <div id="MainRight">
        <Row v-if="loading">
            <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                <Spin fix>
                    <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
                    <div>Loading</div>
                </Spin>
            </Col>
        </Row>
        <Row>   <!-- 之所以要遍历是因为后台需要排序，先遍历出来的会先展示 -->
            <Col v-for="(item,key,index) in clist"  :key="key">
                <Special v-if="item.cid==1" :title="item.title"></Special>
                <Report v-if="item.cid==4" :title="item.title"></Report>
                <Business v-if="item.cid==5"  :title="item.title"></Business>
                <News v-if="item.cid==2" :title="item.title"></News>
                <Author v-if="item.cid==7" :title="item.title"></Author>
                <Platform v-if="item.cid==6" :title="item.title"></Platform>
                <HotNews v-if="item.cid==8" :title="item.title"></HotNews>
                <HotSpecial v-if="item.cid==9" :title="item.title"></HotSpecial>
                <HotQuestion v-if="item.cid==10" :title="item.title"></HotQuestion>
                <Exhibition v-if="item.cid==11" :title="item.title"></Exhibition>    
                <Flash v-if="item.cid==12" :title="item.title"></Flash> 
                <HotDownload v-if="item.cid==13" :title="item.title"></HotDownload>
                <WeekHotNews v-if="item.cid==14" :title="item.title"></WeekHotNews>   
                <ExhibitionNewsList v-if="item.cid==15" :title="item.title"></ExhibitionNewsList>
                <DatePicker v-if="item.cid==16" :title="item.title"></DatePicker>
                <GameInfo v-if="item.cid==17" :title="item.title"></GameInfo>                                
            </Col>
        </Row>
    </div>
    <!-- special 1,news 2,user_data 3, report 4, business 5, platform 6, author 7 -->
</template>
<script>
    import Special from './rightComponents/special'
    import Report from './rightComponents/report'
    import Business from './rightComponents/business'
    import News from './rightComponents/news'
    import Author from './rightComponents/author'
    import Platform from './rightComponents/platform'
    import HotNews from './rightComponents/hot_news'
    import HotSpecial from './rightComponents/hot_special'
    import HotQuestion from './rightComponents/hot_question'
    import Exhibition from './rightComponents/exhibition'
    import Flash from './rightComponents/flash'  
    import HotDownload from './rightComponents/hot_download'    
    import WeekHotNews from './rightComponents/week_hot_news'
    import ExhibitionNewsList from './rightComponents/exhibition_news_list'
    import DatePicker from './rightComponents/datepicker'
    import GameInfo from './rightComponents/gameinfo'
    export default {
        name: 'MainRight',
        props:['pageId'],
        components:{
            Special,
            Report,
            Business,
            News,
            Author,
            Platform,
            HotNews,
            HotSpecial,
            HotQuestion,
            Exhibition,
            Flash,
            HotDownload,
            WeekHotNews,
            ExhibitionNewsList,
            DatePicker,
            GameInfo
        },
        data(){
            return {
                clist:[],
                loading:true
            }
        },
        mounted(){
            var v = this;
            this.https.get('/front/components/get_right_list',{
                    params:{
                        page_id : v.pageId
                    }
                }).then((r)=>{
                    if (r.data.right_list) {
                        v.list == 1;
                        var list = r.data.right_list;
                        for (var i in list) {
                            v.$set(v.clist,i,{'cid':list[i].cid,'title':list[i].title});
                        }
                    }
                    v.loading = false;
                }).catch((e)=>{   
                    console.log(e)
                });
        }
    }
</script>

<style lang="scss" scoped>
    #MainRight {
        .demo-spin-icon-load{
        animation: ani-demo-spin 1s linear infinite;
        }
        @keyframes ani-demo-spin {
            from { transform: rotate(0deg);}
            50%  { transform: rotate(180deg);}
            to   { transform: rotate(360deg);}
        }
        .demo-spin-col{
            height: 100px;
        }
    }
</style>