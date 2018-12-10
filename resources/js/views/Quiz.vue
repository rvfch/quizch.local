<template lang="html">
  <b-row class="d-flex justify-content-center align-items-center quiz-container">
    <b-col lg="10">
      <b-card no-body v-if="$store.state.loading" class="quiz-window">
        <b-card-body class="d-flex flex-column justify-content-center align-items-center">
          <h3>Loading...</h3>
        </b-card-body>
      </b-card>
      <b-card no-body v-else-if="$route.params.id === 'join' && !quizLoaded && !errorLoading" class="quiz-window">
        <b-card-body class="d-flex flex-column justify-content-start">
          <form>
            <h3>To join quiz enter the quiz ID: </h3>
            <b-form-group id="quizIdInputGroup" label="Enter quiz ID: " label-for="quizIdInput">
              <b-form-input id="quizIdInput" type="text" v-model.trim="quizId" required placeholder="Quiz ID..."></b-form-input>
            </b-form-group>
            <b-button variant="success" class="w-100 mb-3" @click="joinQuiz()">Join quiz</b-button>
            <b-button variant="primary" class="w-100" @click="$router.push('/')">Go Back</b-button>
          </form>
        </b-card-body>
      </b-card>
      <b-card no-body v-else-if="$route.params.previewMode" class="quiz-window">
        <b-card-header>
          <strong style="font-weight: 500;">{{ quiz.title }} [PREVIEW MODE]</strong>
        </b-card-header>
        <b-card-body v-if="previewEnded" class="d-flex flex-column justify-content-between">
          <h3>Preview ended</h3>
          <div>
            <b-btn variant="success" class="w-100 mb-3" @click="previewEnded = false; questionNumber = 0">Show again</b-btn>
            <b-btn variant="primary" class="w-100" @click="$router.push('/')">Go Back</b-btn>
          </div>
        </b-card-body>
        <b-card-body v-else class="d-flex flex-column justify-content-between">
          <div>
          <strong style="font-weight: 500;">Question #{{ questionNumber + 1 }}</strong>
          <p style="font-size: 18px;">

            {{ quiz.questions[questionNumber].question_text }}
          </p>
          </div>
          <div class="quiz-answers">
            <b-btn v-for="answer in quiz.questions[questionNumber].answers" :key="answer.id" disabled variant="outline-primary" class="w-100 mb-2 text-left" size="sm">
              {{ answer.text }}
            </b-btn>
            <b-btn variant="outline-success" class="w-100" @click="nextQuestion()">NEXT QUESTION</b-btn>
          </div>
        </b-card-body>
      </b-card>
      <b-card no-body v-else-if="!quizStarted && quiz !== undefined" class="quiz-window">
        <b-card-header>
          <strong style="font-weight: 500;">{{ quiz.title }}</strong>
        </b-card-header>
        <b-card-body class="d-flex flex-column justify-content-start">
          <h3>Welcome to <strong>{{ quiz.title }}</strong> quiz!</h3>
          <p>
            <strong>Description: </strong>{{ quiz.description }}
          </p>
          <p>
            <strong>You have only {{ time }} to do this quiz.</strong>
          </p>
          <p>
            So, good luck and have fun!
          </p>
          <b-alert :show="errorWrongPassword" variant="danger">
            <strong>Error! </strong>Incorrect password.
          </b-alert>
          <b-alert :show="quiz.private && quiz.password === ''" variant="danger">
            <strong>This quiz was disabled by creator! You can't pass it.</strong>
          </b-alert>
          <div v-if="quiz.private">
          <b-form-group id="passwordInputGroup" label="Enter password: " label-for="passwordInput">
            <b-form-input id="passwordInput" type="text" v-model.trim="quizPassword" required placeholder="Password..."></b-form-input>
          </b-form-group>
          <b-button :disabled="quizPassword === '' || quiz.password === ''" variant="outline-success" class="w-100" @click="startQuiz(); setTimer()">START QUIZ</b-button>
          </div>
          <div v-else>
            <b-button variant="outline-success" class="w-100" @click="startQuiz(); setTimer()">START QUIZ</b-button>
          </div>
        </b-card-body>
      </b-card>
      <b-card v-else-if="ifPassed" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz already passed</b-alert>
        <b-button variant="outline-primary" class="w-100 mt-3" @click="$router.push('/')">Click to go back</b-button>
      </b-card>
      <b-card v-else-if="errorLoading" class="quiz-window">
        <b-alert show variant="danger" class="mb-0 w-100 text-center">Quiz not found</b-alert>
        <b-button variant="outline-primary" class="w-100 mt-3" @click="$router.push('/')">Click to go back</b-button>
      </b-card>
      <b-card no-body v-else class="quiz-window">
      <b-card-header class="w-100 d-flex justify-content-between align-items-center">
        <strong style="font-weight: 500;">{{ quiz.title }}</strong>
          <h4 style="padding: 0 !important; margin: 0 !important;">{{ time }}</h4>
      </b-card-header>
      <b-card-body class="d-flex flex-column justify-content-between" v-if="!quizEnded">
        <div>
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
          dismissCountdown: 0,
          dismissSecs: 5,

          quizId: '',
          quizPassword: '',
          quizLoaded: false,
          errorLoading: false,
          errorWrongPassword: false,

          // timer
          timer: null,
          startTime: 0,
          time: '',

          hours: '',
          minutes: '',
          seconds: '',

          previewEnded: false
        }
      },
      computed: {
        quiz() {
          return this.$store.state.quiz
        }
      },
      mounted() {
        if (this.$route.params.id !== 'join')
          this.loadQuiz(this.$route.params.id)
      },
      methods: {
        joinQuiz() {
          this.loadQuiz(this.quizId)
        },
        prepareQuiz() {
          this.startTime = this.quiz.duration
          this.hours = Math.floor(parseInt(this.startTime / 3600))
          this.minutes = Math.floor(parseInt(this.startTime / 60, 10)) % 60
          this.seconds = parseInt(this.startTime % 60, 10)
          this.time = `${this.hours} hours ${this.minutes} minutes ${this.seconds} seconds`
          this.quizLoaded = true
        },
        loadQuiz(quizId) {
          this.$store.dispatch('getquiz', quizId)
          .then(res => {
            if (res.data === 'ALREADY_PASSED') {
              this.ifPassed = true
            } else {
            this.prepareQuiz()
          }
          })
          .catch(err => {
              this.$store.state.loading = false
              console.log(err)
              this.errorLoading = true
          })
        },
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
        setTimer() {
          let hours = this.hours,
              minutes = this.minutes,
              seconds = this.seconds
          hours = hours < 10 ? '0' + hours : hours
          minutes = minutes < 10 ? '0' + minutes : minutes
          seconds = seconds < 10 ? '0' + seconds : seconds
          this.time = `${hours}:${minutes}:${seconds}`
        },
        startQuiz () {
          if (this.quiz.private === 1) {
            if (this.quizPassword === this.quiz.password) {
              this.startTimer()
              this.quizStarted = true
            } else {
              this.errorWrongPassword = true
              throw 'WRONG_PASSWORD'
            }
          } else {
            this.startTimer()
            this.quizStarted = true
          }
        },
        countDownChanged (dismissCountdown) {
          this.dismissCountdown = dismissCountdown
          if (this.dismissCountdown === 0)
            this.$router.push({ name: 'My results' })
        },
        nextQuestion(answerId = 0) {
          if(this.questionNumber !== this.quiz.questions_count - 1) {
            this.questionNumber++
            if (!this.$route.params.previewMode)
              this.results.push(answerId)
          }
          else if(!this.$route.params.previewMode) {
            this.results.push(answerId)
            this.endQuiz()
          } else {
            this.endPreview()
          }
        },
        endPreview() {
          this.previewEnded = true
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
