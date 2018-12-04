import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/pages/index'
import exhibition from '@/components/pages/exhibition'
import article from '@/components/pages/article'
import admin from '@/components/pages/admin/admin'
import myadmin from '@/components/pages/admin/index'
import search from '@/components/pages/search'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: index
    },
    {
      path: '/exhibition/:type',
      name: 'exhibition',
      component: exhibition
    },
    {
      path: '/article/:Id',
      name: 'article',
      component: article
    },
    {
      path: '/admin/:id/:type',
      name: 'admin',
      component: admin
    },{
      path: '/admin/',
      name: 'myadmin',
      component: myadmin
    },
    {
      path: '/search/:content',
      name: 'search',
      component: search
    }
  ]
})
