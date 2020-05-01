<template>
    <div id="app">

                <b-navbar type="dark" variant="dark">
                    <b-navbar-nav>
                      <b-nav-item href="#/">Home</b-nav-item>
                        <search></search>
                    </b-navbar-nav>
                </b-navbar>
                <router-view/>
        </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import Home from './components/list/MovieList.vue'
    import Search from './components/search/search.vue'

    export default Vue.extend({
        name: 'app',
        components: {
            Home,
            Search
        }
    })
</script>


