<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .banner{
        background: #eee;
    }
    .swiper-container{
        height: 500px;
        width: 100%;
        min-width: 990px;
    }
    .box{
        text-align: center;
    }
    .box >>> .img_max{
        display: block;
        width: 90%;
        margin: 24px auto;
    }
    .box >>> .title{
        text-align: left;
        font-size: 18px;
        margin: 20px 0;
        color: #666;
    }
    .box >>> .content{
        text-align: left;
        font-size: 16px;
        margin: 20px 0;
        color: #666;
    }
    .box >>> .text_center{
        text-align: center;
    }
</style>

<template>
  <div class="box" v-html="html">
  </div>
</template>

<script>
export default {
  name: '',
  data () {
    return {
        html:'',
        onload(){
            this.$http.get('./static/ex(' + this.$route.params.Id + ').html').then((response) => {
            // 处理HTML显示
            this.html = response.data
            }).catch(() => {
            this.html = '加载失败'
            })
        }
    }
  },
  mounted(){
      this.onload();
  },
  watch:{
      "$route"(){
        this.onload();
      }
  }
}
</script>