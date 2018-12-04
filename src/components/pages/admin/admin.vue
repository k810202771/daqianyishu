<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .left{
        position: relative;
        top: 0;
        width: 160px;
        border-right: 1px solid #eee;
        bottom: 0;
    }
    .right{
        position: absolute;
        top: 0;
        left: 160px;
        right: 0;
    }
    .box{
        position: relative;
    }
</style>

<template>
  <div class="box" v-if="load">
        <div class="left" :style="'position:' + position">
            <adminnav :value="navlist"></adminnav>
        </div>
        <div class="right" v-loading="types?false:true">
            <release v-show="$route.params.id == 1" :show="$route.params.id == 1" :types='types'></release>
            <articleslist v-show="$route.params.id == 2" :show="$route.params.id == 2" @page="uppage" :types='types'></articleslist>
            <draft v-show="$route.params.id == 3" :show="$route.params.id == 3" @page="updraft" :types='types'></draft>
            <andelete v-show="$route.params.id == 4" :show="$route.params.id == 4" @page="updelete" :types='types'></andelete>
            <banner v-show="$route.params.id == 5" :show="$route.params.id == 5" :types='types'></banner>
        </div>
  </div>
</template>

<script>
import adminnav from '@/components/pages/admin/left_nav'
import release from '@/components/pages/admin/release' //发布文章
import articleslist from '@/components/pages/admin/articleslist' //发布文章
import draft from '@/components/pages/admin/draft' //发布文章
import andelete from '@/components/pages/admin/delete' //发布文章
import banner from '@/components/pages/admin/banner' //发布文章

export default {
  name: '',
  components:{
      adminnav,articleslist,release,draft,andelete,banner
  },
  data () {
    return {
        load:false,
        types:window.types,
        position:'',
        navlist:[
            {id:"1",icon:'el-icon-plus',text:'发布内容',value:'new'},
            {id:"2",icon:'el-icon-tickets',text:'已发布',value:"0"},
            {id:"3",icon:'el-icon-document',text:'草稿',value:"0"},
            {id:"4",icon:'el-icon-delete',text:'垃圾箱',value:"0"},
            {id:"5",icon:'el-icon-picture-outline',text:'海报管理',value:"new"}
        ]
    }
  },
  methods:{
      handleScroll(e){
          var scrollTop = e.target.pageYOffset || e.target.documentElement.scrollTop || e.target.body.scrollTop
          if(scrollTop > 80){
              this.position = 'fixed';
          }else{
              this.position = '';
          }
      },
      uppage(value){
          this.navlist[1].value = value.value;
      },
      updraft(value){
          this.navlist[2].value = value.value;
      },
      updelete(value){
          this.navlist[3].value = value.value;
      }
  },
  created(){
      var loginsign = cookie.get('loginsign');
      if(loginsign){
        this.$http.post('list/login.php',{loginsign:loginsign}).then(function(res){
            switch(res.data.code){
                case 0:
                    this.$router.push({path:'/admin'})
                break;
                case 1:
                    this.load = true;
                    window.addEventListener('scroll', this.handleScroll)
                break;
            };
        })
      }else{
          this.$router.push({path:'/admin'})
      }
  }
}
</script>