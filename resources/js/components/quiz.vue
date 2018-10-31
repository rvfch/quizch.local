<template>
    <div class="panel panel-primary">
        <div v-if="currentQuestion != questions_count">
        <div class="panel-heading">
            <h3 class="panel-title" v-if="questions[currentQuestion]">
                {{ questions[currentQuestion].question_text }}
            </h3>
        </div>
        <div class="panel-body" v-if="answers">
            <div class="radio" v-for="answer in answers" :key="answer.id">
                <label>
                    <input type="radio" name="optionsRadios" v-model="answer.text" :id="'option'+(answer.id+1)" :value="answer.text"> 
                    {{ answer.text }}
                </label>
            </div>
        </div>
        <div class="panel-footer">
            <div v-if="currentQuestion == questions_count - 1">
                <a href="#" class="btn btn-primary" role="button" @click="currentQuestion++; endQuiz();">End Quiz</a>
            </div>
            <div v-else>
                <a href="#" class="btn btn-primary" role="button" @click="currentQuestion++; loadAnswers();">Next question</a>
            </div>
            </div>
        </div>
        <div v-else>
            Quiz ended
        </div>
        </div>
</template>

<script>
    export default {
        props: [ 'quiz_id' ],
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
                questions_count: 0
            };
        },
        methods: {
            fetchQuiz() {
                fetch('/api/quiz/'+this.quiz_id)
                    .then(res => res.json())
                    .then(res => {
                        this.questions = res.data.questions;
                        this.questions_count = res.data.questions_count;
                        this.answers = res.data.questions[0].answers;
                    })
                    .catch(err => console.log(err));
            },
            loadAnswers() {
                this.answers = this.questions[this.currentQuestion].answers;
            },
            endQuiz()
            {

            }
        },
        created() {
            this.fetchQuiz();
            this.loadAnswers();
        }
    }

</script>
