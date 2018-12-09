<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
    <div v-else>
      <b-alert show v-if="results.length === 0" variant="danger">
        You don't have passed quizzes.
      </b-alert>
        <b-card-group v-else deck class="mb-3" v-for="row in Math.ceil(results.length / 4)" :key="row">
          <b-card v-for="(result, index) in results.slice((row-1) * 4, row * 4)" :key="index" bg-variant="success" text-variant="white" class="text-center" style="max-width: 17.5rem;">
            <b-progress :value="result.right_answers" :max="result.right_answers" show-progress></b-progress>
          </b-card>
        </b-card-group>
    </div>
</template>

<script>
    export default {
      data() {
        return {
          rows: null
        }
      },
      computed: {
        results() {
          return this.$store.state.results
        }
      },
      mounted() {
        this.getResults()
      },
      methods: {
        getResults() {
          this.$store.dispatch('getresults')
        }
      }
    }
</script>

<style lang="css">
</style>
