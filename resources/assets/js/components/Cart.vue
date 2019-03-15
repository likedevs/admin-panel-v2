<template>
  <div class="order">
    <div class="invalid-feedback" v-for="(error, index) in serverErrors" :key="index" v-html="error">
      {{error}}
    </div>

    <div class="col-md-9 col-12 fan">
      <div class="row">

        <div class="col-12">
            <h4>Details</h4>
        </div>
        <div class="col-12">
            <p>User Data</p>
        </div>

        <div class="col-12" v-if="!userdata">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-10 radioBox">
                    <label class="container1">New Client?
                    <input type="radio" name="client" checked>
                    <span class="checkmark1"></span>
                    </label>
                    <label class="container1">Already registered?
                    <input type="radio" name="client" data-toggle="modal" data-target="#loginModal">
                    <span class="checkmark1"></span>
                    </label>
                </div>
            </div>
        </div>
        <form @submit.prevent="checkUserdata" v-if="step == 1">
          <div class="col-12 adressUnlogged">
            <div class="row">
              <div class="col-md-4">
                  <div class="form-group">
                      <label for="name">Name<b>*</b></label>
                      <input type="text" id="name" name="name" class="form-control"
                            key="name-input" v-model="name" v-validate="{required: true, min:3}">
                      <div v-if="errors.has('name')" class="invalid-feedback">{{ errors.first('name') }}</div>
                  </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="surname">Surname<b>*</b></label>
                  <input type="text" name="surname" id="surname" class="form-control"
                         key="surname-input" v-model="surname" v-validate="{required: true, min:3}">
                  <div v-if="errors.has('surname')" class="invalid-feedback">{{ errors.first('surname') }}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="email">Email<b>*</b></label>
                  <input type="text" name="email" id="email" class="form-control"
                         key="email-input" v-model="email" v-validate="{required: true, email: true}">
                  <div v-if="errors.has('email')" class="invalid-feedback">{{ errors.first('email') }}</div>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="phone">Phone<b>*</b></label>
                  <input type="text" name="phone" id="phone" class="form-control"
                         key="phone-input" v-model="phone" v-validate="{required: true, min: 9}">
                  <div v-if="errors.has('phone')" class="invalid-feedback">{{ errors.first('phone') }}</div>
                </div>
              </div>
              <template v-if="!userdata">
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="offr">
                      Do you agree to receive new offers and news from us?
                    </div>
                    <p>We will periodically email news and promotions related to our store.</p>
                    <div class="row">
                        <div class="col-12">
                            <label class="containerCheck">
                              I have read and agree with the collection and processing of my personal data along with the terms and conditions of the store. By subscribing to the newsletter I confirm that I am over 16 years of age.
                                <input type="checkbox"  name="promo_agreement" v-model="promo_agreement" key="promo_agreement-input">
                                <span class="checkmarkCheck"></span>
                            </label>
                        </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <div class="form-group">
                    <div class="offr">
                      What will we do with Your personal data?
                   </div>
                   <p>We will periodically email news and promotions related to our store.</p>
                   <div class="row">
                       <div class="col-12">
                           <label class="containerCheck">
                             We ask for the above data for account creation. In order to continue, do not forget to confirm that you have read and agree to the Terms and Conditions and the Privacy Policy
                               <input type="checkbox"  name="terms_agreement" v-model="terms_agreement" v-validate="{required: true}" key="terms_agreement-input">
                               <span class="checkmarkCheck" :class="{ 'is-invalid': errors.has('terms_agreement') }"></span>
                           </label>
                       </div>
                   </div>
                  </div>
                </div>
              </template>
            </div>
          </div>
          <div class="col-md-4 col-sm-5 col-6">
            <div class="btnGrey">
                <input type="submit" value="Submit">
            </div>
          </div>
      </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: ['user'],
  data() {
    return {
      userdata: this.user,
      name: this.user ? this.user.name : null,
      surname: this.user ? this.user.surname : null,
      email: this.user ? this.user.email : null,
      phone: this.user ? this.user.phone : null,
      promo_agreement: this.user ? this.user.promo_agreement : null,
      terms_agreement: this.user ? this.user.terms_agreement: null,
      token: document.querySelector('meta[name="_token"]').content,
      serverErrors: null,
      step: 1
    }
  },
  methods: {
    async checkUserdata() {
      try {
        let result = await this.$validator.validate()

        if(result) {
          result = await axios.post(`/${this.lang}/order/userdata`, {
            name: this.name,
            surname: this.surname,
            email: this.email,
            phone: this.phone,
            promo_agreement: this.promo_agreement,
            terms_agreement: this.terms_agreement,
            _token: this.token
          })

          this.step = 2
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
