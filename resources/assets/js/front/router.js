import Vue from 'vue';
import VueRouter from  'vue-router';
import Home from './homepage/Home.vue';
import Account from './account/Account.vue'
import Search from './homepage/Search.vue'; 
//资讯
import IndustryNews from './news/IndustryNews';
import AuthorList from './news/AuthorList';
import TrendInfo from './news/TrendInfo';
import Report from './news/Report';
import ReportDetail from './news/reportDetail';
import NewsFlashes from './news/7x24h.vue';
import NewsPage from './news/NewsPage.vue';
import Special from './news/Special.vue';
import SpecialDetail from './news/SpecialDetail.vue';
import MicroDetail from './news/Micro.vue';

//小区块
import About from './parts/about.vue';
import Exbition from './parts/Exbition.vue';
import ExbitionDetail from './parts/exbitionDetail.vue';
import Help from './parts/Help.vue'; //帮助中心
import error from './parts/404.vue'; //404 error
import UserAgreement from './parts/UserAgreement.vue'; //用户协议
import AuthorAgreement from './parts/AuthorAgreement.vue'; //作者协议
import UploadAgreement from './parts/UploadAgreement.vue'; //资料上传协议

//互动问答，游戏等
import Game from './tgq/gamestore';
import GameInfo from './tgq/GameInfo';

import Question from './tgq/question';
import NewQuestion from './tgq/newQuestion';
import QuestionDetail from './tgq/questionDetail';
import MyQuestion from './tgq/myQuestion';
import QuestionSearch from './tgq/QuestionSearch'

import BeAuthor from './tgq/beAuthor.vue'; //申请成为作者
import RewardTool from './tgq/rewardTool.vue'; //开奖工具

//交易
import Platform from './trade/Platform';
import Bussiness from './trade/Business';
import BussinessDetail from './trade/BusinessDetail.vue';
import PlatformDetail from './trade/PlatformDetail.vue';
import Publish from './trade/Publish.vue';
import PubBusiness_fwgys from './trade/PubBusiness_fwgys.vue';
import PubBusiness_qgxqf from './trade/PubBusiness_qgxqf.vue';
import PubPlatform_daili from './trade/PubPlatform_daili.vue';
import PubPlatform_pingtai from './trade/PubPlatform_pingtai.vue';
import PubSuccess from './trade/PubSuccess.vue';

//用户中心
import UserZone from './user/UserZone';
import WriteEditor from './user/WriteEditor.vue';
import UserPage from './user/UserPage';

//用户数据
import UserDataList from './userdata/UserDataList';
import UserDataDetail from './userdata/UserDataDetail';
import UserDataUpload from './userdata/UserDataUpload';
import MyData from './userdata/MyData';
import Navigation from './userdata/Navigation';
import Enterprise from './userdata/Enterprise';
import EnterpriseDetail from './userdata/EnterpriseDetail.vue';
import Cash from './userdata/Cash';
import CashDetail from './userdata/CashDetail';
import AddCash from './userdata/AddCash';
import AddEnterprise from './userdata/AddEnterprise';

import Push from './push';

Vue.use(VueRouter);
const routers = [
    {path:'/',component:Home},


    {path:'/push',component:Push},
    {path:'/search',component:Search},
    {path:'/account',component:Account},
    {path:'/news',component:IndustryNews},//产业资讯
    {path:'/news/author',component:AuthorList},//专栏作者
    {path:'/news/beAuthor',component:BeAuthor},//申请成为作者
    {path:'/news/trend',component:TrendInfo},//产品动态
    {path:'/news/report',component:Report},//数据报告    
    {path:'/news/reportDetail/:report_id',component:ReportDetail},//数据报告
    {path:'/news/newspage/:news_id',component:NewsPage},//咨询详情页
    {path:'/news/special',component:Special},//产业专题列表页
    {path:'/news/SpecialDetail/:special_id',component:SpecialDetail},//产业专题详情页
    {path:'/7x24h',component:NewsFlashes}, //7*24小时快讯
    {path:'/parts/about', component:About },
    {path:'/parts/Help', component:Help }, //帮助中心
    {path:'/parts/UserAgreement', component:UserAgreement }, //用户协议
    {path:'/parts/AuthorAgreement', component:AuthorAgreement }, //作者协议
    {path:'/parts/UploadAgreement', component:UploadAgreement }, //资料上传协议
    {path:'/parts/exbition', component:Exbition},
    {path:'/parts/ExbitionDetail/:eid', component:ExbitionDetail},
    {path:'/gamepage',component:Game},
    {path:'/gameinfo',component:GameInfo},

	{path:'/questionpage',component:Question},//互动问答页面
    {path:'/newquestion',component:NewQuestion,meta:{requireAuth: true}},//提问问题
    {path:'/questiondetail/:qid',component:QuestionDetail},//提问问题
    {path:'/myquestion/:type',component:MyQuestion,meta:{requireAuth: true}},//我的问答
    {path:'/questionsearch',component:QuestionSearch,meta:{requireAuth: true}},//互动问答页面

    {path:'/rewardpage',component:RewardTool}, //开奖工具
    {path:'/trade/platform/:game(\\d+)?/:settlement(\\d+)?',component:Platform},//代理招商
    {path:'/trade/business/:cat1_id(\\d+)?/:cat2_id(\\d+)?',component:Bussiness},//供求商讯
    {path:'/trade/PlatformDetail/:platform_id',component:PlatformDetail},//平台招募详情页
    {path:'/trade/BusinessDetail/:business_id',component:BussinessDetail},//供求商讯详情页
	{path:'/user/userzone/:user_id',component:UserZone},
	{path:'/user/userpage/:tab(\\d+)?',component:UserPage,meta:{requireAuth: true}},
	{path:'/user/write',component:WriteEditor,meta:{requireAuthor: true}},
	{path:'/userdata/datalist',component:UserDataList},//数据报告列表
    {path:'/userdata/UserDataDetail/:userdata_id',component:UserDataDetail},//用户资料详情页
    {path:'/userdata/UserDataUpload',component:UserDataUpload,meta:{requireAuth: true}},//用户资料上传页
    {path:'/userdata/MyData',component:MyData,meta:{requireAuth: true}},//我的数据报告    
    {path:'/userdata/Navigation',component:Navigation},//优质网址导航

    {path:'/userdata/Enterprise',component:Enterprise},//企业库
    {path:'/userdata/EnterpriseDetail/:enterprise_id',component:EnterpriseDetail},//企业详情页
    {path:'/userdata/Cash',component:Cash},//现金网
    {path:'/userdata/CashDetail/:cash_id',component:CashDetail},//现金网详情页
    {path:'/userdata/addCash',component:AddCash,meta:{requireAuth: true}},//添加现金网
    {path:'/userdata/addEnterprise',component:AddEnterprise},//添加企业库

    {path:'/trade/Publish',component:Publish,meta:{requireAuth: true}},//发布信息

    {path:'/trade/PubBusiness_fwgys',component:PubBusiness_fwgys,meta:{requireAuth: true}},//发布供求商讯_服务供应商
    {path:'/trade/PubBusiness_qgxqf',component:PubBusiness_qgxqf,meta:{requireAuth: true}},//发布供求商讯_求购需求方

    {path:'/trade/PubPlatform_daili',component:PubPlatform_daili,meta:{requireAuth: true}},//发布代理招商_代理
    {path:'/trade/PubPlatform_pingtai',component:PubPlatform_pingtai,meta:{requireAuth: true}},//发布代理招商_平台

    {path:'/trade/PubSuccess/:type',component:PubSuccess},//信息提交成功
    {path:'/news/micro',component:MicroDetail},//咨询详情页
    {path:'/error/404', component:error }, //404 error
    {path:'*', component:error }, //404 error

];
const router = new VueRouter({
    mode: 'history',
    routes: routers
});
router.beforeEach((to, from, next) => {
    if (to.meta.requireAuth) {  //判断该路由是否需要登录权限
        if (router.app.$store&&router.app.$store.state.user_info){ 
            next();
        }else{
            router.app.https.get('/common/is_login').then((r)=>{
            if (r.data.code) {
                next();        
            }else{
                next({
                    path: '/account',
                    query: {redirect: to.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
                })    
            }}).catch((e)=>{
                console.log(e);
            });
        }
    }else if(to.meta.requireAuthor){
        if (router.app.$store&&router.app.$store.state.user_info&&router.app.$store.state.user_info.is_author){ 
            next();
        }else if (!router.app.$store||!(router.app.$store&&router.app.$store.state.user_info)) {
            router.app.https.get('/common/is_login').then((r)=>{
                if (r.data.code) {
                    if (r.data.user_info.is_author) {
                        next() 
                    }else{
                        next({
                            path: '/news/beAuthor'
                        }) 
                    }     
                }else{              
                    next({
                        path: '/account',
                        query: {redirect: to.fullPath}  // 将跳转的路由path作为参数，登录成功后跳转到该路由
                    })    
                }}).catch((e)=>{
                    console.log(e);
                }); 
        }else if (router.app.$store&&!router.app.$store.state.user_info.is_author) {    
            router.app.$Message.warning('请申请成为认证作者后，开始您的创作')
            next({
                path: '/news/beAuthor'
            }) 
        }      
    }else{
        next();
    }
})
export default router;