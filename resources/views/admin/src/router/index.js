import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/index'
import Login from '@/components/Login'
import novels  from '@/components/Novels'
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
        { path: '/novel/category', component: novelCategory,icon: 'el-icon-share', name: '小说类型',},
        { path: '/novel/novles', component: novels,icon: 'el-icon-share', name: '小说管理',},
        { path: '/novel/novles-add', component: novelCategory,icon: 'el-icon-share', name: '新增小说',},
      ]
    },
    {
      path: '/members',
      name: '会员管理',
      component: index,
      icon: 'el-icon-success',
      children: [
        { path: '/member/members', component: novelCategory,icon: 'el-icon-share', name: '会员管理',},
      ]
    },
    {
      path: '/statistics',
      name: '统计管理',
      component: index,
      icon: 'el-icon-edit-outline',
      children: [
        { path: '/statistics/member', component: novelCategory,icon: 'el-icon-share', name: '会员统计',},
        { path: '/statistics/novel', component: novelCategory,icon: 'el-icon-share', name: '小说统计',},
        { path: '/statistics/pv', component: novelCategory,icon: 'el-icon-share', name: '访问统计',},
      ]
    },
    {
      path: '/sites',
      name: '设置管理',
      component: index,
      icon: 'el-icon-setting',
      children: [
        { path: '/sites/index', component: sites,icon: 'el-icon-setting', name: '站点设置',},
        { path: '/process/index', component: sites,icon: 'el-icon-setting', name: '进程设置',},
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
