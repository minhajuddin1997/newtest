<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-bannerInner o-hidden green-bg p-0">
            <div class="banner-bgInner" :data-bg-img="asset + 'assets/front/images/bg/01.jpg'"></div>
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
                        <div class="col-md-5">
                            <h2><span>How</span> does it work?</h2>
                            <p>
                                Swopers was created by a small team of techies who understand that businesses need to save money without hindering their growth and potential. Our idea was to create an incredibly simple platform that allows businesses to trade services to one another.<br/>
                                Your business is your dream, and you’re passionate about the services you provide. Most business owners and entrepreneurs feel the same way. There’s something to be said for knowing that a service you created – something that is your life’s dream – helped other business owners realize their visions.<br/>
                                Swopers isn’t just about saving money. It’s about making the business world a better place one service at a time through bartering. Here’s how it works.

                            </p>
                        </div>
                        <div class="col-md-4 text-center">
                            <img :src="asset + 'assets/front/images/how-it-works-img.png'" class="img-fluid wow fadeInRight">
                        </div>
                    </div>
                </div>
            </section>
            <!--How does it work? end-->

            <!--Video Content Start-->
            <section class="contTwo">
                <div class="container-fluid pr-lg-0">
                    <div class="row align-items-center bgTwo">
                        <div class="col-lg-4 col-12 ml-auto wow fadeInLeft">
                            <div class="section-title">
                                <div class="section-title">
                                    <h2><strong>How</strong> easy it is?</h2>
                                    <p>
                                        It’s really that simple. In three short, simple steps, you can obtain the services you need, help a fellow business owner with the services they need, and help both companies grow.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-12 mt-5 mt-lg-0 wow fadeInRight">
                            <div class="pos-r imgTwo">
                                <div class="img-bg">

                                </div>
                                <img :src="asset + 'assets/front/images/play-btn-green.png'" class="playBtn wow fadeInRight">
                                <img :src="asset + 'assets/front/images/laptop-img-2.png'">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Video Content End-->

            <!--Process start-->
            <section class="ourProcess">
                <div class="container border-b padd-b">
                    <div class="row">
                        <div class="col-md-12">
                            <h2><span>Our</span> process</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-12 p1-mt wow fadeInUp">
                            <img :src="asset + 'assets/front/images/p-1.png'" class="img-fluid">
                            <p><strong>Create your account.</strong> The first step is to create your Swopers account by providing some information about yourself, your company, and the services you provide. </p>
                        </div>
                        <div class="col-lg-4 col-12 p2-mt wow fadeInDown">
                            <img :src="asset + 'assets/front/images/p-2.png'" class="img-fluid">
                            <p><strong>Look for the services you need.</strong>  After you create your account, you can start browsing the many companies and services listed in the Swopers directory to find exactly what you need.  </p>
                        </div>
                        <div class="col-lg-4 col-12 p3-mt wow fadeInUp">
                            <img :src="asset + 'assets/front/images/p-3.png'" class="img-fluid">
                            <p><strong>Start bartering and trading.</strong> When you’ve spotted a company that seems like a good fit, reach out to them and let them know what you’re interested in – and what you can offer. </p>
                        </div>
                    </div>
                </div>
            </section>
            <!--Process end-->


            <!--Manage Business Start-->
            <section class="manageBusiness secPad-b-none">
                <div class="container border-b padd-b">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>One Dashboard for All Your Trades</h2>
                            <p>
                                Bartering sometimes requires a level of communication that exchanging currency does not. After all, you probably want to know exactly what you’ll receive, and you’ll also want to know exactly what services you’ll need to provide to get it. The Swopers dashboard gives you access to all of your interactions and service trade requests in a single, user-friendly interface.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12 col-12 p1-mt wow fadeInRight">
                            <img :src="asset + 'assets/front/images/screen-3.jpg'" class="img-fluid">
                        </div>

                    </div>
                </div>
            </section>
            <!--Manage Business Start-->

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
        name:'HowItWorks',
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
