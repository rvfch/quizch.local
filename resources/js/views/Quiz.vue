<template lang="html">
  <b-row class="d-flex justify-content-center align-items-center quiz-container">
    <b-col lg="10">
      <b-card no-body v-if="$store.state.loading" class="quiz-window">
        <b-card-body class="d-flex flex-column justify-content-center align-items-center">
          <h3>Loading...</h3>
        </b-card-body>
      </b-card>
      <b-card no-body v-else-if="!quizStarted && quiz !== undefined" class="quiz-window">
        <b-card-header>
          <strong style="font-weight: 500;">{{ quiz.title }}</strong>
        </b-card-header>
        <b-card-body class="d-flex flex-column justify-content-start">
          <h3>Welcome to <strong>{{ quiz.title }}</strong> quiz!</h3>
          <p>
            <strong>You have only {{ time }} to do this quiz.</strong>
          </p>
          <p>
            So, good luck and have fun!
          </p>
          <b-button variant="success" class="w-100" @click="startQuiz(); time = ''">PRESS BUTTON TO START QUIZ</b-button>
        </b-card-body>
      </b-card>
      <b-card no-body v-else-if="previewMode" class="quiz-window">
        <b-card-header>
          <strong style="font-weight: 500;">{{ quiz.title }}</strong>
        </b-card-header>
        <b-card-body class="d-flex flex-column justify-content-between">

        </b-card-body>
      </b-card>
      <b-card v-else-if="ifPassed" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz already passed</b-alert>
        <b-button variant="outline-primary" class="w-100 mt-3" @click="$router.push('/')">Click to go back</b-button>
      </b-card>
      <b-card v-else-if="quiz === undefined" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz not found</b-alert>
        <b-button variant="outline-primary" class="w-100 mt-3" @click="$router.push('/')">Click to go back</b-button>
      </b-card>
      <b-card no-body v-else class="quiz-window">
      <b-card-header>
        <strong style="font-weight: 500;">{{ quiz.title }}</strong>
      </b-card-header>
      <b-card-body class="d-flex flex-column justify-content-between" v-if="!quizEnded">
        <div>
        <div class="timer">
          {{ time }}
        </div>
        <strong style="font-weight: 500;">Question #{{ questionNumber + 1 }}</strong>
        <p style="font-size: 18px;">

          {{ quiz.questions[questionNumber].question_text }}
        </p>
        </div>
        <div class="quiz-answers">
          <b-btn v-for="answer in quiz.questions[questionNumber].answers" :key="answer.id" @click="nextQuestion(answer.id)" variant="outline-primary" class="w-100 mb-2 text-left" size="sm">
            {{ answer.text }}
          </b-btn>
        </div>
      </b-card-body>
        <b-card-body v-else>
          <b-row class="mx-2">
            <h3>You have {{ points }} / {{ quiz.questions.length }} points.</h3>
            <b-alert class="mb-0 mt-3 w-100" :show="dismissCountdown" variant="info" @dismissed="dismissCountdown = 0" @dismiss-count-down="countDownChanged">
                You will be redirected in <strong>{{ dismissCountdown }}</strong> seconds...
            </b-alert>
          </b-row>
        </b-card-body>
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
          quizStarted: false,
          isPassed: false,
          ifPassed: false,
          previewMode: false,
          dismissCountdown: 0,
          dismissSecs: 5,

          // timer
          timer: null,
          startTime: 0,
          time: '',

          hours: '',
          minutes: '',
          seconds: ''
        }
      },
      computed: {
        quiz() {
          return this.$store.state.quiz
        }
      },
      mounted() {
        this.$store.dispatch('getquiz', this.$route.params.id)
        .then(res => {
          if (res.data === 'ALREADY_PASSED')
            this.ifPassed = true

            this.startTime = this.quiz.duration
            this.hours = Math.floor(parseInt(this.startTime / 3600))
            this.minutes = Math.floor(parseInt(this.startTime / 60, 10)) % 60
            this.seconds = parseInt(this.startTime % 60, 10)
            this.time = `${this.hours} hours ${this.minutes} minutes ${this.seconds} seconds`
        })
        .catch(err => console.log(err))

      },
      methods: {
        startTimer() {
          this.timer = setInterval(() => {
            let hours = Math.floor(parseInt(this.startTime / 3600)),
            minutes = Math.floor(parseInt(this.startTime / 60, 10)) % 60,
            seconds = parseInt(this.startTime % 60, 10)
            --this.startTime
            hours = hours < 10 ? '0' + hours : hours
            minutes = minutes < 0 ? --minutes : minutes
            minutes = minutes < 10 ? '0' + minutes : minutes
            seconds = seconds < 0 ? 59 : seconds
            seconds = seconds < 10 ? '0' + seconds : seconds
            this.time = `${hours}:${minutes}:${seconds}`
            if (this.startTime === 0) {
              this.endQuiz()
              return clearInterval(this.timer)
            }
          }, 1000)
        },
        startQuiz () {
          this.startTimer()
          this.quizStarted = true
        },
        countDownChanged (dismissCountdown) {
          this.dismissCountdown = dismissCountdown
          if (this.dismissCountdown === 0)
            this.$router.push({ name: 'My results' })
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

<style lang="css" scoped>
.quiz-container {
  height: 100vh;
  background: #36D1DC;  /* fallback for old browsers */
  background: linear-gradient(to right, #5B86E5, #36D1DC); /* W3C, IE 10+/ Edge, Firefox 16+, Chrome 26+, Opera 12+, Safari 7+ */
}

.quiz-answers {
  margin-top: 6rem;
}

.quiz {
  height: 100%;
}

.quiz-window {
  box-shadow: 0 0 100px rgba(0,0,0,.15);
  min-height: 600px;
  height: 100%;
}

</style>
