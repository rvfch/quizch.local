import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    //loader
    loading: true,

    //
    quizzes: [],
    results: [],
    quiz: [],

    // auth
    status: '',
    token: localStorage.getItem('token') || null,
    user: {}
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    quiz: state => {
      return state.quiz
    }
  },
  mutations: {
    AUTH_REQUEST: (state) => {
      state.status = 'loading'
    },
    AUTH_SUCCESS: (state, token) => {
      state.status = 'success'
      state.token = token
    },
    AUTH_ERROR: (state) => {
      state.status = 'error'
    },
    LOGOUT: (state) => {
      state.status = ''
      state.token = ''
      state.quizzes = []
      state.results = []
      state.quiz = []
    },
    SET_USER: (state, user) => {
      state.user = user
    },
    GET_QUIZZES: (state, quizzes) => {
      state.quizzes = quizzes
    },
    GET_RESULTS: (state, results) => {
      state.results = results
    },
    GET_QUIZ: (state, quiz) => {
      state.quiz = quiz
    },
    LOADING: (state, loading) => {
      state.loading = loading
    }
  },
  actions: {
    // auth
    login({ commit }, user) {
      return new Promise((resolve, reject) => {
        commit('AUTH_REQUEST')
        axios.post('/api/login', {
          username: user.username,
          password: user.password,
        })
        .then(resp => {
          const token = resp.data.access_token
          commit('AUTH_SUCCESS', token)
          localStorage.setItem('token', token)
          axios.defaults.headers.common['Authorization'] = 'Bearer '.concat(token)
          this.dispatch('getUser')
          resolve(resp)
        }).catch(err => {
          commit('AUTH_ERROR', err)
          localStorage.removeItem('token')
          reject(err)
        })
      })
    },
    register({ commit }, user) {
      return new Promise((resolve, reject) => {
        commit('AUTH_REQUEST')
        axios.post('/api/register', { name: user.name, email: user.email, password: user.password })
        .then(resp => {
          axios.post('/api/login', { username: user.email, password: user.password })
          .then(res => {
            const token = res.data.access_token
            commit('AUTH_SUCCESS', token)
            localStorage.setItem('token', token)
            axios.defaults.headers.common['Authorization'] = 'Bearer '.concat(token)
            this.dispatch('getUser')
            resolve(resp)
          })
        })
        .catch(err => {
          commit('AUTH_ERROR', err)
          localStorage.removeItem('token')
          reject(err)
        })
      })
    },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        axios.post('/api/logout').
        then(resp => {
          commit('LOGOUT')
          localStorage.removeItem('token')
          delete axios.defaults.headers.common['Authorization']
          resolve(resp)
        }).catch(err => {
          commit('LOGOUT')
          localStorage.removeItem('token')
          delete axios.defaults.headers.common['Authorization']
          reject(err)
        })
      })
    },
    getUser({ commit, state }) {
      return new Promise((resolve, reject) => {
        axios.get('/api/user', {
          params: {
            Authorization: 'Bearer '.concat(state.token)
          }
        })
        .then(resp => {
          commit('SET_USER', resp.data)
          this.dispatch('getquizzes')
          resolve(resp)
        })
        .catch(err => {
          reject(err)
        }
        )
      })
    },

    // quizzes
    getquizzes({ commit, state }) {
      commit('LOADING', true)
      return new Promise((resolve, reject) => {
        axios.get(`/api/quizzes/${state.user.id}`)
              .then(res => {
                let quizzes = res.data.data.map((element) => {
                  var o = Object.assign({}, element)
                  o.toggleId = false;
                  return o
                })
                commit('GET_QUIZZES', quizzes)
                commit('LOADING', false)
                resolve(res)
              }).catch(err => {
                reject(err)
              })
      })
    },
    updatequiz({ commit, state }, quiz) {
      return new Promise((resolve, reject) => {
        axios.put('/api/quiz', {
          id: quiz.id,
          title: quiz.title,
          description: quiz.description,
          user_id: quiz.user_id,
          questions_count: quiz.questions_count,
          questions: quiz.questions,
          private: quiz.private,
          password: quiz.password,
          duration: quiz.duration
        }).then(res => {
          this.dispatch('getquizzes')
          commit('LOADING', false)
          resolve(res)
        })
        .catch(err => {
          reject(err)
        })
      })
    },
    deletequiz({ commit }, quizId) {
      return new Promise((resolve, reject) => {
        axios.delete('/api/quiz/' + quizId)
            .then(res => {
              this.dispatch('getquizzes')
              commit('LOADING', false)
              resolve(res)
            })
            .catch(err => {
              reject(err)
            })
      })
    },
    addquiz({ commit, state }, quiz) {
      return new Promise((resolve, reject) => {
        axios.post('/api/quiz', {
          id: quiz.id,
          title: quiz.title,
          description: quiz.description,
          user_id: state.user.id,
          questions_count: quiz.questions_count,
          questions: quiz.questions,
          private: quiz.private,
          password: quiz.password,
          duration: quiz.duration
        }).then(res => {
          this.dispatch('getquizzes')
          commit('LOADING', false)
          resolve(res)
        })
        .catch(err => {
          reject(err)
        })
      })
    },
    getquiz({ commit, state }, quizId) {
      commit('LOADING', true)
      return new Promise((resolve, reject) => {
        axios.get(`/api/quiz/${quizId}`)
                    .then(res => {
                      commit('GET_QUIZ', res.data.data)
                      commit('LOADING', false)
                      resolve(res)
                    }
                    )
                    .catch(err => {
                      commit('GET_QUIZ', undefined)
                      reject(err)
                    }
                    )
      })
    },
    //results
    getresults({ commit, state }) {
      commit('LOADING', true)
      return new Promise((resolve, reject) => {
        axios.get(`/api/results/${state.user.id}`)
              .then(res => {
                commit('GET_RESULTS', res.data.data)
                commit('LOADING', false)
                resolve(res)
              }).catch(err => {
                reject(err)
              })
      })
    },
    addresult({ commit, state }, result) {
      return new Promise((reject, resolve) => {
        axios.post('/api/result', {
          id: '',
          user_id: state.user.id,
          quiz_id: result.quiz_id,
          right_answers: result.right_answers,
          isPassed: result.isPassed
        }).then(res => {
          this.dispatch('getresults')
          commit('LOADING', false)
          resolve(res)
        })
          .catch(err => {
            reject(err)
          })
      })
    }
  }
})
