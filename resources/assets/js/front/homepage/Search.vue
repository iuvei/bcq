<template>
<div id="search">
	<NavHeader></NavHeader>
	<Row type="flex" justify="center">
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
        	<!--<div class="bread">-->
				<!--<div class="bread-text"><a href="/">首页</a>  > 搜索</div>-->
			<!--</div>-->
			<Breadcrumb separator=">" style="margin: 15px 0;">
				<BreadcrumbItem to="/">首页</BreadcrumbItem>
				<BreadcrumbItem>搜索</BreadcrumbItem>
			</Breadcrumb>
			<Row type="flex" justify="space-between">
        	<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
   			   	<Row>
   			   		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'common-radio radio-frame'">
					    <RadioGroup v-model="type">
					        <Radio label="News">
					            <span>资讯</span>
					        </Radio>
					        <Radio label="Question">
					            <span>问答</span>
					        </Radio>
					        <Radio label="UserData">
					            <span>资料</span>
					        </Radio>
					        <Radio label="Business">
					            <span>供求</span>
					        </Radio>
					    </RadioGroup>   			   			
   			   		</Col>
   			   		<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'serach-input-frame'">
			   			<Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}">
                              <input class='search-frame' placeholder="站内搜索" v-model="keywords"  @keyup.enter="search">
                        </Col>
                        <Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
                            <div class='search-button' @click="search"><Icon type="search" color="white" size="18px"></Icon>搜索</div>
                        </Col>
   			   		</Col>
   			   		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
   			   			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">共为您找到相关结果 {{search_list.length}} 个</Col>
   			   		</Col>
   			   		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'list-frame'">
   			   			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" v-for="(item,key) in search_list" :key="key"  :class-name="'search-list'">
   			   				<Col :class-name="'list-title'">
   			   					<span class="pointer" @click="go(item.id)">{{item.title}}</span>
   			   				</Col>
   			   				<Col :class-name="'list-brief'">
   			   					{{item.brief}}
   			   				</Col>
   			   				<Col :class-name="'list-info'">
   			   					<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
   			   						<span> {{item.time}}</span>
   			   						<span><Icon type="ios-eye-outline" size="14"></Icon> &nbsp&nbsp{{item.view}}</span>
   			   						<span><Icon type="android-star-outline" size="14"></Icon> &nbsp&nbsp{{item.collection}}</span>
   			   					</Col>
   			   					<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'list-username'">
   			   						 {{item.username}}
   			   					</Col>
   			   				</Col>
   			   			</Col>
   			   		</Col>
   			   		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
   			   			<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
		   			   		<div v-if="no_serch" class="no-serch">
					   			未找到"<span>{{no_serch_keywords}}</span>"的相关问题
						    </div>
						</Col>
   			   		</Col>
   			   		<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
	   			   		<div v-if="loading">
				   			<Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
					            <Spin fix>
					                <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
					                <div>努力搜索中</div>
					            </Spin>
					        </Col>
					    </div>
   			   		</Col>
   			   	</Row>		
			</Col>
			<Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">	

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
	mounted(){
        document.title = '菠菜圈| 搜索';
		this.keywords = this.$route.query.keywords
		this.search()
	},
	data(){
		return {
			keywords:'',
			type:'News',
			search_list:'',
			current_type:'News',
			loading:true,
			no_serch:false,
			no_serch_keywords:''
		}
	},
	methods:{
		go(id){
			if (this.current_type == 'News') {
				this.$router.push('/news/newspage/' + id)				
			}else if(this.current_type == 'Question'){
				this.$router.push('/questiondetail/' + id)
			}else if(this.current_type == 'UserData'){
				this.$router.push('/userdata/UserDataDetail/' + id)
			}else{
				this.$router.push('/trade/BusinessDetail/' + id)
			}
		},
		search(model,keywords){
			var model = this.type
			var keywords = this.keywords
			var v = this
			v.https.get('/front/components/search',{
				params:{
					keywords:keywords,
					model:model
				}
			}).then((r)=>{
				v.search_list = r.data
				if (!v.search_list.length) {
					v.no_serch = true
					v.no_serch_keywords = v.keywords
				}else{
					v.no_serch = false
				}
				v.loading = false
				v.current_type = v.type
			}).catch((e)=>{
				console.log(e)
			})
		}
	}
}
</script>

<style lang="scss" scoped>
#search{
	.container{
		width: 1200px;
		min-height: 80vh;
        margin: 20px auto;
		.radio-frame{			
			padding:20px 0px 20px 0px;
			.ivu-radio-wrapper{
				margin-right: 50px!important;
			}
		}
		.serach-input-frame{
			padding-bottom:20px; 
		}
		.no-serch{
			background-color: #eaf3fe;
			span{
				color: red;
			}
			font-size: 16px;
			letter-spacing: 1px;
			padding:20px 0px 20px 20px;
		}
		.list-frame{
			padding-top: 20px;
			.search-list{
				padding:15px 3px 15px 3px;
				border-top: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}			
				.list-title{
					font-size: 18px;
					font-weight: bold;
					color: #333333;
					:hover{
						color: #28b28a;
					}
				}
				.list-brief{
					font-size: 14px;
					color: #8f8f8f;
					padding-top: 15px;
				}
				.list-info{
					font-size: 12px;
					padding-top: 20px;
					padding-left: 2px;	
					color: #8f8f8f;
					.list-username{
						text-align: right;
						padding-right: 5px;
					}
					span{
						padding-right: 15px;
					}			
				}				
			}
		}
	}
}
</style>