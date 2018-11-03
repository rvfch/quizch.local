<template>
    <div id="newquiz">
        <div v-if="showModal">
            <transition name="modal">
                <div class="modal-mask">
                    <div class="modal-wrapper">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">New question</h5>
                                    <button type="button" class="close" @click="showModal = false" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <label for="newQuestionText">Question text: </label>
                                    <input type="text" name="newQuestionText" id="newQuestionText" v-model="questionText"
                                        class="form-control mb-2" required>

                                    <label>Answers: </label>

                                    <div class="input-group mb-2" v-for="(answer, index) in answers" :key="index">
                                        <input type="text" :name="'newQuestionAnswer'+(index)" v-model="answers[index].text"
                                            class="form-control" required>
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" :disabled="answers[index].correct == 1"
                                                @click="selectAnswer(index)"><i class="fas fa-check"></i></button>
                                        </div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-primary mt-2" v-if="addAnswerButton"
                                        @click="addNewAnswer()">+</button>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" @click="showModal = false">Close</button>
                                    <button type="button" class="btn btn-success" @click="saveQuestion(); showModal = false;">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </transition>
        </div>
        <div class="container">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Title: </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="My new quiz..." required v-model="quizTitle">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Time (minutes): </label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" placeholder="60" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">Type: </label>
                    <div class="col-sm-4">
                        <div class="btn-group btn-group-toggle">
                            <label class="btn btn-success " :class="{'active': isPrivate === 0}">
                                <input type="radio" id="typepublic" value="0" v-model="isPrivate"> Public
                            </label>
                            <label class="btn btn-danger" :class="{'active': isPrivate === 1}">
                                <input type="radio" id="typeprivate" value="1" v-model="isPrivate"> Private
                            </label>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <label v-if="questions.length > 0" class="col-sm-2 col-form-label">Questions: </label>
                    <div class="col-sm-4">
                        <ul class="list-group">
                            <li class="list-group-item" v-if="questions" v-for="question in questions" :key="question.id">
                                {{
                                question.text }}</li>
                        </ul>
                    </div>
                </div>
                <div class="form-group row">
                    <button id="show-modal" class="btn btn-sm btn-primary mt-2" @click="showModal = true">Add
                        question</button>
                </div>
                
                <div class="form-group row">
                    <button type="button" class="btn btn-success" @click="createQuiz()">Create quiz</button>

                </div>
        </div>
    </div>
</template>

<script>
    Vue.component('modal', {
        template: '#newQuestionModal'
    });

    export default {
        name: 'newQuiz',
        props: ['user_id'],
        data() {
            return {
                questions: [],
                answers: [],
                showModal: false,
                questionText: '',
                maxAnswersCount: 4,
                minAnswersCount: 2,
                addAnswerButton: true,
                isPrivate: 0,
                quizTitle: '',
                quiz: {
                    id: '',
                    title: '',
                    user_id: '',
                    questions_count: '',
                    private: '',
                    crated_at: '',
                    questions: [],
                }
            }
        },
        methods: {
            addNewAnswer() {
                if (this.answers.length <= this.maxAnswersCount - 1) {
                    this.answers.push({
                        text: '',
                        correct: 0
                    });
                }
                if (this.answers.length > this.maxAnswersCount - 1) {
                    this.addAnswerButton = false;
                }
            },
            saveQuestion() {
                this.questions.push({
                    id: '',
                    text: this.questionText,
                    answers: this.answers
                });
                this.questionText = '';
                this.answers = [];
                this.answers.push({
                    text: '',
                    correct: 1
                });
                this.addNewAnswer();
                this.addAnswerButton = true;
            },
            selectAnswer(index) {
                for (let i in this.answers) {
                    this.answers[i].correct = 0;
                }
                this.answers[index].correct = 1;
            },
            createQuiz() {
                this.quiz.title = this.quizTitle;
                this.quiz.user_id = this.user_id;
                this.quiz.questions_count = this.questions.length;
                this.quiz.private = this.isPrivate;
                this.quiz.questions = this.questions;
                fetch('/api/quiz', {
                            method: 'post',
                            body: JSON.stringify(this.quiz),
                            headers: {
                                'content-type': 'application/json'
                            }
                        })
                        .then(res => res.json())
                        .then(data => {
                            console.log("quiz created");
                        })
                        .catch(err => console.log(err));
            }
        },
        mounted() {
            this.answers.push({
                text: '',
                correct: 1
            });
            this.addNewAnswer();
        }
    }

</script>

<style>
    .modal-mask {
        position: fixed;
        z-index: 9998;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, .5);
        display: table;
        transition: opacity .3s ease;
    }

    .modal-wrapper {
        display: table-cell;
        vertical-align: middle;
    }

</style>
