<template>
   <main>

       <div class="right_col" role="main" style="min-height: 990px;">
           <div class="">
               <div class="row">
                   <div class="col-md-12">
                       <div class="x_panel text-dark">

                           <div class="x_title">
<!--                               Title Container-->
                               <div class="container-fluid">
                                   <div class="row">
                                       <div class="offset-md-2 col-1 float-left" style="padding-bottom: 30px;">
                                           <img :src="asset+company.profile_picture" style="height: 50px; width: 50px; margin-left: 55px !important;" class="img-fluid border img-circle d-block" />
                                       </div>
                                       <div class="col-md-6 col-sm-12">
                                           <h5>{{company.company_name}}</h5>
                                           <p>{{company.description}}</p>
                                       </div>

                                   </div>
                               </div>
                           </div>
<!--                           End Title Container-->
                           <div class="x_content">
                               <div class="row">
                                   <div class="col-md-6 col-sm-12 offset-md-3">
                                       <div class="x_panel" style="border: none;">
                                           <div class="x_content">
                                               <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">


                                                   <div class="panel" v-for="service in services">
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
                                                        <strong>Total Cost : {{this.totalAmount}}</strong>
                                                       </div>
                                                       <div class="offset-5 col-4">
                                                           <button type="button" class="btn request-exchange-btn" v-on:click="saveAndExchange">Request for Exchange</button>
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
           </div>
       </div>
   </main>
</template>
<script>
    import {mapState, mapActions} from 'vuex';
    import {authApiConfig} from "../../helpers/helpers";
    export default {
        name:'CompanyDetail',
        props:{asset:String},
        computed:{
            ...mapState({
                company:state=>state.exchangeRequest.selectedCompany,
                auth:state=>state.auth,
            }),
        },
        created() {
            if(!this.company.id){
                this.$router.push({name:'admin'});
            }
            this.fetchServices(this.company.id,this.auth.token);
        },
        data:function(){
            return{
                services:[],
                selected:[],
                totalAmount:0
            }
        },
        methods:{
            ...mapActions({
               saveSelectedServices:'selectServices'
            }),

            fetchServices:function(id,token){
                axios.get(`/services/search/${id}`,authApiConfig(token))
                .then(res=>res.data)
                .then((response)=>{
                    this.services=response;
                    // this.selected=response;
                    this.computeAmount();
                }).catch((error)=>{
                    console.log(error);
                });
            },

            selectServices:function (service) {
                if(this.checkStatus(service.id)[0]){
                    var check=service.id;
                    this.selected=this.selected.filter((service)=>service.id!==check);
                }else{
                    this.selected.push(service);
                }
                this.computeAmount();
            },

            checkStatus:function(id){
                if(this.selected.length){
                    var found=this.selected.filter((service)=>{
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

            computeAmount:function () {
                var totalAmount=0;
                this.selected.forEach((service)=>{
                    totalAmount+=service.amount;
                });
                this.totalAmount=totalAmount;
            },

            saveAndExchange:function(){
                if(this.selected.length) {
                    var data = {
                        sender_id: this.auth.user.id,
                        receiver_id: this.company.id,
                        selectedServices: JSON.stringify(this.selected)
                    };
                    axios.post('/services/request', data, authApiConfig(this.auth.token))
                        .then(res => res.data)
                        .then((res) => {
                            if (res[0] === "success") {
                                swal('Great!', res[1], 'success');
                                this.$router.push({name: 'admin'});
                            } else {
                                swal("Error", res[1], "error");
                            }

                        }).catch((error) => {
                        console.log(error);
                    });
                }else{
                    swal("Error", "Select at least one service to exchange.", "error");
                }

            }

        }
    }
</script>
