
<template lang="">
    <div> 
         <!-- Content Wrapper. Contains page content -->
      
          <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div  class="row mb-2">
          <div class="col-sm-6">
            
            <h1 class="m-0 text-dark">role Permissions</h1>
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
          <div class="col">
            <div class="card card-primary">
              <div class="card-header d-inline-flex">
                <h3 class="card-title">Bordered Table</h3> 
                <div class=" col-4 form-group">
                  <label for=""></label>
                  <select v-model="role_id" class="form-control" name="" id="">
                    <option  v-for="(role, index) in roles" :key="index" :value="role.id" @click="role_name(index)">{{role.role_name}}</option>
                  </select>
                </div> 
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table class="table table-bordered">
                  <thead>                  
                    <tr>
                      <th>Permission Name</th>
                      <th>Read</th>
                      <th>Write</th>
                      <th>Update</th>
                      <th>Delete</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="(permission, index) in permissions" :key="index">

                        <td>{{permission.permissionName}}</td>
                        <td><input class="form-check" v-model="permission.read" type="checkbox"></td>
                        <td><input class="form-check" v-model="permission.write" type="checkbox"></td>
                        <td><input class="form-check" v-model="permission.update" type="checkbox"></td>
                        <td><input class="form-check" v-model="permission.delete" type="checkbox"></td>
                    </tr>
                    
                  </tbody>
                </table>

              </div>
              <div  class="card-footer">
                <button @click="role_assigns" class="btn btn-primary">Assigns</button>
              </div>
            </div>
            
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
import { mapGetters } from 'vuex'
export default {
    data() {
      return {
          role_id: null,
          roles:[],
          permissions:[
             
          ],
          default_permissions:[
              {permissionName:'Category' , read: false, write:false, update:false, delete:false},
              {permissionName:'Tag' , read:false, write: false, update:false, delete:false},
              {permissionName:'User' , read:false, write:false, update:false, delete:false},
              {permissionName:'User Role' , read:false, write:false, update:false, delete:false},
              {permissionName:'Role Permission' , read:false, update:false}
          ],
      }
    },
    computed: {
        ...mapGetters(["getUser", "getPermission"])
    },
    methods: {

      
       getrole() {
          axios.get('/api/dashboard/role').then(response => {
              this.roles = response.data;

                if (response.data) {
                  this.role_id = response.data[0].id;

                  
                  const permission= response.data[0].permission
                  if (!permission) {
                    this.permissions = this.default_permissions
                  } else{
                    this.permissions = JSON.parse(permission) 
                  }
                
                // console.log(permission);
              

            }
          })
       },
      role_assigns(){
       let permission_json=JSON.stringify(this.permissions);
       let all= {'permissions_data':permission_json, 'id':this.role_id}


        axios.put('/api/dashboard/role_assigns', all )
            .then(response => { 
                  this.$toast.success({
                  title:'SUCCESS',
                  message:'Role Assigns Update Successfully',
                  })
          
        }).catch(error => {
                if (error.response.data.errors.role_name) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.role_name[0],
                  })
                }
                if (error.response.data.errors.permissions_data) {
                  this.$toast.error({
                  title:'! ERRORS',
                  message: error.response.data.errors.permissions_data[0],
                  })
                }
            })
        
      },
      role_name(index){
        const permission= this.roles[index].permission
        if (!permission) {

          this.permissions = this.default_permissions
        } else{
          this.permissions = JSON.parse(permission) 
        }
      }
    },
    mounted() {
      this.getrole();
    }
    
}
</script>
<style lang="">
    
</style>