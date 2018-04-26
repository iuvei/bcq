<template>
    <div id="exbition-list">
        <NavHeader></NavHeader>
        <Row type="flex" justify="center">
            <Col :xs="{'span':18}" :sm="{'span':18}" :lg="{'span':18}" :class-name="'container'">
                <Breadcrumb separator=">" style="margin: 0 0 15px 0;">
                    <BreadcrumbItem to="/">首页</BreadcrumbItem>
                    <BreadcrumbItem>资讯</BreadcrumbItem>
                    <BreadcrumbItem>行业展会</BreadcrumbItem>
                </Breadcrumb>            
                <Row type="flex" justify="space-between">
                    <Col :xs="{'span':16}" :sm="{'span':16}" :lg="{'span':16}">
                        <ul class="exb-list">
                            <li v-for="(exhibition,index) in exhibitionList">
                                <div class="trend-date">
                                    <div class='trend-date-month'>{{exhibition.month}}月</div>
                                    <div class='trend-date-day'>{{exhibition.day}}</div>
                                </div>
                                <div class="exb-info">
                                    <a :href="'/parts/ExbitionDetail/'+exhibition.id" target="_blank">
                                        <h2 class="hours-title"><span>【{{exhibition.short}}】</span>{{exhibition.title}}</h2>
                                    </a>
                                    <p class="exb-desc">
                                        {{exhibition.content}}
                                    </p>
                                </div>
                            </li>
                        </ul>
                        <Row v-if="loading">
                            <Col class="demo-spin-col" :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                            <Spin fix>
                                <Icon type="load-c" size=18 class="demo-spin-icon-load"></Icon>
                                <div>Loading</div>
                            </Spin>
                            </Col>
                        </Row>
                        <Row>
                            <Col :xs="{'span':8,'offset':8}" :sm="{'span':8,'offset':8}" :lg="{'span':8,'offset':8}">
                            <center>
                                <Button :class="'load-more'" @click="get_more" v-if="more_exhibition">浏览更多</Button>
                            </center>
                            </Col>
                        </Row>
                    </Col>
                    <Col :xs="{'span':7}" :sm="{'span':7}" :lg="{'span':7}" :class-name="'page-right'">
                        <PageRight :page-id="page_id">
                        </PageRight>
                    </Col>
                </Row>
            </Col>
        </Row>

        <FloatSideBar></FloatSideBar>
        <FooterArea></FooterArea>
    </div>
</template>

<script>
    import PageRight from '../components/MainRight.vue';
    import NavHeader from '../components/NavHead.vue';
    import FooterArea from '../components/FooterArea.vue';
    import FloatSideBar from '../components/FloatSideBar.vue';

    export default {
      data() {
        return {
          page_id:21,
          page:1,
          loading:true,
          exhibitionList:[],
          more_exhibition:true
        }
      },
      components: { PageRight, NavHeader, FooterArea, FloatSideBar },
      mounted() {
        document.title = '菠菜圈| 更多展会';
        var v = this;
        this.https.get('/front/exhibition/render').then((r)=>{
          v.exhibitionList = r.data.exhibitionList
          v.loading = false
        }).catch((e)=>{
          console.log(e);
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
          this.https.get('/front/exhibition/get_exhibition_list',{
            params:{
              page : v.page
            }
          }).then((r)=>{
            v.loading = false;
            v.page = v.page + 1;
            if (r.data.length>0) {
              v.exhibitionList = v.exhibitionList.concat(r.data);
            }else{
              v.more_exhibition = false;
              v.$Message.warning('已无更多数据');
            }
          }).catch((e)=>{
            console.log(e)
          });
        }
      },
    }
</script>

<style lang="scss" scoped>
    html, body {
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
    ul, li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .load-more {
        margin-top: 30px;
        margin-bottom: 30px;
    }
    #exbition-list {
        .container{
            width:1200px;
            margin: 20px auto;
            min-height: 10rem;
        }
        .exb-list {
            >li {
                cursor: pointer;
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                padding: 17px 10px;
                &:hover {
                     background: #f2f2f2;
                }
                .trend-date {
                    width: 46px;
                    height: 56px;
                    background: #28b28a;
                    text-align: center;
                    padding: 5px 0;
                    .trend-date-month {
                        font-size: 12px;
                        color: #fff;
                    }
                    .trend-date-day {
                        font-size: 18px;
                        color: #fff;
                    }
                }
                .exb-info {
                    width: 95%;
                    margin-left: 13px;
                    .hours-title {
                        width: 100%;
                        font-size: 18px;
                        font-weight: bold;
                        color: #333;
                        height: 30px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow:ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        -webkit-box-orient: vertical;
                        >span {
                            font-size: 16px;
                            color: #478dce;
                            margin-left: -10px;
                        }
                        &:hover {
                            color: #28b28a;
                        }
                    }
                    .exb-desc {
                        width: 100%;
                        font-size: 14px;
                        color: #888;
                        height: 20px;
                        overflow: hidden;
                        text-overflow: ellipsis;
                        -o-text-overflow:ellipsis;
                        display: -webkit-box;
                        -webkit-line-clamp: 1;
                        -webkit-box-orient: vertical;
                    }
                }
            }
        }
    }
</style>