<template>
    <div class="container">
        <div class="main">
        </div>
        <div class="main-input">
            <div class="username">
                <el-input v-model="username" placeholder="用户名"></el-input>
            </div>
            <div class="password">
                <el-input v-model="password" type="password" placeholder="密码"></el-input>
            </div>
            <div class="btn">
                <el-button v-on:click="login" style="width:100%" type="primary">登录</el-button>
            </div>
        </div>
    </div>
</template>

<script>
import env from '../../config/env.js'
import axios from 'axios'
export default {
  data() {
    return {
      username: '',
      password: ''
    }
  },
  created(){
  },
  methods:{
      login: function(){
        var params = {
            grant_type: env.grant_type,
            client_id: env.client_id,
            client_secret:env.client_secret,
            username: this.username,
            password: this.password
        }
        var url = env.baseUrl + '/oauth/token'
        var that = this
        axios.post(url,params).then(function(response){console.log(response)
            if(response.data.access_token){
                localStorage.setItem('access_token',response.data.access_token)
                that.$router.push({path:'/'});
            }
        }).catch(function(error){
            console.log(error)
            that.ElementUI.Notification.error({
                title: '错误',
                message: '登录失败！'
            });
        })
      }
  }
}
</script>

<style>
    .container{
        height: 100%;
        width:100%;
        /* background-color: rgb(3, 84, 160); */
        background-color: white;
        background-size:cover;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main{
        background-color: white;
        box-sizing: border-box;
        border-radius: 5px;
        box-shadow: 0 0 25px #cac6c6;
        height: 350px;
        width:450px;
        opacity: 0.8;
        display: flex;
        flex-direction: column;
        position: absolute;
        margin-top: -150px;
    }

    .main-input{
        position: relative;
        top:-120px;
        width: 350px;
        height: 250px;
    }

    .password{
        margin-top:50px;
    }

    .btn{
        margin-top: 50px;
    }

</style>
