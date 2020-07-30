<template>
    <div>

        <Header :asset="asset" v-if="showFrontHeader"/>
        <AdminHeader :asset="asset" v-if="showAdminHeader" />
        <router-view :asset="asset" ></router-view>
        <AdminFooter v-if="showAdminFooter" />
        <Footer :asset="asset" v-if="showFrontFooter" />
    </div>
</template>
<script>
    import Header from './shared/Header';
    import Footer from './shared/Footer';
    import AdminHeader from './shared/admin/Header';
    import AdminFooter from './shared/admin/Footer'
    export default {
        name:'Main',
        props:{
          asset : String,
        },
        computed:{
            showFrontFooter:function(){
                return (this.$route.name=='login') || (this.$route.name=='register') || (this.$route.path.indexOf('admin')>-1)?false:true;
            },
            showFrontHeader:function () {
                return this.$route.path.indexOf('admin')>-1 ? false :true;
            },
            showAdminFooter:function(){
                return (this.$route.path.indexOf('admin')>-1) ? true : false;
            },
            showAdminHeader:function () {
                return (this.$route.path.indexOf('admin')>-1) ? true :false;
            }
        },
        components:{
            AdminHeader,
            AdminFooter,
            Header,
            Footer
        }
    }
</script>
