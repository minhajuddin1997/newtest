<template>
    <main>
        <div class="modal fade" id="reasonModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content reason">
                    <form v-on:submit="rejectRequest">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reason For Rejection</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <textarea v-model="message" class="form-control" rows="6" placeholder="Please Enter The Reason For Rejection">{{message}}</textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn reject-btn">Reject Request</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>

        <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" :fetch-data="fetchRequests">
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
                        <button class="btn view"><i class="fa fa-eye"></i>View</button>
                        <button class="btn delete" v-if="!requests.status" data-toggle="modal" data-target="#reasonModal" v-on:click="selectRequest(requests)"><i class="fa fa-trash-o"></i>Reject</button>
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
        name:"Receive",
        props:{asset:String},
        components:{
            Datatable
        },
        computed:{
            ...mapState({
                auth: state=>state.auth,
                receiveRequests:state=>state.exchangeRequest.receiveRequests,
            }),
        },
        data:function(){
            return{
                DataTable:{
                    data:[],
                    columns:['Profile Picture', 'Receive At', 'Status', 'Actions'],
                    pagination: {
                        'current_page': 1
                    },
                },
                message:'',
                selected:{}
            }
        },
        mounted(){
            if(this.receiveRequests.length){
                this.DataTable.data=this.receiveRequests;
            }else{
                this.fetchRequests();
            }
        },
        methods:{
            fetchRequests:function (){
                axios.get(`/exchange/requests/${this.auth.user.id}`,authApiConfig(this.auth.token))
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
            },
            selectRequest:function(request){
                this.selected=request;
            },
            rejectRequest:function (e) {
                e.preventDefault();
                axios.put(`/exchange/requests/${this.selected.id}`,this.message,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    swal("Great!","Request Rejected Successfully.","success");
                    $("#reasonModal").modal('hide');
                }).catch((error)=>{
                   console.log(error);
                });
            }
        }
    }
</script>
