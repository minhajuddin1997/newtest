<template>

    <main>
        <div class="right_col" role="main" style="min-height: 3091px;">
            <div class="">
                <div class="col-md-4 offset-4">
                    <div class="x_panel text-dark">
                        <div class="x_title">
                            <div class="row">
                                <div class="col-2">
                                        <img :src="asset+'assets/admin/uploads/images/189322112.png'" class="img-fluid">
                                </div>
                                <h2 class="font-weight-bolder">John Smith</h2>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <ul class="list-group">
                                <li v-for="item in repeat" class="list-group-item d-flex justify-content-between align-items-center">
                                    <strong>{{item.name}}</strong>
                                    <span>
                                    <span style="font-size: 12px;" :class="item.status=='Pending'?'text-white p-2 badge badge-danger badge-pill':'text-white p-2 badge badge-success badge-pill'">{{item.status}}</span>
                                    <span><button class="btn btn-link btn-sm"><i class="fa fa-eye"></i> View Details</button></span>
                                    </span>

                                </li>
                            </ul>

<!--                            <ul class="list-unstyled msg_list">-->
<!--                                <li >-->
<!--                                    <a>-->
<!--                                        <span>-->
<!--                                            <span style="font-size: 16px">{{item.name}}</span>-->
<!--                                            <span style="font-size: 12px; border-radius: 10px;margin-left: 95px;" :class="item.status=='Pending'?'text-white p-2 bg-danger':'text-white p-2 bg-success'">{{item.status}}</span>-->
<!--                                            <span><button class="btn btn-link btn-sm"><i class="fa fa-eye"></i> View Details</button></span>-->
<!--                                        </span>-->
<!--                                    </a>-->
<!--                                </li>-->

<!--                            </ul>-->


                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </main>

</template>

<script>
    export default {
        name:'OnGoingServices',
        props:{
            asset:String,
        },
        data:function(){
            return{
                repeat:[
                    {name:"Web Designing",status:'completed'},
                    {name:"Web Development",status:'Pending'},
                    {name:"App Development",status:'completed'},
                    {name:"UI\UX Design",status:'Pending'},
                ]
            }
        }
    }
</script>
