<template lang="html">
  <div>
    <b-row class="justify-content-center align-items-center" style="height: 100vh;">
      <b-col lg="3" md="5" sm="6">
        <b-card no-body style="min-height: 300px;" class="auth">
          <b-tabs card>
            <b-tab title="Log In" active @click="alertErrors = []">
              <b-alert :show="alertErrors.length > 0" variant="danger">
                <ul>
                  <li v-for="(err, index) in alertErrors" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </b-alert>
              <b-form @submit.prevent="logIn()" action="#">
                <b-form-group id="loginEmailInputGroup"
                              label="Email address:"
                              label-for="loginEmailInput">
                    <b-form-input id="loginEmailInput" label="E-mail:" type="email" required placeholder="E-mail..." v-model="inputEmail">
                    </b-form-input>
                </b-form-group>

                <b-form-group id="loginPasswordInputGroup"
                              label="Password:"
                              label-for="loginPasswordInput">
                    <b-form-input id="loginPasswordInput" label="Password:" type="password" required placeholder="Password..." v-model="inputPassword">
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="outline-success" class="w-100">Log In</b-button>
              </b-form>
            </b-tab>
            <b-tab title="Sign Up" @click="alertErrors = []">
              <b-alert :show="alertErrors.length > 0" variant="danger">
                <ul>
                  <li v-for="(err, index) in alertErrors" :key="index">
                    {{ err }}
                  </li>
                </ul>
              </b-alert>
              <b-form @submit.prevent="register()" action="#">
                <b-form-group id="regEmailInputGroup"
                              label="Email address:"
                              label-for="regEmailInput">
                    <b-form-input id="regEmailInput" label="E-mail:" type="email" required placeholder="E-mail..." v-model="inputEmail">
                    </b-form-input>
                </b-form-group>
                <b-form-group id="regNameInputGroup"
                              label="Your name:"
                              label-for="regNameInput">
                    <b-form-input id="regNameInput" label="Repeat password:" type="text" required placeholder="Your name..." v-model="inputName">
                    </b-form-input>
                </b-form-group>
                <b-form-group id="regPpasswordInputGroup"
                              label="Password:"
                              label-for="regPasswordInput">
                    <b-form-input id="regPasswordInput" label="Password:" type="password" required placeholder="Password..." v-model="inputPassword">
                    </b-form-input>
                </b-form-group>
                <b-form-group id="regRepeatPasswordInputGroup"
                              label="Repeat password:"
                              label-for="regRepeatPasswordInput">
                    <b-form-input id="regRepeatPasswordInput" label="Repeat password:" type="password" required placeholder="Repeat password..." v-model="inputRepeatPassword">
                    </b-form-input>
                </b-form-group>
                <b-button type="submit" variant="outline-primary" class="w-100">Sign Up</b-button>
              </b-form>
            </b-tab>
          </b-tabs>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  data() {
    return {
      inputEmail: '',
      inputPassword: '',
      inputRepeatPassword: '',
      inputName: '',
      alertErrors: []
    }
  },
  methods: {
    pushError: function(errors) {
      this.alertErrors = []
      errors.forEach((element) => {
        this.alertErrors.push(element)
      })
    },
    logIn: function() {
      this.$store.dispatch('login', { username: this.inputEmail, password: this.inputPassword })
      .then(resp => {
        this.$router.push('/')
      })
      .catch(err => {
        if (err.response.data === 'INCORRECT_DATA') {
          this.pushError(['Incorrect username or password.'])
        } else {
          this.pushError(['Incorrect username or password.'])
        }
      })
    },
    register: function() {
      let email = this.inputEmail,
          password = this.inputPassword,
          repeatPassword = this.inputRepeatPassword,
          name = this.inputName

      if (password === repeatPassword) {
        this.$store.dispatch('register', {
          email: email,
          name: name,
          password: password
         })
        .then(resp => this.$router.push('/'))
        .catch(err => {
            if (err.response.data.errors.email !== undefined) {
              this.pushError([err.response.data.errors.email[0]])
            } else if (err.response.data.errors.password !== undefined) {
              this.pushError(['The password must be at least 6 characters.'])
            }
          })
      } else {
          this.pushError(['Wrong password repeat.'])
      }
    }
  }
}
</script>

<style scoped>
.row {
  background: linear-gradient(to right, #56ccf2, #2f80ed);
}

ul {
  list-style: none;
  margin: 0;
  padding: 0;
}

.auth {
  box-shadow: 0 0 100px rgba(0,0,0,.15);
}
</style>
