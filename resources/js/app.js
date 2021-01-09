require('./bootstrap');

import Vue from 'vue';
import App from './App.vue';

import Navbar from './components/NavbarComponent.vue';

import axios from 'axios'
import VueAxios from 'vue-axios'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';
import Datepicker from 'vuejs-datepicker';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';


Vue.use(VueAxios, axios)

Vue.use(BootstrapVue);

Vue.use(IconsPlugin);


const app = new Vue({
    el: "#app",
    components: {
        App, Navbar, Datepicker
    }
});