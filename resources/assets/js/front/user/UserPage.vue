<template>
<div id="userpage">
	<NavHeader ref="header"></NavHeader>
	<Row type="flex" justify="center">
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
        	<Row  type="flex" justify="space-between">
        		<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
        			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-intro user-pannel'">
        				<Col :xs="{'span':12,'offset':6}" :sm="{'span':12,'offset':6}" :lg="{'span':12,'offset':6}" :class-name="'user-avatar'">
        					<div class="avatar-frame-new">
        						<div class="mask">更换头像</div>
        						<img v-bind:src="user_info.image" @click="change_avatar">
        					</div>
        				</Col>
        				<Col :xs="6" :sm="6" :lg="6">
        					<ul class="user-set">
        						<li @click="edit=false;active_tab=4"><Icon type="ios-gear-outline"></Icon></li>
        						<li @click="active_tab=5;mails=0"><Icon type="ios-email-outline" v-bind:class="{'has-mail':mails}"></Icon></li>
        					</ul>
        				</Col>
        				<Col :xs="24" :sm="24" :lg="24" :class-name="'userinfo'">
        					<div class="username">
        						<span v-bind:class="{'is_author':author_info.code}">{{user_info.username}}</span>
        					</div>
        					<div class="userdesc">
        						{{user_info.desc}}
        					</div>
        				</Col>
        				<Col :xs="12" :sm="12" :lg="12" :class-name="'reward'">
        					<p>我的收益</p>
        					<span @click="active_tab=8">{{income_total}}</span>
        					<div class="break-line"></div>
        				</Col>
        				<Col :xs="12" :sm="12" :lg="12" :class-name="'reward'">
        					<p>菠菜种子</p>
        					<span @click="active_tab=6">{{user_info.price}}</span>
        				</Col>
        			</Col>
        			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'user-tab user-pannel'">
        				<div class="left-tab" v-bind:class="{'left-active':active_tab==4}" @click="edit=true;active_tab=4">	个人信息
        				</div>
        				<div class="left-tab" v-bind:class="{'left-active':active_tab==7}" @click="active_tab=7">	签名设置
        				</div>
         				<div class="left-tab" v-bind:class="{'left-active':active_tab==8}" @click="active_tab=8">收益提成
        				</div>
        				<div class="left-tab" v-bind:class="{'left-active':active_tab==2}" @click="active_tab=2">	我的收藏
        				</div>
        				<div class="left-tab" v-bind:class="{'left-active':active_tab==3}" @click="active_tab=3">	我的发布
        				</div>
        				<div class="left-tab" @click="go('/user/userzone/' + user_info.id)">作者主页</div>
        			</Col>
        		</Col>        		
        		<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
	        		<div class='user-tab-content user-pannel'>
						<div v-if="active_tab==2">
							<Collection></Collection>
						</div>	
						<div v-if="active_tab==3">
							<Publish></Publish>
						</div>
						<div v-if="active_tab==4">
							<Tabs value="name1">
						        <TabPane label="修改个人信息" name="name1">
						        	<Row :class-name="'user-info'" type="flex" align="middle" >
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				昵&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp称&nbsp：
					        			</Col>
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit" placeholder="请输入您的昵称（不得为空）" v-model="user_info.username"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				个人简介：
					        			</Col>
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit" placeholder="这个人很懒，都没有个人简介。。。" v-model="user_info.brief"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>	
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				个人标签：
					        			</Col>
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit||author_info.code?true:false" placeholder="给自己添加个酷炫的标签吧" v-model="user_info.desc"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>				        			
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				微&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp信&nbsp：	
					        			</Col>
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit" placeholder="微信号" v-model="user_info.wechat"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>				        				
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				SKYPE&nbsp&nbsp：	
					        			</Col>					        										
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit" placeholder="SKYPE"  v-model="user_info.skype"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>        			
										<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				Q&nbsp&nbspQ&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp：	
					        			</Col>					        										
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit" placeholder="QQ号码" v-model="user_info.qq"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>        							        			
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				从事工作：	
					        			</Col>			        			
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input :disabled="edit"  placeholder="您的职业" v-model="user_info.job"></Input>
					        			</Col>	
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>					        						        			       
					        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'modify-input'">
					        				所在地区：
					        			</Col>
					        			<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'modify-input'">
					        				<Input  :disabled="edit" placeholder="您所在的地区" v-model="user_info.city"></Input>
					        			</Col>
					        			<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}" :class-name="'modify-input'">&nbsp</Col>
					        			<Col :xs="{'span':5,'offset':7}" :sm="{'span':5,'offset':7}" :lg="{'span':5,'offset':7}">
					        				<Button class="common-button3" :disabled="edit" @click="modeify_info">提交</Button>
					        			</Col>
						        	</Row>
						    	</TabPane>
						    </Tabs>
						</div>					
						<div v-if="active_tab==5">
							<Mail></Mail>
						</div>
						<div v-if="active_tab==6">
							<Record></Record>
						</div>
						<div v-if="active_tab==7">
							<div class="signature-title">
								签名设置
							</div>
							<div>
					            <Row type="flex" justify="center">
					              <Col :xs="{'span':10}" :sm="{'span':10}" :lg="{'span':10}">
						              <div class="news-footer-content">· END ·</div>
						              <div class="news-footer-content">本文由菠菜圈-作者刊登，版权归原作者所有，</div>
						              <div class="news-footer-content">未经授权，请勿转载，谢谢！</div>	
					              </Col>
					              <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
				                    <ul class="img-container pointer">
	 			                        <li @click="change_signature">
				                            <img v-bind:src="signature_img" v-if="signature_img">
				                        </li>
				                    </ul>	
				                    <ul class="reset_signature"><a @click="signature_img=''">重置签名档</a></ul>
				                    <ul class="signature_url">
				                    	<li>签名档链接：</li>
				                    	<li>
				                    		<Input v-model="signature_url" class="common-iview-input">
												<Select v-model="http" slot="prepend" style="width: 80px">
													<Option value="http://">http://</Option>
													<Option value="https://">https://</Option>
												</Select>
											</Input>
				                    	</li>
				                    </ul>	              	
					              </Col>
					              <Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class="'submit_signature'">
										<Button class="common-button3" @click="submit_signature">提交</Button>	
					              </Col>
					            </Row>						
							</div>
						</div>	
						<div v-if="active_tab==8">
							<Income :authorinfo="author_info"></Income>
						</div>	        			
	        		</div>
						      			
        		</Col>
        	</Row>
    	</Col>
    </Row>
	<li>
		<form id="choice-form" style="display:none">
		    <input type="file" accept="image/jpeg,image/png,image/gif" name="file" @change="onFileChange">
		</form>
	</li>
	<FooterArea></FooterArea>
    <Modal
        v-model="cropper.show_cropper"
        title="截取头像图片"
        @on-ok="get_picture"
        :ok-text="'截取'"
        :cancel-text="'取消'"
        :width="910">
		<vueCropper
			ref="cropper"
			:img="cropper.avatar"
			:autoCrop="cropper.autoCrop"
			:autoCropWidth="cropper.autoCropWidth"
			:autoCropHeight="cropper.autoCropHeight"
			:fixedBox="cropper.fixedBox" style="width:880px;height:300px;">
		</vueCropper>
    </Modal>	
</div>
</template>
<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import Mail from './Mail.vue'
import Collection from './Collection.vue'
import Publish from './Publish.vue'
import Record from './Record.vue'
import Income from './Income.vue'
import VueCropper from 'vue-cropper'
import lrz from 'lrz'
import check from '../common/check.js'
import $ from 'jquery';
var get_mail_count ;
export default{
	components: {NavHeader,FooterArea,Mail,Collection,Publish,Record,Income,VueCropper},
	mounted(){
		document.title = '个人中心';
		var v = this;
        v.active_tab = v.$route.params.tab?v.$route.params.tab:4;
		this.https.get('/front/user_center/user_info_render').then((r)=>{
			if (r.data.code) {
				v.user_info = r.data.render.user_info
				v.income_total = r.data.render.income_total
				v.author_info = r.data.render.author_info
				v.mails = r.data.render.mails
				v.signature_img = r.data.render['user_info'].signature
				v.signature_url = r.data.render['user_info'].sign_url.replace(/(http:\/\/|https:\/\/)/,'') 
				if (/(https:\/\/)/.test(r.data.render['user_info'].sign_url)) {
					v.http = 'https://'
				} 				
			}else{
				v.$router.go(-1);
			}
		}).catch((e)=>{
			console.log(e);
		});
	},
	data(){
		return {
			edit:true,
			active_tab:4,
			user_info:'',
			author_info:'',
			income_total:0,
			mails:0,
			is_send:false,
			is_loading:false,
			http:'http://',
			signature_img:'',
			signature_url:'',
			img_type:'',
			upload_router:'',			
			cropper: {
				avatar: '',
				autoCrop: true,
				autoCropWidth: 200,
				autoCropHeight: 200,
				fixedBox: true,
				show_cropper:false
			}					
		} 
	},
	methods:{
		modeify_info(){
			var v = this;
			if(!check.name_check(this.user_info.username,this)){
				return false
			}
			if(this.user_info.wechat&&!check.wechat_check(this.user_info.wechat,this)){
				return false
			}
			if(this.user_info.qq&&!check.qq_check(this.user_info.qq,this)){
				return false
			}
			if(this.user_info.skype&&!check.skype_check(this.user_info.skype,this)){
				return false
			}
			if(this.user_info.job&&!check.job_check(this.user_info.job,this)){
				return false
			}
			if(this.user_info.city&&!check.city_check(this.user_info.city,this)){
				return false
			}	
			if(!check.desc_check(this.user_info.desc,this)){
				return false
			}					
            this.https.post('/front/user_center/modify_info',{
            	user_data:v.user_info
            }).then((r) => {
            	if (r.data.code) {
                	for (var key in r.data.user_info) {
                		v.$set(v.user_info,key,r.data.user_info[key]);	
                	}
	                if (r.data.user_info['username']) {
	                	v.$refs.header.user_info.username = r.data.user_info['username']
	                }
                	v.$Message.success('修改信息成功');
            	}else{
            		v.$Message.warning(r.data.msg);
            	}
                }).catch((e) =>{
                    console.log(e);       
            });
		},
		go(path){
			this.$router.push(path);
		},
		submit_signature(){
			var v = this
			var url = v.signature_url?v.http + v.signature_url:''
			this.https.get('/front/user_center/change_signature',{params:{
				signature_img:v.signature_img,
				signature_url:url,
			}}).then((r)=>{
				if (r.data.code) {
					v.$Message.success('设置成功')
				}
			}).catch((e)=>{
				console.log(e)
			})
		},
		change_avatar(){
			this.cropper.autoCropWidth=200
			this.cropper.autoCropHeight=200
			this.img_type = 1
			this.upload_router = '/front/user_center/change_image'
			$('#choice-form input').click()
		},
	    change_signature(){
	    		this.cropper.autoCropWidth=800
				this.cropper.autoCropHeight=180
				this.img_type = 2
				this.upload_router = '/front/user_center/change_signature_image'
            $('#choice-form input').click()
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
	        	formdata.append('image',data);
	        	var func = function(v,path){
	        		if (v.img_type==1) {
		        		v.user_info.image = path
		            	v.$refs.header.user_info.image = path
	        		}else{
	        			v.signature_img = path
	        		}
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
            this.https.post(vm.upload_router,formdata, config).then(
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
	}
}
</script>
<style lang="scss" scoped>
#userpage{
	background-color: #f8f8f8;
	.container{
		width: 1200px;
		min-height: 10rem;
		padding-top: 15px;
		color: #7c7c7c;
		.user-pannel{
			background-color: #ffffff;
			border-radius: 3px;
			.user-info{
				padding-top: 20px;
				padding-left: 20px;
				.common-button3{
					font-size: 18px;
					padding: 10px 0px 10px 0px;
					margin-top: 30px;
				}
				.modify-input{
					padding-top: 25px;
					font-size: 16px;
					.verify-button{
						margin-left:20px;
					}
				}
			}
		}
		.user-intro{
			.user-set{
				padding-top: 30px;
				font-size: 26px;
				li{
					text-align: right;
					padding-right: 20px;
					cursor: pointer;
					line-height: 30px;
				}
				.has-mail{
					position: relative;
					&:after{
						position: absolute;
						top: 0;
						right: -5px;
						display: block; 
						background-color: red;
						content:"";
						width: 10px;
						height: 10px;	
						border-radius: 50%;		
					}		
				}
			}
			.user-avatar{
				padding: 30px 20px 10px 20px;
				.avatar-frame-new{
					.mask{
						position: absolute;
						z-index: 10;
						color: white;
						top: 80px;
						left: 0px;
						background-color: rgba(0,0,0,0.4);
						width: 108px;
						height:40px;
						text-align: center;
						display: none;
					}
					&:hover{
						.mask{
							display: block;
						}
					}
				}
			}
			.userinfo{
				.username{
					font-size: 20px;
					font-weight: bold;
					color: #333333;
					text-align: center;
				}
				.is_author{
					position: relative;
				}
				.is_author:after{
					position: absolute;
					right: -30px;
					content: url('/static/author_confirm.png');
				}
				.userdesc{
					text-align: center;
					font-size: 14px;
				}
			}
			.reward{
				text-align: center;
				padding: 20px 0 20px 0;
				color: #333333;
				position: relative;
				.break-line{
					position: absolute;
					border-left: 1px solid #b5b5b5;
					height: 40px;
					width: 1px;
					top: 25px;
					right: 0;
				}
				p{
					font-size: 14px;
				}	
				span{
					font-size: 24px;
					font-weight: bold; 
					cursor: pointer;
				}
			}
		}
		.user-tab{
			margin-top: 15px;
			padding-top:20px;
			min-height: 5rem;
			.left-tab{
				text-align: center;
				font-size: 16px;
				padding:15px 0px 15px 0px;
				letter-spacing: 5px;
				font-weight: bold;
				cursor: pointer;
				a{
					color: #7c7c7c;
				}
			}
			.left-active{
				color: #28b28a;
				background-color: #f2f2f2;
				border-left: 5px solid #28b28a;
			}
		}
		.user-tab-content{
			padding: 20px 20px 20px 20px;
			margin-left: 15px;
		}
		.signature-title{
			font-size:18px;
			font-weight: bold; 
			padding-bottom: 10px;
			border-bottom: 1px solid #f2f2f2;
		}
		.news-footer-content{
			text-align: center;
			font-size: 14px;
			margin-top: 15px;
		}
        .img-container {
            margin-top: 30px;
            width: 100%;
            height: 180px;
            >li {
                display: inline-block;
            }
            li:first-child {
                width: 100%;
                height: 100%;
                background: #f7f7f7;
                line-height: 180px;
                text-align: center;
                border: 1px dashed #28a28b;
                position: relative;
                &::before {
                    content: '请上传签名档图片';
                    display: inline-block;
                    position: absolute;
                    top: 0;
                    left: 45%;
                    font-size: .28rem;
                    color: #888;
                    z-index: 1;
                }
                img {
                    position: absolute;
                    top: 0;
                    left: 0;
                    z-index: 2;
                    width: 100%;
                    height: 100%;
                }
            }
        }
        .reset_signature{
        	margin-top: 10px;
        	a{
        		color: #28b28a;
        	}
        }
        .signature_url{
        	padding-top:30px;
        	li{
        		display: block;
        		padding-top: 10px;
        	} 
        }	
        .submit_signature{
        	padding-top: 20px;
        }	
	}
}	
</style>