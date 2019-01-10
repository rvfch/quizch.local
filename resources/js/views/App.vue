<template lang="html">
  <b-container fluid v-if="$route.name !== 'quiz' && $route.name !== 'Auth'">
      <b-navbar toggleable type="dark" variant="primary">
        <b-navbar-toggle target="nav_text_collapse"></b-navbar-toggle>
        <b-navbar-brand><strong><a href="#" style="text-decoration: none; color: white; " @click="$router.push('/')">Quizch</a></strong> <small> simple quizzes</small></b-navbar-brand>
        <b-collapse is-nav id="nav_text_collapse">
          <b-navbar-nav class="d-lg-none d-md-none d-sm-flex">
            <b-nav-item :to="{name: 'New quiz'}" exact-active-class="active" :exact="true"><font-awesome-icon icon="plus-circle" /></b-nav-item>
            <b-nav-item :to="{name: 'My quizzes'}" exact-active-class="active" :exact="true"><font-awesome-icon :icon="['fas', 'bars']" /></b-nav-item>
            <b-nav-item :to="{name: 'My results'}" exact-active-class="active" :exact="true"><font-awesome-icon :icon="['fas', 'table']" /></b-nav-item>
            <b-nav-item :to="{name: 'Settings'}" exact-active-class="active" :exact="true"><font-awesome-icon :icon="['fas', 'sliders-h']" /></b-nav-item>
          </b-navbar-nav>

          <b-navbar-nav class="ml-auto">
            <b-nav-item>
            <strong><font-awesome-icon icon="user" /> {{ $store.state.user.email }}</strong>
            </b-nav-item>
            <b-nav-item href="#" @click="logOut()"><font-awesome-icon :icon="['fas', 'sign-out-alt']" /> Log Out</b-nav-item>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
      <b-row no-gutters>
        <b-col tag="nav" md="2" sm="3" class="d-none d-md-flex flex-column pt-3 sidebar">
            <b-btn variant="outline-primary" class="mx-3 mb-3" @click="$router.push('/quiz/join')">
              <font-awesome-icon :icon="['fas', 'sign-in-alt']"></font-awesome-icon> JOIN QUIZ
            </b-btn>
            <ul class="side-menu">
              <li>
                <router-link tag="a" class="btn-newquiz" :to="{ name: 'New quiz', params: {} }"><font-awesome-icon icon="plus-circle" /> NEW QUIZ</router-link>
              </li>
              <li><router-link tag="a" :to="{ name: 'My quizzes', params: {} }"><font-awesome-icon :icon="['fas', 'bars']" /> My quizzes</router-link></li>
              <li><router-link tag="a" :to="{ name: 'My results', params: {} }"><font-awesome-icon :icon="['fas', 'table']" /> My results</router-link></li>
              <li><router-link tag="a" :to="{ name: 'Settings', params: {} }"><font-awesome-icon :icon="['fas', 'sliders-h']" /> Settings</router-link></li>
            </ul>
        </b-col>
        <b-col tag="main" role="main" md="9" lg="10" class="content ml-sm-auto px-4 mt-4">
          <router-view></router-view>
        </b-col>
      </b-row>
    </b-container>
    <b-container fluid v-else>
      <router-view></router-view>
    </b-container>
</template>


<script>
export default {
  mounted() {
    this.$store.dispatch('getUser')
  },
  methods: {
    logOut: function() {
      this.$store.dispatch('logout')
      .then(() => {
        this.$router.push({ name: 'Auth' })
      })
      .catch(err => {
        this.$router.push({ name: 'Auth' })
      })
    }
  }
}
</script>
