<template>
	<div id='pub-succsee'>
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>交易</BreadcrumbItem>
                    <BreadcrumbItem>
                        <router-link :to="{path: '/trade/platform'}" v-if="lowType == 'platform'">代理招商</router-link>
                        <router-link :to="{path: '/trade/business'}" v-else>供求商讯</router-link>
                    </BreadcrumbItem>
                    <BreadcrumbItem>信息提交成功</BreadcrumbItem>
                </Breadcrumb>

                <Row type="flex" :class-name="'add-cash'">
                    <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'cash-box'">
                        <ul class="pub-success">
                            <li><img src="/static/publish-complete.png" alt=""></li>
                            <li>
                                <h2>发布完成，等待审核中</h2>
                                <p>您可以进入 <a @click="goMyPub">我的发布</a> 查看审核状态</p>
                                <p><span>{{count}}s</span>无任何操作自动返回上个页面，或者 <a @click="goLast">点此返回</a> </p>
                            </li>
                        </ul>
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
import $ from 'jquery';
import lrz from 'lrz';
import Vue from 'vue';

export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar},
	mounted(){
		document.title = '菠菜圈| 发布信息提交成功';
        this.type = this.$route.params.type;
        this.lowType = this.$route.params.type.toLowerCase();
        var v = this
        var sid = setInterval(()=>{
           if(v.flag == true){
               clearInterval(sid)
           }
        v.jump()},1000) 
	},
	data(){
		return {
            type: '',
            lowType: '',
            count: 5,
            flag:false
		}
	},
	methods: {
        jump() {
            var v = this;
            v.count--;
            if(v.count <= 0) {
                v.$router.push('/trade/'+v.type);
            }
        },
        goLast(){
            this.flag = true
            this.$router.push('/trade/'+this.type);
        },
        goMyPub(){
            this.flag = true
            this.$router.push('/user/userpage/3');
        }
	}
}
</script>
<style lang='scss' scoped>
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    #pub-succsee {
        .container {
            width: 1200px;
            margin: 20px auto;
            .add-cash {
                margin: 50px 0;
                .cash-box {
                    font-size: 16px;
                    width: 80%;
                    margin: 0 auto;
                }
            }

            /* pub_step3 */
            .pub-success {
                width: 80%;
                margin: 0 auto;
                list-style: none;
                text-align: center;
                padding: 100px;
                li {
                    display: inline-block;
                    height: 100px;
                }
                li:first-child {
                    overflow: hidden;
                    margin-right: 30px;
                    padding-top: 15px;
                    img {
                        width: 86px;
                        height: 86px;
                        display: block;
                    }
                }
                li:last-child {
                    padding-top: 10px;
                    text-align: left;
                    h2 {
                        font-size: 18px;
                        font-weight: bold;
                        color: #333;
                        padding: 0 10px 10px 10px;
                    }
                    p {
                        padding: 0 10px 10px 10px;
                        font-size: .28rem;
                        color: #555;
                        span {
                            color: #ed8e18;
                            font-size: 16px;
                            margin: 0 8px 0 0;
                        }
                        a {
                            color: #478dce;
                            text-decoration: underline;
                        }
                    }
                }
            }

        }
    }
</style>