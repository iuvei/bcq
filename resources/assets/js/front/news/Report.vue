<template>
	<div id="report">
    <NavHeader></NavHeader>
		<Row type="flex" justify="center">
      <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
				<Breadcrumb separator=">" style="margin: 0 0 15px 0;">
					<BreadcrumbItem to="/">首页</BreadcrumbItem>
					<BreadcrumbItem>资讯</BreadcrumbItem>
					<BreadcrumbItem>数据报告</BreadcrumbItem>
				</Breadcrumb>
        <Row type="flex" justify="space-between">
          <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
						<Row type="flex" align="middle" v-for="(item,key) in reportList" :key="key" :class-name="'report-frame'">
							<Col :class-name="'report-list-left'" :xs="{'span':21}" :sm="{'span':21}" :lg="{'span':21}">
								<div class="report-title"><a v-bind:href="'/news/reportDetail/'+item.id" target="_blank">{{item.title}}</a></div>
								<Col :xs="{'span':22}" :sm="{'span':22}" :lg="{'span':22}" :class-name="'report-brief'">
									<a v-bind:href="'/news/reportDetail/'+item.id" target="_blank" style="color:#333">{{item.brief}}</a>
								</Col>
								<div class="report-info">
									<span>{{item.updated_at}}</span>
                    <span><i class="icon icon-eye1"></i>&nbsp&nbsp{{item.view}}</span>
                    <span @click="collection(key)"><i class="icon icon-shoucang" v-bind:class="{'is_collect':item.is_collected}"></i>&nbsp&nbsp{{item.collection}}</span>
								</div>
							</Col>
							<Col :class-name="'report-list-right'"  :xs="{'span':3}" :sm="{'span':3}" :lg="{'span':3}">
								<div class="report-suffix">
									<img src="/static/suffix_pdf1.png">
								</div>
								<div class="download-frame">
				          <center class="report-download">
				            <Button type="ghost" class="report-download-botton" icon="icon icon-download">下载</Button>
				            <Button type="ghost" class="report-price-botton" icon="ios-color-filter-outline" @click="download_report(key)">{{item.price}}</Button>
				          </center>
								</div>
							</Col>
						</Row>
						<Row v-if="!loading">
					    <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
					      <center>
					        <Button class="load-more" @click="get_more" v-if="more_report">浏览更多</Button>
					      </center>
					    </Col>
					  </Row>
          </Col>
          <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
	          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'report-more-frame'" v-if="report_more.length">
	            <div class="report-more">更多数据报告</div>
	            <ul class="report-ul">
	              <li v-for="(item,key) in report_more" :key="key" class="report-more-title">
	                <a v-bind:href="'/news/reportDetail/'+item.id" target="_blank" v-bind:title="item.title">{{item.title}}</a>
	              </li>
	            </ul>
	          </Col>
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
import PageRight from '../components/MainRight.vue';	
import NavHeader from '../components/NavHead.vue';
import FooterArea from '../components/FooterArea.vue';
import FloatSideBar from '../components/FloatSideBar.vue';
import AccountPannel from '../components/AccountPanel.vue';
export default{
	components: {PageRight,NavHeader,FooterArea,FloatSideBar,AccountPannel},
	data(){
		return {
			page_id:5,
			page:1,
			loading:true,
			reportList:[],
			more_report:true,
			report_more:[]
		}
	},
	mounted(){
		document.title = '菠菜圈| 数据报告';
		var v = this;
        this.https.get('/front/report/render',{
            }).then((r)=>{
                v.loading = false
                v.reportList = r.data.reportList
                v.report_more = r.data.report_more
            }).catch((e)=>{   
                console.log(e)
        });
	},
	methods:{
		get_more(){
    		this.loading = true;
    		var v = this;
	        this.https.get('/front/report/get_report_list',{
		        	params:{
                        page : v.page
                    }
	            }).then((r)=>{
	                v.loading = false;
	                v.page = v.page + 1;
                    if (r.data.length>0) {
                        v.reportList = v.reportList.concat(r.data);
                    }else{
                        v.more_report = false;
                        v.$Message.warning('已无更多数据');    
                    }                    
	            }).catch((e)=>{   
	                console.log(e)
	        });
		},
        collection(key){
			if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
				return false
			}	            	
        	var v = this;
				this.https.get('/common/add_collection',{
					params:{
						cid:v.reportList[key].id,
						model:'Report'
					}
				}).then((r)=>{
					if (r.data.code == 1) {
	                  if (v.reportList[key].collection==1) {
	                    v.$Message.success('已取消收藏');
	                    v.reportList[key].collection = v.reportList[key].collection - 1;
	                    v.reportList[key].is_collected = 0;                      
	                  }else{
	                    v.$Message.success('已收藏');
	                    v.reportList[key].collection = v.reportList[key].collection + 1;
	                    v.reportList[key].is_collected = 1;                    
	                  }
					}
				}).catch((e)=>{
					console.log(e);
				});
        }, 		
		download_report(key){
				if (!this.$store.state.user_info) {
				this.$refs.AccountPannel.show()
					return false
				}	
                var report = this.reportList[key];
                var id = report.id;
                var file = report.file;
                var price = report.price;
                var v = this;
                this.https.get('/common/download_test',{
                    params:{
                    	did:id,
                        price : price,
                        file : file
                    }
                }).then((r)=>{
                    if (r.data.code == 0) {
                        v.$Message.error(r.data.msg);
                        return false;
                    }else{
                        var down_href='/common/data_download?file=' + file;
                        v.download(down_href);
                        }
                }).catch((e)=>{   
                    console.log(e)
                });
        },
        download(url){
            var elemIF = document.createElement("iframe");
            elemIF.src = url;
            elemIF.style.display = "none";
            document.body.appendChild(elemIF);
        }
	}
}
</script>

<style lang="scss" scoped>
	.icon-shoucang {
		font-size: .24rem;
		vertical-align: text-top;
	}
	.icon-download {
		padding: 0;
		font-size: .23rem;
		vertical-align: text-bottom;
	}
	* {
		box-sizing: border-box;
	}
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
	.load-more {
		margin-bottom: 30px;
	}

	#report {
		.container {
			width: 1200px;
			min-height: 80vh;
      margin: 20px auto;
			.report-frame {
				padding: 15px 10px;
				border-bottom: 1px solid #efefef;
				&:hover{
					background-color: #f2f2f2;
				}
				.report-list-left {
					.report-title {
						width: 100%;
						color: #333;
						font-size: 18px;
						font-weight: bold;
						cursor: pointer;
						&:hover {
							color:#28b28a;
						}
						a {
							display: block;
							color: #333;
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
					.report-brief {
						font-size: 14px;
						color: #666;
						margin: 10px 0 15px 0;
						max-height: 56px;
						overflow: hidden;
		                text-overflow: ellipsis;
		                -o-text-overflow:ellipsis;
						-moz-text-overflow:ellipsis;
		                -webkit-line-clamp: 2;
		                display: -webkit-box;
		                -webkit-box-orient: vertical;
					}
					.report-info {
						padding: 15px 0 0 0;
						font-size: 12px;
						color: #999;
						cursor: pointer;
						text-align: left;
						span {
							display: inline-block;
							vertical-align: middle;
							margin-right: 15px;
							text-align: center;
						}
					}
				}
				.report-list-right {
					text-align: center;
					.report-suffix {
						img {
							width: 50px;
							height: 50px;
							vertical-align: middle;
							text-align: center;
						}
					}
					.download-frame {
						width: 70px;
						margin: 0 auto;
						text-align: center;
						.report-download {
							/*overflow: auto;*/
						}
						.button {
							color: #666;
							max-width: 70px;
							margin: 0 auto;
							height: 24px;
							padding: 5px 2px;
							text-align: center;
							line-height: 1;
						}
					}
				}
			}		
		}
		.report-more-frame {
			padding: 20px 0 30px 0;
			.report-more {
				text-align: left;
				font-size: 14px;
				color: #333;
				font-weight: bold;
			}
			ul, li {
				margin: 0;
				padding: 0;
				list-style: none;
			}
			ul.report-ul {
				overflow: auto;
				padding: 10px 0 50px 0;
			}
			li.report-more-title::before {
				content: '';
				display: inline-block;
				width: 5px;
				height: 5px;
				background: #28b28a;
				border-radius: 50%;
				position: absolute;
				top: 50%;
				left: 0;
				margin-top: -2.5px;
			}
			.report-more-title {
				position: relative;
				width: 100%;
				color: #333;
				font-size: 14px;
				cursor: pointer;
				margin: 0 0 10px 0;
				padding: 8px 10px 8px 15px;
				&:hover {
					color:#28b28a;
				}
				a {
					display: block;
					color: #333;
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
	}
</style>