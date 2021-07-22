<template>
  <div>
    <div class="container">
      <h2>Add Job</h2>
      <div class="panel panel-primary">
        <div class="panel-heading">
            Add Job
            <router-link to="/" class="btn btn-info pull-right" style="margin-top:-7px;margin-left:2px;">Job List</router-link>
        </div>
        <div class="panel-body">
          <form @submit.prevent="addJob">
            <div class="form-group">
              <label>Title </label>
              <input type="text" class="form-control" v-model="job.title" />
            </div>
            <div class="form-group">
              <label>Company Name</label>
              <select class="form-control" v-model="job.company">
                 <option v-for="company in companies" :value="company.id">{{company.name}}</option>
              </select>
            </div>
            <div class="form-group">
              <label>Description </label>
              <input type="text" class="form-control" v-model="job.description" />
            </div>
            <div class="form-group">
              <label>Location</label>
              <select class="form-control" v-model="job.location">
                 <option v-for="location in locations" :value="location.value">{{location.text}}</option>
              </select>
            </div>
            <div class="form-group">
              <b-form-group
                label="Status"
                v-slot="{ ariaDescribedby }"
              >
                <b-form-radio-group
                  v-model="job.status"
                  :aria-describedby="ariaDescribedby"
                  aria-controls="ex-disabled-readonly"
                >
                  <b-form-radio value="1">active</b-form-radio>
                  <b-form-radio value="0">inactive</b-form-radio>
                </b-form-radio-group>
              </b-form-group>
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>
 
<script>
export default {
  data() {
    return {
      job: {'status': '1'},
      companies: {},
      locations: [
        { text: 'Location1', value: 'loc1' },
        { text: 'Location2', value: 'loc2' },
        { text: 'Location3', value: 'loc3' },
        { text: 'Location4', value: 'loc4' },
        { text: 'Location5', value: 'loc5' },
        { text: 'Location6', value: 'loc6' },
        { text: 'Location7', value: 'loc7' },
        { text: 'Location8', value: 'loc8' },
      ],
    };
  },
  created() {
    this.axios.get("http://localhost:8001/api/companies").then((response) => {
      console.log("----------conpanies", response.data);
      this.companies = response.data;
    });
  },
  methods: {
    addJob() {
      this.axios
        .post("http://localhost:8001/api/job", this.job)
        .then((response) => this.$router.push({ name: "home" }))
        .catch((err) => console.log(err))
        .finally(() => (this.loading = false));
    },
  },
};
</script>