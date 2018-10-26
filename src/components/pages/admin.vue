<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .onfile{
        display: inline-block;
        height: 100px;
        width: 100px;
        line-height: 100px;
        text-align: center;
        font-size: 90px;
        border: 1px solid #dcdfe6;
        border-radius: 3px;
        color: #dcdfe6;
        position: relative;
        overflow: hidden;
        vertical-align: middle;
    }
    #fileInput{
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        left: 0;
        opacity: 0;
    }
    .el-input{
        width: 250px;
    }
    .el-input-title{
        display: inline-block;
        width: 250px;
        height: 32px;
        line-height: 32px;
        text-align: center;
    }
    .el-input-number{
        width: 250px;
    }
    .n_left{
        display: inline-block;
        width: 150px;
        text-align: right;
        margin-right: 10px;
    }
    .demo-input-suffix{
        margin-top: 10px;
    }
</style>

<template>
  <div class="box">
        
        <div class="demo-input-suffix">
            <span class="n_left">标题:</span><el-input placeholder="请输入标题" prefix-icon="el-icon-edit-outline" v-model="input2"></el-input>
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">副标题:</span><el-input placeholder="请输入副标题" prefix-icon="el-icon-edit-outline" v-model="input2"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">封面:</span><span
            class="el-icon-plus onfile">
                <input type="file" id="fileInput" @change="upimgs">
            </span>
            {{current}}/{{Maximum}}
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">日期/时间:</span><el-date-picker
                v-model="value6"
                type="daterange"
                align="right"
                unlink-panels
                range-separator="至"
                start-placeholder="开始日期"
                end-placeholder="结束日期"
                :picker-options="pickerOptions2">
                </el-date-picker>
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">时间补充:</span><el-input placeholder="请输入时间补充" prefix-icon="el-icon-edit-outline" v-model="input2"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">地址:</span><el-input placeholder="请输入地址" prefix-icon="el-icon-edit-outline" v-model="input2"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">费用:</span><span class="el-input-title">门票类型</span><span class="el-input-title">价格</span>
            <div class="demo-input-suffix" v-for="(item,index) in data.price" :key="index"><span
            class="n_left"></span><el-input placeholder="请输入类型" prefix-icon="el-icon-edit-outline" v-model="data.price[index].name"></el-input>
            <el-input-number v-model="data.price[index].price" :step="0.1" :min="0" :controls="false"></el-input-number>
            <el-button v-if="index>0" @click="deletes(index)" icon="el-icon-delete" type="danger" circle></el-button>
            </div>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left"></span><el-button @click="inserts()" type="warning" round>添加</el-button>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">费用补充:</span><el-input placeholder="请输入费用补充" prefix-icon="el-icon-edit-outline" v-model="input2"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">购票二维码:</span><span
            class="el-icon-plus onfile">
                <input type="file" id="fileInput" @change="upimgs">
            </span>
            {{current}}/{{Maximum}}
        </div>

        <div class="demo-input-suffix">
            <UE ue_style="width:auto;height:400px;margin-left:150px;"></UE>
        </div>

  </div>
</template>

<script>
import UE from '@/components/ue.vue';

export default {
  name: '',
  components:{UE},
  data () {
    return {
        pickerOptions2: {
          shortcuts: [{
            text: '最近一周',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 7);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近一个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 30);
              picker.$emit('pick', [start, end]);
            }
          }, {
            text: '最近三个月',
            onClick(picker) {
              const end = new Date();
              const start = new Date();
              start.setTime(start.getTime() - 3600 * 1000 * 24 * 90);
              picker.$emit('pick', [start, end]);
            }
          }]
        },
        data:{
            price:[
                {}
            ]
        },
        value6: '',
        input2:'',
        title: '',
        current:0,
        Maximum:0
    }
  },
  methods:{
      deletes(id){
          this.data.price.splice(id,1);
      },
      inserts(){
          this.data.price.push({})
      },
      upimgs:function(){
        var file = event.currentTarget.files;
        var reader = [];
        var that = this;
        that.Maximum = file.length;
        that.current = 0;
        for(var i = 0;i<file.length;i++){
            reader[i] = new FileReader();
            reader[i].readAsDataURL(file[i]);
            
            reader[i].onload = function (a) {
                var basedata = a.target.result.substr(('data:image/jpeg;base64,').length,a.target.result.length);
                that.$http.post('/list/index.php',{
                    imgdata: basedata
                },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then((response) => {
                    console.log(response)
                    that.current ++;
                })

            }
        }


      }
  },
  mounted(){

  }
}
</script>