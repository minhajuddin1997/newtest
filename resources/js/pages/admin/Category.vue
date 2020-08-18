<template>

    <main>
        <!--  Modal -->
        <div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <form v-on:submit="AddorEditCategory" id="categoryForm">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title text-dark" id="categoryModalLongTitle"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-12">
                                <label for="name">Name</label>
                                <input type="text" id="name" name="name" v-model="formData.name" class="form-control" required>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" >Save Changes</button>
                    </div>
                </div>
            </div>
                </form>
            </div>
        </div>
        <!--   End Modal    -->

        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Categories</h3>
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
                                        <button class="btn btn-primary" v-on:click="openAddCategory">Add Category</button>
                                        <Datatable :pagination="DataTable.pagination" :data="DataTable.data" :columns="DataTable.columns" :fetch-data="fetchCategory">
                                            <template v-slot:rows>
                                                <tr v-for="category in DataTable.data">
                                                    <td>{{category.id}}</td>
                                                    <td>{{category.name}}</td>
                                                    <td>
                                                        <button type="button" @click="openEditCategory(category)" :class="'btn btn-success'">
                                                            <i class="fa fa-pencil"></i>
                                                        </button>
                                                        <button type="button" v-on:click="deleteCategory(category)" :class="'btn btn-danger'">
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
    import Datatable from "./shared/Datatable";
    import {authApiConfig} from "../../helpers/helpers";
    import {mapState} from 'vuex';
    export default {
        name:'Category',
        components:{
            Datatable
        },
        data:function(){
            return{
                DataTable:{
                    data:[],
                    columns:['ID', 'Name', 'Actions'],
                    pagination: {
                        'current_page': 1
                    }
                },
                selected:0,
                formData:{
                    name:''
                },
                action:''
            }
        },
        created() {
            this.fetchCategory();
        },
        computed:{
            ...mapState({
                auth:state=>state.auth,
            }),
        },
        mounted(){
            var self=this;
            $(document).ready(function(){
                $('#categoryModal').on('hidden.bs.modal', function(){
                    //catch the native bootstrap close event and trigger yours
                    self.fetchCategory();
                    self.action='';
                    self.formData.name='';
                    $("#categoryForm").trigger('reset');
                });
            });
        },
        methods:{

            fetchCategory:function(){
                axios.get('/categories?page='+this.DataTable.pagination.current_page,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((response)=>{
                        this.DataTable.data=response.data.data;
                        this.DataTable.pagination=response.pagination;
                    }).catch((error)=>{
                    console.log(error);
                });
            },
            openAddCategory:function(){
                this.action='add';
                $("#categoryModalLongTitle").text('Add New Category');
                $("#categoryModal").modal('show');
            },
            AddorEditCategory:function(e){
                e.preventDefault();
                var categoryData = {...this.formData};
                if (this.action==='add') {
                    axios.post('/categories', categoryData, authApiConfig(this.auth.token))
                        .then(res => res.data)
                        .then((response) => {
                            if (response[0] === 'success') {
                                swal("Great!", response[1], "success");
                                this.fetchCategory();
                                $("#categoryModal").modal('hide');
                            }
                        }).catch((error) => {
                        console.log(error);
                    });
                }
                else{
                    axios.put('/categories', {...categoryData,id:this.selected}, authApiConfig(this.auth.token))
                        .then(res => res.data)
                        .then((response) => {
                            if (response[0] === 'success') {
                                swal("Great!", response[1], "success");
                                this.fetchCategory();
                                $("#categoryModal").modal('hide');
                            }
                        }).catch((error) => {
                        console.log(error);
                    });
                }

            },
            openEditCategory:function (category) {
                this.action='edit';
                this.selected=category.id;
                this.formData.name=category.name;
                $("#categoryModalLongTitle").text('Edit Service');
                $("#categoryModal").modal('show');
            },
            deleteCategory:function(category){
                axios.delete(`/categories/${category.id}`,authApiConfig(this.auth.token))
                    .then(res => res.data)
                    .then((response) => {
                        if (response[0] === 'success') {
                            swal("Great!", response[1], "success");
                            this.fetchCategory();
                        }
                    }).catch((error) => {
                    console.log(error);
                });
            }


        }
    }
</script>
