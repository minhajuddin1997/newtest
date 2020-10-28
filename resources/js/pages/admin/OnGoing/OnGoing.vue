<template>

    <main>
        <div class="right_col" role="main" style="min-height: 3091px;">
            <div class="">
                <div class="col-10 offset-1 active-work-section">
                    <div>
                        <div class="row">
                            <h2 class="active-work-heading">Active Work</h2>
                        </div>
                        <div class="x_content">
                            <ul class="col-lg-12 works-container">
                                <li v-for="item in companies" class="work-section col-lg-6">
                                    <a v-on:click="goToServices(item.work_id)">
                                        <span class="image">
                                        <img :src="asset+item.profile_picture" alt="img">
                                        </span>
                                        <article class="work_company_name">
                                            <span style="font-size: 18px" >{{item.company_name}}</span>
                                        </article>
                                        <article class="message">
                                            {{item.email}}
                                        </article>
                                    </a>
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
    import {mapState} from 'vuex'
    import {authApiConfig} from "../../../helpers/helpers";
    export default {
        name:'OnGoingWork',
        props:{
            asset:String,
        },
        computed:{
            ...mapState({
                auth:(state)=>state.auth
            })
        },
        created() {
            this.fetchWorks();
        },
        data:function(){
            return{
                companies:[]
            }
        },
        methods:{
            goToServices:function (item) {
                this.$router.push({name:'admin.on_going_services',params:{id:item}});
            },
            fetchWorks:function () {
                axios.get(`/going-works/${this.auth.user.id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((data)=>{
                    this.companies=data;
                });
            }
        }
    }
</script>
