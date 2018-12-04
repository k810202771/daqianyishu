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

    @media screen and (max-width: 768px) {
        .swiper-container{
            height: 180px;
            min-width: auto;
        }
    }
</style>

<template>
  <div class="">
    <div class="swiper-container" v-loading="bannerdata.load">
        <div class="swiper-wrapper">
            <div v-for="(item,index) in bannerdata.list" :key="index" :style="'background:url('+item.url+') center no-repeat;background-size:cover;'" class="banner swiper-slide" @click="topage(item.href)"></div>
        </div>
        <!-- Add Pagination -->
        <div class="swiper-pagination"></div>
    </div>
    <block title="动态新闻" type="text" more="null" :data="newsdata.list" v-loading="newsdata.load"></block>
    <block title="展览 & 公共项目" more="null" :data="demodata.list" v-loading="demodata.load"></block>
    <block title="公益" more="null" :data="pwdata.list" v-loading="pwdata.load"></block>
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
        bannerdata:{load:true,list:[]},
        newsdata:{load:true,list:[]},
        demodata:{load:true,list:[]},
        pwdata:{load:true,list:[]},
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
        observer:true,
        observeParents:true,
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
    this.$http.get('list/getlist.php?type=1&online=0&pagemax=2').then(function(res){
        this.pwdata.list = res.data.list;
        this.pwdata.load = false;
    }.bind(this));
    this.$http.get('list/getlist.php?time=now&type=0&online=0&pagemax=2').then(function(res){
        this.demodata.list = res.data.list;
        this.demodata.load = false;
    }.bind(this));
    this.$http.get('list/getlist.php?type=3&online=0').then(function(res){
        this.newsdata.list = res.data.list;
        this.newsdata.load = false;
    }.bind(this));
    this.$http.get('list/getbanner.php').then(function(res){
        this.bannerdata.list = res.data.list;
        this.bannerdata.load = false;
    })
  }
}
</script>