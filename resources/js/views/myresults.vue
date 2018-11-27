<template lang="html">
    <div>
        <b-card-group deck class="mb-3" v-for="row in Math.ceil(results.length / 4)" :key="row">
          <b-card v-for="(result, index) in results.slice((row-1) * 4, row * 4)" :key="index" bg-variant="success" text-variant="white" :header="result.id" class="text-center" style="max-width: 20rem;">
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
