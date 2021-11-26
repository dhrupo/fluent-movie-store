<template>
  <el-dialog
    v-model="addRentalDialogueVisible"
    title="Rent a movie"
    width="75%"
    @close="closeAddRental"
  >
    <el-form
      ref="addRentalForm"
      :model="addRentalForm"
      :rules="rules"
      label-width="120px"
    >
      <el-form-item label="Select a movie" prop="selectedMovie">
        <el-select v-model="selectedMovie" placeholder="Select a movie">
          <el-option
            v-for="item in selectMovieList"
            :key="item.movie_id"
            :label="item.movie_name"
            :value="item.movie_id"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Select a user" prop="selectedUser">
        <el-select v-model="selectedUser" placeholder="Select a user">
          <el-option
            v-for="item in selectUserList"
            :key="item.ID"
            :label="item.display_name"
            :value="item.ID"
          >
          </el-option>
        </el-select>
      </el-form-item>
      <el-form-item label="Select date" prop="outDate">
        <el-date-picker
          v-model="outDate"
          type="date"
          placeholder="Pick a out date"
          :disabledDate="disabledPrevDate"
        ></el-date-picker>
      </el-form-item>
      <el-form-item label="Select return date" prop="returnDate">
        <el-date-picker
          v-model="returnDate"
          type="date"
          placeholder="Pick a return date"
          :disabledDate="disabledNextDate"
        ></el-date-picker>
      </el-form-item>
      <el-form-item>
        <el-button @click="addRentalSubmit(addRentalForm)" type="primary"
          >Create</el-button
        >
        <el-button @click="closeAddRental">Cancel</el-button>
      </el-form-item>
    </el-form>
  </el-dialog>
</template>

<script>
import { ref, computed, reactive } from "vue";
import Rest from "../Bits/Rest";
import Error from "../Bits/Errors";
import { useRouter } from "vue-router";
import { ElNotification } from "element-plus";

export default {
  name: "AddRental",
  props: ["addRentalDialog", "movieList", "userList"],
  emits: ["closeAddRental"],
  setup(props, context) {
    const selectedMovie = ref("");
    const selectedUser = ref("");
    const outDate = ref("");
    const returnDate = ref("");

    const addRentalForm = reactive({
      selectedMovie,
      selectedUser,
      outDate,
      returnDate,
    });

    const rules = ref({
      selectedMovie: [
        {
          required: true,
          message: "Please select a movie",
          trigger: "select",
        },
      ],
      selectedUser: [
        {
          required: true,
          message: "Please select a user",
          trigger: "select",
        },
      ],
      outDate: [
        {
          required: true,
          message: "Please select a out date",
          trigger: "select",
        },
      ],
      returnDate: [
        {
          required: true,
          message: "Please select a return date",
          trigger: "select",
        },
      ],
    });

    function disabledPrevDate(time) {
      return (
        time.getTime() < Date.now() - 8.64e7 ||
        time.getTime() > Date.now() + 6.048e8
      );
    }

    function disabledNextDate(time) {
      return (
        time.getTime() < new Date(outDate.value).getTime() + 8.64e7 ||
        time.getTime() > new Date(outDate.value).getTime() + 6.048e8
      );
    }

    const addRentalDialogueVisible = computed(() => {
      return props.addRentalDialog;
    });

    const selectMovieList = computed(() => {
      return props.movieList;
    });

    const selectUserList = computed(() => {
      return props.userList;
    });

    function addRentalSubmit(form) {
      form.validate((valid) => {
        if (valid) {
          const data = {
            movie_id: selectedMovie.value,
            user_id: selectedUser.value,
            rental_date_out: outDate.value.toLocaleDateString("en-ZA"),
            rental_date_return: returnDate.value.toLocaleDateString("en-ZA"),
          };

          Rest.post("rentals", data)
            .then((res) => {
              ElNotification({
                title: "Success",
                message: res.message,
                type: "success",
                position: "bottom-right",
                duration: 2000,
              });
              closeAddRental();
            })
            .catch((xhr, ajaxOptions, thrownError) => {
              const errors = JSON.parse(xhr.responseText);
              ElNotification({
                title: "Error",
                message: errors.message,
                type: "error",
                position: "bottom-right",
                duration: 2000,
              });
              errors.length > 0 &&
                errors.map((e) => {
                  ElNotification({
                    title: "Error",
                    message: e.message,
                    type: "error",
                    position: "bottom-right",
                    duration: 2000,
                  });
                });
            });
        } else {
          new Error("Please fill all input");
          return false;
        }
      });
    }

    function closeAddRental() {
      selectedMovie.value = "";
      selectedUser.value = "";
      outDate.value = "";
      returnDate.value = "";
      context.emit("closeAddRental");
    }

    return {
      addRentalDialogueVisible,
      addRentalForm,
      selectedMovie,
      selectedUser,
      outDate,
      returnDate,
      rules,
      addRentalSubmit,
      closeAddRental,
      selectMovieList,
      selectUserList,
      disabledPrevDate,
      disabledNextDate,
    };
  },
};
</script>

<style>
</style>