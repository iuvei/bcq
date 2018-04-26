<template>
	<div id="platform">
		<NavHeader></NavHeader>
		<Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>服务</BreadcrumbItem>
					<BreadcrumbItem>游戏接口</BreadcrumbItem>
				</Breadcrumb>
				<Row type="flex" justify="center" :class-name="'game-notice'">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
						<p>
							<img src="/static/game-notice.png">想让你们家辛辛苦苦开发的游戏也展示到这？获得更多接入？请 <a
							href="http://wpa.qq.com/msgrd?v=3&uin=1750182485&site=qq&menu=yes" target="_blank">联系我们</a> 办理入驻。
							<b style="font-size: 12px; color: #e4393c; text-align: right; margin-left: 30px;
							display: inline-block; float: right;">
								PS:本页面游戏商排序不分排名先后。
							</b>
						</p>
					</Col>
				</Row>
				<Row type="flex" justify="space-around" :class-name="'game-cat'">
					<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'game-cat-frame'" v-bind:class="{'game-cat-frame-active':cid==0}">
						<div @click="change_cat(0)" @mouseover="on_hover=0" @mouseout="on_hover=''">
							<div class="img-frame">
								<img v-bind:src="cid==0||on_hover===0?'/static/quanbu-01.png':'/static/quanbu.png'">
							</div>
							<div class="game-name">全部</div>
						</div>
					</Col>
					<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" v-for="(cat,key) in game_cat_list" :key="key" :class-name="'game-cat-frame'" v-bind:class="{'game-cat-frame-active':cid==cat.id}">
						<div @click="change_cat(cat.id)" @mouseover="on_hover=cat.id" @mouseout="on_hover=''">
							<div class="img-frame">
								<img v-bind:src="cid==cat.id||on_hover==cat.id?cat.image+'-01.png':cat.image+'.png'">
							</div>
							<div class="game-name">{{cat.gname}}</div>
						</div>
					</Col>
				</Row>
				<Row style="margin-bottom: 30px;">
					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'game-store-list'" v-for="(game_store,key) in game_store_list" :key="key">
					<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
						<div class='game-store-logo'>
							<img v-bind:src="game_store.logo">
						</div>
					</Col>
					<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'game-store-detail'">
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'game-store-title'">
							{{game_store.title}}
						</Col>
						<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'game-store-brief'">
							{{game_store.brief}}
						</Col>
						<div class="game-deal">
							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}">
								<!--<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">-->
							<!--接入费 : <span v-if="game_store.money">有</span>-->
									<!--<span v-else>无</span>-->
								<!--</Col>-->
								<Col :xs="{'span':12}" :sm="{'span':12}" :lg="{'span':12}">
								接入点位 : 点击 <b style="color: #28b28a; font-weight: normal;">［快速接入］</b>与我们取得联系
								</Col>
<!-- 								<Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
									市场点位 : {{game_store.access_point}}%
								</Col> -->
							</Col>
						</div>
					</Col>
					<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'game-store-contact'">
						<Row type="flex" justify="center">
							<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
								<a v-bind:href="game_store.url" target="_blank">
									<div class="common-button">
										访问官网
									</div>
								</a>
							</Col>
							<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
								<a>
									<div class="contact-button">
										<a href="http://wpa.qq.com/msgrd?v=3&uin=1750182485&site=qq&menu=yes" target="_blank">快速接入</a>
									</div>
								</a>
							</Col>							
						</Row>
					</Col>
					</Col>
				</Row>
				<Row v-if="loading">
		          <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
		              <Spin fix>
		                  <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
		                  <div>Loading</div>
		              </Spin>
		          </Col>
		    </Row>
			  <Row v-if="!loading">
			        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			            <center>
			                <Button class="load-more" @click="get_more"  v-if="more_data">浏览更多</Button>
			            </center>
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
        document.title = '菠菜圈| 游戏接口';
		var v = this;
		this.https.get('/front/game/render').then((r)=>{
			v.game_cat_list = r.data.gameStoreCategories;
			v.game_store_list = r.data.getGameStoreList;
			v.loading = false;
		}).catch((e)=>{
			console.log(e);
		});
	},
	data(){
		return {
			game_cat_list:[],
			game_store_list:[],
			cid:0,
			page:1,
			loading:true,
			more_data:true,
			on_hover:''
		}
	},
	methods:{
		change_cat(cat_id){
			var v = this;
			if (v.cid == cat_id) {
				return false;
			}
			v.cid = cat_id;
			this.get_game_store(0,cat_id,1);//切换游戏种类	
			this.more_data = true;
			this.page = 1;
		},
		get_more(){
			var page = this.page;
			var cid = this.cid;
			this.get_game_store(page,cid,2);//翻页	
		},
		get_game_store(page,cid,type){
			var v = this;
			v.loading = true;
			this.https.get('/front/game/filter',{
				params:{
					page:page,
					cid:cid
				}
			}).then((r)=>{
				if (type == 1) {
					v.game_store_list = r.data
					if (!r.data.length) {
						v.more_data = false
					}else{
						v.more_data = true
					}					
				}else{
					if (r.data.length) {
						v.game_store_list = v.game_store_list.concat(r.data);
						v.page = v.page + 1;
					}else{
                        v.$Message.warning('已无更多数据');  
                        v.more_data = false;
					}
				}
				v.loading = false;
			}).catch((e)=>{
				console.log(e);
			});
		}
	}
}
</script>

<style lang='scss' scoped>
    html,body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    .common-button{
        padding: 4px 14px 4px 14px;
        font-size:12px;
        color: white !important;
        background-color: #28b28a !important;
        width:auto;
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
        .game-notice {
            margin: 30px 0 40px 0;
            p {
                width: 100%;
                line-height: 46px;
                border: 1px solid #9bc3ff;
                background: #f4f8ff;
                text-align: left;
                padding: 5px 20px;
                border-radius: 5px;
                font-size: 14px;
                color: #666;
                font-weight: bold;
                letter-spacing: 1px;
                img {
                    vertical-align: middle;
                    margin-right: 8px;
                }
            }
        }
		.game-cat {
			margin-top: 20px;
			border-bottom: 1px solid #f2f2f2;
			.game-cat-frame {
				&:hover{
					cursor: pointer;
				}				
				padding:10px; 
/* 				.img-frame{
					width: 100%;
					height: 0;
					padding-top: 100%;
					position: relative;
					img{
						width: 100%;
						height: 100%;
						position: absolute;
						top: 0;
						left: 0;
						border-radius: 50%;
					}
				} */
				.game-name{
					margin-top: 20px;
					font-size: 16px;
					text-align: center;
					font-weight: bold;
				}
			}	
			.game-cat-frame-active{			
				padding:10px; 
				border-bottom: 3px solid #27b48a;
				color: #27b48a;
			}			
		}
		.game-store-list{
			padding:25px; 
			border-bottom: 1px solid #f2f2f2;  
			.game-store-logo{
				width: 100%;
				height: 0;
				padding-top: 70%;
				position: relative;
				img{
					width: 100%;
					height: 100%;
					position: absolute;
					top: 0;
					left: 0;
				}
			}
			.game-store-detail{
				padding-left:30px;
				.game-store-title{
					font-size: 20px;
					color:#333333;
					font-weight: bold;
					padding-bottom:10px; 
					&:hover{
						color: #28b28a;
					}
				} 
				.game-store-brief{
					font-size:14px;
					color: #414141;
					line-height: 20px;
					overflow: hidden;
		            text-overflow: ellipsis;
		            -o-text-overflow:ellipsis;
		            display: -webkit-box;
		            -webkit-line-clamp: 3;
		            -webkit-box-orient: vertical;
		            height: 60px;
				} 
				.game-deal{
					margin-top: 113px;
					font-size: 16px;
					color: #414141;
					.money{
						border-bottom:1px solid #2d8cf0;
					}
				}
			}
			.game-store-contact{
				.common-button{
					height: 44px;
					line-height: 36px;
					border-radius: 3px;
					font-size: 14px;
					text-align: center;
					margin-top: 16px;
					cursor: pointer;
					a{
						color: #fff;
					}
				}
				.contact-button {
				    font-size:14px; 
				    color: #27b48a;
				    border:1px solid #28b28a;
				    height: 44px;
					line-height: 44px;
					border-radius: 3px;
					text-align: center;
					margin-top: 20px;
					cursor: pointer;
					a {
						color: #28b28a;
					}
					&:hover{
						background-color: #fff;
					}
				}
			}
		}
		.load-more {
			margin-bottom: 30px;
		}
	}
</style>