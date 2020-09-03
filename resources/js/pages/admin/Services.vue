<template>
    <div class="right_col" role="main" style="min-height: 990px;">

        <!-- Service Modal -->
        <div class="modal fade" id="serviceModal" tabindex="-1" role="dialog"  aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form v-on:submit="AddorEditService" id="serviceForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="serviceModalTitle"> Add New Service </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="title">Title</label>
                                <input type="text" id="title" v-model="formData.title" class="form-control" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="description">Description</label>
                                <textarea id="description" v-model="formData.description"  class="form-control"></textarea>
                            </div>
                            <div class="form-group col-12">
                                <label for="deliverables">Deliverables (Comma Separated List)</label>
                                <input type="text" id="deliverables" v-model="formData.deliverables" class="form-control" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="amount">Service Charges</label>
                                <input type="number" id="amount" v-model="formData.amount" class="form-control" required>
                            </div>
                            <div class="form-group col-12">
                                <label for="description">Required or Offered</label>
                                <select class="form-control" v-model="formData.required_offered">
                                    <option value="0" :selected="formData.category_id==0">Required</option>
                                    <option value="1" :selected="formData.category_id==1">Offered</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Status of Service</label>
                                <select class="form-control" v-model="formData.status">
                                    <option value="1" :selected="formData.category_id=='1'">Active</option>
                                    <option value="0" :selected="formData.category_id=='0'">De-Active</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Category</label>
                                <select class="form-control" v-model="formData.category_id">
                                    <option v-for="category in data.category" :value="category.id" :selected="formData.category_id==category.id">{{category.name}}</option>
                                </select>
                            </div>

                            <div class="form-group col-12">
                                <label>Select a title image for the service.</label>
                                <input type="file" class="form-control" name="titleImage" v-on:change="readImage" />
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" >Save changes</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
        <!-- End Service Modal -->


        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3 class="main-title"> Your Services </h3>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12">
                    <div class="x_panel" style="background: transparent !important;border: none">
                        <div class="x_content" style="display: block;">


                            <h3 class="main-title">Services You Offer</h3>
                            <div class="row">
                                <div class="col-md-2 pt-2" >
                                    <div class="card text-center new-service-box" v-on:click="openAddService" style="border-radius: 30px !important; ">
                                        <div class="card-body">
                                            <div class="card-title text-center new-service-text">
                                                <i class="fa fa-plus"></i>
                                                <p>
                                                    <span>Add New</span>
                                                    <span>Service</span>
                                                </p>
                                            </div>
                                        </div>
                                        <div class="card-footer" style="background-color:transparent;border: none">
                                        </div>
                                    </div>
                                </div>


                                <!-- List Offered Services -->
                                <div class="col-md-2 pt-2" v-for="service in data.services_offered">
                                    <div class="card text-center text-dark service-box" >
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h5 class="font-weight-bold">{{service.title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-0 bottom-buttons" style="background-color:white;">
                                        <div class="btn-group-sm d-flex">
                                            <button type="button" class="btn btn-default w-100 pt-2 pb-2" v-on:click="openEditService(service)"><i class="fa fa-pencil"></i> Edit</button>
                                            <button type="button" class="btn btn-default w-100 pt-2 pb-2" v-on:click="deleteService(service)"><i class="fa fa-trash"></i> Delete</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br/><br/>
                            <h3 class="main-title">Services You Want</h3>
                            <div class="row">
                                <!-- List Required Services -->
                                <div class="col-md-2 pt-2" v-for="service in data.services_required">
                                    <div class="card text-center text-dark service-box" >
                                        <div class="card-body">
                                            <div class="card-title">
                                                <h5 class="font-weight-bold">{{service.title}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer p-0 bottom-buttons" style="background-color:white;">
                                        <div class="btn-group-sm d-flex">
                                            <button type="button" class="btn btn-default w-100 pt-2 pb-2" v-on:click="openEditService(service)"><i class="fa fa-pencil"></i> Edit</button>
                                            <button type="button" class="btn btn-default w-100 pt-2 pb-2" v-on:click="deleteService(service)"><i class="fa fa-trash"></i> Delete</button>
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

</template>

<script>
    import {mapState} from "vuex";
    import {authApiConfig} from "../../helpers/helpers";
    import {actions} from "../../store/actions";
    export default {
        name:'Services',
        props:{
            asset:String,
        },
        computed:{
            ...mapState({
                auth:state=>state.auth,
            }),
        },
        data:function(){
            return{
                data:[],
                formData:{
                    title:'',
                    titleImage:'',
                    description:'',
                    deliverables:'',
                    amount:0,
                    required_offered:1,
                    status:1,
                    user_id:0,
                    category_id:0
                },
                action:'',
                selected:0,
            }
        },
        created() {
            this.fetchServices();
        },
        mounted(){
            var self=this;
            $(document).ready(function(){
                $('#serviceModal').on('hidden.bs.modal', function(){
                    //catch the native bootstrap close event and trigger yours
                    self.fetchServices();
                    self.formData.title='';
                    self.formData.titleImage='';
                    self.formData.description='';
                    self.formData.deliverables='';
                    self.formData.amount=0;
                    self.formData.required_offered=1;
                    self.formData.status=1;
                    self.formData.user_id=0;
                    self.formData.category_id=0;
                    self.action='';
                    $("#serviceForm").trigger('reset');
                });
            });
        },
        methods:{

            fetchServices:function(){
                axios.get(`/services/${this.auth.user.id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((response)=>{
                    this.data=response;
                }).catch((error)=>{
                    console.log(error);
                });
            },
            openAddService:function(){
                this.action='add';
                $("#serviceModalTitle").text('Add New Service');
                $("#serviceModal").modal('show');
            },
            AddorEditService:function(e){
                e.preventDefault();
                var serviceData = {...this.formData,user_id:this.auth.user.id};
                if (this.action==='add') {
                    axios.post('/services', serviceData, authApiConfig(this.auth.token))
                        .then(res => res.data)
                        .then((response) => {
                            if (response[0] === 'success') {
                                swal("Great!", response[1], "success");
                                this.fetchServices();
                                $("#serviceModal").modal('hide');
                            }
                        }).catch((error) => {
                        console.log(error);
                    });
                }
                else{
                    axios.put('/services', {...serviceData,id:this.selected}, authApiConfig(this.auth.token))
                        .then(res => res.data)
                        .then((response) => {
                            console.log(response);
                            if (response[0] === 'success') {
                                swal("Great!", response[1], "success");
                                this.fetchServices();
                                $("#serviceModal").modal('hide');
                            }
                        }).catch((error) => {
                        console.log(error);
                    });
                }

            },
            readImage:function (e) {
                var reader=new FileReader();
                reader.onload=(e)=>{
                    this.formData.titleImage=e.target.result;
                };
                reader.readAsDataURL(e.target.files[0]);
            },
            openEditService:function (service) {
                this.action='edit';
                this.selected=service.id;
                this.formData.title=service.title;
                this.formData.description=service.description;
                this.formData.deliverables=JSON.parse(service.deliverables).join(',');
                this.formData.amount=service.amount;
                this.formData.required_offered=service.required_offered;
                this.formData.status=service.status;
                this.formData.user_id=service.user_id;
                this.formData.category_id=service.category_id;
                $("#serviceModalTitle").text('Edit Service');
                $("#serviceModal").modal('show');
            },
            deleteService:function(service){
                axios.delete(`/services/${service.id}`,authApiConfig(this.auth.token))
                    .then(res => res.data)
                    .then((response) => {
                        if (response[0] === 'success') {
                            swal("Great!", response[1], "success");
                            this.fetchServices();
                        }
                    }).catch((error) => {
                        console.log(error);
                    });
            }


        }
    }
</script>
