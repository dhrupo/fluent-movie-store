import Dashboard from './Components/Dashboard.vue';
import Movie from './Components/Movie.vue';
import Rental from './Components/Rental.vue';
import MovieDetails from './Components/MovieDetails.vue';
import EditMovie from './Components/EditMovie.vue';
import Genre from './Components/Genre.vue';

export default [
    {
        path: '/',
        name: 'dashboard',
        component: Dashboard,
        meta: {
            active: 'dashboard'
        }
    },
    {
        path: '/movies',
        name: 'movies',
        component: Movie,
    },
    {
        path: '/movieDetails/:movie_id',
        name: 'movieDetails',
        component: MovieDetails
    },
    {
        path: '/editMovie/:movie_id',
        name: 'editMovie',
        component: EditMovie
    },
    {
        path: '/genres',
        name: 'genres',
        component: Genre
    },
    {
        path: '/rentals',
        name: 'rentals',
        component: Rental
    }
];

