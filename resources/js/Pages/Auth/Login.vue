<template>
  <div class="d-flex flex-column flex-root">
    <div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
    <div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="
height: 100%;
min-height: 100%;
position: absolute;
width: 100%;background-image: url('assets/media/bg/bg-3.jpg');">
      <div class="login-form text-center p-7 position-relative overflow-hidden">
        <!--begin::Login Header-->
        <div class="d-flex flex-center mb-15">
          <a href="#">
            <img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
          </a>
        </div>
        <!--end::Login Header-->
        <!--begin::Login Sign in form-->
        <div class="login-signin">
          <div class="mb-20">
            <h3>Sign In To Admin</h3>
            <div class="text-muted font-weight-bold">Enter your details to login to your account:</div>
          </div>
          <form class="form" @submit.prevent="submit">
            <div class="form-group mb-5">
              <input v-model="form.email" class="form-control h-auto form-control-solid py-4 px-8" type="text"
                     placeholder="Email"
                      name="username" autocomplete="off" />
            </div>
            <div class="form-group mb-5">
              <input v-model="form.password" class="form-control h-auto form-control-solid py-4 px-8" type="password"
                     placeholder="Password" name="password" />
            </div>
            <div class="form-group d-flex flex-wrap justify-content-between align-items-center">
              <label class="checkbox m-0 text-muted">
                <input v-model="form.remember " type="checkbox" name="remember" />Remember me
                <span></span></label>
              <a href="javascript:;"  id="kt_login_forgot" class="text-muted text-hover-primary">Forget Password ?</a>
            </div>
            <button id="kt_login_signin_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-4">Sign In</button>
          </form>
          <div class="mt-10">
            <span class="opacity-70 mr-4">Don't have an account yet?</span>
            <a href="javascript:;" id="kt_login_signup" class="text-muted text-hover-primary font-weight-bold">Sign Up!</a>
          </div>
        </div>
        <!--end::Login Sign in form-->
        <!--begin::Login Sign up form-->
        <div class="login-signup">
          <div class="mb-20">
            <h3>Sign Up</h3>
            <div class="text-muted font-weight-bold">Enter your details to create your account</div>
          </div>
          <form class="form" id="kt_login_signup_form">
            <div class="form-group mb-5">
              <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Fullname" name="fullname" />
            </div>
            <div class="form-group mb-5">
              <input class="form-control h-auto form-control-solid py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
            </div>
            <div class="form-group mb-5">
              <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Password" name="password" />
            </div>
            <div class="form-group mb-5">
              <input class="form-control h-auto form-control-solid py-4 px-8" type="password" placeholder="Confirm Password" name="cpassword" />
            </div>
            <div class="form-group mb-5 text-left">
              <label class="checkbox m-0">
                <input type="checkbox" name="agree" />I Agree the
                <a href="#" class="font-weight-bold">terms and conditions</a>.
                <span></span></label>
              <div class="form-text text-muted text-center"></div>
            </div>
            <div class="form-group d-flex flex-wrap flex-center mt-10">
              <button id="kt_login_signup_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Sign Up</button>
              <button id="kt_login_signup_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
            </div>
          </form>
        </div>
        <!--end::Login Sign up form-->
        <!--begin::Login forgot password form-->
        <div class="login-forgot">
          <div class="mb-20">
            <h3>Forgotten Password ?</h3>
            <div class="text-muted font-weight-bold">Enter your email to reset your password</div>
          </div>
          <form class="form" id="kt_login_forgot_form">
            <div class="form-group mb-10">
              <input class="form-control form-control-solid h-auto py-4 px-8" type="text" placeholder="Email" name="email" autocomplete="off" />
            </div>
            <div class="form-group d-flex flex-wrap flex-center mt-10">
              <button id="kt_login_forgot_submit" class="btn btn-primary font-weight-bold px-9 py-4 my-3 mx-2">Request</button>
              <button id="kt_login_forgot_cancel" class="btn btn-light-primary font-weight-bold px-9 py-4 my-3 mx-2">Cancel</button>
            </div>
          </form>
        </div>
        <!--end::Login forgot password form-->
      </div>
    </div>
  </div>
  </div>
</template>

<script>

    export default {

        data() {
            return {
                form: this.$inertia.form({
                    email: '',
                    password: '',
                    remember: false
                })
            }
        },

        methods: {
            submit() {
                this.form
                    .transform(data => ({
                        ... data,
                        remember: this.form.remember ? 'on' : ''
                    }))
                    .post(this.route('login'), {
                        onFinish: () => this.form.reset('password'),
                    })
            }
        }
    }
</script>
