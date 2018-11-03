<template>
    <div id="myquizzes">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Title</th>
                    <th scope="col">Created at</th>
                    <th scope="col">Private</th>
                    <th scope="col">Options</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(quiz, index) in this.quizzes" :key="quiz.id">
                    <td><a :href="'/quiz/'+quiz.id"><strong>{{ quiz.title }}</strong></a></td>
                    <td>{{ quiz.created_at }}</td>
                    <td>
                        <i v-if="quiz.private == 1" class="fas fa-lock"></i>
                        <i v-else class="fas fa-unlock"></i>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button href="#" type="button" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></button>
                            <button href="#" type="button" class="btn btn-sm btn-danger" @click="deleteQuiz(quiz.id)"><i
                                    class="fas fa-trash-alt"></i></button>
                            <button href="#" type="button" class="btn btn-sm btn-primary"><i class="fas fa-info"></i></button>
                            <button href="#" type="button" class="btn btn-sm btn-success" @click="privateQuiz(index, quiz.private)">
                                <i v-if="quiz.private == 1" class="fas fa-unlock"></i>
                                <i v-else class="fas fa-lock"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prevPageUrl}]" class="page-item"><a @click="fetchQuizzes(pagination.prevPageUrl);" class="page-link" href="#">Previous</a></li>

                <li :class="[{disabled: !pagination.nextPageUrl}]" class="page-item"><a @click="fetchQuizzes(pagination.nextPageUrl);" class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>

</template>

<script>
    export default {
        name: 'myquizzes',
        props: [
            'user_id'
        ],
        data() {
            return {
                quizzes: [],
                pagination: {}
            }
        },
        methods: {
            fetchQuizzes(pageUrl) {
                let app = this;
                pageUrl = pageUrl || '/api/quizzes/' + this.user_id;
                fetch(pageUrl)
                    .then(res => res.json())
                    .then(res => {
                        this.quizzes = res.data;
                        app.makePagination(res.meta, res.links);
                    })
                    .catch(err => console.log(err));
            },
            makePagination(meta, links) {
                let pagination = {
                    currentPage: meta.current_page,
                    lastPage: meta.last_page,
                    nextPageUrl: links.next,
                    prevPageUrl: links.prev
                }

                this.pagination = pagination;
            },
            privateQuiz(index, state) {
                if (state == 1) {
                    this.quizzes[index].private = 0;
                    fetch('/api/quiz', {
                            method: 'put',
                            body: JSON.stringify(this.quizzes[index]),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.fetchQuizzes(this.pagination.currentPage);
                        })
                        .catch(err => console.log(err));
                } else {
                    this.quizzes[index].private = 1;
                    fetch('/api/quiz', {
                            method: 'put',
                            body: JSON.stringify(this.quizzes[index]),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            this.fetchQuizzes(this.pagination.currentPage);
                        })
                        .catch(err => console.log(err));
                }
            },
            deleteQuiz(quiz_id) {
                console.log(quiz_id);
                fetch('/api/quiz/' + quiz_id, {
                        method: 'delete'
                    })
                    .then(res => res.json())
                    .then(data => {
                        this.fetchQuizzes(this.pagination.currentPage);
                    })
                    .catch(err => console.log(err));
            }
        },
        created() {
            this.fetchQuizzes();

        }
    }

</script>
