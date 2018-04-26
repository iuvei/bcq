<template>
	<div id="new-question">
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
            	<!--<div class="bread">-->
					<!--<div class="bread-text"><a href="/">首页</a>  > 互动 > 提问</div>-->
				<!--</div>-->

				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>互动</BreadcrumbItem>
                    <BreadcrumbItem to="/questionpage">问答</BreadcrumbItem>
					<BreadcrumbItem>提问</BreadcrumbItem>
				</Breadcrumb>

				<Row type="flex" justify="space-between">
					<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
						<Row>
							<Col :class-name="'question-col'">
								<img src="/static/question_answer.png"> <span class="flag">&nbsp&nbsp&nbsp提问</span>
							</Col>
							<Col :class-name="'question-col'"  :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
								<input class="common-input" placeholder="写下您的问题" v-model="title">
							</Col>
							<Col :class-name="'question-col'"  :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
								<textarea class="common-textarea" placeholder="选填，详细说明您的问题，以便获得更好的答案" v-model="describe"></textarea>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">&nbsp</Col>
							<Col :class-name="'question-col'" :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
								<Button :class="'common-button3'" @click="sub_question">提交</Button>
							</Col>
						</Row>
					</Col>
				</Row>
            </Col>
		</Row>
		<FooterArea></FooterArea>
        <FloatSideBar></FloatSideBar>	
	</div>
</template>
<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
export default{
	components: {NavHeader,FooterArea,FloatSideBar},
	data(){
		return {
			title:'',
			describe:'',
			id:''
		}
	},
	methods:{
		sub_question(){
			if (!this.title.trim()) {
				this.$Message.warning('问题不得为空');
			}
			var v = this;
			if (v.describe.length>500) {
				v.$Message.success('描述字数太长，请保证在500字之内')
				return false
			}
			v.https.post('/front/question/new_question',{
				title:v.title,
				describe:v.describe,
				id:v.id
			}).then((r)=>{
				if (!r.data.code) {
					v.$Message.error(r.data.msg);
				}else{
					v.title = ''
					v.describe = ''
					v.$Message.success(r.data.msg);
					v.$router.push('/questionpage')
				}
			}).catch((e)=>{
				console.log(e)
			})
		}
	},
    mounted() {
        document.title = '菠菜圈| 我要提问';
        var v = this
        var id = v.$route.query.id
        if (id) {
	        v.https.post('/front/question/new_question_render',{
	        	id:id
	        }).then((r)=>{
	        	if (r.data) {
	        		v.id = r.data.id
	        		v.title = r.data.title
	        		v.describe = r.data.describe
	        	}
	        }).catch((e)=>{
	        	console.log(e)
	        })
        }
    }
}
</script>
<style lang="scss" scoped>
#new-question{
    .common-button3 {
        color: #fff !important;
        background-color: #28b28a !important;
        width: 170px;
        height: 46px;
        line-height: .28rem;
        padding: 10px 20px;
        border-radius: 3px;
        font-size: .28rem;
        text-align: center;
        &:hover{
            color: white;
            background-color: #149f77 !important;
            border-color: #149f77 !important;
            transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
            transition-property: color, background-color, border;
            transition-duration: 0.2s, 0.2s, 0.2s;
            transition-timing-function: linear, linear, linear;
            transition-delay: initial, initial, initial;
        }
    }
	.container{
		width:1200px;
		min-height:10rem;
		margin: 20px auto;
		.page-left{
			padding: 30px 50px;
			width: 80%;
			margin: 0 auto;
			.question-col{
				margin-top: 20px;
			}
			.flag{
				font-size: .3rem;
			}
			.common-input {
				font-size: .26rem;
                color: #444;
                height: 36px;
                line-height: 36px;
			}
			.common-textarea{
				min-height: 200px!important;
				font-size: .28rem;
                color: #666;
                padding: 10px;
			}
		}
	}
}
</style>