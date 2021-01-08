<style>
.footer  {
    display:none;
}
</style>
<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-banner o-hidden black-bg p-0" style="min-height: 1009px">
        <div class="banner-bgLogin" :data-bg-img="asset+'assets/front/images/bg/04.jpg'"></div>
        <div class="align-center b-pl">
            <div class="row">
                <div class="col-sm-1" ><img :src="asset+'assets/front/images/tick_success.png'" width="100"></div>
                <div class="col-sm-5" ><br><h3 style="margin-left:25px;color:white;">Your Account Has Been Verified.</h3></div>
            </div>
        </div>
        </section>
        <!--hero section end-->
    </div>
</template>
<script>
    export default {
        name:'AuthenticateLogin',
        props:{
            asset:String
        },
        created() {
            setTimeout(function () {
                var backImg = $(".banner-bgLogin").attr("data-bg-img");
                $(".banner-bgLogin").css('background-image', 'url(' + backImg + ')');
            },1);
            var urls = this.$route.query.email + "," +this.$route.query.hash;
            this.fetchAuth(urls);
        },
        data:function(){
          return{
              email:'',
              password:'',
              errors:''
          }
        },
        methods:{
            fetchAuth:function (data){
                axios.get(`/authenticate_login?v=${data}`)
                    .then(res=>res.data)
                    .then((res)=>{
                        if(res == 1) {
                            toastr.success('Account Verified');
                            
                        } else {
                            toastr.error('Error! Link Expired.');
                        }
                    }).catch((error)=>{
                    console.log(error.response);
                });
            },
        }
    }
</script>