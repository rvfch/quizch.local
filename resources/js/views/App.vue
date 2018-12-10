<template lang="html">
  <b-container fluid v-if="$route.name !== 'quiz' && $route.name !== 'Auth'">
      <b-navbar toggleable type="dark" variant="primary">
        <b-navbar-toggle target="nav_text_collapse"></b-navbar-toggle>
        <b-navbar-brand><strong>Quizch</strong> <small> simple quizzes</small></b-navbar-brand>
        <b-collapse is-nav id="nav_text_collapse">
          <b-navbar-nav class="d-lg-none d-md-none d-sm-flex">
            <b-nav-item :to="{name: 'New quiz'}"><font-awesome-icon icon="plus-circle" /> New quiz</b-nav-item>
            <b-nav-item :to="{name: 'My quizzes'}"><font-awesome-icon :icon="['fas', 'bars']" /> My quizzes</b-nav-item>
            <b-nav-item :to="{name: 'My results'}"><font-awesome-icon :icon="['fas', 'table']" /> My results</b-nav-item>
            <b-nav-item :to="{name: 'Statistics'}"><font-awesome-icon icon="chart-bar" /> Stats</b-nav-item>
            <b-nav-item :to="{name: 'Settings'}"><font-awesome-icon :icon="['fas', 'sliders-h']" /> Settings</b-nav-item>
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
          <div class="top-sidebar d-lg-flex d-none">
            <b-btn variant="outline-dark" @click="$router.push('/quiz/join')">JOIN QUIZ</b-btn>
            <div>
            <a href="#"><font-awesome-icon :icon="['fas', 'bell']"></font-awesome-icon></a>
            <a href="#"><font-awesome-icon :icon="['fas', 'envelope']"></font-awesome-icon></a>
            </div>
          </div>
            <ul class="side-menu">
              <li>
                <router-link tag="a" class="btn-newquiz" :to="{ name: 'New quiz', params: {} }"><font-awesome-icon icon="plus-circle" /> NEW QUIZ</router-link>
              </li>
              <li><router-link tag="a" :to="{ name: 'My quizzes', params: {} }"><font-awesome-icon :icon="['fas', 'bars']" /> My quizzes</router-link></li>
              <li><router-link tag="a" :to="{ name: 'My results', params: {} }"><font-awesome-icon :icon="['fas', 'table']" /> My results</router-link></li>
              <li><router-link tag="a" :to="{ name: 'Statistics', params: {} }"><font-awesome-icon icon="chart-bar" /> Statistics</router-link></li>
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
