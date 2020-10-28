<template>
    <Base :work_service_id="work_service_id">
        <template v-slot:details-header>
            <div class="row service-details-header">
                <!-- File Uploading Modal -->
                <FileModal id="uploadFile" title="Upload Files">
                    <template v-slot:body>
                        <div class="container upload-file-section">
                            <div class="col-12">
                                <p>{{fileTitle}}</p>
                                <p v-show="fileSize!==0">{{"("+fileSize+")"}}</p>
                                <input type="file" name="file-input" id="file-input" style="display: none" v-on:change="uploadedFile" />
                                <button class="btn accepted-btn pt-1 pb-1" v-on:click="addFile">Add File</button>
                                <p class="text-danger mt-2" v-if="errors.file.length" v-for="error in errors.file">{{error}}</p>
                            </div>
                        </div>
                    </template>
                    <template v-slot:footer>
                        <div class="upload-file-footer">
                            <h4>Description</h4>
                            <form>
                                <textarea class="form-control p-0 border-0"  v-model="description" ></textarea>
                            </form>
                            <article></article>
                            <p class="text-danger font-weight-bold" v-if="errors.description.length" v-for="error in errors.description">{{error}}</p>
                            <button class="btn pending-btn upload-btn" v-on:click="saveFile">Upload The File</button>
                            <button class="btn btn-delet" data-dismiss="modal">Cancel</button>
                        </div>
                    </template>
                </FileModal>
                <!-- File Uploading Modal -->
                <div class="col-lg-5 col-md-5 p-0">
                    <h2 class="service-header-heading">{{service.title}}</h2>
                </div>
                <div class="offset-lg-2 col-lg-5 offset-md-1 col-md-6 service-header-button p-0">
                    <button class="btn pending-btn task-button" data-target="#uploadFile" data-toggle="modal">Upload Files</button>
                    <button class="btn accepted-btn msg-button" v-on:click="goToMessage()">Send Message</button>
                </div>
            </div>
        </template>

        <template v-slot:details-body>
            <div class="row col-10 service-details-tasks-container" v-for="(fileData, date) in files">
                <h5 class="service-details-tasks-date" >{{date}}</h5>
                <ul class="service-details-file-section col-12 p-0">
                    <li v-if="fileData.length" v-for="file in fileData" class="row service-details-file">
                        <div class="col-lg-6 col-md-12">
                            <img :src="asset+detectFileIcon(file.file_path)"/>
                            <div class="file-content">
                                <p class="file-title">{{file.title}}</p>
                                <p class="file-reference">by {{file.company_name}}. <span class="file-upload-days">{{daysUploaded(file.created_at)}}</span> <span class="file-upload-size">- {{calculateSize(file.file_size)}}</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <div class="file-buttons">
                                <a :href="asset+file.file_path" class="btn accepted-btn">Download</a>
                                <button type="button" class="btn " v-on:click="deleteFile(file.id)">
                                    <i class="fa fa-close mr-2"></i> Delete
                                </button>
                            </div>
                        </div>
                    </li>

                </ul>
            </div>
            <h6 v-if="Object.keys(files).length===0">No Files</h6>
        </template>
    </Base>
</template>

<script>
    import {mapState} from 'vuex';
    import DetailsBase from "./DetailsBase";
    import Modal from "../../shared/Modal";
    import {authApiConfig} from "../../../../helpers/helpers";
    export default{
        name:'work-details',
        props:{
            asset:String
        },
        components:{
            Base:DetailsBase,
            FileModal:Modal
        },
        computed:{
            ...mapState({
                auth:(state)=>state.auth
            }),
            work_service_id: function(){return this.$route.params.id;}
        },
        created() {
            this.fetchServiceFiles();
        },
        data:function () {
            return{
                service:{},
                files:[],
                file:undefined,
                originalFile:{},
                errors:{
                    file:[],
                    description:[]
                },
                fileTitle:"Upload File Here",
                fileSize:0,
                description:undefined
            }
        },
        methods:{
            fetchServiceFiles:function(){
                axios.get(`/detail-service/files/${this.work_service_id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((data)=>{
                    this.service = data.service[0];
                    this.files = data.files;
                });
            },
            goToMessage:function () {
                this.$router.push({name:'admin.messages'});
            },
            detectFileIcon:function (image_path) {
                var extension = image_path.split(".")[1];
                var iconBase = "assets/admin/uploads/services/icons/";
                switch (extension) {
                    case 'pdf':
                        return iconBase+"pdf.png";
                    case 'docx':
                    case 'doc':
                        return iconBase+"word.png";
                    case 'xls':
                    case 'xlsx':
                        return iconBase+"excel.png";
                    case 'mp3':
                    case 'ogg':
                    case 'wav':
                        return iconBase+"audio.png";
                    case 'mp4':
                    case 'mov':
                    case 'mkv':
                        return iconBase+"video.png";
                    case 'zip':
                    case '7z':
                    case 'rar':
                        return iconBase+"zip.png";
                    case 'jpg':
                    case 'jpeg':
                    case 'gif':
                    case 'png':
                        return image_path;
                    case "html":
                    case "htm":
                        return iconBase+"html.png";
                    case "ppt":
                        return iconBase+"ppt.png";
                    case "txt":
                        return iconBase+"text.png";
                    default:
                        return iconBase+"unknown.png";
                }
            },
            addFile:function () {
                document.getElementById("file-input").click();
            },
            uploadedFile:function (e) {
               var picture = e.target.files[0];
               this.fileTitle=picture.name;
               this.originalFile=picture;
               this.fileSize=this.calculateSize(this.originalFile.size);
               var reader= new FileReader();
               var self=this;
               reader.onload=function(e) {
                   self.file=e.target.result;
               };
               reader.readAsDataURL(picture);
            },
            saveFile:function (){
                if(this.file===undefined){
                    this.errors.file.push("Please Select a File.");
                }
                else{this.errors.file=[]}
                if(this.originalFile.size > 20971520){
                    this.errors.file.push("Limit size exceeds, File must be of 20 MB or less.");
                }
                else{this.errors.file=[]}
                if(this.description===undefined){
                    this.errors.description.push("Please Enter Brief Title For File.");
                }
                else{this.errors.description=[]}
                if(this.errors.file.length || this.errors.description.length){
                    return;
                }else{
                    var formData = new FormData();
                    formData.append("file", this.originalFile);
                    formData.append("size",this.originalFile.size);
                    formData.append("title",this.description);
                    formData.append("user_id", this.auth.user.id);
                    // var data={
                    //     file:this.file,
                    //     size:this.originalFile.size,
                    //     title:this.description,
                    //     user_id:this.auth.user.id
                    // };
                    axios.post(`/detail-service/files/${this.work_service_id}`,formData,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        swal("Success",res,"success");
                        $("#uploadFile").modal("hide");
                        this.description="";
                        this.file="";
                        this.originalFile={};
                        this.fileSize=0;
                        this.fileTitle="Upload File Here";
                        this.fetchServiceFiles();
                    }).catch((error)=>{
                        console.log(error.response);
                    });
                }
            },
            deleteFile:function(id) {
                axios.delete(`/detail-service/files/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    swal("Success",res,"success");
                    this.fetchServiceFiles();
                });
            },
            calculateSize: function (size) {
                var annotations = ["B","KB","MB","GB"];
                var size=size; var index=0;
                for(var i=1; i<4; i++){
                    if(size>=1024) {
                        size = (size / 1024);
                        index = i;
                    }
                }
                size=size.toFixed(2)+" "+annotations[index];
                return size;
            },
            daysUploaded: function(date){
                var today=new Date();
                var dayUploaded=new Date(date);
                var difference=today.getDate()-dayUploaded.getDate();
                switch(difference){
                    case 0:
                        return "Today";
                    case 1:
                        return "Yesterday";
                    default:
                        return difference+" days ago";
                }
            }
        }
    }
</script>
