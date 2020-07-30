<template>
    <div>
        <!--footer start-->

        <footer class="footer bgTwo">
            <div class="primary-footer">
                <div class="container">
                    <div class="row mb-5 align-items-center">
                        <div class="col-lg-3">
                            <a class="navbar-brand logo mr-5" v-on:click="()=>this.$router.push('/')">
                                <img class="img-fluid" :src="asset+'assets/front/images/logo.png'" alt="">
                            </a>
                        </div>
                        <div class="col-lg-6">
                            <div class="footer-list text-right-f">
                                <ul class="list-inline">
                                    <li><a v-on:click="()=>this.$router.push('/')">Home</a></li>
                                    <li><a v-on:click="()=>this.$router.push('/how-it-works')">How it Works</a></li>
                                    <li><a v-on:click="()=>this.$router.push('/about')">About Us</a></li>
                                    <li><a v-on:click="()=>this.$router.push('/contact-us')">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 text-md-right">
                            <!--                   Not Login                     -->
                            <a class="btn btn-sm btn-outline-light rounded text-white" v-if="!authCheck" v-on:click="()=>this.$router.push('/login')">Login</a>
                            <a class="btn btn-sm btn-outline-light rounded btn-sm-green text-white" v-if="!authCheck" v-on:click="()=>this.$router.push('/register')">Free Sign Up</a>
                            <!--                   Login                     -->
                            <a class="btn btn-sm btn-outline-light rounded text-white" v-if="authCheck" v-on:click="logout">Logout</a>
                            <a class="btn btn-sm btn-outline-light rounded btn-sm-green text-white" v-if="authCheck" v-on:click="dashboard">Dashboard <i class="fa fa-arrow-right"></i></a>

                        </div>
                    </div>
                    <div class="row align-items-center btp">
                        <div class="col-lg-4">
                            <h3 class="mb-4 text-white">Newsletter</h3>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <input type="text" class="form-control" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="form-group">
                                        <input type="email" class="form-control"  placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-lg-3">
                                    <div class="form-group">
                                        <button type="submit" class="btn btnSubmit">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </footer>

        <!--footer end-->
    </div>
</template>

<script>
    import {mapState, mapActions} from 'vuex';
    export default {
        name:'Footer',
        props:{
            asset:String
        },
        computed:{
            ...mapState({
                authCheck:state=>state.authCheck,
                auth:state=>state.auth
            })
        },
        methods:{
            ...mapActions({
               sendLogout:'logout'
            }),
            logout:function () {
                this.sendLogout(this.auth.user.email).then(()=>{this.$router.push({name:'home'})});
            },
            dashboard:()=>{
                window.location.href='/admin';
            }
        }
    }
</script>
