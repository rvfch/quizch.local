<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
  <div v-else>
    <b-list-group style="width: 50%;">
      <b-list-group-item class="d-flex justify-content-between align-items-center">
        Registered at
        <div>
          {{ $store.state.user.created_at }}
        </div>
      </b-list-group-item>
      <b-list-group-item class="d-flex justify-content-between align-items-center">
        Passed
        <b-badge variant="primary" pill>{{ $store.state.results.length }}</b-badge>
      </b-list-group-item>
      <b-list-group-item class="d-flex justify-content-between align-items-center">
        Excellent
        <b-badge variant="success" pill>{{ $store.state.excellentCount }}</b-badge>
      </b-list-group-item>
      <b-list-group-item class="d-flex justify-content-between align-items-center">
        Good
        <b-badge variant="warning" pill>{{ $store.state.goodCount }}</b-badge>
      </b-list-group-item>
      <b-list-group-item class="d-flex justify-content-between align-items-center">
        Bad
        <b-badge variant="danger" pill>{{ $store.state.badCount }}</b-badge>
      </b-list-group-item>
    </b-list-group>
  </div>
</template>

<script>
export default {
  mounted() {
    this.$store.dispatch('getresults')
    .then(() => {

    })
    .catch(err => console.log(err))
  }
}
</script>

<style lang="css">
</style>
