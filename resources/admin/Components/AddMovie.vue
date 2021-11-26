<template>
  <el-dialog v-model="addMovieDialogueVisible" title="Add movie" width="50%">
    <el-form ref="form" label-width="120px">
      <el-form-item label="Movie Name">
        <el-input required v-model="movieName"></el-input>
      </el-form-item>
      <el-form-item label="Director Name">
        <el-input required v-model="directorName"></el-input>
      </el-form-item>
      <el-form-item label="Genre">
        <el-select v-model="selectedGenre" placeholder="Select Genre">
          <el-option
            v-for="item in genreListProps"
            :key="item.genre_id"
            :label="item.genre_name"
            :value="item.genre_id"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Movie Stock">
        <el-input
          type="number"
          min="1"
          v-model="movieStock"
          required
        ></el-input>
      </el-form-item>
      <el-form-item label="Rental Rate">
        <el-input
          type="number"
          min="1"
          v-model="rentalRate"
          required
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-button @click="addMovieSubmit" type="primary">Create</el-button>
        <el-button @click="closeAddMovie">Cancel</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import { ref, computed } from "vue";
import Rest from "../Bits/Rest";
import { useRouter } from "vue-router";
import { ElNotification } from "element-plus";

export default {
  name: "AddMovie",
  props: ["addMovieDialog", "genreList"],
  emits: ["closeAddMovie"],
  setup(props, context) {
    const movieName = ref("");
    const directorName = ref("");
    const router = useRouter();
    const selectedGenre = ref("");
    const movieStock = ref("");
    const rentalRate = ref("");

    const genreListProps = computed(() => {
      return props.genreList;
    });

    const addMovieDialogueVisible = computed(() => {
      return props.addMovieDialog;
    });

    function addMovieSubmit() {
      // if (movieName.value === "" || directorName.value === "") {
      //   ElNotification({
      //     title: "Error",
      //     message: "Input  can not be empty",
      //     type: "error",
      //     position: "bottom-right",
      //     duration: 2000,
      //   });
      //   return;
      // }

      const data = {
        movie_name: movieName.value,
        director: directorName.value,
        genre_id: selectedGenre.value,
        in_stock: movieStock.value,
        rental_rate: rentalRate.value,
      };

      Rest.post("movies", data)
        .then((res) => {
          ElNotification({
            title: "Success",
            message: res.message,
            type: "success",
            position: "bottom-right",
            duration: 2000,
          });
          setTimeout(function () {
            router.go("/");
          }, 3000);
        })
        .catch((err) => {
          if (err.status === 422) {
            ElNotification({
              title: "Error",
              message: "Input can not be empty",
              type: "error",
              position: "bottom-right",
              duration: 2000,
            });
          }
        })
        .always(() => {});
    }

    function closeAddMovie() {
      context.emit("closeAddMovie");
    }

    return {
      movieName,
      directorName,
      movieStock,
      addMovieSubmit,
      addMovieDialogueVisible,
      closeAddMovie,
      genreListProps,
      selectedGenre,
      rentalRate,
    };
  },
};
</script>

<style>
</style>