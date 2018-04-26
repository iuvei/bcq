<template>
	<div id="recommand" v-if="recommand_list.length">
		<ul class="recommand-list">
			<li class="title">推荐微动态<label class="pointer" @click="get_recommand"><Icon type="refresh"></Icon>&nbsp换一批</label></li>
			<li v-for="(item,key) in recommand_list" :key="key">
				<Row>
					<a :href="'/user/userzone/' + item.user.id" target="_blank">
						<Col :xs="3" :sm="3" :lg="3">
							<div class="avatar-frame-new">
								<img v-bind:src="item.user.image">
							</div>
						</Col>
						<Col :xs="10" :sm="10" :lg="10" :class-name="'userinfo'">
							<div class="username">
								<span v-bind:class="{'username-author':item.user.is_author}">{{item.user.username}}</span>
							</div>
							<div class="userdesc">
								{{item.user.desc}}
							</div>
						</Col>
					</a>
					<Col :xs="{'span':5,'offset':6}" :sm="{'span':5,'offset':6}" :lg="{'span':5,'offset':6}">
						<Button class="common-button" v-if="item.is_attention=='0'" @click="add_attention(item.user.id,item.is_attention,key)"> ＋ 关 注 </Button>
						<Button class="common-button-white" v-if="item.is_attention=='1'" @click="add_attention(item.user.id,item.is_attention,key)"> 已 关 注 </Button>

					</Col>
					<Col :xs="24" :sm="24" :lg="24">
						<a v-bind:href="'/news/micro?id=' + item.id" target="_blank">
							<div class="content line2" v-html="item.content">
								
							</div>
						</a>
					</Col>
				</Row>	
			</li>
		</ul>
		<AccountPannel ref="AccountPannel"></AccountPannel>
	</div>
</template>
<script>
import AccountPannel from '../components/AccountPanel.vue';
export default{
	components: {AccountPannel},
	mounted(){
		this.get_recommand()
	},
	data(){
		return {
			recommand_list:[],
			page:0
		}
	},
	methods:{
		get_recommand(){
			var v = this
			v.https.get('/front/micro/get_recommand_micro',{
				params:{
					page:v.page
				}
			}).then((r)=>{
				if (!r.data.length) {
					v.page = 0
				}else{
					v.recommand_list = r.data
					v.page = v.page + 1
				}
			}).catch((e)=>{
				console.log(e)
			})				
		},
        add_attention(uid,status,key){
            var v = this;
            if (!this.$store.state.user_info) {
	          this.$refs.AccountPannel.show()
	          return false
	        }
            this.https.get('/common/add_attention',{
                params:{
                    aid : uid
                }
            }).then((r)=>{
                if(r.data.code == 1){
                    v.$Message.success(r.data.msg);
                    if (status == 1) {
                        v.recommand_list[key].is_attention = 0;
                    }else{
                        v.recommand_list[key].is_attention = 1;
                    }
                }else{
                    v.$Message.error(r.data.msg);
                }
            }).catch((e)=>{
                console.log(e)
            });
        }	
	}
}
</script>
<style lang="scss" scoped>
#recommand{
	.recommand-list{
		.title{
			font-size: 14px;
			font-weight: bold;
			color: #333;
			position: relative;
			label{
				position: absolute;
				right: 0;
				font-weight: lighter;
				color: #777777;
				&:hover{
					color: #28b28a;
				}
			}
		}		
		li{
			padding-top:20px; 
			.userinfo{
				padding-left: 10px;
				.username{
					font-size: 16px;
					color: #333;
				}	
				.userdesc{
					font-size: 12px;
					color: #999999;
				}
			}
			a{
				color: #333;
				&:hover{
					color: #28b28a;
				}
			}
			.content{
				padding-top: 15px;
				font-size: 14px;
				line-height: 25px;
			}
		}
	}
}	
</style>