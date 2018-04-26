<template>
<div id="question_detail">
	<NavHeader></NavHeader>
	<Row type="flex" justify="center">
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
			<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
                <BreadcrumbItem>互动</BreadcrumbItem>
                <BreadcrumbItem to="/questionpage">问答</BreadcrumbItem>
                <BreadcrumbItem>问答详情</BreadcrumbItem>
			</Breadcrumb>

			<Row type="flex" justify="space-between">
        	<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
    			<Row>
    				<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'question-title'">
    					{{question.title}}
    				</Col>     				
        			<Col :class-name="'question-info'" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
        				<span>
        					<i class="icon icon-shoucang"></i>
					  		{{question.collection_count}}
        				</span>
        				<a href="#comment">
	        				<span style="color:#999">
	        					<i class="icon icon-message3"></i>
						  		{{question.answer_count}}
	        				</span>
        				</a>
        				<span>
  							<Icon type="ios-color-filter-outline" size="18" style="color: #999;cursor: pointer;"></Icon>
  							{{question.price}}
        				</span>        				
        			</Col>
        			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
        				<Col class="question-describe" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
	        				<div class="describe-add">问题补充：</div><div class="describe-add-content" v-html="question.describe"></div>
        				</Col>
        				<Col class="question-warn" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="!question.best_answer">
        					该问题被采纳后，系统将赠送{{question.price}}个种子作为奖励
        				</Col>
        				<Col class="more-best-answer" :xs="{'span':4,'offset':20}" :sm="{'span':4,'offset':20}" :lg="{'span':4,'offset':20}" v-if="question.best_answer">
        					<Button :class="'common-button3'" @click="answer_panel?answer_panel=false:answer_panel=true">我有更好的回答</Button>
        				</Col>        				
        			</Col>
        			<Col :class-name="'answer-frame'"  :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="!question.best_answer||answer_panel">
	        			<div>
	        				<textarea class="common-textarea" placeholder="请输入回答内容..." v-model="answer_content"></textarea>
	        			</div>
	        			<div>
	        				<Col :xs="{'span':4,'offset':20}" :sm="{'span':4,'offset':20}" :lg="{'span':4,'offset':20}">
	        					<Button :class="'common-button3'" @click="submit_answer">提交回答</Button>
	        				</Col>
	        			</div>
        			</Col>
        			<Col v-if="question.best_answer"  :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'answer-zone'">
        				<div class="best-answer">
							<img src="/static/best_answer.png">
        					<div class="best-answer-title">
	        					<span>最佳回答</span>
	        					<label>本答案由提问者推荐</label>
        					</div>
        				</div>
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'answer-info'" style="border-bottom: 0;">
							<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
								<div class="avatar-frame-new" @click="go('/user/userzone/'+question.best_answer.uid)">
									<img v-bind:src="question.best_answer.image">
								</div>
							</Col>
							<Col :xs="{'span':17}" :sm="{'span':17}" :lg="{'span':17}">
								<div class="answer-username" @click="go('/user/userzone/'+item.uid)">{{question.best_answer.username}}
									<img src='/static/author_confirm.png' v-if="question.best_answer.author_info&&question.best_answer.author_info.status==1">    
									&nbsp<span class="answer-time">{{question.best_answer.time}}</span>                    	
								</div>
								<div class="user-desc">{{question.best_answer.desc}}</div>
							</Col>
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<div class="best-answer-content" v-html="question.best_answer.content">
									<img src="/static/accept.png">
								</div>
							</Col>
						</Col>
        			</Col>          			
    			</Row>    			
    			<Row :class-name="'answer-zone'">
    				<Col :class-name="'answer-title'" id="comment">
						<label v-if="question.best_answer">其他回答</label>
						<label v-else>全部回答</label>
    				</Col>
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in question.other_answers" :key="key" :class-name="'answer-info'">
						<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
							<div class="avatar-frame-new" @click="go('/user/userzone/'+item.uid)">
								<img v-bind:src="item.image">
							</div>
						</Col>
						<Col :xs="{'span':17}" :sm="{'span':17}" :lg="{'span':17}">
							<div @click="go('/user/userzone/'+item.uid)" class="answer-username" v-bind:title="item.username">{{item.username}}
								<img src='/static/author_confirm.png' v-if="item.author_info&&item.author_info.status==1">
								&nbsp<span  class="answer-time">{{item.time}}</span>
							</div>
							<div class="user-desc">{{item.desc}}</div>
							<div class="answer-time"></div>
						</Col>
						<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'accept-answer'" v-if="(question.is_self!=item.uid)&&(!question.best_answer)">
							<span v-if="question.is_self" class="pointer" @click="accept_answer(key)">采纳为最佳答案</span>
						</Col>
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
							<div class="answer-content" v-html="item.content"></div>
						</Col>        						
					</Col>
    			</Row>     			
			</Col>
            <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
            	<UserPannel :user="question.user"></UserPannel>
				<PageRight :page-id="page_id"></PageRight>
            </Col>
		</Row>
        </Col>
	</Row>
	<FooterArea></FooterArea>
    <FloatSideBar></FloatSideBar>
    <AccountPannel ref="AccountPannel"></AccountPannel>
</div>
</template>
<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import PageRight from '../components/MainRight.vue';
import UserPannel from '../components/UserPannel.vue';
import AccountPannel from '../components/AccountPanel.vue';
export default{
	components: {NavHeader,FooterArea,FloatSideBar,PageRight,UserPannel,AccountPannel},
	mounted(){
        document.title = '菠菜圈| 问答详情';
		var myDate = new Date()
		var v = this
		this.https.get('/front/question_details/render',{params:{
			qid:v.$route.params.qid
		}}).then((r)=>{
			if (!r.data) {
				v.$Message.warning('该提问不存在或已被提问者删除！')
				v.$router.go(-1)
			}else{
				v.question = r.data
			}	
		}).catch((e)=>{
			console.log(e)
		});
	},
	data(){
		return {
            page_id: 23,
            ad_list:'',
			question: '',
			answer_panel: false,
			answer_content: ''
		}
	},
	methods:{
		go(path){
			this.$router.push(path)
		},
		accept_answer(key){
			var v = this
			var qid = v.question.id
			var rid = v.question.other_answers[key].id
			v.https.get('/front/question_details/accept_question',{
				params:{
					qid:qid,
					rid:rid
				}
			}).then((r)=>{
				if (r.data.code == 1) {
					v.$Message.success('设为最佳答案');
					v.$set(v.question,'best_answer',v.question.other_answers[key]);
				}else{
					console.log(r.data.msg)
				}
			}).catch((e)=>{
				console.log(e)
			})
		},
		submit_answer(){
			if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}
			var qid = this.question.id;
			var content = this.answer_content;
			content = content.replace(/\n/g,'<br/>');
			if (content.length>500) {
				this.$Message.success('回答字数太长，请保证在500字之内')
				return false
			}
			var v = this;
			v.https.post('/front/question_details/answer_question',{
				qid:qid,
				content:content
			}).then((r)=>{
				if (r.data.code == 1) {
					v.$Message.success('提交答案成功')
					var new_answer = []
					new_answer['content'] = content
					new_answer['qid'] = qid
					new_answer['uid'] = r.data.user_info.id
					new_answer['username'] = r.data.user_info.username
					new_answer['image'] = r.data.user_info.image
					new_answer['created_at'] = 'just now'
					var len = Object.keys(v.question.other_answers).length
					v.question.other_answers[len] = new_answer
					v.answer_content = ''
					v.https.get('/common/change_read_status?status=1&model=question&id='+qid)
				}else{
					v.$Message.error(r.data.msg);
				}
			}).catch((e)=>{
				console.log(e.data)
			})
		}
	}
}
</script>
<style lang="scss" scoped>
    .icon {
        font-size: .3rem;
        font-style: normal;
        color: #999;
        &:hover, &:focus {
            color: #28b28a;
        }
    }
	.icon-message3 {
		vertical-align: baseline;
	}
	.icon-shoucang {
		vertical-align: text-bottom;
	}
	* {
		box-sizing: border-box;
	}
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
#question_detail {
	.container {
		width: 1200px;
		min-height: 10rem;
        margin: 20px auto;
		.page-left {
			padding: 20px 0 0 0;
			.question-title {
				font-size: 18px;
				font-weight: bold;
				color: #333333;
				padding-bottom: 20px; 
			}
			.question-info {
				font-size: 12px;
				color: #999;
				padding-bottom: 15px;
				border-bottom: 1px solid #efefef;
				span {
					font-size: 14px;
					padding: 0 20px 0 0;
				}				
			}
			.question-describe {
				font-size: 14px;
				color: #666;
				padding: 18px 0;
				white-space: pre-wrap;
				text-align: justify;
				.describe-add{
					display: inline-block;
					width: 80px;
					vertical-align: top;	
				}
				.describe-add-content{
					display: inline-block;
					width: 700px;
					vertical-align: top;
				}
			}
			.best-answer {
				padding: 20px 0 0 10px;
				border-bottom: 1px solid #efefef;
				img {
					display: inline-block;
					vertical-align: text-bottom;
				}
				.best-answer-title {
					display: inline-block;
					vertical-align: middle;
					padding: 0 10px 10px 0;
					span{
						font-size: 18px;
						font-weight: bold;
						color: #28b28a;
						padding-right: 10px;
						padding-left: 5px;
					}
					label {
						font-size: 12px;
						color: #999999;
					}									
				}
			}
			.best-answer-content {
				position: relative;
				padding-top: 20px;
				font-size: 16px;
				img{
					position: absolute;
					left: 500px;
					top:-60px;
				}
			}
			.question-warn {
				font-size: 12px;
				color: #666;
				padding: 5px 0;
				border:1px dashed #28b28a;
				background-color: #dff4ee;
				width: 290px;
				text-align: center;
			}
			.more-best-answer {
				padding-top: 20px;
				font-size:14px;			 
			}
			.answer-frame {
				margin-top: 30px;
				padding: 15px 15px 15px 15px;
				background-color: #f9fafb;
				.common-textarea {
					width: 100%;
					min-height: 80px;
					padding: 10px;
					color: #333;
					font-size: 14px;
					border-radius: 3px;
					border: 1px solid #d2dbe1;
					outline: none;
					transition: all .5s;
					-webkit-transition: all .5s;
					-moz-transition: all .5s;
					-ms-transition: all .5s;
					-o-transition: all .5s;
					&:focus {
						border-color: #28b28a;
						outline: 0;
					}
				}
			}
			.common-button3 {
				width: 118px;
				height: 40px;
				line-height: 14px;
				text-align: center;
				margin-top: 18px;
				font-size: 14px;
				color: #fff;
				border-radius: 2px;
				font-weight: 500;
				padding: 10px 0;
				outline: none;
				border: 1px solid #28b28a;
				&:hover{
					color: #fff;
					background-color: #149f77;
					border-color: #149f77;
					transition: #149f77 .2s linear,background-color .2s linear,border .2s linear;
					transition-property: color, background-color, border;
					transition-duration: 0.2s, 0.2s, 0.2s;
					transition-timing-function: linear, linear, linear;
					transition-delay: initial, initial, initial;
				}
			}				
			.answer-zone {
				margin-top: 30px;
				padding: 30px 0 30px 10px;
				.answer-title {
					font-size: 18px;
					font-weight: bold;
					border-bottom: 1px solid #efefef;
					padding-bottom: 12px;
				}
				.answer-info {
					padding: 20px 10px;
					border-bottom: 1px solid #efefef;
					.accept-answer {
						padding-top: 20px;
						color: #adadad;
						text-align: center;
						span{
							display: none;
						}
					}
					&:hover{
						.accept-answer{
							span{
								display: inline-block;
								color: #28b28a;
							}
						}
					}
				}
			}
			.avatar-frame-new {
				width: 100%;
				height: 100%;
				border-radius: 50%;
				overflow: hidden;
				text-align: center;
				border: 1px solid #e0e0e0;
				img {
					cursor: pointer;
					border-radius: 50%;
					width: 100%;
					height: 100%;
					background: #e9e9e9;
				}
			}
			.answer-username {
				cursor: pointer;
				width: 100%;
				padding: 7px 0 0 15px;
				font-size: 16px;
				color: #333;
				font-weight: bold;
				overflow : hidden;
				text-overflow: ellipsis;
				-webkit-text-overflow: ellipsis;
				-moz-text-overflow: ellipsis;
				-ms-text-overflow: ellipsis;
				white-space: nowrap;
				-moz-white-space: nowrap;
				-webkit-white-space: nowrap;
				-o-white-space: nowrap;
			}
			.user-desc{
				padding: 0 0 0 15px;
			}
			.answer-time {
				font-size: 13px;
				font-weight: lighter;
				color: #999;
				padding-bottom: 3px;
				padding-left: 15px;
			}
			.answer-content {
				cursor: pointer;
				font-size: 16px;
				color: #333;
				padding: 20px 0 10px 0;
				text-align: left;
			}
		}
	}
}
</style>