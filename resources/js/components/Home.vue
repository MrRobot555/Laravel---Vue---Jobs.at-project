<template>

    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <div class="row">
            
            <div class="col-md-12">
              <b-form-group
                label="Location"
                v-slot="{ ariaDescribedby }"
              >
                <b-form-checkbox-group
                  v-model="locationSelected"
                  :options="locations"
                  :aria-describedby="ariaDescribedby"
                  name="flavour-2a"
                  class="ml-0"
                  stacked
                >
                </b-form-checkbox-group>
              </b-form-group>              
            </div>

            <div class="col-md-12">
              <b-form-group
                label="Company"
                v-slot="{ ariaDescribedby }"
                style="margin-top:30px"
              >
                <b-form-checkbox-group
                  v-model="companySelected"
                  :aria-describedby="ariaDescribedby"
                  name="flavour-2a"
                  stacked
                >
                  <b-form-checkbox v-for="company in companies" :value="company.id" :key="company.id">{{company.name}}</b-form-checkbox>
                </b-form-checkbox-group>
              </b-form-group>              
            </div>
          </div>
        </div>

        <div class="col-md-9">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Search..." v-model="searchKeyword" >
            <button class="btn btn-outline-secondary" type="button" id="button-addon2">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
              </svg>
            </button>
          </div>
          <div class="panel panel-primary">
            <div class="panel-heading">
                Jobs
                <router-link to="/login" class="btn btn-info pull-right" style="margin-top:-7px;margin-left:2px;">Add new job ad</router-link>
            </div>
            
            <div class="panel-body">
              <!-- <table class="table">
                <thead>
                  <tr>
                    <th>Title</th>
                    <th>Company</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Date</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="job in filteredRows" :key="job.id" @click="highlighting(job.id, job.highlighted)" :style="{ background: job.highlighted == 0 ? 'white' : '#ccc' }">
                    <td>{{ job.title }}</td>
                    <td>{{ job.name }}</td>
                    <td>{{ job.description }}</td>
                    <td>{{ job.location }}</td>
                    <td>{{ job.created_at }}</td>
                  </tr>
                </tbody>
              </table> -->

              <b-table
                :items="filteredRows"
                :fields="fields"
                :sort-by.sync="sortBy"
                :sort-desc.sync="sortDesc"
 
                responsive="sm"
                class="table"
              ></b-table>
            </div>
            
              
         
          </div>
        </div>

      </div>
    </div>

</template>
 
<script>
export default {
  data() {
    return {
      sortBy: 'created_at',
      sortDesc: true,
      fields: [
        { key: 'title', sortable: true },
        { key: 'name', sortable: true },
        { key: 'description', sortable: false },
        { key: 'location', sortable: true },
        { key: 'created_at', sortable: true }
      ],
       
      searchKeyword: "",
      locationSelected: [], // Must be an array reference!
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
      companySelected: [], // Must be an array reference!
      companies: [],
      jobs: [],
    };
  },
  created() {
    this.axios.get("http://localhost:8001/api/jobs").then((response) => {
      this.jobs = response.data;
    });
    this.axios.get("http://localhost:8001/api/companies").then((response) => {
      this.companies = response.data;
    });
  },
   methods: {
    highlighting(id, highlighted) {
      let datas = {id:id, highlighted:highlighted};
      this.axios
        .post(`http://localhost:8001/api/highlighting`, datas)
        .then((response) => {
          this.axios.get("http://localhost:8001/api/jobs").then((response) => {
            this.jobs = response.data;
          });
        });
    },
  },
 
  computed: {
    filteredRows() {
      return this.jobs.filter(row => {
        const currentTime = new Date();
        const createdDate = Date.parse(row.created_at);
        var Difference_In_Days = (currentTime - createdDate) / (1000 * 3600 * 24);

        const title = row.title.toString().toLowerCase();
        const description = row.description.toString().toLowerCase();
        const searchTerm = this.searchKeyword.toString().toLowerCase();

        if (!this.locationSelected.length && !this.companySelected.length) {
          if(Difference_In_Days <= 7)
            return (
              title.includes(searchTerm) || description.includes(searchTerm)
            )
        } else if(this.locationSelected.length && !this.companySelected.length){
          if(this.locationSelected.includes(row.location) == true) {
            if(Difference_In_Days <= 7)
              return ( title.includes(searchTerm) || description.includes(searchTerm))
          }
        } else if(!this.locationSelected.length && this.companySelected.length){
          if(this.companySelected.includes(row.company_id) == true) {
            if(Difference_In_Days <= 7)
              return ( title.includes(searchTerm) || description.includes(searchTerm))
          }
        } else if(this.locationSelected.length && this.companySelected.length){
          if((this.locationSelected.includes(row.location) == true) && this.companySelected.includes(row.company_id) == true) {
            if(Difference_In_Days <= 7)
              return ( title.includes(searchTerm) || description.includes(searchTerm))
          }
        }
        
      });
    }
  }
};
</script>
                