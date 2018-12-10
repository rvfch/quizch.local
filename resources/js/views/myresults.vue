<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
    <div v-else>
      <b-alert show v-if="results.length === 0" variant="danger">
        You don't have passed quizzes.
      </b-alert>
        <b-card-group v-else deck class="mb-3" v-for="row in Math.ceil(results.length / 4)" :key="row">
          <b-card v-for="(result, index) in results.slice((row-1) * 4, row * 4)" :key="index" :bg-variant="result.resultColor" text-variant="white" class="text-center pt-0" style="max-width: 17.5rem;">
            <div class="d-flex justify-content-center flex-column align-items-center mb-2 mt-0 pt-0">
              <strong>{{ result.quiz_title }}</strong>
              <span>{{ result.created_at }}</span>
            </div>
            <b-progress :value="result.right_answers" :max="result.questions_count" show-value></b-progress>
            <b-btn variant="success" class="w-100 mt-3" size="sm">Detailed info...</b-btn>
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
          .then(res => {

          })
          .catch(err => console.log(err))
        }
      }
    }
</script>

<style lang="css">
</style>
