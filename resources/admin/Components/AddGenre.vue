<template>
  <el-dialog v-model="addGenreDialogueVisible" title="Add Genre" width="50%">
    <el-form ref="form" label-width="120px">
      <el-form-item label="Genre Name">
        <el-input required v-model="genreName"></el-input>
      </el-form-item>
      <el-form-item>
        <el-button @click="addGenreSubmit" type="primary">Create</el-button>
        <el-button @click="closeAddGenre">Cancel</el-button>
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
  name: "AddGenre",
  props: ["addGenreDialog"],
  emits: ["closeAddGenre"],
  setup(props, context) {
    const genreName = ref("");
    const router = useRouter();

    const addGenreDialogueVisible = computed(() => {
      return props.addGenreDialog;
    });

    function closeAddGenre() {
      context.emit("closeAddGenre");
    }

    function addGenreSubmit() {
      const data = {
        genre_name: genreName.value,
      };

      Rest.post("genres", data)
        .then((res) => {
          if (res.status === 200) {
            ElNotification({
              title: "Success",
              message: "Successfully added the movie",
              type: "success",
              position: "bottom-right",
              duration: 2000,
            });
            router.go("/");
          }
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
    return {
      genreName,
      addGenreDialogueVisible,
      addGenreSubmit,
      closeAddGenre,
    };
  },
};
</script>

<style>
</style>