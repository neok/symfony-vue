import Vue from 'vue';
import Vuex, {mapState} from 'vuex';
import {Movie} from '../interfaces/models';
import Api from '../services/api'

Vue.use(Vuex);


export default new Vuex.Store({
    state: {
        movies: [],
        weeks: {
            active: 'all',
            list: ['all',15,16,17,18]
        },
        genres: {
            active: '',
            list: [
                'comedy',
                'thriller',
                'detective'
            ]
        },
        searchQuery: '',
    },
    getters: {
        SEARCH_QUERY: (state) => {
            return state.searchQuery
        },
        GET_MOVIES: (state) => {
            return state.movies
        }
    },
    mutations: {
        CLEAR_SEARCH: (state) => {
            state.movies = []
            state.searchQuery = ''
        },
        SET_SEARCH_QUERY: (state, query) => {
            state.searchQuery = query
        },
        SET_MOVIES(state, movies) {
            state.movies = movies;
        },
        ADD_MOVIE(state, movie) {
            let movies = state.movies.concat(movie);
            state.movies = movies;
        },
        DELETE_MOVIE(state, movieId){
            let movies = state.movies.filter((v: Movie) => v.id != movieId)
            state.movies = movies;
        },
        EDIT_MOVIE(state, movie) {
            let v = state.movies.find((v: Movie) => v.id == movie.id)
            v = movie;
        },

        //genres
        SET_ACTIVE_GENRE(state, genre) {
            state.genres.active = genre;
        },

        SET_ACTIVE_WEEK(state, week) {
            state.weeks.active = week;
        }
    },
    plugins: [],
    actions: {
        async searchByTitle({commit}, searchQuery) {
            let response = await Api.get('/movies?title=' + searchQuery);
            let movies = response.data;
            commit('SET_MOVIES', movies.map((v: Movie) => v));
            commit('SET_ACTIVE_GENRE', '');
            commit('SET_SEARCH_QUERY', searchQuery);
        },
        async loadMoviesByWeek({commit}, week) {
            if (this.state.weeks.active == week) {
                return;
            }
            let response = await Api.get('/movies/week/' + week);
            let movies = response.data;
            commit('SET_MOVIES', movies.map((v: Movie) => v));
            commit('SET_ACTIVE_WEEK', week);
        },
        async loadMoviesByGenre({commit}, genre) {
            if (this.state.genres.active == genre) {
                return;
            }

            let response = await Api.get('/movies?genre=' + genre);
            let movies = response.data;
            commit('SET_MOVIES', movies.map((v: Movie) => v));
            commit('SET_ACTIVE_GENRE', genre);
        },

        async loadMovies({commit}) {
            let response = await Api.get('/movies');
            let movies = response.data
            commit('SET_MOVIES', movies.map((v: Movie) => v));
            commit('SET_ACTIVE_GENRE', '');
        },
        async create({commit}, movie) {
            let response = await Api.post('/movies/create', movie);
            let savedMovie = response.data;
            commit('ADD_movie', savedMovie);
            return savedMovie;
        },
        async delete({commit}, movie) {
            let response = await Api.delete(`/movies/${movie.id}`);
            if(response.status == 200 || response.status == 204){
                commit('DELETE_movie', movie.id);
            }
        },
        async edit({commit}, movie) {
            let response = await Api.patch(`/movies/${movie.id}/edit`, movie);
            let newMovie = response.data;
            commit('EDIT_movie', newMovie);
            return newMovie;
        },
    }
});
