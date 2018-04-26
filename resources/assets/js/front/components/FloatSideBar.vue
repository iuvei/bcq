<template>
    <div>
        <ul id="floatSideBar">
            <li>
                <Icon type="ios-chatboxes-outline" class="ftIcon"></Icon>
                <p class="level-two">
                    <a href="http://wpa.qq.com/msgrd?v=3&uin=78398249&site=qq&menu=yes" target="_blank">在线客服</a>
                </p>
            </li>
<!--             <li>
                <Icon type="ios-bookmarks-outline" class="ftIcon"></Icon>
                <p class="level-two">
                    <a href="#">RSS订阅</a>
                </p>
            </li> -->
            <li>
                <Icon type="ios-help-outline" class="ftIcon"></Icon>
                <p class="level-two">
                    <a target="_blank" href="/parts/Help#help">帮助中心</a>
                </p>
            </li>

            <li id="cp-notice">
                <Icon type="ios-bell-outline" class="ftIcon"></Icon>
                <p class="level-two">
                    <a href="#">网站公告</a>
                </p>
            </li>

            <li id="gotop">
                <Icon type="ios-arrow-thin-up" class="ftIcon goTop"></Icon>
                <p class="level-two">
                    <a>返回顶部</a>
                </p>
            </li>
        </ul>
        <div class="modal-box">
            <div class="modal-dialog">
                <div class="modal-head">
                    <h3><Icon type="ios-email-outline" class="m-notice"></Icon>官方公告</h3>
                    <Icon type="android-close" class="m-close"></Icon>
                </div>
                <div class="modal-main">
                    <div class="tab-wrap clearfix">
                        <ul class="tabs">
                            <li v-bind:class="{'active':key==0}" v-for="(item,key) in notice" :key="key">{{item.title}}</li>
                        </ul>
                        <ul class="tab-content">
                            <li  v-bind:class="{'active':key==0}"  v-for="(item,key) in notice" :key="key">
                                <h2 class="pubTitle">{{item.title}}</h2>
                                <img class="pubImg" v-bind:src="item.image" alt="公告图片">
                                <p class="pubDay">{{item.created_at}}</p>
                                <p class="pubInfo">
                                    {{item.content}}
                                </p>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import $ from 'jquery';
    export default {
        data(){
            return {
                notice:[]
            }
        },
        mounted(){
            $(document).ready(function () {
                $(window).scroll(function (e) {
                    if ($(window).scrollTop() > 100)
                        $('#gotop').fadeIn(500);
                    else
                        $('#gotop').fadeOut(500);
                });
                $(function () {
                    $('#gotop').click(function (e) {
                        e.preventDefault();
                        $('body,html').animate({scrollTop: 0}, 1000);
                    });
                })
                let btn = $("#cp-notice");
                let modal = $(".modal-box");
                let dialog = $(".modal-dialog");
                let close = $(".m-close");
                btn.on("click",function(){
                    modal.css('display', 'block');
                    dialog.css('display', 'block');
                });
                close.on("click",function(){
                    modal.css('display', 'none');
                    dialog.css('display', 'none');
                });
                $(".tabs").on("click","li", function (e) {
                    e.preventDefault();
                    let idx = $(this).index();
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");
                    $(this).parents(".tab-wrap").find(".tab-content>li").eq(idx).siblings().removeClass("active");
                    $(this).parents(".tab-wrap").find(".tab-content>li").eq(idx).addClass("active");
                })
            })
            var v = this
            this.https.get('/front/components/get_notice_list').then((r)=>{
                v.notice = r.data
            }).catch((e)=>{
                console.log(e)
            })
        },
        methods: {
            goto(path){
                this.$router.push(path)
            }
        },
    }
        
</script>

<style lang="scss" scoped>
    body {
        position: relative;
    }
    ul,li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
        #floatSideBar {
            position: fixed;
            right: 0;
            bottom: 5%;
            max-width: 50px;
            border: 1px solid #e0e0e0;
            background: #fff;
            z-index: 3333;
            font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
            li {
                width: 40px;
                height: 40px;
                color: #666;
                padding: 3px;
                text-align: center;
                border-top: 1px solid #e0e0e0;
                cursor: pointer;
                position: relative;
                .ftIcon {
                    position: absolute;
                    top: 25%;
                    left: 25%;
                    font-size: .4rem;
                    color: #666;
                    vertical-align: middle;
                }
                .goTop {
                    margin-left: .1rem;
                }
                .level-two {
                    display: none;
                    position: absolute;
                    top: 0;
                    left: 0;
                    right: 0;
                    bottom: 0;
                    background: #28b28a;
                    color: #fff;
                    font-size: 0.22rem;
                    text-align: center;
                    padding: 0px 3px 5px 3px;
                    border-top: 1px solid #28b28a;
                    -webkit-transition: 0.5s;
                    -o-transition: 0.5s;
                    transition: 0.5s;
                    a {
                        width: 100%;
                        height: 100%;
                        display: block;
                        color: #fff;
                        cursor: pointer;
                        text-decoration: none;
                    }
                }
            }
            li:first-child {
                border-top: none;
            }
            li:hover .level-two {
                display: block;
            }
            .selected {
                background: #28b28a;
                -webkit-box-shadow: inset 1px 1px 10px 1px rgba(0,0,0,.25);
                -moz-box-shadow: inset 1px 1px 10px 1px rgba(0,0,0,.25);
                box-shadow: inset 1px 1px 10px 1px rgba(0,0,0,.25);
            }
        }

    /* modal */
    h3 {
        margin:0;
        padding:0;
    }
    .clearfix:after {
        content:"";
        display:block;
        clear:both;
    }
    .modal-box {
        width:100%;
        height:100%;
        background-color:rgba(0,0,0,0.45);
        position:fixed;
        top:0;
        bottom:0;
        left:0;
        right:0;
        display:none;
        z-index: 99999;
    }
    .modal-dialog {
        min-width:600px;
        max-height: 600px;
        border:1px solid #ddd;
        border-radius:4px;
        position:absolute;
        left:50%;
        top:50%;
        margin-left:-301px;
        margin-top:-200px;
        background-color:#fff;
        display:none;
        padding: 10px 15px;
    }
    .modal-head {
        border-bottom:1px solid #28a28b;
        >h3 {
            color: #28a28b;
            font-size: .28rem;
            line-height: .5rem;
            font-weight: bold;
            padding: 5px 0 10px 0;
            .m-notice {
                font-size: .4rem;
                padding-right: 5px;
                vertical-align: middle;
            }
        }
        >.m-close {
            float:right;
            font-size:18px;
            color:#888;
            margin-top:-40px;
            cursor:pointer;
        }
    }

    .modal-main {
        padding: 0 0 15px 0;
    }
    /* tab */
    .tab-wrap {
        max-width:600px;
        max-height: 500px;
        margin:0 auto;
        overflow: auto;
    }
    .tabs {
        width: 35%;
        overflow: auto;
        float: left;
        font-size: .25rem;
    }
    .tabs>li {
        display: block;
        padding:10px;
        line-height: 36px;
        border-bottom:1px solid #e0e0e0;
        color:#666;
        text-align: left;
        cursor:pointer;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .tabs>li:hover {
        background: #f2f2f2;
    }
    .tabs>.active {
        color:#28a28b;
        font-weight: bold;
    }
    .tab-content{
        width: 65%;
        height: 100%;
        overflow: auto;
        float: left;
        padding: 15px 0 0 15px;
        text-align: center;
        .pubImg {
            display: block;
            width: 100%;
            height: 200px;
            background: #ddd;
        }
        .pubTitle {
            text-align: left;
            font-size: .28rem;
            color: #333;
            font-weight: bold;
            padding: 0 0 15px 0;
        }
        .pubDay {
            font-size: .27rem;
            text-align: left;
            color: #888;
            padding: 10px 0 0 0;
        }
        .pubInfo {
            padding: 10px 0 0 0;
            text-align: left;
            font-size: .26rem;
            color: #666;
        }
    }
    .tab-content>li {
        display:none;
    }
    .tab-content>.active {
        display:block;
    }




</style>