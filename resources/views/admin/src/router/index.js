import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/index'
import Login from '@/components/Login'
import novelCategory from '@/components/novelCategory'

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
    },
    {
      path: '/novel/category',
      name: 'novel-category',
      component: novelCategory
    }
  ]
})
