<template>
  <el-button type="success" @click="addRentalDialogueVisible = true"
    >Rent a movie</el-button
  >

  <AddRental
    :addRentalDialog="addRentalDialogueVisible"
    :movieList="movieList"
    :userList="userList"
    @closeAddRental="addRentalDialogueVisible = false"
  ></AddRental>

  <!-- <EditRental
    :editRentalDialog="editRentalDialogueVisible"
    :editRentalDetails="editRentalDetails"
    @closeEditRental="editRentalDialogueVisible = false"
  ></EditRental> -->

  <el-table
    :data="
      pagedTableData.filter(
        (data) =>
          !search ||
          data.movie.movie_name.toLowerCase().includes(search.toLowerCase()) ||
          data.user.display_name.toLowerCase().includes(search.toLowerCase())
      )
    "
    :default-sort="
      ({ prop: 'movie.movie_name', order: 'descending' },
      { prop: 'user.display_name', order: 'descending' },
      { prop: 'user.rental_date_out', order: 'descending' },
      { prop: 'user.rental_date_return', order: 'descending' })
    "
    stripe
    style="width: 100%; margin-top: 20px"
  >
    <el-table-column prop="movie.movie_name" sortable label="Movie name" />
    <el-table-column prop="user.display_name" sortable label="Client name" />
    <el-table-column prop="rental_date_out" sortable label="Issue Date" />
    <el-table-column prop="rental_date_return" sortable label="Return Date" />
    <el-table-column align="right" width="220">
      <template #header>
        <el-input
          v-model="search"
          size="mini"
          placeholder="search by name/client"
        />
      </template>
      <template #default="scope">
        <el-button type="text" @click="editRental(scope.row.rental_id)"
          >Edit</el-button
        >
        <el-popconfirm
          title="Are you sure to delete this?"
          @confirm="deleteRental(scope.row.rental_id)"
        >
          <template #reference>
            <el-button type="text">Delete</el-button>
          </template>
        </el-popconfirm>
      </template>
    </el-table-column>
  </el-table>
  <div class="block">
    <el-pagination
      layout="prev, pager, next"
      :page-size="pageSize"
      :total="rentalDataCount"
      @current-change="setPage"
    ></el-pagination>
  </div>
</template>

<script>
import Rest from "../Bits/Rest";
import { computed, ref } from "vue";
// import { useRouter } from "vue-router";
import AddRental from "./AddRental.vue";
import EditRental from "./EditRental.vue";
export default {
  name: "Rental",
  components: {
    AddRental,
    EditRental,
  },
  setup() {
    // const router = useRouter();
    const rentalData = ref([]);
    const addRentalDialogueVisible = ref(false);
    // const editRentalDialogueVisible = ref(false);
    // const editRentalDetails = ref({});
    const movieList = ref([]);
    const userList = ref([]);
    const search = ref("");
    const rentalDataCount = ref(0);
    const pageNo = ref(1);
    const pageSize = ref(5);

    function getRentals() {
      Rest.get("rentals", {})
        .then((res) => {
          rentalData.value = res;
          rentalDataCount.value = res.length;
        })
        .catch((err) => {
          console.log(err);
        });
    }
    getRentals();

    Rest.get("movies", {})
      .then((res) => {
        movieList.value = res;
      })
      .catch((err) => {
        console.log(err);
      });

    Rest.get("users", {})
      .then((res) => {
        userList.value = res;
      })
      .catch((err) => {
        console.log(err);
      });

    function setPage(val) {
      pageNo.value = val;
    }

    const pagedTableData = computed(() => {
      return rentalData.value.slice(
        pageSize.value * pageNo.value - pageSize.value,
        pageSize.value * pageNo.value
      );
    });

    // function editRental(rental_id) {
    //   console.log(rental_id);
    // }

    return {
      rentalData,
      addRentalDialogueVisible,
      // editRentalDialogueVisible,
      // editRentalDetails,
      search,
      movieList,
      userList,
      rentalDataCount,
      setPage,
      pagedTableData,
      pageSize,
      pageNo,
    };
  },
};
</script>

<style>
</style>