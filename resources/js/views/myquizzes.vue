<template lang="html">
    <div>
        <table class="table table-fixed">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Created at</th>
                    <th>Passed by</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="fas fa-lock-open black"></i></td>
                    <td><a href="#">Test quiz</a></td>
                    <td>This is my quiz about fruits.</td>
                    <td>11.11.2018</td>
                    <td>5346 users</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-yellow btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-red btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                            <button class="btn btn-green btn-sm">
                                <i class="fas fa-lock"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="css">
</style>
