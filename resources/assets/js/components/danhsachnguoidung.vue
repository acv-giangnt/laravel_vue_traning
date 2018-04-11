<template>
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Danh sách người dùng</h3>
        </div>
        <div style="padding-bottom: 10px;">
            Show:
            <select name="" v-model="lenSelect" @change="realShowUser()">
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="40">40</option>
            </select>
            Phần tử
            <input type="text" class="ip-search" v-model="search" style="margin-left: 10px;margin-right: 20px;min-width:300px;border-radius: 10px;" placeholder="Nhập từ khóa tìm kiếm">
            <button class="btn btn-danger ds-bt" @click="xoa_muc_da_chon()">Xóa mục đã chọn</button>
            <button class="btn btn-success ds-bt" @click="save_status()">Lưu</button>
            <button class="btn btn-info ds-bt" @click="show_them_moi()">Thêm mới User</button>
            <button class="btn btn-info ds-bt" @click="show_import_excel()"><i class="fa fa-file-excel-o"></i> Import file CSV</button>
        </div>
        <div class="clearfix"></div>
        <!-- /.box-header -->
        <div class="box-body">
            <table id="table-user" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th><input type="checkbox" v-model="check_all" @change="un_all()"></th>
                    <th>Nội dung</th>
                    <th>Trạng thái</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(nguoi_dung,index) in toan_bo_nguoi_dung" v-if="index >= lenSelect * (pageSelect - 1) && index < lenSelect * pageSelect && searchUser(nguoi_dung)">
                    <td>
                        <input type="checkbox" :value="nguoi_dung.id" v-model="id_da_chon" @change="click()">
                    </td>
                    <td>
                        <a href="#" @click="get_du_lieu_nguoi_dung(nguoi_dung.id)">{{nguoi_dung.ho + " " + nguoi_dung.ten}}</a>
                    </td>
                    <td>

                        <select name="" id="" @change="change_status(nguoi_dung.id)" class="form-control" v-if="nguoi_dung.trang_thai == 1" style="width: 100%">
                            <option value="1" selected>Hiển thị</option>

                            <option value="0">Không hiển thị</option>
                        </select>
                        <select name="" @change="change_status(nguoi_dung.id)" class="form-control"  v-else style="width: 100%">
                            <option value="1" >Hiển thị</option>

                            <option value="0" selected>Không hiển thị</option>
                        </select>
                    </td>

                </tr>

                </tbody>
            </table>

            <span style="float: left;margin: 20px 0"> Hiển thị {{lenShow}}/{{toan_bo_nguoi_dung.length}} danh mục</span>
            <div class="" style="float: right">


                <ul class="pagination">
                    <li><a href="#">&laquo;</a></li>
                    <li v-for="currPage in listPage" @click="actionSelectPage(currPage)"><a href="#">{{currPage}}</a></li>
                    <li><a href="#">&raquo;</a></li>
                </ul>


            </div>
        </div>
        <div class="clearfix"></div>
        <!-- /.box-body -->
        <div class="modal fade" id="modal-thong-tin-nguoi-dung" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #00a157">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" style="color: #e6ffef">Thông tin người dùng</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="">
                                    Họ
                                </label>
                                <input type="text" class="form-control" name="ho" v-model="du_lieu_nguoi_dung.ho">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Tên
                                </label>
                                <input type="text" class="form-control" name="ho" v-model="du_lieu_nguoi_dung.ten">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Địa chỉ
                                </label>
                                <input type="text" class="form-control" name="ho" v-model="du_lieu_nguoi_dung.dia_chi">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Tài khoản
                                </label>
                                <input type="text" disabled class="form-control" v-bind:value="du_lieu_nguoi_dung.tai_khoan">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Mật khẩu
                                </label>
                                <input type="password" class="form-control" name="ho" v-model="du_lieu_nguoi_dung.password">
                            </div>
                            <div class="form-group">
                                <label for="">
                                   Trạng thái
                                </label>
                                <select name="" class="form-control" v-model="du_lieu_nguoi_dung.trang_thai">
                                    <option value="1"> Hiển thị</option>
                                    <option value="0"> Không hiển thị</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="">Quyền người dùng</label>
                                <select name=""  v-model="du_lieu_nguoi_dung.auth" class="form-control">
                                    <option value="0" selected v-if="du_lieu_nguoi_dung.auth == 0">Người dùng</option>
                                    <option value="0" v-else>Người dùng</option>
                                    <option value="1" selected v-if="du_lieu_nguoi_dung.auth == 1">Admin</option>
                                    <option value="1" v-else>Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="luu_chinh_sua()">Lưu chỉnh sửa</button>
                        <button type="button" class="btn btn-danger" @click="xoa_nguoi_dung()">Xóa người dùng</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="modal-them-moi" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header"  style="background-color: #0b93d5">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span></button>
                        <h4 class="modal-title" style="color: #e6ffef">Thêm mới người dùng</h4>
                    </div>
                    <div class="modal-body">
                        <form action="#">
                            <div class="form-group">
                                <label for="">
                                    Họ
                                </label>
                                <input type="text" placeholder="Họ" class="form-control"  v-model="them_moi.ho">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Tên
                                </label>
                                <input type="text" placeholder="Tên" class="form-control"  v-model="them_moi.ten">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Địa chỉ
                                </label>
                                <input type="text" placeholder="Địa chỉ" class="form-control" v-model="them_moi.dia_chi">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Tài khoản
                                </label>
                                <input type="text" placeholder="Tài khoản" class="form-control" v-model="them_moi.tai_khoan">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Mật khẩu
                                </label>
                                <input type="password" placeholder="Mật khẩu" class="form-control" v-model="them_moi.password">
                            </div>
                            <div class="form-group">
                                <label for="">
                                    Nhập lại mật khẩu
                                </label>
                                <input type="password" placeholder="Mật khẩu" class="form-control" v-model="them_moi.password_confirmation">
                            </div>
                            <div class="form-group">
                                <label for="">Quyền người dùng</label>
                                <select name="" v-model="them_moi.auth" class="form-control">
                                    <option value="0" >Người dùng</option>
                                    <option value="1">Admin</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="them_moi_nguoi_dung()">Thêm mới người dùng</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <div class="modal fade" id="import-excel" style="display: none;">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-body">
                        <b-form-file v-model="file" :state="Boolean(file)" accept=".csv,.xlsx" placeholder="Choose a file..."></b-form-file>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" @click="import_excel()">Import file</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</template>
<script>

    export default {

        mounted (){
            this.laydulieu()

        },

        data(){
            return {
                toan_bo_nguoi_dung : [],
                id_da_chon : [],
                check_all: false,
                du_lieu_nguoi_dung: [],
                danh_sach_trang_thai: [],
                them_moi: [],
                file: null,
                search: "",
                lenSelect: 10,
                pageSelect: 1,
                listPage: [],
                lenShow: 0
            }
        },
        methods:{
            laydulieu(){
                axios.get("/api/nguoi-dung").then((res) => {
                    this.toan_bo_nguoi_dung = res.data
                    var count =parseInt(this.toan_bo_nguoi_dung.length / this.lenSelect) + 1
                    this.listPage = []
                    for(var i = 1;i<=count;i++)
                    {
                        this.listPage.push(i)
                    }

                    if(this.toan_bo_nguoi_dung.length> 0)
                    {
                        this.danh_sach_trang_thai = this.toan_bo_nguoi_dung.map((value) => {
                            return {id: value.id,trang_thai : value.trang_thai}
                        })
                        this.realShowUser()

                    }

                })


            },
            click(){
                if(this.id_da_chon.length == this.toan_bo_nguoi_dung.length)
                {
                    this.check_all = true
                }
                else
                {
                    this.check_all = false
                }
            },
            un_all(){
               if(this.check_all == true)
               {
                   var td = this.id_da_chon
                   this.toan_bo_nguoi_dung.forEach(function (value,index){
                       td.push(value.id)
                   })
               }else
               {

                   this.id_da_chon = []
               }
            },
            get_du_lieu_nguoi_dung(id){
                axios.get("/api/nguoi-dung/"+id).then((res) => {
                    this.du_lieu_nguoi_dung = res.data
                    this.du_lieu_nguoi_dung.password = ''
                    $("#modal-thong-tin-nguoi-dung").modal("show")
                })
            },
            luu_chinh_sua(){
                if(this.du_lieu_nguoi_dung.password != '')
                {
                    axios.put("/api/nguoi-dung/"+this.du_lieu_nguoi_dung.id,{

                        ho: this.du_lieu_nguoi_dung.ho,
                        ten: this.du_lieu_nguoi_dung.ten,
                        dia_chi: this.du_lieu_nguoi_dung.dia_chi,
                        password: this.du_lieu_nguoi_dung.password,
                        trang_thai: this.du_lieu_nguoi_dung.trang_thai,
                        auth:this.du_lieu_nguoi_dung.auth

                    }).then((res) => {
                        if(res.data.sc == true)
                        {
                            console.log("thành công")
                            $("#modal-thong-tin-nguoi-dung").modal("hide")
                            this.laydulieu()
                        }
                        else
                        {
                            console.log(res)
                        }
                    }).catch((err) => {
                        console.log(err)
                    })
                }
                else {
                    axios.put("/api/nguoi-dung/"+this.du_lieu_nguoi_dung.id,{

                        ho: this.du_lieu_nguoi_dung.ho,
                        ten: this.du_lieu_nguoi_dung.ten,
                        dia_chi: this.du_lieu_nguoi_dung.dia_chi,
                        trang_thai: this.du_lieu_nguoi_dung.trang_thai,
                        auth:this.du_lieu_nguoi_dung.auth

                    }).then((res) => {
                        if(res.data.sc == true)
                        {
                            console.log("thành công")
                            $("#modal-thong-tin-nguoi-dung").modal("hide")
                            this.laydulieu()
                        }
                        else
                        {
                            console.log(res)
                        }
                    }).catch((err) => {
                        console.log(err)
                    })
                }

            },
            xoa_nguoi_dung(){
                axios.delete("/api/nguoi-dung/"+this.du_lieu_nguoi_dung.id).then((sc) => {
                    if(sc.data.sc == true)
                    {
                        console.log("thành công")
                        $("#modal-thong-tin-nguoi-dung").modal("hide")
                        this.laydulieu()

                    }
                })
            }
        ,
            xoa_muc_da_chon(){
                console.log(this.id_da_chon)
                for(var i = 0; i< this.id_da_chon.length;i++)
                {

                    axios.delete("/api/nguoi-dung/"+this.id_da_chon[i]).then((sc) => {
                        if(sc.data.sc == true)
                        {
                            console.log("Thành công")
                            this.laydulieu()
                            this.id_da_chon = []
                        }
                    }).catch((err) => {
                        alert("Đã xảy ra lỗi");
                        return;
                    })


                    this.toan_bo_nguoi_dung = this.reset_dulieu(this.id_da_chon[i])
                }
                alert("Đã xóa thành công những người dùng đã chọn")
                this.id_da_chon = []
                this.check_all = false

            },
            reset_dulieu(gia_tri){

                var gt = []
                for(var i = 0;i< this.toan_bo_nguoi_dung.length;i++)
                {
                    if(this.toan_bo_nguoi_dung[i].id != gia_tri)
                    {
                        gt.push(this.toan_bo_nguoi_dung[i])
                    }
                }
                return gt;
            },
            show_them_moi(){
                $("#modal-them-moi").modal("show")
            },
            them_moi_nguoi_dung(){
                axios.post("/api/nguoi-dung",{
                    ho: this.them_moi.ho,
                    ten: this.them_moi.ten,
                    dia_chi: this.them_moi.dia_chi,
                    password: this.them_moi.password,
                    password_confirmation: this.them_moi.password_confirmation,
                    tai_khoan: this.them_moi.tai_khoan,
                    auth:this.du_lieu_nguoi_dung.auth
                }).then((sc) => {
                    if(sc.data.sc == true)
                    {
                        console.log("thành công")
                        $("#modal-them-moi").modal("hide")
                        this.laydulieu()
                    }
                    else{
                        console.log(sc)
                    }
                }).catch((err) => {
                    console.log(err.response)
                })
            },
            change_status(id){
                this.danh_sach_trang_thai = this.danh_sach_trang_thai.filter(function (value) {
                    if(value.id == id)
                    {
                        if(value.trang_thai == 1)
                        {
                            value.trang_thai = 0
                        }
                        else
                        {
                            value.trang_thai = 1
                        }
                    }
                    return value;
                })
            },
            save_status()
            {

                for(var i = 0;i<this.id_da_chon.length;i++)
                {
                    for(var j = 0;j<this.danh_sach_trang_thai.length;j++)
                    {
                        if(this.id_da_chon[i] == this.danh_sach_trang_thai[j].id)
                        {
                            this.danh_sach_trang_thai[j].check = 1;
                        }
                    }
                }

                var trangthai = this.danh_sach_trang_thai.filter(function (value) {
                    if(value.check == 1)
                    {
                        return value
                    }
                })
                axios.post("/api/update-status-list-user",{
                   list: trangthai
                }).then((sc) => {
                    if(sc.data.sc == true)
                    {
                        alert("thành công")
                        this.laydulieu()
                    }
                    else{
                        console.log(sc)
                    }
                }).catch((err) => {
                    console.log(err.response)
                })
            },
            show_import_excel()
            {
                $("#import-excel").modal("show")
            },
            import_excel()
            {
                var form_data= new FormData();
                form_data.append("file",this.file);
                if(this.file!=null)
                {
                    axios.post("/api/add-list-user",form_data).then((sc) => {
                        if(sc.data.sc == true)
                        {
                            console.log("thành công")
                            $("#import-excel").modal("hide")
                            this.laydulieu()
                        }
                        else{
                            console.log(sc)
                        }
                    }).catch((err) => {
                        console.log(err.response)
                    })
                }
            },
            actionSelectPage(i){
                this.pageSelect = i
                this.realShowUser()
            },
            realShowUser(){
                if(parseInt(this.lenSelect) * parseInt(this.pageSelect) >= this.toan_bo_nguoi_dung.length)
                {
                    this.lenShow = this.toan_bo_nguoi_dung.length
                }
                else {
                    this.lenShow = parseInt(this.lenSelect) * parseInt(this.pageSelect)
                }

            },
            searchUser(nguoi_dung)
            {
                if(this.search == "")
                {
                    return true;
                }
                return nguoi_dung.ho.search(this.search) != -1?true:false || nguoi_dung.ten.search(this.search) != -1?true:false
            }
        },
        watch:{
            search: function(val,oldVal)
            {

            },
            lenSelect: function (val,oldVal) {
                var count =parseInt(this.toan_bo_nguoi_dung.length / this.lenSelect) + 1
                this.listPage = []
                for(var i = 1;i<=count;i++)
                {
                    this.listPage.push(i)
                }
            }
        }
    }
</script>
<style>
    .ip-search{
        float: left !important;
        margin-left: 10px !important;
        width: 100px !important;
    }
</style>