<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .item-box{
        font-size: 0;
    }
    .item-view{
        display: inline-block;
        width: 50%;
        cursor: pointer;
        vertical-align: top;
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
    .more{
        float: right;
    }
    .title{
        height: 48px;
        line-height: 48px;
    }
    .line{
        margin-top: 12px;
    }

    .text-view{
        list-style-type: none;
        padding: 0;
        margin: 0;
        font-size: 14px;
        background: #eee;
        color: #666;
        padding: 5px 20px;
    }
    .text-view li{
        padding: 10px 0;
        cursor: pointer;
    }
    .text-view li:hover{
        color: #333;
    }
    .text-view li+li{
        border-top: 1px solid #ddd;
    }
</style>

<template>
  <div class="box">
      <div class="line"></div>
      <div class="title">
          {{$attrs.title}}
          <span class="more" v-if="$attrs.more!='null'">{{$attrs.more}}>></span>
      </div>
      <!--显示新闻-->
      <div class="item-box" v-if="type=='text'">
          <ul class="text-view">
              <li @click="topage(item.id)" v-for="(item,index) in $attrs.data" :key="index">{{item.title}}</li>
          </ul>
      </div>
      <!--显示图片-->
      <div class="item-box" v-if="type=='img'">
        <div class="item-view" v-for="(item,index) in $attrs.data" :key="index" @click="topage(item.id)">
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
        title:'未命名的标题',
        more:'更多',
        type:'img',
        data:[
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1},
            {title:'女性力量：新维度——国际女性主义巡回展',cover:'http://pgq49ilm4.bkt.clouddn.com/zhan1-Cover.jpg',id:1}
        ],
        topage(id){
            this.$router.push({
              name: 'article',params: {Id: id}
            })
        }
    }
  },
  created(){
    this.type = this.$attrs.type?this.$attrs.type:this.type;
    for(var i in this.$data)this.$attrs[i] = this.$attrs[i]?this.$attrs[i]:this.$data[i];
  }
}
</script>