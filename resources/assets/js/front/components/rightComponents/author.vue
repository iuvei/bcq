<template>
    <div id="author"> <!-- 推荐作者组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a  v-bind:href="'/news/author'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
                </div>
            </Col>
        </Row>
        <Row :class-name="'authorList'">
            <Col :xs="24" :sm="24" :lg="24" v-for="(item,key,index) in authorList" :key="key" :class-name="'author'">
                <Row  type="flex" align="middle">
                    <Col :xs="5" :sm="5" :lg="5" :class-name="'author-avatar'"><!-- 头像 -->
                        <div class="avatar-frame-new">
                          <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
                            <img :src="item.image" onerror="this.src='/static/noimg.png'"/>
                          </a>
                        </div>
                    </Col>    
                    <Col :xs="15" :sm="15" :lg="15" :class-name="'author-info'">
                      <a v-bind:href="'/user/userzone/'+item.uid" target="_blank">
                        <div class="author-info-frame">
                            <span class="author-name">{{item.username}}</span>                        
                          <!-- 加图标 认证作者-->
                          <div class="author-name-frame">
                            <img src="/static/author_confirm.png">
                          </div>
                        </div>
                        <span class="user-desc">{{item.desc}}</span>
                      </a>
                        <div class="author-news-title">
                            <a v-bind:href="'/news/newspage/' + item.news.id" target="_black">{{item.news.title}}</a>
                            <span class="new-news" v-bind:class="{'new-news2':item.desc}">new</span>
                        </div>  
                    </Col>  
                </Row>               
            </Col>
        </Row>
    </div>
</template>

<script>
    import JQ from 'jquery';
    export default {
        name: 'Author',
        props:['title'],
        mounted(){
            this.get_list();
        },
        data(){
            return {
                page:0,
                authorList:''
            }
        },
        methods:{
            get_list(){
                var v = this;
                this.https.get('/front/components/get_author').then((r)=>{
                    v.authorList = r.data
                }).catch((e)=>{   
                    console.log(e)
                });
            }
        }
    }
</script>

<style lang="scss" scoped>
  #author {
    padding-bottom: 50px;
    .components-title{
      text-align: center;
      font-size: 16px;
      color: #333;
      font-weight: bold;
      border-top: 2px solid #27b289;
      border-bottom:1px solid silver;
      border-style: solid none dashed none;
      height: 1rem;
      line-height: 1rem;
      position: relative;
      .title-image{
        position: absolute;
        right: 0.5rem;
        top: 45%;
        cursor: pointer;
      }
    }
    .authorList{
      .author{
        text-align: left;
        padding: 10px 10px 10px 0;
        height: auto;
        .author-avatar{
          padding:3px;
        }
        .author-info {
          padding:0 0 0 15px;
          position: relative;
          .new-news {
            font-size: 10px;
            background: #28b28a;
            color: #fff;
            padding: 0 3px 0 3px;
            position: absolute;
            top: 34px;
            right: -30px;
          }
          .new-news2{
            position: absolute;
            top: 52px;
            right: -30px;  
          }
          .author-info-frame{
            display: table;
            .author-name-frame{
              display: table-cell;
              vertical-align: bottom;
              img{
                padding:0px 3px 0px 3px;
              }
            }
            .author-name {
              display: block;
              max-width: 150px;
              max-height: 28px;
              overflow: hidden;
              font-size: 18px;
              color: #333;
              font-weight: bold;
              cursor: pointer;
              vertical-align: bottom;
              &:hover {
                color: #28b28a;
              }
            }            
          }

          .author-news-title {
            height: 18px;
            margin-top: 6px;
            overflow: hidden;
            text-overflow: ellipsis;
            -o-text-overflow:ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
            a {
              color: #333;
              font-size: 14px;
              font-weight: normal;
              &:hover{
                color: #28b28a;
              }
            }
          }
        }
      }
    }
}
</style>