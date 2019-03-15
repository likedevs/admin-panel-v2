<template>
  <div class="">
    <div class="invalid-feedback" v-for="(error, index) in serverErrors" :key="index" v-html="error">
      {{error}}
    </div>

    <form @submit.prevent="login" method="post">

      <label for="name">Email<b>*</b></label>
      <input type="text" name="email" id="email" class="form-control" v-model="email" v-validate="{required: true, email: true}">
      <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>

      <label for="pwd">Password<b>*</b></label>
      <input type="password" class="form-control" name="password" id="pwd" v-model="password" v-validate="{required: true, min: 4}">
      <div v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>

      <div class="row justify-content-center">
        <div class="col-md-4 col-sm-5 col-10">
          <div class="btnGrey">
            <input type="submit" value="Sign in">
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {
  data() {
    return {
      email: null,
      password: null,
      serverErrors: null
    }
  },
  methods: {
    async login(e) {
      try {
        let result = await this.$validator.validate()

        if(result) {
          result = await axios.post(`/${this.lang}/loginAjax`, {
            email: this.email,
            password: this.password
          })

          location.href = `/${this.lang}/cabinet/personalData`;
        }
      } catch(err) {
        this.serverErrors = err.response.data.errors
        window.scrollTo(0,0)
      }
    }
  }
}
</script>

<style scoped>
.invalid-feedback {
  display: block;
}
.is-valid {
  border-color: #28a745 !important;
}
.is-invalid {
  border-color: #dc3545 !important;
}
</style>
