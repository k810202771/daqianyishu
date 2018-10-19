<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .nav{
        list-style-type: none;
        margin: 0 10px;
        padding: 0;
    }
    .nav li{
        display: inline-block;
        padding: 10px;
    }
    .navsub{
        color: #999;
        text-decoration: none;
    }
    .fontcolor{
        color: block;
    }
    .item-box{
        margin-top: 16px;
        font-size: 0;
    }
    .item-view{
        display: inline-block;
        width: 50%;
        cursor: pointer;
    }
    .cover{
        width: 100%;
    }
    .item-title{
        font-size: 16px;
        color: #666;
        display: inline-block;
        padding: 16px 0;
    }
</style>
<template>
  <div class="box">
      <ul class="nav">
          <li>
              <router-link class="navsub" :style="'color:' + nav.now" :to="{name:'exhibition',params:{type:'now'}}">正在展出</router-link>
          </li>
          <li>
              <router-link class="navsub" :style="'color:' + nav.soon" :to="{name:'exhibition',params:{type:'soon'}}">即将展出</router-link>
          </li>
          <li>
              <router-link class="navsub" :style="'color:' + nav.past" :to="{name:'exhibition',params:{type:'past'}}">过往展出</router-link>
          </li>
      </ul>
      <div class="item-box">
        <div class="item-view" v-for="(item,index) in data" :key="index" @click="topage(item.id)">
            <div style="overflow:hidden;padding: 5px;">
                <img class="cover" :src="item.cover">
                <span class="item-title">
                    {{item.title}}
                </span>
            </div>
        </div>
      </div>
  </div>
</template>

<script>
export default {
  name: '',
  data () {
    return {
        nav:{
            now: "#999",
            soon: "#999",
            past: "#999"
        },
        data:[],
        topage(id){
            this.$router.push({
              name: 'article',params: {Id: id}
            })
        },
        update(){
            this.nav.now = ""
            this.nav.soon = ""
            this.nav.past = ""
            switch(this.$route.params.type){
                case "soon":
                    this.data = [];
                    this.nav.soon = "#000"
                break;
                case "past":
                    this.data = [
                        {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
                        {title:'内观-全国优秀八零后中国画作品展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan2-Cover.jpg',id:2},
                        {title:'在路上——中国青年艺术家巡展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan3-Cover.jpg',id:3},
                        {title:'纸牌屋-黄勇色粉画展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan4-Cover.jpg',id:4},
                        {title:'「迁想妙得」 ——“寻大国工匠精神 与经典面对面”',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan5-Cover.jpg',id:5},
                        {title:'陈岩和陈岩的朋友们文献展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan6-Cover.jpg',id:6}
                    ]
                    this.nav.past = "#000"
                break;
                default:
                    this.data = [
                        {title:'三千大千世界——大千画廊30周年特展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan7-Cover.jpg',id:10},
                    ]
                    this.nav.now = "#000";
                break;
            }

            
        }
    }
  },
  created(){
      this.update();
  },
  watch: {
    "$route"(to,from){
        this.update();
    }
  }
}
</script>