<template>

    <div class="right_col" role="main" style="min-height: 990px;">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Edit Profile</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Your <small>Profile</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a>
                                </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">



                            <form class="form-horizontal form-label-left" v-on:submit="printState">
                               <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="first_name">First Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="first_name" class="form-control" name="first_name" v-model="auth.user.first_name" data-validate-length-range="6" data-validate-words="2" placeholder="First Name" required="required" autocomplete="name" autofocus="" type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="last_name">Last Name <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="last_name" class="form-control " name="last_name" v-model="auth.user.last_name"  placeholder="Last Name" required="required"  type="text">
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="email">E-Mail Address <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="email" id="email" class="form-control" v-model="auth.user.email" name="email"  required="required" >
                                    </div>
                                </div>
                                <div class="item form-group" v-if="auth.user.role_id==2">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="contact_number">Contact Number <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6">
                                        <input type="text" id="contact_number" name="contact_number" v-model="auth.user.contact_number" required="required"  class="form-control ">
                                    </div>
                                </div>

                                <div class="item form-group" v-if="auth.user.role_id==2">
                                    <label for="company_name" class="col-form-label col-md-3 label-align">Company Name</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="company_name" type="text" name="company_name" v-model="auth.user.company_name" class="form-control " required="required" autocomplete="company_name">
                                    </div>
                                </div>


                                <div class="item form-group " v-if="auth.user.role_id==2">
                                    <label for="description" class="col-form-label col-md-3 label-align">Company Description</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="description"  name="description" v-model="auth.user.description"  class="form-control" required="required">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="item form-group " v-if="auth.user.role_id==2">
                                    <label for="privacy_policy" class="col-form-label col-md-3 label-align">Privacy Policy</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="privacy_policy" rows="3"  name="privacy_policy" v-model="auth.user.privacy_policy"  class="form-control" required="required">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="item form-group " v-if="auth.user.role_id==2">
                                    <label for="how_to_use" class="col-form-label col-md-3 label-align">How To Use</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="how_to_use" rows="3"  name="how_to_use" v-model="auth.user.how_to_use"  class="form-control" required="required">
                                        </textarea>
                                    </div>
                                </div>



                                <div class="item form-group" v-if="auth.user.role_id==2">
                                    <label for="address" class="col-form-label col-md-3 label-align">Address</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="address" rows="2" name="address" v-model="auth.user.address"  class="form-control" >
                                        </textarea>
                                    </div>

                                </div>



                                <div class="item form-group " v-if="auth.user.role_id==2">
                                    <label for="website" class="col-form-label col-md-3 label-align">Website</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="website" type="text" name="website" v-model="auth.user.website" class="form-control " required="required" autocomplete="website">
                                    </div>
                                </div>




                                <div class="item form-group ">
                                    <label for="password" class="col-form-label col-md-3 label-align">Password</label>
                                    <div class="col-md-6 col-sm-6">
                                        <input id="password" type="password" v-model="formData.password" name="password" class="form-control" >
                                    </div>
                                </div>

                                <div class="item form-group " v-if="auth.user.role_id==2">
                                    <label for="terms_and_conditions" class="col-form-label col-md-3 label-align">Terms & Conditions</label>
                                    <div class="col-md-6 col-sm-6">
                                        <textarea id="terms_and_conditions" rows="3"  name="terms_and_conditions" v-model="auth.user.terms_and_conditions" class="form-control" required="required">
                                        </textarea>
                                    </div>
                                </div>

                                <div class="item form-group">
                                    <label class="col-form-label col-md-3 col-sm-3 label-align" for="profile_picture">Profile Picture <span class="required">*</span>
                                    </label>
                                    <div class="col-md-6 col-sm-6 col-xs-12">
                                        <div class="input-group-btn">
                                            <div class="image-upload">
                                                <img :src="profile_picture" id="" class="img-responsive">
                                                <div class="file-btn">
                                                    <input type="file" id="profile_picture" name="profile_picture" v-on:change="profile_image" accept=".jpg,.png">
                                                    <label class="btn btn-info">Upload</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <span>
                                    <p class="text-danger" :style="{fontSize: '14px', fontWeight: 'bold'}" v-if="errors" v-for="error in errors" v-text="error"></p>
                                </span>

                                <div class="ln_solid"></div>
                                <div class="form-group">
                                    <div class="col-md-6">
                                        <button type="submit" class="btn btn-primary">Cancel</button>
                                        <button id="send" type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</template>

<script>
    import {mapState} from 'vuex';
    import {updateProfile, authApiConfig} from "../../helpers/helpers";

    export default {
        name: 'Profile',
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
                errors:[]
            }
        },
        created() {
            this.profile_picture=this.auth.user.profile_picture? this.asset+''+this.auth.user.profile_picture: this.asset+'assets/admin/images/img.png';
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
