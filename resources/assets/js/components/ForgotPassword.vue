<template>
  <div class="">

    <div class="valid-feedback" v-if="success">
      {{success}}
    </div>

    <div class="invalid-feedback" v-for="(error, index) in serverErrors" :key="index" v-html="error">
      {{error}}
    </div>

    <form @submit.prevent="sendEmail" v-if="step == 1">

        <label for="name">Email<b>*</b></label>
        <input type="text" name="email" id="email" class="form-control"
               v-model="email" key="email-input" v-validate="{required: true, email: true}">

        <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>

        <div class="row justify-content-center">
          <div class="col-md-4 col-sm-5 col-10">
            <div class="btnGrey">
              <input type="submit" value="Submit">
            </div>
          </div>
        </div>
    </form>

    <form @submit.prevent="sendCode" v-if="step == 2">

        <label for="name">Code<b>*</b></label>
        <input type="text" name="code" id="code" class="form-control"
               v-model="code" key="code-input" v-validate="{required: true, min: 10}">

        <div v-if="errors.has('code')" class="invalid-feedback">{{ errors.first('code') }}</div>

        <div class="row justify-content-center">
          <div class="col-md-4 col-sm-5 col-10">
            <div class="btnGrey">
              <input type="submit" value="Submit">
            </div>
          </div>
        </div>
    </form>

    <form @submit.prevent="resetPassword" v-if="step == 3">

        <label for="pwd">Password<b>*</b></label>
        <input type="password" class="form-control" name="password" id="pwd"
               v-model="password" key="password-input" v-validate="{required: true, min: 4}"
               ref="password">

        <div v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>

        <label for="confpwd">Repeat password<b>*</b></label>
        <input type="password" class="form-control" name="repeatPassword" id="confpwd"
               key="repeatPassword-input" v-validate="{required: true, confirmed: 'password'}">

        <div v-if="errors.has('repeatPassword')" class="invalid-feedback">{{ errors.first('repeatPassword') }}</div>

        <div class="row justify-content-center">
          <div class="col-md-4 col-sm-5 col-10">
            <div class="btnGrey">
              <input type="submit" value="Submit">
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
      code: null,
      password: null,
      token: document.querySelector('meta[name="_token"]').content,
      serverErrors: null,
      success: null,
      step: 1
    }
  },
  methods: {
    async sendEmail() {
      try {
        let result = await this.$validator.validate()
        if(result) {
          result = await axios.post(`/${this.lang}/password/email`, {email: this.email})

          this.success = result.data.success
          this.step = 2
        }
      } catch(err) {
        this.serverErrors = err.response.data.errors
      }
    },
    async sendCode() {
      try {
        let result = await this.$validator.validate()
        if(result) {
          result = await axios.post(`/${this.lang}/password/code`, {code: this.code})

          this.success = result.data.success
          this.serverErrors = null
          this.step = 3
        }
      } catch(err) {
        this.serverErrors = err.response.data.errors
        this.success = null
      }
    },
    async resetPassword() {
      try {
        let result = await this.$validator.validate()

        if(result) {
          result = await axios.post(`/${this.lang}/password/reset`, {
            password: this.password,
            _token: this.token
          })

          location.href = `/${this.lang}/login`
        }
      } catch(err) {
        this.serverErrors = err.response.data.errors
        this.success = null
      }
    }
  }
}
</script>

<style scoped>
.invalid-feedback, .valid-feedback {
  display: block;
}
.is-valid {
  border-color: #28a745 !important;
}
.is-invalid {
  border-color: #dc3545 !important;
}
</style>
