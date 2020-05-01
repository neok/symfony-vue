<template>
    <div class="filters">
        <div class="items">
            <p>Filter by genre</p>
            <button v-on:click="filterMovies" v-for="genre in genres" :key="genre" class="btn btn-primary">{{genre}}</button>
            <button v-on:click="clearFilters" class="btn btn-primary btn-sm">Clear filters</button>
        </div>
        <div class="items weeks">
            <p>Filter by week(1-33)</p>
            <b-form-select @change="onChange($event)" v-model="selected" :options="weeks" size="sm" class="mt-3"></b-form-select>
            <div class="mt-3">Selected: <strong>{{ selected }}</strong></div>
        </div>
    </div>
</template>

<script lang="ts">
    import Vue from 'vue';
    import { mapState } from 'vuex';


    export default Vue.extend({
        name: 'filters',
        data () {
            return {
                selected: null,
            }
        },
        computed: {
            ...mapState({
                genres: (state: any) => state.genres.list,
                weeks: (state: any) => state.weeks.list
            }),
        },
        methods: {
            filterMovies(event:any) {
                // @ts-ignore
                this.$store.dispatch('loadMoviesByGenre', event.target.textContent)
            },
            clearFilters(event:any) {
                // @ts-ignore
                this.$store.dispatch('loadMovies')
            },

            onChange(event:any) {

                if (event == 'all') {
                    this.$store.dispatch('loadMovies')
                } else {
                    this.$store.dispatch('loadMoviesByWeek', event)
                }
            }
        }
    })
</script>

<style scoped lang="scss">
    .filters {
        .weeks {
            margin-top: 10px;
            p {
                margin: 0;
            }
            select {
                width: 150px;
                margin-right: 25px;
                margin-top: 0;
            }
        }
        .items {
            display: flex;
            flex-direction: row;
            align-items: center;
            .btn {
                height: 40px;
                line-height: 25px;
                margin-left: 15px;
            }
        }


    }

</style>
