<!-- Add "scoped" attribute to limit CSS to this component only -->
import { constants } from 'http2';
<style scoped>
    .img{
        width: 384px;
        height: 100px;
        vertical-align: middle;
        float: left;
    }
    .hebox{
        padding: 10px;
    }
    .linebox{
        height: 100px;
        line-height: 100px;
        text-align: right;
        padding: 5px;
    }
    .linebox+.linebox{
        border-top: 1px solid #eee;
    }
    .onbutton{
        vertical-align: middle;
    }
</style>

<template>
  <div v-loading="fullscreenLoading" class="hebox">
      <div v-for="(item,index) in list" :key="index" class="linebox">
          <img :src="item.url" class="img">
          <el-button type="text" @click.stop="deletebanner(item.id)">删除本条记录</el-button>
      </div>
  </div>
</template>

<script>

export default {
  name: 'banner',
  data () {
    return {
        fullscreenLoading:true,
        list:[]
    }
  },
  methods:{
    deletebanner(id){
        this.$http.post('/list/setbanner.php',{
            id: id,type:'delete'
        },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
            if(response.data.code == 1){
                this.update();
                this.$message({
                    message: '操作成功',
                    type: 'success'
                });
            }else{
                this.$message.error('操作失败！');
            }
            console.log(response);
        }.bind(this))
    },
    update(value){
        this.fullscreenLoading = true;
        if(!this.$route.params.type){
            this.$route.params.type = 0
        }
        this.$emit('page',{value: parseInt(this.$route.params.type) });
        this.$http.get('/list/getbanner.php',{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
            this.list = response.data.list;
            this.pagemasx = response.data.count;
            this.fullscreenLoading = false;
            console.log(response);
        }.bind(this))
    }
  },
  watch:{
      show(value){
          if(value){
            this.update();
          }
      }
  },
  computed: {
    show() {
　　　　return this.$attrs.show
　　}
  },
  mounted(){
    if(this.show){
        this.update();
    }
  }
}
</script>