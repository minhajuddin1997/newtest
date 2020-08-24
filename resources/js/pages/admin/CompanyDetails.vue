<template>
   <main>

       <div class="right_col" role="main" style="min-height: 990px;">
           <div class="">
               <div class="row">
                   <div class="offset-3 col-md-6">
                       <div class="x_panel text-dark">

                           <div class="x_title">
<!--                               Title Container-->
                               <div class="container-fluid">
                                   <div class="row">
                                       <div class="offset-4 col-4">
                                           <img :src="asset+company.profile_picture" class="img-fluid mx-auto circle d-block" />
                                       </div>
                                   </div>
                                   <div>
                                       <h5 class="text-center">{{company.company_name}}</h5>
                                       <p class="text-center">96 Reviews</p>
                                   </div>
                                   <div class="row col-12 text-center">
                                       {{company.description}}
                                   </div>
                               </div>
                           </div>
<!--                           End Title Container-->
                           <div class="x_content">
                               <div class="row">
                                   <div class="col-md-12 col-sm-12  ">
                                       <div class="x_panel" style="border: none;">
                                           <div class="x_content">
                                               <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">


                                                   <div class="panel" v-for="service in services">
                                                       <a class="panel-heading collapsed" role="tab" :id="service.id" data-toggle="collapse" data-parent="#accordion" :href="'#a'+service.id" aria-expanded="false" aria-controls="collapseThree">
                                                           <h4 class="panel-title">
                                                           <button :class="'btn'+checkStatus(service.id)[1]" v-on:click="selectServices(service)" style="padding: 0 6px;"><i class="fa fa-check"></i></button>
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
                                                           <button type="button" class="btn btn-danger" v-on:click="saveAndExchange">Request for Exchange</button>
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
                this.saveSelectedServices({services:this.selected,amount:this.totalAmount});
                swal('Great!',"Your Request For Exchange Has Been Sent.",'success');
                this.$router.push({name:'admin'});
            }

        }
    }
</script>
