<template>
    <div class="btn-share">
        <span><Icon type="share" size="16"></Icon>&nbsp分享到：</span>
        <a v-on:click="ShareTo('weibo');"><i class="icon-weibo"></i></a>
        <a v-on:click="ShareTo('qzone');"><i class="icon-qzone"></i></a>
        <a class="wchat" v-on:click="createWechat();">
            <i class="icon-wechat"></i>
            <div class="wechat-qrcode">
                <h4>微信扫一扫分享</h4>
                <div class="qrcode">
                    <qr-code :text="'http://www.bcquan.com/'" :size="100"></qr-code>
                </div>
                <div class="help">
                    <p>微信扫一扫二维码</p>
                    <p>即可将本文分享至微信朋友圈</p>
                </div>
            </div>
        </a>
        <a v-on:click="ShareTo('douban');"><i class="icon-douban"></i></a>
        <a v-on:click="ShareTo('baidu');"><i class="icon-baidu"></i></a>
        <a v-on:click="ShareTo('linkedin');"><i class="icon-linkedin"></i></a>
        <a v-on:click="ShareTo('facebook');"><i class="icon-facebook"></i></a>
        <a v-on:click="ShareTo('twitter');"><i class="icon-twitter"></i></a>
        <!--<a v-on:click="ShareTo('google');"><i class="icon-google" style="color: #eb1c2e;"></i></a>-->
    </div>
</template>


<script>
    import '../../../css/icons.css';
    import $ from 'jquery';
    import VueQRCodeComponent from 'vue-qrcode-component'
    export default {
        components:{'qr-code':VueQRCodeComponent},
        mounted(){
        },
        methods: {
            ShareTo: function(obj){
                let _url = window.location.href;
                let shareuri = encodeURIComponent(_url);
                let sharetitle = '菠菜圈_东南亚菠菜产业第一指引者';
                let target_url;
                switch(obj){
                    case 'qzone':
                        target_url = 'http://sns.qzone.qq.com/cgi-bin/qzshare/cgi_qzshare_onekey?url='+shareuri+'&title='+sharetitle;
                        break;
                    case 'baidu':
                        target_url='http://s.share.baidu.com/mshare?title=' + shareuri + '——' + sharetitle;
                        break;
                    case 'weibo':
                        target_url='http://service.weibo.com/share/share.php?url='+shareuri+'&title='+sharetitle;
                        break;
                    case 'linkedin':
                        target_url='http://www.linkedin.com/shareArticle?mini=true&url='+shareuri+'&content='+sharetitle;
                        break;
                    case 'douban':
                        target_url='http://www.douban.com/recommend/?url='+shareuri+'&title='+sharetitle;
                        break;
                    case 'facebook':
                        target_url='http://www.facebook.com/sharer.php?u='+shareuri+'&t='+sharetitle;
                        break;
                    case 'twitter':
                        target_url='http://twitter.com/home?status='+sharetitle+' - '+shareuri;
                        break;
                    case 'qq':
                        target_url='http://connect.qq.com/widget/shareqq/index.html?'+shareuri+'&title='+sharetitle;
                        break;
                    case 'goggle':
                        target_url='http://www.google.com/bookmarks/mark?op=add&bkmk='+shareuri+'&title='+sharetitle;
                        break;
                }
                window.open(target_url);
            },
            createWechat: function() {
                let $wechat = $('a.wchat');
                if (!$wechat.length) {return;}
                if ($wechat.offset().top < 100) {
                    $wechat.find('.wechat-qrcode').addClass('bottom');
                }
            }
        },
    }
</script>

<style lang="scss" scoped>
    .btn-share {
        text-align: right;
        display: flex;
        flex-direction:row;
        align-items:center;
        justify-content:flex-end;
        span{
            font-size: 14px;
        }
        a {
            /*margin-right: 2px;*/
            margin-right: -2px;
            display: inline-block;
            padding: 3px;
            text-align: center;
            &:hover i.icon-weibo {
                color: #df4d69;
            }
            &:hover i.icon-qzone {
                color: #e6c738;
            }
            &:hover i.icon-wechat {
                color: #42ae3c;
            }
            &:hover i.icon-douban {
                color: #319e28;
            }
            &:hover i.icon-baidu {
                color: #369ee9;
            }
            &:hover i.icon-linkedin {
                color: #b183ce;
            }
            &:hover i.icon-facebook {
                color: #336799;
            }
            &:hover i.icon-twitter {
                color: #00acec;
            }
            i {
                vertical-align: middle;
                font-style: normal;
                font-size: .35rem;
                /*font-size: .4rem;*/
                color: #9ca4ab;
                transition: all .3s;
            }
        }
        a.wchat {
            position: relative;
            &:hover .wechat-qrcode {
                display: block;
            }
            .icon-wechat {

            }
        }
        .wechat-qrcode {
            display: none;
            border: 1px solid #eee;
            position: absolute;
            /*top: -205px;*/
            /*left: -84px;*/
            top: -195px;
            left: -88px;
            z-index: 2222;
            width: 200px;
            height: 192px;
            color: #666;
            font-size: 12px;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 2px 10px #aaa;
            transition: all 200ms;
            -webkit-tansition: all 350ms;
            -moz-transition: all 350ms;
        }
        .wechat-qrcode h4 {
            font-weight: normal;
            height: 26px;
            line-height: 26px;
            font-size: 14px;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
            color: #777;
        }
        .wechat-qrcode .qrcode {
            width: 106px;
            margin: 10px auto;
        }
        .wechat-qrcode .qrcode table {
            margin: 0 !important;
        }
        .wechat-qrcode .help p {
            font-weight: normal;
            line-height: 16px;
            padding: 0;
            margin: 0;
        }
        .wechat-qrcode:after {
            content: '';
            position: absolute;
            left: 50%;
            margin-left: -6px;
            bottom: -13px;
            width: 0;
            height: 0;
            border-width: 8px 6px 6px 6px;
            border-style: solid;
            border-color: #fff transparent transparent transparent;
        }
        .wechat-qrcode.bottom {
            top:40px;
            left:-84px;
            &:after {
                display:none;
            }
        }
    }
</style>