<template>
  <el-button type="success" @click="addMovieDialogueVisible = true"
    >Add a movie</el-button
  >

  <AddMovie
    :addMovieDialog="addMovieDialogueVisible"
    :genreList="genreList"
    @closeAddMovie="addMovieDialogueVisible = false"
  ></AddMovie>

  <EditMovie
    :editMovieDialog="editMovieDialogueVisible"
    :editGenre="editGenre"
    :editMovieDetails="editMovieDetails"
    :genreList="genreList"
    @closeEditMovie="editMovieDialogueVisible = false"
  ></EditMovie>

  <el-table
    :data="
      movieData.filter(
        (data) =>
          !search ||
          data.movie_name.toLowerCase().includes(search.toLowerCase())
      )
    "
    stripe
    style="width: 100%; margin-top: 20px"
  >
    <el-table-column prop="movie_name" label="Movie name" width="200" />
    <el-table-column prop="director" label="Director" width="200" />
    <el-table-column prop="genre.genre_name" label="Genre Name" width="200" />
    <el-table-column align="right">
      <template #header>
        <el-input v-model="search" size="mini" placeholder="Type to search" />
      </template>
      <template #default="scope">
        <el-button type="text" @click="getMovieDetails(scope.row.movie_id)"
          >Detail</el-button
        >
        <el-button type="text" @click="editMovie(scope.row.movie_id)"
          >Edit</el-button
        >
        <el-popconfirm
          title="Are you sure to delete this?"
          @confirm="deleteMovie(scope.row.movie_id)"
        >
          <template #reference>
            <el-button type="text">Delete</el-button>
          </template>
        </el-popconfirm>
      </template>
    </el-table-column>
  </el-table>
</template>

<script>
import EditMovie from "./EditMovie.vue";
import AddMovie from "./AddMovie.vue";
import Rest from "../Bits/Rest";
import { ref } from "vue";
import { useRouter } from "vue-router";
export default {
  name: "Movie",
  components: {
    EditMovie,
    AddMovie,
  },
  setup() {
    const router = useRouter();
    const movieData = ref([]);
    const addMovieDialogueVisible = ref(false);
    const editMovieDialogueVisible = ref(false);
    const editMovieDetails = ref({});
    const editGenre = ref({});
    const genreList = ref([]);
    const search = ref("");

    function getMovies() {
      Rest.get("movies", {})
        .then((res) => {
          movieData.value = res;
        })
        .catch((err) => {
          console.log(err);
        })
        .always(() => {});
    }
    getMovies();

    function editMovie(movie_id) {
      editMovieDialogueVisible.value = true;
      Rest.get(`movies/${movie_id}`, { movie_id })
        .then((res) => {
          editMovieDetails.value = res;
          editGenre.value = {
            genre_id: res.genre.genre_id,
            genre_name: res.genre.genre_name,
          };
        })
        .catch((err) => {})
        .always(() => {});
    }

    function deleteMovie(movie_id) {
      Rest.delete(`movies/${movie_id}`, { movie_id })
        .then((res) => {
          getMovies();
        })
        .catch((err) => {})
        .always(() => {});
    }

    function getMovieDetails(movie_id) {
      router.push(`/movieDetails/${movie_id}`);
    }

    function getGenreList() {
      Rest.get("genres", {})
        .then((res) => {
          genreList.value = res.map((genre) => {
            return {
              genre_id: genre.genre_id,
              genre_name: genre.genre_name,
            };
          });
        })
        .catch((err) => {
          console.log(err);
        })
        .always(() => {});
    }
    getGenreList();

    return {
      movieData,
      addMovieDialogueVisible,
      getMovieDetails,
      editMovieDialogueVisible,
      editMovie,
      editMovieDetails,
      deleteMovie,
      genreList,
      editGenre,
      search,
    };
  },
};
</script>

<style>
</style>