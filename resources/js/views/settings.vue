<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
  <div v-else>
    <b-card class="mb-3">
      <span style="font-weight: 500; font-size:18px;">ID: {{ $store.state.user.id }}</span>
    </b-card>
    <b-form-row>
      <b-col>
        <h4>Change name</h4>
        <div class="h-100 d-flex flex-column justify-content-between">
        <b-form-group id="nameInputGroup" label="Name: " label-for="nameInput">
          <b-form-input id="nameInput" type="text" v-model="nameInput" :value="$store.state.user.name"></b-form-input>
        </b-form-group>
        <b-btn variant="primary" class="w-100 mt-0" @click="updateUser()">Change name</b-btn>
        </div>
      </b-col>
      <b-col>
        <h4>Change password</h4>
        <div class="h-100 d-flex flex-column justify-content-between">
          <div>
        <b-form-group id="oldPasswordInputGroup" label="Old password: " label-for="oldPasswordInput">
          <b-form-input id="oldPasswordInput" type="password" v-model="oldPasswordInput" placeholder="Old password..."></b-form-input>
        </b-form-group>
        <b-form-group id="newPasswordInputGroup" label="New password: " label-for="newPasswordInput">
          <b-form-input id="newPasswordInput" type="password" v-model="passwordInput" placeholder="New password..."></b-form-input>
        </b-form-group>
        </div>
        <b-btn variant="primary" class="w-100 mt-0" @click="updateUser()">Change password</b-btn>
      </div>
      </b-col>
    </b-form-row>
  </div>
</template>

<script>
    export default {
      data() {
        return {
          oldPasswordInput: '',
          passwordInput: '',
          nameInput: '',
          data: null
        }
      },
      mounted() {

      },
      methods: {
        updateUser() {
          this.data = {
            name: this.nameInput,
            password: this.passwordInput,
            oldPassword: this.oldPasswordInput,
          }
          this.$store.dispatch('updateuser', this.data)
          alert('User updated')
        }
      }
    }
</script>

<style lang="css">
</style>
