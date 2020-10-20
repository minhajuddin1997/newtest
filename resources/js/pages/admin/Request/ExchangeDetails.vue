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

        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="row">
                    <div class="offset-md-1 col-md-10 offset-lg-2 col-lg-8 col-sm-12">
                        <div class="x_panel">

                            <div class="row requested-service-header">
                                <div class="col-1">
                                    <img :src="asset+sender.profile_picture"  />
                                </div>
                                <div class="col-8">
                                    <article class="requested-company-name">{{sender.company_name}}</article>
                                    <article class="requested-text">Requested These Services</article>
                                </div>
                            </div>
                            <div v-for="service in requestedServices" class="card card-body requested-service-box">
                                <div class="row">
                                    <div class="col-md-8">
                                        <h5>{{service.title}}</h5>
                                        <p>{{service.description}}</p>
                                    </div>
                                    <div class="offset-md-2 col-md-2 col-sm-4 cost-box">
                                        <p class="head-cost">Cost:</p>
                                        <p class="text-cost">${{service.amount}}</p>
                                    </div>
                                </div>
                            </div>

                            <div v-if="this.receiveRequest.status===0" class="offer-services-container">

                            <div class="col-12 mt-2 p-1">
                                <p>Select The Services You Want</p>
                                <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">

                                    <div class="panel" v-for="service in offerServices">
                                        <a class="panel-heading collapsed" role="tab" :id="service.id" data-toggle="collapse" data-parent="#accordion" :href="'#a'+service.id" aria-expanded="false" aria-controls="collapseThree">
                                            <h4 class="panel-title">
                                                <button :class="'btn check-button'+checkStatus(service.id)[1]" v-on:click="selectServices(service)" ><i class="fa fa-check"></i></button>
                                                {{service.title}}</h4>

                                        </a>
                                        <div :id="'a'+service.id" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" style="">
                                            <div class="panel-body p-3">
                                                {{service.description}}
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="x_panel">
                                <div class="x_content">
                                    <div class="row">
                                        <div class="col-3">
                                            <strong>Total Cost : {{this.amount}}</strong>
                                        </div>
                                        <div class="offset-4 col-5">
                                            <button type="button" class="btn accepted-btn" :disabled="this.selectedServices.length?false:'disabled'" v-on:click="saveDetails">Next Step</button>
                                            <button type="button" class="btn rejected-btn" data-toggle="modal" data-target="#reasonModal">Reject</button>
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
<script>
    import {mapState, mapActions} from 'vuex';
    import {authApiConfig} from "../../../helpers/helpers";
    export default {
        name:'ExchangeDetails',
        props:{asset:String},
        computed:{
            ...mapState({
                receiveRequests:(state)=>state.exchangeRequest.receiveRequests,
                auth:state=>state.auth,
            })
        },
        created() {
            this.requestId=this.$route.params.id;
            this.receiveRequest=this.receiveRequests.filter(request => parseInt(request.id) === parseInt(this.requestId))[0];
            if(this.receiveRequests.length){
                this.sender=this.receiveRequest.user;
            }else{
                this.findRequest(this.requestId)
                .then(res=>res.data)
                .then((res)=>{
                    this.sender=res.user;
                }).catch((error)=>{
                    console.log(error);
                })
            }
            // 1. fetch Requested Services
            this.fetchRequestedServices(this.requestId);
            // 2. fetch offer services
            this.fetchOfferServices(this.requestId);
        },
        data:function(){
            return{
                requestId:0,
                receiveRequest:{},
                sender:{},
                requestedServices:[],
                offerServices:[],
                selectedServices:[],//Sender Services Selection Array
                amount:0,
                message:""
            }
        },
        methods:{
            ...mapActions({
                setExchangeDetails:'setExchangeDetails'
            }),

            findRequest:async function(id){
                return await axios.get(`/exchange/find/request/${id}`,authApiConfig(this.auth.token));
            },

            fetchRequestedServices:function(id){
                axios.get(`/exchange/requested/services/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    this.requestedServices=res;
                    this.computeAmount();
                }).catch((error)=>{
                    console.log(error);
                });
            },

            fetchOfferServices:function (id) {
                axios.get(`/exchange/offer/services/${id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.offerServices=res;
                    }).catch((error)=>{
                    console.log(error);
                });
            },

            rejectRequest:function (e) {
                e.preventDefault();
                axios.put(`/exchange/requests/${this.requestId}`,{message:this.message},authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        var index=this.$store.state.exchangeRequest.receiveRequests.findIndex((request)=>request.id===this.requestId);
                        this.$store.state.exchangeRequest.receiveRequests[index].status=-1;
                        this.$router.push({name:"admin.requests"});
                        swal("Great!","Request Rejected Successfully.","success");
                        $("#reasonModal").modal('hide');
                    }).catch((error)=>{
                    console.log(error);
                });
            },

            checkStatus:function(id){
                if(this.selectedServices.length){
                    var found=this.selectedServices.filter((service)=>{
                        return service.id===id;
                    });
                    if(found.length){
                        return found[0].id?[true,' btn-success']:[false,' btn-dark'];
                    }
                    return [false,' btn-dark'];
                }
                else{
                    return [false,' btn-dark'];
                }
            },
            //
            computeAmount:function () {
                var requestServicesAmount=0, selectedServicesAmount=0;

                this.selectedServices.forEach((service)=>{
                    selectedServicesAmount+=service.amount;
                });
                this.requestedServices.forEach((service)=>{
                    requestServicesAmount+=service.amount;
                });
                this.amount=requestServicesAmount-selectedServicesAmount;
            },
            //

            selectServices:function (service) {
                if(this.checkStatus(service.id)[0]){
                    var check=service.id;
                    this.selectedServices=this.selectedServices.filter((service)=>service.id!==check);
                }else{
                    this.selectedServices.push(service);
                }
                this.computeAmount();
            },

            // recording request
            saveDetails:function (e){
                var data={
                    sender:this.sender,
                    requestedServices:this.requestedServices,
                    selectedServices:this.selectedServices,
                    amount:this.amount,
                    requestId: this.requestId
                };
                if(this.amount>0){
                    data.paidTo=this.auth.user.id;
                    data.paidBy=this.sender.id;
                }else if(this.amount===0){
                    data.paidTo=0;
                    data.paidBy=0;
                }else{
                    data.paidTo=this.sender.id;
                    data.paidBy=this.auth.user.id;
                }
                this.setExchangeDetails(data);
                this.$router.push({name:'admin.exchange.agreement'});
            }

        }
    }
</script>
