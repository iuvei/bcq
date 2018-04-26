<template>
    <div id="app">
        <router-view>
        </router-view>
    </div>
</template>
<script>
export default{
    mounted(){
		this.$Message.config({
		    duration: 3
		});
    }		
}
</script>
<style lang="scss" scoped>
    #app{
        min-width: 1200px;
        font-family: "PingFang SC","Helvetica Neue",Helvetica,"Hiragino Sans GB","Microsoft YaHei","微软雅黑",Arial,sans-serif;
    }
</style>