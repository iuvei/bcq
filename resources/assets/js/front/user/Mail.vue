<template>
	<div id="mail">
		<Tabs value="name2" v-if="!loading">
	        <TabPane label="私信夹" name="name2">
	        	<Row :class-name="'mail'" v-if="message.data.length">
        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'mail-title'">
	        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'mail-check'">序号</Col>
	        			<Col :xs="{'span':11}" :sm="{'span':11}" :lg="{'span':11}" :class-name="'title-name'">发件人</Col>
	        			<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">时间</Col>
	        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">状态</Col>
	        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">操作</Col>
	        		</Col>
	        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'mail-frame'">
		        		<CheckboxGroup v-model="message.choice">
			        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'mail-content'" v-for="(item,key) in message.data" :key="key">	
			        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'mail-check'">
			        				<Checkbox :label="key" class="common-checkbox">{{key + 1}}</Checkbox>
			        			</Col>
			        			<Col :xs="{'span':11}" :sm="{'span':11}" :lg="{'span':11}" :class-name="'title-name'"><span class="pointer" @click="look_mail(key,'message')">{{item.username}}</span></Col>
			        			<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">{{item.date}}</Col>
			        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
			        				<span v-if="item.status==2" class="pointer" @click="look_mail(key,'message')"><img src="/static/readed.png"></span>
			        				<span v-if="item.status==1" class="pointer" @click="look_mail(key,'message')"><img src="/static/noread.png"></span>
			        			</Col>
			        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
			        				<span class="pointer" @click="delete_single(item.id,'message')">
			        					<Icon type="trash-a" size="20" color="gray"></Icon>
			        				</span>
			        			</Col>
			        		</Col>
		        		</CheckboxGroup>
		        		<div v-if="message.count">
		        		<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'  all-check mail-check'">
	        				<Checkbox v-model="message.check_all" class="common-checkbox" @on-change="check_all('message')">全选</Checkbox>
	        			</Col>
        				<Col :xs="{'span':15}" :sm="{'span':15}" :lg="{'span':15}" :class-name="'all-check'">
        					&nbsp
        				</Col>
	        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'all-check'">
	        				<span class="pointer">
	        				</span>
	        			</Col>
	        			<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'all-check'">
	        			<span class="pointer" @click="delete_all('message')">
	        				<Icon type="trash-a" size="20" color="gray"></Icon>
	        			</span></Col>
	        			</div>		        		
	        		</Col>
	        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'page-footer'">
	        			<Page :total="message.count" :page-size="limit" @on-change="setMessagePage" :class-name="'common-page'">
	        			</Page>
	        		</Col>
	        	</Row>	
	        	<Row v-else>
	        		<Col :xs="24" :sm="24" :lg="24" :class-name="'no-mail'">
		        		<center>
		        			<img src="/static/no_mail.png">
		        			<div class="attention">暂时没有私聊消息喔~</div>
		        		</center>
	        		</Col>
	        	</Row>        	
	        </TabPane>					        
	    </Tabs>	
    <Modal
        v-model="message.look"
        :title="'发件人： ' + message.look_mail.username"
        @on-ok="look_mail">
        <Row>
        	<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'look-content'">	
        		内容：
        	</Col>
        	<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}" :class-name="'look-content'">
        		{{message.look_mail.content}}
        	</Col>
        	<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'look-content'">	
        		回复：
        	</Col>
        	<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}" :class-name="'look-content'">
        		<textarea class="common-textarea" v-model="message.reply">
        			
        		</textarea>
        	</Col>
    	</Row>
	 	<Row slot="footer">
		 	<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			 	<Button class="common-button3" style="font-size:18px;" @click="reply">
			 		发&nbsp&nbsp送
			 	</Button>
		 	</Col>
	 	</Row>
    </Modal>    
	</div>
</template>
<script>
	export default{
		mounted(){
			var v = this;
			this.https.get('/front/user_center/mail_render').then((r)=>{
				v.message.count = parseInt(r.data.message.count);
				v.message.data = r.data.message.data;			
				v.loading = false
			}).catch((e)=>{
				console.log(e);
			});		
		},
		data(){
			return{
				loading:true,
				message:{
					data:'',
					count:0,
					choice:[],
					check_all:false,
					look:false,
					look_mail:'',
					current:1,
					reply:''				
				},
				limit:10
			}
		},
		methods:{
			reply(){
				var v = this;
				this.https.post('/front/user_mail/send_message',{
					to:v.message.look_mail.from,
					content:v.message.reply
				}).then((r)=>{
					if(r.data.code == 1){
						this.$Message.success('发送成功');
					}else{
						this.$Message.error('发送失败');
					}
				}).catch((e)=>{
					console.log(e);
				});	
				this.message.look = false;
				this.message.reply = ''
			},
			look_mail(key,type){
				var status = 1;
				if(type == 'mail'){
					this.mail.look_mail = this.mail.data[key].mail;
					this.mail.look = true;
					status = this.mail.data[key].status;
					var id = this.mail.data[key].id;
				}else{
					this.message.look_mail = this.message.data[key];
					this.message.look = true;
					status = this.message.data[key].status;
					var id = this.message.data[key].id;
				}
				if (status == 1) {
					if (type == 'mail') {
						this.view_mail(id,type)
						this.mail.data[key].status = 2;
					}else{
						this.view_mail(id,type)
						this.message.data[key].status = 2;
					}
				}
			},
			check_all(type){
				if (type == 'mail') {
					if (this.mail.check_all) {
						for (var i = 0; i < this.mail.data.length; i++) {
							this.mail.choice.push(i);
						}
					}else{
						this.mail.choice = [];
					}
				}else{
					if (this.message.check_all) {
						for (var i = 0; i < this.message.data.length; i++) {
							this.message.choice.push(i);
						}
					}else{
						this.message.choice = [];
					}					
				}
			},
			setMailPage(page){
				var v = this;
				this.https.get('/front/user_mail/get_mail',{
					params:{
						page:page-1
					}
				}).then((r)=>{
					v.mail.data = r.data.data
					v.mail.count = r.data.count
				}).catch((e)=>{
					console.log(e);
				});					
			},
			setMessagePage(page){
				var v = this;
				this.https.get('/front/user_mail/get_message',{
					params:{
						page:page-1
					}
				}).then((r)=>{
					v.message.data = r.data.data
					v.message.count = r.data.count
				}).catch((e)=>{
					console.log(e);
				});	
			},
			view_mail(id,type){
				this.https.get('/front/user_mail/view_mail',{
					params:{
						id:id,
						type:type
					}
				}).then((r)=>{
					console.log(r.data)
				}).catch((e)=>{
					console.log(e);
				});	
			},
			delete_single(id,type){
				var delete_id = [];
				var v = this;
				delete_id.push(id);
				this.https.get('/front/user_mail/delete_mail',{
					params:{
						id:delete_id,
						type:type
					}
				}).then((r)=>{
					if (type == 'mail') {
						v.setMailPage(v.mail.current);						
					}else{
						v.setMessagePage(v.message.current);
					}
				}).catch((e)=>{
					console.log(e);
				});			
			},
			delete_all(type){
				var v = this;
				var id = [];
				if(type == 'mail'){
					if (!v.mail.choice.length) {
						return false;
					}
					for (var i = 0; i < v.mail.choice.length; i++) {
						var mid = v.mail.data[v.mail.choice[i]].id;
						id.push(mid);
					}
					v.setMailPage(v.mail.current);		
				}else{
					if (!v.message.choice.length) {
						return false;
					}
					for (var i = 0; i < v.message.choice.length; i++) {
						var mid = v.message.data[v.message.choice[i]].id;
						id.push(mid);
					}	
					v.setMessagePage(v.message.current);					
				}
				this.https.get('/front/user_mail/delete_mail',{
					params:{
						id:id,
						type:type
					}
				}).then((r)=>{
					console.log(r.data)
				}).catch((e)=>{
					console.log(e);
				});					
			}
		}
	}
</script>
<style lang="scss" scoped>
#mail{
	.no-mail{
		margin-top: 100px;
		.attention{
			margin-top: 20px;
			font-size: 14px;
		}
	}
	.mail{
		.mail-title{
			padding-top: 20px;
			font-size:16px;
			padding-bottom:5px; 
			border-bottom: 1px solid #666666; 
			text-align: center;
		}
		.all-check{
			margin-top: 15px;
			text-align: center;
		}
		.mail-check{
			text-align: left;
			padding-left:30px; 
		}
		.mail-frame{
			min-height: 280px;
			padding-bottom: 20px;
			.mail-content{
				padding:10px 0px 5px 0px; 
				font-size: 14px;
				text-align: center;
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}
			}			
		}
		.title-name{
			&:hover{
				color: #48b48a;
				span{
					border-bottom: 1px solid #48b48a;
				}
			}
			text-align: left;
			overflow: hidden;
	        text-overflow: ellipsis;
	        -o-text-overflow:ellipsis;
	        display: -webkit-box;
	        -webkit-line-clamp: 1;
	        -webkit-box-orient: vertical;
		}
	}
	.page-footer{
		text-align: center;
	}
}
</style>