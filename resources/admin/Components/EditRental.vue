 <template>
   <el-dialog
     v-model="editRentalDialogueVisible"
     title="Rent a movie"
     width="50%"
     center
     @close="closeEditRental"
   >
     <el-form ref="form" label-width="120px">
       <el-form-item label="Select a movie">
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
       <el-form-item label="Select a user">
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
       <el-form-item label="Select date">
         <el-date-picker
           v-model="outDate"
           type="date"
           placeholder="Pick a out date"
           :disabledDate="disabledPrevDate"
         ></el-date-picker>
       </el-form-item>
       <el-form-item label="Select return date">
         <el-date-picker
           v-model="returnDate"
           type="date"
           placeholder="Pick a return date"
           :disabledDate="disabledNextDate"
         ></el-date-picker>
       </el-form-item>
       <el-form-item>
         <el-button @click="editRentalSubmit" type="primary">Create</el-button>
         <el-button @click="closeAddRental">Cancel</el-button>
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
   name: "EditRental",
   props: ["editRentalDialog", "editRentalDetails"],
   emits: ["closeEditRental"],
   setup(props, context) {
     const router = useRouter();

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

     const editRentalDialogueVisible = computed(() => {
       return props.editRentalDialog;
     });

     const editRentalDetailsProps = computed(() => {
       return props.editRentalDetails;
     });

      function editRentalSubmit() {
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
              message: "Successfully added the movie",
              type: "success",
              position: "bottom-right",
              duration: 2000,
            });
            setTimeout(function () {
              router.go("/");
            }, 2000);
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
      }

     function closeEditRental() {
       selectedMovie.value = "";
       selectedUser.value = "";
       outDate.value = "";
       returnDate.value = "";
       context.emit("closeEditRental");
     }

     return {
       selectedMovie,
       selectedUser,
       editRentalDetailsProps,
       editRentalDialogueVisible,
       closeEditRental,
       outDate,
       returnDate,
       disabledPrevDate,
       disabledNextDate,
     };
   },
 };

</script>

 <style>

</style>