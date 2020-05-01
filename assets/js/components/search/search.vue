<template>
    <div class="search">
        <b-navbar  type="dark" variant="dark">
            <b-nav-form>
                <b-input-group prepend="@">

                    <b-form-input
                            v-model="searchQuery"
                            placeholder="Search"
                            icon="magnify"
                            @keypress="onClickSearch"
                            >

                    </b-form-input>
                    <p class="control" v-if="searchQuery">
                        <button @click="onClickClearSearch" class="btn btn-primary"></button>
                    </p>
                </b-input-group>
            </b-nav-form>
        </b-navbar>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import { mapState } from 'vuex';
    // import _ from 'lodash'
    import _ from 'lodash';

    export default Vue.extend({
        name: 'search',
        data () {
            return {
                searchQuery: '',
            }
        },
        mounted () {
            this.searchQuery = '';
            this.onClickSearch()
        },
        watch: {
            searchQuery: {
                handler: _.debounce(function (val) {
                    if (val === '') {
                        //@ts-ignore
                        this.$store.commit('CLEAR_SEARCH')
                    } else {
                        //@ts-ignore
                        if (val !== this.newSearchQuery) {
                            //@ts-ignore
                            this.onClickSearch()
                        }
                    }
                }, 1000)
            },
            newSearchQuery (val) {
                //@ts-ignore

                this.searchQuery = val
            }
        },

        methods: {
            onClickSearch () {
                this.$store.dispatch('searchByTitle', this.searchQuery)
            },
            onClickClearSearch () {
                this.searchQuery = '';
                this.$store.dispatch('searchByTitle', '')
            }
        }
    })
</script>

<style scoped lang="scss">


</style>
