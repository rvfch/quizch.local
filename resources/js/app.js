/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
 import Vue from 'vue'
 import VueRouter from 'vue-router'

 Vue.use(VueRouter)

import App from './views/App'
import Myquizzes from './views/myquizzes'
import Myresults from './views/myresults'
import Settings from './views/settings'
import Stats from './views/stats'
import Newquiz from './views/newquiz'


const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'myquizzes',
      component: Myquizzes
    },
    {
      path: '/myresults',
      name: 'myresults',
      component: Myresults
    },
    {
      path: '/settings',
      name: 'settings',
      component: Settings
    },
    {
      path: '/stats',
      name: 'stats',
      component: Stats
    },
    {
      path: '/newquiz',
      name: 'newquiz',
      component: Newquiz
    },
  ],
});

const app = new Vue({
  el: '#app',
  components: { App },
  router,
});
