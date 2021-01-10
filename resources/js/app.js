/**
 * Main App JS File 
 * 
 * @author: John Dave D. Lagdameo <jdlagdameo@gmail.com>
 * @since: 2021/01/08
 * @internal revisions: 
 * + 20200110 - setup font vue fontawesome
 * 
 */
require('./bootstrap');

import Vue from 'vue';
import App from './App.vue';

import Navbar from './components/NavbarComponent.vue';

import axios from 'axios'
import VueAxios from 'vue-axios'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue';

import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import { library } from '@fortawesome/fontawesome-svg-core'
import { faCheck, faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faCheck)
library.add(faTimesCircle)

Vue.component('font-awesome-icon', FontAwesomeIcon)

Vue.use(VueAxios, axios)

Vue.use(BootstrapVue);

Vue.use(IconsPlugin);

const app = new Vue({
    el: "#app",
    components: {
        App, Navbar
    }
});