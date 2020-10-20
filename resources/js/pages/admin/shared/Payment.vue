<template>
    <main>
        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="row">
                    <div class="offset-md-1 col-md-10 offset-lg-2 col-lg-8 col-sm-12">
                        <h3 class="payment-heading">Payment</h3>
                        <div class="x_panel card p-0">
                            <div class="card-body p-0">
                                <div class="row p-0">
                                    <div class="col-4 payment-summary-box">
                                        <div>
                                            <h5>Summary</h5>
                                            <div class="payment-summary-box-content">
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p># Services</p>
                                                        <p class="numeric">{{paymentInfo.requestedServices.length}}</p>
                                                    </article>
                                                </section>
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p>Services Cost</p>
                                                        <p class="numeric">${{cost}}</p>
                                                    </article>
                                                </section>
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p>Services Fee (0%)</p>
                                                        <p class="numeric">+${{services_fee}}</p>
                                                    </article>
                                                </section>
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p>Services Exchange Cost</p>
                                                        <p class="numeric">-${{exchangeCost}}</p>
                                                    </article>
                                                </section>
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p>Difference Cost</p>
                                                        <p class="numeric">${{differenceCost}}</p>
                                                    </article>
                                                </section>
                                                <section class="summary-sub-box">
                                                    <article>
                                                        <p>Tax</p>
                                                        <p class="numeric">+$00.00</p>
                                                    </article>
                                                </section>
                                                <section class="total-box">
                                                    <article>
                                                        <p>Total Pay</p>
                                                        <p class="numeric">${{this.totalCost}}</p>
                                                    </article>
                                                </section>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 payment-detail-box">
                                        <h5>Payment Methods</h5>
                                        <div class="row mt-3">
                                            <div class="col-3">
                                                <section class="payment-method-box-active">
                                                    <i class="fa fa-credit-card"></i>
                                                    <p>Credit Card</p>
                                                </section>
                                                <p class="payment-method-box-active-check"><i class="fa fa-check"></i></p>
                                            </div>
                                            <div class="col-3">
                                                <section class="payment-method-box">
                                                    <i class="fa fa-globe"></i>
                                                    <p>Net Banking</p>
                                                </section>
                                            </div>
                                            <div class="col-3">
                                                <section class="payment-method-box">
                                                    <i class="fa fa-paypal"></i>
                                                    <p>Paypal</p>
                                                </section>
                                            </div>
                                        </div>
                                        <form v-on:submit="saveAndProceed">
                                        <div class="row mt-3">
                                                <div class="col-9">
                                                <div class="form-group text-credit-card-field">
                                                    <label>Card Number</label>
                                                    <span><img :src="asset+'assets/admin/images/credit-card-info.png'" /></span>
                                                    <input type="text" class="form-control"
                                                           v-model="cardInfo.cardNumber"
                                                           placeholder="XXXX-XXXX-XXXX-XXXX"
                                                           pattern="[0-9]{4}-{1}[0-9]{4}-{1}[0-9]{4}-{1}[0-9]{4}"
                                                           required
                                                    />
                                                </div>
                                                </div>
                                                <div class="col-9">
                                                    <div class="form-group text-credit-card-field">
                                                        <label>Name On Card</label>
                                                        <input type="text" class="form-control"
                                                               v-model="cardInfo.nameOnCard"
                                                               placeholder="Jhon Smith"
                                                               required
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-5">
                                                    <div class="form-group text-credit-card-field">
                                                        <label>Valid Through</label>
                                                        <input type="text" class="form-control"
                                                               v-model="cardInfo.cardValidDate"
                                                               required
                                                               placeholder="01/24"
                                                        />
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="form-group text-credit-card-field">
                                                        <label>CVC/CVV</label>
                                                        <input type="text" class="form-control"
                                                               v-model="cardInfo.cardCVC"
                                                               pattern="[0-9]{3}"
                                                               required
                                                               placeholder="XXX"
                                                        />
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6 mt-3">
                                                <button type="submit" class="btn pending-btn" style="border-radius: 6px;">Proceed to Pay</button>
                                            </div>
                                        </div>
                                        </form>
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
    import {mapState} from "vuex";
    import {authApiConfig} from "../../../helpers/helpers";
    export default{

        name:"Payment",
        props:{
          asset: String
        },
        computed:{
            cost:function (){
                var total=0;
                this.paymentInfo.requestedServices.forEach((service)=>{
                    total+=service.amount;
                });
                return total.toFixed(2);
            },

            exchangeCost:function (){
                var total=0;
                this.paymentInfo.selectedServices.forEach((service)=>{
                    total+=service.amount;
                });
                return total.toFixed(2);
            },

            differenceCost:function () {
                return (this.cost-this.exchangeCost).toFixed(2);
            },

            tax:function () {
                return 0.00;
            },

            services_fee:function (){
                return  (this.cost*0.0).toFixed(2);
            },

            totalCost:function () {
                return (parseInt(this.differenceCost)+parseInt(this.tax)+parseInt(this.services_fee)).toFixed(2);
            },

            ...mapState({
                auth:(state)=>state.auth
            }),

        },
        data: function() {
            return {
                paymentInfo: this.$store.state.exchangeProcess,
                cardInfo: {
                    cardNumber:"",
                    nameOnCard:"",
                    cardCVC:"",
                    cardValidDate:"",
                }
            };
        },
        created() {
          if (this.paymentInfo.sender.id===undefined && this.$route.params.paymentId===undefined){
              this.$router.push({name:'admin.requests'});
          }
        },
        methods:{
            saveAndProceed:function (e) {
                e.preventDefault();
                if(this.$route.params.paymentId===undefined){
                    var data={requestedServices: this.paymentInfo.requestedServices,
                              exchangeServices:  this.paymentInfo.selectedServices,
                              sender: this.paymentInfo.sender,
                              receiver: this.auth.user,
                              amount: this.paymentInfo.amount,
                              paidTo: this.paymentInfo.paidTo,
                              paidBy: this.paymentInfo.paidBy,
                              paymentMethod: "Credit Card",
                              requestId:this.paymentInfo.requestId,
                              status: "Pending",
                              ...this.cardInfo
                    }
                }
                else{
                    var data= {
                        status: "Pending",
                        ...this.cardInfo,
                        paymentId:this.$route.params.paymentId
                    };
                }
                axios.post('/exchange/payment',data,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    var self=this;
                    swal("Success",res,"success");
                    if(this.$route.params.paymentId===undefined) {
                        var index = this.$store.state.exchangeRequest.receiveRequests.findIndex((request) => {
                            return request.id === self.paymentInfo.requestId;
                        });
                        this.$store.state.exchangeRequest.receiveRequests[index].status=1;
                    }
                    this.$router.push({name:"admin.requests"});
                }).catch((error)=>{
                    console.log(error.response);
                });
            }
        }
    }
</script>
