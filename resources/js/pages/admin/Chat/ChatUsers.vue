<template>
    <main>
        <div class="container-fluid">
            <div class="row list-group user" v-for="company in users">
                <a href="javascript:void(0)" v-on:click="selectUser(company)" class="list-group-item list-group-item-action flex-column align-items-start company-item">
                        <img :src="asset+company.profile_picture" style="height: 50px; width: 50px; float: left" class="img-fluid img-circle" />
                        <h6 class="list-inline-item text-dark ml-2"><strong>{{company.company_name}}</strong><span class="notification badge badge-info" v-if="company.count">{{company.count}}</span></h6>
                        <p class="text-dark" style="width: 80%; white-space: nowrap; overflow: hidden; margin-left: 58px !important;">{{company.description}}</p>
                </a>
            </div>
        </div>

    </main>
</template>

<style scoped>
    .row{
        margin-right: -14px;
        margin-left: -14px;
    }
    .user{
        border-radius: 0;
    }

    .user a{
        background-color: transparent;
        border-bottom:1px solid #ffffff;
        border-left: none; border-right: none;
    }


    .user .company-item:hover, .company-item:active, .company-item:focus, .company-item:visited{
        transition:all ease-in-out 0.2s;
        background-color: #ebebeb !important;
        border: none;
    }

    .user .company-item .notification{
        position: absolute;
        right: 20px;
    }


</style>

<script>
    import {authApiConfig} from "../../../helpers/helpers";

    export default {
        name:'ChatUsers',
        props:[
            'asset','auth','users'
        ],
        methods: {
            selectUser: function (user) {
                this.$emit('select',user);
            }
        }
    }
</script>
