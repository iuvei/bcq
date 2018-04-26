<template>
    <div id="platform" v-if="platformList.length"> <!-- 招商信息组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a v-bind:href="'/trade/platform'"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row type="flex" justify="space-between" class="platform-list">
            <Col :xs="24" :sm="24" :lg="24" v-for="(item,key) in platformList" :key="key" :class-name="'platform'">
                <div class="img-frame">
                    <a v-bind:href="'/trade/PlatformDetail/' + item.id" target="_blank">
                        <img :src="item.logo" class="platform-image">
                            <a>
                                <div class="title-frame">
                                    <span>
                                        <p>
                                            <em>{{item.title}}</em>
                                        </p> 
                                    </span>
                                </div>
                            </a>
                        <img src="/static/platform_confirm.png" class="platform-confirm" v-if="item.confirm==1">
                    </a>
                </div>
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        name: 'Platform',
        props:['title'],      
        data(){
            return {
                page:0,
                platformList:[]
            }
        },
        mounted(){
            this.get_list();
        },
        methods:{
            get_list(){
                var v = this;
                this.https.get('/front/components/get_platform',{
                    params:{
                        page : v.page
                    }
                }).then((r)=>{
                    if (r.data.platformList.length>0) {
                        v.platformList = v.platformList.concat(r.data.platformList);
                    }
                }).catch((e)=>{   
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    #platform{
        padding-bottom: 50px;
        .components-title{
            text-align: center; 
            font-size: 0.3rem;
            font-weight: 800;
            border-top: 2px solid #27b289;
            border-bottom:1px solid #e0e0e0;
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
        .platform-list{
            margin-top: 0.15rem;
            .platform{
                .img-frame{
                    .platform-image { 
                        position: absolute;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        transition-property: initial;
                        transition-duration: 0.7s;
                        transition-timing-function: initial;
                        transition-delay: initial;
                        cursor: pointer; 
                        border-radius: 4px;
                        &:hover {
                            transform: scale(1.1);
                        }
                    }
                    .platform-confirm{
                        display: block;
                        position: absolute;
                        top: 0;
                        left: 0.5rem;
                    }
                    a{
                        .title-frame{
                            position: absolute;
                            width: 100%;
                            left: 0px;
                            bottom:0px; 
                            height: 60px;
                            background: rgba(0,0,0,0.6);
                            display: table;
                            padding:0px 10px 0px 10px;
                            >span{
                                color: white;
                                font-size: 16px;
                                font-weight: bold;
                                letter-spacing: 1px;
                                display: table-cell;
                                text-align: center;
                                vertical-align: middle;
                                    >p{
                                        display: inline-block;
                                        text-align: left;
                                        em{
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
                    height: 0;
                    width: 100%;
                    padding-bottom:60%;
                    position: relative;
                    margin-top: 0.3rem;
                    border-radius: 4px;
                    overflow: hidden; 
                }
            }
        }
    }
</style>