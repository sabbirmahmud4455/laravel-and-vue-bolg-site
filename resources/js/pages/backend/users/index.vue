
<template lang="">
    <div> 
         <!-- Content Wrapper. Contains page content -->
      
          <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User' ).read==true" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div  class="row mb-2">
          <div class="col-sm-6">
            
            <h1 class="m-0 text-dark">Users</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name:'dashboard'}">Dashboard</router-link></li>
              <li class="breadcrumb-item active">users</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-lg-8">
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Bordered Table</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th style="width: 10px">#</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Type</th>
                      <th>Status</th>
                      <th style="width: 20%">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="users.length">
                    
                    <tr v-for="(user, index) in users" :key="index" >
                      <td>{{index+1}}</td>
                      <td>{{user.full_name}}</td>
                      <td>{{user.email}}</td>
                      <td><span v-if="user.role">{{user.role.role_name}}</span>  <span v-else>User</span></td>
                      
                      
                      <td><span v-if="user.status==0">Inactive </span>  <span v-else>Active</span> </td>
                      <td>
                        <button v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').update==true" v-on:click="edituser(user.id, index)"  class="btn btn-primary"> <i class="fas fa-pen    "></i></button>
                        <button v-else   class="btn muted"> <i class="fas fa-pen    "></i></button>
                        <button  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').delete==true" v-on:click="delete_user(user)" class="btn btn-danger"> <i class="fas fa-trash    "></i></button>
                        <button v-else class="btn muted"> <i class="fas fa-trash    "></i> </button>
                      </td>
                    </tr>
                  </tbody>
                  <div v-else>
                      <h3>user Not Found</h3>
                    </div>
                </table>
              </div>
              <!-- /.card-body -->
              <!-- <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  <li class="page-item"><a class="page-link" href="#">«</a></li>
                  <li class="page-item"><a class="page-link" href="#">1</a></li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item"><a class="page-link" href="#">3</a></li>
                  <li class="page-item"><a class="page-link" href="#">»</a></li>
                </ul>
              </div> -->
            </div>
            
          </div>
          
          <div class="col-lg-4">
              <div class="card card-primary">
              <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').write==true && this.add_form==true" class="card-header">
            
                <h3 class="card-title">Add user</h3>
              </div>
              <div v-if="this.add_form==false" class="card-header d-flex">
                <h3 class="card-title">Update user</h3>
                <button v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').write==true" class="btn btn-info ml-auto py-0" v-on:click="show_add_form()">Add user</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').write==true && this.add_form==true">
                <form   @submit.prevent="adduser()" @keydown="userForm.onKeydown($event)">
                  <div class="card-body">
                    <div class="form-group mb-0">
                      <label for="full_name">Full Name</label>
                      <input v-model="userForm.full_name" type="text" class="form-control" id="full_name" placeholder="Full Name"  :class="{ 'is-invalid': userForm.errors.has('full_name') }">
                      <has-error :form="userForm" field="full_name"></has-error>
                    </div>
                    <div class="form-group mb-0">
                      <label for="user_email">Email</label>
                      <input v-model="userForm.email" type="email" class="form-control" id="user_email" placeholder="User Email"  :class="{ 'is-invalid': userForm.errors.has('email') }">
                      <has-error :form="userForm" field="email"></has-error>
                    </div>
                    <div class="form-group">
                      <label for="user_role">User Role</label>
                      <select v-model="userForm.role" class="form-control" name="user_role" id="user_role">
                        <option v-if="roles.length" v-for="(role, index) in roles" :key="index" :value="role.id">{{role.role_name}}</option>
                        <!-- <option  value="2">Editor</option>
                        <option  value="3">Manager</option>
                        <option  value="0">Subscriber</option> -->
                      </select>
                    </div>
                    <div class="form-group mb-0">
                      <label for="user_password">Password</label>
                      <input v-model="userForm.password" type="password" class="form-control" id="user_password" placeholder="User Password"  :class="{ 'is-invalid': userForm.errors.has('password') }">
                      <has-error :form="userForm" field="password"></has-error>
                    </div>
                    
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add user</button>
                  </div>
                </form>
              </div>

              <div  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User').update==true && this.add_form==false">
                <form @submit.prevent="update_user()" @keydown="editdata.onKeydown($event)">
                  <div class="card-body">
                    <input type="hidden" v-model="editdata.id" name="id">
                    <input type="hidden" v-model="editdata.index" name="index">

                    <div class="form-group mb-0">
                      <label for="full_name">Full Name</label>
                      <input v-model="editdata.full_name" type="text" class="form-control" id="full_name" placeholder="Full Name"  :class="{ 'is-invalid': editdata.errors.has('full_name') }">
                      <has-error :form="editdata" field="full_name"></has-error>
                    </div>
                    <div class="form-group mb-0">
                      <label for="user_email">Email</label>
                      <input v-model="editdata.email" type="email" class="form-control" id="user_email" placeholder="User Email"  :class="{ 'is-invalid': editdata.errors.has('email') }">
                      <has-error :form="editdata" field="email"></has-error>
                    </div>
                    <div class="form-group">
                      <label for="user_role">User Role</label>
                      <select v-model="editdata.role" class="form-control" name="user_role" id="user_role">
                        <option value="1">Admin</option>
                        <option value="2">Editor</option>
                        <option value="3">Manager</option>
                        <option value="0">Subscriber</option>
                      </select>
                    </div>
                    <div  class="form-group mb-0">
                      <label for="user_password">Password</label>
                      <input v-model="editdata.password" type="password" class="form-control" id="user_password" placeholder="User Password"  :class="{ 'is-invalid': editdata.errors.has('password') }">
                      <span>if you update password.</span>
                      <has-error :form="editdata" field="password"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">UPdate user</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
  </div>


        <!-- /.content-wrapper -->
    </div>
</template>
<script>
import { Form } from 'vform'
import {mapGetters} from 'vuex'
export default {
    data() {
      return {
        users:[],
        roles:[],
        userForm: new Form({
          full_name: '',
          email: '',
          role: '1',
          password: '',
      }),
        editdata: new Form({
          id: '',
          index: '',
          full_name: '',
          email: '',
          role: '',
          password: ''
      }),

      add_form:true,

      }
    },
    computed: {
            
            ...mapGetters(["getUser", "getPermission"])
        },
    methods: {

      
       getuser() {
          axios.get('/api/dashboard/user').then(response => {
              this.users = response.data.users;
              this.roles = response.data.roles;
              
          })
       },
      adduser(){
        this.userForm.post('/api/dashboard/user')
            .then(response => { 
          
          this.getuser();
            this.userForm.full_name= '';
            this.userForm.email= '';
            this.userForm.role= 'subscribe';
            this.userForm.password= '';
            this.$toast.success({
              title:'SUCCESS',
              message:'user Created Successfully'
          })
        }).catch(error => {

                if (error.response.data.errors.full_name) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.full_name[0],
                  })
                } if (error.response.data.errors.email) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.email[0],
                  })
                } if (error.response.data.errors.password) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.password[0],
                  })
                }
            })
      },
      edituser(id , index){
        this.add_form=false
        axios.get(`/api/dashboard/user/${id}/edit`).then(response => {
              this.editdata.index = index;
              this.editdata.id = response.data.id;
              this.editdata.full_name = response.data.full_name;
              this.editdata.email = response.data.email;
              this.editdata.role = response.data.user_type;
          })
      },
      show_add_form(){
        this.add_form =true
      },
      async update_user(){
        const index= this.editdata.index;
        const id = this.editdata.id;
        this.editdata.put(`/api/dashboard/user/${id}`)
        .then(({ data }) => { 
          console.log(this.editdata.name);
          
          this.users[index].name= this.editdata.name;


          this.$toast.success({
              title:'SUCCESS',
              message:'user Update Successfully'
          }) 
        }).catch(error => {
                if (error.response.data.errors.name) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.name[0],
                  })
                }
            })
      },
      delete_user(user , index){
        
          
        axios.delete(`/api/dashboard/user/${user.id}`).then( res=>{
          let found = this.users.indexOf(user);
          this.users.splice(found, 1);
          this.$toast.success({
          title:'SUCCESS',
          message: res.data,
          })
        })
        
      }
    },
    mounted() {
      this.getuser();
    }
    
}
</script>
<style lang="">
    
</style>