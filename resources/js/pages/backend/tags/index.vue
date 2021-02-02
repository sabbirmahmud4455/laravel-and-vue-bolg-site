
<template lang="">
    <div> 
         <!-- Content Wrapper. Contains page content -->
      
          <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div  class="row mb-2">
          <div class="col-sm-6">
            
            <h1 class="m-0 text-dark">Tags</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><router-link :to="{name:'dashboard'}">Dashboard</router-link></li>
              <li class="breadcrumb-item active">Tags</li>
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
                  <tbody v-if="tags.length">
                    
                    <tr v-for="(tag, index) in tags" :key="index" >
                      <td>{{index+1}}</td>
                      <td>{{tag.name}}</td>
                      <td>
                        <button v-on:click="editTag(tag.id, index)"  class="btn btn-primary"> <i class="fas fa-pen    "></i></button>
                        <button v-on:click="delete_tag(tag)" class="btn btn-danger"> <i class="fas fa-trash    "></i></button>
                      </td>
                    </tr>
                  </tbody>
                  <div v-else>
                      <h3>Tag Not Found</h3>
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
              </div>
            </div> -->
            
          </div>
          
          <div class="col-lg-4">
              <div class="card card-primary">
              <div v-if="this.add_form==true" class="card-header">
            
                <h3 class="card-title">Add Tag</h3>
              </div>
              <div v-else class="card-header d-flex">
                <h3 class="card-title">Update Tag</h3>
                <button class="btn btn-info ml-auto py-0" v-on:click="show_add_form()">Add Tag</button>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <div v-if="this.add_form==true">
                <form   @submit.prevent="addTag()" @keydown="tagForm.onKeydown($event)">
                  <div class="card-body">
                    <div class="form-group mb-0">
                      <label for="tag_name">Tag Name</label>
                      <input v-model="tagForm.name" type="text" class="form-control" id="tag_name" placeholder="Tag Name"  :class="{ 'is-invalid': tagForm.errors.has('name') }">
                      <has-error :form="tagForm" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Add Tag</button>
                  </div>
                </form>
              </div>

              <div v-else >
                <form @submit.prevent="update_tag()" @keydown="editdata.onKeydown($event)">
                  <div class="card-body">
                    <input type="hidden" v-model="editdata.id" name="id">
                    <input type="hidden" v-model="editdata.index" name="index">
                    <div class="form-group mb-0">
                      <label for="tag_name">Tag Name</label>
                      <input v-model="editdata.name" type="text" class="form-control" id="tag_name" placeholder="Tag Name"  :class="{ 'is-invalid': editdata.errors.has('name') }">
                      <has-error :form="editdata" field="name"></has-error>
                    </div>
                  </div>
                  <!-- /.card-body -->
                
                  <div class="card-footer">
                    <button type="submit" class="btn btn-primary">UPdate Tag</button>
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
        tags:[],
        tagForm: new Form({
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

      
       getTag() {
          axios.get('/api/dashboard/tag').then(response => {
              this.tags = response.data;
          })
       },
      addTag(){
       

        this.tagForm.post('/api/dashboard/tag')
            .then(response => { 
          
          
          this.getTag();
            this.tagForm.name= '';
            this.$toast.success({
              title:'SUCCESS',
              message:'Tag Created Successfully'
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
      editTag(id , index){
        this.add_form=false
        axios.get(`/api/dashboard/tag/${id}/edit`).then(response => {
              this.editdata.name = response.data.name;
              this.editdata.id = response.data.id;
              this.editdata.index = index;
              
          })
      },
      show_add_form(){
        this.add_form =true
      },
      async update_tag(){
        const index= this.editdata.index;
        const id = this.editdata.id;
        this.editdata.put(`/api/dashboard/tag/${id}`)
        .then(({ data }) => { 
          console.log(this.editdata.name);
          
          this.tags[index].name= this.editdata.name;


          this.$toast.success({
              title:'SUCCESS',
              message:'Tag Update Successfully'
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
      delete_tag(tag , index){
        
          
        axios.delete(`/api/dashboard/tag/${tag.id}`).then( res=>{
          let found = this.tags.indexOf(tag);
          this.tags.splice(found, 1);
          this.$toast.success({
          title:'SUCCESS',
          message: res.data,
          })
        })
        
      }
    },
    mounted() {
      this.getTag();
    }
    
}
</script>
<style lang="">
    
</style>