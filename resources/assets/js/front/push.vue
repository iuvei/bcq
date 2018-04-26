<template>
	<div>
		{{push}}
	</div>
</template>
<script>
import io from 'socket.io-client'
export default{
	mounted(){
		var v = this
		var url = '127.0.0.1:3001'
		var socket = io(url)
		v.socket = socket
		v.socket.on('push',function(push_info){
			console.log(push_info)
        	v.push = push_info
        })
	},
	data(){
		return {
			push:'',
			socket:{},
		}
	}
}
</script>