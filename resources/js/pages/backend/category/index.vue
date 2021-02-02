


<template lang="">
    <div> 
         <!-- Content Wrapper. Contains page content -->
      
          <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div  class="row mb-2">
          <div class="col-sm-6">
            
            <h1 class="m-0 text-dark">Categories</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name:'dashboard'}">Dashboard</router-link></li>
              <li class="breadcrumb-item active">Categories</li>
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
                  <tbody v-if="categorys.length">
                    
                    <tr v-for="(category, index) in categorys" :key="index" >
                      <td>{{index+1}}</td>
                      <td>{{category.name}}</td>
                      <td>
                        <button v-on:click="editcategory(category.id, index)"  class="btn btn-primary"> <i class="fas fa-pen    "></i></button>
                        <button v-on:click="delete_category(category)" class="btn btn-danger"> <i class="fas fa-trash    "></i></button>
                      </td>
                    </tr>
                  </tbody>
                  <div v-else>
                      <h3>Category Not Found</h3>
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
              <div v-if="this.add_form==true" class="card-header">
            
                <h3 class="card-title">Add Category</h3>
              </div>
              <div v-else class="card-header d-flex">
                <h3 class="card-title">Update Category</h3>
                <button class="btn btn-info ml-auto py-0" v-on:click="show_add_form()">Add Category</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div v-if="this.add_form==true">
                <form   @submit.prevent="addcategory()" @keydown="categoryForm.onKeydown($event)">
                  <div class="card-body">
                    <div class="form-group mb-0">
                      <label for="category_name">Category Name</label>
                      <input v-model="categoryForm.name" type="text" class="form-control" id="category_name" placeholder="Category Name"  :class="{ 'is-invalid': categoryForm.errors.has('name') }">
                      <has-error :form="categoryForm" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Category</button>
                  </div>
                </form>
              </div>

              <div v-else >
                <form @submit.prevent="update_category()" @keydown="editdata.onKeydown($event)">
                  <div class="card-body">
                    <input type="hidden" v-model="editdata.id" name="id">
                    <input type="hidden" v-model="editdata.index" name="index">
                    <div class="form-group mb-0">
                      <label for="category_name">Category Name</label>
                      <input v-model="editdata.name" type="text" class="form-control" id="category_name" placeholder="Category Name"  :class="{ 'is-invalid': editdata.errors.has('name') }">
                      <has-error :form="editdata" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">UPdate Category</button>
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
export default {
    data() {
      return {
        categorys:[],
        categoryForm: new Form({
          name: ''
      }),
        editdata: new Form({
          name: '',
          id: '',
          index: ''
      }),

      add_form:true,

      }
    },
    methods: {

      
       getcategory() {
          axios.get('/api/dashboard/category').then(response => {
              this.categorys = response.data;
          })
       },
      addcategory(){
       

        this.categoryForm.post('/api/dashboard/category')
            .then(response => { 
          
          
          this.getcategory();
            this.categoryForm.name= '';
            this.$toast.success({
              title:'SUCCESS',
              message:'Category Created Successfully'
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
      editcategory(id , index){
        this.add_form=false
        axios.get(`/api/dashboard/category/${id}/edit`).then(response => {
              this.editdata.name = response.data.name;
              this.editdata.id = response.data.id;
              this.editdata.index = index;
              
          })
      },
      show_add_form(){
        this.add_form =true
      },
      async update_category(){
        const index= this.editdata.index;
        const id = this.editdata.id;
        this.editdata.put(`/api/dashboard/category/${id}`)
        .then(({ data }) => { 
          console.log(this.editdata.name);
          
          this.categorys[index].name= this.editdata.name;


          this.$toast.success({
              title:'SUCCESS',
              message:'Category Update Successfully'
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
      delete_category(category , index){
        
          
        axios.delete(`/api/dashboard/category/${category.id}`).then( res=>{
          let found = this.categorys.indexOf(category);
          this.categorys.splice(found, 1);
          this.$toast.success({
          title:'SUCCESS',
          message: res.data,
          })
        })
        
      }
    },
    mounted() {
      this.getcategory();
    }
    
}
</script>
<style lang="">
    
</style>