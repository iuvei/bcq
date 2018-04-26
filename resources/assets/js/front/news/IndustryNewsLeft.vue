<template>
	<div id='page-left'>
    <Row>
      <Col v-for="(item,key,index) in newsList" :key="key" :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}"
           :class-name="'news-list'">
        <Col :xs="{'span':5}" :sm="{'span':5}" :lg="{'span':5}">
          <div class='news-image-frame'>
            <img :src="item.image" class="news-image" onerror="this.src='/static/noimg.png'" :title="item.title">
            <div class="news-tag">
              {{item.category_name}}
            </div>
          </div>
        </Col>
        <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'news-content'">
          <div class="news-title">
            <a v-bind:href="'/news/newspage/'+item.id" target="_blank">
              {{item.title}}
            </a>
          </div>
          <Col :xs="{'span':24}" :sm="{'span':24}" :lg="{'span':24}" :class-name="'news-info'">
            <Col :class-name="'news-updated_at'" :xs="{'span':6}" :sm="{'span':6}" :lg="{'span':6}">
              {{item.updated_at}}
            </Col>
            <Col :class-name="'news-views'" :xs="{'span':14}" :sm="{'span':14}" :lg="{'span':14}">
                &nbsp&nbsp
                <i class="icon icon-eye1"></i>
                {{item.view}}&nbsp&nbsp&nbsp
                <a v-bind:href="'/news/newspage/'+item.id" target="_blank">
                    <i class="icon icon-message3"></i>
                    {{item.comment}}
                </a>
            </Col>
            <Col :class-name="'news-username'" :xs="{'span':4}" :sm="{'span':4}"
                 :lg="{'span':4}">
              <i class="icon icon-user"></i>
              <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
                {{item.user_name}}
              </a>
            </Col>
          </Col>
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
          <Button class="load-more" @click="get_more" v-if="more_news">浏览更多</Button>
        </center>
      </Col>
    </Row>
	</div>
</template>

<script>
    export default {
    	data(){
    		return{
    			loading: true,
    			newsList: '',
    			more_news: true,
    			page: 1
    		}
    	},
        mounted(){
            document.title = '菠菜圈| 产业资讯';
	    	var v = this;
	        this.https.get('/front/news/render',{
	            }).then((r)=>{
	                v.loading = false;
	                v.newsList = r.data.newsList;
	            }).catch((e)=>{
	                console.log(e)
	        });
        },
        methods: {
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
            },
        	get_more(){
        		this.loading = true;
        		var v = this;
		        this.https.get('/front/news/get_news_list',{
			        	params:{
	                        page : v.page
	                    }
		            }).then((r)=>{
		                v.loading = false;
		                v.page = v.page + 1;
	                        if (r.data.length>0) {
	                            v.newsList = v.newsList.concat(r.data);
	                        }else{
	                            v.more_news = false;
	                            v.$Message.warning('已无更多数据');    
	                        }
		            }).catch((e)=>{   
		                console.log(e)
		        });
        	},
        	get_collect(id,key){//添加收藏
                var v = this;
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
                    if (v.newsList[key].is_collected == 1) {
                    v.newsList[key].is_collected = 0;
                    v.$Message.success('取消收藏');
                    }else{
                        v.newsList[key].is_collected = 1;
                        v.$Message.success('已收藏');
                    }
                }).catch((e)=>{
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
    .icon-user {
        vertical-align: text-bottom;
    }

	#page-left{
		min-height: 10rem;
        margin: 0 0 30px 0;
        .news-list {
            .news-image-frame {
                outline: none;
            }
            .news-content {
                .news-title {
                    width: 100%;
                    height: 30px;
                    line-height: 30px;
                    font-size: 18px;
                    color: #333;
                    font-weight: bold;
                    padding-top: 5px;
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
                .news-info {
                    color: #999;
                    margin-top: 45px;
                    .news-username {
                        height: 28px;
                        cursor: pointer;
                        a {
                            color: #666;
                            &:hover, &:focus {
                                color: #28b28a;
                            }
                        }
                    }
                }
            }
        }
	}
</style>