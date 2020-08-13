
<template>
    <main>
            <div class="col-md-3 left_col">
                <div class="left_col scroll-view">
                    <div class="navbar nav_title" style="border: 0;">
                        <a class="site_title"><i class="fa fa-paw"></i> <span>Swoppers</span></a>
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
                            <h3>General</h3>
                            <ul class="nav side-menu">
                                <li v-if="permissions('viewUser')"><a><i class="fa fa-user"></i> Users <span class="fa fa-chevron-down"></span></a>
                                    <ul class="nav child_menu">
                                        <li v-if="permissions('viewVendors')" v-on:click="()=>this.$router.push({name:'admin.vendors'})"><a>Vendors</a></li>
                                    </ul>
                                </li>
<!--                                <li><a><i class="fa fa-edit"></i> Forms <span class="fa fa-chevron-down"></span></a>-->
<!--                                    <ul class="nav child_menu">-->
<!--                                        <li><a >General Form</a></li>-->
<!--                                        <li><a >Advanced Components</a></li>-->
<!--                                        <li><a >Form Validation</a></li>-->
<!--                                        <li><a >Form Wizard</a></li>-->
<!--                                        <li><a >Form Upload</a></li>-->
<!--                                        <li><a >Form Buttons</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->


<!--                                <li><a><i class="fa fa-clone"></i>Layouts <span class="fa fa-chevron-down"></span></a>-->
<!--                                    <ul class="nav child_menu">-->
<!--                                        <li><a >Fixed Sidebar</a></li>-->
<!--                                        <li><a >Fixed Footer</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->
                            </ul>
                        </div>
<!--                        <div class="menu_section">-->
<!--                            <h3>Live On</h3>-->
<!--                            <ul class="nav side-menu">-->
<!--                                <li><a><i class="fa fa-bug"></i> Additional Pages <span class="fa fa-chevron-down"></span></a>-->
<!--                                    <ul class="nav child_menu">-->
<!--                                        <li><a >E-commerce</a></li>-->
<!--                                        <li><a >Projects</a></li>-->
<!--                                        <li><a >Project Detail</a></li>-->
<!--                                        <li><a >Contacts</a></li>-->
<!--                                        <li><a >Profile</a></li>-->
<!--                                    </ul>-->
<!--                                </li>-->
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
<!--                               </ul>-->
<!--                        </div>-->
                    </div>


                    <div class="sidebar-footer hidden-small">
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Settings">
                            <span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
                        </a>
                        <a data-toggle="tooltip" data-placement="top" title="" data-original-title="Logout" v-on:click="logout">
                            <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
                        </a>
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
            }
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
                this.sendLogout(this.auth.user.email).then(()=>window.location.href=redirectedPaths('/',prefixPath));
            },
            permissions:function(permission){
                var perm=this.auth.user.permissions;
                if(perm.indexOf(permission)>-1){
                    return true;
                }
                return false;
            }
        }
    }
</script>
