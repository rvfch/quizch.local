<template lang="html">
  <b-row class="d-flex justify-content-center align-items-center quiz-container">
    <b-col lg="10">
      <b-card v-if="quiz === undefined" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz not found</b-alert>
      </b-card>
      <b-card v-else-if="ifPassed === true" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz already passed</b-alert>
      </b-card>
      <b-card v-else class="quiz-window" :header="quiz.title">
      <div id="quiz" v-if="!quizEnded">
        <p style="font-size: 18px;">
          {{ quiz.questions[questionNumber].question_text }}
        </p>
        <div class="quiz-answers">
          <b-btn v-for="answer in quiz.questions[questionNumber].answers" :key="answer.id" @click="nextQuestion(answer.id)" variant="outline-primary" class="w-100 mb-2 text-left" size="sm">
            {{ answer.text }}
          </b-btn>
        </div>
        </div>
        <div v-else>
          <b-row class="mx-2">
            <h3>You have {{ points }} / {{ quiz.questions.length }} points.</h3>
            <b-alert class="mb-0 mt-3 w-100" :show="dismissCountdown" variant="info" @dismissed="dismissCountdown = 0" @dismiss-count-down="countDownChanged">
                You will be redirected in <strong>{{ dismissCountdown }}</strong> seconds...
            </b-alert>
          </b-row>
        </div>
      </b-card>
    </b-col>
  </b-row>
</template>

<script>
    export default {
      data() {
        return {
          questionNumber: 0,
          points: 0,
          results: [],
          result: {},
          quizEnded: false,
          isPassed: false,
          dismissCountdown: 0,
          dismissSecs: 5
        }
      },
      computed: {
        quiz() {
          return this.$store.state.quiz
        }
      },
      mounted() {
        this.$store.dispatch('getquiz', this.$route.params.id)
      },
      methods: {
        ifPassed () {
          if (this.quiz === 'ALREADY_PASSED')
            return true
          return false
        },
        countDownChanged (dismissCountdown) {
          this.dismissCountdown = dismissCountdown
          if (this.dismissCountdown === 0)
            this.$router.push('/myresults')
        },
        nextQuestion(answerId) {
          if(this.questionNumber !== this.quiz.questions_count - 1) {
            this.questionNumber++
            this.results.push(answerId)
          }
          else {
            this.results.push(answerId)
            this.endQuiz()
          }
        },
        endQuiz() {
          this.quizEnded = true
          this.calculateResult(this.results)
          this.dismissCountdown = this.dismissSecs

          this.result = {
            quiz_id: this.quiz.id,
            right_answers: this.points,
            isPassed: this.isPassed
          }
          this.$store.dispatch('addresult', this.result)
        },
        calculateResult(results) {
          results.forEach((element, index) => {
            if (this.quiz.questions[index].answers.find(x => x.id === element).correct === 1)
              this.points++
          })

          if(this.points > Math.floor(this.quiz.questions.length / 2))
            this.isPassed = true
          else
            this.isPassed = false
        }
      }
    }
</script>

<style lang="css">
.quiz-container {
  height: 100vh;
}

.quiz-answers {
  margin-top: 6rem;
}

.quiz-window {
  box-shadow: 0 0 100px rgba(0,0,0,.15)
}

body {
  background: #36D1DC;  /* fallback for old browsers */
  background: linear-gradient(to right, #5B86E5, #36D1DC); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}
</style>
