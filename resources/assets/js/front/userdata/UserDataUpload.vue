<template>
    <div id="upload">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资料</BreadcrumbItem>
                    <BreadcrumbItem>上传资料</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" justify="space-between" :class-name="'main'">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
                        <Row type="flex" align="middle">
                            <Col :xs="{'span':5}" :sm="{'span':5}" :lg="{'span':5}">
                                <Upload action="" :before-upload="handleUpload" :show-upload-list="true">
                                    <Button class="default-button" :loading="loadingStatus">
                                        <span v-if="upload_success">选择文件</span>
                                        <span v-else>重新上传文件</span>
                                    </Button>
                                </Upload>                       
                            </Col>
                            <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}">
                                目前只支持 rar , zip 格式
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="complete">   
                                <div class="upload-info">
                                    <div v-if="file" class="upload-file"><span>{{file.name}} <label @click="del_file" class="del-file">×</label></span>
                                    </div> 
                                    <div class="upload-progress">
                                        <div v-if="upload_success">
                                            <Progress :percent="progress" status="success">
                                            <span>{{progress}}%</span>
                                            </Progress>
                                        </div>
                                        <div v-else>
                                            <Progress :percent="65" status="wrong">
                                            </Progress>
                                        </div>
                                    </div>
                                </div>                                
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="' must'">*</Col>
                                <Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
                                    <div class="form-label">资料名称 : </div>
                                </Col>
                                <Col  :xs="{'span':10,'offset':1}" :sm="{'span':10,'offset':1}" :lg="{'span':10,'offset':1}">
                                    <input class="common-input" placeholder="3-30个汉字" v-model="title"/>
                                </Col>
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="' must'">*</Col>
                                <Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
                                    <div class="form-label">标签 : </div>
                                </Col>
                                <Col  :xs="{'span':10,'offset':1}" :sm="{'span':10,'offset':1}" :lg="{'span':10,'offset':1}">
                                    <input class="common-input" placeholder="请用空格分隔标签，标签可填1-5个" v-model="keywords"/>
                                </Col>
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <Col :xs="{'span':1}" :sm="{'span':1}" :lg="{'span':1}" :class-name="' must'">*</Col>
                                <Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
                                    <div class="form-label">资料类型 : </div>
                                </Col>
                                <Col  :xs="{'span':4,'offset':1}" :sm="{'span':4,'offset':1}" :lg="{'span':4,'offset':1}">
                                    <Select v-model="type" placeholder="未选择" class="common-select">
                                        <Option v-for="(item,key) in data_type" :value="key+1" :key="key">
                                        {{ item }}
                                        </Option>
                                    </Select>
                                </Col>
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <Col :xs="{'span':3,'offset':1}" :sm="{'span':3,'offset':1}" :lg="{'span':3,'offset':1}">
                                    <div class="form-label">种子量 : </div>
                                </Col>
                                <Col  :xs="{'span':4,'offset':1}" :sm="{'span':4,'offset':1}" :lg="{'span':4,'offset':1}">
                                    <input class="common-input" placeholder="请输入数字（颗）" @blur="test_dig(this)" ref="price"/>
                                </Col>
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <Col :xs="{'span':3,'offset':1}" :sm="{'span':3,'offset':1}" :lg="{'span':3,'offset':1}">     
                                    <div class="form-label">资料简介 : </div>
                                </Col>
                                <Col :xs="{'span':18,'offset':1}" :sm="{'span':18,'offset':1}" :lg="{'span':18,'offset':1}">
                                    <!-- <textarea class="common-textarea" v-model="brief"></textarea> -->
                                    <quill-editor v-model="brief" style="min-height: 5rem; border: 1px solid #e2e2e2;" :options="editorOption">
                                    </quill-editor>
                                    <div>阅读并同意<a href="/parts/UploadAgreement#upload" target="_blank">《菠菜圈资料上传/下载协议》</a></div>
                                </Col>
                            </Col>
                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'form-cell'">
                                <center>
                                    <Button class="default-button" @click="submit">提交</Button>
                                    <Button class="default-button preview-button" @click="preview=1">预览</Button>
                                </center>
                            </Col>
                        </Row>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
                        <!-- <UserPannel></UserPannel>   -->                       
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
        <div class="preview" v-bind:class="{'preview-show':preview}">
            <Row type="flex" justify="center">
                <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                    <Row type="flex" justify="center">
                        <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                            <div class="close-preview">
                                <span class="pointer" @click="preview=0"><Icon type="ios-undo"></Icon> 关闭预览</span>
                            </div>  
                            <Row  type="flex" justify="space-between" :class-name="'report-frame'">
                                <Col :xs="{'span':13}" :sm="{'span':13}" :lg="{'span':13}" :class-name="'report-description'">
                                    <div class="report-title">
                                        {{title}}
                                    </div>
                                    <div class="report-brief" v-html="brief">
                                        
                                    </div>
                                </Col>
                            </Row>
                        </Col>
                    </Row>
                </Col>
            </Row>            
        </div>          
    </div>
</template>

<script>
import PageRight from '../components/MainRight.vue';    
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import auth from '../common/auth';
import upload from '../common/upload';
import UserPannel from './UserPannel'
import 'quill/dist/quill.core.css';
import 'quill/dist/quill.snow.css';
import 'quill/dist/quill.bubble.css';
import { quillEditor } from 'vue-quill-editor';
let Option = { 
            placeholder: "添加发布内容！", 
            modules: {          
                toolbar: [
                  ['bold', 'italic', 'underline', 'strike',{ 'header': 1 }, { 'header': 2 }]
                ]
            }
        }
    export default{
        components: {NavHeader,FooterArea,FloatSideBar,PageRight,UserPannel,quillEditor},
        mounted(){
            document.title = '菠菜圈| 上传资料';
            var v= this;
            var id = this.$route.query.id;
            this.https.get('/front/data_upload/render').then(
                (r)=>{
                    v.ad_list = r.data.adList;
                }).catch(
                (e)=>{
                    console.log(e);
                });  
            if(id){
                this.https.get('/front/mydata/edit',{
                    params:{
                        id:id
                    }
                }).then((r)=>{
                    if(r.data){
                        v.id = id;
                        v.title = r.data.title;
                        v.keywords = r.data.keywords.split(',').join(' ');
                        v.type = r.data.type;
                        v.$refs.price.value = r.data.price;
                        v.brief = r.data.brief;
                    }
                }).catch((e)=>{
                    console.log(e);
                });
            }
        },
        data(){
            return {
                preview:0,
                id:'',
                page_id:18,
                ad_list:'',
                user:'',
                file:'',
                editorOption:Option,  
                file_name:'upload_file',
                loadingStatus: false,
                progress : 0,
                upload_success:true,
                complete:false,
                file_id:'',
                data_type:['源代码','推广技巧','技术资料'],
                type:'',
                price:'',
                title:'',
                brief:'',
                keywords:'',
                suffix:''
            }
        },
        methods:{
            go(path){
                this.$router.push(path);
            },
            handleUpload (file) {
                if (file.size/1024/1024>10) {
                    this.$Message.error('文件太大，请保证文件最大不超过8M')
                    return false
                }
                this.file = file;
                this.upload();
                return false;
            },
            test_dig(e){
                var inp = this.$refs.price.value;
                if (!isNaN(inp)&&inp) {
                    this.price = inp;
                }else{
                    this.price = '';
                    this.$Message.warning('请输入正确的种子数');
                    this.$refs.price.value = '';
                }
            },
            upload () {
                var suffix = upload.get_suffix(this.file.name);
                var valid = upload.validate(suffix,['rar','zip']);
                if(!valid){
                    this.$Message.warning('请上传系统支持文件类型');
                    return false;
                }
                var v= this;
                this.progress = 0;
                this.complete = true;
                this.loadingStatus = true;
                this.suffix = suffix;
                let formdata = new window.FormData();
                formdata.append('upload_file',v.file);
                formdata.append('type','data');
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    onUploadProgress: progressEvent => {
                            var complete = progressEvent.loaded / progressEvent.total * 100 
                            this.progress = complete
                    }
                };
                this.https.post('/common/upload_data_file',formdata, config).then(
                    (res) => {
                        if (!res.data.code) {
                            v.$Message.warning(res.data.msg);   
                            v.upload_success = false;                         
                        }else{
                            v.file_id = res.data.file_id;
                            v.upload_success = true;
                        }
                        v.loadingStatus = false;
                    }).catch(
                    (err) =>{
                        v.$Message.warning('文件上传,出现错误'); 
                        this.file = ''
                        this.upload_success = false
                        this.loadingStatus = false 
                });
            },
            del_file(){
                this.file = ''
                this.complete = false
                this.loadingStatus = false
            },
            submit(){
                var v = this;
                if(!v.id){
                    if(!v.title){
                        this.$Message.warning('请设置资料标题');
                        return false;
                    }else if(!v.keywords){
                        this.$Message.warning('请设置资料标签');
                        return false;
                    }else if(!v.type){
                        this.$Message.warning('请选择资料类型');
                        return false;
                    }else if(!v.file_id){
                        this.$Message.warning('请上传资料文件');
                        return false;
                    }
                }                
                var keywords_arr = this.keywords.trim().split(' ');

                var keywords = new Array();

                for (var i = 0; i < keywords_arr.length; i++) {
                    if (keywords_arr[i]) {
                        keywords.push(keywords_arr[i]);
                    }
                }

                keywords = keywords.join(',');

                this.https.post('/front/data_upload/data_submit',{
                    id:v.id,
                    title:v.title,
                    brief:v.brief,
                    price:v.price,
                    suffix:v.suffix,
                    file:v.file_id,
                    type:v.type,
                    keywords:keywords
                }, {
                    headers: {
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(
                    (res) => {
                        v.$router.push('/userdata/MyData')
                    }).catch(
                    (err) =>{
                        console.log(err);       
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    * {
        box-sizing: border-box;
    }
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    #upload{
        position: relative;
        .preview{
            position: absolute;
            top: 0; 
            left: 0;
            width: 100%;
            min-height: 100%;
            background-color: #fff;
            z-index: 10000;
            display: none;
            .container{
                width: 1200px;
                min-height: 60vh;
                .close-preview{
                    font-size: 18px;
                    margin-top: 20px;
                    padding-bottom: 20px;
                }
                .report-frame{
                    padding-top: 10px;
                    padding-bottom: 20px;
                    border-bottom: 1px solid #f4f4f4;
                    border-weight:lighter;
                    .report-description{
                        .report-title{
                            font-size:24px;
                            color: #333333; 
                            /*padding-top: 20px;*/
                            padding-bottom: 20px;
                        }
                        .report-brief{
                            min-height: 100px;
                            font-size: 14px;
                        }
                    }
                }                
            }
        }
        .preview-show{
            display: block;
        }           
        .container{
            width: 1200px;
            margin: 20px auto;
            min-height: 80vh;
            .main{
                padding-top: 30px;
                .page-left{
                    .default-button{
                    width: 150px;
                    font-size:14px; 
                    padding:15px 10px 15px 10px;
                    background-color: #28b28a;
                    color: white; 
                        >span{
                            cursor: pointer;
                        }
                    }
                    .preview-button{
                        color: #333;
                        background-color: #f2f2f2;
                    }
                    .upload-info{
                        .upload-file{
                            background-color: #f6f5f6;
                            font-size: 14px;
                            color: #478dce;                            
                            margin-top: 15px;
                            span{
                                padding: 4px 8px 8px 4px; 
                            }
                            .del-file{
                                cursor: pointer;
                            }
                        }
                        .upload-progress{
                            margin-top: 15px;
                        }
                    }
                    .form-cell{
                        margin-top: 30px;
                    }
                    .form-label{
                        text-align:justify;
                        text-justify:distribute-all-lines;/*ie6-8*/
                        text-align-last:justify;/* ie9*/
                        -moz-text-align-last:justify;/*ff*/
                        -webkit-text-align-last:justify;/*chrome 20+*/
                        width: 100%;
                        font-size: 16px;
                        color: #666666;
                    }
                    .common-textarea{
                        min-height: 200px;
                        color: #666666;
                        overflow:hidden;
                    }
                    .must{
                        color: #e4393c;
                        text-align: center;
                        margin-top: 5px;
                    }
                }
            }
        }
    }
</style>