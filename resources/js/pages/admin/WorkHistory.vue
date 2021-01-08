<template>
    <main>
        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="container-fluid">
                    <div class="row col-12 work-heading">
                        <h3>Work History</h3>
                    </div>
                    <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" class="work-table" :fetch-data="fetchWorks">
                        <template v-slot:rows>
                            <tr><p v-if="!DataTable.data.length" style="color: #1c1c1c;font-size: 15px;">No Works Found</p></tr>
                            <tr v-for="work in DataTable.data" id="requests_row">
                                <td class="tb_company">
                                    <img :src="checkImage(work.user.profile_picture)" class="img-fluid"  />
                                    <article class="company_name"><strong>{{work.user.company_name}}</strong></article>
                                    <article class="company_email">{{work.user.email}}</article>
                                </td>
                                <td class="tb_amount">$ {{work.payment.amount}}</td>
                                <td><p class="work_date">{{formatDate(work.created_at)}}</p></td>
                                <td>
                                    <span :class="checkStatus(work.status)[0]" >{{work.status?"Complete":"Incomplete"}}</span>
                                </td>
                                <td class="tb_buttons">
<!--                                    v-if="requests.status!==1" v-on:click="viewDetails(requests.id)"-->
                                    <p v-show="!viewActions(work.payment.payment_status.status)">
                                        Payment Is <strong>Not Verified</strong><br/>
                                        Continue the work when it get's verified.
                                    </p>
                                    <button class="btn view" v-on:click="gotoWork(work.id)" ><i class="fa fa-eye"></i>View</button>
                                    <button class="btn delete" v-on:click="delWork(work.id)" ><i class="fa fa-trash"></i>Delete</button>
                                    <!-- <button class="btn view" v-show="viewActions(work.payment.payment_status.status)" ><i class="fa fa-eye"></i>View</button> -->
                                    <!-- <button class="btn delete" v-show="viewActions(work.payment.payment_status.status)"><i class="fa fa-trash"></i>Delete</button> -->
                                </td>
                            </tr>
                        </template>
                    </Datatable>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
    import {authApiConfig} from '../../helpers/helpers';
    import {mapState} from 'vuex';
    import Datatable from "./shared/Datatable";
    export default{
        name:"WorkHistory",
        props:{asset:String},
        components:{
            Datatable
        },
        computed:{
            ...mapState({
                auth: state=>state.auth,
            }),
        },
        data:function(){
            return{
                DataTable:{
                    data:[],
                    columns:['Company Name', 'Payment' , 'Payment Date' ,'Status', 'Actions'],
                    pagination: {
                        'current_page': 1
                    },
                },
                message:'',
                selected:{}
            }
        },
        created(){
            this.fetchWorks();
        },
        methods:{
            fetchWorks:function (){
                var authId=this.auth.user.id;
                axios.get(`/works/${authId}`,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((res)=>{
                        this.DataTable.data=res;
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
            formatDate:(date)=>{
                var date=new Date(date);
                var options={month:'numeric',day:'numeric',year:'numeric'};
                return date.toLocaleDateString("en-US",options);
            },
            checkImage:function(profileURL){
                return profileURL? this.asset+''+profileURL: this.asset+'assets/admin/images/placeholder.png';
            },
            checkStatus:(status)=>{
                switch (status) {
                    case 0:
                        return ["pending","Pending"];
                    case 1:
                        return ["accepted","Accepted"];
                }
            },
            viewActions:function(status){
                return status !== "Not Verified" ? true : false;
            },      
            gotoWork:function (item) {
                this.$router.push({name:'admin.work_details',params:{id:item}});
            },
            delWork:function (item) {
                axios.get(`/works/del_work/${item}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((res)=>{
                    console.log(res);
                    if(res == 1){
                        toastr.success('Deleted');
                        location.reload();
                    } else{
                        toastr.error('Error!');
                    }
                    console.log(res);
                }).catch((error)=>{
                    console.log(error);
                });
            },
            // selectRequest:function(request){
            //     this.selected=request;
            // },
            // viewDetails:function(id){
            //     return this.$router.push({name:'admin.request.exchange', params:{id:id}});
            // }
        }
    }
</script>
