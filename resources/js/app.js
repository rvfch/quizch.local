require('./bootstrap')
window.Vue = require('vue')

import Vue from 'vue'
import Vuex from 'vuex'
import VueRouter from 'vue-router'
import BootstrapVue from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import Axios from 'axios'
import VueClipboard from 'vue-clipboard2'
import Draggable from 'vuedraggable';

import App from './views/App'
import Myquizzes from './views/myquizzes'
import Myresults from './views/myresults'
import Settings from './views/settings'
import Stats from './views/stats'
import Newquiz from './views/newquiz'
import Editquiz from './views/editquiz'
import Quiz from './views/quiz'
import Auth from './views/auth/auth'
import NotFoundRoute from './views/NotFoundRoute'

import { library } from '@fortawesome/fontawesome-svg-core'
import { faEnvelope, faBell, faLink, faEye, faPlusCircle, faCopy, faPlus, faCheck, faList, faBars, faTable, faChartBar, faSlidersH, faSignInAlt, faSignOutAlt, faUser, faEdit, faTrashAlt, faLock, faLockOpen, faClock } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import store from './store/index'

library.add(faEnvelope, faBell, faLink, faEye, faPlusCircle, faCopy, faList, faBars, faTable, faChartBar, faSlidersH, faSignInAlt, faSignOutAlt, faUser, faEdit, faTrashAlt,
            faLock, faLockOpen, faClock, faCheck, faPlus)

Vue.component('font-awesome-icon', FontAwesomeIcon)


Vue.config.productionTip = false
Vue.use(Vuex)
Vue.use(VueRouter)
Vue.use(BootstrapVue)
Vue.use(VueClipboard)
Vue.component('draggable', Draggable)
// setup auth
Vue.prototype.$http = Axios
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = 'Bearer '.concat(token)
}

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/auth',
      name: 'Auth',
      component: Auth,
      meta: {
        requiresVisitor: true
      }
    },
    {
      path: '/',
      name: 'My quizzes',
      component: Myquizzes,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/myresults',
      name: 'My results',
      component: Myresults,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/settings',
      name: 'Settings',
      component: Settings,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/stats',
      name: 'Statistics',
      component: Stats,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/newquiz',
      name: 'New quiz',
      component: Newquiz,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/editquiz',
      name: 'Edit quiz',
      component: Editquiz,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '/quiz/:id',
      name: 'quiz',
      component: Quiz,
      meta: {
        requiresAuth: true
      }
    },
    {
      path: '*',
      component: NotFoundRoute,
    }
  ],
})

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (!store.getters.isLoggedIn) {
      next({
        name: 'Auth'
      })
    } else {
      next()
    }
  } else if (to.matched.some(record => record.meta.requiresVisitor)) {
      if (store.getters.isLoggedIn) {
        next({
          name: 'myquizzes'
        })
      } else {
        next()
      }
  } else {
    next()
  }
})

const app = new Vue({
  el: '#app',
  computed: Vuex.mapState(['loading', 'quizzes', 'results', 'quiz']),
  components: { App },
  store,
  router,
})
