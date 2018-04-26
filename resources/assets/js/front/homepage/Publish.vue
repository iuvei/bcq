<template>
	<div id="publish">
	    <Card style="width:450px" class="img-frame" v-if="add_images">
	        <div class="frame-zone">
	        	<div class="tag"></div>
	        	<div class="img-zone">
	        		<Row>
		        		<Col :xs="24" :sm="24" :lg="24" :class-name="'img-zone-title'">
		        			<b>本地上传</b>
		        			<span class="close pointer" @click="add_images=false;micro.img=[]"><Icon type="close"></Icon></span>
		        		</Col>
		        		<Col :xs="24" :sm="24" :lg="24">
		        			<p style="margin-top:5px;color:#a7a7a7">共{{micro.img.length}}张，还能上传{{9-micro.img.length}}张</p>
		        		</Col>
		        		<Col :xs="8" :sm="8" :lg="8" :class-name="'img-item-frame pointer'" v-for="(item,key) in micro.img" :key="key"  v-bind:style="{'background-image':'url('+item+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}">
 		        			<!-- <img v-bind:src="item"> -->
 		        			<span class="delete-img" @click="delete_img(key)">
 		        				<Icon type="close-circled" color="red"></Icon>
 		        			</span>
		        		</Col>		        				        		
		        		<Col :xs="8" :sm="8" :lg="8" :class-name="'add-img-item-frame pointer'" v-if="micro.img.length<9">
		        			<img src="/static/add_img.png" @click="add_img">
		        		</Col>
		        	</Row>
		        	<form id="choice-form" style="display:none">
					    <input type="file" accept="image/jpeg,image/png" name="file" @change="onFileChange">
					</form>
	        	</div>
	        </div>
	    </Card>
		<Tabs v-model="publish" @on-click="change_panel" class="tab-weight-nomal">
	        <TabPane label="发布微动态" :name="'micro'" class="micro">
	        	<a href="/user/write" target="_blank">
	        	<span class="warning-frame" v-if="micro_count>200&&publish=='micro'">想更专业的发布文章?点击这里加入作者</span>
	        	</a>
	        	<div class="textarea-frame">
	        		<textarea placeholder="欢迎您登陆会员，请问今天有什么事情跟大家分享呢？(备注：请勿发放广告讯息，发送后经管理员多次删除不听警告，会进行封号处置)" v-model="micro.content" style="border:0px"></textarea>
	        		<span class="count-tag">10-500字</span>
	        	</div>
	        	<div class="action-frame">
		        	<div class="action">
		        		<Checkbox class="common-checkbox" v-model="add_images" @on-change="img_swich">附上图片</Checkbox>  		
		        	</div>
		        	<div class="submit common-button" v-bind:class="{'dis-publish':micro_count>500||micro_count<10}" @click="sub_micro">发&nbsp&nbsp布</div>
	        	</div>	
	        </TabPane>
	        <TabPane label="发布问答" :name="'question'" class="question">
	        	<div class="textarea-frame">
		        	<input placeholder="请输入问题标题(10-30字)" v-model="queston.title" style="border:0px"/>
		        	<div style="height:0;border:1px solid #dddee1;"></div>
		        	<textarea placeholder="添加问题背景描述" v-model="queston.describe" style="border:0px"></textarea>
	        	</div>
	        	<div class="action-frame">
		        	<div class="action">
		        		<a target="_blank" href="/questionpage">更多回答</a>
		        	</div>
		        	<div class="submit common-button" @click="sub_question">发&nbsp&nbsp布</div>
	        	</div>	        	
	        </TabPane>
	    </Tabs>
<!-- 	    <Modal
	        v-model="cropper.show_cropper"
	        title="截取头像图片"
	        @on-ok="get_picture"
	        :ok-text="'截取'"
	        :cancel-text="'取消'"
	        :width="550" :height="450">
			<vueCropper
				ref="cropper"
				:img="cropper.avatar"
				:autoCrop="cropper.autoCrop"
				:autoCropWidth="cropper.autoCropWidth"
				:autoCropHeight="cropper.autoCropHeight"
				:fixedBox="cropper.fixedBox" style="width:500px;height:400px;">
			</vueCropper>
	    </Modal> -->	    
	</div>
</template>
<script>
import VueCropper from 'vue-cropper'
import lrz from 'lrz'
import $ from 'jquery'
export default{
	components: {VueCropper},	
	mounted(){

	},
	data(){
		return {
			publish:'micro',
			cropper: {
				avatar: '',
				autoCrop: true,
				autoCropWidth: 480,
				autoCropHeight: 300,
				fixedBox: true,
				show_cropper:false
			},	
			queston:{
				title:'',
				describe:''
			},	
			micro:{
				img:[],
				content:''
			},	
			add_images:false,
			upload_router:'/front/home/upload_image'							
		}
	},
	computed:{
		micro_count(){
			return this.micro.content.length
		}
	},
	methods:{
		change_panel(){
			this.add_images = false
		},
		sub_micro(){
			
			if (this.micro_count>500) {
				this.$Message.warning('字数请保持在500字之内')
				return false
			}
			
			if (this.micro_count<10) {
				this.$Message.warning('字数要在10字以上')
				return false
			}

			var v = this

			v.micro.content = v.micro.content.replace(/\n/g,'<br/>');

			v.https.post('/front/micro/new_micro',{
				micro:v.micro
			}).then((r)=>{
				if (r.data.code==1) {
					v.$Message.success(r.data.msg)
					v.micro.content = ''
					v.add_images = false
					v.micro.img=[]
					v.$emit('pubmicro')
				}else{
					v.$Message.warning(r.data.msg)
				}
			}).catch((e)=>{
				console.log(e)
			}) 
		},
		sub_question(){
			var v = this;
			if (!v.queston.title.trim()) {
				v.$Message.warning('问题不得为空');
			}
			if (v.queston.title.length>30) {
				v.$Message.success('问题标题保持在30字之内')
				return false
			}
			if (v.queston.describe.length>500) {
				v.$Message.success('描述字数太长，请保证在500字之内')
				return false
			}
			v.https.post('/front/question/new_question',{
				title:v.queston.title,
				describe:v.queston.describe
			}).then((r)=>{
				if (!r.data.code) {
					v.$Message.error(r.data.msg);
				}else{
					v.queston.title = ''
					v.queston.describe = ''
					v.$Message.success(r.data.msg);
				}
			}).catch((e)=>{
				console.log(e)
			})
		},
		img_swich(e){
			if (e) {
				this.add_images = true
			}else{
				this.add_images = false
				this.micro.img=[]
			}
		},
		delete_img(key){
			this.micro.img.splice(key,1)
		},
		add_img(){
			$('#choice-form input').click()
			this.upload_image = '/front/home/upload_image'
		},
		onFileChange(e){
            var file = e.target.files || e.dataTransfer.files;
            if(!file.length) return false
            if (file[0].size>5*1024*1024) {
            	this.$Message.warning('图片大小不得超过5M')
	       		$("#choice-form")[0].reset()
            	return false
            }
            var v = this
	        lrz(file[0]).then((rst)=>{
/*	        	v.cropper.avatar = rst.base64
	        	v.cropper.show_cropper = true*/
	        	let formdata = new window.FormData();
	        	formdata.append('image',rst.base64);
	        	var func = function(v,path){
	        		v.micro.img.push(path)
	            }
	            v.uploadReq(formdata,func);		
		        $("#choice-form")[0].reset()
	        })
		},
/*		get_picture(){
			this.$refs.cropper.getCropData((data) => {
				let formdata = new window.FormData();
	        	formdata.append('image',data);
	        	var func = function(v,path){
	        		v.micro.img.push(path)
	            }
	            this.uploadReq(formdata,func);				
			})		
		},  */
        uploadReq(formdata,func){
            var v =this;
            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            };
            this.https.post(v.upload_router,formdata, config).then(
                (res) => {
                    if (res.data.code == 1) {
                        func(v,res.data.path)
                    } else {
                        v.$Message.warning(res.data.msg)
                    }
                }).catch(
                (err) =>{
                    console.log(err);       
            });
        }					
	}
}
</script>
<style lang="scss" scoped>
#publish{
	position: relative;
	.img-frame{
		position: absolute;
		z-index: 100;
		top:235px;
		.tag{
			position: absolute;
			top: -4px;
			left: 50px;
			box-shadow: 0 2px 15px rgba(0,0,0,.4);
			transform:rotate(45deg);
			-ms-transform:rotate(45deg); 	
			-moz-transform:rotate(45deg); 	
			-webkit-transform:rotate(45deg);
			-o-transform:rotate(45deg);
			background-color: #fff; 	
			width: 20px;
			height: 20px;			
		}
		.img-zone{
			position: absolute;
			top: 0;
			left: 0;
			padding: 15px;
			width: 100%;
			min-height: 250px;
			background-color: #fff;
			z-index: 10;
			box-shadow: 0 2px 15px rgba(0,0,0,.12);
			font-size: 14px;
			.img-zone-title{
				position: relative;
				.close{
					color: #dddddd;
					position: absolute;
					right: 10px;
				}
			}
			.img-item-frame{
				position: relative;
				height: 95px;
				padding: 10px;
				overflow: hidden;
				img{
					width: 100%;
/* 					height: 100%; */
				}
				.delete-img{
					position: absolute;
					top: 10px;
					right: 10px;
				}
			}
			.add-img-item-frame{
				height: 95px;
				padding: 10px 0 0 0;
			}
		}
	}	
}
.action-frame{
	position: flex;
	display: -webkit-flex;
	flex-direction:row;
	flex-wrap:wrap;
	height: 50px;
	.action{
		width: 80%;
		padding: 15px 0 0 15px;
		font-size: 14px;
		color: #333333;
		font-weight: bold;
		a{
			color: #333333;
		}		
	}
	.dis-publish{
		background: #93d8c4!important;
	}
	.submit{
		width: 20%;
		font-size: 16px;
		text-align: center;
		vertical-align: middle;
		line-height: 40px;
		cursor: pointer;
	}
}
.warning-frame{
	position: absolute;
	right: 10px;
	top: -25px;
	color: #ff7b34;
	z-index: 100;
}
.textarea-frame{
	height: 150px;
	position: relative;
	.count-tag{
		position: absolute;
		bottom: 10px;
		right: 5px;
		width: 70px;
		height: 20px;
		text-align: center;
		line-height: 20px;
		border-radius: 10px;
		color: white;
		background-color: black;
		opacity: 0.3;
	}
}
textarea{
	padding: 15px;
	font-size: 14px;
	background-color: #f7f7f7;
	border:1px solid #e8e8e8;
}
.micro{
	textarea{
		height: 150px;
		max-height: 150px;
		width: 100%;
	}
}
.question{
	input{
		padding: 15px;
		height: 50px;
		width: 100%;
		font-size: 14px;
		background-color: #f7f7f7;		
		border:1px solid #e8e8e8;
	}
	textarea{
		height: 100px;
		max-height: 100px;
		width: 100%;
	}
}
</style>