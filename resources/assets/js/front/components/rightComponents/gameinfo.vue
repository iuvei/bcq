<template>
<div id="gameinfo" v-if="loading&&gameinfo">
	<Row>
	    <Col :xs="24" :sm="24" :lg="24">
	        <div class="components-title">
	            {{title}}
	            <a v-bind:href="'/gameinfo'"><span><img src="/static/down_row.png" class="title-image"></span></a>
	        </div>
	    </Col>
	     <Col :xs="24" :sm="24" :lg="24">
			<div class="content-zone">
				<div class="content-fame">
					<div class="avatar">
						<div class="avatar-frame-new">
							<a v-bind:href="'/user/userzone/'+gameinfo.uid" target="blank">
								<img v-bind:src="gameinfo.user.image">
							</a>
						</div>
					</div>
					<div class="username">&nbsp&nbsp<span class="username-author">{{gameinfo.user.username}}</span><br>&nbsp&nbsp<span class="userdesc">{{gameinfo.user.desc}}</span></div>
					<div class="pointer micro-content"><a class="title" v-bind:href="'/news/micro?id='+gameinfo.id" target="blank"><div v-html="gameinfo.content"></div></a></div>
				</div>
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
		v.https.get('/front/components/get_game_info').then((r)=>{
			v.gameinfo = r.data
			if (v.gameinfo) {
				v.loading = true
			}
		}).catch((e)=>{
			console.log(e)
		})
	},
	data(){
		return {
			gameinfo:'',
			loading:false
		}
	}
}
</script>
<style lang="scss" scoped>
	#gameinfo{
		 	.content-zone{
		 		padding: 10px 0 10px 0;
				display: block;
				vertical-align: middle;
				padding-left: 15px;
				border-bottom: 1px solid #f2f2f2;
				&:hover{
					background-color: #f2f2f2;
				}
				.title{
					font-size: 20px;
					line-height: 25px;
					height: 25px;
					overflow: hidden;
					font-weight: bolder;
					color: #333333;
					&:hover{
						color: #28b28a;
					}
				}
				.avatar{
					display: inline-block;
					width: 40px;
				}
				.username{
					font-size: 14px;
					.userdesc{
						font-size: 12px;
						color: #999999;
					}
				}
				.tags,.avatar,.username,.comment,.time,.view,.collection{
					display: inline-block;
					vertical-align: middle;
				}
				.micro-content{
					line-height: 30px;
					height: 30px;
					a{
						font-size: 14px;	
						font-weight: normal;			
					}
				}
				.content-info{
					font-size: 14px;
					padding-top: 5px;
					.tags{
						border:1px solid #f22284;
						color: #f22284;
						padding-left:5px;
						padding-right: 5px; 
					}
				}
			} 		
	}
</style>