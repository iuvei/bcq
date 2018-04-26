<template>
	<div id="enterprise">
    	<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <!--<Row type="flex" justify="space-between">-->
                    <!--<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">-->
            		    <!--<div class="bread">-->
							<!--<div class="bread-text"><a href="/">首页</a> > <a>资料</a> > <a>企业库</a> > 添加企业库 </div>-->
						<!--</div>-->
                    <!--</Col>-->
                <!--</Row>-->

				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资料</BreadcrumbItem>
					<BreadcrumbItem to="/userdata/Enterprise">企业库</BreadcrumbItem>
					<BreadcrumbItem>添加企业库</BreadcrumbItem>
				</Breadcrumb>

				<Row type="flex" :class-name="'add-cash'">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'cash-box'">
						<Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="200">
							<FormItem label="企业名称:" prop="title">
								<Input v-model="formValidate.title" size="large" style="width: 620px" placeholder="请输入企业名称" ></Input>
							</FormItem>
							<FormItem label="企业规模" prop="scale">
								<Select v-model="formValidate.scale" style="width: 160px" placeholder="企业规模">
									<Option :value="val.val" v-for="(val,index) in scaleList" :key="index">{{val.name}}</Option>
								</Select>
							</FormItem>
							<FormItem label="所在地区:" prop="region">
								<Select v-model="formValidate.region" size="large" style="width: 160px" placeholder="所在地">
									<Option :value="val.val" v-for="(val,index) in regionList" :key="index">{{val.name}}</Option>
								</Select>
							</FormItem>
							<FormItem label="博招聘外链地址:" prop="url">
								<Input v-model="formValidate.url" type="text" size="large" style="width: 620px" placeholder="请输入网址"></Input>
							</FormItem>
							<FormItem label="企业介绍:" prop="content">
								<Input v-model="formValidate.content" type="textarea" :autosize="{minRows: 10,maxRows: 30}" style="width: 620px" placeholder="写一段话介绍企业吧"></Input>
							</FormItem>
                            <FormItem label="企业LOGO:" prop="logo">
                                <ul class="img-container">
                                    <li v-model="formValidate.logo">
                                        <img v-bind:src="image" v-if="image">
                                    </li>
                                    <li>
                                        <a href="javascript:;" class="file">上传图片
                                            <input type="file" accept="image/jpeg,image/png,image/gif" name="file" @change="onFileChange">
                                        </a>
                                        <p style="color: #e4393c;padding-right: 3px;">185*76像素</p>
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
	export default {
		components: {NavHeader,FooterArea,FloatSideBar},
        mounted(){
            document.title = '菠菜圈| 添加企业库';
            var v = this;
            this.https.get('/front/enterprise/add_enterprise').then((r)=>{
                v.scaleList = r.data.scaleList;
                v.regionList = r.data.regionList;
            }).catch((e)=>{
                console.log(e);
            });
        },
		data(){
			return {
			    scaleList: '',
                regionList:'',
                image:'',
                addImgRange:'',
                formValidate: {
                    title: '',
                    scale: '',
                    region: '',
                    url: '',
                    content: '',
                    logo: ''
                },
                ruleValidate: {
                    title: [
                        { required: true, message: '企业名称不能为空', trigger: 'blur' }
                    ],
                    scale: [
                        { required: true, type: 'number', message: '企业规模不能为空', trigger: 'change' },
                    ],
                    region: [
                        { required: true, type: 'number', message: '所在地不能为空', trigger: 'change' }
                    ],
                    url: [
                        { required: true, message: '博招聘外链地址不能为空', trigger: 'blur' },
                        { type: 'url', message: '请输入一个网址', trigger: 'blur' }
                    ],
                    content: [
                        { required: true, message: '企业介绍不能为空', trigger: 'blur' },
                        { type: 'string', min: 20, message: '企业介绍不能少于20个字', trigger: 'blur' }
                    ],
                    logo: [
                        { required: true, message: '请上传企业LOGO' }
                    ],
                }
			}
		},
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        var v = this;
                        this.https.post('/front/enterprise/add_enterprise',{
                            title: v.formValidate.title,
                            scale: v.formValidate.scale,
                            region: v.formValidate.region,
                            url: v.formValidate.url,
                            content: v.formValidate.content,
                            logo: v.formValidate.logo,

                        }).then((r)=>{
                            if(r.data.code){
                                v.$Message.success(r.data.msg);
                                setTimeout(function () {
                                    v.$router.push(`/userdata/Enterprise`);
                                },2000);
                            }else {
                                v.$Message.warning(r.data.msg);
                            }
                        }).catch(function (error) {
                            let replace = {
                                scale: '企业规模',
                                region: '所在地区',
                                title: '企业名称',
                                content: '企业介绍',
                                url: '博招聘外链'
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
                let formdata = new window.FormData();
                formdata.append('picture',file[0]);
                var func = function(v,path){
                    v.image = path;
                }
                this.uploadReq(formdata,func);
            },
            uploadImg: function(e) {
                var file = e.target.files || e.dataTransfer.files;
                let formdata = new window.FormData();
                formdata.append('picture',file[0]);
                var func = function(v,path){
                    v.addImgRange = v.$refs.myQuillEditor.quill.getSelection()
                    v.$refs.myQuillEditor.quill.insertEmbed(v.addImgRange != null?v.addImgRange.index:0, 'image',path)
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
            },
        }
	}
</script>
<style lang="scss" scoped>
	#enterprise {
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
