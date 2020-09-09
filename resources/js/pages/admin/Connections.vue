<template>
    <main>
        <div class="right_col" role="main" style="min-height: 1068px;">
            <div class="">
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">

                        <div class="x_panel" style="background:none;">
                            <div class="x_content" style="border-radius: 50px">
                                <div class="offset-md-1 col-md-5 col-sm-12">

                                    <div class="card connection-box" style="border: none;background:none;">
                                        <div class="card-header" style="background-color: transparent; color: #000000">
                                            <h3><strong>Current Connections</strong></h3>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 v-if="!current_connections.length">No Connections</h4>
                                            <div class="row pt-3 pb-3 border connection" v-for="connection in current_connections">
                                                <div class="col-2">
                                                    <img :src="asset+connection.profile_picture" style="height: 60px; width: 60px;" class="img-fluid img-thumbnail border" />
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="text-dark font-weight-bolder">{{connection.company_name}}</h5>
                                                    <p style="width: 200px; white-space: nowrap; overflow: hidden">{{connection.description}}</p>
                                                </div>
                                                <div class="offset-2 col-4">
                                                    <button class="btn btn-info msg-btn mt-2" v-on:click="openMessage"><i class="fa fa-comment mr-2" style="font-size:19px;"></i> Message</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="col-md-5 col-sm-12">

                                    <div class="card connection-box" style="border: none;background:none;">
                                        <div class="card-header" style="background-color: transparent; color: #000000">
                                            <h3><strong>Pending Connections</strong></h3>
                                        </div>
                                        <div class="card-body p-2">
                                            <h4 v-if="!pending_connections.length">No Pending Connections</h4>
                                            <div class="row pt-3 pb-3 border connection" v-for="connection in pending_connections">
                                                <div class="col-2">
                                                    <img :src="asset+connection.profile_picture" style="height: 60px; width: 60px;" class="img-fluid img-thumbnail border" />
                                                </div>
                                                <div class="col-4">
                                                    <h5 class="text-dark font-weight-bolder">{{connection.company_name}}</h5>
                                                    <p style="width: 200px; white-space: nowrap; overflow: hidden">{{connection.description}}</p>
                                                </div>
                                                <div class="offset-2 col-4">
                                                    <button class="btn btn-info accept-btn mt-2" v-on:click="acceptConnection(connection.connection_id)"><i class="fa fa-user-plus mr-2" style="font-size:19px;"></i> Accept</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </main>
</template>

<style scoped>
    .msg-btn{
        background-color:#48e3b7;
        border-radius: 20px;
        border:none;
        padding:6px 20px;
        color: #000000;
    }

    .accept-btn{
        background-color: #fa617b;
        border-radius: 20px;
        border:none;
        padding:6px 25px;
        color:#ffffff;
    }

</style>

<script>
    import {mapState} from 'vuex';
    import {authApiConfig} from "../../helpers/helpers";
    export default {
        name : 'Connections',
        props : {asset:String},
        computed:{
            ...mapState({
                auth:state=>state.auth
            })
        },
        created() {
            this.loadCurrentConnections();
            this.loadPendingConnections();
        },
        data:function(){
            return{
                current_connections:[],
                pending_connections:[]
            }
        },
        methods:{
            loadCurrentConnections:function () {
                axios.get(`/connections/1/${this.auth.user.id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.current_connections=response;
                    }).catch((error)=>{
                    console.log(error);
                });
            },

            loadPendingConnections:function () {
                axios.get(`/connections/0/${this.auth.user.id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.pending_connections=response;
                    }).catch((error)=>{
                    console.log(error);
                });
            },

            acceptConnection:function (id) {
                axios.patch(`/connection/status/${id}`,{},authApiConfig(this.auth.token))
                .then(()=>{
                    this.loadCurrentConnections();
                    this.loadPendingConnections();
                }).catch((error)=>{
                    console.log(error);
                });

            },

            openMessage:function (){
                this.$router.push({name:'admin.messages'});
            }

        }
    }
</script>
