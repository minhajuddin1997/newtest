<template>
    <main>
        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="container-fluid">
                    <div class="row col-12 work-heading">
                        <h3>Payments</h3>
                    </div>
                    <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" class="work-table" :fetch-data="fetchPayments">
                        <template v-slot:rows>
                            <tr><p v-if="!DataTable.data.length" style="color: #1c1c1c;font-size: 15px;">No Works Found</p></tr>
                            <tr v-for="work in DataTable.data" id="requests_row">
                                <td class="tb_company" style="width:250px">
                                    <img :src="checkImage(work.user.profile_picture)" class="img-fluid"  />
                                    <article class="company_name"><strong>{{work.user.company_name}}</strong></article>
                                    <article class="company_email">{{work.user.email}}</article>
                                </td>
                                <td class="tb_amount">000{{work.payment.id}}</td>
                                <td class="tb_amount">$ {{work.payment.amount}}</td>
                                <td><p class="work_date">{{formatDate(work.payment.created_at)}}</p></td>
                                <td><p class="work_date">{{work.payment.payment_method}}</p></td>
                                <td>
                                    <span :class="checkStatus(work.payment.payment_status.status)[0]" :disabled="work.payment.payment_status.status=='Not Verified'?'disabled':''" >{{work.payment.payment_status.status}}</span>
                                </td>
                                <td class="tb_buttons">
                                    <button class="btn btn-danger mt-1"
                                            v-show="verifyPayment(work.payment.payment_status.status,work.payment.paid_by)"
                                            v-on:click="saveVerifyPayment(work)" >
                                            <i class="fa fa-credit-card"></i>
                                            Verify Payment
                                    </button>
                                    <button class="btn view" v-show="viewActions(work.payment.payment_status.status)" ><i class="fa fa-eye"></i>View</button>
                                    <button class="btn delete" v-show="viewActions(work.payment.payment_status.status)" ><i class="fa fa-trash"></i>Delete</button>
                                </td>
                            </tr>
                        </template>
                    </Datatable>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import {authApiConfig} from '../../helpers/helpers';
    import {mapState, mapActions} from 'vuex';
    import Datatable from "./shared/Datatable";
    export default{
        name:"PaymentsHistory",
        props:{asset:String},
        components:{
            Datatable
        },
        computed:{
            ...mapState({
                auth: state=>state.auth,
            }),
        },
        data:function(){
            return{
                DataTable:{
                    data:[],
                    columns:['Company Name', 'Payment ID' , 'Amount' , 'Payment Date' , 'Payment Method' ,'Status', 'Actions'],
                    pagination: {
                        'current_page': 1
                    },
                },
                message:'',
                selected:{}
            }
        },
        created(){
            this.fetchPayments();
        },
        methods:{
            ...mapActions({
                setExchangeDetails:'setExchangeDetails'
            }),
            fetchPayments:function (){
                var authId=this.auth.user.id;
                axios.get(`/works/${authId}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.DataTable.data=res;
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
            formatDate:(date)=>{
                var date=new Date(date);
                var options={month:'numeric',day:'numeric',year:'numeric'};
                return date.toLocaleDateString("en-US",options);
            },
            checkImage:function(profileURL){
                return profileURL? this.asset+''+profileURL: this.asset+'assets/admin/images/placeholder.png';
            },
            checkStatus:(status)=>{
                switch (status) {
                    case "Pending":
                        return ["pending"];
                    case "Completed":
                        return ["accepted"];
                    case "Cancelled":
                        return ["pending"];
                    case "Not Verified":
                        return ["not-verified"];

                }
            },
            // selectRequest:function(request){
            //     this.selected=request;
            // },
            verifyPayment:function(status,paidBy){
                return paidBy===this.auth.user.id && status === "Not Verified" ? true : false;
            },
            viewActions:function(status){
                return status !== "Not Verified" ? true : false;
            },
            saveVerifyPayment: function (work) {
                console.log(work.id);
                axios.get(`/works-payments/${work.id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    var data={requestedServices: res.requested_services,
                        selectedServices:  res.offered_services,
                        sender: res.sender,
                        receiver: res.receiver,
                        amount: res.payment.amount,
                        paidTo: res.payment.paid_to,
                        paidBy: res.payment.paid_by,
                    };
                    this.setExchangeDetails(data);
                    this.$router.push({name:"admin.payment",params:{paymentId:work.payment.id}});
                });
            }
        }
    }
</script>
