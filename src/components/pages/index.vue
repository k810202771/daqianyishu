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
    .swiper-pagination >>> .swiper-pagination-bullet-active{
        background: #fff;
    }
</style>

<template>
  <div class="">
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div style="background:url(http://pgq49ilm4.bkt.clouddn.com/banner2.jpg) center" class="banner swiper-slide" @click="topage(10)"></div>
            <div style="background:url(http://pgq49ilm4.bkt.clouddn.com/banner1.jpg) center" class="banner swiper-slide" @click="topage(4)"></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <block title="动态新闻" type="text" more="null" :data="news"></block>
    <block title="展览 & 公共项目" more="null" :data="demo"></block>
    <block title="公益" more="null" :data="gongyi"></block>
  </div>
</template>

<script>
import Swiper from 'swiper';
import block from '@/components/block.vue';
import '@/assets/css/swiper.min.css';

export default {
  name: '',
  components: {block},
  data () {
    return {
        news:[
            {title:'三千大千世界——大千画廊30周年特展',id:10},
            {title:'女性力量：新维度——国际女性主义巡回展',id:1},
            {title:'内观-全国优秀八零后中国画作品展',id:2},
            {title:'在路上——中国青年艺术家巡展',id:3},
        ],
        demo:[
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan7-Cover.jpg',id:10},
            {title:'内观-全国优秀八零后中国画作品展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan2-Cover.jpg',id:2}
        ],
        gongyi:[
            {title:'为了母亲的微笑——幸福工程精准扶贫健康扶贫23载跡录展',cover:'http://pgq49ilm4.bkt.clouddn.com/gongyi1-Cover.jpg',id:9}
        ],
        topage(id){
            this.$router.push({
              name: 'article',params: {Id: id}
            })
        },
    }
  },
  mounted(){
    var swiper = new Swiper('.swiper-container', {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true
        }
    });
  }
}
</script>