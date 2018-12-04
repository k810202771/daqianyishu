<template>
  <div class="box">
    <div class="header">
      <img src="@/assets/logo.png" class="logo">
      <div class="navindex" @click="shownav=true">···</div>
      <ul class="nav" v-if="$route.name!='admin'" :style="shownav?'display:block;':''">
        <li @click="click('home')">首页</li>
        <li @click="click('exhibition','now')">展览</li>
        <li @click="click('exhibition','project')">公共项目</li>
        <li @click="click('exhibition','record')">记录</li>
        <li @click="click('exhibition','shop')">商店</li>
        <li @click="click('exhibition','pw')">公益</li>
        <li @click="click('about')">关于我们</li>
        <li @click="click('search')" class="el-icon-search"></li>
      </ul>
      <div class="nav exit" v-if="$route.name=='admin'" @click="exitlogon">退出登陆</div>
    </div>
    <div class="line"></div>
    <div class="address" v-if="address">首页 >> 展览</div>
    <div class="line" v-if="address"></div>
  </div>
</template>

<script>
import '@/assets/css/style.css';

export default {
  name: '',
  data () {
    return {
      shownav:false,
      address: '',
      setaddress:function(){
        switch(this.$route.name){
          case 'exhibition':
            //this.address = '首页 >> 展览';
          break;
          case 'index':
            this.address = null;
          break;
          default:
            this.address = null;
          break;
        }
      },
      click(type,page){
        this.shownav = false;
        switch(type){
          case "home":
            this.$router.push({name: 'index'})
          break;
          case "exhibition":
            this.$router.push({
                name: 'exhibition',params: {type: page}
            })
          break;
          case "publicwelfare":
            this.$router.push({
              name: 'article',params: {Id: '9'}
            })
          break;
          case "about":
            this.$router.push({
              name: 'article',params: {Id: '12'}
            })
          break;
          case "search":

            this.$prompt('请输入要搜索的内容', '搜索', {
              confirmButtonText: '搜索',
              cancelButtonText: '取消',
              inputPattern: /\S/,
              inputErrorMessage: '内容不能为空',
            }).then(({ value }) => {
              this.$router.push({
                name: 'search',params: {content: value}
              })
            }).catch(() => {
              this.$message({
                type: 'info',
                message: '取消搜索'
              });       
            });

          break;
        }
      }
    }
  },
  methods:{
      exitlogon(){
        cookie.delete('loginsign');
        this.$router.push({path:'/admin'});
      }
  },
  created(){
    this.setaddress();
  },
  watch:{
    shownav(to){
      document.body.style.overflow = to?"hidden":'auto';
    },
    '$route'(to,from){
      this.setaddress();
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .navindex{
    display: none;
    color: #555;
  }
  .header{
    height: 80px;
    line-height: 80px;
  }
  .logo{
    height: 45px;
    vertical-align: middle;
  }
  .exit{
    cursor: pointer;
  }
  .nav{
    list-style-type: none;
    margin: 0;
    padding: 0;
    float: right;
    margin-right: 80px;
  }
  .nav li{
    display: inline-block;
    margin: 0 14px;
    cursor: pointer;
    line-height:inherit;
  }
  .box{
    font-size: 14px;
  }
  .address{
    line-height: 1;
    padding: 20px;
  }
  .huise{
    color: #ccc;
  }
  .box >>> [class*=" el-icon-"], [class^=el-icon-]
  {
    line-height: inherit !important ;
  }
  
  @media screen and (max-width: 768px) {
    .navindex{
      display: block;
      list-style-type: none;
      margin: 0;
      padding: 0;
      float: right;
      margin-right: 10px;
      font-size: 32px;
    }
    .nav {
      display: none;
      position: absolute;
      z-index: 999;
      background: #fff;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      margin-right: 0;
    }
    .nav li{
      display: block;
      margin: 0 14px;
      cursor: pointer;
    }
    .header{
      height: 48px;
      line-height: 48px;
    }
    .logo{
      height: 24px;
      vertical-align: middle;
    }
  }
</style>