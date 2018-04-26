<template>
	<div id="account-pannel" v-if="show_pannel">
		<div class="pannel-mask" @click="close">			
		</div>
        <Card style="width: 7rem;"  class='pannel-frame'>
            <div style="text-align: center;">
                <Row>
                    <Col>
                        <img class="logo" src="/static/logo-34.png"/>
                    </Col>
                    <Col :class-name="'brief'">
                        <span>亚太菠菜产业的第一指引者</span>
                    </Col>
                    <Col class="top">
                        <Row type="flex" justify="center" v-if="tab=='login'||tab=='register'">
                            <Col :xs="5" :sm="5" :lg="5" :class-name="'register-tab tab'">
                            <div v-bind:class="{ 'tab-css': tab=='register' }" @click="changetab('register')">
                                注册
                            </div>
                                <div class="button-line" v-if="tab=='register'"></div>
                            </Col>
                            <Col :xs="5" :sm="5" :lg="5" :class-name="'login-tab tab'">
                            <div v-bind:class="{ 'tab-css': tab=='login' }"  @click="changetab('login')">
                                登录
                            </div>
                                <div class="button-line" v-if="tab=='login'"></div>
                            </Col>
                        </Row>
                        <Row  type="flex" justify="center"  :class-name="'reset-step'">
                            <Col>
                                <img src="/static/reset_step1.png" class="step-img" v-if="tab=='reset_step1'">
                                <img src="/static/reset_step2.png" class="step-img" v-if="tab=='reset_step2'">
                                <img src="/static/reset_step3.png" class="step-img" v-if="tab=='reset_step3'">
                            </Col>
                        </Row>
                    </Col>
                    <Col :xs="{span:22,offset:1}" :sm="{span:22,offset:1}" :lg="{span:22,offset:1}">
                        <Row v-if="tab=='login'">
                            <Col :xs="24" :sm="24" :lg="24" :class-name="'phone-check'">
                                <Input v-model="loginData.phone" v-bind:placeholder="'请输入手机号'" class="data-input">
                                    <Select v-model="zonecode" slot="prepend" placeholder="国家" ref="select" style="min-width:1.5rem;width:auto" :transfer="true" class="phone-check">
                                        <Option v-for="(item,key) in countrycode" :key= "key" :value="item.code">
                                            {{item.value}} (+{{item.code}})
                                        </Option>
                                    </Select>
                                </Input>
                                <Input v-model="loginData.psd" @on-keypress="login" type="password" placeholder="请输入登录密码" class="data-input">
                                </Input>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24" class="login-opt">
                                <Col :xs="12" :sm="12" :lg="12" class="remember-psd">
                                    <Checkbox v-model="loginData.remember">保持登录</Checkbox>
                                </Col>
                                <Col :xs="12" :sm="12" :lg="12" class="forget-psd">
                                    <a @click="changetab('reset_step1')">忘记密码?</a>
                                </Col>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24">
                                <Button  @click="login" class="submit-button">
                                    &nbsp登录
                                </Button>
                            </Col>
                        </Row>
                        <Row v-if="tab=='register'">
                            <Col :xs="24" :sm="24" :lg="24" :class-name="'phone-check'">
                                <Input v-model="registerData.phone" v-bind:placeholder="'请输入手机号'" class="data-input">
                                    <Select v-model="zonecode" slot="prepend" placeholder="国家" ref="select" :transfer="true" style="min-width:1.5rem;width:auto" class="phone-check">
                                        <Option v-for="(item,key) in countrycode" :key= "key" :value="item.code">
                                            {{item.value}} (+{{item.code}})
                                        </Option>
                                    </Select>
                                </Input>
                            </Col>
                            <Col  :xs="24" :sm="24" :lg="24">
                                <Input v-model="registerData.authCode" placeholder="请输入注册手机验证码" class="data-input">
                                    <label v-if="codesend" slot="append">{{countdown}}</label>
                                    <label v-else="codesend" slot="append" class="auth-code" @click="getAuthCode(registerData.phone)">发送验证码</label>
                            </Input>
                                <Input v-model="registerData.psd" type="password" placeholder="请设置登录密码，密码由6-18位数字/字符+字母组成" class="data-input">
                                </Input>
                                <Input v-model="registerData.psdconfirm" type="password" placeholder="请确认密码" class="data-input">
                                </Input>
                                <Input v-model="registerData.username" placeholder="请设置昵称" class="data-input" @on-keypress="register">
                                </Input>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24" :class-name="'attention'">
                                点击注册按钮，即代表你同意<a target="_blank" href="/parts/UserAgreement#userAgreement">《菠菜圈协议》</a>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24">
                                <Button  @click="register" class="submit-button">
                                    &nbsp注册
                                </Button>
                            </Col>
                        </Row>
                        <Row v-if="tab=='reset_step1'">
                            <Col :xs="24" :sm="24" :lg="24" :class-name="'phone-check'">
                                <Input v-model="resetData.phone" v-bind:placeholder="'请输入手机号'" class="data-input">
                                    <Select v-model="zonecode" slot="prepend" placeholder="国家" ref="select" :transfer="true" style="min-width:1.5rem;width:auto">
                                        <Option v-for="(item,key) in countrycode" :key= "key" :value="item.code">
                                            {{item.value}} (+{{item.code}})
                                        </Option>
                                    </Select>
                                </Input>
                            </Col>
                            <Col  :xs="24" :sm="24" :lg="24">
                                <Input v-model="resetData.authCode" placeholder="请输入注册手机验证码" class="data-input">
                                    <label v-if="codesend"  slot="append">{{countdown}}</label>
                                    <label v-else="codesend" slot="append" class="auth-code" @click="getAuthCode(resetData.phone)">发送验证码</label>
                                </Input>
                            </Col>
                            <Col :xs="12" :sm="12" :lg="12" :class-name="'back-login'">
                                已有账号,<a @click="tab='login'">马上登录</a>
                            </Col>
                            <Col :xs="12" :sm="12" :lg="12" :class-name="'back-home'">
                                <a @click="go('/')">返回菠菜圈首页</a>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24">
                                <Button  @click="reset_step1" class="submit-button">
                                    下一步
                                </Button>
                            </Col>
                        </Row>
                        <Row v-if="tab=='reset_step2'">
                            <Col :xs="24" :sm="24" :lg="24">
                            <div>
                                <Input placeholder="请输入新注册密码（不小于8位）"  type="password" v-model="resetData.psd" class="reset-input">
                                </Input>
                            </div>
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24">
                            <div>
                                <Input placeholder="请再次输入新注册密码（新密码与确认密码相同" type="password"  class="reset-input" v-model="resetData.psdconfirm" @on-keypress="reset">
                                </Input>
                            </div>
                            </Col>
                            <Col :xs="12" :sm="12" :lg="12" :class-name="'back-login'">
                                已有账号,<a @click="tab='login'">马上登录</a>
                            </Col>
                            <Col :xs="12" :sm="12" :lg="12" :class-name="'back-home'">
                                <a @click="go('/')">返回菠菜圈首页</a>
                            </Col>                                
                            <Col :xs="24" :sm="24" :lg="24">
                                <Button  @click="reset" class="submit-button">
                                    下一步
                                </Button>
                            </Col>
                        </Row>
                        <Row v-if="tab=='reset_step3'" type="flex" justify="center">
                            <Col :xs="24" :sm="24" :lg="24">
                                <img src="/static/reset_finish.png" class="reset_finish">
                            </Col>
                            <Col :xs="24" :sm="24" :lg="24" :class-name="'finish_alert'">
                                <span>设置完成，3s后返回登录页面</span>
                            </Col>
                        </Row>
                    </Col>
                </Row>
            </div>
        </Card>			
	</div>
</template>
<script>
    import country from '../common/countrycode.js';
    import JQ from 'jquery';
    export default {
        mounted(){
            this.countrycode = country.countrycode  
        },
        props:['action','fresh'],
        data(){
            return {
            	show_pannel:false,
                registerData:{
                    phone:'',
                    username:'',
                    authCode:'',
                    psd:'',
                    psdconfirm:''
                },
                loginData:{
                    phone:'',
                    psd:'',
                    remember:false
                },
                resetData:{
                    phone:'',
                    authCode:'',
                    psd:'',
                    psdconfirm:''
                },
                zonecode:'',
                countrycode:'',
                tab:'login',
                time:0,
                codesend:false
            }
        },
        computed: {
            countdown:function(){
                if (this.time == 0){
                    this.codesend= false;
                }
                return this.time > 0 ? this.time + 's 后重新获取' : '发送验证码';
            }
        },
        methods: {
        	show(){
        		this.show_pannel = true
        		JQ("html").css('overflow','hidden')
        	},
        	close(){
        		this.show_pannel = false
        		JQ("html").css('overflow','scroll')
        		this.$emit('colse')	
        	},
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
            timer: function () { //倒计时
                if (this.time > 0) {
                    if (!this.codesend){
                        this.codesend = true;
                    }
                    this.time--;
                    setTimeout(this.timer, 1000);
                }
            },
            getAuthCode(phone){
                var v= this;
                if (!v.zonecode) {
                    v.$Message.error('请选择国家代码')
                    return false
                }
                if(!this.phone_verify(phone)){
                    return false
                }
                this.https.get('/common/get_verification_code',{
                params:{
                    phone:phone,
                    zonecode:v.zonecode
                }
                }).then(function(r){
                    if (r.data.code == 1){
                        v.$Message.success('验证码已发送');
                        v.time = 60;
                        v.timer();
                    }else{
                        v.$Message.error(r.data.msg);
                    }
                }).catch(function(e){
                    console.log(e);
                });
            },
            register(e){
                if(e.keyCode!=13 && typeof e.keyCode != 'undefined'){
                    return false   
                }
                var v = this;
                if (!v.zonecode) {
                    v.$Message.error('请选择国家代码')
                    return false
                }
                if(!this.phone_verify(v.registerData.phone)){
                    return false
                }else if(!this.psd_verify(v.registerData.psd)){
                    return false
                }else if(!this.name_verify(v.registerData.username)){
                    return false
                }
                this.https.post('/front/account/register',{
                    register:v.registerData,
                    zonecode:v.zonecode
                },{
                    headers: {
                            'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(function(r){
                        if (r.data.code ==1){
                            v.$store.state.user_info = r.data.user;
                            v.$router.go(0);
                        }else{
                            v.$Message.error(r.data.msg);
                        }
                    })
                    .catch(function(err){
                        console.log(err);
                    });
            },
            login(e){
                if(e.keyCode!=13 && typeof e.keyCode != 'undefined'){
                    return false   
                }
                var v = this;
                if (!v.zonecode) {
                    v.$Message.error('请选择国家代码')
                    return false
                }
                if(!this.phone_verify(v.loginData.phone)){
                    return false
                }

                this.https.post('/front/account/login',{
                    login:v.loginData,
                    zonecode:v.zonecode
                },{
                    headers: {
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(function(r){
                    if (r.data.code ==1){
                    	v.$store.commit('authCheck',{user_info:r.data.user})
                        if(v.action=='collection'){
                        	v.$emit('collection')
                        }
                        if (v.fresh==1) {
                            v.$Message.success('登陆成功')
                            v.close()
                        }else{
                            v.$router.go(0)
                        }
                    }else{
                        v.$Message.error(r.data.msg);
                    }
                    }).catch(function(err){
                        console.log(err);
                    });
            },
            reset(e){
                if(e.keyCode!=13 && typeof e.keyCode != 'undefined'){
                    return false   
                }                
                var v = this;
                if (!v.zonecode) {
                    v.$Message.error('请选择国家代码')
                    return false
                }
                if(!this.phone_verify(v.resetData.phone)){
                    return false
                }
                if(!this.psd_verify(v.resetData.psd)){
                    return false
                }                
                this.https.post('/front/account/reset_password',{
                    reset:v.resetData,
                    zonecode:v.zonecode,
                },{
                    headers: {
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(function(r){
                    if (r.data.code == 1){
                        v.tab = 'reset_step3';
                        setTimeout(function(){
                            v.tab = 'login';
                        },3000);
                    }else {
                        v.$Message.error(r.data.msg);
                    }
                }).catch(function(err){
                    console.log(err);
                });
            },
            changetab(tab){
                this.tab = tab;
            },
            reset_step1(){
                var v = this;
                if (!v.zonecode) {
                    v.$Message.error('请选择国家代码')
                    return false
                }
                if(!v.resetData.phone || !v.resetData.authCode) {
                    v.$Message.error('手机号或验证码不得为空');
                    return false;
                }
                this.https.post('/common/verify_code',{
                    phone:v.resetData.phone,
                    authCode:v.resetData.authCode,
                    zonecode:v.zonecode
                },{
                    headers: {
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                }).then(function(r){
                    if (r.data.code == 1){
                        v.tab = 'reset_step2'
                    }else {
                        v.$Message.error(r.data.msg);
                    }
                }).catch(function(err){
                    console.log(err);
                });
            },
            remember_account(){
                if (this.loginData.remember) {
                    localStorage.setItem("bcq_phone",this.loginData.phone)
                    localStorage.setItem("bcq_psd",this.loginData.psd)   
                    localStorage.setItem("bcq_remember",1)         
                }else{
                    localStorage.removeItem("bcq_phone");
                    localStorage.removeItem("bcq_psd");
                    localStorage.removeItem("bcq_remember");
                }
            },
            phone_verify(phone){
                if (phone.length<8) {
                    this.$Message.error('请输入正确手机号！')
                    return false
                }else if (!/^[0-9]*$/.test(phone)) {
                    this.$Message.error('手机号非法！')
                    return false       
                }
                return true
            },
            psd_verify(psd){
                if(!/^\w{6,18}$/.test(psd)){    
                    this.$Message.error('密码由6-18个数字、字符以及下划线组成！')
                    return false
                }else if(!psd.match(/\d{1,18}/)||!psd.match(/[a-zA-Z]{1,18}/)){
                    this.$Message.error('密码必须包含数字以及字母组成！')
                    return false
                }
                return true
            },
            name_verify(name){
                if (!(name.length>1&&name.length<12)) {
                    this.$Message.error('用户名要求在3-10个字符之间')
                    return false
                }
                return true
            }
        }
    }
</script>
<style lang="scss">
#account-pannel{
	position: fixed;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	z-index: 1000;
	.pannel-mask{
		position: absolute;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: black;
		opacity: 0.5;
		z-index: 1;
	}
	.pannel-frame{
		position: absolute;
		z-index: 2;
		top: 100px;
		left: 40%;
	}
}
.ivu-select-dropdown{
    width: 250px!important;
}
.back-login,.back-home{
    padding-top: 15px;
    font-size:12px; 
}
.back-login{
    text-align: left;
}
.back-home{
    text-align: right;
}
.ivu-input-group-prepend,.ivu-input,.ivu-input-group-append{
    border-radius: 3px;
    background-color: #fff;
    height: 0.7rem;
}
.data-input{
    margin-top: 0.3rem;
    height: 0.7rem
}
.auht-code{
    font-weight: lighter;
    color: silver;
}
.ivu-input-group-append{
    border-left: none;
}
.nav{
    height: 3rem;
}
.submit-button{
    margin-top: 0.5rem;
    width: 2rem;
    font-size: 14px;
    background-color: #24a97e;
    color: white;
    span{
        width: 100%!important;
        text-align: center!important;
    }
}
.submit-button:hover {
    background-color: #53caa4;
    border-color: #53caa4;
    color: white;
}
.remember-psd{
    text-align: left;
}
.forget-psd{
    text-align: right;
    font-size: 12px;
    color: #495060;
    cursor: pointer;
}
.login-opt{
    margin-top: 0.1rem;
}
.logo{
    width: 220px;
    margin-top: 0.35rem;
}
.brief {
    color:#23aa7f;
    font-size: 0.32rem;
    margin-top:0.28rem;
    font-weight: lighter;
    letter-spacing: 1px;
}
.ivu-checkbox-checked .ivu-checkbox-inner {
    border-color: #24a97e;
    background-color: #24a97e;
}
.ivu-select-item{
    font-size: 0.2rem;
}
.register-tab,.login-tab{
    text-align: center;
    font-size: 0.35rem;
    margin-top: 0.6rem;
    color:#666666;
    cursor: pointer;
}
.button-line{
    height: 1px;
    border: 1px solid #24a97e;
    margin-top: 0.1rem;
    background-color: #24a97e;
}
.tab-css{
    color:#24a97e
}
.auth-code{
    cursor: pointer;
}
.attention{
    font-weight: lighter;
    font-size: 0.2rem;
    text-align: left;
    margin-top: 0.2rem;
}
.step-img{
    margin-top: 0.5rem;
    width: 5rem;
}
.reset-input{
    margin-top: 0.3rem;
}
.reset_finish{
    margin-top: 0.7rem;
    width: 1rem;
    font-size: 0.2rem;
    color: #797979;
}
.finish_alert{
    margin-top: 0.6rem;
    padding-bottom: 0.7rem;
}	
</style>