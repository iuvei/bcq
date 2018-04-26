<template>
    <div class="be-author" id="author">
        <NavHeader></NavHeader>
        <div class="banner"></div>
        <div class="leaveMsg container">
            <Form ref="formValidate" :model="formValidate" :rules="ruleValidate" :label-width="200" :class="'contact_form'">
                <FormItem label="怎么称呼：" prop="name">
                    <Input v-model="formValidate.name" style="width: 620px" placeholder="请输入名称"></Input>
                </FormItem>
                <FormItem label="联系电话：" prop="phone">
                    <Input v-model.number="formValidate.phone" style="width: 620px" placeholder="请输入联系电话"></Input>
                </FormItem>
                <FormItem label="所在领域：" prop="interest">
                    <CheckboxGroup v-model="formValidate.interest">
                        <Checkbox label="游戏厂商"></Checkbox>
                        <Checkbox label="平台经营"></Checkbox>
                        <Checkbox label="产业媒体"></Checkbox>
                        <Checkbox label="产业周边"></Checkbox>
                    </CheckboxGroup>
                </FormItem>
                <FormItem label="申请理由：" prop="desc">
                    <Input v-model="formValidate.desc" type="textarea" style="width: 620px" :autosize="{minRows: 5,maxRows: 5}" placeholder="请输入您申请成为本站专栏作者的理由吧"></Input>
                </FormItem>
                <FormItem label="您的相关文章链接：" prop="links">
                    <Input v-model="formValidate.links" type="textarea" style="width: 620px" :autosize="{minRows: 3,maxRows: 5}" placeholder="若没有已发布的个人文章链接,建议先移步至 ‘博牛社区’ 发表再复制相关链接"></Input>
                </FormItem>
                <FormItem prop="agreed">
                    <RadioGroup v-model="formValidate.agreed">
                        <Radio label="agreed">我已阅读<a target="_blank" href="/parts/AuthorAgreement#authorAgreement">《菠菜圈作者要求及条件》</a></Radio>
                    </RadioGroup>
                </FormItem>
                <FormItem style="text-align: center; margin-left: -340px;">
                    <button type="button" class="submit-button" @click="handleSubmit('formValidate')">提交</button>
                </FormItem>
            </Form>
        </div>
        <FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>
    </div>
</template>


<script>
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';
    import $ from 'jquery';

    export default {
        components: {NavHeader,FooterArea,FloatSideBar},
        mounted() {
            document.title = '菠菜圈| 申请成为专栏作者';
            var v = this;
            this.https.get('/front/user_center/user_info_render').then((r)=>{
                if (r.data.code){
                    v.formValidate.name = r.data.render.user_info.username;
                }
            }).catch((e)=>{
                console.log(e);
            });
        },
        data(){
            return {
                formValidate: {
                    name: '',
                    phone: '',
                    interest: [],
                    desc: '',
                    links: '',
                    agreed: '',
                },
                ruleValidate: {
                    name: [
                        { required: true, message: '请留下您的联系姓名吧', trigger: 'blur' },
                        { max: 20, message: '联系姓名不能大于20个字', trigger: 'change' },
                    ],
                    phone: [
                        { required: true, type: 'number', message: '请留下您的联系电话', trigger: 'blur' },
                    ],
                    interest: [
                        { required: true, type: 'array', min: 1, message: '选择所在行业领域', trigger: 'change' },
                    ],
                    desc: [
                        { required: true, message: '申请理由不能为空', trigger: 'blur' },
                        { min: 20, message: '申请理由不能少于20个字', trigger: 'change' },
                        { max: 200, message: '申请理由不能大于200个字',trigger: 'change' },
                    ],
                    links: [
                        { required: false, message: '请提供您的相关文章链接', trigger: 'blur' },
                        { max: 200, message: '相关文章链接不能大于200个字', trigger: 'change' },
                    ],
                    agreed: [
                        { required: true, message: '请阅读并勾选作者协议', trigger: 'blur' }
                    ],
                }
            }
        },
        methods: {
            handleSubmit (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        var v = this;
                        this.https.post('/front/applicant_auth/add_auth',{
                            name: v.formValidate.name,
                            phone: v.formValidate.phone,
                            interest: v.formValidate.interest,
                            links: v.formValidate.links,
                            desc: v.formValidate.desc
                        }).then((r)=>{
                            if(r.data.code){
                                if (r.data.namecode){
                                    v.$store.commit('resetName',{username:v.formValidate.name});
                                }
                                v.$Message.success(r.data.msg);
                                setTimeout(function () {
                                    v.$router.push(`/`);
                                },3000);
                            }else {
                                v.$Message.warning(r.data.msg);
                            }
                        }).catch(function (error) {
                            let replace = {
                                name: '联系姓名',
                                phone: '联系电话',
                                interest: '行业领域',
                                links: '文章链接',
                                desc: '申请理由',
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
        },
    }

</script>

<style lang="scss" scoped>
    html,body {
        height: 100%;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .be-author {
        height: 100%;
        background: #fff;
        .container {
            width: 1200px;
            margin: 20px auto;
            min-height: 80vh;
        }
        .banner {
            width: 100%;
            height: 606px;
            background: url("/static/beauthor-banner.jpg") center center no-repeat;
        }
    }
    .contact_form {
        width: 100%;
        margin:20px 0 20px 50px;
        padding: 30px 0 20px 80px;
    }
    .links-txt {
        position: absolute;
        top: 10px;
        right: 0;
        margin-left: -260px;
        z-index: 2;
    }
    .xx-input {
        display: inline-block;
        width: 240px;
        height: 40px;
        line-height: 1.5;
        padding: 4px 7px;
        font-size: 12px;
        border: 1px solid #dddee1;
        border-radius: 3px;
        color: #495060;
        background-color: #fff;
        background-image: none;
        position: relative;
        cursor: text;
        transition: border .2s ease-in-out,background .2s ease-in-out,box-shadow .2s ease-in-out;
        transition-property: border, background, box-shadow;
        transition-duration: 0.2s, 0.2s, 0.2s;
        transition-timing-function: ease-in-out, ease-in-out, ease-in-out;
        transition-delay: initial, initial, initial;
        &:focus {
            border-color:  #27b48a;
            outline: 0;
            box-shadow: 0 0 0 2px rgba(45,140,240,.2);
        }
        &::-webkit-input-placeholder {
            color: #c1c1c1;
            font-size: .2rem;
        }
        &::-moz-placeholder {
            color: #c1c1c1;
            font-size: .2rem;
        }
        &:-ms-input-placeholder {
            color: #c1c1c1;
            font-size: .2rem;
        }
        &:-moz-placeholder {
            color: #c1c1c1;
            font-size: .2rem;
        }
    }
    .xx-textarea {
        width: 330px;
        min-height: 80px;
        padding: 5px;
        border-radius: 3px;
        border: 1px solid #dddee1;
        &:focus{
            border-color: #27b48a;
            outline: 0;
            box-shadow: 0 0 0 2px rgba(45,140,240,.2);
        }
        &::-webkit-input-placeholder {
            color: #c1c1c1;
            font-size: .23rem;
        }
        &::-moz-placeholder {
            color: #c1c1c1;
            font-size: .23rem;
        }
        &:-ms-input-placeholder {
            color: #c1c1c1;
            font-size: .23rem;
        }
        &:-moz-placeholder {
            color: #c1c1c1;
            font-size: .23rem;
        }
    }


</style>