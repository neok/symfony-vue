<template>
    <section>
        <div class="container">
            <div class="row">
                <h1>All movies</h1>

                <div class="col-lg-12">
                    <filters></filters>
                </div>
                <div class="col-lg-12 movies">
                    <div v-for="movie in movies" :key="movie.id" class="movie-card">
                        <img :src="movie.image_src" :alt="movie.title" />
                        <h4>{{movie.title}}</h4>
                        <p>Showtimes</p>
                        <div v-for="showtime in movie.showtimes" :key="showtime.id" class="showtime">
                            {{showtime.showtime}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script lang="ts">
    import Vue from 'vue';
    import { mapState } from 'vuex';
    import Filters from '../filters/filters';


    export default Vue.extend({
        name: 'movies',
        components: {
            Filters
        },
        computed: {
            ...mapState({
                movies: (state: any) => state.movies
            }),
        },
        mounted(): void {
            this.$store.dispatch('loadMovies')
        }
    })
</script>

<style scoped lang="scss">
    .movies {
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        .showtime {
            font-size: 8px;
        }
        .movie-card {
            display: flex;
            max-width: 158px;
            padding: 15px;
            flex-direction: column;

            img {
                width: 100%;
                max-width: 150px;
                border: 1px solid #ececec;
            }
        }
    }

</style>
