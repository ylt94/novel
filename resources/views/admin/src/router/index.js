import Vue from 'vue'
import Router from 'vue-router'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: '小说管理',
      component: resolve => require(['@/components/index'],resolve),
      icon: 'el-icon-document',
      children: [
        { 
          path: '/novel/category', 
          component: resolve => require(['@/components/novelCategory'],resolve),
          icon: 'el-icon-share', 
          name: '小说类型',
        },
        { 
          path: '/novel/novles', 
          component: resolve => require(['@/components/novels'],resolve),
          icon: 'el-icon-share', 
          name: '小说管理',
        },
        { 
          path: '/novel/novles-add', 
          component: resolve => require(['@/components/novelCategory'],resolve),
          icon: 'el-icon-share', 
          name: '新增小说',},
      ]
    },
    {
      path: '/member',
      name: '会员管理',
      component: resolve => require(['@/components/index'],resolve),
      icon: 'el-icon-success',
      children: [
        { 
          path: '/member/members', 
          component: resolve => require(['@/components/members'],resolve),
          icon: 'el-icon-share', 
          name: '会员管理',
        },
      ]
    },
    {
      path: '/statistics',
      name: '统计管理',
      component: resolve => require(['@/components/index'],resolve),
      icon: 'el-icon-edit-outline',
      children: [
        { 
          path: '/statistics/member', 
          component: resolve =>require(['@/components/novelCategory'],resolve),
          icon: 'el-icon-share', 
          name: '会员统计',
        },
        { 
          path: '/statistics/novel', 
          component: resolve =>require(['@/components/novelCategory'],resolve),
          icon: 'el-icon-share', 
          name: '小说统计',
        },
        { 
          path: '/statistics/pv', 
          component: resolve =>require(['@/components/novelCategory'],resolve),
          icon: 'el-icon-share', 
          name: '访问统计',
        },
      ]
    },
    {
      path: '/sites',
      name: '设置管理',
      component: resolve => require(['@/components/index'],resolve),
      icon: 'el-icon-setting',
      children: [
        { 
          path: '/sites/index', 
          component: resolve =>require(['@/components/sites'],resolve),
          icon: 'el-icon-setting', 
          name: '站点设置',
        },
        { 
          path: '/process/index', 
          component: resolve =>require(['@/components/sites'],resolve),
          icon: 'el-icon-setting', 
          name: '进程设置',
        },
      ]
    },
    {
      path: '/login',
      name: 'login',
      component: resolve => require(['@/components/login'],resolve),
      hidden: true
    },
  ]
})
