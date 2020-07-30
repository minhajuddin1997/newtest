<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-banner o-hidden black-bg p-0" style="min-height: 1009px">
        <div class="banner-bgLogin" :data-bg-img="asset+'assets/front/images/bg/04.jpg'"></div>
        <div class="align-center b-pl">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5">
                        <h1 class="head-2">Welcome</h1>
                        <p class="text-light pra-2">Please Enter details to login your account</p>

                        <form class="ls-form" @submit="loginCheck">
                            <div class="form-group">
                                <input type="email" class="form-control" v-model="email" required placeholder="Email">
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control" v-model="password" required placeholder="Password">
                            </div>
                            <span>
                                <p class="text-danger" v-if="errors" v-for="error in errors" v-text="error"></p>
                            </span>
                            <button class="btn btnSend" type="submit">Login</button>
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
    import {login} from '../helpers/helpers'
    export default {
        name:'Login',
        props:{
            asset:String
        },
        created() {
            setTimeout(function () {
                var backImg = $(".banner-bgLogin").attr("data-bg-img");
                $(".banner-bgLogin").css('background-image', 'url(' + backImg + ')');
            },1);
        },
        data:function(){
          return{
              email:'',
              password:'',
              errors:''
          }
        },
        methods:{
            loginCheck:function (e) {
                e.preventDefault();
                if(this.email && this.password) {
                    this.errors=[];
                    login(this.email, this.password)
                    .then((response)=>{
                        var authToken=JSON.stringify({token:response[0],expire:response[1],user:response[2]});
                        localStorage.setItem('authToken',authToken);
                        this.$store.commit('auth',{status:true, auth:JSON.parse(authToken)});
                        //this.$router.push('/admin')
                        window.location.href=this.asset+'admin';
                    })
                    .catch((error)=>{
                        if(typeof error === "object"){
                            if(error.email){this.errors.push(error.email[0]);}
                            if(error.password){this.errors.push(error.password[0]);}
                        }else {
                            this.errors.push(error);
                        }
                    })
                }
            }
        }
    }
</script>
