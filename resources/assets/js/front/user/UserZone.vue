<template>
<div id="userpage">
	<NavHeader></NavHeader>
	<Row type="flex" justify="center">
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
	        <Row :class-name="'page-top'" type="flex" align="bottom">
	        	<Col :xs="24" :sm="24" :lg="24" :class-name="'top-pic-frame'">
	        		<img src="/static/zonetop.png">
	        		<span @click="go('/news/beAuthor')" class="pointer"></span>
	        	</Col>
				<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'user-info'">
					&nbsp
					<div class="avatar-realitive">
						<div class="avatar-absolute">
							<div class="avatar-frame-new">
								<img v-bind:src="user_info.image">
							</div>
						</div>
					</div>
				</Col>
				<Col :xs="{'span':13}" :sm="{'span':13}" :lg="{'span':13}" :class-name="'user-intro'">
					<div class="author-intro-frame">
						<div class="username line1">{{user_info.username}}&nbsp<img src="/static/author_confirm.png" v-if="is_author"></div>
						<div class="userdesc line1"><span v-if="user_info.desc">{{user_info.desc}}</span><span v-if="user_info.brief"> | {{user_info.brief}}</span></div>
					</div>
				</Col>
				<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'buttons'">
					<Col :xs="{'span':7,'offset':7}" :sm="{'span':7,'offset':7}" :lg="{'span':7,'offset':7}">
						<Button class="user-zone-button-no" @click.stop="add_attention(user_id,0,-1)" v-if="is_attention !== -1&&is_attention !== 1&&!is_self">十 关注</Button>
						<Button class="user-zone-button" @click.stop="add_attention(user_id,1,-1)" v-if="is_attention == 1&&!is_self">已关注</Button>
					</Col>
					<Col :xs="{'span':7,'offset':1}" :sm="{'span':7,'offset':1}" :lg="{'span':7,'offset':1}">
						<Button class="user-zone-button" v-if="!is_self" @click="check_login()">发私信</Button>
					</Col>
					<Col :xs="{'span':10,'offset':12}" :sm="{'span':10,'offset':12}" :lg="{'span':10,'offset':12}">
						<Button class="common-button3" v-if="is_self" @click="go('/user/userpage')">进入个人信息中心</Button>
					</Col>
				</Col>	        	
	        </Row>        
        	<Row>
        		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}" :class-name="'page-right'">
        			<Row :class-name="'userhot'">
        				<Col :xs="6" :sm="6" :lg="6" :class-name="'userhot-cell'">
        					<div class="separet"></div>
							<div style="cursor:pointer"><b style="color:#28b28a"><span style="font-size:18px">￥</span>{{user_info.income}}</b><br/><span>收益</span></div> 
        				</Col>
        				<Col :xs="6" :sm="6" :lg="6" :class-name="'userhot-cell'">
        					<div class="separet"></div>
							<div @click="active_tab='fans-attention';attention_tab='attention'" style="cursor:pointer"><b>{{user_info.attention}}</b><br/><span>关注</span></div>        			
						</Col>
						<Col :xs="6" :sm="6" :lg="6" :class-name="'userhot-cell'">
							<div class="separet"></div>
							<div @click="active_tab='fans-attention';attention_tab='fans'" style="cursor:pointer"><b>{{user_info.fans}}</b><br/><span>粉丝</span></div>
						</Col>
						<Col :xs="6" :sm="6" :lg="6">
							<div v-if="is_author" class="pointer" @click="active_tab='';choice_ucid('')">
								<label v-if="user_info.count>9999" class="pointer">
									<b>9999+</b>
								</label>
								<label v-else  class="pointer">
									<b>{{user_info.count}}</b>
								</label>
								<br/>
								<span class="end-tag">讯息量</span>
							</div>
							<div v-else>
								<label><b>0</b><br></label>
								<span class="end-tag">讯息量</span>
							</div>
						</Col>
        			</Row>	
        			<Row :class-name="'visitors'" v-if="!loading">
        				<Col :xs="24" :sm="24" :lg="24" :class-name="'visitors-title'"><b>有谁来过</b></Col>
        				<Col :xs="24" :sm="24" :lg="24" v-if="visitors.length">
        					<ul>
        						<li v-for="(item,key) in visitors" :key="key">
        							<a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
	        							<div class="img-frame">
	        								<img v-bind:src="item.image">
	        							</div>
        							</a>
        							<div class="username-mask"></div>
        							<div class="username line1">{{item.username}}</div>
        							<img src="/static/author_confirm.png" class="confirm" v-if="item.is_author">
        						</li>
        					</ul>
        				</Col>
        				<Col :xs="24" :sm="24" :lg="24" v-else>
        					暂时还没有访客哦~~
        				</Col>
        			</Row>
        			<Row :class-name="'category'"  v-if="is_author">
        				<Col :class-name="'category-title'">
        					<span class="category-left">我创建的标签</span>
        				</Col>
        				<Col :class-name="'category-content'">
        					<span v-for="(item,key) in user_category" @click="choice_ucid(item.id)">{{item.cname}}</span>
        				</Col>
        			</Row>	 
					<Row :class-name="'comment'">
        				<Col :class-name="'comment-title'">
        					<span class="comment-left">最近评论</span>
        					<span class="comment-right" @click="active_tab='comments'">全部评论</span>
        				</Col>
        				<Col :class-name="'comment-list'" v-for="(item,key) in recently_comments_render" :key="key">
        					<a v-bind:href="path[item.type]+item.nid" target="_blank">
        						<div class="comment-list-title pointer" v-html="item.title"></div>
        					</a>
        					<div>
        						<div class="comment-list-content-frame">
        							<a v-bind:href="path[item.type]+item.nid+'#comment'" target="_blank" style="color:#333333">
	        							<div class="comment-content line2" v-html="item.content"></div>
	        						</a>
        							<div class="comment-list-content">
	        							<span class="type">{{type[item.type]}}</span>
	        							<span class="time">{{item.time}}</span>
        							</div>      							
        						</div>
        					</div>
        				</Col>
        			</Row>	
        			<Row>
        				<Col :xs="24" :sm="24" :lg="24" :class-name="'recommand'">
        					<RecommandMicro></RecommandMicro>  
        				</Col>   
        			</Row>  				
        		</Col>        		
        		<Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}" :class-name="'page-left'">
        			<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'pannel-content'">
        				<Tabs v-if="!active_tab" class="tab-weight-nomal tab-padding" @on-click="get_cat_list">
        					<TabPane label="全部"  name="all">
        						<Falls :uid = "user_id" @show="show_account_pannel"></Falls>
        					</TabPane>
        					<TabPane label="微动态" name="micro">
        						<div v-if="user_micro.length||loading">
	        						<div class='micro-frame'  v-for="(item,key) in user_micro" :key="key">
										<div class="img-zone" v-if="item.image.length&&item.image.length<=3">
											<a v-bind:href="'/news/micro?id='+item.id" target="_blank" style="color:#999">
												<div class="img-frame" v-bind:style="{'background-image':'url('+item.image[0]+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}">
													<!-- 
														<img v-bind:src="item.image[0]" onerror="this.src='/static/noimg.png'">
													</a> -->
													<span class="img-tag">{{item.image.length}}图</span>
												</div>
											</a>
										</div>
										<div class="content-zone-1" v-bind:class="{'content-zone-width':!item.image.length||item.image.length>=4}">
											<div class="content-fame">
												<div class="avatar">
													<div class="avatar-frame-new">
														<a v-bind:href="'/user/userzone/'+item.uid" target="blank">
															<img v-bind:src="item.user.image">
														</a>
													</div>
												</div>
												<div class="username"><span class="username-author">{{item.user.username}}</span><br><span class="userdesc">{{item.user.desc}}</span></div>
												<div class="pointer micro-content" v-bind:class="{'content-height':item.image.length&&item.image.length<=3}"><a class="title" v-bind:href="'/news/micro?id='+item.id" target="blank"><div class="line2" v-html="item.content"></div></a></div>
												<div class="more-img-frame" v-if="item.image.length&&item.image.length>=4">
													<span class="img-tag">{{item.image.length}}图</span>
													<a v-bind:href="'/news/micro?id='+item.id" target="_blank" style="color:#999">
														<ul class="more-img">
															<li v-for="(img,key) in item.image" :key="key" v-if="key<=3" v-bind:style="{'background-image':'url('+img+')','background-position':'center','background-repeat':'no-repeat','background-repeat':'no-repeat','background-size':'100%'}">
	<!-- 															<img v-bind:src="img">-->
															</li>
														</ul>
													</a>
												</div>
												<div class="content-info">
													<div class="tags">微动态</div>&nbsp&nbsp⋅
													<div class="time">{{item.time}}</div>
													<div class="right-info">
														<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.f_view}}
														&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/news/micro?id='+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment_count}}</a>
													</div>	
												</div>
											</div>
										</div>	        								
	        						</div>
	        						<Row>
				                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" v-if="!loading">
				                            <center>
				                                <Button class="load-more" @click="get_more('micro')" v-if="more_micro">浏览更多</Button>
				                            </center>
				                        </Col>
				                    </Row>	
				                    <Loading :loading="loading"></Loading>
			                	</div>
			                	<div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_news.png">
								    			<div class="default-font">暂时没有发布过任何微动态喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/')">立即发布</Button>
						        				</div>							    			
							    			</center>
							    		</Col>	
							    	</Row>			                		
			                	</div>
        					</TabPane>
					        <TabPane label="文章" name="news"><!--  icon="document-text" -->
			                    <Row v-if="is_author&&(user_news.length||loading)">
			                        <Col v-for="(item,key,index) in user_news" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-list'">
			                            <Col :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
			                                <div class='news-image-frame'>
			                                	<a v-bind:href="'/news/newspage/'+item.id" target="_blank">
			                                    	<img :src="item.image" class="news-image">
			                                	</a>
			                                    <div class="news-tag">
			                                        {{item.category_name}}
			                                    </div>
			                                </div>
			                            </Col>
			                            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'news-content'">
			                                <div class="news-title"><a v-bind:href="'/news/newspage/'+item.id" target="_blank">{{item.title}}</a></div>
			                                <div class="news-brief">{{item.brief}}</div>
			                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-info'">
			                                	<Col :class-name="'updated-time'" :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">{{item.time}}
			                                    </Col>
			                                	<div class="right-info">
													<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}
													&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/news/newspage/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment}}</a>
													&nbsp&nbsp|&nbsp&nbsp<span class="shoucang-frame" @click="get_collect(item.id,key)"><i class="icon icon-shoucang" v-bind:class="{'is_collect':item.is_collected}"></i>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp{{item.collection}}</span>		
												</div>			                                    		                        
			                                </Col>
			                            </Col>
			                        </Col>
			                        <Col v-if="!loading" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			                            <center>
			                                <Button class="load-more" @click="get_more('news')" v-if="more_news">浏览更多</Button>
			                            </center>
			                        </Col>
			                    	<Loading :loading="loading"></Loading>			                    
			                    </Row>		                    
						    	<Row :class-name="'default-frame'" v-else>   
						    		<Col :xs="24" :sm="24" :lg="24">
						    			<center>
						    				<img src="/static/no_news.png">
							    			<div class="default-font">暂时没有发布过任何资讯喔~</div>
							    			<div style="width:140px;margin-top:40px;" v-if="is_self">
					        					<Button class="common-button3" @click="go('/user/write')">立即发布</Button>
					        				</div>						    			
						    			</center>
						    		</Col>	
						    	</Row>	
					        </TabPane>
					        <TabPane label="产品" name="trend"> <!-- icon="cube" -->
					        	<div v-if="user_trend.length!==0||loading">
			            			<Row type="flex" justify="space-between" v-for="(item,key,index) in user_trend" :key="key">
			            				<Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
			            					<div class='trend-date'>
			            						<div class='trend-date-month'>{{item[0].month}} 月</div>
			            						<div class='trend-date-day'>{{item[0].day}}</div>
			            					</div>
			            				</Col>
			            				<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}">
				            				<div v-for="(item1,key1,index1) in item" :key="key1">
				            					<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-frame'">
				            						<Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}">
				            							<div class="trend-title">
				            								<a :href="item1.product_url" target="_blank">{{item1.title}}</a>
				            							</div>
				            						</Col>
			            							<Col :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}" :class-name="'trend-type'">
				            							<span v-for="(type1,key2) in item1.type" :key="key2" class="Icon-frame">
				            								<img src="/static/web.png" v-if="type1==1" class="type-icon">
				            								<img src="/static/android.png" v-if="type1==2"  class="type-icon">
				            								<img src="/static/ios.png" v-if="type1==3"  class="type-icon">
				            							</span>
			            							</Col>
			            							<Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'trend-content'">
			            								{{item1.content}}
			            							</Col>             						
			            						</Col>
				            				</div>
			            				</Col>		            				
			            			</Row>	
			            			<Row>
			            				<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" v-if="!loading">
				                            <center>
				                                <Button class="load-more" @click="get_more('trend')" v-if="more_trend">浏览更多</Button>
				                            </center>
				                        </Col>
				                        <Loading :loading="loading"></Loading>  
			            			</Row>
		            			</div>
		            			<div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_collection.png">
								    			<div class="default-font">暂时没有发布过任何产品喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/news/trend')">立即发布</Button>
						        				</div>							    			
							    			</center>
							    		</Col>	
							    	</Row>	
						    	</div>	
					        </TabPane>
					        <TabPane label="产业资源下载" name="data"> <!-- icon="ios-book" -->
					        	<div v-if="user_data.length||loading">
				                    <Row>
				                        <Col v-for="(item,key,index) in user_data" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-list'">
				                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
				                                <div class="news-title"><a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank">{{item.title}}</a></div>
				                                <div class="news-brief">{{item.brief}}</div>
				                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-info'">
				                                	<Col :class-name="'updated-time'" :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">{{item.time}}
				                                    </Col>
				                                	<div class="right-info">
														<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}
														&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/userdata/UserDataDetail/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comment}}</a>
													</div>
				                                </Col>
				                            </Col>
				                        </Col>
				                    </Row>		                    
				                    <Row v-if="!loading">
				                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
				                            <center>
				                                <Button class="load-more" @click="get_more('data')" v-if="more_data">浏览更多</Button>
				                            </center>
				                        </Col>
				                    </Row>	
				                    <Loading :loading="loading"></Loading>	
			                    </div>	
			                    <div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_collection.png">
								    			<div class="default-font">暂时没有发布过任何产业资源喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/userdata/UserDataUpload')">立即发布</Button>
						        				</div>							    			
							    			</center>
							    		</Col>	
							    	</Row>				                    	
			                    </div>			        	
					        </TabPane>
					        <TabPane label="代理招商" name="platform"><!--  icon="person-stalker" -->
					        	<div v-if="user_platform.length||loading">
				                    <Row>
				                        <Col v-for="(item,key,index) in user_platform" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-list'">
				                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
				                                <div class="news-title"><a v-bind:href="'/trade/PlatformDetail/'+item.id" target="_blank">{{item.title}}</a></div>
				                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-info'">			                               
				                                	<Col :class-name="'updated-time'" :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
				                                		<span class="cname" v-for="(item1,key1,index1) in item.games" :key="key1">{{item1.name}}</span>&nbsp&nbsp&nbsp&nbsp{{item.time}}
				                                    </Col>
				                                	<div class="right-info" style="width:80px;text-align:left">
														<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}
														
													</div>
			                                	</Col>
				                            </Col>
				                        </Col>
				                    </Row>
				                    <Row v-if="!loading">
				                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
				                            <center>
				                                <Button class="load-more" @click="get_more('platform')" v-if="more_platform">浏览更多</Button>
				                            </center>
				                        </Col>
				                    </Row>	
				                    <Loading :loading="loading"></Loading>
			                    </div>
			                    <div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_collection.png">
								    			<div class="default-font">暂时没有发布过任何代理招商信息喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/trade/Publish')">立即发布</Button>
						        				</div>							    			
							    			</center>
							    		</Col>	
							    	</Row>				                    	
			                    </div>			                    					        	
					        </TabPane>
					        <TabPane label="供求商讯" name="business"> <!-- icon="ios-toggle" -->
					        	<div v-if="user_business.length||loading">
			                    <Row>
			                        <Col v-for="(item,key,index) in user_business" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-list'">
			                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
			                                <div class="news-title"><a v-bind:href="'/trade/BusinessDetail/'+item.id" target="_blank">{{item.title}}</a></div>
			                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-info'">			                               
			                                	<Col :class-name="'updated-time'" :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
			                                		<span class="cname">{{item.category.cname}}</span>&nbsp&nbsp&nbsp&nbsp{{item.time}}
			                                    </Col>
			                                	<div class="right-info" style="width:80px;text-align:left">
													<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}
													
												</div>
			                                </Col>
			                            </Col>
			                        </Col>
			                    </Row>
			                    <Row v-if="!loading">
			                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			                            <center>
			                                <Button class="load-more" @click="get_more('business')" v-if="more_business">浏览更多</Button>
			                            </center>
			                        </Col>
			                    </Row>	
			                    <Loading :loading="loading"></Loading>			                    						        </div>
			                    <div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_collection.png">
							    				<div class="default-font">暂时没有发布过任何供求商讯喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/trade/Publish')">立即发布</Button>
						        				</div>
							    			</center>
							    		</Col>	
							    	</Row>			                    	
			                    </div>
					        </TabPane>
					        <TabPane label="问答互动" name="question"><!--  icon="social-twitch" -->
					        	<div v-if="user_question.length||loading">
			                    <Row>
			                        <Col v-for="(item,key,index) in user_question" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-list'">
			                            <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-content'">
			                                <div class="news-title"><a v-bind:href="'/questiondetail/'+item.id" target="_blank">{{item.title}}</a></div>
			                                <div class="news-brief" v-html="item.describe"></div>
			                                <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'news-info'">
			                                	<Col :class-name="'updated-time'" :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">{{item.time}}
			                                    </Col>
			                                	<div class="right-info">
													<i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}
													&nbsp&nbsp|&nbsp&nbsp<a v-bind:href="'/questiondetail/'+item.id" target="_blank" style="color:#999"><i class="icon icon-message3"></i>&nbsp&nbsp{{item.comments}}</a>
												</div>
			                                </Col>
			                            </Col>
			                        </Col>
			                    </Row>
			                    <Row v-if="!loading">
			                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			                            <center>
			                                <Button class="load-more" @click="get_more('question')" v-if="more_question">浏览更多</Button>
			                            </center>
			                        </Col>
			                    </Row>	
			                    <Loading :loading="loading"></Loading>   
			                	</div>
			                	<div v-else>
							    	<Row :class-name="'default-frame'">   
							    		<Col :xs="24" :sm="24" :lg="24">
							    			<center>
							    				<img src="/static/no_collection.png">
							    				<div class="default-font">暂时没有发布过任何问答喔~</div>
								    			<div style="width:140px;margin-top:40px;" v-if="is_self">
						        					<Button class="common-button3" @click="go('/newquestion')">立即发布</Button>
						        				</div>
							    			</center>
							    		</Col>	
							    	</Row>				                		
			                	</div>
					        </TabPane>
					    </Tabs>
					    <Tabs v-if="active_tab == 'fans-attention'" :value="attention_tab">
					        <TabPane label="我关注的" name="attention">
					        	<Row>
			                        <Col v-for="(item,key,index) in user_attention" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'user-list'">
				                        <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
					                        <a :href="'/user/userzone/'+item.id" target="_blank">
					                        	<div class="avatar-frame-new">
					                        		<img v-bind:src="item.image">
					                        	</div>
					                        </a>
				                        </Col>
				                        <Col :xs="{'span':20}" :sm="{'span':20}" :lg="{'span':20}" :class-name="'user-info'">
				                        	<div class="user-name line1">{{item.username}}</div>
				                        	<div class="user-brief">{{item.brief}}</div>
				                        </Col>
					        		</Col>					        		
					        	</Row>
			        			<Row v-if="!loading">
			                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			                            <center>
			                                <Button class="load-more" @click="get_more('attention')" v-if="more_attention">浏览更多</Button>
			                            </center>
			                        </Col>
			                    </Row>	
			                    <Loading :loading="loading"></Loading>	
					        </TabPane>					    	
					        <TabPane label="我的粉丝" name="fans">
					        	<Row v-if="user_fans.length">
					        		<Col v-for="(item,key,index) in user_fans" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"  :class-name="'user-list'">
				                        <Col :xs="{'span':2}" :sm="{'span':2}" :lg="{'span':2}">
				                        	<a :href="'/user/userzone/'+item.id" target="_blank">
					                        	<div class="avatar-frame-new">
					                        		<img v-bind:src="item.image">
					                        	</div>
				                        	</a>
				                        </Col>
				                        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'user-info'">
				                        	<div class="user-name line1">{{item.username}}</div>
				                        	<div class="user-brief">{{item.brief}}</div>
				                        </Col>
	  			                    	<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}" :class-name="'attention-frame'"><!--  v-if="is_self" -->
			                            	<Button v-if="item.is_attention !== -1 && item.is_attention !== 1" class="common-button" @click.stop="add_attention(item.id,item.is_attention,key)"> 	+ 关注</Button>
			                            	<Button v-if="item.is_attention == 1" class="common-button-white" @click="	add_attention(item.id,item.is_attention,key)">已关注</Button>
				                        </Col>					                        						
					        		</Col>
					        		<Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}" v-if="!loading">
			                            <center>
			                                <Button class="load-more" @click="get_more('fans')" v-if="more_fans">浏览更多</Button>
			                            </center>
			                        </Col>	
			                        <Loading :loading="loading"></Loading>		        		
					        	</Row>
						    	<Row v-else :class-name="'default-frame'">   
						    		<Col :xs="24" :sm="24" :lg="24">
						    			<center>
						    				<img src="/static/no_fans.png">
						    			</center>
						    			<div class="default-font">暂时没有粉丝喔~</div>
						    			<center>
							    			<div class="button-frame">
							    				<Button class="common-button3" @click="go('/news/author')">去逛逛</Button>
							    			</div>
						    			</center>
						    		</Col>	
						    	</Row>				                					        	
					        </TabPane>
					    </Tabs>   
					    <Tabs v-if="active_tab == 'comments'"> 
					        <TabPane label="最近的评论">
			        				<Row :class-name="'comment'">
			        				<Col :class-name="'comment-list'" v-for="(item,key) in recently_comments" :key="key">
				        				<a v-bind:href="path[item.type]+item.nid" target="_blank">
				        					<div class="comment-list-title pointer">{{item.title}}
				        					</div>
				        				</a>
			        					<div>
			        						<div class="comment-list-content-frame">
			        							<div class="comment-list-content">
				        							<div class="comment-content line2">{{item.content}}</div>
	        										<span class="type">{{type[item.type]}}</span>
				        							<span class="time">{{item.time}}</span>   
			        							</div>      							
			        						</div>
			        					</div>
 										<div class="comment-reply" v-if="comment_id == item.cid">
											<div>
												<textarea class="common-textarea" :placeholder="'回复  ' + item.username + ' :'" v-model="reply_comment">			
												</textarea>
											</div>
										</div>	 		        					
			        				</Col>
			        			</Row>
			        			<Row v-if="!loading">
			                        <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
			                            <center>
			                                <Button class="load-more" @click="get_more('comments')" v-if="more_comment">浏览更多</Button>
			                            </center>
			                        </Col>
			                    </Row>						        	
					        </TabPane>
					    </Tabs>
        			</Col>
        		</Col>
        	</Row>
		</Col>
    </Row>
	<FooterArea></FooterArea>
	<Message :message="message" :rid="user_id" :name = "user_info.username" v-on:close="message=false"></Message>
	<AccountPannel ref="AccountPannel"></AccountPannel>
</div>
</template>

<script>
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import Loading from '../components/Loading.vue';
import Message from '../components/Message.vue';
import RecommandMicro from '../news/RecommandMicro.vue';
import Falls from './Falls.vue';
import AccountPannel from '../components/AccountPanel.vue';
export default{
	components: {NavHeader,FooterArea,Loading,Message,RecommandMicro,Falls,AccountPannel},
	mounted(){
        document.title = '菠菜圈| 用户个人主页';
		var v= this;
		var user_id = v.user_id = v.$route.params.user_id;
		v.https.get('/front/user_zone/render',{
			params:{
				auid:user_id
			}
		}).then((r)=>{
            v.is_author = r.data.is_author
            v.is_self = r.data.is_self
            v.is_attention = r.data.is_attention
            v.user_info = r.data.user_info
            v.user_category = r.data.user_category
            v.recently_comments = r.data.recently_comments
            v.recently_comments_render = r.data.recently_comments
            v.new_brief = r.data.user_info.brief
            v.user_attention = r.data.attention
            v.more_attention = v.user_attention.length?v.more_attention=true:v.more_attention=false            
            v.user_fans = r.data.fans
            v.more_fans = v.user_fans.length?v.more_fans=true:v.more_fans=false
            v.visitors = r.data.visitors
            v.loading = false
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			user_id:'',
			is_author:'',
			is_self:'',
			is_attention:'',
			user_category:'',
			user_info:'',
			user_news:[],
			user_micro:[],
			user_trend:[],
			user_data:[],
			user_business:[],
			user_platform:[],
			user_question:[],
			user_attention:'',
			user_fans:'',
			visitors:'',
			recently_comments_render:[],
			recently_comments:[],
			more_news:false,
			more_trend:false,
			more_data:false,
			more_business:false,
			more_platform:false,
			more_question:false,
			more_fans:false,
			more_attention:false,
			more_comment:true,
			more_micro:true,
			loading:true,
			ucid:'',
			news_page:1,
			micro_page:1,
			trend_page:1,
			data_page:1,
			business_page:1,
			platform_page:1,
			question_page:1,
			fans_page:1,
			attention_page:1,
			comment_page:1,
			active_tab:'',
			comment_id:'',
			reply_comment:'',
			message:false,//true,
			attention_tab:'attention',
			type:{
				1:'资讯',
				2:'问答',
				3:'数据报告',
				4:'产业资源',
				5:'微动态'
			},
			path:{
				1:'/news/newspage/',
				2:'/questiondetail/',
				3:'/news/reportDetail/',
				4:'/userdata/UserDataDetail/',
				5:'/news/micro?id=',
			}
		}
	},
	methods:{
		check_login(){
			if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}
			this.message=true;
		},
		show_account_pannel(){
			this.$refs.AccountPannel.show()
		},
		get_cat_list(cat){
			if (cat != 'all') {
				var data = `user_${cat}`
				if (!this[data].length) {
					this.get_list_req(cat)
				}
			}
		},
		get_list_req(cat){
			var v = this
			this.https.get('/front/user_zone/get_cat_list',{params:{
				cat:cat,
				auid:v.user_id
			}}).then((r)=>{
				
				var u_data = `user_${cat}`
				var u_more = `more_${cat}`

	          	v[u_data] = r.data
	          	if (u_more!='more_trend') {
		            v[u_more] = r.data.length?v[u_more]=true:v[u_more]=false
	          	}else{
		            v[u_more] = r.data?v[u_more]=true:v[u_more]=false
	          	}
			}).catch((e)=>{
				console.log(e)
			})
		},
        choice_ucid(ucid){
        	this.active_tab=''
        	this.ucid = ucid
        	this.news_page = 0
        	this.more_news = true
        	this.user_news = []
        	this.get_more('news')        	
        },	
        add_attention(uid,status,key){
        	if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}
            var v = this;
            this.https.get('/common/add_attention',{
                params:{
                    aid : uid
                }
            }).then((r)=>{
            	if (key == -1) {
	                if(r.data.code == 1){
	                    if (status == 1) {
	                        v.is_attention = 0;
	                        v.$Message.success('取消关注');                       
	                    }else{
	                        v.is_attention = 1;
	                        v.$Message.success('关注成功');
	                    }
	                }else{
	                    v.$Message.error(r.data.msg);
	                }
            	}else{
	                if(r.data.code == 1){
	                    if (status == 1) {
	                        v.user_fans[key].is_attention = 0;
	                        if (v.is_self) {
		                        for (var i = 0; i < v.user_attention.length; i++) {
		                        	if(v.user_attention[i].id == v.user_fans[key].id){
		                        		v.user_attention.splice(i,1)
		                        		v.user_info.attention -- 
		                        	}
		                        }
	                    	}
	                        v.$Message.success('取消关注');                       
	                    }else{
	                        v.user_fans[key].is_attention = 1;
	                        v.$Message.success('关注成功');
	                        if (v.is_self) {
		                        v.user_attention.push(v.user_fans[key])
		                        v.user_info.attention ++	                        	
	                        }
	                    }
	                }else{
	                    v.$Message.error(r.data.msg);
	                }
            	}
            }).catch((e)=>{   
                console.log(e)
            });
        },		
		go(path){
			this.$router.push(path);
		},
	    get_collect(id,key){//添加收藏
            var v = this;
            if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}
            this.https.get('/common/add_collection',{
                params:{
                    cid : id,//该收藏模型的主键
                    model : 'News'
                }
            }).then((r)=>{
                if (r.data.code == 0) {
                    v.$Message.error(r.data.msg);
                    return false;
                }
                if (v.user_news[key].is_collected == 1) {
                v.user_news[key].is_collected = 0
                v.user_news[key].collection--
                v.$Message.success('取消收藏');
                }else{
                    v.user_news[key].is_collected = 1
                    v.user_news[key].collection++
                    v.$Message.success('已收藏')
                }
            }).catch((e)=>{
                console.log(e)
            });
        },
		get_more(type){
    		this.loading = true;
    		var v = this;
    		if (type == 'news') {
    			var page = this.news_page;
    			var url = '/front/user_zone/get_news';
    		}else if(type == 'trend'){
    			var page = this.trend_page;
    			var url = '/front/user_zone/get_trend';
    		}else if(type == 'data'){
    			var page = this.data_page;
    			var url = '/front/user_zone/get_data';
    		}else if(type == 'business'){
    			var page = this.business_page;
    			var url = '/front/user_zone/get_business';
    		}else if(type == 'platform'){
    			var page = this.platform_page;
    			var url = '/front/user_zone/get_platform';
    		}else if(type == 'question'){
    			var page = this.question_page;
    			var url = '/front/user_zone/get_question';
    		}else if(type == 'attention'){
    			var page = this.attention_page;
    			var url = '/front/user_zone/get_attention';
    		}else if(type == 'fans'){
    			var page = this.fans_page;
    			var url = '/front/user_zone/get_fans';
    		}else if(type == 'comments'){
    			var page = this.comment_page;
    			var url = '/front/user_zone/get_comment';
    		}else if(type == 'micro'){
    			var page = this.micro_page;
    			var url = '/front/user_zone/get_micro';
    		}
	        this.https.get(url,{
		        	params:{
                        page : page,
                        auid : v.user_id,
                        ucid : v.ucid
                    }
	            }).then((r)=>{
	                v.loading = false;
	                if (type == 'news') {
	                    if (r.data.length !== 0) {
	                    		v.user_news = v.user_news.concat(r.data);
	                    }else{
	                        v.more_news = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.news_page = v.news_page + 1;   	
	                }else if(type == 'trend'){
	                    if (r.data.length !== 0) {
	                    	for(var i in r.data){
	              				if (typeof v.user_trend[i] == 'undefined') {
	               					v.user_trend[i] = [];
	               				}
	                    		v.user_trend[i] = v.user_trend[i].concat(r.data[i])
	                    	}
	                    }else{
	                        v.more_trend = false;
	                        v.$Message.warning('已无更多数据');    
	                    }
	                	v.trend_page = v.trend_page + 1;    
	                }else if (type == 'data') {
	                    if (r.data.length !== 0) {
	                    		v.user_data = v.user_data.concat(r.data);
	                    }else{
	                        v.more_data = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.data_page = v.data_page + 1;   	
	                }else if (type == 'micro') {
	                    if (r.data.length !== 0) {
	                    		v.user_micro = v.user_micro.concat(r.data);
	                    }else{
	                        v.more_micro = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.micro_page = v.micro_page + 1;   	
	                }else if (type == 'business') {
	                    if (r.data.length !== 0) {
	                    		v.user_business = v.user_business.concat(r.data);
	                    }else{
	                        v.more_business = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.business_page = v.business_page + 1;   	
	                }else if (type == 'platform') {
	                    if (r.data.length !== 0) {
	                    		v.user_platform = v.user_platform.concat(r.data);
	                    }else{
	                        v.more_platform = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.platform_page = v.platform_page + 1;   	
	                }else if (type == 'question') {
	                    if (r.data.length !== 0) {
	                    		v.user_question = v.user_question.concat(r.data);
	                    }else{
	                        v.more_question = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                v.question_page = v.question_page + 1;   	
	                }else if(type == 'fans'){
	                    if (r.data.length !== 0) {
	                    		v.user_fans = v.user_fans.concat(r.data);
	                    }else{
	                        v.more_fans = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                	v.fans_page = v.fans_page + 1;   	                	
	                }else if(type == 'attention'){
	                    if (r.data.length !== 0) {
	                    		v.user_attention = v.user_attention.concat(r.data);
	                    }else{
	                        v.more_attention = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                	v.attention_page = v.attention_page + 1;   
	                }else if(type == 'comments'){
	                    if (r.data.length !== 0) {    
	                    	var recently_comments = []
	                    	for (var i in v.recently_comments) {
	                    		recently_comments.push(v.recently_comments[i])
	                    	}
	                    	for (var i in r.data) {
	                    		recently_comments.push(r.data[i])
	                    	}
	                    	v.recently_comments = recently_comments
	                    }else{
	                        v.more_comment = false;
	                        v.$Message.warning('已无更多数据');    
	                    }	             
	                	v.comment_page = v.comment_page + 1;   
	                }
	            }).catch((e)=>{   
	                console.log(e)
	        });
		}
	}
}
</script>

<style lang="scss" scoped>
	* {
		box-sizing: border-box;
	}
	html,body{
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
	.icon-user {
		vertical-align: text-bottom;
	}
	.icon-shoucang {
		vertical-align: text-bottom;
	}
#userpage {
	background-color: #f8f8f8;
	.common-textarea {
		margin-top: 20px;
	}
	.container {
		width: 1200px;
		min-height: 10rem;
		.page-top{
			background-color: #fff;
			padding:0 0 20px 0;
			.top-pic-frame{
				position: relative;
				span{
					position: absolute;
					width: 150px;
					height: 45px;
					right: 45px;
					bottom: 25px;
				}
			}
			.user-info {
				.avatar-realitive{
					width: 100%;
					height: 60px;
					position: relative;
					.avatar-absolute{
						position: absolute;
						left: 20px;
						top: -60px;
						.avatar-frame-new{
							width: 120px;
							height: 120px;
						}
					}
				}
			}
			.user-intro {
				.author-intro-frame {
					padding: 5px 0 15px 0;
				}
				.deal-button {
					padding-top: 30px;
				}
				.user-intro-frame {
					padding-top:20px;
					padding-left: 20px; 
				}
				.username {
					width: 200px;
					height: 40px;
					line-height: 40px;
					padding-top: 5px;
					padding-left: 10px;
					font-size: 20px;
					font-weight: bold;
					color: #333;
				}
				.userdesc{
					width: 700px;
					height: 20px;
					font-size: 14px;
					color: #adadad;
					padding-left: 10px;					
				}
			}
			margin-bottom: 15px;			
		}
		.page-left {
			background-color: #f8f8f8;
			padding-left: 15px;
			.micro-frame{
				display: flex;
				display: -webkit-flex;
				flex-direction:row;
				padding-bottom: 10px;
				border-bottom: 1px solid #f2f2f2;
				padding-top: 10px;
				padding-right: 15px;
				&:hover{
					background: #f2f2f2;
				}
				.img-zone{
					display: inline-block;
					width: 25%;
					vertical-align: middle;
					margin-left:15px; 
					.img-frame{
						width: 100%;
					    height: 0;
					    padding-bottom: 65%;
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
						img{
							position: absolute;
							top: 0;
							left: 0;
							width: 100%;
							height: 100%;
						}
					}
				}
			 	.content-zone-1{
					display: inline-block;
					vertical-align: middle;
					padding-left: 15px;
					width: 74%;
					.title{
						font-size: 20px;
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
						font-size: 14px;
						padding-left: 10px;
						.userdesc{
							font-size: 12px;
							color: #999999;
						}
					}
					.tags,.avatar,.username,.comment1,.time,.view,.collection{
						display: inline-block;
						vertical-align: middle;
					}
					.micro-content{
						max-height: 50px;
						a{
							font-size: 14px;	
							font-weight: normal;			
						}
					}
					.content-height{
						padding-top: 5px;
						height: 50px;
					}
					.more-img-frame{
						padding-bottom: 5px;
						position: relative;
					    .img-tag{
					    	position: absolute;
					    	width: 30px;
					    	height: 20px;
					    	bottom:10px;
					    	right: 5px;
					    	border-radius: 10px;
					    	color: #fff;
					    	line-height: 20px;
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
								img{
									width: 100%;
									height: 100%;
								}
							}
						}	
					}
					.content-info{
						font-size: 14px;
						padding-top: 5px;
						.tags{
							border-radius: 3px;
							border:1px solid #f22284;
							color: #f22284;
							padding-left:5px;
							padding-right: 5px; 
						}
						color: #999;
						font-size: 12px;
						position: relative;
			            .right-info{
			                width: 300px;
			                height: 26px;
			                position: absolute;
			                top: 10px;
			                right: 0;
			                text-align: right;
			                padding-right: 15px;
			            } 						
					}
				} 	
				.content-zone-width{
					width: 100%!important;
				}					
			}
			.news-list{
				.cname {
                    padding: 1px 5px 1px 5px;
                    color: #596681;
                    background-color: #ebf2fb;
                    border: 1px dashed #9ca7b9;
                    margin-right: 10px;
                    border-radius: 3px;
                }				
			}
			.trend-date {
				position: absolute;
				top: 10px;
				left: 10px;
				width: 46px;
				height: 56px;
				background-color: #28b28a;
				text-align: center;
				padding-top: 5px;
				padding-bottom: 5px;
				.trend-date-month {
					font-size: 14px;
					color: #fff;
				}
				.trend-date-day{
					font-size: 18px;
					color: #fff;
				}
			}
			.trend-frame {
				padding: 5px 10px 10px 10px;
				margin: 10px 0;
				.trend-title {
					width: 100%;
					height: 26px;
					line-height: 26px;
					font-size: 16px;
					color: #333;
					font-weight: bold;
					a {
						color: #333;
						display: block;
						overflow : hidden;
						text-overflow: ellipsis;
						-webkit-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						-ms-text-overflow: ellipsis;
						white-space: nowrap;
						-moz-white-space: nowrap;
						-webkit-white-space: nowrap;
						-o-white-space: nowrap;
						&:hover {
							color:#28b28a;
						}
					}
				}
				.trend-type {
					margin-top: 4px;
					.Icon-frame{
						display:none;
						margin-left:6px;
						.type-icon{
							width:18px;
							height:18px;
						}
					}
				}
				.trend-content {
					padding-top: 14px;
					color: #999;
					font-size: 14px;
					min-height: 30px;
					overflow: hidden;
	                text-overflow: ellipsis;
					-o-text-overflow:ellipsis;
					-moz-text-overflow:ellipsis;
	                -webkit-line-clamp: 2;
	                display: -webkit-box;
	                -webkit-box-orient: vertical;
				}
				&:hover{
					.Icon-frame{
						display: inline;
					}
					background-color: #f2f2f2;
				}
			}			
			.user-list{
				padding: 20px 5px 20px 5px;
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}
				.user-info{
					padding-left:10px; 
					.user-name{
						font-size: 14px;
						font-weight: bold;
					}
					.user-brief{
						padding-top: 5px;
						color: #bbbbbb;
				        overflow: hidden;
				        text-overflow: ellipsis;
				        -o-text-overflow:ellipsis;
				        display: -webkit-box;
				        -webkit-line-clamp: 2;
				        -webkit-box-orient: vertical;						
					}
				}
				.attention-frame{
					padding-top: 20px;
					padding-left: 40px;
	                .author-attention{
	                    padding: 5px 12px 5px 12px;
	                    font-size:12px; 
	                    width:auto;
	                }
				}				
			}	
			
			.buttons {
				margin-top: 50px;
				display: flex;
				display: -webkit-flex;
				justify-content: space-between;
				align-items: center;
			}
			.pannel-content {
				background-color: #fff;
				.news-title {
					width: 100%;
					height: 30px;
					line-height: 30px;
					font-size: 18px;
					color: #333;
					font-weight: bold;
					a {
						display: block;
						overflow : hidden;
						text-overflow: ellipsis;
						-webkit-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						-ms-text-overflow: ellipsis;
						white-space: nowrap;
						-moz-white-space: nowrap;
						-webkit-white-space: nowrap;
						-o-white-space: nowrap;
						&:hover {
							color:#28b28a;
						}
					}
				}
			}
			.comment{
				padding-top: 0px;
				.comment-list{
					.comment-list-title{
						font-size:18px;
						color: #333333;
					}
				}
			}
		}
		.comment{
			margin-top: 15px;
			padding:15px 10px 15px 10px;				
			border-bottom: 1px solid #dddee1;
			background-color: #fff;
			.comment-title{
				font-size:16px;
				font-weight: bold; 
				.comment-right{
					margin-left:260px; 
					font-size:12px;
					font-weight: bold;
					color: #707070;
					cursor: pointer;
				}
			}
			.comment-list{
				padding-top: 15px;
				padding-bottom: 15px;
				.comment-list-title{
					font-size: 14px;
					color: #333333;
					font-weight: bold;
					position: relative;
				}
				.comment-list-user{
					padding-top: 20px;
					position: relative;
					height: 60px;
					.line1{
						width: 100px;
					}
					.avatar-frame{
						position: absolute;
						width: 35px;
						height: 35px;
						display: inline-block;
						border-radius: 50%;
						overflow: hidden;
						left: 0px;
						img{
							width: 100%;
							height: 100%;
						}
					}
					span{
						position: absolute;
						left: 40px;
						top: 30px;
					}
					.reply{
						display: none;
						cursor: pointer;
						position: absolute;
						top: 30px;
						left: 710px;
					}
				}
				&:hover{
					.reply{
						display: inline-block;
					}
				}
				.comment-list-content-frame{
						margin-top: 10px;
						background-color: #f4f4f4;
						min-height: 70px;
						padding: 10px 5px 20px 5px;
						border-radius: 3px;
						position: relative;	
						.type{
							position: absolute;
							left: 5px;
							bottom: 5px;
							color: silver;
						}
						.time{
							position: absolute;
							right: 20px;
							bottom: 5px;
						}											
					.comment-list-content{
						.comment-content{
							min-height: 36px;
							word-wrap:break-word;
						}
					}
				}
			}				
		}			
		.page-right{
			background-color: #f8f8f8;
			.recommand{
				margin-top: 20px;
				padding: 0 15px 15px 15px;
				background-color: #fff;
			}
			.userhot {
				.userhot-cell{
					position: relative;
					.separet{
						width: 1px;
						height: 40px;
						border-left:1px solid #b5b5b5;
						position: absolute;
						top: 10px;
						right: 0;
					}
				}
				padding:15px 0 15px 0;
				background-color: #fff;
				overflow: hidden;
				text-align: center;
				font-size: 14px;
				color: #5c5c5c;
				b{
					font-size: 24px;
					color: #333;
				}
			}
			.visitors{
				padding:15px 10px 15px 10px;
				background-color: #fff;
				margin-top: 15px;
				b{
					font-size: 16px;
				}
				.visitors-title{
					padding:10px 0 10px 0;
				}
				ul{
					display: flex;
					display: -webkit-flex;
					flex-direction: row;
					flex-wrap: wrap;
					li{
						margin-top: 5px;
						width: 76px;
						height: 76px;
 						position: relative;
 						.username{
 							position: absolute;
 							left: 5px;
 							bottom: 6px;
 							font-size: 12px;
 							font-weight: bold;
 							color: white;
 							width: 56px;
 							max-height: 16px;	
 							z-index: 1;
 							padding:0 2px 0 2px;
 						}
 						.username-mask{
 							position: absolute;
 							left: 5px;
 							bottom: 5px;
 							background-color: black;
 							opacity: 0.5;
 							width: 66px;
 							height: 18px;
 							z-index: 1;	
 							border-radius: 0 0 3px 3px;
 						}
 						.confirm{
 							position: absolute;
 							bottom: 5px;
 							right: 4px;
 							width: 18px;
 							height: 18px;
 							z-index: 3;
 						}
 						.img-frame{
							position: absolute;
							width: 100%;
							height: 100%;
							padding:5px 5px 5px 5px;
							img{
								width: 100%;
								height: 100%;
								border-radius: 3px;
							}
 						} 
					}
				}
			}			
			.category {
				padding:15px 10px 15px 10px;
				background-color: #fff;
				margin-top: 15px;
				border-bottom: 1px solid #dddee1;
				.category-title {
					position: relative;
					font-size: 16px;
					font-weight: bold; 
					.category-left {
						position: absolute;
						left: 0;
					}
				}
				.category-content {
					padding-top: 32px;
					font-size: 12px;
					color: #999;
					display: flex;
					display: -webkit-flex;
					justify-content: flex-start;
					align-items: center;
					flex-wrap: wrap;
					span {
						padding: 5px 15px;
						margin: 0 13px 10px 0;
						text-align: center;
						color: #999;
						display: block;
						max-width: 200px;
						height: 28px;
						border-radius: 14px;
						border: 1px solid #888;
						cursor: pointer;
						overflow : hidden;
						text-overflow: ellipsis;
						-webkit-text-overflow: ellipsis;
						-moz-text-overflow: ellipsis;
						-ms-text-overflow: ellipsis;
						white-space: nowrap;
						-moz-white-space: nowrap;
						-webkit-white-space: nowrap;
						-o-white-space: nowrap;
						&:hover{
							color: #28b28a;
							border-color: #28b28a;
						}
					}
				}				
			}	
		}
	}
}
</style>