<template>
    <div>
        <Upload
                :before-upload="handleUpload"
                action="">
            <Button type="ghost" icon="ios-cloud-upload-outline">Select the file to upload</Button>
        </Upload>
        <div v-if="file !== null">Upload file: {{ file.name }} <Button type="text" @click="upload" :loading="loadingStatus">{{ loadingStatus ? 'Uploading' : 'Click to upload' }}</Button></div>
    </div>
</template>
<script>
    export default {

        mounted(){

/*            var file_id = [5,6,7];

            var len = file_id.length;

            while ( len -- ) {
                var down_href='/common/data_download?file=' + file_id[len];
                this.download(down_href);
            }*/
        },
        data () {
            return {
                file: null,
                loadingStatus: false,
                file_name:'upload_file'
            }
        },
        methods: {
            handleUpload (file) {
                this.file = file;
                return false;
            },
            upload () {
                var v= this;
                this.loadingStatus = true;
                let formdata = new FormData();
                formdata.append('picture',this.file);
                formdata.append('type','data');
                let config = {
                    headers: {
                        'Content-Type': 'multipart/form-data',  //之前说的以表单传数据的格式来传递fromdata
                        'X-XSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                };
                this.https.post('/front/creation_page/upload_picture',formdata, config).then( (res) => {
                    console.log(res.data);
                    v.file = null;
                    v.loadingStatus = false;
                }).catch((error) =>{
                });
            },
            download(url){
                var elemIF = document.createElement("iframe");
                elemIF.src = url;
                elemIF.style.display = "none";
                document.body.appendChild(elemIF);
            }
        }
    }
</script>