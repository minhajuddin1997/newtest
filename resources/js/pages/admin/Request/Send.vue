<template>
    <main>
        <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" :fetch-data="fetchSenderRequests">
            <template v-slot:rows>
                <tr><p v-if="!DataTable.data.length" style="color: #1c1c1c;font-size: 15px;">No Requests Found</p></tr>
                <tr v-for="requests in DataTable.data" id="requests_row">
                    <td class="tb_company">
                        <img :src="checkImage(requests.user.profile_picture)" class="img-fluid"  />
                        <article class="company_name"><strong>{{requests.user.company_name}}</strong></article>
                        <article class="company_email">{{requests.user.email}}</article>
                    </td>
                    <td><p class="request_date">{{formatDate(requests.created_at)}}</p></td>
                    <td>
                        <span :class="checkStatus(requests.status)[0]">{{checkStatus(requests.status)[1]}}</span>
                    </td>
                    <td class="tb_buttons">
                        <button class="btn delete" v-if="requests.status===-1"><i class="fa fa-trash-o"></i>Delete</button>
                    </td>
                </tr>
            </template>
        </Datatable>
    </main>
</template>

<script>
    import {authApiConfig} from '../../../helpers/helpers';
    import {mapState} from 'vuex';
    import Datatable from "../shared/Datatable";
    export default{
        name:"Send",
        props:{asset:String},
        components:{
            Datatable
        },
        computed:{
            ...mapState({
                auth: state=>state.auth,
                sendRequests:state=>state.exchangeRequest.sendRequests,
            }),
        },
        data:function(){
            return{
                DataTable:{
                    data:[],
                    columns:['Profile Picture', 'Send At', 'Status', ''],
                    pagination: {
                        'current_page': 1
                    },
                }
            }
        },
        mounted(){
            if(this.sendRequests.length){
                this.DataTable.data=this.sendRequests;
            }else{
                this.fetchSenderRequests();
            }
        },
        methods:{
            fetchSenderRequests:function (){
                axios.get(`/exchange/send/requests/${this.auth.user.id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.DataTable.data=res;
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
            formatDate:(date)=>{
                var date=new Date(date);
                var options={month:'short',day:'numeric',year:'numeric'};
                return date.toLocaleDateString("en-US",options);
            },
            checkImage:function(profileURL){
                return profileURL? this.asset+''+profileURL: this.asset+'assets/admin/images/placeholder.png';
            },
            checkStatus:(status)=>{
                switch (status) {
                    case 0:
                        return ["pending","Pending"];
                    case -1:
                        return ["reject","Rejected"];
                    case 1:
                        return ["accepted","Accepted"];
                }
            }
        }
    }
</script>
