<template lang="html">
    <div>
        <div class="form-content">
            <div class="form-left">
                <div class="form-row">
                    <input type="text" placeholder="Title" required>
                </div>
                <div class="form-row">
                    <textarea placeholder="Description" rows="10" required></textarea>
                </div>
                <div class="form-row">
                    <div class="input-group-prepend">
                        <span><i class="fas fa-clock"></i></span>
                        <input type="text" placeholder="59:59">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-green"><i class="fas fa-calendar-times"></i></button>
                        <input type="datetime-local">
                    </div>
                </div>
                <div class="form-row">
                    <div class="input-group-prepend">
                        <button type="button" class="btn btn-green"><i class="fas fa-lock"></i></button>
                        <input type="password" placeholder="Password">
                    </div>
                </div>

            </div>
            <div class="form-right">
                <div class="form-row">
                    <div class="card card-hover">
                        <div class="card-body">
                            <div class="card-row">Do you like apples?
                                <div class="card-options">
                                    <a href="#"><i class="fas fa-edit"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-row">Do you like apples?
                                <div class="card-options">
                                    <a href="#"><i class="fas fa-edit"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-row">Do you like apples?
                                <div class="card-options">
                                    <a href="#"><i class="fas fa-edit"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-row">Do you like apples?
                                <div class="card-options">
                                    <a href="#"><i class="fas fa-edit"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                            <div class="card-row">Do you like apples?
                                <div class="card-options">
                                    <a href="#"><i class="fas fa-edit"></i></a>
                                    <a href="#"><i class="fas fa-trash-alt"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <button type="button" class="btn btn-blue"><i class="fas fa-plus"></i>Add question</button>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-green btn-lg w100"><i class="fas fa-plus-circle"></i>Create quiz</button>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="css">
</style>
