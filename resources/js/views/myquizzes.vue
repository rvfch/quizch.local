<template lang="html">
    <div>
        <b-table responsive :fields="fields" :items="quizzes">
          <template slot="options" slot-scope="row">
            <b-button-group size="sm">
              <b-button variant="warning"><font-awesome-icon :icon="['fas', 'edit']"></font-awesome-icon></b-button>
              <b-button variant="danger"><font-awesome-icon :icon="['fas', 'trash-alt']"></font-awesome-icon></b-button>
              <b-button v-if="row.item.private === 0" variant="success" @click="update(row.item.id, {id: row.item.id, title: row.item.title, description: row.item.description, private: 1, answers_count: row.item.questions_count })"><font-awesome-icon :icon="['fas', 'lock']"></font-awesome-icon></b-button>
              <b-button v-else variant="danger" @click="update(row.item.id, {id: row.item.id, title: row.item.title, description: row.item.description, private: 0, answers_count: row.item.questions_count })"><font-awesome-icon :icon="['fas', 'lock-open']"></font-awesome-icon></b-button>
            </b-button-group>
          </template>

          <template slot="private" slot-scope="row">
            <font-awesome-icon v-if="row.item.private" :icon="['fas', 'lock']"></font-awesome-icon>
            <font-awesome-icon v-else :icon="['fas', 'lock-open']"></font-awesome-icon>
          </template>

          <template slot="title" slot-scope="data">
            <strong><a href="#">{{ data.value }}</a></strong>
          </template>
        </b-table>
    </div>
</template>

<script>
import axios from 'axios'

export default {
    data() {
        return {
            fields: [
              {
                key: 'private',
                label: '#'
              },
              {
                key: 'title',
                label: 'Title'
              },
              {
                key: 'description',
                label: 'Description'
              },
              {
                key: 'created_at',
                label: 'Date'
              },
              {
                key: 'users',
                label: 'Users'
              },
              {
                key: 'options',
                label: 'Options'
              }
            ]
        }
    },
    computed: {
      userId() {
        return this.$store.state.userId
      },
      quizzes() {
        return this.$store.state.quizzes
      }
    },
    mounted() {
        this.$store.dispatch('getquizzes')
    },
    methods: {
      update(id, data) {
        this.$store.dispatch('updatequiz', data)
      }
    }
}
</script>

<style lang="css">
</style>
