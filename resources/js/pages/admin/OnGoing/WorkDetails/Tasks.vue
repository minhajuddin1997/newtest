<template>
        <Base :work_service_id="work_service_id">
            <template v-slot:details-header>
                <div class="row service-details-header">
                    <!-- Task Uploading Modal -->
                    <TaskModal id="createTask" title="Create Task">
                        <template v-slot:body>
                            <div class="container create-task-section">
                                <div class="col-12 pl-1 pr-1">
                                    <form>
                                        <div class="form-group">
                                            <label class="form-label" for="task">Enter Task</label>
                                            <textarea class="form-control" v-model="taskFormData.task" id="task" name="task" rows="1" required></textarea>
                                            <p class="text-danger" v-show="errors.task!==''">{{errors.task}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label" for="due_date">Due Date</label>
                                            <input type="datetime-local" class="form-control" v-model="taskFormData.dueDate" id="due_date" name="due_date" required />
                                            <p class="text-danger" v-show="errors.dueDate!==''">{{errors.dueDate}}</p>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label mr-3" >Status</label>
                                            <span class="pending pt-1 pb-1 detail-label">In Progress</span>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                        <template v-slot:footer>
                            <div class="upload-file-footer">
                                <article></article>
                                <button class="btn pending-btn" v-on:click="createTask">Create Task</button>
                                <button class="btn btn-delet" data-dismiss="modal">Cancel</button>
                            </div>
                        </template>
                    </TaskModal>
                    <!-- Task Uploading Modal -->

                    <!--Task Edit Modal-->
                    <TaskModal id="editTask" title="Update Task Progress">
                        <template v-slot:body>
                            <div class="container create-task-section">
                                <div class="col-12 pl-1 pr-1">
                                    <form>
                                        <div class="form-group">
                                            <label class="form-label mr-3" >Update Progress</label>
                                            <input type="number" class="form-control" v-model="taskFormData.progress" placeholder="Enter Percentage of Work" required />
                                            <p class="text-danger" v-show="errors.progress!==0">{{errors.progress}}</p>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </template>
                        <template v-slot:footer>
                            <div class="upload-file-footer">
                                <article></article>
                                <button class="btn pending-btn" v-on:click="updateTask">Update Progress</button>
                                <button class="btn btn-delet" data-dismiss="modal">Cancel</button>
                            </div>
                        </template>
                    </TaskModal>
                    <!--Task Edit Modal-->

                    <div class="col-lg-5 col-md-5 p-0">
                        <h2 class="service-header-heading">{{service.title}}</h2>
                    </div>
                    <div class="offset-lg-2 col-lg-5 offset-md-1 col-md-6 service-header-button p-0">
                        <button class="btn pending-btn task-button" data-toggle="modal" data-target="#createTask">Add Task</button>
                        <button class="btn accepted-btn msg-button" v-on:click="goToMessage()">Send Message</button>
                    </div>
                </div>
            </template>

            <template v-slot:details-body>
                <div class="row col-10 service-details-tasks-container">
                    <ul class="service-details-tasks col-12 p-0">
                        <li v-if="tasks.length>0" v-for="task in tasks"><i :class="task.status?'check-icon fa fa-check':'check-icon disable-check fa fa-check'"/>  {{task.task}}
                            <span :class="task.status?'accepted pt-1 pb-1 detail-label':'pending pt-1 pb-1 detail-label'">{{task.status?"Completed":"In Progress"}}</span>
                            <span class="detail-progress">{{task.progress}}%</span>
                            <span class="detail-tag-icon"><i class="fa fa-tag" /></span>
                            <button v-show="task.status===0" class="ml-3 btn btn-link text-dark" data-toggle="modal" v-on:click="editTask(task.id)" data-target="#editTask">Edit Progress</button>
                        </li>
                        <li v-if="tasks.length<=0"> No Task </li>
                    </ul>
                </div>
            </template>
        </Base>
</template>

<script>
    import {mapState} from 'vuex';
    import DetailsBase from "./DetailsBase";
    import Modal from "../../shared/Modal";
    import {authApiConfig} from "../../../../helpers/helpers";
    export default{
        name:'work-details',
        props:{
            asset:String
        },
        components:{
          Base:DetailsBase,
          TaskModal:Modal
        },
        computed:{
            ...mapState({
                auth:(state)=>state.auth
            }),
            work_service_id: function(){return this.$route.params.id;}
        },
        created(){
            this.fetchServiceTasks();
        },
        data:function () {
            return{
                tasks:[],
                service:{},
                taskFormData:{
                    dueDate:'',
                    task:'',
                    progress:0
                },
                errors:{
                    dueDate:'',
                    task:'',
                    progress:0,
                },
                id:0
            }
        },
        methods:{
            fetchServiceTasks:function(){
                axios.get(`/detail-service/tasks/${this.work_service_id}`,authApiConfig(this.auth.token))
                .then(res=>res.data)
                .then((data)=>{
                    this.tasks=data.tasks;
                    this.service=data.service;
                });
            },
            createTask:function(){
                var date="";
                if(this.taskFormData.dueDate===""){
                    date="";
                }else{
                    date=new Date(this.taskFormData.dueDate);
                    date=date.getFullYear().toString()+"-"+(date.getMonth()+1)+"-"+date.getDate()+" "+date.getHours()+":"+date.getMinutes()+":"+date.getSeconds();
                }
                var data={
                    task:this.taskFormData.task,
                    due_date:date,
                    user_id:this.auth.user.id,
                    progress:0,
                    status:0
                };
                axios.post(`/detail-service/tasks/${this.work_service_id}`,data,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((data)=>{
                        if(data.status){
                            swal("Success",data.success,"success");
                            this.errors={};
                            this.taskFormData={dueDate:"", task:"", progress:0};
                            this.fetchServiceTasks();
                            $("#createTask").modal("hide");
                        }else{
                            //defining errors
                            if(data.errors.due_date) {
                                this.errors.dueDate = data.errors.due_date[0];
                            }else {
                                this.errors.dueDate = "";
                            }
                            if(data.errors.task) {
                                this.errors.task = data.errors.task[0];
                            }else{
                                this.errors.task = "";
                            }
                        }
                    }).catch((error)=>{
                });
            },
            editTask:function(id){
                this.id=id;
            },
            updateTask:function(){
                var data={
                    progress: this.taskFormData.progress,
                    status: 0
                };
                if(this.taskFormData.progress==100){
                    data.status=1;
                }
                axios.put(`/detail-service/tasks/update/${this.id}`,data,authApiConfig(this.auth.token))
                    .then(res=>res.data)
                    .then((data)=>{
                        if(data.status){
                            swal("Success",data.success,"success");
                            this.errors={};
                            this.taskFormData={dueDate:"", task:"", progress:0};
                            this.fetchServiceTasks();
                            $("#editTask").modal("hide");
                        }else{
                            //defining errors
                            if(data.errors.progress) {
                                this.errors.progress = data.errors.progress[0];
                            }else {
                                this.errors.progress = "";
                            }
                        }
                    }).catch((error)=>{
                });
            },
            goToMessage:function () {
                this.$router.push({name:'admin.messages'});
            }
        }
    }
</script>
