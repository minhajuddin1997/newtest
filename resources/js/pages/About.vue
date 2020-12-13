<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-bannerInner o-hidden green-bg p-0">
            <div class="banner-bgInner"  :data-bg-img="asset + 'assets/front/images/bg/03.jpg'"></div>
            <div class="align-center b-pl">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h1 class="head-1">Money is overrated. </h1>
                            <p class="text-light pra-1">
                                There’s a better way to get the services you need.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero section end-->



        <!--body content start-->
        <div id="main-page" class="page-content">

            <!--How does it work? start-->
            <section class="hdw secPad-b-none">
                <div class="container border-b padd-b">
                    <div class="row justify-content-center">
                        <div class="col-md-4">
                            <h2><span>Who</span> we are</h2>
                            <p>
                                They say money doesn’t buy happiness, and some people even say money is the root of all evil. You need money to buy a house. You need money to buy a car. You even need money to pay the kid down the street to mow the lawn. Currency is an important part of our lives, and while it may not really be the root of all evil, it’s pretty clear that our lives would be a little better if we could stop worrying so much about who we’re paying for which services.
                                What if you could get the things you needed without currency? How would that change your life?

                            </p>
                        </div>
                        <div class="col-md-6 text-center">
                            <img :src="asset + 'assets/front/images/whoweare-img.png'" class="img-fluid wow fadeInRight">
                        </div>
                        <div class="col-md-10">
                            <p>
                                The truth is that money is an unnecessary step in many transactions we make every day. Think about it like this: Let’s say you need someone to write blogs for your graphic design company. Normally, to make this happen, you would pay a blogger or an agency to write your blogs for you, and you would pay the agency. Then, the agency would use that money to pay other companies for the services they need.
                                In other words, in many aspects of your everyday life, money is merely a middleman. Fortunately, there’s a better and more efficient way to get things done.
                                Swopers is a platform that eliminates the middleman – money – and allows companies just like yours to provide your specialized services to other companies in exchange for their services. Does your graphic design company need some blog posts? Swopers can connect you to a blogger or marketing agency that needs new logos. Do you need a meal catered for your construction company picnic? Swopers can help you find a caterer who needs some help with their lighting. The possibilities are truly endless.

                            </p>
                        </div>
                    </div>
                </div>
            </section>
            <!--How does it work? end-->

            <!--Connect start-->
            <section class="connect secPad-b-none">
                <div class="container border-b padd-b">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <h2>Connect with other businesses.</h2>
                            <p>Swopers is much like an alternative to the Yellow Pages or even a Google search for a service, but without the expectation of currency changing hands. Every business and company you’ll find at Swopers is here because they want to barter with you. </p>
                            <a class="btn wow fadeInUp wh1-mt btnSignup" v-on:click="()=>this.$router.push({name:'register'})"><span>Free Sign Up</span></a>

                        </div>
                        <div class="col-md-5 text-center">
                            <img :src="asset + 'assets/front/images/connect-img.png'" class="img-fluid wow fadeInRight">
                        </div>
                    </div>
                </div>
            </section>
            <!--Connect end-->



        </div>

        <!--body content end-->
    </div>
</template>
<script>
    export default {
        name:'About',
        props:{
            asset:String
        },
        created() {
            setTimeout(function () {
                var backImg = $(".banner-bgInner").attr("data-bg-img");
                $(".banner-bgInner").css('background-image', 'url(' + backImg + ')');
            },1);
        }
    }
</script>
