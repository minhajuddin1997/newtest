<template>
    <main>

        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3 class="request_title">Exchange Requests</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title border-bottom-0">

                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12 mb-2">

                                        <div class="btn-group">
                                            <router-link :to="{name:'receive'}" class="btn tab_receive"><i class="fa fa-envelope-open-o"></i> Receive Requests</router-link>
                                            <router-link :to="{name:'send'}" class="btn tab_send"><i class="fa fa-paper-plane-o"></i> Send Requests</router-link>
                                        </div>

                                    </div>

                                    <div class="col-sm-12">
                                        <router-view :asset="asset" ></router-view>
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
    import {mapState} from 'vuex';
    export default {
        name:'Requests',
        props:['asset'],
        data:function(){
          return{
              DataTable:{
                  data:[],
                  columns:['Profile Picture', 'Receive At', 'Status', 'Actions'],
                  pagination: {
                      'current_page': 1
                  },
              }
          }
        },
        computed:{
            ...mapState({
                auth: state=>state.auth
            }),
        },
        mounted() {
            this.$router.push({name:'receive'});
        }

    }
</script>
