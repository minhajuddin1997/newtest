<template>
    <div>
        <!--hero section start-->
        <section class="banner fullscreen-banner o-hidden green-bg p-0" style="min-height: 1009px;">
            <div class="banner-bg" id="titleImage" :data-bg-img="asset + 'assets/front/images/bg/02.jpg'"></div>
            <div class="align-center b-pl">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-7">
                            <h1 class="head-1">Money is overrated. Bartering is underrated. Swopers aims to change that.</h1>
                            <p class="text-light pra-1">Swopers is a platform dedicated to cutting out the middleman (money) by helping companies exchange services instead of currencies.</p>
                            <!--  <a class="btn btn-white" href="#"><span>Learn More <i class="fas fa-plus-square"></i></span></a> -->


                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search" aria-label="Search" aria-describedby="basic-addon2">
                                <div class="input-group-append">
                                    <button class="btn btnSearch" type="button"><i class="fas fa-search"></i></button>
                                </div>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!--hero section end-->

        <!--body content start-->
        <div id="main-page" class="page-content">

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
                            <p><strong>Create Your Account</strong> – Fill in your details, then explain who you are and what you do. Do you bake wedding cakes? Renovate houses? Are you a plumber? Tell the Swopers community what you can provide! </p>
                        </div>
                        <div class="col-lg-4 col-12 p2-mt wow fadeInDown">
                            <img :src="asset + 'assets/front/images/p-2.png'" class="img-fluid">
                            <p><strong>Browse for Services</strong> – Search the Swopers directory to find companies offering the services you need. What are you looking for? A catered meal? An inventory audit? You can find virtually any service here. </p>
                        </div>
                        <div class="col-lg-4 col-12 p3-mt wow fadeInUp">
                            <img :src="asset + 'assets/front/images/p-3.png'" class="img-fluid">
                            <p><strong>Start Trading</strong> – When you find the perfect company and service, connect with them to trade your own services for theirs. It’s really that simple, and Swopers makes it a breeze to barter for services over and over again.  </p>
                        </div>
                    </div>
                </div>
            </section>
            <!--Process end-->


            <!--We Help start-->
            <section class="weHelp secPad-b-none">
                <div class="container border-b padd-b">
                    <div class="row">
                        <div class="col-md-7">
                            <h2>We help all industries exchange services.</h2>
                            <div class="row">
                                <div class="col-lg-4 col-12 wow fadeInUp wh1-mt">
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/financial-icon.png'">
                                                <p>Financial</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/goverment.png'">
                                                <p>Goverment</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 wow fadeInDown wh2-mt">
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/healthcare-1.png'">
                                                <p>Healthcare</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/retail.png'">
                                                <p>Retail</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-12 wow fadeInUp wh3-mt">
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/manufacturing.png'">
                                                <p>Manufacturing</p>
                                            </div>
                                        </a>
                                    </div>
                                    <div class="serviceBox wh4-mt">
                                        <a href="javascript:void(0)">
                                            <div class="hIcon">
                                                <img :src="asset + 'assets/front/images/media.png'">
                                                <p>Media</p>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 text-center">
                            <img :src="asset + 'assets/front/images/help-img.png'" class="img-fluid wow fadeInRight">
                            <a class="btn wow fadeInUp wh1-mt btnSeeAllindustries" href="industries.html"><span>See All Industries</span></a>
                        </div>
                    </div>
                </div>
            </section>
            <!--We Help end-->

            <!--Video Content Start-->
            <section class="contOne">
                <div class="container-fluid pr-lg-0">
                    <div class="row align-items-center bgOne">
                        <div class="col-lg-4 col-12 ml-auto wow fadeInLeft">
                            <div class="section-title">
                                <div class="section-title">
                                    <h2>The Perfect Service Bartering Platform for All Industries</h2>
                                    <p>Swopers is a platform that eliminates the middleman (money) and allows companies just like yours to provide specialized services to other companies in exchange for their services. No matter what your company provides – and no matter what you’re looking for – the possibilities are endless.  </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-7 col-12 mt-5 mt-lg-0 wow fadeInRight">
                            <div class="pos-r imgOne">
                                <div class="img-bg">

                                </div>
                                <img :src="asset + 'assets/front/images/play-btn.png'" class="playBtn wow fadeInRight">
                                <img :src="asset + 'assets/front/images/laptop-img-1.png'">
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Video Content End-->


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
                        <div class="col-lg-6 col-6 p1-mt wow fadeInLeft">
                            <img :src="asset + 'assets/front/images/screen-1.jpg'" class="img-fluid">
                        </div>
                        <div class="col-lg-6 col-6 p1-mt wow fadeInRight">
                            <img :src="asset + 'assets/front/images/screen-2.jpg'" class="img-fluid">
                        </div>

                    </div>
                </div>
            </section>
            <!--Manage Business Start-->



            <!--Find Right Professional Start-->
            <section class="findRightProfessional">
                <div class="container border-b padd-b">
                    <div class="row">
                        <div class="col-md-12">
                            <h2>Find the right <span>Professional services</span></h2>
                            <p>Different companies within the same industry can provide totally different products and services. That’s why Swopers focuses on transparency – so you’ll always know exactly what kind of services you can receive.</p>
                        </div>
                    </div>
                    <div class="row p1-mt">
                        <div class="col-lg-12 col-12">
                            <div class="owl-carousel" data-items="3" data-md-items="1" data-sm-items="1" data-margin="30" data-autoplay="true">
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">4.5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">4.5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">4.5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star-half-alt"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row no-gutters post style-2">
                                        <div class="col-sm-12">
                                            <div class="post-desc">
                                                <div class="row">
                                                    <div class="col-7">
                                                        <div class="pdImg">
                                                            <img :src="asset + 'assets/front/images/company-logo.jpg'">
                                                        </div>
                                                    </div>
                                                    <div class="col-5">
                                                        <ul class="text-right pd">
                                                            <li><span class="rating">5</span></li>
                                                            <li>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                                <i class="fas fa-star"></i>
                                                            </li>
                                                            <li><span class="jobs">(93 Jobs)</span></li>
                                                        </ul>
                                                    </div>
                                                </div>

                                                <div class="post-title">
                                                    <h5>Company Name</h5>
                                                    <p>Lorem ipsum dolor sit amet,</p>
                                                </div>

                                                <div class="row tag-wrapper">
                                                    <div class="col-12">
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem Ipsum is simply</a>
                                                        <a href="javascript:void(0)" class="tag"> Lorem ipsum</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--Find Right Professional End-->


            <!--Connect start-->
            <section class="connect secPad-b-none">
                <div class="container border-b padd-b">
                    <div class="row justify-content-center">
                        <div class="col-md-5">
                            <h2>Connect with other businesses.</h2>
                            <p>Swopers is much like an alternative to the Yellow Pages or even a Google search for a service, but without the expectation of currency changing hands. Every business and company you’ll find at Swopers is here because they want to barter with you. </p>
                            <a class="btn wow fadeInUp wh1-mt btnSignup" v-on:click="goToSignup"><span>Free Sign Up</span></a>

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
        name:'Home',
        props:{
            asset:String
        },
        created() {
            setTimeout(function () {
                var backImg = $("#titleImage").attr("data-bg-img");
                $("#titleImage").css('background-image', 'url(' + backImg + ')');
                },1);
        },
        methods:{
            goToSignup:function(){
                this.$router.push({name:'register'});
            }
        }
    }
</script>
