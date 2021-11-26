<template>
  <el-row>
    <el-col :span="12"
      ><div class="grid-content">
        <h3>{{ movieDetails.movie_name }}</h3>
      </div></el-col
    >
    <el-col :span="12"
      ><div class="grid-content">
        <h3>{{ movieDetails.director }}</h3>
      </div></el-col
    >
  </el-row>
  <div>
    <el-button size="small" type="primary">Edit</el-button>
    <el-button size="small" type="danger">Delete</el-button>
  </div>
</template>

<script>
import Rest from "../Bits/Rest";
import { ref } from "vue";
import { useRoute } from "vue-router";

export default {
  name: "MovieDetails",
  setup() {
    const route = useRoute();
    const movie_id = route.params.movie_id;
    const movieDetails = ref({});

    Rest.get(`movies/${movie_id}`, { movie_id })
      .then((res) => {
        movieDetails.value = res;
      })
      .catch((err) => {
        console.log(err);
      })
      .always(() => {});

    return {
      movieDetails,
    };
  },
};
</script>

<style>
</style>