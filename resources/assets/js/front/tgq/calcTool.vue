<template>
    <div class="calc-modal">
        <div class="modal-dialog">
            <div class="modal-head">
                <h3>打码计算器(流水)</h3>
                <Icon type="android-close" class="m-close"></Icon>
            </div>
            <div class="modal-main">
                <div class="tab-wrap clearfix">
                    <ul class="tabs">
                        <li class="active">返利</li>
                        <li>充一返一</li>
                        <li>免费送</li>
                    </ul>
                    <ul class="tab-content">
                        <li class="active">
                            <div class="calc-zoo">
                                <p>
                                    <label>
                                        充值量：(元)
                                    </label>
                                    <Input v-model.number="value1" element-id="value1" placeholder="请输入数字" style="width: 200px"></Input>
                                </p>
                                <p>
                                    <label>
                                        赠送额：(让利)
                                    </label>
                                    <Input v-model.number="rebate1" element-id="rebate1" placeholder="请输入数字" style="width: 200px;display: inline-table;">
                                    <Select v-model.number="rebate1Type" element-id="rebate1Type" slot="append" style="width: 70px;">
                                        <Option :value="1" :selected="'selected'">%</Option>
                                        <Option :value="2">元</Option>
                                    </Select>
                                    </Input>
                                </p>
                                <p>
                                    <label>
                                        奖金组：(返点)
                                    </label>
                                    <AutoComplete v-model.number="group" :data="groupList" element-id="group" @on-search="groupsearch" placeholder="请选择,可手动输入" style="width:200px">
                                    </AutoComplete>
                                </p>
                                <p class="calBtn"><a class="Icon-calculate" @click="get1AM">计算</a></p>
                            </div>
                            <div class="CalResult">
                                <p>计算结果：</p>
                                <p class="cr1">流水量: = <span :id="'amount1'">0</span>元</p>
                                <p class="cr2">倍&nbsp;&nbsp;&nbsp;数: = <span :id="'multiple1'">0</span>倍</p>
                                <p class="cr3">如果想要让利给玩家则倍数与流水量均要小于计算值哦~</p>
                            </div>
                        </li>
                        <li>
                            <div class="calc-zoo">
                                <p>
                                    <label>
                                        充值量：(元)
                                    </label>
                                    <Input v-model.number="value2" element-id="value2" placeholder="请输入数字" style="width: 200px"></Input>
                                </p>
                                <p>
                                    <label>
                                        奖金组：(返点)
                                    </label>
                                    <AutoComplete v-model.number="group" :data="groupList" element-id="group" @on-search="groupsearch" placeholder="请选择,可手动输入" style="width:200px">
                                    </AutoComplete>
                                </p>
                                <p class="calBtn"><a class="Icon-calculate" @click="get2AM">计算</a></p>
                            </div>
                            <div class="CalResult">
                                <p>计算结果：</p>
                                <p class="cr1">流水量: = <span :id="'amount2'">0</span>元</p>
                                <p class="cr2">倍&nbsp;&nbsp;&nbsp;数: = <span :id="'multiple2'">0</span>倍</p>
                                <p class="cr3">如果想要让利给玩家则倍数与流水量均要小于计算值哦~</p>
                            </div>
                        </li>
                        <li>
                            <div class="calc-zoo">
                                <p>
                                    <label>
                                        赠送额：(元)
                                    </label>
                                    <Input v-model.number="value3" element-id="value3" placeholder="请输入数字" style="width: 200px"></Input>
                                </p>
                                <p>
                                    <label>
                                        奖金组：(返点)
                                    </label>
                                    <AutoComplete v-model.number="group" :data="groupList" element-id="group" @on-search="groupsearch" placeholder="请选择,可手动输入" style="width:200px">
                                    </AutoComplete>
                                </p>
                                <p class="calBtn"><a class="Icon-calculate" @click="get3A">计算</a></p>
                            </div>
                            <div class="CalResult">
                                <p>计算结果：</p>
                                <p class="cr1">流水量: = <span :id="'amount3'">0</span>元</p>
                                <p class="cr3">如果想要让利给玩家则流水量要小于计算值哦~</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import $ from 'jquery';
    import '../../../css/reset_alex.scss';

    export default {
        data(){
            return {
                value1: 0,
                rebate1Type: 1,
                rebate1: 0,
                value2: 0,
                value3: 0,
                group: 0,
                groupList: [
                    1990, 1980, 1970, 1960, 1950, 1940, 1930, 1920, 1910, 1900,
                ]
            }
        },
        methods: {
            groupsearch (value) {
                value = Number(value);
                let newGroupList = new Array(
                    1990, 1980, 1970, 1960, 1950, 1940, 1930, 1920, 1910, 1900,
                );
                switch (value.toString().length){
                    case 1:
                        newGroupList = [
                            1990+ value,1980+ value,1970+ value,1960+ value,1950+ value,1940+ value,1930+ value,1920+ value,1910+ value,1900+ value,
                        ];
                        this.groupList = !value ? [] : newGroupList;
                        break;
                    case 2:
                        newGroupList.push(1900+ value);
                        this.groupList = !value ? [] : newGroupList;
                        break;
                    case 3:
                        newGroupList.push(1000+ value);
                        this.groupList = !value ? [] : newGroupList;
                        break;
                    case 4:
                        if(!$.inArray(value,newGroupList)){
                            newGroupList.push(value);
                        }
                        this.groupList = !value ? [] : newGroupList;
                        break;
                    default:
                        this.groupList = newGroupList;
                }
            },
            get1AM(){
                this.getTools();
                $("#amount1").html(this.amount1);
                $("#multiple1").html(this.multiple1);
            },
            get2AM(){
                this.getTools();
                $("#amount2").html(this.amount2);
                $("#multiple2").html(this.multiple2);
            },
            get3A(){
                this.getTools();
                $("#amount3").html(this.amount3);
            },
            getTools(){
                this.https.get('/common/tools_use_record?type=1');

            },
        },
        mounted: function () {
            $("#value1,#value2,#value3,#rebate1,#group").attr('type','number');
            $(document).ready(function () {
                let btn = $(".calc-tool");
                let modal = $(".calc-modal");
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
            $(document).ready(function () {
                $(".tabs").on("click","li", function (e) {
                    e.preventDefault();
                    let idx = $(this).index();
                    $(this).siblings().removeClass("active");
                    $(this).addClass("active");
                    $(this).parents(".tab-wrap").find(".tab-content>li").eq(idx).siblings().removeClass("active");
                    $(this).parents(".tab-wrap").find(".tab-content>li").eq(idx).addClass("active");
                })
            })            
        },
        watch: {   //watch()监听某个值（双向绑定）的变化，从而达到change事件监听的效果
            group: {
                handler: function () {
                    if (this.value3 >= 2000){
                        this.value3 = 0;
                    }
                }
            }
        },
        computed: {
            amount1: function () {
                let transit = 0;
                if(this.rebate1Type == 1){
                    transit = (this.value1 * this.rebate1 * 0.01 / ((2000 - this.group) / 2000)).toFixed(0);
                }else{
                    transit = (this.rebate1 / ((2000 - this.group) / 2000)).toFixed(0);
                }
                if (isNaN(transit)){
                    return 0;
                }else{
                    return transit;
                }
            },
            multiple1: function () {
                let transit = (this.amount1 / this.value1).toFixed(0);
                if (isNaN(transit)){
                    return 0;
                }else{
                    return transit;
                }
            },
            amount2: function () {
                let transit = (this.value2 / ((2000 - this.group) / 2000)).toFixed(0);
                if (isNaN(transit)){
                    return 0;
                }else{
                    return transit;
                }
            },
            multiple2: function () {
                let transit = (this.amount2 / this.value2).toFixed(0);
                if (isNaN(transit)){
                    return 0;
                }else{
                    return transit;
                }
            },
            amount3: function () {
                let transit = (this.value3 / ((2000 - this.group) / 2000)).toFixed(0);
                if (isNaN(transit)){
                    return 0;
                }else{
                    return transit;
                }
            },
        }
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
    h3 {
        margin:0;
        padding:0;
    }
    .clearfix:after {
        content:"";
        display:block;
        clear:both;
    }
    .calc-modal {
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
        border-bottom:1px solid #28a28b;
        >h3 {
            color: #28a28b;
            font-size: .28rem;
            line-height: .5rem;
            font-weight: bold;
            padding: 5px 0 10px 0;
            text-align: left;
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
        /* tab */
        .tab-wrap {
            width:100%;
            height: 100%;
            margin:0 auto;
            overflow: auto;
        }
        .tabs {
            max-width: 418px;
            margin: 15px auto;
            font-size: .25rem;
            display: flex;
            justify-content: center;
        }
        .tabs>li {
            width: 33.3%;
            padding: 8px 30px;
            line-height: 24px;
            color: #666;
            font-size: .28rem;
            text-align: center;
            border-radius: 5px;
            border: 1px solid #e0e0e0;
            cursor: pointer;
            &:first-child {
                border-right: 0;
                -webkit-border-radius: 5px 0 0 5px;
                -moz-border-radius: 5px 0 0 5px;
                border-radius: 5px 0 0 5px;
                &:hover {
                    border-right: 1px solid #28b28a;
                }
            }
            &:nth-child(2){
                border-radius: 0;
                &:hover {
                    border-left: 1px solid #28b28a;
                    border-right: 1px solid #28b28a;
                }
            }
            &:last-child {
                border-left: 0;
                -webkit-border-radius: 0 5px 5px 0;
                -moz-border-radius: 0 5px 5px 0;
                border-radius: 0 5px 5px 0;
                &:hover {
                    border-left: 1px solid #28b28a;
                }
            }
        }
        .tabs>.active {
            color: #fff;
            background: #28b28a;
            border-color: #28b28a;
        }
        .tabs>li:hover {
            border-color: #28b28a;
        }
        .tab-content{
            width: 100%;
            margin: 0 auto;
            height: 100%;
            overflow: auto;
            padding: 15px 0;
            text-align: center;
        }
        .tab-content>li {
            display:none;
            color: #333;
            font-size: .28rem;
        }
        .tab-content>li.active {
            display:block;
        }
    }
    .tab-content>li {
        .calc-zoo {
            width: 100%;
            min-height: 295px;
            margin: 0 auto;
            padding: 10px 10px 30px 10px;
            border-bottom: 1px dashed #28b28a;
            &:last-child {
                border-bottom: none;
            }
            p {
                padding: 10px 10px 10px 44px;
                text-align: left;
                font-size: .26rem;
                line-height: .26rem;
                label {
                    padding-top: 5px;
                    font-size: .26rem;
                    display: inline-block;
                    width: 72px;
                    height: 40px;
                    vertical-align: middle;
                    &:first-child {
                        padding-top: 8px;
                    }
                }
                Input {
                    height: 40px;
                    vertical-align: middle;
                }
            }
            .calBtn {
                text-align: center;
                margin: 0 auto;
            }
            .Icon-calculate {
                width: 200px;
                color: #fff;
                font-size: .3rem;
                display: block;
                padding: 15px 30px;
                background: #28b28a;
                text-align: center;
                border-radius: 5px;
                margin-left: 77px;
                &:hover {
                    background: #219472;
                }
            }
        }
        .CalResult {
            border-bottom: none;
            padding: 10px 20px;
            text-align: center;
            p {
                padding: 10px 10px;
                text-align: left;
                font-size: .26rem;
                line-height: .26rem;
            }
            p.cr1, p.cr2, p.cr3 {
                text-align: center;

            }
            p.cr1, p.cr2 {
                span {
                    color: #28b28a;
                    font-weight: bold;
                    margin: 0 5px;
                }
            }
            p.cr3 {
                font-size: .23rem;
                color: #888;
            }
        }
    }


</style>