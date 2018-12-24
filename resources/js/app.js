/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 
require('./bootstrap');
 
window.Vue = require('vue');
import VueRouter from 'vue-router';

 
window.Vue.use(VueRouter);
 
import PersonsIndex from './components/PersonsIndex.vue';
import PersonsCreate from './components/PersonsCreate.vue';
import PersonsEdit from './components/PersonsEdit.vue';
 
const routes = [
    {
        path: '/',
        components: {
            personsIndex: PersonsIndex
        }
    },
    {path: '/persons/create', component: PersonsCreate, name: 'createPerson'},
    {path: '/persons/edit/:id', component: PersonsEdit, name: 'editPerson'},
]
 
const router = new VueRouter({ routes })
 
const mixin = {
  methods: {
    hello() {
      return 'Hello World!';
    }
  },
  created() {
    console.log('Mixin Created!');
  },
};
 
const app = new Vue({ router,  mixins: [mixin], }).$mount('#app')

