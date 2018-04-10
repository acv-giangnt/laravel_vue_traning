<template>
    <form v-on:submit.prevent>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Tài khoản" v-model="login.tai_khoan" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Mật khẩu" v-model="login.password" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox" v-model="login.remember"> Remember Me
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" @click="submit()"  class="btn btn-primary btn-block btn-flat">Sign In</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</template>
<script>
    export default {
            data(){
                return {
                    login: {
                        tai_khoan: "",
                        password: "",
                        remember: 0
                    }
                }
            },
        methods:{
                submit(){

                   if(this.login.tai_khoan !="" && this.login.password !="")
                   {
                       axios.post("api/login",{
                           tai_khoan: this.login.tai_khoan,
                           password: this.login.password,
                           remember:this.login.remember
                       }).then((sc) => {
                           console.log(sc.data)
                           if(sc.data.sc == true)
                           {
                               location.reload();
                           }
                           else{
                               alert("Thông tin tài khoản hoặc mật khẩu không chính xác")
                           }
                       }).catch((err) => {
                           console.log(err.response)
                       })
                   }
                   else{
                        alert("Không được để trống trường tài khoản hoặc mật khẩu")
                   }
                }
        }
    }
</script>