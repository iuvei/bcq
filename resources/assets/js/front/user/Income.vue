<template>
	<div id="income">
		<IncomeBar v-on:getlast="getlast" ref="IncomeBar" class="IncomeBar"></IncomeBar>
		<Tabs v-model="name" @on-click="tab_change"  class="tab-weight-nomal">
	        <TabPane label="收益报表" name="report" class="report">
	        	<Row :class-name="'date-bar'">
	        		<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
	        			<Tag class="date-choice" v-bind:class="{'date-choice-active':day_range==7}"><b @click="get_list_pre(7)">7天</b></Tag>
	        		</Col>
	        		<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
	        			<Tag class="date-choice" v-bind:class="{'date-choice-active':day_range==14}"><b @click="get_list_pre(14)">14天</b></Tag>
	        		</Col>
	        		<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
	        			<Tag class="date-choice" v-bind:class="{'date-choice-active':day_range==30}"><b @click="get_list_pre(30)">30天</b></Tag>
	        		</Col>
	        		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'datepicker'">
	        			<DatePicker size="small" type="date" placeholder="请选择日期" @on-change="choice_date($event,'start')"></DatePicker> ~ <DatePicker size="small" type="date" placeholder="请选择日期" @on-change="choice_date($event,'end')"></DatePicker>
	        		</Col>	        		
	        	</Row>
	        	<Row :class-name="'record-bar'">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'record-bar-title'">
		        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
		        			日期	
		        		</Col>
		        		<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
		        			文章标题
		        		</Col>
		        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
		        			阅读量
		        		</Col>
		        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
		        			收益金额
		        		</Col>
	        		</Col>
	        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-if="publsih_list.length||loading">
		        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'record-bar-list'" v-for="(item,key,index) in publsih_list" :key="key">
			        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'record-bar-date'">
			        			{{item.created_at}}
			        		</Col>
			        		<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}" :class-name="'record-bar-content'">
			        			<span class="line1">
			        			<a v-bind:href="'/news/newspage/'+item.id" target="blank">{{item.title}}</a>
			        			</span>
			        		</Col>
			        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'record-bar-view'">
			        			{{item.f_view}}
			        		</Col>
			        		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'record-bar-comment'">
			        			<span style="color:#28b28a">{{item.income}}</span>
			        		</Col>
		        		</Col>
	        		</Col>
	        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-else>
	        			<center>
	        				<img src="/static/no_news.png" style="margin-top:50px;">
	        				<p style="margin-top:25px;font-size:16px;">您最近没有新文章，点击下面按钮开始您的写作</p>
	        				<div style="width:140px;margin-top:40px;">
	        					<Button class="common-button3" @click="publish">立即发布</Button>
	        				</div>
	        			</center>
	        		</Col>
	        	</Row>
	        	<center class="page-break" v-if="page_break">
	        		<Page :total="publsih_list_count" :page-size="20" :current="page" @on-change="get_more_list" class="common-page"></Page>
	        	</center>
	    	</TabPane>
	        <TabPane label="报表提成" name="income" class="income">
	        	<Row :class-name="'income-title'">
	        		<Col :xs="6" :sm="6" :lg="6">提现时间</Col>
	        		<Col :xs="6" :sm="6" :lg="6">提现金额</Col>
	        		<Col :xs="6" :sm="6" :lg="6">手续费用</Col>
	        		<Col :xs="6" :sm="6" :lg="6">出款状态</Col>
	        	</Row>
	        	<Row v-if="incomelist.length">
	        		<Col v-for="(item,key) in incomelist" :key="key" :xs="24" :sm="24" :lg="24" :class-name="'income-list'">
		        		<Col :xs="6" :sm="6" :lg="6">{{item.created_at}}</Col>
		        		<Col :xs="6" :sm="6" :lg="6">{{item.price}}</Col>
		        		<Col :xs="6" :sm="6" :lg="6">15</Col>
		        		<Col :xs="6" :sm="6" :lg="6"><b v-if="item.status==-2" style="color:red">已取消</b><b v-if="item.status==-1" style="color:red">审核未通过</b><b v-if="item.status==0" style="color:red">审核中</b><b v-if="item.status==1" style="color:#28b28a">审核通过，待出款</b>
		        		<b v-if="item.status==2" style="color:#28b28a">已出款，请查收</b>
		        		<a v-if="item.status==0" @click="cancel(item.id,key)">&nbsp&nbsp取消提取</a>
		        		</Col>
	        		</Col>
	        		<Col :xs="24" :sm="24" :lg="24">
			        	<center class="page-break">
			        		<Page :total="incomecount" :page-size="20" @on-change="get_income_list" class="common-page"></Page>
			        	</center>	
	        		</Col>
	        	</Row>
	        	<Row v-else>
	        		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
	        			<center>
	        				<img src="/static/no_news.png" style="margin-top:50px;">
	        				<p style="margin-top:25px;font-size:16px;">您还没有过提款申请</p>
	        				<div style="width:140px;margin-top:40px;">
	        					<Button class="common-button3" @click="go_takeout">我要提成</Button>
	        				</div>
	        			</center>
	        		</Col>
	        	</Row>
	        </TabPane>
	        <TabPane label="我要提成" name="raise" class="raise">
	        	<Row  type="flex" align="middle" :class-name="'raise-frame'">
	        		<Col :xs="18" :sm="18" :lg="18">
		        		<Row  type="flex" align="middle">
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">剩余收益金额：</Col>
			        		<Col :xs="18" :sm="18" :lg="18"> <b style="font-size:18px">{{income_last}}</b></Col>
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">本次提取金额：</Col>
			        		<Col :xs="18" :sm="18" :lg="18"> <input class="common-input" v-model="takeout" @blur="check_mount" placeholder="提取金额必须大于手续费用（15元）"></Col>
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">联系电话：</Col>
			        		<Col :xs="18" :sm="18" :lg="18">
								<Input v-model="phone" class="data-input common-iview-input">
                                    <Select v-model="zonecode" slot="prepend" placeholder="中国大陆 (+86)" ref="select" :transfer="true" style="min-width:3rem;width:auto" class="phone-check">
                                        <Option v-for="(item,key) in countrycode" :key= "key" :value="item.code">
                                            {{item.value}} (+{{item.code}})
                                        </Option>
                                    </Select>
                                </Input>			        			
			        		</Col>
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">验证码：</Col>
			        		<Col :xs="11" :sm="11" :lg="11"> <input class="common-input" placeholder="请输入验证码"  v-model="authcode"></Col>
			        		<Col :xs="{'span':6,'offset':1}" :sm="{'span':6,'offset':1}" :lg="{'span':6,'offset':1}"> 
				        		<div class="common-button2" v-if="codesend">{{countdown}}</div>
				        		<div class="common-button3 pointer" style="height:36px;line-height:36px" v-else @click="getAuthCode(phone)">获取验证码</div>
			        		</Col>
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">所在地区：</Col>
			        		<Col :xs="18" :sm="18" :lg="18"> 
				        		<Select v-model="city" :placeholder="'请选取您所在的位置'" class="common-select" @on-change="choice_city">
							        <Option v-for="(item,key) in cityList" :value="item" :key="key">
							        	{{ item }}
							        </Option>
							    </Select>
							</Col>
			        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">提取方式：</Col>
			        		<Col :xs="18" :sm="18" :lg="18"> 
				        		<Select v-model="payment" :placeholder="'请选取提取方式'" class="common-select">
							        <Option v-for="(item,key) in paymentList" :value="item" :key="key">
							        	{{ item }}
							        </Option>
							    </Select>
			        		</Col>
			        		<Col :xs="24" :sm="24" :lg="24" v-if="payment!='银行卡'">
			        			<Row  type="flex" align="middle">
			        				<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">账户号码：</Col>
					        		<Col :xs="18" :sm="18" :lg="18"> <input class="common-input" placeholder="请输入微信号或支付宝账号，以便打款" v-model="accountnumber"></Col>
					        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">账户持有人姓名：</Col>
					        		<Col :xs="18" :sm="18" :lg="18"> <input class="common-input" placeholder="请输入账户持有人的真实姓名" v-model="accountname"></Col>
				        		</Row>
			        		</Col>
			        		<Col :xs="24" :sm="24" :lg="24" v-else>
			        			<Row  type="flex" align="middle">
				        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">银行名称：</Col>
				        		<Col :xs="18" :sm="18" :lg="18"> <input class="common-input" placeholder="请输入您的银行名称" v-model="bankname"></Col>
				        		<Col :xs="6" :sm="6" :lg="6" :class-name="'raise-left'">银行账号：</Col>
				        		<Col :xs="18" :sm="18" :lg="18"> <input class="common-input" placeholder="请输入您的银行账号" v-model="banknumber"></Col>
				        		</Row>
			        		</Col>
			        	</Row>
			        	<Col :xs="{'span':6,'offset':12}" :sm="{'span':6,'offset':12}" :lg="{'span':6,'offset':12}" :class-name="'submit-frame'">
		        			<div class="common-button2" @click="takeout_submit">提交</div>
		        		</Col>
	        		</Col>
	        	</Row>
	        </TabPane>
	    </Tabs>
	</div>
</template>
<script>
import IncomeBar from './IncomeBar'
import country from '../common/countrycode.js'
	export default{
		components:{
			IncomeBar
		},
		props:['authorinfo'],
		mounted(){
			var v = this
			this.get_publish_list(0,0,0)
			this.countrycode = country.countrycode
		},
		data(){
			return {
				name:'report',
				publsih_list:[],
				publsih_list_count:0,
				start:'',//起始时间
				end:'',//结束时间
				day_range:'',//多少天之内的数据
				page:0,
				page_break:0,
				cityList:[
					'大陆','台湾','香港','澳门','老挝','菲律宾'
				],
				paymentList:[
					'支付宝','微信'
				],
				phone:'',
				countrycode:'',
				city:'',
				payment:'',
				zonecode:'',
				income_last:0,
				takeout:'',
				authcode:'',
				accountnumber:'',
				accountname:'',
				banknumber:'',
				bankname:'',
				time:0,
				codesend:false,
				incomelist:'',
				incomecount:0,
				loading:true
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
		methods:{
			go_takeout(){
				if (this.authorinfo.code == 1) {
					this.name = 'raise'
				}else{
					this.$router.push('/news/beAuthor')
				}
			},
			publish(){
				this.$router.push('/user/write')
			},
			cancel(id,key){
				var v = this
				this.https.post('/front/user_center/takeout_cancel',{
					id:id
				}).then((r)=>{
					console.log(r.data)
					if (r.data.code) {
						v.incomelist[key].status = -2
					}else{
						v.$Message.error(r.data.msg)
					}
				}).catch((e)=>{
					console.log(e)
				})
			},
			tab_change(name){
				if (name == 'income') {
					this.get_income_list(1)
				}
			},
			get_income_list(page){
				var v = this
				this.https.get('/front/user_center/get_income_iist',{params:{
					page:page
				}}).then((r)=>{
					v.incomelist = r.data.list
					v.incomecount = r.data.count
				}).catch((e)=>{
					console.log(e)
				})
			},
			takeout_submit(){
				if (!this.takeout||this.takeout>this.income_last) {
					this.$Message.error('请填写正确的提取金额')
					return false
				}
				if (this.takeout<15) {
					this.$Message.error('提取金额必须大于手续费用（15元）')
					return false
				}
				if (!this.authcode) {
					this.$Message.error('请填写手机验证码')
					return false
				}
				if (!this.zonecode) {
					this.zonecode = '86'
				}
				if (!this.city) {
					this.$Message.error('请选择所在地区')
					return false
				}
				if (!this.payment) {
					this.$Message.error('请选择提取方式')
					return false
				}
				if (this.payment == '银行卡') {
					if (!this.banknumber||!this.banknumber) {
						this.$Message.error('请填写银行名称以及银行账号')
						return false
					}
				}else{
					if (!this.accountnumber||!this.accountname) {
						this.$Message.error('请填写付款账号以及账户人真实姓名')
						return false
					}
				}
				if (!this.phone_verify(this.phone)) {
					return false
				}
				
				var v = this
				this.https.post('/front/user_center/takeout_request',{
					takeout:v.takeout,
					phone:v.phone,
					zonecode:v.zonecode,
					authcode:v.authcode,
					city:v.city,
					payment:v.payment,
					banknumber:v.banknumber,
					accountnumber:v.accountnumber,
					bankname:v.bankname,
					accountname:v.accountname,
				}).then((r)=>{
					if (!r.data.code) {
						v.$Message.error(r.data.msg)
					}else{
						v.phone = ''
						v.authcode = ''
						v.income_last = (v.income_last - v.takeout).toFixed(3)
						v.$refs.IncomeBar.income_last = v.income_last
						v.$refs.IncomeBar.income_pick = parseFloat(v.$refs.IncomeBar.income_pick) + v.takeout
						v.$Message.success(r.data.msg)
						v.takeout = ''
					}
				}).catch((e)=>{
					console.log(e)
				})
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
                    var zonecode = 86
                }else{
                    var zonecode = v.zonecode  
                }
                if(!this.phone_verify(phone)){
                    return false
                }
                v.time = 60;
                v.timer();
                this.https.get('/common/get_verification_code',{
                params:{
                    phone:phone,
                    zonecode:zonecode
                }
                }).then(function(r){
                    if (r.data.code == 1){
                        v.$Message.success('验证码已发送');
                    }else{
                        v.$Message.error(r.data.msg);
                    }
                }).catch(function(e){
                    console.log(e);
                });
            },            		
			check_mount(){
				if (this.takeout> this.income_last) {
					this.takeout = this.income_last
				}
				if (!this.takeout||this.takeout<0) {
					this.takeout = 0
				}
				this.takeout = parseInt(this.takeout)
			},
			getlast(last){
				this.income_last = last
			},
			choice_date(date,type){
				if (type == 'start') {
					this.start = date
				}
				if (type == 'end') {
					this.end = date
				}
				
				this.day_range = ''

				this.page = 1

				this.page_break = 1

				this.get_publish_list(this.page,this.start,this.end)
			},
			get_list_pre(range){

				var start = ''

				var end = ''

				if (range) {

					this.day_range = range

					var currentDate = new Date()

					this.end = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate()

					currentDate.setDate(currentDate.getDate() - range),//获取前7天的时间戳
     				
     				this.start = currentDate.getFullYear() + '-' + (currentDate.getMonth() + 1) + '-' + currentDate.getDate()
				}
				this.page = 1

				this.page_break = 1

				this.get_publish_list(this.page,this.start,this.end)

			},
			get_publish_list(page,start,end){
				var v = this
				this.https.get('/front/user_center/publsih_list',{
					params:{
						page:page,
						start:start,
						end:end
					}
				}).then((r)=>{
					v.publsih_list = r.data.lists
					v.publsih_list_count = r.data.count
					v.loading = false
				}).catch((e)=>{
					console.log(e)
				})
			},
			get_more_list(page){
				this.get_publish_list(page,this.start,this.end)
				this.page = page
			},
			choice_city(city){
				if (city == '台湾') {
					this.$set(this.paymentList,2,'银行卡')
				}else{
					if(this.paymentList.length==3){
						this.paymentList.splice(2)
					}
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
            }
		}
	}
</script>
<style lang="scss" scoped>	
#income{
	position: relative;
	.IncomeBar{
		width: 100%;
		position: absolute;
		top: 50px;
	}
	.report{
		margin-top: 120px;
		.date-bar{
			padding-top: 10px;
			text-align: center;
			.start-day,.end-day,.date-choice{
				width: 90%;
				font-size: 14px;
				&:hover{
					color: #28b28a!important;
				}
			}
			.date-choice-active{
				border-color: #28b28a;
			}
			.datepicker{
				.ivu-date-picker{
					width: 110px!important;
				}
			}
		}
		.record-bar{
			padding-top: 20px;
			min-height: 500px;
			.record-bar-title{
				padding-top: 10px;
				padding-bottom: 10px;
				text-align: center;
				font-size: 16px;
				border-top:1px solid #bfbfbf;
				border-bottom:1px solid #bfbfbf; 
			}
			.record-bar-list{
				padding: 10px 0px 10px 0px;
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}
				.record-bar-date,.record-bar-view,.record-bar-comment,.record-bar-content{
					text-align: center;
					font-size: 14px;
					.line1{
						max-height: 20px;
					}	
				}
				a{
					color: #333;
					font-weight: bold;
					&:hover{
						color: #28b28a;
					}
				}			
			}
		}	
		.page-break{
			padding-top: 20px;
		}
	}
	.income{
		margin-top: 135px;
		.income-title{
			text-align: center;
			font-size: 16px;
			padding: 10px 0px 10px 0px;
			border-top: 1px solid #bfbfbf;
			border-bottom: 1px solid #bfbfbf;
		}
		.income-list{
			font-size: 14px;
			padding:10px 0px 10px 0px;
			text-align: center;
			border-bottom: 1px solid #f2f2f2;
			&:hover{
				background-color:#f2f2f2; 
			}
		}
		.page-break{
			padding-top: 20px;
		}
	}
	.raise{
		margin-top: 110px;
		.raise-frame{
			padding-top: 20px;
			.raise-left{
				font-size: 16px;
				font-weight: bold;
				line-height: 50px;			
			}
		}
		.submit-frame{
			padding-top: 20px;
		}
	}
}
</style>