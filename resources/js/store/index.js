import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    userId: null,
    userName: null,
    quizzes: [],
    results: []
  },
  getters: {
    userId: state => {
      return state.userId
    }
  },
  mutations: {
    SET_USER_ID: (state, userId) => {
      state.userId = userId
    },
    SET_USER_NAME: (state, userName) => {
      state.userName = userName
    },
    GET_QUIZZES: (state, quizzes) => {
      state.quizzes = quizzes
    },
    GET_RESULTS: (state, results) => {
      state.results = results
    }
  },
  actions: {
    // quizzes
    getquizzes({ commit, state }) {
      return axios.get('/api/quizzes/' + state.userId)
            .then(res => {
              commit('GET_QUIZZES', res.data.data)
            }).catch()
    },
    updatequiz({ state }, quiz) {
      axios.put('/api/quiz', {
        id: quiz.id,
        title: quiz.title,
        description: quiz.description,
        user_id: quiz.user_id,
        questions_count: quiz.questions_count,
        questions: quiz.questions,
        private: quiz.private,
      }).then(() => this.dispatch('getquizzes'))
      .catch()
    },
    deletequiz({}, quizId) {
      axios.delete('/api/quiz/' + quizId)
          .then(() => this.dispatch('getquizzes'))
          .catch()
    },
    addquiz({ state }, quiz) {
      axios.post('/api/quiz', {
        id: quiz.id,
        title: quiz.title,
        description: quiz.description,
        user_id: state.userId,
        questions_count: quiz.questions_count,
        questions: quiz.questions,
        private: quiz.private,
      }).then(() => this.dispatch('getquizzes'))
      .catch()
    },
    //results
    getresults({ commit, state }) {
      return axios.get('/api/results/' + state.userId)
            .then(res => {
              commit('GET_RESULTS', res.data.data)
            }).catch()
    }
  }
})
