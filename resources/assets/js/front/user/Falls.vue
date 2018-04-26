<template>
<div>
<Row v-if="falls.length||loading">
	<Col>
		<ul>
			<li v-for="(item,key) in falls">
				<div v-if="item.model=='News'" class="news list">
					<div  class="img-zone">
						<div class="img-frame">
							<a v-bind:href="'/news/newspage/'+item.id" target="_blank" style="color:#999">
								<img v-bind:src="item.image" onerror="this.src='/static/noimg.png'">
							</a>
						</div>
					</div>
					<div class="content-zone">
						<div class="content-fame">
							<div class="line2 pointer" style="height:50px;"><a class="title" v-bind:href="'/news/newspage/'+item.id" target="blank">{{item.title}}</a></div>
							<div class="content-info">
								<div class="right-info">
									<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
									&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/news/newspage/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment_count}}</a>
									&nbsp&nbsp|&nbsp&nbsp<span class="shoucang-frame" @click="collection(item.id,item.is_collection,key)"><i class="icon icon-shoucang" v-bind:class="{'is_collect':item.is_collection}"></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{item.collection_count}}</span>		
								</div>
								<div class="byself" v-if="item.byself">原创</div>
								<div class="tags">{{item.category_name}}</div>&nbsp&nbsp
								<div class="avatar">
									<div class="avatar-frame-new">
										<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
											<img v-bind:src="item.user_image">
										</a>
									</div>
								</div>
								<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>
								<div class="time">&nbsp&nbsp{{item.time}}</div>
							</div>
						</div>
					</div>	
				</div>
				<div v-if="item.model=='Report'" class="report list">
					<div class="content-fame">
						<div class="line1 pointer"><a class="title" v-bind:href="'/news/reportDetail/'+item.id" target="blank">{{item.title}}</a></div>
						<div class="content-info">
							<div class="right-info">
								<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
								&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/news/reportDetail/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment}}</a>
							</div>
							<div class="tags">官方报告</div>&nbsp&nbsp
							<div class="avatar">
								<div class="avatar-frame-new">
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
										<img v-bind:src="item.user_image">
									</a>
								</div>
							</div>
							<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>							
							<div class="time">&nbsp&nbsp{{item.time}}</div>
						</div>
					</div>
				</div>
				<div v-if="item.model=='UserData'" class="userdata list">
					<div class="content-fame">
						<div class="title pointer"><a class="title" v-bind:href="'/userdata/UserDataDetail/'+item.id" target="blank">{{item.title}}</a></div>
						<div class="content-info">
							<div class="right-info">
								<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
								&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment}}</a>
							</div>
							<div class="tags">产业资源</div>&nbsp&nbsp
							<div class="avatar">
								<div class="avatar-frame-new">										
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
										<img v-bind:src="item.user_image">
									</a>
								</div>
							</div>
							<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>							
							<div class="time">&nbsp&nbsp{{item.time}}</div>
						</div>
					</div>
				</div>
				<div v-if="item.model=='Question'" class="question list">
					<div class="content-fame">
						<div class="line1 pointer"><a class="title" v-bind:href="'/questiondetail/'+item.id" target="blank">{{item.title}}</a></div>
						<div class="content-info">
							<div class="right-info">
								<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
								&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/questiondetail/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.answer_count}}</a>
							</div>
							<div class="tags">互动问答</div>&nbsp&nbsp
							<div class="avatar">
								<div class="avatar-frame-new">
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">									
										<img v-bind:src="item.user_image">
									</a>
								</div>
							</div>
							<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>							
							<div class="time">&nbsp&nbsp{{item.time}}</div>
						</div>
					</div>
				</div>
				<div v-if="item.model=='Trend'" class="trend list">
					<div class="content-fame">
						<div class="line1 pointer"><a class="title" v-bind:href="'/news/trend?id='+item.id" target="blank">{{item.title}}</a></div>
						<div class="content-info">
							<div class="right-info">
								<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
							</div>
							<div class="tags">产品动态</div>&nbsp&nbsp
							<div class="avatar">
								<div class="avatar-frame-new">
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
										<img v-bind:src="item.user_image">
									</a>
								</div>
							</div>
							<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>							
							<div class="time">{{item.time}}</div>
						</div>
					</div>
				</div>
				<div v-if="item.model=='Business'" class="business list">
					<div class="content-fame">
						<div class="line1 pointer"><a class="title" v-bind:href="'/trade/BusinessDetail/'+item.id" target="blank">{{item.title}}</a></div>
						<div class="content-info">
							<div class="right-info">
								<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
							</div>							
							<div class="tags">供求商讯</div>&nbsp&nbsp
							<div class="avatar">
								<div class="avatar-frame-new">
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
										<img v-bind:src="item.user_image">
									</a>
								</div>
							</div>
							<div class="username line1">&nbsp&nbsp{{item.user_name}}</div>
							<div class="time">&nbsp&nbsp{{item.time}}</div>
						</div>
					</div>	
				</div>	
				<div v-if="item.model=='Platform'" class="platform list">
					<div  class="img-zone"  v-if="item.logo">
						<div class="img-frame">
							<img v-bind:src="item.logo" onerror="this.src='/static/noimg.png'">
						</div>
					</div>
					<div class="content-zone">
						<div class="content-fame">
							<div class="line1 pointer"><a class="title" v-bind:href="'/trade/PlatformDetail/'+item.id" target="blank">{{item.title}}</a></div>
							<div class="content-info">
								<div class="right-info">
									<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}	
								</div>
								<div class="tags">代理招商</div>&nbsp&nbsp
								<div class="avatar">
									<div class="avatar-frame-new">
										<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
											<img v-bind:src="item.user_image">
										</a>
									</div>
								</div>
								<div class="username line1">&nbsp&nbsp{{item.user_name}}&nbsp&nbsp</div>
								<div class="time">{{item.time}}</div>
							</div>
						</div>
					</div>	
				</div>	
				<div v-if="item.model=='Micro'" class="micro list">
					<div  class="img-zone" v-if="item.image.length&&item.image.length<=3">
						<a class="title" v-bind:href="'/news/micro?id='+item.id" target="_blank">
							<div class="img-frame" v-bind:style="{'background-image':'url('+item.image[0]+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}">
	<!-- 							
									<img v-bind:src="item.image[0]" onerror="this.src='/static/noimg.png'">							
	 -->							<span class="img-tag">{{item.image.length}}图</span>
							</div>
						</a>
					</div>
					<div class="content-zone" v-bind:class="{'content-zone-width':item.image.length&&item.image.length>=4||item.image.length==0}">
						<div class="content-fame">
							<div class="avatar">
								<div class="avatar-frame-new">
									<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
										<img v-bind:src="item.user.image">
									</a>
								</div>
							</div>
							<div class="username"><span v-bind:class="{'username-author':item.user.is_author}">{{item.user.username}}</span><br><span class="userdesc">{{item.user.desc}}</span></div>
							<div class="pointer"><a class="title" v-bind:href="'/news/micro?id='+item.id" target="blank"><div class="line1 micro-content" v-html="item.content"></div></a></div>
							<a class="title" v-bind:href="'/news/micro?id='+item.id" target="_blank">
								<div class="more-img-frame" v-if="item.image.length&&item.image.length>=4">
									<span class="img-tag">{{item.image.length}}图</span>
									<ul class="more-img">
										<li v-for="(img,key) in item.image" :key="key" v-if="key<=3" v-bind:style="{'background-image':'url('+img+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}">
	<!-- 										<img v-bind:src="img"></a> -->
										</li>
									</ul>
								</div>
							</a>
							<div class="content-info">
								<div class="right-info">
									<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
									&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/news/micro?id='+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment_count}}</a>	
								</div>								
								<div class="tags">微动态</div>
								<div class="time">&nbsp&nbsp{{item.time}}</div>
							</div>
						</div>
					</div>					
				</div>																		
			</li>
		</ul>
	</Col>
	<Row>
        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" v-if="!loading">
            <center>
                <Button class="load-more" @click="getFalls" v-if="has_more">浏览更多</Button>
            </center>
        </Col>
    </Row>	
    <Loading :loading="loading"></Loading>
</Row>
<Row v-else>
	<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" :class-name="'default-frame'">
		<center>
			<img src="/static/no_news.png">
		</center>
		<div class="default-font">暂时没有发布过任何讯息喔~</div>
	</Col>
</Row>
</div>
</template>
<script>
    import $ from 'jquery';
    import Loading from '../components/Loading.vue';
	export default{
		components: {Loading},
		props:['uid'],
		mounted(){
			var v = this
			v.$nextTick(function(){
				v.getFalls()				
			})
		},
		destroyed(){
			$(window).unbind('scroll')
		},
		data(){
			return {
				page:0,
				falls:[],
				loading_text:'加载中',
				has_more:true,
				loading:true,
				type:'',
				cid:''
			}
		},
        methods: {
        	collection(id,is_collection,key){
            	var v = this
      				this.https.get('/front/news_details/collection',{
      					params:{
      						nid:id,
      						model:'News'
      					}
      				}).then((r)=>{
      					if (r.data.code == 1) {
		                  if (is_collection==1) {
		                    v.$Message.success('已取消收藏')
		                    v.falls[key].is_collection = 0     
		                    v.falls[key].collection_count--              
		                  }else{
		                    v.$Message.success('已收藏')
		                    v.falls[key].is_collection = 1  
		                    v.falls[key].collection_count++		                                
		                  }
      					}else{
      						v.$emit('show')
      					}
      				}).catch((e)=>{
      					console.log(e)
      				});
            },
            getFalls(){
				var v = this
				v.loading = true
				if (v.page == 0) {
					v.falls = []
				}
				v.https.get('/front/home/falls_render',{params:{
					page:v.page,
					type:v.type,
					cid:v.cid,
					uid:v.uid
				}}).then((r)=>{
					setTimeout(() => {
						if (r.data.length) {
							v.falls = v.falls.concat(r.data)		
							v.page = v.page + 1	
							}else{
							v.loading_text = '已无更多资讯'
							v.has_more = false
						}
		            	v.loading = false
		            }, 1000);					
				}).catch((e)=>{
					console.log(e)
				})
            },
            changeCat(data){
            	var v = this
            	v.type = data.type
            	v.cid = data.id
            	v.page = 0
            	v.has_more = true
				v.loading = true
				v.loading_text = '加载中'
            	v.getFalls()
            	document.documentElement.scrollTop = 300
            }
        }		
	}
</script>
<style lang="scss" scoped>
.default-frame{
	padding-top: 100px;
	.default-font{
		text-align: center;
		font-size: 14px;
	}	
}
.list{
	padding-top:10px;
	padding-bottom:10px; 
	border-bottom: 1px solid #f2f2f2;
	&:hover{
		background-color: #f2f2f2;
	}
}
.platform{
	.content-zone-width{
		width: 100%!important;
		.content-info{
			padding-top: 25px!important;
		}
	}	
	.img-zone{
		display: inline-block;
		width: 25%;
		vertical-align: middle;
		.img-frame{
			width: 100%;
		    height: 0;
		    padding-bottom: 62.5%;
		    overflow: hidden;
		    border-radius: 3px;
		    position: relative;
			img{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		}
	}
 	.content-zone{
		display: inline-block;
		vertical-align: middle;
		padding-left: 15px;
		width: 74%;
		padding-top: 5px;
		.title{
			font-size: 22px;
			line-height: 25px;
			height: 25px;
			overflow: hidden;
			font-weight: bolder;
			color: #333333;
			&:hover{
				color: #28b28a;
			}
		}
		.content-info{
			position: relative;
			font-size: 12px;
			padding-top: 45px;
			color: #777777;
			.right-info{
				font-size: 12px;
				width: 300px;
				height: 26px;
				position: absolute;
				bottom: -5px;
				right: 0;
				text-align: right;
				padding-right: 15px;
				.shoucang-frame{
					position: relative;
					.icon-shoucang{
						position: absolute;
						top:-2px;
					}
				}
			}
			.tags,.avatar,.username,.time{
				display: inline-block;
				vertical-align: middle;
			}
			.username{
				max-width: 80px;
				height: 18px;
			}
			.tags{
				border:1px solid #5186ee;
				color: #5186ee;
				padding-left:5px;
				padding-right: 5px; 
				border-radius: 3px;
			}
			.avatar{
				display: inline-block;
				width: 20px;
				height: 20px;
			}
		}
	} 
}
.news{
	.content-zone-width{
		width: 100%!important;
		.content-info{
			padding-top: 25px!important;
		}
	}	
	.img-zone{
		display: inline-block;
		width: 25%;
		vertical-align: middle;
		.img-frame{
			width: 100%;
		    height: 0;
		    padding-bottom: 62.5%;
		    overflow: hidden;
		    border-radius: 3px;
		    position: relative;
			img{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			}
		}
	}
 	.content-zone{
		display: inline-block;
		vertical-align: middle;
		padding-left: 15px;
		width: 74%;
		padding-top: 5px;
		.title{
			font-size: 22px;
			line-height: 25px;
			height: 25px;
			overflow: hidden;
			font-weight: bolder;
			color: #333333;
			&:hover{
				color: #28b28a;
			}
		}
		.content-info{
			position: relative;
			font-size: 12px;
			padding-top: 35px;
			color: #777777;
			.right-info{
				font-size: 12px;
				width: 300px;
				height: 26px;
				position: absolute;
				bottom: -5px;
				right: 0;
				text-align: right;
				padding-right: 15px;
				.shoucang-frame{
					position: relative;
					.icon-shoucang{
						position: absolute;
						top:-2px;
					}
				}
			}
			.tags,.avatar,.username,.time{
				display: inline-block;
				vertical-align: middle;
			}
			.username{
				max-width: 80px;
				height: 18px;
			}
			.tags{
				border:1px solid #5186ee;
				color: #5186ee;
				padding-left:5px;
				padding-right: 5px; 
				border-radius: 3px;
			}
			.avatar{
				display: inline-block;
				width: 20px;
				height: 20px;
			}
		}
	} 
}
.report,.userdata,.question,.trend,.business{
	display: inline-block;
	vertical-align: middle;
	padding-left: 15px;
	width: 100%;
	.title{
		font-size: 22px;
		line-height: 25px;
		height: 25px;
		overflow: hidden;
		font-weight: bolder;
		color: #333333;		
		&:hover{
			color: #28b28a;
		}
	}
	.content-info{
		font-size: 12px;
		padding-top: 45px;
		color: #777777;
		position: relative;
		.right-info{
			font-size: 12px;
			width: 300px;
			height: 32px;
			line-height: 32px;
			position: absolute;
			bottom: -5px;
			right: 0;
			text-align: right;
			padding-right: 15px;
		}
		.tags,.avatar,.username,.time{
			display: inline-block;
			vertical-align: middle;
		}
		.tags{
			border:1px solid #999;
			color: #999;
			padding-left:5px;
			padding-right: 5px; 
			border-radius: 3px;
		}
		.avatar{
			display: inline-block;
			width: 20px;
		}
	}
}
.business{
	.content-info{
		.tags{
			border:1px solid #ee5054;
			color: #fc606e;
			border-radius: 3px;
		}	
	}
}
.platform{
	.content-zone{
		width: 100%;
		.content-info{
			.tags{
				border:1px solid #ee5054;
				color: #fc606e;
				border-radius: 3px;
			}	
		}
	}
}
.userdata,.report{
	.content-info{
		.tags{
			border:1px solid #28b28a;
			color: #28b28a;
			border-radius: 3px;
		}	
	}
}
.trend{
	.content-info{
		.tags{
			border:1px solid #c67e38;
			color: #c67e38;
			border-radius: 3px;
		}	
	}
}
.question{
	.content-info{
		.tags{
			border:1px solid #da8826;
			color: #ff7b34;
			border-radius: 3px;
		}	
	}
}
.micro{
	display: flex;
	display: -webkit-flex;
	flex-direction:row;
	.content-zone-width{
		width: 100%!important;
	}	
	.img-zone{
		display: inline-block;
		width: 25%;
		vertical-align: middle;
		.img-frame{
			width: 100%;
		    height: 0;
		    padding-bottom: 62.5%;
		    overflow: hidden;
		    border-radius: 3px;
		    position: relative;
		    .img-tag{
		    	position: absolute;
		    	width: 30px;
		    	height: 20px;
		    	bottom:5px;
		    	right: 5px;
		    	border-radius: 10px;
		    	color: #fff;
		    	z-index: 1;
		    	text-align: center;
		    	background-color: rgba(0,0,0,.4);
		    }
/* 			img{
				position: absolute;
				top: 0;
				left: 0;
				width: 100%;
				height: 100%;
			} */
		}
	}
 	.content-zone{
		display: inline-block;
		vertical-align: middle;
		padding-left: 15px;
		width: 74%;
		.title{
			font-size: 22px;
			line-height: 25px;
			height: 25px;
			overflow: hidden;
			font-weight: bolder;
			color: #333333;
			&:hover{
				color: #28b28a;
			}
		}
		.avatar{
			display: inline-block;
			width: 40px;
		}
		.username{
			padding-left: 5px;
			font-size: 16px;
			font-weight: bold;
			.userdesc{
				font-size: 12px;
				color: #999999;
				font-weight: normal;
			}
		}
		.tags,.avatar,.username,.comment,.time,.view,.collection{
			display: inline-block;
			vertical-align: middle;
		}
		.micro-content{
			line-height: 25px;
			height: 25px;
			font-size: 14px;	
			font-weight: normal;
			color: #333;	
			margin-top: 5px;	
			&:hover{
				color: #28b28a;
			}
		}
		.more-img-frame{
			margin-top: 15px;
			position: relative;
		    .img-tag{
		    	position: absolute;
		    	width: 30px;
		    	height: 20px;
		    	bottom:10px;
		    	right: 5px;
		    	font-size: 12px;
		    	font-weight: normal;
		    	line-height: 20px;
		    	border-radius: 10px;
		    	color: #fff;
		    	z-index: 1;
		    	text-align: center;
		    	background-color: rgba(0,0,0,.4);
		    }
			.more-img{
				width: 100%;
				height: 100px;
				display: flex;
				display: -webkit-flex;
				flex-direction:row;
				justify-content:space-between;
				li{
					width: 24%;
					height: 100%;
					overflow: hidden;
		   			border-radius: 3px;
					/* img{
						width: 100%;
						height: 100%;
					} */
				}
			}	
		}
		.content-info{
			font-size: 12px;
			margin-top: 15px;
			color: #777777;
			position: relative;
			.right-info{
				font-size: 12px;
				width: 300px;
				height: 28px;
				line-height: 32px;
				position: absolute;
				bottom: -5px;
				right: 0;
				text-align: right;
				padding-right: 15px;
			}
			.tags{
				border:1px solid #f22284;
				color: #f22284;
				padding-left:5px;
				padding-right: 5px; 
				border-radius: 3px;
			}
		}
	} 		
}
</style>