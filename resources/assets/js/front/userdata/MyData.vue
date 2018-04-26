<template>
    <div id="my-data">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<div class="bread">-->
                    <!--<div class="bread-text"><a href="/">首页</a>  > 知识 > 我的资料</div>-->
                <!--</div>  -->

                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资料</BreadcrumbItem>
                    <BreadcrumbItem>我的资料</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" justify="space-between" :class-name="'main'">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
                        <Tabs v-model="tap">
                            <TabPane label="我上传的资料" name="my_upload">
                                <Row>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'userdata-list'" v-for="(item,key) in my_upload" :key="key">
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-title'">
                                            <label @click="go(`/userdata/UserDataDetail/${item.id}`)">{{item.title}}</label>
                                        </Col>
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-tag'">
                                            <tag :color="'green'" :class="'data-cat'">{{item.type}}</tag>
                                            <label v-for="(tag,key1) in item.keywords" :key="key1" class="data-keywords" >
                                                <span v-if="tag">·&nbsp&nbsp{{tag}}</span>
                                            </label>
                                        </Col>
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-info'">
                                            <Row type="flex" align="middle" >
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" style="text-align:left">
                                                    <label class="change-color line1">
                                                        <Icon type="android-person" size="12"></Icon>&nbsp
                                                        {{item.username}}
                                                     </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                     <label class="change-color">
                                                     {{item.publish_time}}
                                                    </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                    <label class="change-color">
                                                        <Icon type="ios-download-outline" size="12"></Icon>&nbsp
                                                        {{item.down}}
                                                     </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                    <label class="change-color">
                                                        <Icon type="chatbox-working" size="12"></Icon>&nbsp
                                                        {{item.comment}}</label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">                                
                                                    <label class="change-color">
                                                        <Icon type="ios-color-filter-outline" size="12"></Icon>&nbsp
                                                        {{item.price}}
                                                    </label>
                                                </Col> 
                                                <Col :xs="{'span':3,'offset':11}" :sm="{'span':3,'offset':11}" :lg="{'span':3,'offset':11}">   
                                                    <span class="data-deal" @click="edit(item.id)">[编辑]</span> 
                                                    <span class="data-deal" @click="del(item.id,key)">[删除]</span>                             
                                                </Col> 
                                            </Row>  
                                        </Col>
                                    </Col>
                                </Row>
                            </TabPane>
                            <TabPane label="我下载的资料" name="my_download">
                                <Row>
                                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'userdata-list'" v-for="(item,key) in my_download" :key="key">
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-title'">
                                            <label  @click="go(`/userdata/UserDataDetail/${item.id}`)">{{item.title}}</label>
                                        </Col>
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-tag'">
                                            <tag :color="'green'" :class="'data-cat'">{{item.type}}</tag>
                                            <label v-for="(tag,key1) in item.keywords" :key="key1" class="data-keywords" >
                                                <span v-if="tag">·&nbsp&nbsp{{tag}}</span>
                                            </label>
                                        </Col>
                                        <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'data-info'">
                                            <Row type="flex" align="middle" >
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}" style="text-align:left">
                                                    <label class="change-color line1">
                                                        <Icon type="android-person" size="12"></Icon>&nbsp
                                                        {{item.username}}
                                                     </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                     <label class="change-color">
                                                     {{item.publish_time}}
                                                    </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                    <label class="change-color">
                                                        <Icon type="ios-download-outline" size="12"></Icon>&nbsp
                                                        {{item.down}}
                                                     </label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
                                                    <label class="change-color">
                                                        <Icon type="chatbox-working" size="12"></Icon>&nbsp
                                                        {{item.comment}}</label>
                                                </Col> 
                                                <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">                                
                                                    <label class="change-color">
                                                        <Icon type="ios-color-filter-outline" size="12"></Icon>&nbsp
                                                        {{item.price}}
                                                    </label>
                                                </Col> 
                                                <Col :xs="{'span':2,'offset':12}" :sm="{'span':2,'offset':12}" :lg="{'span':2,'offset':12}">  
                                                    <span v-if="item.is_comment">[已评论]</span>
                                                    <span class="data-comment" v-else @click="go(`/userdata/UserDataDetail/${item.id}`)">[待评论]</span>                               
                                                </Col> 
                                            </Row>  
                                        </Col>
                                    </Col>
                                </Row>
                            </TabPane>
                        </Tabs>
                        <Row v-if="loading">
                            <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                <Spin fix>
                                    <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
                                    <div>Loading</div>
                                </Spin>
                            </Col>
                        </Row>
                        <Row v-if="!loading">
                            <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                                <center v-if="more_my_upload&&tap=='my_upload'">
                                    <Button class="load-more" @click="get_more(1)">浏览更多</Button>
                                </center>
                                <center  v-if="more_my_download&&tap=='my_download'">
                                    <Button class="load-more" @click="get_more(2)">浏览更多</Button>
                                </center>
                            </Col>
                        </Row>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
                        <Row class="my-data" type="flex" align="middle">
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                                <Button class="common-button3 upload-button" icon="ios-cloud-upload-outline" @click="go('/userdata/UserDataUpload')">上传资料</Button>
                            </Col>
                        </Row>    
                        <UserPannel v-on:ChangePannel="ChangePannel"></UserPannel>                                         
                        <PageRight :page-id="page_id">
                            
                        </PageRight>                          
                        <div v-if="ad_list[1]" class="ad-zone">
                            <a :href="ad_list[1].url" :title="ad_list[1].title" target="_blank">
                                <div class="ad-frame" :title="ad_list[1].title">
                                    <img :src="ad_list[1].image" class="ad-image-frame">
                                    <span class="ad-tag">广告</span>
                                    <div class="ad-title ad1-title">
                                        <div class="ad-title-content">
                                            {{ad_list[1].title}}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </Col>
                </Row>
            </Col>
        </Row>
        <FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>
    </div>
</template>
<script>
import PageRight from '../components/MainRight.vue'
import NavHeader from '../components/NavHead.vue'
import FooterArea from '../components/FooterArea.vue'
import FloatSideBar from '../components/FloatSideBar.vue'
import auth from '../common/auth'
import upload from '../common/upload'
import UserPannel from './UserPannel'
    export default{
        components: {NavHeader,FooterArea,FloatSideBar,PageRight,UserPannel},
        mounted(){
            document.title = '菠菜圈| 我的资料';
            var v = this;
            if (this.$route.query.type == 'my_download') {
                this.tap = 'my_download'
            }else{
                this.tap = 'my_upload'
            }
            var func1 = (v,i)=>{
                v.user = i;
            }
            var func2 = (v)=>{
                v.$router.push('/account');
            }
            auth.is_login(this,func1,func2);
            this.loading = true;
            var v = this;
            this.https.get('/front/mydata/render').then((r)=>{
                v.my_download = r.data.mydata.my_download;
                v.my_upload = r.data.mydata.my_upload;                
                v.ad_list = r.data.adsList;
                v.loading = false;
            }).catch((e)=>{
                console.log(e);
            });
        },
        data(){
            return {
                page_id:'19',
                user:'',
                tap:'my_upload',
                my_upload:'',
                my_download:'',
                my_upload_page:1,
                my_download_page:1,                
                ad_list:'',
                loading:false,
                more_my_upload:true,
                more_my_download:true   
            }
        },
        methods:{
            go(route){
                this.$router.push(route);
            },
            get_more(type){ 
                if (type ==1 ) {
                    var url = '/front/mydata/get_upload_list';
                    var page = this.my_upload_page;
                    this.my_upload_page = this.my_upload_page+1;
                }else{
                    var url = '/front/mydata/get_download_list';
                    var page = this.my_download_page;
                    this.my_download_page = this.my_download_page+1;
                }
                var v = this; 
                this.https.get(url,{
                    params:{
                        page : page
                    }
                }).then((r)=>{
                    v.loading = false;
                    if (r.data.length>0) {
                        if(type == 1){
                            v.my_upload = v.my_upload.concat(r.data);
                        }else{
                            v.my_download = v.my_download.concat(r.data);
                        }
                    }else{
                        if(type == 1){
                            v.more_my_upload = false;
                        }else{
                            v.more_my_download = false;
                        }                       
                        v.$Message.warning('已无更多数据');    
                    }
                }).catch((e)=>{
                    console.log(e);
                });                   
            },
            del(id,key){
                var v= this;
                this.https.get('/front/mydata/delete',{
                    params:{
                        id:id
                    }
                }).then((r)=>{
                    v.my_upload.splice(key,1)
                }).catch((e)=>{
                    console.log(e);
                });
            },
            edit(id){
                this.$router.push({ path:'/userdata/UserDataUpload',query:{id:id}}); 
            },
            ChangePannel(type){
                this.tap = type
            }
        }
}
</script>
<style lang="scss" scoped>
    * {
        box-sizing: border-box;
    }
    html, body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .data-cat {
        color: #509bff;
        background-color:#d9e9ff;
    }
#my-data{
    .container{
        width: 1200px;
        min-height: 10rem;
        margin: 20px auto;
        .page-left{
            .userdata-list{
                display: block;
                padding: 5px 5px 10px 20px;
                border-bottom: 1px solid #f4f4f4; 
                &:hover{
                    background-color: #f4f4f4;
                }
                .data-title{
                    font-size: 18px;
                    font-weight: bold;
                    padding-bottom: 10px;
                    padding-top: 10px;
                    color: #323232;
                    >label:hover{
                        cursor: pointer;
                        color: #28b28a;
                    }
                }
                .data-tag{
                    padding-top: 10px;
                    padding-bottom: 10px;
                    font-size: 12px;
                    .data-cat{
                        color: #509bff;
                        background-color:#d9e9ff;
                    }
                    .data-keywords{
                        padding-left: 5px;
                        padding-right: 5px;
                        color: #858585;
                    }
                }
                .data-info{
                    display: block;
                    padding-top: 10px;
                    padding-bottom: 10px;
                    color: #858585;
                    text-align: center;
                    .common-button{
                        width: 100%;
                    }
                    .data-deal{
                        margin-left:10px;
                        color: #333333;
                        cursor: pointer;
                        &:hover{
                            color: #28b28a;
                        }
                    }
                    .data-comment{
                        color: #333333;
                        cursor: pointer;
                        &:hover{
                            color: #28b28a;
                        }
                    }
                }
            }
        }   
        .page-right{
            .my-data{
                font-size:14px; 
                font-weight:bold;
                color: #28b28a;
                .upload-button{
                    font-size: 18px;
                    padding: 10px 15px 10px 15px; 
                    margin-bottom: 20px;
                }
                .my-data-button{
                    cursor: pointer;
                }
            }
        }    
    }
}   
</style>