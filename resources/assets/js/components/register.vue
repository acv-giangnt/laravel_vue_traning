<template>
    <form v-on:submit.prevent>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="user.ho" placeholder="Họ" required>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="user.ten" placeholder="Tên" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="user.dia_chi" placeholder="Địa chỉ" required>
            <span class="fa fa-location-arrow form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="text" class="form-control" v-model="user.tai_khoan" placeholder="Tài khoản" required>
            <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" v-model="user.password" placeholder="Nhập mật khẩu" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input type="password" class="form-control" v-model="user.password_confirmation" placeholder="Nhập lại mật khẩu" required>
            <span class="glyphicon glyphicon-log-in form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <input type="checkbox"> I agree to the <a href="#">terms</a>
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" @click="on_register()" class="btn btn-primary btn-block btn-flat">Đăng ký</button>
            </div>
            <!-- /.col -->
        </div>
    </form>
</template>
<script>
    export default {
        data(){
            return {
                user: {
                    ho: "",
                    ten: "",
                    dia_chi: "",
                    tai_khoan: "",
                    password: "",
                    password_confirmation: ""
                }
            }
        },
        methods:{
            on_register(){
                axios.post("/register",{
                    ho: this.user.ho,
                    ten: this.user.ten,
                    dia_chi: this.user.dia_chi,
                    password: this.user.password,
                    password_confirmation: this.user.password_confirmation,
                    tai_khoan: this.user.tai_khoan
                }).then((res) => {
                    if(res.data.sc == true)
                    {

                        alert("Thành công")
                        window.location="/login";
                    }
                    else{
                        alert("Thất bại")
                    }
                    console.log(res.data)
                }).catch((err) => {
                    if(err.response.data.errors.tai_khoan!= undefined&&err.response.data.errors.tai_khoan[0] == "false")
                    {
                        alert("Tài khoản đã tồn tại")
                    }
                    if(err.response.data.errors.password!= undefined&&err.response.data.errors.password[0] == "false")
                    {
                        alert("Mật khẩu không khớp")
                    }
                    console.log(err.response.data.errors)
                })
            }
        }
    }
</script>