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

    .box >>> .text_center{
        text-align: center;
    }
    .content >>> p{
        text-align: left;
        font-size: 16px;
        margin: 20px 0;
        color: #666;
    }
    .content >>> img{
        max-width: 100%;
        height: auto !important;
    }
</style>

<template>
  <div class="box">
      <div class="title">
          {{title}} {{subtitle?'——':''}} {{subtitle}}
      </div>
      <div v-html="html" class="content">

      </div>
  </div>
</template>

<script>
export default {
  name: '',
  data () {
    return {
        html:'',
        title:'',
        subtitle:'',
        onload(){
            this.$http.get('/list/getlist.php?list=*&id=' + this.$route.params.Id ).then((response) => {
                // 处理HTML显示
                this.html = response.data.list[0].content
                this.title = response.data.list[0].title
                this.subtitle = response.data.list[0].subtitle
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