<template>
  <div class="d-flex flex-column flex-root">
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
    <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="height: 100%;min-height: 100%;position: absolute;width: 100%;background-image: url('assets/media/bg/bg-3.jpg');">
      <div class="login-form text-center p-7 position-relative overflow-hidden">
        <!--begin::Login Header-->
        <div class="d-flex flex-center mb-15">
          <a href="#">
            <img :src="$asset('assets/media/logos/logo-letter-13.png')" class="max-h-75px" alt="" />
          </a>
        </div>
        <!--end::Login Header-->
        <!--begin::Login Sign in form-->
        <div class="login-signin">
          <div class="mb-20">
            <h3>Sign In To Admin</h3>
            <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
          </div>
          <a
              v-for="oauth in oauthClients"
              :key="oauth"
              :href="`/auth/${oauth}/redirect`"
              @click="submit" class="btn  font-weight-bold px-9 py-4 my-3   btn-block">Sign In {{ oauth
            }}</a>
        </div>
      </div>
    </div>
  </div>
  </div>
</template>

<script>

    export default {
      props: {
        oauthClients: {
          type: Array,
          required: true
        }
      }
    }
</script>
