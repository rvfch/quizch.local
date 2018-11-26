import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    userId: null,
    userName: null,
    quizzes: null
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
    }
  },
  actions: {
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
        user_id: state.userId,
        answers_count: quiz.questions_count,
        private: quiz.private,
      }).then(() => this.dispatch('getquizzes'))
    }
  }
})
