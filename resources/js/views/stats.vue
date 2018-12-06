<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
  <div v-else>
    Statistics
  </div>
</template>

<script>
export default {
}
</script>

<style lang="css">
</style>
