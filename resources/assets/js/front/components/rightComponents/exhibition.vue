<template>
<div id="exhibition" v-if="show_pannel">
    <Row>
        <Col>
            <div class="components-title">
                {{title}}
                <a v-bind:href="'/parts/exbition'" target="_blank"><span><img src="/static/down_row.png" class="title-image"></span></a>
            </div>
        </Col>
    </Row>	
	<Row :class-name="'exhibition'">
		<Col :xs="8" :sm="8" :lg="8">
			<div class='img-frame'>
				<img v-bind:src="exhibition.image" onerror="this.src='/static/noimg.png'">
			</div>
		</Col>
		<Col :xs="16" :sm="16" :lg="16" :class-name="'exhibition-info'">
			<div class="title"><a v-bind:href="exhibition.url" target="_blank">{{exhibition.title}}</a></div>
			<div class="time"><span><Icon color="gray" type="android-time"></Icon></span>{{exhibition.startdate}}-{{exhibition.enddate}}</div>
			<div class="address"><span><Icon color="gray" type="ios-location-outline"></Icon></span>{{exhibition.address}}</div>
		</Col>
		<Col :xs="24" :sm="24" :lg="24" v-if="show_count">
			<div class="cound-down">
				<span v-if="d<1000">{{d}}</span><span v-else :title="d">999+</span>
				天 <span>{{h}}</span> 时 <span>{{m}}</span> 分 <span>{{s}}</span> 秒 &nbsp&nbsp&nbsp&nbsp后开幕
			</div>
		</Col>
	</Row>
</div>
</template>
<script>
	export default{
		props:['title'],
		mounted(){
			var v = this
			v.https.get('/front/components/get_exhibition').then((r)=>{
				v.exhibition = r.data
				if(!v.exhibition){
					v.exhibition = {}
					return false
				}else{
					v.show_pannel = true
					v.starttime = r.data.starttime
		            let time = setInterval(()=>{
		               if(v.flag == true){
		                   clearInterval(time)
		               }
		            v.timeDown()
		            },1000)	
				}				
			}).catch((e)=>{
				console.log(e)
			})			
		},
		data(){
			return {
				exhibition:'',	
              	flag : false,
              	starttime:0,
              	d:0,
              	h:0,
              	m:0,
              	s:0,
              	show_pannel:false,
              	show_count:false				
			}
		},
        methods:{
            go: function (path) {
                var path = path
                this.$router.push({path: path})
            },
           timeDown () {
               	const starttime = parseInt(this.exhibition.format)*1000
               	const nowTime = new Date()
               	let leftTime = (starttime-nowTime.getTime())/1000
               	let d = parseInt(leftTime/(24*60*60))
               	let h = parseInt(leftTime/(60*60)%24)
               	let m = parseInt(leftTime/60%60)
               	let s = parseInt(leftTime%60)
               	if(leftTime <= 0){
               	    this.flag = true
               	}
               	this.d = d
               	this.h = h
               	this.m = m
               	this.s = s               	
               	if (!this.show_count) {
               		this.show_count = true
               	}            
           },
           format (time) {
               if(time>=10){
                   return time
               }else{
                   return `0${time}`
               }
           }           
        }		
	}
</script>
<style lang="scss" scoped>
	* {
		box-sizing: border-box;
	}
	html,body{
		height: 100%;
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}
#exhibition {
	padding-bottom: 50px;
	.exhibition{
		padding-top: 20px;
	    .img-frame{
	        width: 100%;
	        height: 0;
	        padding-bottom:65%;
	        overflow: hidden; 
	        border-radius: 3px;
	        position: relative;
	        border: 1px solid #f2f2f2;
	        >img{
	            position: absolute;
	            top: 0;
	            left: 0;
	            width: 100%;
	            height: 100%;
	            transition-duration: 0.7s;
	            cursor: pointer; 
	            border-radius: 4px;
	            &:hover {
	                transform: scale(1.1);
	            }
	        }
	    } 	
	    .exhibition-info{
	    	padding-left: 10px;
	    	color: #333333;
	    	.title{
	    		font-size:16px;
	    		font-weight: bold; 
	    		a{
	    			color: #333333;
	    			cursor: pointer;
	    			&:hover{
	    				color: #28b28a;
	    			}
	    		}
	    	}
	    	.address,.time {
	    		font-size: 14px;
	    		padding-top: 5px;
	    		span {
	    			width: 20px;
	    			display: inline-block;
	    			text-align: center;
	    		}
	    	}
	    	.title,.address,.time{
                overflow: hidden;
                text-overflow: ellipsis;
                -o-text-overflow:ellipsis;
                display: -webkit-box;
                -webkit-line-clamp: 1;
                -webkit-box-orient: vertical;	    		
	    	}
	    }
	    .cound-down {
	    	font-size: 14px;
	    	padding-top: 20px;
	    	span {
	    		font-size: 16px;
	    		display: inline-block;
	    		padding: 3px 5px 3px 5px;
	    		width: 45px;
	    		height: 30px;
	    		color: #fff;
	    		background-color: #ff7b34;
	    		text-align: center;
	    		border-radius: 4px;
	    	}
	    	em{
	    		padding:0 5px 0 5px;
	    	}
	    }
	}
}	
</style>