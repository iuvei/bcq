<template>
	<div id="cash">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem to="/userdata/Cash">现金网</BreadcrumbItem>
					<BreadcrumbItem>添加现金网</BreadcrumbItem>
				</Breadcrumb>

				<Row type="flex" :class-name="'add-cash'">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'cash-box'">
						<Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="160">
							<FormItem label="网站名称:" prop="title">
								<Input v-model="formValidate.title" size="large" style="width: 620px" placeholder="请输入网站名称" ></Input>
							</FormItem>
							<FormItem label="接入平台:" prop="access">
								<CheckboxGroup v-model="formValidate.access" :class="'common-checkbox'">
									<Checkbox :label="val.val" v-for="(val,index) in accessList" :key="index">{{val.name}}</Checkbox>
								</CheckboxGroup>
							</FormItem>
							<FormItem label="经营游戏:" prop="games">
                                <CheckboxGroup v-model="formValidate.games" :class="'common-checkbox'">
                                    <Checkbox :label="val.val" v-for="(val,index) in gameList" :key="index">{{val.name}}</Checkbox>
                                </CheckboxGroup>
							</FormItem>
							<FormItem label="所在地区:" prop="region">
								<Select v-model="formValidate.region" size="large" style="width: 160px" placeholder="所在地">
									<Option :value="val.val" v-for="(val,index) in regionList" :key="index">{{val.name}}</Option>
								</Select>
							</FormItem>
							<FormItem label="网站介绍:" prop="content">
								<Input v-model="formValidate.content" type="textarea" :autosize="{minRows: 10,maxRows: 30}" style="width: 620px" placeholder="写一段话介绍公司吧"></Input>
							</FormItem>
							<FormItem label="网址1:" prop="url1">
								<Input v-model="formValidate.url1" type="text" size="large" style="width: 620px" placeholder="请输入网址"></Input>
							</FormItem>
							<FormItem label="网址2:" prop="url2">
								<Input v-model="formValidate.url2" type="text" size="large" style="width: 620px" placeholder="请输入网址"></Input>
							</FormItem>
							<FormItem label="网址3:" prop="url3">
								<Input v-model="formValidate.url3" type="text" size="large" style="width: 620px" placeholder="请输入网址"></Input>
							</FormItem>
							<FormItem label="网址4:" prop="url4">
								<Input v-model="formValidate.url4" type="text" size="large" style="width: 620px" placeholder="请输入网址"></Input>
							</FormItem>
                            <FormItem label="网站LOGO:" prop="logo">
                                <ul class="img-container">
                                    <li v-model="formValidate.logo">
                                        <img v-bind:src="formValidate.logo" v-if="formValidate.logo">
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="file">上传图片
                                            <form id="choice-form">
                                                <input type="file" accept="image/jpeg,image/png,image/gif" name="file" @change="onFileChange">
                                            </form>
                                        </a>
                                        <p style="color: #e4393c;padding-right: 3px;">100*100像素</p>
                                    </li>
                                </ul>
                            </FormItem>
							<FormItem>
								<button type="button" class="submit-button" @click="handleSubmit('formValidate')">提交</button>
							</FormItem>
						</Form>
					</Col>
				</Row>
            </Col>
		</Row>
		<FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>
        <Modal
            v-model="cropper.show_cropper"
            title="截取头像图片"
            @on-ok="get_picture"
            :ok-text="'截取'"
            :cancel-text="'取消'"
            :width="500">
            <vueCropper
                ref="cropper"
                :img="cropper.avatar"
                :autoCrop="cropper.autoCrop"
                :autoCropWidth="cropper.autoCropWidth"
                :autoCropHeight="cropper.autoCropHeight"
                :fixedBox="cropper.fixedBox" style="width:400px;height:400px;">                                 
            </vueCropper>
        </Modal>        
	</div>
</template>

<script>
import PageRight from '../components/MainRight.vue';
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import lrz from 'lrz';
import Vue from 'vue';
import $ from 'jquery';
import VueCropper from 'vue-cropper'
	export default {
		components: {NavHeader,FooterArea,FloatSideBar,VueCropper},
        mounted(){
            document.title = '菠菜圈| 添加现金网';
            var v = this;
            this.https.get('/front/cash/add_cash').then((r)=>{
                v.accessList = r.data.accessList;
                v.regionList = r.data.regionList;
                v.gameList = r.data.gameList;
            }).catch((e)=>{
                console.log(e);
            });
        },
		data(){
			return {
                cropper: {
                    avatar: '',
                    autoCrop: true,
                    autoCropWidth: 100,
                    autoCropHeight: 100,
                    fixedBox: true,
                    show_cropper:false
                },                  
                accessList: '',
                regionList: '',
                gameList: '',
			    title: '',
                addImgRange:'',
                formValidate: {
                    title: '',
                    access: [],
                    games: [],
                    region: '',
                    content: '',
                    url1: '',
                    url2: '',
                    url3: '',
                    url4: '',
                    logo: '',
                },
                ruleValidate: {
                    title: [
                        { required: true, message: '现金网名称不能为空', trigger: 'blur' }
                    ],
                    access: [
                        { required: true, type: 'array', min: 1, message: '至少选择一个接入平台', trigger: 'change' },
                    ],
                    games: [
                        { required: true, type: 'array', min: 1, message: '至少选择一个游戏类型', trigger: 'change' }
                    ],
                    region: [
                        { required: true, type: 'number', message: '所在地不能为空', trigger: 'change' }
                    ],
                    url1: [
                        { required: true, message: '该网址不能为空', trigger: 'blur' },
                        { type: 'url', message: '请输入一个网址', trigger: 'blur' }
                    ],
                    url2: [
                        { required: false, type: 'url', message: '请输入一个网址', trigger: 'blur' }
                    ],
                    url3: [
                        { required: false, type: 'url', message: '请输入一个网址', trigger: 'blur' }
                    ],
                    url4: [
                        { required: false, type: 'url', message: '请输入一个网址', trigger: 'blur' }
                    ],
                    content: [
                        { required: true, message: '公司介绍不能为空', trigger: 'blur' },
                        { type: 'string', min: 20, message: '公司介绍不能少于20个字', trigger: 'blur' }
                    ],
                    logo: [
                        { required: false, message: '公司LOGO不能为空' }
                    ],
                }
			}
		},
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        var v = this;
                        this.https.post('/front/cash/add_cash',{
                            title: v.formValidate.title,
                            access: v.formValidate.access,
                            games: v.formValidate.games,
                            region: v.formValidate.region,
                            content: v.formValidate.content,
                            url1: v.formValidate.url1,
                            url2: v.formValidate.url2,
                            url3: v.formValidate.url3,
                            url4: v.formValidate.url4,
                            logo: v.formValidate.logo
                        }).then((r)=>{
                            if(r.data.code){
                                v.$Message.success(r.data.msg);
                                setTimeout(function () {
                                    v.$router.push(`/userdata/Cash`);
                                },2000);
							}else {
                                v.$Message.warning(r.data.msg);
                            }
                        }).catch(function (error) {
                            let replace = {
                                title: '现金网名称',
                                access: '接入平台',
                                games: '游戏类型',
                                region: '所在地',
                                url1: '网址1',
                                url2: '网址2',
                                url3: '网址3',
                                url4: '网址4',
                                content: '网站介绍',
                            };
                            if (error.response.status == 422){
                                $.each(error.response.data.errors,function (index,val) {
                                    v.$Message.warning(val[0].replace(index,replace[index]));
                                })
                            }else {
                                v.$Message.warning('服务器错误!');
                            }
                        });
                    }
                })
            },
            handleReset (name) {
                this.$refs[name].resetFields();
            },
            onFileChange: function(e) {
                var file = e.target.files || e.dataTransfer.files;
                if(!file.length) return;
                var v = this
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
                    var func = function(v,path){
                        v.formValidate.logo = path
                    }
                    this.uploadReq(formdata,func);              
                })      
            },     
            uploadReq(formdata,func){
                var vm =this;
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };
                this.https.post('/front/trade/upload_picture',formdata, config).then(
                    (res) => {
                        if (res.data.code == 1) {
                            func(vm,res.data.path)
                        } else {
                            vm.$Message.warning('更换图片失败')
                        }
                    }).catch(
                    (err) =>{
                        console.log(err);       
                });
            }    
                      
/*            onFileChange: function(e) {
                var file = e.target.files || e.dataTransfer.files;
                if(!file.length) return;
                let formdata = new window.FormData();
                formdata.append('picture',file[0]);
                var func = function(v,path){
                    v.image = path;
                }
                this.uploadReq(formdata,func);
            },
            uploadReq(formdata,func){
                var vm =this;
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };
                this.https.post('/front/creation_page/upload_picture',formdata, config).then(
                    (res) => {
                        if (res.data.code == 1) {
                            func(vm,res.data.path);
                        } else {
                            vm.$Message.warning('添加图片失败')
                        }
                    }).catch(
                    (err) =>{
                        console.log(err);
                    });
            },*/
        }
	}
</script>
<style lang="scss" scoped>
	#cash {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
		.container {
			width: 1200px;
			margin: 20px auto;
			min-height: 80vh;
			.add-cash {
				margin: 50px 0 30px 0;
				.cash-box {
					font-size: .28rem;
                    width: 80%;
                    margin: 0 auto;
				}
			}
            .img-container {
                width: 100%;
                height: 100%;
                padding: 10px;
                >li {
                    display: inline-block;
                }
                li:first-child {
                    margin-right: 10px;
                    width: 100px;
                    height: 100px;
                    background: #f7f7f7;
                    line-height: 100px;
                    text-align: center;
                    border: 1px dashed #28a28b;
                    position: relative;
                    &::before {
                        content: 'LOGO图片';
                        display: inline-block;
                        position: absolute;
                        top: 0;
                        left: 0;
                        margin-left: 12px;
                        font-size: .25rem;
                        color: #888;
                        z-index: 1;
                    }
                    img {
                        position: absolute;
                        top: 0;
                        left: 0;
                        z-index: 2;
                        width: 100px;
                        height: 100px;
                    }
                }
                li:last-child {
                    margin-right: 0;
                    margin-left: 30px;
                    >p {
                        font-size: .25rem;
                        color: #666;
                    }
                    >a.file {
                        position: relative;
                        display: inline-block;
                        background: #38be97;
                        border: 1px solid #38be97;
                        border-radius: 4px;
                        padding: 4px 12px;
                        overflow: hidden;
                        color: #fff;
                        text-decoration: none;
                        text-indent: 0;
                        line-height: 25px;
                        font-size: .25rem;
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
                        background: #149f77;
                        border-color: #149f77;
                    }
                }
            }
		}
	}
</style>
