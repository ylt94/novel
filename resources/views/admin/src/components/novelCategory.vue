<template>
    
</template>

<script>
import env from '../../config/env.js'
import axios from 'axios'
export default {
  data() {
    return {
      categories:[]
    }
  },
  created(){
      this.getCategories();
  },
  methods:{
      getCategories(){
          this.api.get('api/admin/novel/categories').then((ret)=>{
              console.log(ret)
          })
      },
      
  }
}
</script>

<style>
    .container{
        height: 100%;
        width:100%;
        background-image:url('../assets/timg.jpg');
        background-size:cover;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main{
        background-color: white;
        box-sizing: border-box;
        border:1px solid grey;
        border-radius: 5px;
        height: 600px;
        width:400px;
        margin-left:300px;
        opacity: 0.8;
        display: flex;
        flex-direction: column;
        position: absolute;
    }

    .main-input{
        position: relative;
        left:300px;
        top:50px;
        width: 350px;
        height: 300px;
    }

    .password{
        margin-top:50px;
    }

    .btn{
        margin-top: 130px;
    }

</style>
