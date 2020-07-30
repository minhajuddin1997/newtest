<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-banner o-hidden black-bg p-0" style="min-height: 1009px;">
            <div class="banner-bgLogin" :data-bg-img="asset + 'assets/front/images/bg/04.jpg'"></div>
            <div class="align-center b-pl">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-5">
                            <h1 class="head-2">Welcome</h1>
                            <p class="text-light pra-2">Please Enter details to create your account</p>

                            <form class="ls-form">
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Name">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="form-control" placeholder="Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Password">
                                </div>
                                <button type="submit" class="btn btnSend">Sign Up</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero section end-->
    </div>
</template>

<script>
    export default {
        name:'Register',
        props:{
            asset:String
        },
        created() {
            setTimeout(function () {
                var backImg = $(".banner-bgLogin").attr("data-bg-img");
                $(".banner-bgLogin").css('background-image', 'url(' + backImg + ')');
            },1);
        }
    }
</script>
