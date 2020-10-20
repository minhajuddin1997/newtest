<template>
    <main>
        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="row">
                    <div class="offset-md-1 col-md-10 offset-lg-2 col-lg-8 col-sm-12">
                        <h3 class="agreement-heading">Demo Agreement</h3>
                        <div class="x_panel card">

                            <div class="card-body" style="color: #1c1c1c">
                                <div class="row mb-2">
                                    <div class="col-3 p-0">
                                        <h6>Contract</h6>
                                    </div>
                                    <div class="offset-6 col-3 p-0" >
                                        <h6>{{date}}</h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <p>{{agreement}}</p>
                                </div>
                                <div class="row">
                                    <button type="button" class="btn pending-btn pl-4 pr-4" v-on:click="saveWork">Accept</button>
                                    <button type="button" class="btn  pl-4 pr-4" v-on:click="resetDetails">Decline</button>
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
    import {authApiConfig} from "../../../helpers/helpers";
    import {mapState,mapActions} from 'vuex';
    export default {
        name:'Agreement',
        data:function () {
            return{
                agreement:""
            }
        },
        computed:{
            ...mapState({
                auth:(state)=>state.auth,
                paymentInfo:(state)=>state.exchangeProcess
                     }),
            date: function () {
                var options={day:'numeric',month:'long',year:"numeric"};
                return new Date().toLocaleString('en-US',options);
            },
        },
        mounted() {
            if(this.$store.state.exchangeProcess.sender.id===undefined){
                this.$router.push({name:'admin.requests'});
            }
            this.fetchAgreement();
        },
        methods:{
            ...mapActions({
                resetExchange:'resetExchangeDetails'
            }),
            fetchAgreement:function () {
                axios.get("/exchange/agreement",authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    this.agreement=this.replace(res.agreement_text);
                });
            },

            replace: function(agreement=""){
                //Tags To Replace:  <sender> <receiver>
                var sender=this.$store.state.exchangeProcess.sender;
                agreement=agreement.replace(/\<sender\>/, sender.company_name);
                agreement=agreement.replace(/\<receiver\>/, this.auth.user.company_name);
                return agreement;
            },

            resetDetails:function () {
                this.resetExchange();
                this.$router.push({name:'admin.requests'})
            },

            saveWork:function () {
                let serviceAmount=this.calculateAmounts()[1];
                let exchangeAmount=this.calculateAmounts()[0];
                if(serviceAmount<exchangeAmount){
                    this.$router.push({name:'admin.payment'});
                }else{
                    var data={requestedServices: this.paymentInfo.requestedServices,
                        exchangeServices:  this.paymentInfo.selectedServices,
                        sender: this.paymentInfo.sender,
                        receiver: this.auth.user,
                        amount: this.paymentInfo.amount,
                        paidTo: this.paymentInfo.paidTo,
                        paidBy: this.paymentInfo.paidBy,
                        paymentMethod: "Credit Card",
                        requestId:this.paymentInfo.requestId,
                        status:"Not Verified",
                        ...this.cardInfo
                    };
                    axios.post('/exchange/payment',data,authApiConfig(this.auth.token))
                        .then(res=>res.data)
                        .then((res)=>{
                            var self=this;
                            swal("Success","Thank you, You will be notified by email when payment gets verified. ","success");
                            var index=this.$store.state.exchangeRequest.receiveRequests.findIndex((request)=>{
                                return request.id===self.paymentInfo.requestId;
                            });
                            this.$store.state.exchangeRequest.receiveRequests[index].status=1;
                            this.$router.push({name:"admin.requests"});
                        }).catch((error)=>{
                        console.log(error.response);
                    });
                }

            },

            calculateAmounts:function () {
                var exchangeAmount=0;
                this.$store.state.exchangeProcess.selectedServices.forEach((service)=>{exchangeAmount+=service.amount});
                var serviceAmount=0;
                this.$store.state.exchangeProcess.requestedServices.forEach((service)=>{serviceAmount+=service.amount});
                return [exchangeAmount, serviceAmount];
            }

        }
    }
</script>
