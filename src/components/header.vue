<template>
  <div class="box">
    <div class="header">
      <img src="@/assets/logo.png" class="logo">
      <ul class="nav">
        <li @click="click('home')">首页</li>
        <li @click="click('exhibition')">展览</li>
        <li class="huise">公共项目</li>
        <li class="huise">记录</li>
        <li class="huise">商店</li>
        <li @click="click('publicwelfare')">公益</li>
        <li @click="click('about')">关于我们</li>
      </ul>
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
      address: '',
      setaddress:function(){
        switch(this.$route.name){
          case 'exhibition':
            this.address = '首页 >> 展览';
          break;
          case 'index':
            this.address = null;
          break;
          default:
            this.address = null;
          break;
        }
      },
      click(type){
        switch(type){
          case "home":
            this.$router.push({name: 'index'})
          break;
          case "exhibition":
            this.$router.push({
                name: 'exhibition',params: {type: 'now'}
            })
          break;
          case "publicwelfare":
            this.$router.push({
              name: 'article',params: {Id: '9'}
            })
          break;
          case "about":
            this.$router.push({
              name: 'article',params: {Id: '8'}
            })
          break;
        }
      }
    }
  },
  created(){
    this.setaddress();
  },
  watch:{
    '$route'(to,from){
      this.setaddress();
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .header{
    height: 80px;
    line-height: 80px;
  }
  .logo{
    height: 45px;
    vertical-align: middle;
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

  @media screen and (max-width: 768px) {
    .nav {
      display: block;
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