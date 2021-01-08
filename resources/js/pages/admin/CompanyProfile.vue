<style>
.emp-profile{
    padding: 3%;
    margin-top: 3%;
    margin-bottom: 3%;
    border-radius: 0.5rem;
    background: #fff;
}
.profile-img{
    text-align: center;
}
.profile-img img{
    width: 70%;
    height: 100%;
}
.profile-img .file {
    position: relative;
    overflow: hidden;
    margin-top: -20%;
    width: 70%;
    border: none;
    border-radius: 0;
    font-size: 15px;
    background: #212529b8;
}
.profile-img .file input {
    position: absolute;
    opacity: 0;
    right: 0;
    top: 0;
}
.profile-head h5{
    color: #333;
}
.profile-head h6{
    color: #0062cc;
}
.profile-edit-btn{
    border: none;
    border-radius: 1.5rem;
    width: 70%;
    padding: 2%;
    font-weight: 600;
    color: #6c757d;
    cursor: pointer;
}
.proile-rating{
    font-size: 12px;
    color: #818182;
    margin-top: 5%;
}
.proile-rating span{
    color: #495057;
    font-size: 15px;
    font-weight: 600;
}
.profile-head .nav-tabs{
    margin-bottom:5%;
}
.profile-head .nav-tabs .nav-link{
    font-weight:600;
    border: none;
}
.profile-head .nav-tabs .nav-link.active{
    border: none;
    border-bottom:2px solid #0062cc;
}
.profile-work{
    padding: 14%;
    margin-top: -15%;
}
.profile-work p{
    font-size: 12px;
    color: #818182;
    font-weight: 600;
    margin-top: 10%;
}
.profile-work a{
    text-decoration: none;
    color: #495057;
    font-weight: 600;
    font-size: 14px;
}
.profile-work ul{
    list-style: none;
}
.profile-tab label{
    font-weight: 600;
}
.profile-tab p{
    font-weight: 600;
    color: #0062cc;
}
</style>
<template>
    
    <div class="right_col" role="main" style="min-height: 990px;">
        <div class="container emp-profile">
            <form method="post">
                <div class="row">
                    <div class="col-md-4">
                        <div class="profile-img">
                            <img :src="profile_picture" alt="" style="max-height:250px"/>
                            <div class="file btn btn-lg btn-primary">
                                Company Profile Image
                                <input type="file" name="file"/>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="profile-head">
                                    <h5>
                                       {{auth.user.company_name}}
                                    </h5>
                                    <p class="proile-rating"> <span></span></p>
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">About</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-2">
                 
                <input type="submit" v-on:click="()=>this.$router.push({name:'admin.profile'})" class="profile-edit-btn" name="btnAddMore" value="Edit Profile">
                   
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                    <!--
                        <div class="profile-work">
                            <p>WORK LINK</p>
                            <a href="">Website Link</a><br/>
                            <a href="">Bootsnipp Profile</a><br/>
                            <a href="">Bootply Profile</a>
                            <p>SKILLS</p>
                            <a href="">Web Designer</a><br/>
                            <a href="">Web Developer</a><br/>
                            <a href="">WordPress</a><br/>
                            <a href="">WooCommerce</a><br/>
                            <a href="">PHP, .Net</a><br/>
                        </div> -->
                    </div>
                    <div class="col-md-8">
                        <div class="tab-content profile-tab" id="myTabContent">
                            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Name</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{auth.user.first_name}} {{ auth.user.last_name }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{auth.user.email}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Phone</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{auth.user.contact_number}}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Address</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{auth.user.address}}</p>
                                            </div>
                                        </div>
                            </div>
                            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Sent Messages</label>
                                            </div>
                                            <div class="col-md-6">
                                                <p>{{ frommessageCount }}</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <label>Total Received Messages</label>
                                            </div>
                                            <div class="col-md-6">
                                                    <p>{{ receivemessageCount }}</p>
                                            </div>
                                        </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>           
        </div>
    </div>

</template>

<script>
    import {mapState} from 'vuex';
    import {updateProfile, authApiConfig} from "../../helpers/helpers";

    export default {
        name: 'CompanyProfile',
        props:{
            asset:String
        },
        data:function(){
            return{
                formData: {
                    password: '',
                    profile_picture:''
                },
                profile_picture:'',
                frommessageCount: '',
                receivemessageCount: '',
                errors:[]
            }
        },
        created() {
            this.profile_picture=this.auth.user.profile_picture? this.asset+''+this.auth.user.profile_picture: this.asset+'assets/admin/images/img.png';
            this.fetchMessages();
        },
        computed:{
            ...mapState({
                auth:state=>state.auth
            })
        },
        methods:{
            printState:function (e) {
                e.preventDefault();
                this.formData={...this.auth.user,...this.formData};
                updateProfile(this.formData,authApiConfig(this.auth.token))
                .then((response)=>{
                    this.errors=[];
                    this.auth.user.profile_picture=response[1];
                    localStorage.removeItem('authToken');
                    localStorage.setItem('authToken',JSON.stringify(this.auth));
                    swal('Great!',response[0],"success");
                }).catch((error)=>{
                    swal('Stop!',"Some errors to correct.","error");
                    if(typeof error === "object"){
                        if(error.email){this.errors.push(error.email[0]);}
                        if(error.password){this.errors.push(error.password[0]);}
                    }else {
                        this.errors.push(error);
                    }
                })
            },

            fetchMessages:function (){
                var authId=this.auth.user.id;
                axios.get(`/company_profile/${authId}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.frommessageCount = res.from;
                        this.receivemessageCount = res.to;
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
            profile_image:function(e){
                var image=e.target.files[0];
                var reader = new FileReader();
                reader.onload=(e)=>{
                    this.profile_picture=e.target.result;
                    this.formData.profile_picture=e.target.result;
                };
                reader.readAsDataURL(image);
            }
        },
    }
</script>
