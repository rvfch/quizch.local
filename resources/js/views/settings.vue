<template lang="html">
    <div>
        <div class="form-content">
            <div class="form-full">
                <div class="form-row">
                    <h1>Main settings</h1>
                </div>
                <div class="form-row">
                    <label for="email">E-mail:</label>
                    <input type="text" name="email" value="rvfchdev@gmail.com">
                </div>
                <div class="form-row">
                    <label for="username">Name:</label>
                    <input type="text" name="username" value="Roman Filatov">
                </div>
                <div class="form-row">
                    <button type="button" class="btn btn-blue w100">Change settings</button>
                </div>
                <div class="form-row">
                    <h1>Password</h1>
                </div>
                <div class="form-row">
                    <input type="password" placeholder="Old password..." />
                </div>
                <div class="form-row">
                    <input type="password" placeholder="New password...">
                </div>
                <div class="form-row">
                    <button type="button" class="btn btn-green w100">Change password</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {}
</script>

<style lang="css">
</style>
