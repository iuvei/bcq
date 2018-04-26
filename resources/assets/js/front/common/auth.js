export default{
	is_login:(vue,func1,func2)=>{//func1是指状态为登录时的回调，func2是指未登录时的回调
		vue.https.get('/common/is_login').then((r)=>{
			if (r.data.code) {
				func1(vue,r.data.user_info);
			}else{
				func2(vue);
			}	
		}).catch((e)=>{
			console.log(e);
		});
	}
}