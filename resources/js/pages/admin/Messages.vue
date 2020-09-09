<template>
    <main>
        <div class="right_col" role="main" style="min-height: 1068px;">
            <div class="p-0">
                <div class="row p-0">
                    <div class="col-md-12 col-sm-12 p-0">

                        <div>
                            <div>
                                <div class="col-md-3 p-0 connections" >
                                    <ChatUsers :auth="auth" :asset="asset" :users="users" v-on:select="selectedConnection" />
                                </div>
                                <div class="col-md-9 p-0 mt-2">
                                    <div class="card messages" style="border: none">
                                    <div class="card-header" style="background-color: #f8f8f8;border: none; height:68px;">
                                        <div class="row">
                                            <div class="col-1">
                                                <img v-if="selected.profile_picture!==undefined" :src="asset+selected.profile_picture" style="height: 50px; width: 50px" class="img-fluid img-circle ml-3  bg-white">
                                            </div>
                                            <div class="col-2 mr-2" >
                                                <h6 style="line-height: 50px" class="text-dark">{{selected.company_name}}</h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <ChatMessages v-if="users.length" :auth="auth" :asset="asset" :messages="messages" :loading="loadingMessages"/>
                                        <h4  v-if="!users.length" > No Connections</h4>
                                    </div>

                                    <div class="card-footer">
                                        <ChatForm :auth="auth" v-if="selected.id !== undefined" :asset="asset" v-on:send="sendMessage" />
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

<style>
    .connections{
        height:844px;
        background-color: #f8f8f8;
        padding-top: 10px !important;
    }
    .messages{
        height: 844px;
    }
    .card-footer{
        padding: 0 !important;
        background: none;
        border: none;
    }
</style>

<script>
    import ChatForm from "./Chat/ChatForm";
    import ChatMessages from "./Chat/ChatMessages";
    import ChatUsers from "./Chat/ChatUsers";
    import {mapState} from 'vuex';
    import {authApiConfig} from "../../helpers/auth/authTokenConfig";
    export default{
        name:'Messages',
        props:{asset:String},
        components:{
            ChatForm,
            ChatMessages,
            ChatUsers
        },
        computed:{
            ...mapState({
               auth:state=>state.auth
            }),
        },
        data:function(){
            return{
                messages:[],
                users:[],
                loadingMessages:true,
                selected:{},
                hold:{message:''}
            }
        },
        created() {
            this.loadConnections();
        },
        updated() {
            var pusher=new Pusher('13dc91256b26300c36f3', {
                cluster: 'ap2',
            });
            var channel=pusher.subscribe('company-message-'+this.selected.connection_id);
            var self=this;
            channel.bind('message.sent',function (data) {
                if(data.connection_id===self.selected.connection_id) {
                    if(self.messages.length===0){
                        self.messages.push(data);
                    }
                    else if(self.messages[self.messages.length-1].message!==data.message)
                        self.messages.push(data);
                }
                else{
                    self.users.forEach((user,index)=>{
                        if(user.connection_id===data.connection_id){
                            if(self.hold.message!==data.message) {
                                self.hold=data;
                                self.users[index].count += 1;
                            }
                        }
                    });
                }
            });

        },
        methods:{
            //Update Status Of Notification
            updateNotificationStatus:function(toId, fromId, connection_id, token){
                axios.get(`/messages/status/${toId}/${fromId}/${connection_id}`,authApiConfig(token))
                    .then(res=>res.data)
                    .then((data)=>{
                    }).catch((error)=>{
                        console.log(error);
                });
            },
            loadMessages:function(connection_Id){
                axios.get(`/messages/${connection_Id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.messages=response;
                        this.loadingMessages=false;
                        this.selected.count=0;
                        this.updateNotificationStatus(this.selected.id,this.auth.user.id, connection_Id,this.auth.token);
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            loadConnections:function () {
                axios.get(`/connections/1/${this.auth.user.id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.users=response;
                        this.selected=this.users[0];
                        this.loadMessages(this.users[0].connection_id);
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            sendMessage:function(message){
                var data={from:this.auth.user.id, to:this.selected.id, message:message, connection_id:this.selected.connection_id};
                axios.post(`/messages`,data,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
            selectedConnection:function (company) {
                this.selected = company;
                this.loadingMessages=true;
                this.loadMessages(this.selected.connection_id);
            }

        }
    }
</script>
