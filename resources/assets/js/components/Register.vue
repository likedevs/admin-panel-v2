<template>
    <div>
      <div class="invalid-feedback" v-for="(error, index) in serverErrors" :key="index" v-html="error">
        {{error}}
      </div>
      <form @submit.prevent="registration" method="post">
          <label for="name">Name<b>*</b></label>
          <input type="text" id="name" name="name" class="form-control" v-model="name" v-validate="{required: true, min:3}">
          <div v-if="errors.has('surname')" class="invalid-feedback">{{ errors.first('name') }}</div>

          <label for="name">Surname<b>*</b></label>
          <input type="text" name="surname" id="surname" class="form-control" v-model="surname" v-validate="{required: true, min:3}">
          <div v-if="errors.has('surname')" class="invalid-feedback">{{ errors.first('surname') }}</div>

          <label for="name">Email<b>*</b></label>
          <input type="text" name="email" id="email" class="form-control" v-model="email" v-validate="{required: true, email: true}">
          <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>

          <label for="name">Phone<b>*</b></label>
          <input type="text" name="phone" id="phone" class="form-control" v-model="phone" v-validate="{required: true, min: 9}">
          <div v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>

          <label for="pwd">Password<b>*</b></label>
          <input type="password" class="form-control" name="password" id="pwd" v-model="password" v-validate="{required: true, min: 4}" ref="password">
          <div v-if="errors.has('password')" class="invalid-feedback">{{ errors.first('password') }}</div>

          <label for="confpwd">Repeat password<b>*</b></label>
          <input type="password" class="form-control" name="repeatPassword" id="confpwd" v-validate="{required: true, confirmed: 'password'}">
          <div v-if="errors.has('repeatPassword')" class="invalid-feedback">{{ errors.first('repeatPassword') }}</div>

          <div class="offr">
            Do you agree to receive new offers and news from us?
          </div>
          <p>We will periodically email news and promotions related to our store.</p>
          <div class="row">
              <div class="col-12">
                  <label class="containerCheck">
                    I have read and agree with the collection and processing of my personal data along with the terms and conditions of the store. By subscribing to the newsletter I confirm that I am over 16 years of age.
                      <input type="checkbox"  name="promo_agreement" v-model="promo_agreement">
                      <span class="checkmarkCheck"></span>
                  </label>
              </div>
          </div>

           <div class="offr">
             What will we do with Your personal data?
          </div>
          <p>We will periodically email news and promotions related to our store.</p>
          <div class="row">
              <div class="col-12">
                  <label class="containerCheck">
                    We ask for the above data for account creation. In order to continue, do not forget to confirm that you have read and agree to the Terms and Conditions and the Privacy Policy
                      <input type="checkbox"  name="terms_agreement" v-model="terms_agreement" v-validate="{required: true}" >
                      <span class="checkmarkCheck" :class="{ 'is-invalid': errors.has('terms_agreement') }"></span>
                  </label>
              </div>
          </div>
      <div class="row justify-content-center margeTop2">
      </div>
      <div class="col-md-5 col-sm-5 col-7">
          <div class="btnGrey">
              <input type="submit" value="Sign up">
          </div>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  data() {
    return {
      name: null,
      surname: null,
      email: null,
      phone: null,
      password: null,
      terms_agreement: null,
      promo_agreement: null,
      token: document.querySelector('meta[name="_token"]').content,
      serverErrors: null
    }
  },
  methods: {
    async registration(e) {
      try {
        let result = await this.$validator.validate()

        if(result) {
          result = await axios.post(`/${this.lang}/registrationAjax`, {
            name: this.name,
            surname: this.surname,
            email: this.email,
            phone: this.phone,
            password: this.password,
            terms_agreement: this.terms_agreement,
            promo_agreement: this.promo_agreement,
            _token: this.token
          })

          location.href = `/${this.lang}/login`;
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
