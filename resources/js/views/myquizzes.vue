<template lang="html">
    <div>
      <b-alert show variant="danger" v-if="quizzes.length === 0">You don't have quizzes.</b-alert>
        <b-table v-else responsive :fields="fields" :items="quizzes">
          <template slot="options" slot-scope="row">
            <b-button-group size="sm">
              <b-button variant="warning"><font-awesome-icon :icon="['fas', 'edit']"></font-awesome-icon></b-button>
              <b-button variant="danger" @click="deletequiz(row.item.id)"><font-awesome-icon :icon="['fas', 'trash-alt']"></font-awesome-icon></b-button>
            </b-button-group>
          </template>

          <template slot="private" slot-scope="row">
            <b-button v-if="row.item.private === 0" size="sm" variant="outline-danger" @click="row.item.private = 1; update(row.item.id, row.item)"><font-awesome-icon :icon="['fas', 'lock-open']"></font-awesome-icon></b-button>
            <b-button v-else variant="outline-success" size="sm" @click="row.item.private = 0; update(row.item.id, row.item)"><font-awesome-icon :icon="['fas', 'lock']"></font-awesome-icon></b-button>
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
      },
      deletequiz(id) {
        if(confirm('Are you sure?'))
          this.$store.dispatch('deletequiz', id)
      }
    }
}
</script>

<style lang="scss">
.table td {
  vertical-align: middle!important;
}
</style>
