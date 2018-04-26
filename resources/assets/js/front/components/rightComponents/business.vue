<template>
    <div id="business"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a  v-bind:href="'/trade/business'"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row :class-name="'businessList'">
            <Col  :xs="24" :sm="24" :lg="24">
                <Tabs value="sale">
                    <TabPane label="供应信息" name="sale">
                        <div class="sale-list line1" v-for="(item,key) in sale" :key="key">
                            <span class="confirm" v-if="item.confirm">官方认证</span>
                            <span class="no-confirm" v-else>跳蚤信息</span>
                            <label class="cname">[{{item.category.cname}}]</label>
                            <a target="_blank"  v-bind:href="'/trade/BusinessDetail/'+item.id">{{item.title}}</a>
                        </div>
                    </TabPane>
                    <TabPane label="求购信息" name="purchase">
                        <div class="purchase-list line1" v-for="(item,key) in purchase" :key="key">
                            <span class="confirm" v-if="item.confirm">官方认证</span>
                            <span class="no-confirm" v-else>跳蚤信息</span>
                            <label class="cname">[{{item.category.cname}}]</label>
                            <a target="_blank"  v-bind:href="'/trade/BusinessDetail/'+item.id">{{item.title}}</a>
                        </div>
                    </TabPane>
                </Tabs>
            </Col>                       
        </Row>
    </div>
</template>
<script>
    export default {
        name: 'Business',
        props:['title'],
        data(){
            return {
                page:0,
                sale:[],
                purchase:[]
            }
        },
        mounted(){
            this.get_list();
        },
        methods:{
            get_list(){
                var v = this;
                this.https.get('/front/components/get_business',{
                    params:{
                        page : v.page
                    }
                }).then((r)=>{
                    v.sale = r.data.sale
                    v.purchase = r.data.purchase
                }).catch((e)=>{   
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
#business{
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
    .businessList{
        text-align: left;
        margin-top: 0.3rem;
        .sale-list,.purchase-list{
            margin-top:15px; 
            font-size: 14px;
            height: 21px;
            a{
                color: black;
                &:hover{
                    color: #28b28a;
                }
            }
        }
        .confirm,.no-confirm{
            padding:2px 4px 2px 4px;
            border-radius: 3px;
            color: #fff;
        }   
        .confirm{
            background-color: #28b28a;
        }   
        .no-confirm{
            background-color: gray;
        }   
        .cname{
            color: #ff9d6a;
        }
        .title{
            display: inline;
        }
    }
}
</style>