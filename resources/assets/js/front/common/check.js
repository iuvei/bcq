export default{
	phone_check(phone,v){
        if (phone.length<8) {
            v.$Message.error('请输入正确手机号！')
            return false
        }else if (!/^[0-9]*$/.test(phone)) {
            v.$Message.error('手机号非法！')
            return false       
        }
        return true
	},
	psd_check(psd,v){
        if(!/^\w{6,18}$/.test(psd)){    
            v.$Message.error('密码由6-18个数字以及字符组成！')
            return false
        }else if(!psd.match(/\d{1,18}/)||!psd.match(/[a-zA-Z]{1,18}/)){
            v.$Message.error('密码必须包含数字以及字母组成！')
            return false
        }
        return true
	},
	email_check(email,v){
		if (!/^[\w+\-\+\.\w+]*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/.test(email)) {
			v.$Message.error('请输入合法邮箱！')
            return false  
		} 
		return true
	},
	qq_check(qq,v){
        if (!/^[0-9]{4,25}$/.test(qq)) {
            v.$Message.error('请输入合法qq号')
            return false       
        }
        return true
	},
	wechat_check(wechat,v){
	    if (!(wechat.length>2&&wechat.length<25)) {
	        v.$Message.error('请输入合法微信号')
	        return false
	    }
	    return true
	},
	skype_check(skype,v){
	    if (!(skype.length>4&&skype.length<30)) {
	        v.$Message.error('请输入合法skype账号')
	        return false
	    }
	    return true
	},
	name_check(name,v){
        if (!(name.length>=2&&name.length<11)) {
            v.$Message.error('用户名要求在2-10个字符之间')
            return false
        }
        if (/^[0-9]*$/.test(name)) {
            v.$Message.error('用户名不能为全数字')
            return false
        }
        return true
	},
	job_check(name,v){
        if (name.length>20) {
            v.$Message.error('请输入合法工作名称')
            return false
        }
        return true
	},
	city_check(name,v){
        if (name.length>20) {
            v.$Message.error('请输入合法城市名')
            return false
        }
        return true
	},
    comment_check(content,v){
        if (content.length>150) {
            v.$Message.error('评论字数过长，请保持在150个字符之内')
            return false
        }
        return true        
    },
    desc_check(desc,v){
        if (desc.length>10) {
            v.$Message.error('个人标签不得大于10个字')
            return false
        }
            return true   
        }
}