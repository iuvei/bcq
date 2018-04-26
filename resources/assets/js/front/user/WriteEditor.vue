<template>
    <div id="WriteEditor">
        <ul class="WriteEditor">
            <li class="editAuthor">
                <a @click="goback" class="btn-back">返回作者页面</a>
                <h2 class="AuthorInfo">
                    <img v-bind:src="author_info.image" onError="this.src='/static/web.png';" alt="作者头像">
                    <center>
                        <div class="line1">{{author_info.username}}</div>
                    </center>
                </h2>
                <nav>
                    <ol class="folder-tab">
                        <li class="add-folder" @click="new_class=true">
                            <Icon class="Icon-plus" type="plus-round">
                            </Icon>新建标签
                        </li>
                        <li :class="{active: 1 == selected && news_class == item.id}" v-for="(item,key) in author_class" :key="key" @click="selected = 1;news_class = item.id">
                            {{item.cname}}
                            <span class="edit-class" @click="edit_id=item.id;edit_cname=item.cname;edit_class_show=true">
                                <Icon type="edit">
                                    
                                </Icon>
                            </span>
                        </li>
<!--                         <li class="trash" :class="{active: -1 === selected}" @click="selected = -1">
                            <Icon class="Icon-del" type="ios-trash-outline"></Icon>&nbsp回收站
                        </li> -->
                    </ol>
                </nav>
            </li>
            <li class="editTab">
                <div class="add-article" v-if="selected==1" @click="add_article">
                    <Icon class="Icon-plus" type="plus-round"></Icon>新建文章
                </div>
                <ol class="panels">
                    <li v-if="selected==1" v-for="(item,key) in news[news_class]" @click="select_article(item.id)">
                        <div class="folderField" :class="{active: item.id === select_nid}">
                            <p>{{item.title}}</p>
                            <div class="font-count">
                                字数：{{item.count}}
                                <span class="status-no-sub" v-if="item.status==-3">(文章未发表)</span>
                                <span class="status-sub" v-else>(未通过审核)</span>
                                <span class="locked" v-if="item.locked" @click="lock_news(item.id);item.locked=0" title="锁定后文章将不可被复制">
                                    <Icon type="locked"></Icon>
                                </span>
                                <span class="locked" v-if="!item.locked" @click="lock_news(item.id);;item.locked=1" title="锁定后文章将不可被复制">
                                    <Icon type="unlocked"></Icon>
                                </span>
                                <span class="folder" @click.stop="move_class_show=true;move_id=item.id;move_key=key">
                                    <Icon type="folder"></Icon>
                                </span>
                                 <span class="trash" @click.stop="go_trash(item.id,key,'news')">
                                    <Icon type="trash-a"></Icon>
                                </span>
                            </div>                         
                        </div>
                    </li> 
                    <li v-if="selected==-1" v-for="(item,key) in trash">
                        <div class="folderField"  :class="{active: item.id === select_nid}">
                            <p>{{item.title}}</p>
                            <div class="font-count">字数：{{item.count}}</div>
                        </div>
                    </li> 
                </ol>
            </li>
            <li class="editField" v-bind:class="{'hide-zone':!select_nid}">
                <section class="img-cover">
                    <div class="publish">
                        <a @click="preview=1;createCreation(1)"><Icon class="Ico-preview" type="ios-paper"></Icon>预览文章</a>
                        <a @click="createCreation(1)"><Icon class="Ico-save" type="android-list"></Icon>保存文章</a>
                        <a @click="createCreation(2)"><Icon class="Ico-send" type="paper-airplane"></Icon>发表文章</a>
                        <a><Checkbox v-model="byself" class="common-checkbox"><span style="font-size:14px">原创</span></Checkbox></a>
                    </div>
                    <!--图片上传-->
                    <ul class="img-container">
                        <li v-if="loading">
                            <Spin fix>
                                <Icon type="load-c" size=18 :class="'demo-spin-icon-load'"></Icon>
                            </Spin>
                        </li>
                        <li v-else @click="upload_picture">
                            <img v-bind:src="image" v-if="image">
                        </li>
                        <li>
                            <form id="choice-form" style="display:none">
                                <input type="file" accept="image/jpeg,image/png,image/gif" name="file" @change="onFileChange">
                            </form> 
                            <p>
                                <b style="color: #e4393c;padding-right: 3px;">*</b>支持图片格式：jpg/jpeg/png
                            </p>
                        </li>
                    </ul>
                </section>
                <section class="txt-title">
                    <input class="edit-title common-input" placeholder="请输入文章标题" v-model="title">
                </section>
                <section class="txt-editor creation-page">
                    <quill-editor v-model="content" style="min-height:5rem; border:1px solid #e2e2e2;" ref="myQuillEditor" :options="editorOption">
                    </quill-editor>
                </section>
                <form id="creation-form">
                    <input style="display: none" id="editor-upload" type="file" accept="image/jpg,image/jpeg,image/png,image/gif" @change="uploadImg">
                </form>
            </li>
        </ul>
        <Modal
            v-model="show_class"
            title="请选择文章标签"
            @on-ok="choice_class">
            <Select v-model="cid">
                <Option v-for="(item,key) in news_category" :value="item.id" :key="key">
                    <label style="font-size:20px;margin:10px 0px 10px 0px">{{ item.cname }}
                    </label>
                </Option>
            </Select>
        </Modal>
        <Modal
            v-model="new_class"
            title="新建标签"
            @on-ok="add_new_class">
            <input class="common-input" v-model="new_cname"  placeholder="新标签名称" />
        </Modal>
        <Modal
            v-model="edit_class_show"
            title="修改标签名称"
            @on-ok="edit_class_name">
            <input class="common-input" v-model="edit_cname"  placeholder="编辑标签名称" />
        </Modal>
        <Modal
            v-model="move_class_show"
            title="移动到"
            @on-ok="move">
            <Select v-model="move_ucid">
                <Option v-for="(item,key) in author_class" :value="item.id" :key="key">
                    <label style="font-size:20px;margin:10px 0px 10px 0px">{{ item.cname }}
                    </label>
                </Option>
            </Select>
        </Modal>
        <Modal
            v-model="cropper.show_cropper"
            title="截取封面图片"
            @on-ok="get_picture"
            :ok-text="'截取'"
            :cancel-text="'取消'">
            <vueCropper
                ref="cropper"
                :img="cropper.avatar"
                :autoCrop="cropper.autoCrop"
                :autoCropWidth="cropper.autoCropWidth"
                :autoCropHeight="cropper.autoCropHeight"
                :fixedBox="cropper.fixedBox"
                :fixed="cropper.fixed"
                :fixedNumber="cropper.fixedNumber"
                 style="width:500px;height:300px;">                                 
            </vueCropper>
        </Modal>        
        <div style="display:none">{{show_image}}{{show_title}}{{show_content}}</div>
        <div class="preview" v-bind:class="{'preview-show':preview}">
            <Row type="flex" justify="center">
                <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">

                    <Row type="flex" justify="center">
                        <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                            <div class="close-preview">
                                <span class="pointer" @click="preview=0"><Icon type="ios-undo"></Icon> 关闭预览</span>
                            </div>
                            <Row :class-name="'news-detail'">
                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                                  <span class="news-title">{{title}}</span>
                                </Col>
                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
                                  <div class="v-html-content" v-html="content"></div>
                                </Col>
                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-footer'">
                                    <Row type="flex" justify="center">
                                      <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}">
                                        <div class="news-footer-content">· END ·</div>
                                        <div class="news-footer-content">本文由菠菜圈-作者刊登，版权归原作者所有，</div>
                                        <div class="news-footer-content">未经授权，请勿转载，谢谢！</div>
                                      </Col>
                                    </Row>
                                </Col>
                            </Row>  
                            <Row type="flex" justify="center">
                              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
                                <div class="signature">
                                    <img v-bind:src="author_info.signature?author_info.signature:'/static/official.jpg'">
                                </div>
                              </Col>
                            </Row> 
                            <div class="close-preview">
                                <span class="pointer" @click="preview=0"><Icon type="ios-undo"></Icon> 关闭预览</span>
                            </div>                             
                        </Col>
                    </Row>
                </Col>
            </Row>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery';
    import 'quill/dist/quill.core.css';
    import 'quill/dist/quill.snow.css';
    import 'quill/dist/quill.bubble.css';
    import { quillEditor } from 'vue-quill-editor';
    import lrz from 'lrz';
    import Vue from 'vue';
    import VueCropper from 'vue-cropper'

    var Option_no_vedio = { 
            placeholder: "开始你的创作！", 
            modules: {          
                toolbar: [
                  ['bold','italic','underline', 'strike','blockquote',,{ 'header': 1 }, { 'header': 2 }],
                  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                  ['link'],
                  ['image']
                ]
            }
        }

        var Option_vedio = { 
            placeholder: "开始你的创作！", 
            modules: {          
                toolbar: [
                  ['bold','italic','underline', 'strike','blockquote',,{ 'header': 1 }, { 'header': 2 }],
                  [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                  ['link'],
                  ['image'],
                  ['video']
                ]
            }
        }

        var Option = {}    
    export default{
        components: {
            quillEditor,VueCropper
        },
        beforeCreate(){
   
            var v = this

            if (!this.$store.state.user_info) {
                $.ajax({
                    url:'/common/is_login',
                    type:'GET',
                    async:false, 
                    dataType:'json',//返回的数据格式：
                    success:function(data,textStatus,jqXHR){

                        if (data.code == 1&&data.user_info.level_id>3) {
                            
                            Option = Option_vedio    
            
                        }else{
                            Option = Option_no_vedio
                        }
                    },
                    error:function(xhr,textStatus){
                        console.log(xhr)
                    },
                })
            }else{

                if (this.$store.state.user_info.level_id>3) {
                    
                    Option = Option_vedio   
                    
                }
                
            }            
        },
        mounted(){

            var v = this;

            v.https.get('/front/creation_page/render').then((r)=>{

                v.author_info = r.data.author_info

                v.trash = r.data.author_news[-1]?r.data.author_news[-1]:[]
                
                v.news = r.data.author_news[1]?r.data.author_news[1]:[]

                v.author_class = r.data.author_class

                v.news_class = v.author_class.length?v.author_class[0].id:''

                v.news_category = r.data.news_category

                this.is_changed = false

            }).catch((e)=>{

                console.log(e);

            });             
            var vm =this
            var imgHandler = function(image) {
                vm.addImgRange = vm.$refs.myQuillEditor.quill.getSelection()
                if (image) {
                 var fileInput = document.getElementById('editor-upload') //隐藏的file文本ID
                 fileInput.click() //加一个触发事件
                }
            }
            vm.$refs.myQuillEditor.quill.getModule("toolbar").addHandler("image", imgHandler)
            var has_class = false
            $(window).bind('scroll',function(e){
                var bar_height = $(".edit-title").offset().top
                var pub_height = $(".publish").offset().top + 56
                if (pub_height<bar_height) {
                    if (has_class) {
                        $(".ql-toolbar").removeClass('ql-toolbar-write')
                        has_class = false
                    }                    
                }else{
                    if (!has_class) {
                        $(".ql-toolbar").addClass('ql-toolbar-write')
                        has_class = true
                    }                        
                }
            })
        },
        destroyed(){

            $(window).unbind('scroll')

        },
        data(){
            return {
                byself:false,
                preview:0,
                title:'',
                content: '',
                image:'',
                addImgRange:'',
                editorOption:Option,
                selected: 1,
                author_class:'',
                author_info:[],
                trash:[],
                news:[],
                news_class:'',
                select_nid:'',
                ucid:'',
                news_category:'',
                cid:'',
                show_class:false,
                new_class:false,
                edit_class_show:false,
                move_class_show:false,                
                new_cname:'',
                edit_id:'',
                edit_cname:'',
                move_id:'',
                move_ucid:'',
                move_key:'',
                loading:false,
                is_changed:false,
                cropper: {
                    avatar: '',
                    autoCrop: true,
                    autoCropWidth: 320,
                    autoCropHeight: 200,
                    fixedBox: false,
                    show_cropper:false,
                    fixed:true,
                    fixedNumber:[1.6,1]
                }                
            }
        },
        computed:{
            show_image(){
                this.is_changed = true
                return this.image
            },
            show_title(){
                this.is_changed = true
                return this.title
            },
            show_content(){
                this.is_changed = true
                return this.content
            }
        },
        methods:{
            goback(){
                if (this.is_changed) {
                    this.createCreation(1)
                }             
                this.$router.push('/user/userzone/' + this.author_info.id)
            },
            move(){
                var v = this;
                v.https.get('/front/creation_page/move_creation',{
                    params:{
                        nid:v.move_id,
                        ucid:v.move_ucid
                    }
                }).then((r)=>{
                    if (r.data.code == 1) {
                        if (!v.news[v.move_ucid]) {
                            v.news[v.move_ucid] = [];
                        }
                        v.news[v.move_ucid].push(v.news[v.news_class][v.move_key]);
                        v.news[v.news_class].splice(v.move_key,1);             
                    }else{
                        v.$Message.warning(r.data.msg);
                    }   
                }).catch((e)=>{
                    console.log(e);
                });
            },
            go_trash(id,key,type){
                var v = this;
                v.https.get('/front/creation_page/delete_creation',{
                    params:{
                        nid:id
                    }
                }).then((r)=>{
                    if (r.data.code == 1) {
                        v.trash.push(v.news[v.news_class][key])
                        v.news[v.news_class].splice(key,1)    
                    }else{
                        v.$Message.warning(r.data.msg)
                    }   
                }).catch((e)=>{
                    console.log(e)
                });   
                v.is_changed = false               
            },
            edit_class_name(){
                var v = this;
                if (v.edit_cname.length>10) {
                    this.$Message.error('分类名称保持在15个字符之内')
                    return false
                }
                v.https.get('/front/creation_page/rename_class',{
                    params:{
                        ucid:v.edit_id,
                        new_name:v.edit_cname
                    }
                }).then((r)=>{
                    if (r.data.code == 1) {
                        v.author_class = r.data.author_class;
                    }else{
                        v.$Message.warning(r.data.msg);
                    }   
                }).catch((e)=>{
                    console.log(e);
                });                
            },
            add_new_class(){
                var v = this;
                if (v.new_cname.length>10) {
                    this.$Message.error('分类名称保持在15个字符之内')
                    return false
                }
                v.https.get('/front/creation_page/build_class',{
                    params:{
                        cname:v.new_cname
                    }
                }).then((r)=>{
                    v.author_class = r.data;
                }).catch((e)=>{
                    console.log(e);
                });
            },
            choice_class(){
                this.createCreation(2);
            },
            select_article(id){        
                if (id==this.select_nid) {
                    return false
                }
                if (this.is_changed) {
                    this.createCreation(1)
                }                              
                this.select_nid = id;
                    var v = this;
                    v.https.get('/front/creation_page/get_content',{
                        params:{
                            id:id
                        }
                    }).then((r)=>{
                        v.title = r.data.title
                        v.image = r.data.image
                        v.content = r.data.content  
                        v.ucid = r.data.ucid        
                        v.$nextTick(()=>{v.is_changed = false})     
                    }).catch((e)=>{
                        console.log(e);
                    });
            },
            add_article(){
                if (!this.author_class) {
                    this.$Message.warning('请点击新建分类')
                    return false
                }
                if (this.is_changed) {
                    this.createCreation(1)
                }
                this.select_nid = ''
                this.content = ''
                this.title = ''  
                this.image = ''
                this.cid = ''
/*                var myDate = new Date();
                var year = myDate.getFullYear();    //获取完整的年份(4位,1970-????)
                var month = myDate.getMonth() + 1;       //获取当前月份(0-11,0代表1月)
                var date = myDate.getDate(); */ 
                this.title = '我是占位标题，请输入文章标题'//year + '-' + month + '-' + date
                this.count = 0
                this.createCreation(3)
            },
            upload_picture(){
                $('#choice-form input').click()
            },  
            onFileChange: function(e) {
                var file = e.target.files || e.dataTransfer.files;
                if(!file.length) return;
                var v = this
                var file_split = file[0].name.split('.')
                var suffix = file_split[file_split.length - 1]
                if (!/^(jpg|jpeg|png|JPG|PNG)$/.test(suffix)) {
                    this.$Message.error('请上传规定格式的图片')
                    return false
                }
                lrz(file[0]).then((rst)=>{
                    v.cropper.avatar = rst.base64
                    v.cropper.show_cropper = true
                })
                $("#choice-form")[0].reset()
            },      
            get_picture(){
                this.$refs.cropper.getCropData((data) => {
                    let formdata = new window.FormData();
                    formdata.append('picture',data);
                    this.loading = true
                    var func = function(v,path){
                        v.image = path;
                        v.loading = false
                    }
                    this.uploadReq(formdata,func,'/front/creation_page/upload_picture_base64');              
                })      
            },    
            uploadImg: function(e) {
                var file = e.target.files || e.dataTransfer.files;
                let formdata = new window.FormData();
                formdata.append('picture',file[0]);
                var func = function(v,path){
                        v.addImgRange = v.$refs.myQuillEditor.quill.getSelection()
                        v.$refs.myQuillEditor.quill.insertEmbed(v.addImgRange != null?v.addImgRange.index:0, 'image',path)
                }
                this.uploadReq(formdata,func,'/front/creation_page/upload_picture');
                $("#creation-form")[0].reset()
            },
            uploadReq(formdata,func,url){
                var vm =this;
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };
                this.https.post(url,formdata, config).then(
                    (res) => {
                        if (res.data.code == 1) {
                            func(vm,res.data.path);
                        } else {
                            console.log(res.data)
                            vm.$Message.warning('添加图片失败')
                        }
                    }).catch(
                    (err) =>{
                        console.log(err);       
                });
            },
            createCreation(type){
                var v = this;
                if (type == 2&&!this.cid) {
                    this.show_class = true;
                    return false;
                } 
                if (!this.title.trim()) {
                    this.$Message.warning('请设置文章标题！')
                    return false
                }else if(this.title.length>40){
                    this.$Message.warning('文章标题过长，请保证在 40 个字符之内！')
                    return false
                }
                var byself = v.byself?1:0   
                var count = this.$refs.myQuillEditor.quill.getLength();
                let formdata = new window.FormData();
                this.https.post('/front/creation_page/create_creation',{
                    'type':type,
                    'nid':v.select_nid,
                    'ucid':v.news_class,
                    'content':v.content,
                    'count':count,
                    'title':v.title,   
                    'image':v.image,
                    'cid':v.cid,
                    'byself':byself       
                }).then(
                    (res) => {
                        if (res.data.code == 1 ) {
                            if (type == 1) {
                                v.$Message.success('文章已保存更改');
                            }else if(type == 2){
                                v.$Message.success('文章发布成功,等待审核');
                            }/*else if(type == 3){
                                v.$Message.success('创建文章成功');
                            }*/
                            v.select_nid = res.data.id;

                            v.https.get('/front/creation_page/render').then((r)=>{
                
                                v.trash = r.data.author_news[-1]?r.data.author_news[-1]:[];
                                
                                v.news = r.data.author_news[1]?r.data.author_news[1]:[]; 
                                
                                v.author_class = r.data.author_class;

                            }).catch((e)=>{
                                console.log(e);
                            });
                        }else{
                                v.$Message.error(res.data.msg);
                        }  
                        v.$nextTick(()=>{v.is_changed = false}) 
                        v.cid = ''
                    }).catch(
                    (err) =>{
                        console.log(err);       
                });                
            },
            lock_news(id){
                this.https.get('/front/creation_page/lock_news?id='+id)
            }
        }
    }
</script>

<style lang="scss" scoped>
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    ul,li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    #WriteEditor{
        position: relative;
    }
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
            min-height: 80vh;
            .close-preview{
                font-size: 18px;
                margin-top: 20px;
            }
            .news-detail{
                margin: 30px 0 30px 0;
                .news-title{
                    font-size: 28px;
                    color: #333333;
                    font-weight: bold;
                }
                .news-content {
                    padding-top: 30px;
                    font-size: 16px;
                    color: #333;
                    white-space: pre-wrap;
                    text-align: justify;
                }
                .news-footer{
                    padding-top: 50px;
                    .news-footer-content{
                        text-align: center;
                        font-size: 14px;
                        margin-top: 15px;
                    }
                }
            } 
            .signature{
                position: relative;
                img{
                  width: 100%;
                  height: 100%;
                }
            }           
        }
    }    
    .preview-show{
        display: block;
    }
    .WriteEditor {
        height: 100%;
        display: flex;
        flex-direction: row;
        >li {
            text-align: center;
        }
        ::-webkit-scrollbar {
            display: none;
        }
        .editAuthor {
            overflow-y: scroll;
            width: 22%;
            position: fixed;//左边也固定
            top: 0px;//左边也固定
            height: 100%;//左边也固定
            z-index: 100;//左边也固定
            padding: 50px 0 20px 0;
            margin: 0 auto;
            background: #484848;
            color: #fff;
            font-size: .25rem;
            .btn-back {
                margin: 30px 0 20px 0;
                display: inline-block;
                width: 258px;
                font-size: .26rem;
                color: #28b28a;
                text-align: center;
                padding: 14px 15px;
                line-height: .26rem;
                border: 1px solid #28b28a;
                border-radius: 30px;
            }
            .AuthorInfo {
                padding: 20px 0 35px 0;
                img {
                    width: 100px;
                    height: 100px;
                    background: silver;
                    border-radius: 50%;
                }
                .line1{
                    width: 100px;
                    padding: 12px 0 0 0;
                    height: 35px;
                    font-size: 18px;
                    font-weight: 700;
                    text-align: center;

                }
            }
            .folder-tab {
                padding: 0 0 20px 0;
                .edit-class{
                    margin-left: 10px;
                    display: none;
                }
                >li {
                    display: block;
                    height: 46px;
                    text-align: left;
                    padding-left: 38%;
                    font-size: .26rem;
                    line-height: 46px;
                    letter-spacing: 2px;
                    border-left: 4px solid transparent;
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    &:hover, &:focus, &.active {
                        background: rgba(136,136,136,.8);
                        border-left: 4px solid #28b28a;
                    }
                    &:hover{
                        .edit-class{
                            display: inline;
                            cursor: pointer;
                        }
                    }
                }
                .trash{
                    color: #929292;
                    margin-top: 20px;
                    &:hover, &:focus, &.active {
                        color: white;
                    }
                }
                .add-folder {
                    color: #929292;
                    text-align: left;
                    padding-right: 15px;
                    cursor: pointer;
                    transition: all .5s;
                    -webkit-transition: all .5s;
                    -moz-transition: all .5s;
                    -o-transition: all .5s;
                    &:hover, &:focus, &:active {
                        color: #fff;
                        background: none;
                        border-left: 4px solid transparent;
                    }
                    .Icon-plus {
                        font-size: .3rem;
                        padding-right: 5px;
                    }
                }
            }
        }
        .editTab {
            overflow-y: scroll;
            width: 28%;
            position: fixed;//左边也固定
            top: 0px;//左边也固定
            left: 22%;//左边也固定
            height: 100%;//左边也固定
            z-index: 100;//左边也固定
            margin: 0 auto;
            border-right: 1px solid #f2f2f2;
            .panels {
                >li {
                    .folderField {
                        text-align: left;
                        padding: 10px 20px 10px 10px;
                        border-top: 1px solid #f2f2f2;
                        border-right: none;
                        border-left: 4px solid transparent;
                        transition: all .5s;
                        -webkit-transition: all .5s;
                        -moz-transition: all .5s;
                        -o-transition: all .5s;
                        &:hover,&:focus, &.active {
                            background: #f2f2f2;
                            border-left: 4px solid #28b28a;
                        }
                        p {
                            color: #666;
                            font-size: 18px;
                            min-height: 50px;
                        }
                    }
                    .font-count{
                        padding-top: 10px;
                        font-style: normal;
                        font-size: 14px;
                        color: #999; 
                        text-align: left;
                        position: relative;
                        .trash,.folder,.locked,.status-no-sub,.status-sub{
                            font-size: 18px;
                            cursor: pointer;                            
                            position: absolute;
                            right: 0px;
                            display: none;
                        }
                        .locked{
                            right: 60px;
                        }
                        .folder{
                            right: 30px;
                        }
                        .status-no-sub{
                            top: 14px;
                            right: 100px;
                            font-size: 12px;
                            color: #28b28a;
                        }
                        .status-sub{
                            top: 14px;
                            right: 100px;
                            font-size: 12px;
                            color: red;
                        }
                    }
                    &:hover{
                            .trash,.folder,.status-no-sub,.status-sub,.locked{
                                display: inline;
                            } 
                        }
                    .folderField:last-child {
                        border-bottom: 1px solid #f2f2f2;
                    }
                }
            }
            .add-article {
                color: #929292;
                font-size: 18px;
                text-align: left;
                padding: 20px;
                font-weight: bold;
                cursor: pointer;
                transition: all .5s;
                -webkit-transition: all .5s;
                -moz-transition: all .5s;
                -o-transition: all .5s;
                &:hover, &:focus, &:active {
                    color: #666;
                }
                .Icon-plus {
                    font-size: .3rem;
                    padding-right: 5px;
                }
            }
        }
        .hide-zone{
            visibility: hidden;
        }
        .editField {
            width: 50%;
            text-align: left;
            margin: 0 auto;
            margin-left: 50%;//左边也固定          
            >section.img-cover {
                .publish {
                    padding: 8px 20px;
                    text-align: right;
                    border: 1px solid #ddd;
                    line-height: 30px;
                    background: #28b28a;
                    color: #fff;
                    position: fixed;
                    top: 0px;
                    width: 50%;
                    z-index: 100;
                    >a {
                        display: inline-block;
                        margin-right: 15px;
                        padding: 5px;
                        line-height: 2;
                        font-size: .28rem;
                        color: rgba(255,255,255,.8);
                        transition: all .5s;
                        -webkit-transition: all .5s;
                        -moz-transition: all .5s;
                        -o-transition: all .5s;
                        .Ico-save, .Ico-send ,.Ico-preview{
                            padding-right: 5px;
                            font-size: .35rem;
                            vertical-align: middle;
                        }
                        &:hover, &:focus, &.active {
                            color: rgba(255,255,255,1);
                        }
                    }
                }
                .img-container {
                    margin-top: 60px;
                    width: 100%;
                    min-height: 200px;
                    padding: 5px;
                    >li {
                        display: inline-block;
                    }
                    li:first-child {
                        margin-right: 10px;
                        width: 322px;
                        height: 202px;
                        background: #f7f7f7;
                        line-height: 200px;
                        text-align: center;
                        border: 1px dashed #28a28b;
                        position: relative;
                        &::before {
                            content: '请上传封面图片';
                            display: inline-block;
                            position: absolute;
                            top: 0;
                            left: 30%;
                            font-size: .28rem;
                            color: #888;
                            z-index: 1;
                        }
                        img {
                            position: absolute;
                            top: 0;
                            left: 0;
                            z-index: 2;
                            width: 320px;
                            height: 200px;
                        }
                    }
                    li:last-child {
                        margin-right: 0;
                        margin-left: 30px;
                        >p {
                            font-size: .26rem;
                            color: #666;
                        }
                        >a.file {
                            position: relative;
                            display: inline-block;
                            background: #28b28a;
                            border: 1px solid #28b28a;
                            border-radius: 4px;
                            padding: 4px 12px;
                            overflow: hidden;
                            color: #fff;
                            text-decoration: none;
                            text-indent: 0;
                            line-height: 26px;
                            font-size: .27rem;
                            cursor: pointer;
                        }
                        .file input {
                            position: absolute;
                            font-size: 100px;
                            right: 0;
                            top: 0;
                            opacity: 0;
                            cursor: pointer;
                        }
                        .file:hover {
                            background: #179772;
                            border-color: #179772;
                        }
                    }
                }
            }
            >section.txt-title {
                border-top: 1px solid #f2f2f2;
                .edit-title {
                    font-size: .38rem;
                    color: #333;
                    height: 50px;
                }
            }
            .ql-editor{
                height: 10rem;
            }
        }
    }

</style>