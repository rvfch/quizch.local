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
                                    <input type="text" name="newQuestionText" id="newQuestionText" v-model="questionText" class="form-control mb-2">

                                    <label>Answers: </label>

                                    <div class="input-group mb-2" v-for="(answer, index) in answers" :key="index">
                                        <input type="text" :name="'newQuestionAnswer'+(index)" v-model="answers[index].text"
                                            class="form-control">
                                        <div class="input-group-append">
                                            <button type="button" class="btn btn-success" :disabled="answers[index].correct == 1"
                                                @click="selectAnswer(index)"><i class="fas fa-check"></i></button>
                                            <button type="button" class="btn btn-danger" :disabled="answers[index].correct == 0"
                                                @click="selectAnswer(index)"><i class="fas fa-times"></i></button>
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
        <div class="form-group row">
            <label for="email" class="col-sm-4 col-form-label text-md-right">Questions:</label>

            <div class="col-md-6">
                <button id="show-modal" class="btn btn-sm btn-primary mt-2" @click="showModal = true">Add question</button>
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
        data() {
            return {
                answers: [],
                questions: [],
                questionText: '',
                showModal: false,
                maxAnswersCount: 4,
                minAnswersCount: 2,
                addAnswerButton: true
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
                console.log(this.questionText);
                console.log(this.answers);
            },
            selectAnswer(index) {
                for (let i in this.answers) {
                    this.answers[i].correct = 0;
                }
                this.answers[index].correct = 1;
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
