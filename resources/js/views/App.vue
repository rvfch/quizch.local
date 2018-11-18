<template lang="html">
    <div>
        <main class="main animated zoomIn fast">
            <header>
                <div class="logo">Hello, %user%</div>
                <nav id="navigation">
                    <router-link tag="button" :to="{ name: 'newquiz' }" class="btn btn-lg btn-green" exact-active-class="active">
                      <i class="fas fa-plus-circle"></i> <strong>New quiz</strong>
                    </router-link>
                    <ul class="side-nav">
                        <li>
                            <router-link tag="button" :to="{ name: 'myquizzes' }" class="btn btn-blue" exact-active-class="active">
                                <i class="fas fa-bars"></i> My quizzes
                            </router-link>
                        </li>
                        <li>
                            <router-link tag="button" :to="{ name: 'myresults' }" class="btn btn-blue" exact-active-class="active">
                                <i class="fas fa-table"></i> My results
                            </router-link>
                        </li>
                        <li>
                            <router-link tag="button" :to="{ name: 'stats' }" class="btn btn-blue" exact-active-class="active">
                                <i class="far fa-chart-bar"></i> Statistics
                            </router-link>
                        </li>
                        <li>
                            <router-link tag="button" :to="{ name: 'settings' }" class="btn btn-blue" exact-active-class="active">
                                <i class="fas fa-sliders-h"></i> Settings
                            </router-link>
                        </li>
                    </ul>
                    <button href="/logout" class="btn btn-blue"><i class="fas fa-sign-out-alt"></i> Log Out</button>
                </nav>
            </header>
            <section>
                <div class="top-bar">
                    top-bar
                </div>
                <div class="content">
                    <router-view></router-view>
                </div>
            </section>
        </main>
    </div>
</template>

<script>
    export default {}
</script>
