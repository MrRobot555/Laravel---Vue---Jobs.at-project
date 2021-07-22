<template>
  <div>
    <div class="container">
      <h2>Login</h2>
      <div class="panel panel-primary">
        <div class="panel-heading">
            <router-link to="/" class="btn btn-info pull-right" style="margin-top:-7px;margin-left:2px;">Back</router-link>
        </div>
        <div class="panel-body">
          <form @submit.prevent="login">
            <div class="form-group">
              <label>Email(Default:user@gmail.com) </label>
              <input type="text" class="form-control" v-model="auth.email" required/>
            </div>
            <div class="form-group">
              <label>Password(Defalut:12345)</label>
              <input type="password" class="form-control" v-model="auth.password" required/>
            </div>
            <button type="submit" class="btn btn-primary">Sign</button>
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
      auth: {},
    
    };
  },
  
  methods: {
    login() {
      this.axios
        .post("http://localhost:8001/api/auth", this.auth)
        .then((response) => {
          if(response.data[0].id) {
            this.$router.push({ name: "add" })
          } else {
            alert("login failed.")
          }
        })
        .catch((err) => alert("login failed."))
        .finally(() => (this.loading = false));
    },
  },
};
</script>