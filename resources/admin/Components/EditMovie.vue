<template>
  <el-dialog v-model="editMovieDialogueVisible" title="Edit movie" width="50%">
    <el-form ref="form" label-width="120px">
      <el-form-item label="Movie Name">
        <el-input v-model="editMovieDetailsProps.movie_name"></el-input>
      </el-form-item>
      <el-form-item label="Director Name">
        <el-input v-model="editMovieDetailsProps.director"></el-input>
      </el-form-item>
      <el-form-item label="Genre">
        <el-select v-model="selectedGenre.genre_id" placeholder="Select Genre">
          <el-option
            v-for="item in genreListProps"
            :key="item.genre_id"
            :label="item.genre_name"
            :value="item.genre_id"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item>
        <el-button @click="editMovieSubmit" type="primary">Edit</el-button>
        <el-button @click="closeEdit">Cancel</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import Rest from "../Bits/Rest";
import { ref, computed } from "vue";
import { useRouter } from "vue-router";
import { ElNotification } from "element-plus";

export default {
  name: "EditMovie",
  emits: ["closeEditMovie"],
  props: ["editMovieDialog", "editMovieDetails", "genreList", "editGenre"],
  setup(props, context) {
    const router = useRouter();
    const movieDetails = ref({});

    const editMovieDialogueVisible = computed(() => {
      return props.editMovieDialog;
    });

    const editMovieDetailsProps = computed(() => {
      return props.editMovieDetails;
    });

    const selectedGenre = computed({
      get() {
        return props.editGenre && props.editGenre;
      },
      set(value) {
        this.value = value;
      },
    });

    const genreListProps = computed(() => {
      return props.genreList;
    });

    function closeEdit() {
      context.emit("closeEditMovie");
    }

    function editMovieSubmit() {
      // if (
      //   editMovieDetailsProps.value.movie_name === "" ||
      //   editMovieDetailsProps.value.director === ""
      // ) {
      //   ElNotification({
      //     title: "Error",
      //     message: "Value can not be empty",
      //     type: "error",
      //     position: "bottom-right",
      //     duration: 2000,
      //   });
      //   return;
      // }

      const data = {
        movie_id: editMovieDetailsProps.value.movie_id,
        movie_name: editMovieDetailsProps.value.movie_name,
        director: editMovieDetailsProps.value.director,
        genre_id: selectedGenre.value.genre_id,
      };

      Rest.put(`movies/${data.movie_id}`, data)
        .then((res) => {
          router.go("/");
        })
        .catch((err) => console.log(err));
    }

    return {
      editMovieDialogueVisible,
      movieDetails,
      closeEdit,
      editMovieDetailsProps,
      editMovieSubmit,
      selectedGenre,
      genreListProps,
    };
  },
};
</script>

<style>
</style>