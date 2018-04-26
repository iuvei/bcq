<template>
<div>
	<Modal v-model="message"  :closable="false" :mask-closable="false">
        <div class="title">收件人 ： <a>{{name}}</a> <p><a @click="close_modal">×</a></p></div>
        <textarea class="common-textarea" v-model="mail_content" placeholder="请输入信件内容">	
        </textarea>  
        <p style="text-align:right">您还可以输入{{count}}字</p>
        <p slot="footer">
            <Row>
                <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
            	   <Button @click="send_message" class="common-button3">发送</Button>
                </Col>
            </Row>
        </p>   
    </Modal>
</div>
</template>
<script>
    export default{
        props:['message','rid','name'],
        data(){
            return {
                mail_content:'',
                limit_mail:''
            }
        },
        methods:{
            send_message(){
                var v= this;
                if (!v.mail_content) {
                    v.$Message.success('请输入信件内容');
                    return false;
                }
                v.https.post('/front/user_zone/send_message',{
                    to:v.rid,
                    content:v.mail_content
                }).then((r)=>{
                    if (r.data.code == 1) {
                        v.$Message.success('发送成功');
                        v.close_modal();
                    }else{
                        v.$Message.warning(r.data.msg)
                        return false
                    }
                }).catch((e)=>{
                    console.log(e);
                });
            },
            close_modal(){
                this.mail_content = '';
                this.limit_mail = '';
                this.$emit('close');
            }
        },
        computed:{
            count(){
                var count = 300 - this.mail_content.length;
                if (count > 0) {
                    return count;
                }else if (count == 0){
                    this.limit_mail =this.mail_content;
                    return 0;
                }else if(count < 0){
                    this.mail_content =this.limit_mail;
                    this.$Message.warning('最多输入300字');
                    return 0;
                }
            }
        }
    }
</script>
<style scoped lang="scss">
    .title{
        padding:10px 0px 10px 0px; 
        position: relative;
        p{
            position: absolute;
            right: 10px;
            top: 0px;
            font-size:20px;
            a{
                color: silver;
            } 
        }
    }
</style>