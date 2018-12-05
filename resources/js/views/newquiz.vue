<template lang="html">
    <div>
      <b-modal id="addQuestionModal" @ok="handleOk" :title="questionModalTitle" ref="modal">
        <form @submit.stop.prevent="handleSubmit">
          <b-form-input ref="questionText" type="text" placeholder="Enter question..." v-model="question" required></b-form-input>
          <hr />
          <b-input-group v-for="(answer, index) in answers" :key="index" class="mb-3">
            <b-form-input :ref="`answerText${index}`" type="text" placeholder="Enter answer..." v-model="answer.text"></b-form-input>
            <b-input-group-append>
              <b-btn @click="selectRightAnswer(index)" variant="success" :disabled="answer.correct === 1"><font-awesome-icon :icon="['fas', 'check']"></font-awesome-icon></b-btn>
            </b-input-group-append>
          </b-input-group>
        </form>
      </b-modal>

        <b-form-row>
          <b-col>
          <b-form-group id="titleInputGroup" label="Title: " label-for="titleInput">
            <b-form-input id="titleInput" type="text" v-model="title" required placeholder="Title..."></b-form-input>
          </b-form-group>
          <b-form-group id="descriptionInputGroup" label="Description: " label-for="descriptionInput">
            <b-form-textarea id="descriptionInput" :rows="4" :max-rows="8" v-model.trim="description" placeholder="Quiz description..." required no-resize></b-form-textarea>
          </b-form-group>
          <b-form-group id="timerInputGroup" label="Set timer: " label-for="timerInput">
            <b-input-group>
            <b-input-group-text slot="prepend">
              <font-awesome-icon :icon="['fas', 'clock']"></font-awesome-icon>
            </b-input-group-text>
              <b-form-input id="timerInput" autocomplete="off" type="time" v-model="timer" required placeholder="hh:mm" value="01:00"></b-form-input>
            </b-input-group>
          </b-form-group>
          <b-form-group id="passwordInputGroup" label="Privacy: " label-for="passwordInput">
            <transition name="fade" mode="out-in">
          <b-input-group v-if="private">
            <b-input-group-prepend>
              <b-btn @click="private = 0" variant="outline-success"><font-awesome-icon :icon="['fas', 'lock-open']"></font-awesome-icon></b-btn>
            </b-input-group-prepend>
            <b-form-input id="passwordInput" type="password" v-model="password" placeholder="Password..."></b-form-input>
          </b-input-group>
          <b-btn v-else @click="private = 1" variant="outline-danger" class="w-100"><font-awesome-icon :icon="['fas', 'lock']"></font-awesome-icon></b-btn>
          </transition>
          </b-form-group>
          </b-col>
          <b-col>
            <label>Questions: </label>
            <b-card v-if="questions.length > 0" no-body variant="primary" class="mb-3">
              <b-list-group flush>
                <b-list-group-item v-for="(question, index) in questions" :key="index">
                  <span class="align-middle">{{ question.question_text }}</span>
                  <b-button-group size="sm" class="float-right">
                    <b-btn v-b-modal.addQuestionModal @click="questionModalShown(index, true)" variant="warning"><font-awesome-icon :icon="['fas', 'edit']"></font-awesome-icon></b-btn>
                    <b-btn @click="deleteQuestion(index)" variant="danger"><font-awesome-icon :icon="['fas', 'trash-alt']"></font-awesome-icon></b-btn>
                  </b-button-group>
                </b-list-group-item>
              </b-list-group>
            </b-card>
            <b-btn v-b-modal.addQuestionModal @click="questionModalShown()" variant="outline-primary" class="w-100 mb-3 d-flex align-items-center px-0" size="sm">
              <span class="w-25 d-flex pl-2"><font-awesome-icon :icon="['fas', 'plus']"></font-awesome-icon></span><span class="w-50">ADD QUESTION</span><span class="w-25"></span></b-btn>
          </b-col>
          <b-btn @click="handleQuiz($event)" variant="success" class="w-100 d-flex align-items-center px-0" size="md"><span class="w-25 d-flex pl-2"><font-awesome-icon :icon="['fas', 'plus-circle']"></font-awesome-icon></span><span class="w-50">CREATE QUIZ</span><span class="w-25"></span></b-btn>
        </b-form-row>
    </div>
</template>

<script>
export default {
    data() {
        return {
            title: '',
            description: '',
            timer: '',
            private: false,
            password: '',
            question: '',
            answers: [],
            questions: [],
            duration: 0,

            questionModalTitle: '',
            edit: false,
            editableId: ''
        }
    },
    methods: {
      questionModalShown(index, edit = false) {
        if(edit) {
          this.editQuestion(index)
          this.questionModalTitle = 'Edit question'
          this.edit = true
        } else {
          this.clearAddQuestionForm()
          this.questionModalTitle = 'Add question'
        }
      },
      deleteQuestion(index) {
        this.questions.splice(index, 1)
      },
      clearAddQuestionForm() {
        this.question = ''
        this.answers = [{
          text: '',
          correct: 1
        },
        {
          text: '',
          correct: 0
        },
        {
          text: '',
          correct: 0
        },
        {
          text: '',
          correct: 0
        }]
        this.$refs.questionText.focus()
      },
      checkAnswers() {
        let counter = 0
        this.answers.forEach((answer) => {
          if(answer.text !== '')
            counter++
        })
        if(counter >= 2)
          return true
        else
          return false
      },
      handleOk(evt) {
        evt.preventDefault()
        if(!this.question) {
          alert('Enter question')
        } else {
          if(this.checkAnswers())
            this.handleSubmit()
          else
            alert('Enter from 2 to 4 answers')
        }
      },
      handleSubmit() {
        if(this.edit) {
          this.questions[this.editableId] = {question_text: this.question, answers: this.answers}
          this.edit = false
        } else {
          this.questions.push({question_text: this.question, answers: this.answers})
        }
        this.clearAddQuestionForm()
        this.$refs.modal.hide()
      },
      selectRightAnswer(index) {
        this.answers.forEach((answer) => {
          answer.correct = 0
        })
        this.answers[index].correct = 1
      },
      editQuestion(index) {
        this.editableId = index
        this.question = this.questions[index].question_text
        this.questions[index].answers.forEach((answer, index) => {
          this.answers[index].text = answer.text
          this.answers[index].correct = answer.correct
        })
      },
      handleQuiz(event) {
        event.preventDefault()
        if(!this.title || !this.description || this.questions.length === 0)
          alert('Enter data')
        else
        {
          this.addQuiz()
          alert('Quiz successfully added :)')
          this.$router.push('/')
        }
      },
      addQuiz() {
        let minutes = parseInt(this.timer.split(':')[0]),
            seconds = parseInt(this.timer.split(':')[1])

        const quiz = {
          id: '',
          title: this.title,
          description: this.description,
          questions_count: this.questions.length,
          private: this.private,
          password: this.private ? this.password : '',
          questions: this.questions,
          duration: minutes * 60 + seconds
        }
        this.$store.dispatch('addquiz', quiz)
      }
    }
}
</script>

<style lang="css">
</style>
