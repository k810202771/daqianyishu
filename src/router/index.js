import Vue from 'vue'
import Router from 'vue-router'
import index from '@/components/pages/index'
import exhibition from '@/components/pages/exhibition'
import article from '@/components/pages/article'

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
    }
  ]
})
