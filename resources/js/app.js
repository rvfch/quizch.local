require('./bootstrap');
window.Vue = require('vue');

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


import App from './views/App'
import Myquizzes from './views/myquizzes'
import Myresults from './views/myresults'
import Settings from './views/settings'
import Stats from './views/stats'
import Newquiz from './views/newquiz'
import Quiz from './views/quiz'
import NewFoundRoute from './views/NotFoundRoute'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faPlusCircle, faPlus, faCheck, faList, faBars, faTable, faChartBar, faSlidersH, faSignOutAlt, faUser, faEdit, faTrashAlt, faLock, faLockOpen, faClock } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

import store from './store/index'

library.add(faPlusCircle)
library.add(faList)
library.add(faBars)
library.add(faTable)
library.add(faChartBar)
library.add(faSlidersH)
library.add(faSignOutAlt)
library.add(faUser)
library.add(faEdit)
library.add(faTrashAlt)
library.add(faLock)
library.add(faLockOpen)
library.add(faClock)
library.add(faCheck)
library.add(faPlus)
Vue.component('font-awesome-icon', FontAwesomeIcon)
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(BootstrapVue)

Vue.config.productionTip = false

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
)

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
)

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
)


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
    {
      path: '/quiz/:id',
      name: 'quiz',
      component: Quiz
    },
    {
      path: '*',
      name: 'myquizzes',
      component: Myquizzes
    }
  ],
})

const app = new Vue({
  el: '#app',
  components: { App },
  store,
  router,
})
