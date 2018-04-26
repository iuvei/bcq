<template>
    <div id="datepicker">
        <Row>
            <Col>
                <div class="components-title">
                    {{title}}
                </div>
            </Col>
        </Row>          
        <Row :class="'date-bar-zone'" type="flex" justify="space-between" >
            <Col :lg="7" :md="7" :sm="7">
                <Col :lg="4" :md="4" :sm="4" :class="'raw-left-zone'">
                    <span @click="yearPre">
                    <Icon type="chevron-left" class="raw-left"></Icon>
                    </span>
                </Col>
                <Col :lg="16" :md="16" :sm="16" :class="'date-bar'">
                    {{currentYear}} 年
                </Col>
                <Col :lg="4" :md="4" :sm="4" :class="'raw-right-zone'">
                    <span @click="yearNext">
                    <Icon type="chevron-right"></Icon>
                    </span>
                </Col>
            </Col>
            <Col :lg="7" :md="7" :sm="7">
                <Col :lg="4" :md="4" :sm="4" :class="'raw-left-zone'">
                <span  @click="monthPre">
                <Icon type="chevron-left" class="raw-left"></Icon>
                </span>
                </Col>
                <Col :lg="16" :md="16" :sm="16" :class="'date-bar'">
                    {{currentMonth}} 月
                </Col>
                <Col :lg="4" :md="4" :sm="4" :class="'raw-right-zone'">
                <span @click="monthNext">
                <Icon type="chevron-right" class="raw"></Icon>
                </span>
                </Col>
            </Col>
            <Col :lg="7" :md="7" :sm="7" :class="'date-bar'">
                <span @click="date_today" class="pointer">回到今天</span>
            </Col>
        </Row>
        <Row type="flex" justify="space-between" :id="'date-item-zone'">
            <Col :lg="24" :md="24" :sm="24">
                <ul class="date-item-frame">
                    <li class="date-item">一</li>
                    <li class="date-item">二</li>
                    <li class="date-item">三</li>
                    <li class="date-item">四</li>
                    <li class="date-item">五</li>
                    <li class="date-item">六</li>
                    <li class="date-item">日</li>
                    <li class="date-item" v-for="(item,key) in days" :key="key"
                        v-bind:class="{'no-currentMonth':item.day.getMonth()!=currentMonth-1,'is-today':item.day.getMonth()==new Date().getMonth()&&item.day.getFullYear()==new Date().getFullYear()&&item.day.getDate()==new Date().getDate()}">
                        <p>{{item.day.getDate()}}<br>
                            <a v-if="item.short" v-bind:href="item.url" target="blank">{{item.short}}</a>
                        </p>
                    </li>
                </ul>
            </Col>
        </Row>
    </div>
</template>
<script>
    export default {
        mounted(){
            var v = this
            this.https.get('/front/components/get_brief_list').then((r)=>{
                v.shows = r.data
                this.date_today()
            }).catch((e)=>{
                this.date_today()
                console.log(e)
            })
        },
        props:['title'],
        data(){
            return {
                currentDay:'',
                currentWeek:'',
                currentMonth:'',
                currentYear:'',
                days:[],
                shows:[]
            }
        },
        methods:{
            date_today(){
                var now=new Date();
                var date = new Date(this.formatDate(now.getFullYear(),now.getMonth() + 1,1));
                this.date_init(date)
            },
            date_init(date){
                this.currentDay = date.getDate();
                this.currentYear = date.getFullYear();
                this.currentMonth = date.getMonth() + 1;
                this.currentWeek = date.getDay(); // 1...6,0
                if (this.currentWeek == 0) {
                    this.currentWeek = 7;
                }
                var str = this.formatDate(this.currentYear , this.currentMonth, this.currentDay);
                this.days.length = 0;
                for (var i = this.currentWeek - 1; i >= 0; i--) {
                    var d = new Date(str);
                    d.setDate(d.getDate() - i);
                    var dayobject={}; //用一个对象包装Date对象  以便为以后预定功能添加属性
                    dayobject.day=d;
                    this.days.push(dayobject);//将日期放入data 中的days数组 供页面渲染使用
                }
                for (var i = 1; i <= 42 - this.currentWeek; i++) {
                    var d = new Date(str);
                    d.setDate(d.getDate() + i);
                    var dayobject={};
                    dayobject.day=d;
                    this.days.push(dayobject);
                }
                var monthstart = str

                var end = new Date(this.currentYear , this.currentMonth, 0)

                var monthend = this.formatDate(this.currentYear,this.currentMonth,end.getDate())

                for (var i = this.shows.length - 1; i >= 0; i--) {

                    if (this.shows[i].startdate < monthend&&this.shows[i].startdate >monthstart) {

                        var show_date = new Date(this.shows[i].startdate)

                        for (var j = 0; j < this.days.length; j++) {
                            if(this.days[j].day.getDate() == show_date.getDate()&&this.days[j].day.getMonth() == show_date.getMonth()){
                                this.days[j].url = this.shows[i].url
                                this.days[j].short = this.shows[i].short
/*                                console.log(this.shows[i].url)
                                console.log(this.shows[i].short)*/
                            }
                        } 
                    }
                }
            },
            monthPre(){
                var date = new Date(this.formatDate(this.currentYear,this.currentMonth-1,1))
                this.date_init(date)
            },
            monthNext(){
                if (this.currentMonth+1>12) {
                    this.currentMonth = 1
                    this.yearNext()
                    return false
                }
                var date = new Date(this.formatDate(this.currentYear,this.currentMonth+1,1))
                this.date_init(date)
            },
            yearPre(){
                var date = new Date(this.formatDate(this.currentYear-1,this.currentMonth,1))
                this.date_init(date)
            },
            yearNext(){
                var date = new Date(this.formatDate(this.currentYear+1,this.currentMonth,1))
                this.date_init(date)
            },
            formatDate: function(year,month,day){
                var y = year;
                var m = month;
                if(m<10) m = "0" + m;
                var d = day;
                if(d<10) d = "0" + d;
                return y+"-"+m+"-"+d
            },
        }
    }
</script>
<style lang="scss" scoped>
#datepicker{
    .date-bar-zone{
        padding-left: 18px;
        margin-top: 15px;
        font-size: 14px;
    }
    .date-bar{
        text-align: center;
    }
    .raw-left-zone{
        text-align: left;
        color: #28b28a;
        cursor: pointer;
    }
    .raw-right-zone{
        text-align: right;
        color: #28b28a;
        cursor: pointer;
    }
    #date-item-zone{
        .date-item-frame{
            display: flex;
            flex-direction: row;
            width: 100%;
            flex-wrap: wrap;
            .date-item{
                text-align: center;
                width: 14.2%;
                line-height: 35px;
            }
            .no-currentMonth{
                color: silver;
            }
            .is-today{
                position: relative;
                p{
                    position: absolute;
                    width: 100%;
                    z-index: 2;
                }
            }
            .date-item{
                position: relative;
                a{
                    position: absolute;
                    width: 100%;
                    text-align: center;
                    left: 0;
                    top: 0;
                    padding-top: 15px;
                    white-space:nowrap;
                    color: #28b28a;
                }
            }
            .is-today::after{
                content: "";
                position: absolute;
                top: 4px;
                left: 12px;
                width: 25px;
                height: 25px;
                border-radius: 50%;
                background-color: #28b28a;
            }
        }
    }
}
</style>