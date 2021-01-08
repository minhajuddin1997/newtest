<template>
    <main>
      <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="row">
                    <div class="offset-md-1 col-md-10 offset-lg-2 col-lg-8 col-sm-12">
                        <div class="x_panel">

                            <div class="row requested-service-header">
                                <div class="col-2">
                                    <img :src="checkImage(userArray.profile_picture)" class="img-fluid"  width="350" />
                                </div>
                                <div class="col-5">
                                    Company: <article class="requested-company-name">{{userArray.company_name}}</article>
                                </div>
                
                            </div>
                           
                            <div v-for="payment in requestedServices" class="card card-body requested-service-box">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h6>Payment Method: {{payment.payment_method}}</h6>
                                        <h6>Payment Date: {{payment.created_at}}</h6>
                                        <h6>Payment Made To: {{userArray.first_name}} {{userArray.last_name}}</h6>
                                        <h6>Name on Card: {{payment.name_on_card}}</h6>
                                        <h6>Card Number: {{payment.card_number}}</h6>
                                    </div>
                                     <div class="col-md-8">
                                       
                                    </div>
                                    <div class="offset-md-2 col-md-2 col-sm-4 cost-box">
                                        <p class="head-cost">Amount: {{payment.amount}}</p>
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
<script>
    import {mapState, mapActions} from 'vuex';
    import {authApiConfig} from "../../../helpers/helpers";
    export default {
        name:'PaymentDetails',
        props:{asset:String},
        computed:{
            ...mapState({
                receiveRequests:(state)=>state.exchangeRequest.receiveRequests,
                auth:state=>state.auth,
            })
        },
        created() {
            this.requestId=this.$route.params.id;
            this.user_id = this.auth.user.id;
            this.fetchRequestedServices(this.requestId);
            this.fetchUser(this.user_id);
        },
        data:function(){
            return{
                requestId:0,
                receiveRequest:{},
                sender:{},
                requestedServices:[],
                userArray:[],
                selectedServices:[],//Sender Services Selection Array
                amount:0,
                message:""
            }
        },
        methods:{
            ...mapActions({
                setExchangeDetails:'setExchangeDetails'
            }),

       
            fetchUser:function(id){
                axios.get(`/user/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    this.userArray=res;
                    console.log(res);
                }).catch((error)=>{
                    console.log(error);
                });
            },
            fetchRequestedServices:function(id){
                axios.get(`/payment/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    this.requestedServices=res;
                }).catch((error)=>{
                    console.log(error);
                });
            },
            checkImage:function(profileURL){
                return profileURL? this.asset+''+profileURL: this.asset+'assets/admin/images/placeholder.png';
            },
 

            //
        }
    }
</script>
