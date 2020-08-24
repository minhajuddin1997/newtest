<template>

    <main>
        <div class="right_col" role="main" style="min-height: 3091px;">
            <div class="">
                <div class="col-md-4 offset-4">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>On Going Work</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <ul class="list-unstyled msg_list">
                                <li v-for="item in repeat">
                                    <a v-on:click="goToServices(item)">
                                        <span class="image">
                                        <img :src="asset+'assets/admin/uploads/images/189322112.png'" alt="img">
                                        </span>
                                        <span>
                                            <span style="font-size: 18px">John Smith</span>
                                            <span class="font-weight-bold">- {{item}} Services</span>
                                        </span>
                                        <span class="message">
                                            Film festivals
                                        </span>
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
    export default {
        name:'OnGoingWork',
        props:{
            asset:String,
        },
        data:function(){
            return{
                repeat:[1,2,3,4]
            }
        },
        methods:{
            goToServices:function (item) {
                this.$router.push({name:'admin.on_going_services',params:{id:item}});
            }
        }
    }
</script>
