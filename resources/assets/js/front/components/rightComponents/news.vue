<template>
    <div id="news" v-if="newsList.length"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a @click="go('/news')"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row :class-name="'newsList'">
            <Col :xs="24" :sm="24" :lg="24" v-for="(item,key,index) in newsList" :key="key" :class-name="'news'">
                <a v-bind:href="'/news/newspage/'+item.id" target="_blank">    
                    <div class="news-title change-color">
                        {{ item.title }}
                    </div>
                </a>
                <div class="news-brief">{{ item.brief }}</div>    
                <Row class="news-info" type="flex" align="middle" >
                    <Col :class-name="'news-view change-color'" :xs="3" :sm="3" :lg="3">
                        <Icon type="ios-eye-outline" size="12"></Icon>&nbsp&nbsp
                        <label class="view">{{item.view}}</label>
                    </Col>
                    <Col :class-name="'news-comment change-color'"  :xs="3" :sm="3" :lg="3">
                        <Icon type="chatbox-working" size="12"></Icon>&nbsp&nbsp
                        <label class="comment">{{item.comment}}</label>
                    </Col>
                    <Col :class-name="'news-time change-color'"  :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
                        {{item.updated_at}}
                    </Col>
                </Row>                       
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        name: 'news',
        props:['title'],
        data(){
            return {
                page:0,
                newsList:[]
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
                this.https.get('/front/components/get_news',{
                    params:{
                        page : v.page
                    }
                }).then((r)=>{
                    if (r.data.newsList.length>0) {
                        v.newsList = v.newsList.concat(r.data.newsList);
                        
                    }
                }).catch((e)=>{   
                    console.log(e)
                });
            },
        }
    }
</script>

<style lang="scss" scoped>
#news{
    padding-bottom: 50px;
    .components-title{
        text-align: center; 
        font-size: 0.3rem;
        font-weight: 800;
        border-top: 2px solid #27b289;
        border-bottom:1px solid silver;
        border-style: solid none dashed none;
        height: 1rem;
        line-height: 1rem;
        position: relative;
        .title-image{
            position: absolute;
            right: 0.5rem;
            top: 45%;
            cursor: pointer;
        }
    }
    .newsList{
        .news{
            text-align: left;
            margin-top: 0.3rem;
            .news-title{
                font-size: 16px;
                font-weight: bold;
                color: #323232;
                min-height: 0.5rem;
                max-height: 0.5rem;
                vertical-align: middle;
                cursor: pointer;
                overflow : hidden;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;
                &:hover{
                    color:#27b48a;
                }
            }
            .news-brief{
                font-size: 12px;
                color: #989898;
                min-height: 0.6rem;
                max-height: 0.6rem;
                overflow : hidden;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
            }
            .news-info{
                margin-top: 15px;
                font-size: 12px;
                color: #989898;
                .collected{
                    color: #27b48a;
                    border-color: #27b48a;
                }
            }
            .news-time{
                padding-right:10px;
                text-align: right;
            }
            border-bottom: 1px solid silver;
            border-style: none none solid none;
            padding-bottom: 10px;
        }
    }
}
</style>