<template>
  <el-button type="success" @click="addGenreDialogueVisible = true"
    >Add a Genre</el-button
  >
  <AddGenre
    :addGenreDialog="addGenreDialogueVisible"
    @closeAddGenre="addGenreDialogueVisible = false"
  ></AddGenre>

  <el-table :data="genreData" stripe style="width: 100%; margin-top: 20px">
    <el-table-column prop="genre_name" label="Genre name" width="200" />
    <el-table-column label="Action" width="280">
      <template #default="scope">
        <el-button type="text" @click="editGenre(scope.row.genre_id)"
          >Edit</el-button
        >
        <el-popconfirm
          title="Are you sure to delete this?"
          @confirm="deleteGenre(scope.row.genre_id)"
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
import Rest from "../Bits/Rest";
import { ref } from "vue";
import { useRouter } from "vue-router";
import AddGenre from "./AddGenre.vue";
import { ElNotification } from "element-plus";

export default {
  name: "Genre",
  components: {
    AddGenre,
  },
  setup() {
    const router = useRouter();
    const genreData = ref([]);
    const addGenreDialogueVisible = ref(false);

    function getGenres() {
      Rest.get("genres", {})
        .then((res) => {
          genreData.value = res;
        })
        .catch((err) => {
          console.log(err);
        })
        .always(() => {});
    }
    getGenres();

    function editGenre() {}

    function deleteGenre(genre_id) {
      Rest.delete(`genres/${genre_id}`, { genre_id })
        .then((res) => {
          if (res.status === 200) {
            ElNotification({
              title: "Success",
              message: "Successfully deleted the genre",
              type: "success",
              position: "bottom-right",
              duration: 2000,
            });
            setTimeout(function () {
              getGenres();
            }, 2000);
          }
        })
        .catch((xhr, ajaxOptions, thrownError) => {
          ElNotification({
            title: "Error",
            message: thrownError,
            type: "error",
            position: "bottom-right",
            duration: 2000,
          });
        })
        .always(() => {});
    }

    return {
      genreData,
      addGenreDialogueVisible,
      editGenre,
      deleteGenre,
    };
  },
};
</script>

<style>
</style>