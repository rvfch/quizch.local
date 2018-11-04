<template>
    <div id="myresults">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th scope="col">Quiz title</th>
                    <th scope="col">Your points</th>
                    <th scope="col">Passed?</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(result,index) in results" :key="index">
                    <td class="align-baseline">{{ result.quiz_title }}</td>
                    <td class="align-baseline">
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" :style="{width: calculatePercentage(result.right_answers, result.total_questions) + '%'}" :aria-valuenow="calculatePercentage(result.right_answers, result.total_questions)" aria-valuemin="0"
                                aria-valuemax="100">{{ result.right_answers }} / {{ result.total_questions }}</div>
                        </div>
                    </td>
                    <td v-if="result.isPassed" class="align-baseline"><span class="badge badge-success" style="width:100%;">Success</span></td>
                    <td v-else class="align-baseline"><span class="badge badge-danger" style="width:100%;">Failed</span></td>
                    <td class="align-baseline text-right"><a href="#" class="btn btn-primary btn-sm">Open</a></td>
                </tr>
            </tbody>
        </table>
        <nav>
            <ul class="pagination">
                <li :class="[{disabled: !pagination.prevPageUrl}]" class="page-item"><a @click="fetchQuizzes(pagination.prevPageUrl);" class="page-link" href="#">Previous</a></li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{ pagination.currentPage }} of {{ pagination.lastPage }}</a></li>
                <li :class="[{disabled: !pagination.nextPageUrl}]" class="page-item"><a @click="fetchQuizzes(pagination.nextPageUrl);" class="page-link" href="#">Next</a></li>
            </ul>
        </nav>
    </div>
</template>

<script>
    export default {
        name: 'myresults',
        props: ['user_id'],
        data() {
            return {
                results: [],
                pagination: {}
            }
        },
        methods: {
            fetchResults(pageUrl) {
                let app = this;
                pageUrl = pageUrl || '/api/results/' + this.user_id;
                fetch(pageUrl)
                    .then(res => res.json())
                    .then(res => {
                        this.results = res.data;
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
            calculatePercentage(current, total) {
                return ((current / total) * 100).toString();
            }
        },
        created() {
            this.fetchResults();
        }
    }

</script>
