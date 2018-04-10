<template>

    <form v-on:submit.prevent class="form-horizontal">
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Họ</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" v-model="user.ho" id="inputName" placeholder="Họ">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Tên</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" v-model="user.ten" id="inputEmail" placeholder="Tên">
            </div>
        </div>
        <div class="form-group">
            <label for="inputEmail" class="col-sm-2 control-label">Địa chỉ</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" v-model="user.dia_chi"  placeholder="Địa chỉ">
            </div>
        </div>
        <div class="form-group">
            <label for="inputName" class="col-sm-2 control-label">Quyền</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" v-if="user.auth == 0" disabled value="Người dùng">
                <input type="text" class="form-control" v-else disabled value="Admin">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">Trạng thái</label>

            <div class="col-sm-10">
                <input type="text" class="form-control" v-if="user.trang_thai == 1" disabled value="Bình thường">
                <input type="text" class="form-control" v-else disabled value="Bị khóa">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">Tài khoản</label>

            <div class="col-sm-10">
                <input type="text" v-bind:value="user.tai_khoan" disabled value="Tài khoản" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <label  class="col-sm-2 control-label">Mật khẩu</label>

            <div class="col-sm-10">
                <input type="password" v-model="user.password" class="form-control">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" @click="luu_chinh_sua()" class="btn btn-danger">Lưu chỉnh sửa</button>
            </div>
        </div>
    </form>
</template>
<script>
    export default {
        created(){
          this.get_profile()
        },
        props: ["idUser"],
        data(){
            return {
                user: ""
            }
        },
        methods: {
            get_profile(){
                axios.get("/api/nguoi-dung/"+this.idUser).then((res) => {
                    this.user = res.data
                    this.user.password = ""
                    console.log(res.data)
                }).catch((err) => {
                    console.log(err.response)
                })
            },
            luu_chinh_sua(){
               if(this.user.password == "")
               {
                   axios.put("/profile",{
                       ho: this.user.ho,
                       ten: this.user.ten,
                       dia_chi: this.user.dia_chi,

                   }).then((res) => {
                       if(res.data.sc == true)
                       {
                           this.get_profile()
                           alert("Update Thành công")
                       }
                       else {
                           alert("Update Thất bại")
                       }
                   }).catch((err) => {
                       console.log(err.response)
                   })
               }
               else {
                   axios.put("/profile",{
                       ho: this.user.ho,
                       ten: this.user.ten,
                       dia_chi: this.user.dia_chi,
                        password: this.user.password
                   }).then((res) => {
                       if(res.data.sc == true)
                       {
                           this.get_profile()
                           alert("Update Thành công")
                       }
                       else{
                           alert("Update Thất bại")
                       }
                       console.log(res.data)
                   }).catch((err) => {
                       console.log(err.response)
                   })
               }
            }
        }
    }
</script>