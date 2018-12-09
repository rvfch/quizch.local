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
        <b-form-group id="firstNameInputGroup" label="First name: " label-for="firstNameInput">
          <b-form-input id="firstNameInput" type="text" placeholder="..."></b-form-input>
        </b-form-group>
        <b-form-group id="lastNameInputGroup" label="Last name: " label-for="lastNameInput">
          <b-form-input id="lastNameInput" type="text" placeholder="..."></b-form-input>
        </b-form-group>
        <b-btn variant="primary" class="w-100">Change name</b-btn>
      </b-col>
      <b-col>
        <h4>Change password</h4>
        <b-form-group id="oldPasswordInputGroup" label="Old password: " label-for="oldPasswordInput">
          <b-form-input id="oldPasswordInput" type="password" placeholder="Old password..."></b-form-input>
        </b-form-group>
        <b-form-group id="newPasswordInputGroup" label="New password: " label-for="newPasswordInput">
          <b-form-input id="newPasswordInput" type="password" placeholder="New password..."></b-form-input>
        </b-form-group>
        <b-btn variant="primary" class="w-100">Change password</b-btn>
      </b-col>
    </b-form-row>
  </div>
</template>

<script>
    export default {}
</script>

<style lang="css">
</style>
