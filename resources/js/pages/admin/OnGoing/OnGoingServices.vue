<template>

    <main>
        <div class="right_col" role="main" style="min-height: 3091px;">
            <div class="">
                <div class="col-lg-10 offset-lg-1 col-md-12">
                    <div class="text-dark">
                        <div class="">
                            <div class="row going-service-company-section">
                                <div class="col-lg-1 col-md-2 col-sm-2">
                                    <img :src="asset+company.profile_picture" class="img-fluid">
                                </div>
                                <div class="col-lg-11 col-md-10">
                                    <h6 class="font-weight-bolder going-services-company-heading">{{company.company_name}}</h6>
                                </div>
                            </div>
                        </div>
                        <div class="x_content row work-service-section">

                            <ul class="list-group offset-lg-1 col-lg-8 offset-md-2 col-md-8 ">
                                <li v-for="item in servicesList" class="work-service">
                                    <div class="work-service-name">
                                        {{item.service_title}}
                                    </div>
                                    <div class="work-service-status">
                                        <span style="font-size: 12px;" :class="item.work_service_status===0?'pending pt-1 pb-1':'accepted pt-1 pb-1'">{{item.work_service_status?"Completed":"Incomplete"}}</span>
                                        <span><button class="btn btn-link btn-sm work-service-details-button"
                                                      v-on:click="goToDetails(item.work_service_id)">
                                            <i class="fa fa-eye"></i> View Details</button></span>
                                    </div>

                                </li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </main>

</template>

<script>
    import {mapState} from 'vuex';
    import {authApiConfig} from "../../../helpers/helpers";
    export default {
        name:'OnGoingServices',
        props:{
            asset:String,
        },
        computed:{
            ...mapState({
                auth:(state)=>state.auth
            })
        },
        created() {
            this.fetchServices();
        },
        data:function(){
            return{
                repeat:[
                    {name:"Web Designing", status:1, work_service_id:10},
                    {name:"Web Development", status:0, work_service_id:10},
                    {name:"App Development", status:1, work_service_id:10},
                    {name:"UI\/UX Design", status:0, work_service_id:10},
                ],
                servicesList:[],
                yourServices:[],
                company:{}
            }
        },
        methods:{
            fetchServices:function () {
                var id = this.$route.params.id;
                axios.get(`/going-works-services/${id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((data)=>{
                    this.servicesList=data.services.filter((service)=>{
                        return service.sender_id===this.auth.user.id;
                    });
                    this.company=data.user;
                })
            },
            goToDetails:function(work_service_id){
                return this.$router.push({name:"admin.work-service.tasks",params:{id:work_service_id}});
            }
        }

    }
</script>
