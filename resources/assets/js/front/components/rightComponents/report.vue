<template>
    <div id="report" v-if="reportList.length"> <!-- 专题组件 -->
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                    <a v-bind:href="'/news/report'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a><!-- 跳转链接 -->
                </div>
            </Col>
        </Row>
        <Row :class-name="'reportList'">
            <Col :xs="24" :sm="24" :lg="24" v-for="(item,key,index) in reportList" :key="key" :class-name="'report'">
                <Col :xs="18" :sm="18" :lg="18">
                    <a v-bind:href="'/news/reportDetail/' + item.id" target="_blank">
                        <div class="report-title line1">{{ item.title }}</div>
                    </a>
                    <div class="report-brief">{{ item.brief }}</div>
                </Col>
                <Col :xs="{'span':5,'offset':1}" :sm="{'span':5 ,'offset':1}" :lg="{'span':5,'offset':1}">
                    <div class="report-suffix">
                        <img src="/static/suffix_pdf1.png">
                    </div>
                    <center class="report-download">
                        <Button type="ghost" class="button report-download-botton" icon="icon icon-download">下载</Button>
                        <Button type="ghost" class="button report-price-botton" icon="ios-color-filter-outline" @click="download_report(key)">{{item.price}}</Button>
                    </center>
                </Col>                                       
            </Col>
        </Row>
        <AccountPannel ref="AccountPannel"></AccountPannel>        
    </div>
</template>

<script>
import AccountPannel from '../AccountPanel.vue';
    export default {
        components: {AccountPannel},        
        name: 'Report',
        props:['title'],
        data(){
            return {
                page:0,
                reportList:[]
            }
        },
        mounted(){
            this.get_list();
        },
        methods:{
            go: function (path) {
                var path = path;
                this.$router.push({path: path});
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
            get_list(){
                var v = this;
                this.https.get('/front/components/get_report',{
                    params:{

                        page : v.page

                    }
                }).then((r)=>{
                    if (r.data.reportList.length>0) {
                        v.reportList = v.reportList.concat(r.data.reportList);
                        
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
.icon-download {
    padding: 0;
    font-size: .23rem;
    vertical-align: text-bottom;
}
#report{
    .report-download{//文件下载
        padding-bottom: 20px;
        .button {
            color: #666;
            width: 70px;
            margin: 0 auto;
            height: 24px;
            padding: 5px 2px;
            text-align: center;
            line-height: 1;
        }
        &:hover{
            .report-download-botton{
                display: none;
            }
            .report-price-botton{
                display: inline;
            }
        }
    }
    .components-title{
        text-align: center; 
        font-size: 0.3rem;
        font-weight: 800;
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
    .reportList{
        .report{
            text-align: left;
            margin-top: 15px;
            .report-title {
                cursor: pointer;
                font-size: 14px;
                color: #333;
                font-weight: bold;
                height: 25px;
                &:hover{
                    color: #28b28a;
                }
            }
            .report-brief {
                font-size: 12px;
                height: 56px;
                color: #666;
                text-align: justify;
                overflow : hidden;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 3;
                -webkit-box-orient: vertical;
            }
            .report-suffix {
                >img{
                    width: 0.8rem;
                    clear: both;
                    display: block;
                    margin:auto;
                }
            }

            border-bottom: 1px solid silver;
            border-style: none none dashed none;
        }
    }
}
</style>