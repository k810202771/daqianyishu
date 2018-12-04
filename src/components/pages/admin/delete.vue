<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .item-box{
        font-size: 0;
        margin: 4px auto 0;
        padding: 0 5px;
    }
    .item-view{
        position: relative;
        overflow: hidden;
        display: inline-block;
        /*width: 200px;*/
        cursor: pointer;
        margin-bottom: 12px;
    }
    .cover{
        width: 400px;
        height: 300px;
    }
    .button{
        width: 400px;
        text-align: left;
    }
    .item-title{
        text-align: left;
        font-size: 14px;
        color: #888;
        display: block;
        padding: 12px 2px;
    }
    .block{
        text-align: center;
        margin: 20px;
    }
    .rightjb{
        position: absolute;
        right: 5px;
        top: 5px;
        z-index: 9999;
        font-size: 12px;
        padding: 5px;
        background: #f88;
        color: #fff;
    }
    .demo-input-suffix{
        margin-top: 10px;
        margin-left: 10px;
    }
    .el-radio-button >>> .el-radio-button__orig-radio:checked+.el-radio-button__inner{
        background-color: #f56c6c;
        border-color: #f56c6c;
        box-shadow: -1px 0 0 0 #f56c6c;
    }
    .el-radio-button >>> .el-radio-button__orig-radio:checked+.el-radio-button__inner:hover{
        color: #fff;
    }
    .el-radio-button >>> .el-radio-button__inner:hover{
        color: #f56c6c;
    }
</style>

<template>
    <div v-loading="fullscreenLoading">
        <div class="demo-input-suffix">
            <el-radio-group v-model="type">
                <el-radio-button label="-1">全部</el-radio-button>
                <el-radio-button :label="index" v-for="(item,index) in $attrs.types" :key="index">{{item.name}}</el-radio-button>
            </el-radio-group>
        </div>
        <div class="item-box">
            <div class="item-view" v-for="(item,index) in list" :key="index" @click="topage(item.id)">
                <div class="rightjb">{{$attrs.types[item.zltype].name}}</div>
                <div style="overflow:hidden;padding: 5px;">
                    <img class="cover" :src="item.cover">
                    <span class="item-title">
                        {{item.title}}
                    </span>
                    <div class="button">
                        <el-button-group>
                            <el-button size="mini" @click.stop="xiugai(item.id)" round>修改</el-button>
                            <el-button size="mini" @click.stop="ontype(item.id,'0')" round>发布</el-button>
                            <el-button size="mini" @click.stop="ontype(item.id,'1')" round>存入草稿</el-button>
                            <el-button size="mini" @click.stop="notrecommend(item.id,item.recommend=='0'?'true':'false')" round>{{item.recommend=='0'?'置顶':'取消置顶'}}</el-button>
                        </el-button-group>
                    </div>
                </div>
            </div>
        </div>
        <div class="block">
            <el-pagination
            background
            layout="prev, pager, next"
            :total="pagemasx" :page-size="1" @current-change="uppage" :current-page="pageindex">
            </el-pagination>
        </div>


    </div>
</template>

<script>


export default {
  name: 'list',
  data () {
    return {
        type:"-1",
        fullscreenLoading:true,
        list:null,
        pagemasx:0,
        pageindex:1
    }
  },
  methods:{
    topage(id){
        console.log(id);
    },
    //修改类型
    ontype(id,value){
        this.$http.post('/list/functions.php?id='+id,{
            online:value
        },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
            if(response.data.code == 1){
                this.$router.push({
                    params: {type: 'new'}
                })
                this.update(this.type)
                this.$message({
                    message: '操作成功',
                    type: 'success'
                });
            }else{
                this.$message.error('操作失败！');
            }
        }.bind(this))
    },
    //修改
    xiugai(id){
        this.pageindex = -1;
        this.$router.push({
            params: {id:1,type: id}
        })
    },
    //取消置顶
    notrecommend(id,value){
        this.$http.post('/list/functions.php?id='+id,{
            recommend:value
        },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
            if(response.data.code == 1){
                this.update(this.type)
                this.$message({
                    message: '操作成功',
                    type: 'success'
                });
            }else{
                this.$message.error('操作失败！');
            }
        }.bind(this))
    },
    uppage(index){
        this.$router.push({
            params: {type: index - 1}
        })
    },
    update(value){
        this.fullscreenLoading = true;
        if(!this.$route.params.type){
            this.$route.params.type = 0
        }
        this.$emit('page',{value: parseInt(this.$route.params.type) });
        this.$http.get('/list/getlist.php?pageindex=' + this.$route.params.type + '&online=2' + (!value || value == "-1"?'':'&type='+value),{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
            this.list = response.data.list;
            this.pagemasx = response.data.count;
            this.pageindex = parseInt(this.$route.params.type) + 1;
            this.fullscreenLoading = false;
            console.log(response);
        }.bind(this))
    }
  },
  watch:{
      type(value,fromvalue){
            this.$router.push({
                params: {type: 0}
            })
            this.update(value);
      },
      $route(to,from){
        if(to.params.id == 4 && from.params.id == 4 || to.params.id == 4 && from.params.type == "new"){
            if(this.list)this.update(this.type)
        };
      },
      show(value){
          if(value){
            if(!this.list || this.pageindex != parseInt(this.$route.params.type) + 1 )this.update();
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