<template>
    <div id="special" v-if="specialList.length"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a v-bind:href="'/news/special'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row type="flex" justify="space-between" class="special-list">
            <Col :xs="24" :sm="24" :lg="24" v-for="(item,key) in specialList" :key="key" :class-name="'special'">
                <Col :xs="8" :sm="8" :lg="8">
                <div class='img-frame'>
                    <img :src="item.image" onerror="this.src='/static/noimg.png'">
                </div>
                </Col>
                <Col :xs="16" :sm="16" :lg="16" :class-name="'special-info'">
                    <div class="special-title"><a v-bind:href="'/news/SpecialDetail/'+item.id" target="_blank">{{item.title}}</a></div>
                    <div class="special-brief">{{item.content}}</div>
                </Col>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        name: 'Special',
        props:['title'],
        data(){
            return {
                page:0,
                specialList:[]
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
                this.https.get('/front/components/get_special',{
                    params:{
                        page : v.page
                    }
                }).then((r)=>{
                    if (r.data.specialList.length>0) {
                        v.specialList = v.specialList.concat(r.data.specialList);
                    }
                }).catch((e)=>{   
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    #special{
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
        .special-list{
            .special{
                .img-frame {
                  width: 100%;
                  height: 0;
                  padding-bottom: 62.5%;
                  overflow: hidden;
                  border-radius: 3px;
                  position: relative;
                  text-align: center;
                  vertical-align: center;
                  border: 1px solid #f2f2f2;
                  &:hover img, &:focus img {
                    transform: scale(1.1);
                    -webkit-transform: scale(1.1);
                    -moz-transform: scale(1.1);
                    -o-transform: scale(1.1);
                    -ms-transform: scale(1.1);
                  }
                  img {
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    cursor: pointer;
                    border-radius: 3px;
                    outline: none;
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    -ms-transition: all .5s;
                  }
                }
                .special-info{
                    padding:0 0 0 10px;
                    .special-title{
                        height: 21px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow:ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        -webkit-box-orient: vertical;                      
                        a{
                            font-size:16px;
                            font-weight: bold; 
                            color: #333333; 
                            &:hover{
                                color:#28b28a;
                            }                                
                        }                                               
                    }
                    .special-brief{
                        font-size: 14px;
                        margin-top: 10px;
                        height: 40px;
                        color: #666666;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow:ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 2;
                        -webkit-box-orient: vertical;                           
                    }

                }
                margin-top: 20px;
            }
        }
    }
</style>