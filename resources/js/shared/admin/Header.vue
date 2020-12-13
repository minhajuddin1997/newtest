
<template>
    <main>
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a class="site_title"><img :src="asset+'assets/front/images/logo.png'" class="img-fluid pl-5 pr-5"></a>
                    </div>
                    <div class="clearfix"></div>

                    <div class="profile clearfix">
                        <div class="profile_pic">
                            <img :src="profileImage" alt="..." class="img-circle profile_img">
                        </div>
                        <div class="profile_info">
                            <span>Welcome,</span>
                            <h2 v-text="auth.user.first_name+' '+auth.user.last_name"></h2>
                        </div>
                    </div>

                    <br>

                    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                        <div class="menu_section">
<!--                            <h3>General</h3>-->
                            <ul class="nav side-menu">

                                <li><a  v-on:click="()=>this.$router.push({name:'admin'})" ><i class="fa fa-dashboard"></i> Dashboard </a></li>

                                <li v-if="permissions('viewUser')"><a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li v-if="permissions('viewVendors')" v-on:click="()=>this.$router.push({name:'admin.vendors'})"><a>Vendors</a></li>
                                    </ul>
                                </li>
                                <li v-if="permissions('viewCategory')"><a><i class="fa fa-edit"></i> Category <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li><a v-on:click="()=>this.$router.push({name:'admin.categories'})" >Add Category</a></li>
                                    </ul>
                                </li>


<!--                                <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>-->
<!--                                    <ul class="nav child_menu">-->
<!--                                        <li><a >Fixed Sidebar</a></li>-->
<!--                                        <li><a >Fixed Footer</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->

                                    <li v-if="permissions('viewService')"><a><i class="fa fa-laptop"></i> Services & Products <span class="fa fa-chevron-down"></span></a>
                                        <ul class="nav child_menu">
                                            <li><a v-on:click="()=>this.$router.push({name:'admin.services'})">Services & Products</a></li>
                                            <li><a disabled="disabled" v-on:click="()=>this.$router.push({name:'admin.on_going_work'})">On Going Work</a></li>
                                        </ul>
                                    </li>

                                    <li v-if="permissions('viewConnection')"><a v-on:click="()=>this.$router.push({name:'admin.connections'})"><i class="fa fa-users"></i> Connections </a></li>

                                    <li v-if="permissions('viewMessage')"><a v-on:click="()=>this.$router.push({name:'admin.messages'})"><i class="fa fa-envelope-open"></i> Messages </a></li>

                                    <li v-if="permissions('viewRequest')"><a v-on:click="()=>this.$router.push({name:'admin.requests'})"><i class="fa fa-book"></i> Requests <span v-show="request_notifications" id="requests_counter" class="badge badge-info">{{request_notifications}}</span></a></li>

                                    <li v-if="permissions('viewHistory')"><a v-on:click="()=>this.$router.push({name:'admin.works_history'})"><i class="fa fa-history"></i> Work History </a></li>

                                    <li v-if="permissions('viewPayment')"><a v-on:click="()=>this.$router.push({name:'admin.payments_history'})"><i class="fa fa-dollar"></i> Payments </a></li>


                                    <!--                                <li><a><i class="fa fa-windows"></i> Extras <span class="fa fa-chevron-down"></span></a>-->
                                    <!--                                    <ul class="nav child_menu">-->
                                    <!--                                        <li><a>403 Error</a></li>-->
                                    <!--                                        <li><a >404 Error</a></li>-->
                                    <!--                                        <li><a >500 Error</a></li>-->
                                    <!--                                        <li><a >Plain Page</a></li>-->
                                    <!--                                        <li><a >Login Page</a></li>-->
                                    <!--                                        <li><a >Pricing Tables</a></li>-->
                                    <!--                                    </ul>-->
                                    <!--                                </li>-->
                            </ul>

                        </div>
                    </div>


                    <div class="sidebar-footer hidden-small">
                        <li type="button" style="width:100%; height:50px" v-on:click="logout">
                            <h6 class="text-center text-dark font-weight-bold" style=" line-height:50px;">LOGOUT</h6>
                        </li>
                    </div>

                </div>
            </div>

            <div class="top_nav">
                <div class="nav_menu">
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                    <nav class="nav navbar-nav">
                        <ul class=" navbar-right">
                            <li class="nav-item dropdown open" style="padding-left: 15px;">
                                <a href="javascript:;" class="user-profile dropdown-toggle" aria-haspopup="true" id="navbarDropdown" data-toggle="dropdown" aria-expanded="false">
                                    <img :src="profileImage" alt="">{{auth.user.first_name+' '+auth.user.last_name}}
                                </a>
                                <div class="dropdown-menu dropdown-usermenu pull-right" aria-labelledby="navbarDropdown" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(15px, 21px, 0px);">
                                    <a class="dropdown-item" v-on:click="()=>this.$router.push({name:'admin.profile'})"> Profile</a>
                                    <a class="dropdown-item" v-on:click="logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

    </main>

</template>

<script>
    import {mapState, mapActions} from 'vuex';
    import {prefixPath, redirectedPaths} from "../../helpers/helpers";
    // import axios from 'axios';
    import {authApiConfig} from "../../helpers/helpers";
    import {fetchAuthUser} from "../../helpers/api/profile";

    export default {
        name:'AdminHeader',
        props:{
            asset:String
        },
        computed:{
            ...mapState({
                authCheck: state=>state.authCheck,
                auth: state=>state.auth
            }),
            profileImage:function(){
                return this.auth.user.profile_picture? this.asset+''+this.auth.user.profile_picture: this.asset+'assets/admin/images/img.png';
            },
        },
        created() {
            var auth=JSON.parse(localStorage.getItem('authToken'));
            if(auth){
                var authToken=auth.token;
                var expire=new Date(auth.expire);
                var now=new Date();
            }
            if(authToken!='' && (expire>now)){
                fetchAuthUser(auth.user.id,authApiConfig(authToken))
                .then((response)=>{
                        auth.user=response;
                        localStorage.setItem('authToken',JSON.stringify(auth));
                    })
                .catch((error)=>{
                        console.log(error);
                    });
                this.$store.commit('auth',{status:true, auth:auth});
            }
            else{
                localStorage.removeItem('authToken');
                this.$store.commit('auth',{status:false, auth:{}});
            }
            this.fetchRequests();
        },
        mounted(){
          var pusher=new Pusher('13dc91256b26300c36f3',{
              cluster:'ap2'
          });
          var channel=pusher.subscribe(`exchange_requests_notification.${this.auth.user.id}`);
          var self=this;
          channel.bind("exchange.requested",function (data) {
                self.requests=data.original;
                self.setReceiveRequests(self.requests);
                self.request_notifications=self.requests.filter((request)=>request.status===0).length;
          });
        },
        data:function(){
          return{
              requests:[],
              request_notifications:0,
          }
        },
        methods:{
            ...mapActions({
                sendLogout:'logout',
                setReceiveRequests:'setReceiveRequests'
            }),
            logout:function(){
                this.sendLogout(this.auth.user.email).then(()=>window.location.href=redirectedPaths('/',prefixPath));
            },
            permissions:function(permission){
                var perm=this.auth.user.permissions;
                if(perm.indexOf(permission)>-1){
                    return true;
                }
                return false;
            },
            fetchRequests:function (){
                axios.get(`/exchange/requests/${this.auth.user.id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    res.forEach((item)=>{
                        this.requests.push(item);
                    });
                    this.setReceiveRequests(res);
                    this.request_notifications=this.requests.filter((request)=>request.status===0).length;
                }).catch((error)=>{
                    console.log(error.response);
                });
            }
        }
    }
</script>
