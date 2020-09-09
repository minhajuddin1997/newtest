<template>
    <div>
        <table class="table table-responsive-md table-striped table-hover" >
            <thead class="border">
            <tr>
                <th v-for="name in columns">{{name}}</th>
            </tr>
            </thead>
            <tbody>
                <slot name="rows"></slot>
            </tbody>

        </table>
        <pagination v-if="pagination.last_page > 1" :pagination="pagination" :offset="5" @paginate="fetchData" ></pagination>
    </div>
</template>
<script>
    import pagination from './Paginate';
    export default {
        name:'DataTable',
        props:['columns','data','pagination','fetchData'],
        components:{pagination}
    }
</script>
