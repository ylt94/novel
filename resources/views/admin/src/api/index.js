import Vue from 'vue'
import axios from 'axios'
import env from '../../config/env.js'
import ElementUI from 'element-ui';
import router from '../router'

axios.defaults.baseURL = env.baseUrl
axios.defaults.timeout = 6000

if(!localStorage.getItem('access_token')){
    router.push('/login')
}
console.log('token--------------->',localStorage.getItem('access_token'));
axios.defaults.headers.common['Authorization'] ='Bearer ' + localStorage.getItem('access_token')

function get(url,params){
    return new Promise(function(resolve,reject){
        axios.get(url,{params})
        .then(function (response) {
            resolve(response.data)
        }).catch(function(error){
            errorCheck(error)
        })
    })
}

function post(url,params){
    return new Promise(function(resolve,reject){
        axios.post(url,params)
        .then(function (response) {
            resolve(response.data)
        }).catch(function(error){
            console.log('error->>>>>>>>',error.response.status)
            errorCheck(error)
        })
    })
}

function getToken(){
    console.log('token--------------->',localStorage.getItem('access_token'));
    axios.defaults.headers.common['Authorization'] ='Bearer ' + localStorage.getItem('access_token')
}

function errorCheck(error){
    var msg = ''
    switch(error.response.status){
        case 400:
            msg = '验证错误!'
            break
        case 401:
            msg = '登录失效!'
            router.push('/login')
            break
        case 404:
            msg = '服务未找到!'
            break
        case 405:
            msg = '方法不被允许!'
            break
        case 500:
            msg = '服务器错误，请稍后再试!'
            break
    }
    ElementUI.Notification.error({
        title: '提示',
        message: msg
      });

}

function retrunMsg(ret){
    if(ret.status) {
        ElementUI.Message({
            type: 'success',
            message: '操作成功!'
        })
    }else{
        ElementUI.Message({
            type: 'error',
            message: '操作失败:'+ret.msg
        })
    }
}

export default{
    get,
    post,
    retrunMsg
}