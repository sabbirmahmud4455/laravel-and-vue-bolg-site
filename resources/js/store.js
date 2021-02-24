import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        user:null ,
        userPermission: null

    },
    getters : {
        getUser(state){
           return state.user
        },
        getPermission(state){
           return state.userPermission
        }
    },
    mutations: {
       setUser(state , data){
          state.user= data
       },
       setPermission(state, data){
        state.userPermission= JSON.parse(data.permission)
       }
    }
})