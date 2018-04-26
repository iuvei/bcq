<template>
    <div id="shows" v-if="shows.length"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a v-bind:href="'/news'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row type="flex" justify="space-between">
            <Col :xs="24" :sm="24" :lg="24" :class-name="'shows'">
                <ul>
                    <li v-for="(item,index) in shows" class="shows-list line1">
                        <a v-bind:href="'/parts/ExbitionDetail/'+item.sid" target="_blank" class="short">【{{item.short}}】</a> 
                        <a v-bind:href="'/news/newspage/'+item.nid" target="_blank" class="title">{{item.title}}</a>
                    </li>
                </ul>
            </Col>
        </Row>
    </div>	
</template>
<script>
    export default {
        props:['title'],
        data(){
            return {
                page:0,
                shows:[]
            }
        },
        mounted(){
            var v = this
            this.https.get('/front/components/get_exhibition_news').then((r)=>{
            	v.shows = r.data
            }).catch((e)=>{
            	console.log(e)
            })
        },
        methods:{
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            }
        }        
    }	
</script>
<style lang="scss" scoped>
	.shows-list{
        font-size: 14px;
        margin-top: 15px;
        height: 20px;
        .short{
            color: #478dce;
        }
        .title{
            color: #333333;
            &:hover{
                color: #28b28a;
            }
        }
    }
</style>