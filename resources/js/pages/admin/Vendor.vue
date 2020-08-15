<template>
    <main>

        <!-- Edit Modal -->
        <div class="modal fade" id="vendorEditForm" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="exampleModalLongTitle">Edit Company</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                            <div class="form-group">
                                <label for="privacy_policy">Privacy Policy</label>
                                <textarea id="privacy_policy" name="privacy_policy" class="form-control" rows="3" required></textarea>
                            </div>
                            <div class="form-group">
                                <label for="terms_and_conditions">Terms And Conditions</label>
                                <textarea id="terms_and_conditions" name="terms_and_conditions" class="form-control" rows="3" required></textarea>
                            </div>

                            <div class="form-group">
                                <label for="how_to_use">How To Use</label>
                                <textarea id="how_to_use" name="how_to_use" class="form-control" rows="3" required></textarea>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button"  class="btn btn-primary" @click="updateForm">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
        <!--   End Edit Modal    -->

        <!-- Add Modal -->
        <div class="modal fade" id="vendorForm" tabindex="-1" role="dialog"  data-backdrop="static" data-keyboard="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="vendorModalLongTitle">Company Form</h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-6">
                                <label for="company_name">Company Name</label>
                                <input type="text" id="company_name" v-model="formData.company_name" class="form-control" required>
                            </div>
                            <div class="form-group col-6">
                                <label for="conatct_number">Contact Number</label>
                                <input type="text" id="conatct_number" v-model="formData.contact_number" class="form-control" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="email">Email</label>
                                <input type="text" id="email" v-model="formData.email" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <p class="text-danger" :style="{fontSize: '14px', fontWeight: 'bold'}" v-if="errors" v-for="error in errors" v-text="error"></p>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button"  class="btn btn-primary" @click="addVendor">Create Profile</button>
                    </div>
                </div>
            </div>
        </div>
        <!--   End Add Modal    -->


        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Company's / Vendors</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 ">
                        <div class="x_panel">
                            <div class="x_title">

                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button class="btn btn-primary" data-toggle="modal" data-target="#vendorForm">Add Company</button>
                                        <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" :fetch-data="fetchVendors">
                                                <template v-slot:rows>
                                                    <tr v-for="vendor in DataTable.data">
                                                        <td>{{vendor.id}}</td>
                                                        <td>{{vendor.first_name}}</td>
                                                        <td>{{vendor.last_name}}</td>
                                                        <td><img width="65" :src="checkImage(vendor.profile_picture)"/></td>
                                                        <td>{{vendor.email}}</td>
                                                        <td>{{vendor.contact_number}}</td>
                                                        <td>
                                                            <select class="form-control" v-on:change="(e)=>profileStatus(vendor.id,e)">
                                                                <option v-for="status in DataTable.profile_status"
                                                                        :selected="status==vendor.profile_status"
                                                                        >{{status}}</option>
                                                            </select>
                                                        </td>
                                                        <td>{{vendor.company_name}}</td>
                                                        <td><a :href="vendor.website">{{vendor.website}}</a></td>
                                                        <td>
                                                            <button type="button"
                                                                    v-on:click="changeStatus(vendor.id,vendor.status)"
                                                                    :class="vendor.status?'btn btn-danger':'btn btn-primary'">
                                                                {{vendor.status?' Block':' Unblock'}}
                                                            </button>
                                                            <button type="button" @click="openEditForm(vendor)" :class="'btn btn-success'">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                            <button type="button" v-on:click="profileDelete(vendor.id)" :class="'btn btn-danger'">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </template>
                                        </Datatable>
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
    import {authApiConfig} from "../../helpers/helpers";
    import {mapState} from 'vuex';
    import  Datatable from './shared/Datatable';
    export default {
        name: 'Vendor',
        props:{
            asset:String
        },
        components:{
          Datatable
        },
        computed:{
            ...mapState({
               auth:state=>state.auth
            }),
        },
        data:function(){
          return{
                DataTable:{
                    data:[],
                    columns:['ID','First Name','Last Name', 'Profile Picture', 'Email', 'Contact Number', 'Profile Status', 'Company Name', 'Website', 'Actions'],
                    pagination: {
                        'current_page': 1
                    },
                    profile_status:[]
                },
                selected:{},
                formData:{
                    company_name:'',
                    contact_number:'',
                    email:'',
                    password:''
                },
              errors:[]
          }
        },
        created() {
            this.fetchVendors();
        },

        methods:{
            fetchVendors:function(){
                axios.get('/vendors?page='+this.DataTable.pagination.current_page,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.DataTable.data=response.data.data;
                        this.DataTable.pagination=response.pagination;
                        this.DataTable.profile_status=response.profile_status;
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            checkImage:function(profileURL){
                return profileURL? this.asset+''+profileURL: this.asset+'assets/admin/images/placeholder.png';
            },
            changeStatus: function(id,status){
                this.statusApiCall(id,{status:!status});
            },
            openEditForm:function (vendor) {
                this.selected=vendor;
                $("#privacy_policy").val(this.selected.privacy_policy);
                $("#terms_and_conditions").val(this.selected.terms_and_conditions);
                $("#how_to_use").val(this.selected.how_to_use);
                $("#vendorEditForm").modal('show');
            },
            updateForm:function () {
                var privacy_policy=$("#privacy_policy").val();
                var terms_and_conditions=$("#terms_and_conditions").val();
                var how_to_use=$("#how_to_use").val();
                var data={privacy_policy, terms_and_conditions, how_to_use};
                axios.put('/user/info/update/'+this.selected.id,data,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((response)=>{
                    if(response[0]==='success'){
                        this.fetchVendors();
                        $("#vendorEditForm").modal('hide');
                        swal("Great!",response[1],"success");
                    }

                }).catch((error)=>{
                    console.log(error);
                });
            },
            statusApiCall:function(id,data){
                axios.put('/user/status/update/'+id,data,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        if(response[0]==='success'){
                            this.fetchVendors();
                            swal("Great!",response[1],"success");
                        }

                    }).catch((error)=>{
                    console.log(error);
                });
            },
            profileStatus:function(id,e){
                this.statusApiCall(id,{profile_status:e.target.value});
            },
            profileDelete:function (id) {
                axios.delete('/user/'+id,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        if(response[0]==='success'){
                            this.fetchVendors();
                            swal("Great!",response[1],"success");
                        }

                    }).catch((error)=>{
                    console.log(error);
                });
            },
            addVendor:function () {
                axios.post('/user',this.formData,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.errors=[];
                        if(response[0]==='success'){
                            this.fetchVendors();
                            this.formData.company_name='';
                            this.formData.contact_number='';
                            this.formData.email='';
                            this.formData.password='';
                            $("#vendorForm").modal('hide');
                            swal("Great!",response[1],"success");
                        }else{
                            var error=response[1];
                            swal('Stop!',"Some errors to correct.","error");
                            if(typeof error === "object"){
                                if(error.email){this.errors.push(error.email[0]);}
                                if(error.password){this.errors.push(error.password[0]);}
                                if(error.company_name){this.errors.push(error.company_name[0]);}
                                if(error.contact_number){this.errors.push(error.contact_number[0]);}
                            }else {
                                this.errors.push(error);
                            }
                        }

                    }).catch((error)=>{
                    console.log(error);
                });
            }
        }
    }
</script>
