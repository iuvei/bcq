export default{
    get_suffix(filename){
	    var type = filename.split('.');
	    var len = type.length;
	    var l = len - 1;
	    var suffix = type[l]; 
	    return suffix;
	},
	validate(suffix,accept){
		if (!accept) {
			return true;
		}else{
			for (var i = 0; i < accept.length; i++) {
				if(accept[i] == suffix){
					return true;
				}
			}
			return false;
		}
	}
}