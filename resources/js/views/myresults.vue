<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
  <b-alert show v-else-if="results.length === 0" variant="danger">
    You don't have passed quizzes.
  </b-alert>
    <div v-else>
        <b-card-group deck class="mb-3" v-for="row in Math.ceil(results.length / 4)" :key="row">
          <b-card no-body v-for="(result, index) in results.slice((row-1) * 4, row * 4)" :key="index" :bg-variant="result.resultColor" text-variant="white" class="pt-0" style="max-width: 17.5rem;">
            <b-card-body class="d-flex flex-column justify-content-between align-items-center" style="padding: 1em !important; margin: 0 !important;">
              <div style="width: 100%; text-align:center; white-space: nowrap;" class="d-flex flex-column mb-3">
                <strong>{{ result.quiz_title }}</strong>
                <span>{{ result.created_at }}</span>
              </div>
              <div style="width: 100%;">
                <b-progress :value="result.right_answers" :max="result.questions_count" show-value></b-progress>
                <b-btn variant="dark" class="w-100 mt-3" size="sm">Detailed info...</b-btn>
              </div>
            </b-card-body>
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
        this.$store.dispatch('getresults')
        .then(() => {})
        .catch(err => console.log(err))
      },
      methods: {

      }
    }
</script>

<style lang="css">
</style>
