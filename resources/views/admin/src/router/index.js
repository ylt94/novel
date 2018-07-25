import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/index'
import Login from '@/components/Login'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: '首页',
      component: index
    },
    {
      path: '/login',
      name: 'login',
      component: Login
    }
  ]
})
