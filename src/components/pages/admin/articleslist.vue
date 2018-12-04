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
        z-index: 9;
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
    .bannerbox{
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.2);
        z-index: 999;
    }
    .banner{
        position: absolute;
        width: 600px;
        height: 220px;
        background: #fff;
        margin: auto;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        padding: 10px;
    }
    .upbannerbox{
        width: 384px;
        height: 100px;
        line-height: 100px;
        text-align: center;
        background: #eee;
        margin: 20px auto 5px;
        font-size: 40px;
        color: #bbb;
        position: relative;
    }
    .bannerauto{
        border: 1px solid #eee;
        height: 100%;
        text-align: center;
    }
    .fileInput{
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        width: 100%;
        opacity: 0;
    }
    .explain{
        font-size: 14px;
        color: #888;
    }
    .queren{
        margin: 20px;
    }
</style>

<template>
    <div v-loading="fullscreenLoading">
        <div v-if="bannershow" class="bannerbox" @click="bannershow = false">
            <div class="banner" @click.stop='bannershow=bannershow'>
                <div class="bannerauto">
                    <div class="upbannerbox" :style="banner?'background:url(' + banner + ') center center / contain no-repeat;':''">
                        <span class="el-icon-plus" v-if="!banner"></span><input type="file" class="fileInput" @change="upimgs">
                    </div>
                    <span class="explain">（推荐尺寸 1920*500）</span>
                    <div class="queren">
                        <el-button type="success" @click.stop="setbanner(bannershow)">确定添加</el-button>
                    </div>
                </div>
            </div>
        </div>
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
                            <el-button size="mini" @click.stop="ontype(item.id,'1')" round>存草稿</el-button>
                            <el-button size="mini" @click.stop="ontype(item.id,'2')" round>删除</el-button>
                            <el-button size="mini" @click.stop="notrecommend(item.id,item.recommend=='0'?'true':'false')" round>{{item.recommend=='0'?'置顶':'取消置顶'}}</el-button>
                            <el-button size="mini" @click.stop="bannershow = item.id" round>插入海报</el-button>
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
        banner:null,
        bannerKEY:null,
        bannershow:false,
        type:"-1",
        fullscreenLoading:true,
        list:null,
        pagemasx:0,
        pageindex:1
    }
  },
  methods:{
    //上传图片
    upimgs:function(type){
        
        console.log(type);

        var file = event.currentTarget.files;
        var reader = [];
        var that = this;
        
        for(var i = 0;i<file.length;i++){
            reader[i] = new FileReader();
            reader[i].readAsDataURL(file[i]);
            
            reader[i].onload = function (a) {
                var basedata = a.target.result.substr(('data:image/jpeg;base64,').length,a.target.result.length);
                that.$http.post('/list/index.php',{
                    imgdata: basedata
                },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then((response) => {
                    that.banner = response.data.src;
                    that.bannerKEY = response.data.key;
                    console.log(response)
                })

            }
        }


    },
    setbanner(id){
        //img,url,herf
        if(this.banner){
            this.$http.post('/list/setbanner.php',{
                img: this.bannerKEY,url: this.banner,href: id,type:'init'
            },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
                if(response.data.code == 1){
                    this.bannerKEY = null;
                    this.banner = null;
                    this.bannershow = false;
                    this.$message({
                        message: '操作成功',
                        type: 'success'
                    });
                }else{
                    this.$message.error('操作失败！');
                }
                console.log(response);
            }.bind(this))
        }else{
            this.$message.error('请上传banner图！');
        }
        console.log(id)
    },
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
        this.$http.get('/list/getlist.php?pageindex=' + this.$route.params.type + '&online=0' + ( isNaN(value) || value == "-1"?'':'&type='+value),{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
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
        if(to.params.id == 2 && from.params.id == 2 || to.params.id == 2 && from.params.type == "new"){
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
      console.log(this);
    if(this.show){
        this.update();
    }
  }
}
</script>