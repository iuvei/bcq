<template>
	<div id="income-bar">
    	<Row type="flex" align="middle" :class-name="'report-bar'">
    		<Col :xs="{'span':8}" :sm="{'span':8}" :lg="{'span':8}">
    			<ul class="income-total">
    				<li class="income-total-title">累计收益金额(元)</li>
    				<li class="income-total-value"><span>￥</span>{{income_total}}</li>
    			</ul>	        			
    		</Col>
    		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
    			<ul class="income-detail">
    				<div class="break-line"></div>
    				<li class="income-detail-title">已提金额</li>
    				<li class="income-detail-value">{{income_pick}}</li>
    			</ul>
    		</Col>
    		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
    			<ul class="income-detail">
    				<div class="break-line"></div>    				
    				<li class="income-detail-title">剩余金额</li>
    				<li class="income-detail-value">{{income_last}}</li>
    			</ul>
    		</Col>
    		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
    			<ul class="income-detail">
    				<div class="break-line"></div>    				
    				<li class="income-detail-title">本月文章点击量</li>
    				<li class="income-detail-value"><label v-if="view_trend"><Icon type="android-arrow-up" color="#28b28a"></Icon></label><label v-else><Icon type="android-arrow-down" color="red"></Icon></label>&nbsp{{view_month}}</li>	        				
    			</ul>
    		</Col>
    		<Col :xs="{'span':4}" :sm="{'span':4}" :lg="{'span':4}">
    			<ul class="income-detail">    				
    				<li class="income-detail-title">总点击量</li>
    				<li class="income-detail-value">{{view_total}}</li>	        				
    			</ul>
    		</Col>	        		
    	</Row>		
	</div>
</template>
<script>
	export default{
		mounted(){
			var v = this
			this.https.get('/front/user_center/report_bar').then((r)=>{
				v.income_total = r.data.income_total
				v.income_pick = r.data.income_pick
				v.income_last = r.data.income_last
				v.view_month = r.data.view_month
				v.view_total = r.data.view_total
				v.view_trend = r.data.view_trend
				this.$emit('getlast',v.income_last)
			}).catch((e)=>{
				console.log(e)
			})
		},
		data(){
			return {
				name:'report',
				income_total:0,
				income_pick:0,
				income_last:0,
				view_month:0,
				view_total:0,
				view_trend:1
			}
		},
		methods:{

			
		}
	}
</script>
<style lang='scss' scoped>
#income-bar{
	.report-bar{
		background-color: #f1faf7;
		padding:10px 10px 10px 10px;
		.income-total{
			display: flex;
			flex-direction:column;
			vertical-align: middle;
			text-align: left;
			.income-total-title{
				font-size:16px; 
			}
			.income-total-value{
				font-size: 42px;
				font-weight: bold;
				color:#28b28a;
				span{
					font-size: 16px;
				}
			}
		}
		.income-detail{
			height: 100%;
			display: flex;
			flex-direction:column;
			justify-content: center;
			text-align: center;
			position: relative;
			.break-line{
				height: 30px;
				position: absolute;
				right: 0;
				top: 10px;
				width: 1px;
				border-right: 1px solid #7a7a7a;
			}
			.income-detail-title{
				font-size: 14px;
			}
			.income-detail-value{
				font-size: 30px;
				font-weight: bold;
				color: #333;
			}
		}
	}	
}	
</style>