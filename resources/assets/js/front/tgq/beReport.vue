<template>
    <div class="report-modal">
        <div class="modal-dialog">
            <div class="modal-head">
                <Icon type="android-close" class="m-close"></Icon>
            </div>
            <div class="modal-main">
                <div class="tab-wrap">
                    <h2>欢迎有以下需求的朋友联系我们</h2>
                    <ul>
                        <li>1. 我觉得我公司的产品不错，可以报道</li>
                        <li>2. 我觉得我的business不错，可以报道</li>
                        <li>3. 我长期对产业保持观察，有话想说</li>
                        <li>4. 我要爆料</li>
                    </ul>
                    <p>
                        <h4 style="line-height: 1; font-size: 12px; color: #888;text-align:center">
                            扫描二维码，添加[ 报道助理 ]为好友
                        </h4>
                        <p class="wechat-qrcode" style="text-align: center;">
                            <img src="/static/qq-report.jpg" alt="扫码添加报道助理" style="width: 132px; height: 132px; vertical-align: middle;">
                        </p>
                        <h4 style="line-height: 1; font-size: 12px; color: #888; padding: 5px 0;;text-align:center">点击下方链接</h4>
                        <ul class="contact">
                            <li><a href="https://t.me/bcquan" target="_blank">https://t.me/bcquan</a>加入菠菜圈交流群</li>
                            <li><a href="https://t.me/bcquancom" target="_blank">https://t.me/bcquancom</a>关注菠菜圈频道</li>
                            <li>或于Telegram搜索“菠菜圈”</li>
                        </ul>
                    </p>
                    <p>
                        <button class="rep-button m-close">我知道了</button>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import $ from 'jquery';
    import '../../../css/reset_alex.scss';

    export default {
        mounted(){
            $(document).ready(function () {
                let btn = $(".be-report");
                let modal = $(".report-modal");
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
            })
        },
        data(){
            return {
                acType: '行业资讯',
            }
        },
        methods: {

        },
    }

</script>

<style lang="scss" scoped>
    html {
        position: relative;
    }
    ul,li {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    /* modal */
    .clearfix:after {
        content:"";
        display:block;
        clear:both;
    }
    .report-modal {
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
        width:420px;
        height: 628px;
        border:1px solid #ddd;
        border-radius:4px;
        position:absolute;
        left:50%;
        top:50%;
        margin-left:-210px;
        margin-top:-314px;
        background-color:#fff;
        display:none;
        padding: 10px 15px;
    }
    .modal-head {
        text-align: right;
        line-height: 40px;
        >.m-close {
            font-size:18px;
            color:#888;
            cursor:pointer;
        }
    }
    .modal-main {
        /*padding: 0 0 10px 0;*/
        /* tab */
        .tab-wrap {
            width:100%;
            height: 100%;
            overflow: auto;
            margin: 0 auto;
            h2 {
                max-width: 418px;
                margin: 5px auto;
                padding: 0 20px 10px 20px;
                font-size: 16px;
                font-weight: 700;
                color: #333;
                text-align: center;
            }
            ul {
                max-width: 418px;
                margin: 5px auto;
                padding: 0 20px;
                >li {
                    padding: 5px 0 5px 64px;
                    text-align: left;
                    color: #666;
                    font-size: .28rem;
                    font-weight: 400;
                }
            }
            p {
                max-width: 418px;
                margin: 5px auto;
                padding: 5px 20px;
                text-align: center;
                .rep-button {
                    width: 210px;
                    height: 46px;
                    text-align: center;
                    padding: 10px 15px;
                    font-size: .28rem;
                    color: #fff;
                    background: #28b28a;
                    border: 1px solid #28b28a;
                    border-radius: 3px;
                    &:hover {
                        background: #229573;
                        border: 1px solid #229573;
                    }
                }
            }
            ul, li {
                margin: 0;
                padding: 0;
                list-style: none;
            }
            .contact {
                li {
                    text-align: center;
                    color: #666;
                    font-size: 14px;
                    padding: 5px 0;
                    a {
                        margin-right: 10px;
                    }
                }
            }
        }
    }


</style>