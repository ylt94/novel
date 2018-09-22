import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/index'
import Login from '@/components/Login'
import novelCategory from '@/components/novelCategory'
import sites from '@/components/Sites'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: '小说管理',
      component: index,
      icon: 'el-icon-document',
      children: [
        { path: '/novel/category', component: novelCategory,icon: 'el-icon-share', name: '类型设置',},
      ]
    },
    {
      path: '/sites',
      name: '站点管理',
      component: index,
      icon: 'el-icon-document',
      children: [
        { path: '/sites/index', component: sites,icon: 'el-icon-info', name: '站点列表',},
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: Login,
      hidden: true
    },
  ]
})
