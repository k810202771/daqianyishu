<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .text-view{
        list-style-type: none;
        padding: 0;
        margin: 0;
        margin-top: 10px;
        font-size: 14px;
        background: #eee;
        color: #777;
        padding: 5px 20px;
    }
    .text-view li{
        padding: 10px 0;
        cursor: pointer;
    }
    .text-view li:hover{
        color: #222;
    }
    .text-view li+li{
        border-top: 1px solid #ddd;
    }
</style>

<template>
  <div class="box">
    <ul class="text-view">
        <li @click="topage(item.id)" v-for="(item,index) in content" :key="index">[{{types[item.zltype].name}}] {{item.title}} —— {{item.subtitle}}</li>
    </ul>
    <div style="text-align:center;margin:10px;">
        <el-pagination
        background
        layout="prev, pager, next"
        :page-size='1'
        @current-change="pagechange"
        :current-page="pageidnex + 1"
        :total="pagemax">
        </el-pagination>
    </div>
  </div>
</template>

<script>
export default {
  name: '',
  data () {
    return {
        types:window.types,
        content:[],
        pageidnex:0,
        pagemax:0
    }
  },
  methods:{
    update(){
      this.$http.get('list/getlist.php?online=0&title=' + this.$route.params.content + "&pageindex=" + this.pageidnex).then(function(res){
          console.log(res);
          this.content = res.data.list
          this.pagemax = res.data.count
      })
    },
    pagechange(e){
        this.pageidnex = e - 1;
        this.update();
        console.log(this.pageidnex);
    }
  },
  watch:{
      $route(to,from){
        this.pageidnex = 0;
        this.update();
      }
  },
  created(){
    this.update()
  }
}
</script>