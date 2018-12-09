<template lang="html">
  <div v-if="$store.state.loading" class="loading">
    Loading...
  </div>
  <b-alert show v-else-if="quizzes.length === 0" variant="danger">You don't have quizzes.</b-alert>
    <div v-else>
        <b-table responsive :fields="fields" :items="quizzes" sort-desc.sync="true">
          <template slot="options" slot-scope="row">
            <b-button-group size="sm">
              <b-button variant="warning"><font-awesome-icon :icon="['fas', 'edit']"></font-awesome-icon></b-button>
              <b-button variant="danger" @click="deletequiz(row.item.id)"><font-awesome-icon :icon="['fas', 'trash-alt']"></font-awesome-icon></b-button>
              <b-button variant="secondary" @click.stop="row.toggleDetails"><font-awesome-icon :icon="['fas', 'link']"></font-awesome-icon></b-button>
            </b-button-group>
          </template>

          <template slot="private" slot-scope="row">
            <b-button-group size="sm">
            <b-button v-if="row.item.private === 0" size="sm" variant="outline-danger" @click="row.item.private = 1; update(row.item.id, row.item)"><font-awesome-icon :icon="['fas', 'lock-open']"></font-awesome-icon></b-button>
            <b-button v-else variant="outline-success" size="sm" @click="row.item.private = 0; update(row.item.id, row.item)"><font-awesome-icon :icon="['fas', 'lock']"></font-awesome-icon></b-button>
            <b-button size="sm" variant="outline-info"><font-awesome-icon :icon="['fas', 'eye']"></font-awesome-icon></b-button>
          </b-button-group>
          </template>

          <template slot="title" slot-scope="row">
            <a href="#"><strong>{{ row.item.title }}</strong></a>
          </template>

          <template slot="row-details" slot-scope="row">
        <b-card>
          <b-input-group>
            <b-form-input type="text" disabled :value="`http://quizch.local/quiz/${row.item.hash}`" ref="quizURL"></b-form-input>
            <b-button variant="outline-primary" slot="prepend" type="button" @click="copyURL()">
              <font-awesome-icon :icon="['fas', 'copy']"></font-awesome-icon>
            </b-button>
          </b-input-group>
        </b-card>
      </template>
        </b-table>
    </div>
</template>

<script>

export default {
    data() {
        return {
            fields: [
              {
                key: 'private',
                label: '#',
              },
              {
                key: 'title',
                label: 'Title',
              },
              {
                key: 'description',
                label: 'Description',

              },
              {
                key: 'created_at',
                label: 'Date',
              },
              {
                key: 'users',
                label: 'Users',
              },
              {
                key: 'options',
                label: 'Options',
              }
            ]
        }
    },
    computed: {
      quizzes() {
        return this.$store.state.quizzes
      }
    },
    mounted() {
        this.$store.dispatch('getquizzes')
    },
    methods: {
      copyURL() {
        this.$copyText(this.$refs.quizURL.value)
      },
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
