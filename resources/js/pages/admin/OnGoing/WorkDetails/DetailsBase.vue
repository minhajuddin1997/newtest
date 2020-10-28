<template>
    <main>
        <div class="right_col" role="main" style="min-height: 990px;">
            <div class="">
                <div class="col-lg-10 offset-lg-1 col-md-12">
                    <div class="text-dark">
                        <div class="">
                            <slot name="details-header"></slot>
                        </div>
                        <div class="row col-10 service-details-nav">
                            <Navbar :route="this.$route" :work_service_id="work_service_id"/>
                        </div>
                        <div class="">
                            <slot name="details-body"></slot>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>

    </main>
</template>

<script>
    import Navbar from '../../shared/WorkDetailsNav';
    export default {
        name:"DetailsBase",
        props:[
            "work_service_id"
        ],
        components:{
            Navbar:Navbar
        }
    }
</script>
