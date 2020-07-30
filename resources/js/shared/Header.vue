<template>
    <!--header start-->
    <header id="site-header" class="header">
        <div id="header-wrap">
            <div class="container-fluid pl-lg-0 pr-lg-5">
                <div class="row">
                    <div class="col-lg-12">
                        <!-- Navbar -->
                        <nav class="navbar navbar-expand-lg">
                            <a class="navbar-brand logo mr-5" v-on:click="()=>this.$router.push('/')">
                                <img class="img-fluid" :src="asset+'assets/front/images/logo.png'" alt="">
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation"> <span></span>
                                <span></span>
                                <span></span>
                            </button>
                            <div class="collapse navbar-collapse">

                            </div>
                            <div class="right-nav align-items-center d-flex justify-content-end">
                                <div>
                                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                                        <ul class="navbar-nav mr-auto">
                                            <li class="nav-item"> <a class="nav-link active" v-on:click="()=>this.$router.push('/')">Home</a></li>
                                            <li class="nav-item"> <a class="nav-link" v-on:click="()=>this.$router.push('/how-it-works')">How it Works</a></li>
                                            <li class="nav-item"> <a class="nav-link" v-on:click="()=>this.$router.push('/about')">About Us</a></li>
                                            <li class="nav-item"> <a class="nav-link" v-on:click="()=>this.$router.push('/contact-us')">Contact Us</a></li>
                                        </ul>
                                        <!--                   Not Login                     -->
                                        <a class="btn btn-sm btn-outline-light rounded text-white" v-if="!authCheck" v-on:click="()=>this.$router.push('/login')">Login</a>
                                        <a class="btn btn-sm btn-outline-light rounded btn-sm-green text-white" v-if="!authCheck" v-on:click="()=>this.$router.push('/register')">Free Sign Up</a>
                                        <!--                   Login                     -->
                                        <a class="btn btn-sm btn-outline-light rounded text-white" v-if="authCheck" v-on:click="logout">Logout</a>
                                        <a class="btn btn-sm btn-outline-light rounded btn-sm-green text-white" v-if="authCheck" v-on:click="dashboard">Go to Dashboard <i class="fa fa-arrow-right"></i></a>

                                    </div>
                                </div>

                            </div>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!--header end-->
</template>
<script>
    import {mapState, mapActions} from 'vuex';
    export default {
        name:'Header',
        props:{
            asset:String,
        },
        computed:{
           ...mapState({
             authCheck: state=>state.authCheck,
             auth: state=>state.auth
           })
        },
        created() {
            const auth=JSON.parse(localStorage.getItem('authToken'));
            if(auth){
                var authToken=auth.token;
                var expire=new Date(auth.expire);
                var now=new Date();
            }
            if(authToken!='' && (expire>now)){
                this.$store.commit('auth',{status:true, auth:auth});
            }
            else{
                this.$store.commit('auth',{status:false, auth:{}});
            }
        },
        methods:{
            ...mapActions({
                sendLogout:'logout'
            }),
            logout:function(){
                    this.sendLogout(this.auth.user.email).then(()=>this.$router.push({name:'home'}));
            },
            dashboard:function () {
                window.location.href='/admin';
            }
        }
    }
</script>
