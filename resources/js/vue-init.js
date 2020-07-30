import Main from './Main';
import Vue from 'vue';
import router from './router';
import store from "./store";
var axios = require('axios');

axios.defaults.baseURL = $("#asset").val()+"api";

new Vue({
    el:"#app",
    router,
    store,
    components: {
        app: Main
    }
});
