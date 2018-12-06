<template lang="html">
  <b-container fluid v-if="$route.name !== 'quiz' && $route.name !== 'Auth'">
      <b-navbar toggleable type="dark" variant="primary">
        <b-navbar-toggle target="nav_text_collapse"></b-navbar-toggle>
        <b-navbar-brand>Quizch</b-navbar-brand>
        <b-collapse is-nav id="nav_text_collapse">
          <b-navbar-nav class="d-lg-none d-md-none d-sm-flex">
            <b-nav-item :to="{name: 'New quiz'}"><font-awesome-icon icon="plus-circle" /> New quiz</b-nav-item>
            <b-nav-item :to="{name: 'My quizzes'}"><font-awesome-icon :icon="['fas', 'bars']" /> My quizzes</b-nav-item>
            <b-nav-item :to="{name: 'My results'}"><font-awesome-icon :icon="['fas', 'table']" /> My results</b-nav-item>
            <b-nav-item :to="{name: 'Statistics'}"><font-awesome-icon icon="chart-bar" /> Stats</b-nav-item>
            <b-nav-item :to="{name: 'Settings'}"><font-awesome-icon :icon="['fas', 'sliders-h']" /> Settings</b-nav-item>
          </b-navbar-nav>

          <b-navbar-nav class="ml-auto">
            <b-nav-item-dropdown right>
              <template slot="button-content">
                <strong><font-awesome-icon icon="user" /> {{ $store.state.user.email }}</strong>
              </template>
              <b-dropdown-item @click="logOut()"><font-awesome-icon :icon="['fas', 'sign-out-alt']" /> Log Out</b-dropdown-item>
            </b-nav-item-dropdown>
          </b-navbar-nav>
        </b-collapse>
      </b-navbar>
      <b-row no-gutters>
        <b-col tag="nav" md="2" sm="3" class="px-4 d-none d-md-block sidebar">
            <ul>
              <li><router-link tag="a" :to="{ name: 'New quiz', params: {} }"><font-awesome-icon icon="plus-circle" /> New quiz</router-link></li>
              <li><router-link tag="a" :to="{ name: 'My quizzes', params: {} }"><font-awesome-icon :icon="['fas', 'bars']" /> My quizzes</router-link></li>
              <li><router-link tag="a" :to="{ name: 'My results', params: {} }"><font-awesome-icon :icon="['fas', 'table']" /> My results</router-link></li>
              <li><router-link tag="a" :to="{ name: 'Statistics', params: {} }"><font-awesome-icon icon="chart-bar" /> Statistics</router-link></li>
              <li><router-link tag="a" :to="{ name: 'Settings', params: {} }"><font-awesome-icon :icon="['fas', 'sliders-h']" /> Settings</router-link></li>
            </ul>
        </b-col>
        <b-col tag="main" role="main" md="9" lg="10" class="content ml-sm-auto px-4">
          <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h3>{{ $route.name }}</h3>
          </div>
          <router-view></router-view>
        </b-col>
      </b-row>
    </b-container>
    <b-container fluid v-else>
      <router-view></router-view>
    </b-container>
</template>

<style scoped>
  a.router-link-exact-active {
    font-weight: 500;
  }
</style>

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
