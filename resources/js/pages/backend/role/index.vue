
<template lang="">
    <div> 
         <!-- Content Wrapper. Contains page content -->
      
          <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role' ).read==true" class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div  class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name:'dashboard'}">Dashboard</router-link></li>
              <li class="breadcrumb-item active">roles</li>
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
                      <th style="width: 20%">Action</th>
                    </tr>
                  </thead>
                  <tbody v-if="roles.length">
                    
                    <tr v-for="(role, index) in roles" :key="index" >
                      <td>{{index+1}}</td>
                      <td>{{role.role_name}}</td>
                      <td>
                        <button v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role' ).update==true" v-on:click="editrole(role.id, index)"  class="btn btn-primary"> <i class="fas fa-pen    "></i></button>
                        <button v-else class="btn muted"> <i class="fas fa-pen    "></i></button>
                        <button  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role' ).delete==true"  v-on:click="delete_role(role)" class="btn btn-danger"> <i class="fas fa-trash    "></i></button>
                        <button v-else class="btn muted"> <i class="fas fa-trash"></i> </button>
                      </td>
                    </tr>
                  </tbody>
                  <div v-else>
                      <h3>role Not Found</h3>
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
              <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role').write==true && this.add_form==true" class="card-header">
            
                <h3 class="card-title">Add role</h3>
              </div>
              <div  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role').update==true && this.add_form==false "  class="card-header d-flex">
                <h3 class="card-title">Update role</h3>
                <button  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role').write==true"  class="btn btn-info ml-auto py-0" v-on:click="show_add_form()">Add role</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div  v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role').write==true && this.add_form==true">
                <form   @submit.prevent="addrole()" @keydown="roleForm.onKeydown($event)">
                  <div class="card-body">
                    <div class="form-group mb-0">
                      <label for="role_name">role Name</label>
                      <input v-model="roleForm.role_name" type="text" class="form-control" id="role_name" placeholder="role Name"  :class="{ 'is-invalid': roleForm.errors.has('name') }">
                      <has-error :form="roleForm" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add role</button>
                  </div>
                </form>
              </div>

              <div v-if="getPermission.find( ({ permissionName }) => permissionName === 'User Role').update==true && this.add_form==false">
                <form @submit.prevent="update_role()" @keydown="editdata.onKeydown($event)">
                  <div class="card-body">
                    <input type="hidden" v-model="editdata.id" name="id">
                    <input type="hidden" v-model="editdata.index" name="index">
                    <div class="form-group mb-0">
                      <label for="role_name">role Name</label>
                      <input v-model="editdata.role_name" type="text" class="form-control" id="role_name" placeholder="role Name"  :class="{ 'is-invalid': editdata.errors.has('name') }">
                      <has-error :form="editdata" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">UPdate role</button>
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
        roles:[],
        roleForm: new Form({
          role_name: ''
      }),
        editdata: new Form({
          role_name: '',
          id: '',
          index: ''
      }),

      add_form:true,

      }
    },
    computed: {
            
            ...mapGetters(["getUser", "getPermission"])
        },
    methods: {

      
       getrole() {
          axios.get('/api/dashboard/role').then(response => {
              this.roles = response.data;
          })
       },
      addrole(){
       
        this.roleForm.post('/api/dashboard/role')
            .then(response => { 
          
          
          this.getrole();
            this.roleForm.role_name= '';
            this.$toast.success({
              title:'SUCCESS',
              message:'role Created Successfully'
          })
        }).catch(error => {
                if (error.response.data.errors.role_name) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.role_name[0],
                  })
                }
            })
        
      },
      editrole(id , index){
        this.add_form=false
        axios.get(`/api/dashboard/role/${id}/edit`).then(response => {
              this.editdata.role_name = response.data.role_name;
              this.editdata.id = response.data.id;
              this.editdata.index = index;
              
          })
      },
      show_add_form(){
        this.add_form =true
      },
      async update_role(){
        const index= this.editdata.index;
        const id = this.editdata.id;
        this.editdata.put(`/api/dashboard/role/${id}`)
        .then(({ data }) => { 
          console.log(this.editdata.name);
          
          this.roles[index].name= this.editdata.name;


          this.$toast.success({
              title:'SUCCESS',
              message:'role Update Successfully'
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
      delete_role(role , index){
        
          
        axios.delete(`/api/dashboard/role/${role.id}`).then( res=>{
          let found = this.roles.indexOf(role);
          this.roles.splice(found, 1);
          this.$toast.success({
          title:'SUCCESS',
          message: res.data,
          })
        })
        
      }
    },
    mounted() {
      this.getrole();
    }
    
}
</script>
<style lang="">
    
</style>