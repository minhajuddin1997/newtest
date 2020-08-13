<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-banner o-hidden black-bg p-0" style="min-height: 1009px;">
            <div class="banner-bgLogin" :data-bg-img="asset + 'assets/front/images/bg/04.jpg'"></div>
            <div class="align-center b-pl">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <h1 class="head-2">Welcome</h1>
                            <p class="text-light pra-2">Please Enter details to create your account</p>

                            <form class="ls-form" v-on:submit="register">
                                <div class="form-group">
                                    <input type="text" v-model="formData.first_name" class="form-control" placeholder="First Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="formData.last_name" class="form-control" placeholder="Last Name" required>
                                </div>
                                <div class="form-group">
                                    <input type="email" v-model="formData.email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="form-group">
                                    <input type="password" v-model="formData.password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <input type="text" v-model="formData.contact_number" class="form-control" placeholder="Contact Number">
                                </div>
                                <div class="form-group">
                                    <label class="text-white">Profile Picture</label>
                                    <input type="file" class="form-control" accept="image/x-png,image/gif,image/jpeg" v-on:change="profile_image" required>
                                </div>
                                <span>
                                    <p class="text-danger" v-if="errors" v-for="error in errors" v-text="error"></p>
                                </span>
                                <button type="submit" class="btn btnSend">Sign Up</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero section end-->
    </div>
</template>

<script>
    import {prefixPath, redirectedPaths, register} from "../helpers/helpers";

    export default {
        name:'Register',
        props:{
            asset:String
        },
        data:function(){
            return{
                formData:{
                    first_name:'',
                    last_name:'',
                    email:'',
                    password:'',
                    contact_number:'',
                    profile_picture:''
                },
                errors:[]
            }
        },
        created() {
            setTimeout(function () {
                var backImg = $(".banner-bgLogin").attr("data-bg-img");
                $(".banner-bgLogin").css('background-image', 'url(' + backImg + ')');
            },1);
        },
        methods:{
            register:function (e) {
                e.preventDefault();
                register({...this.formData})
                    .then((response)=>{
                        var authToken=JSON.stringify({token:response[0],expire:response[1],user:response[2]});
                        localStorage.setItem('authToken',authToken);
                        this.$store.commit('auth',{status:true, auth:JSON.parse(authToken)});
                        window.location.href=redirectedPaths('/admin',prefixPath);
                    })
                    .catch((error)=>{
                        if(typeof error === "object"){
                            if(error.email){this.errors.push(error.email[0]);}
                            if(error.password){this.errors.push(error.password[0]);}
                        }else {
                            this.errors.push(error);
                        }
                    })
            },

            profile_image:function(e){
                var image=e.target.files[0];
                var reader = new FileReader();
                reader.onload=(e)=>{
                    this.formData.profile_picture=e.target.result
                };
                reader.readAsDataURL(image);
            }
        }
    }
</script>
