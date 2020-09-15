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
                message:{}
            }
        },
        methods:{
            ...mapActions({
                setExchangeDetails:'saveDetails'
            }),

            findRequest:async function(id){
                return await axios.get(`/exchange/find/request/${id}`,authApiConfig(this.auth.token));
            },

            fetchRequestedServices:function(id){
                axios.get(`/exchange/requested/services/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    this.requestedServices=res;
                }).catch((error)=>{
                    console.log(error);
                });
            },

            fetchOfferServices:function (id) {
                axios.get(`/exchange/offer/services/${id}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.offerServices=res;
                        console.log(res);
                    }).catch((error)=>{
                    console.log(error);
                });
            },

            rejectRequest:function (e) {
                e.preventDefault();
                axios.put(`/exchange/requests/${this.selected.id}`,{message:this.message},authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        var index=this.$store.state.exchangeRequest.receiveRequests.findIndex((request)=>request.id===this.selected.id);
                        this.$store.state.exchangeRequest.receiveRequests[index].status=-1;
                        this.DataTable.data[index].status=-1;
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
            // computeAmount:function () {
            //     var totalAmount=0;
            //     this.selected.forEach((service)=>{
            //         totalAmount+=service.amount;
            //     });
            //     this.totalAmount=totalAmount;
            // },
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

        }
    }
</script>
