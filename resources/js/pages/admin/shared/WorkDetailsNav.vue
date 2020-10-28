<template>
        <nav class="nav nav-pills nav-justified">
            <a :class="activeLink('admin.work-service.tasks')" href="javaScript:void(0);" v-on:click="loadTasks()">Tasks</a>
            <a :class="activeLink('admin.work-service.milestones')+' disabled'" href="#">Milestones</a>
            <a :class="activeLink('admin.work-service.files')" href="javaScript:void(0);" v-on:click="loadFiles()">Files</a>
        </nav>
</template>

<script>
    export default {
        name:"WorkDetailNav",
        props:[
            "work_service_id","route"
        ],
        created() {
            this.activeLink() ;
        },
        //active logic
        methods:{
            activeLink:function (route_name) {
                return this.route.name===route_name ? "nav-link active" : "nav-link";
            },
            loadFiles:function () {
                return this.$router.push({name:'admin.work-service.files',params:{id: this.work_service_id}});
            },
            loadTasks:function () {
                return this.$router.push({name:'admin.work-service.tasks',params:{id: this.work_service_id}});
            }
        }
    }
</script>
