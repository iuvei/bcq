<template>
<div id="user-pannel" v-if="user">
	<Row>
	    <Col :xs="24" :sm="24" :lg="24" :class-name="'author'">
	        <Col :xs="5" :sm="5" :lg="5" :class-name="'author-avatar'">
	            <div class="avatar-frame-new">
	            	<a v-bind:href="'/user/userzone/'+user.id" target="_blank">
	                	<img :src="user.image" onerror="this.src='/static/noimg.png'">
	            	</a>
	            </div>
	        </Col>
	        <Col :xs="19" :sm="19" :lg="19" :class-name="'author-info'">
	            <Col :xs="24" :sm="24" :lg="24">
	            	<a v-bind:href="'/user/userzone/'+user.id" target="_blank">
		                <Row>
		                    <Col :xs="24" :sm="24" :lg="24">
		                        <div class="author-name">{{user.username}}</div>
		                        <img src='/static/author_confirm.png' v-if="user.author_info">
		                    </Col>
		                    <Col :xs="24" :sm="24" :lg="24">
		                    	<label class="user-desc">{{user.desc}}</label>
		                    </Col>
		                </Row>
	            	</a>
	            </Col>
	        </Col>
	    	<Col :xs="24" :sm="24" :lg="24" :class-name="'author-brief'">
	            <div class="author-brief-inner">简介：{{user.brief}}</div>
	        </Col>
	    </Col>
	</Row>
</div>
</template>
<script>
export default {
    props:['user'],
    methods:{
    	go(path){
    		this.$router.push(path)
    	}
    }
}
</script>	
<style lang="scss" scoped>
	* {
		box-sizing: border-box;
	}
	html,body {
		font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
	}

#user-pannel{
	margin-bottom: 50px;
	.author{
	    text-align: left;
	    border: 1px solid #efefef;
		padding: 15px;
	    height: 100%;
	    .author-avatar {
			.avatar-frame-new {
				width: 100%;
				height: 100%;
				border-radius: 50%;
				overflow: hidden;
				text-align: center;
				border:1px solid #e0e0e0;
				img {
					cursor: pointer;
					border-radius: 50%;
					width: 100%;
					height: 100%;
					background: #ccc;
				}
			}
	    }
	    .author-info {
	    	padding-top: 10px;
	    	padding-left: 10px;
	    	display: relative;
	    	img{
	    		position: absolute;
	    		top:5px;
	    		margin-left: 10px;
	    	}
	        .author-name {
				font-size: 20px;
				font-weight: bold;
	            color: #444;
				margin-left: 20px;
				max-width: 150px;
				overflow: hidden;
				display: inline-block;
	        }
	        .user-desc{
	        	margin-left: 20px;
	        }
	        .author-publish {
	            font-weight: bold;
	            border: 0 0 2px 0 solid #000;
	            padding: 0 2px 0 2px;
	        }
	        .author-attention {
	        	width: 100%;
			    height: 34px;
			    font-size: 14px;
			    font-weight: bold;
			    cursor: pointer;
			    background-color: #fff;
			    border-radius: 17px;
			    &:hover{
			        border-color: #28b28a;
			        color: #28b28a;
			    }
	        }
	    }
	    .author-brief {
	        margin-top: 15px;
	        overflow : hidden;
	        .author-brief-inner {
	            font-size: 12px;
	            color: #888;
	            line-height: 2;
				text-align: justify;
	        }
	    }
	}	
}

</style>