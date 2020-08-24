<template>
        <!-- page content -->
        <div class="right_col" role="main" style="min-height: 990px;">
            <!-- top tiles -->
            <div class="row" style="display: block;" v-if="checkDisplay">
                <div class="tile_count">
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
                        <div class="count">2500</div>
                        <span class="count_bottom"><i class="green">4% </i> From last Week</span>
                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
                        <div class="count">123.50</div>
                        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
                        <div class="count green">2,500</div>
                        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
                        <div class="count">4,567</div>
                        <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
                        <div class="count">2,315</div>
                        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                    </div>
                    <div class="col-md-2 col-sm-4  tile_stats_count">
                        <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
                        <div class="count">7,325</div>
                        <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
                    </div>
                </div>
            </div>
            <!-- /top tiles -->
            <div class="row" style="display: block;" v-if="!checkDisplay">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-5 offset-3">
                            <form v-on:submit="doSearch">
                                <div class="input-group">
                                    <input type="text" name="search" placeholder="Search for the required services" v-model="Searching.search" class="form-control" />
                                    <button type="submit" class="btn btn-dark input-group-append"><i class="fa fa-search p-1"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-2 offset-5" v-show="Searching.loading">
                            <div class="spinner-border" style="width: 3rem; height: 3rem;" role="status">
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>

                        <div class="col-md-6 offset-3" v-show="!Searching.loading && Searching.services.length">
                            <h6>Company's found with this search. "{{Searching.search}}"</h6>
                        </div>

                        <div class="col-md-6 offset-3 mt-2 card card-body text-dark"
                             style="-webkit-box-shadow: 0px 2px 10px -1px rgba(0,0,0,0.75);
                                    -moz-box-shadow: 0px 2px 10px -1px rgba(0,0,0,0.75);
                                    box-shadow: 0px 2px 10px -1px rgba(0,0,0,0.75);"
                             v-for="company in Searching.services"
                             v-show="!Searching.loading && Searching.services">
                            <div class="media">
                                <div class="media-body">
                                    <h5 class="mt-0">{{company.company_name}}</h5>
                                    <p>{{company.description}}</p>
                                </div>
                                <img class="align-self-end mr-3"
                                     style="height: 180px; width: 180px; border-radius: 50%;"
                                     :src="company.profile_picture!=''?asset+company.profile_picture:asset+'assets/admin/images/services_icon.png'" >
                            </div>
<!--                                <button class="btn btn-primary w-25">View <i class="fa fa-arrow-right"></i></button>-->
                            <button class="btn btn-info w-25"
                                    v-on:click="companyDetails(company)">
                                <i class="fa fa-eye"></i>
                                View Details
                            </button>
                        </div>

                        <div class="col-md-6 offset-3" v-show="Searching.notFound">
                            <p>No Companies Found</p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->
</template>
<script>
    import {mapState, mapActions} from 'vuex';
    import {authApiConfig} from "../../helpers/helpers";
    export default {
        name:'dashboard',
        props:{
          asset:String,
        },
        computed:{
            ...mapState({
                auth:state=>state.auth
            }),
            checkDisplay:function(){
                return this.auth.user.role_id==1?true:false;
            },
        },
        data:function(){
            return{
                Searching: {
                    search: '',
                    services: [],
                    loading:false,
                    notFound:false,
                    // search_logs:[]
                }
            }
        },
        created() {
        },
        methods:{
            doSearch:function(e){
                e.preventDefault();
                this.Searching.loading=true;
                axios.get(`/company/search/${this.auth.user.id}/${this.Searching.search===''?'1':this.Searching.search}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((response)=>{
                    if(response.length) {
                        this.Searching.loading = false;
                        this.Searching.services = response;
                        this.Searching.notFound = false;
                    }else{
                        this.Searching.loading = false;
                        this.Searching.services = response;
                        this.Searching.notFound = true;
                    }
                }).catch((error)=>{
                    console.log(error);
                });
            },
            ...mapActions({
                selectedCompany:'viewSearchedCompany'
            }),
            companyDetails:function (company) {
                this.$router.push({name:'admin.company-details'});
                this.selectedCompany(company);
            }
            // searchLogs:function () {
            //     axios.get(`/services/search_logs/${this.auth.user.id}`,authApiConfig(this.auth.token))
            //         .then(res=>res.data)
            //         .then((response)=>{
            //             console.log(response);
            //             this.Searching.search_logs=response;
            //         }).catch((error)=>{
            //         console.log(error);
            //     });
            // }
        }
    }
</script>
