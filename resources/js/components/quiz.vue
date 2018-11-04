<template>
    <div class="panel panel-primary">
        <div v-if="currentQuestion != questions_count">
            <div class="panel-heading">
                <h3 class="panel-title" v-if="questions[currentQuestion]">
                    {{ questions[currentQuestion].question_text }}
                </h3>
            </div>
            <div class="panel-body" v-if="answers">
                <div class="radio" v-for="(answer,index) in answers" :key="index">
                    <label>
                        <input type="radio" name="optionsRadios" v-model="answer.id" :id="'option'+(answer.id+1)"
                            :value="index" @click="selectedAnswerId = index">
                        {{ answer.text }}
                    </label>
                </div>
            </div>
            <div class="panel-footer">
                <div v-if="currentQuestion === questions_count - 1">
                    <a href="#" class="btn btn-primary" role="button" @click="checkQuestion(selectedAnswerId); currentQuestion++; endQuiz(); ">End
                        Quiz</a>
                </div>
                <div v-else>
                    <a href="#" class="btn btn-primary" role="button" @click="checkQuestion(selectedAnswerId); currentQuestion++; loadAnswers(); ">Next
                        question</a>
                </div>
            </div>
        </div>
        <div v-if="quizEnded">
            You have {{ userPoints }} points.
        </div>
    </div>
</template>

<script>
    export default {
        name: 'quiz',
        props: ['quiz_id', 'user_id'],
        data() {
            return {
                questions: [],
                answers: [],
                question: {
                    id: '',
                    text: ''
                },
                answer: {
                    id: '',
                    text: '',
                    correct: ''
                },
                currentQuestion: 0,
                questions_count: 0,
                userPoints: 0,
                selectedAnswerId: '',
                quizEnded: false,
                quizTitle: '',
                result: {
                    id: '',
                    user_id: '',
                    quiz_id: '',
                    quiz_title: '',
                    total_questions: '',
                    right_answers: '',
                    isPassed: ''
                }
            };
        },
        methods: {
            fetchQuiz() {
                fetch('/api/quiz/' + this.quiz_id)
                    .then(res => res.json())
                    .then(res => {
                        this.quizTitle = res.data.title;
                        this.questions = res.data.questions;
                        this.questions_count = res.data.questions_count;
                        this.answers = res.data.questions[0].answers;
                    })
                    .catch(err => console.log(err));
            },
            loadAnswers() {
                this.answers = this.questions[this.currentQuestion].answers;
            },
            endQuiz() {
                this.quizEnded = true;
                this.result.user_id = this.user_id;
                this.result.quiz_id = this.quiz_id;
                this.result.quiz_title = this.quizTitle;
                this.result.total_questions = this.questions.length;
                this.result.right_answers = this.userPoints;
                if (this.userPoints >= this.questions.length / 2) {
                    this.result.isPassed = 1;
                }
                else {
                    this.result.isPassed = 0;
                }
            

                fetch('/api/result', {
                        method: 'post',
                        body: JSON.stringify(this.result),
                        headers: {
                            'content-type': 'application/json'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {

                    })
                    .catch(err => console.log(err));
            },
            checkQuestion(answer_id) {
                if (answer_id != '') {
                    if (this.answers[answer_id].correct === 1)
                        this.userPoints++;
                    this.selectedAnswerId = '';
                }
            }
        },
        created() {
            this.fetchQuiz();
            this.loadAnswers();
        }
    }

</script>
