<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .onfile{
        display: inline-block;
        height: 75px;
        line-height: 75px;
        width: 100px;
        text-align: center;
        font-size: 50px;
        border: 1px solid #dcdfe6;
        border-radius: 3px;
        color: #dcdfe6;
        position: relative;
        overflow: hidden;
        vertical-align: middle;
    }
    .fileInput{
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
    .n_right{
        display: block;
        width: 150px;
        float: right;
        margin-right: 10px;
        margin-bottom: 10px;
    }
    .demo-input-suffix{
        margin-top: 10px;
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
    .explain{
        color: #bbb;
        font-size: 14px;
    }
    .textred{
        padding: 12px;
        color: #f56c6c;
    }
    .qrcode{
        height: 100px;
        line-height: 100px;
        width: 100px;
    }
</style>

<template>
  <div>
        <div class="demo-input-suffix">
            <span class="n_left">文章类型:</span><el-radio-group v-model="data.atype" >
                <el-radio-button :label="index" v-for="(item,index) in $attrs.types" :key="index">{{item.name}}</el-radio-button>
            </el-radio-group>
        </div>
        <div class="demo-input-suffix" v-if="$attrs.types[data.atype].titletype">
            <el-checkbox-group v-model="$attrs.types[data.atype].titletype.list" size="mini" :min="1">
                <span class="n_left"></span><el-checkbox v-for="(item,index) in $attrs.types[data.atype].titletype.name" :key='index' :label="''+index" border>{{item}}</el-checkbox>
                <span class="explain textred"> * 必填项</span>
            </el-checkbox-group>
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">标题:</span><el-input placeholder="请输入标题" prefix-icon="el-icon-edit-outline" v-model="data.title"></el-input><span class="explain textred"> * 必填项</span>
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">副标题:</span><el-input placeholder="请输入副标题" prefix-icon="el-icon-edit-outline" v-model="data.subtitle"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">封面:</span><span
            class="onfile" :class="($attrs.types[data.atype].cover?'qrcode ':'') + (data.cover?'':'el-icon-plus')" :style="data.cover?'background:url(' + data.cover + ') center center / contain no-repeat;':''">
                <input type="file" class="fileInput" @change="upimgs('cover')">
            </span>
            <span class="explain">（推荐比例 {{$attrs.types[data.atype].cover?'1:1':'4:3'}}）<span class="textred"> * 必填项</span></span>
        </div>
        <div class="demo-input-suffix">
            <span class="n_left">日期/时间:</span><el-date-picker
                v-model="data.time"
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
            <span class="n_left">时间补充:</span><el-input placeholder="请输入时间补充" prefix-icon="el-icon-edit-outline" v-model="data.timeRemarks"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">地址:</span><el-input placeholder="请输入地址" prefix-icon="el-icon-edit-outline" v-model="data.address"></el-input>
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
            <span class="n_left">费用补充:</span><el-input placeholder="请输入费用补充" prefix-icon="el-icon-edit-outline" v-model="data.priceRemarks"></el-input>
        </div>

        <div class="demo-input-suffix">
            <span class="n_left">购票二维码:</span><span
            class="onfile qrcode" :class="data.QRcode?'':'el-icon-plus'" :style="data.QRcode?'background:url(' + data.QRcode + ') center center / contain no-repeat;':''">
                <input type="file" class="fileInput" @change="upimgs('QRcode')">
            </span>
        </div>

        <div class="demo-input-suffix">
            <UE ue_style="width:auto;height:400px;margin-left:150px;" @textcontent="contentChange" :content="data.content"></UE>
        </div>

        <div class="demo-input-suffix">
            <el-button class="n_right" @click="release(0)" type="warning" round>{{$route.params.type == 'new'?'发布':'保存修改'}}</el-button>
            <el-button v-if="$route.params.type == 'new'" class="n_right" @click="release(1)" type="warning" round>存入草稿箱</el-button>
        </div>

        <div class="demo-input-suffix">
        </div>
  </div>
</template>

<script>
import UE from '@/components/ue.vue';
import { setInterval } from 'timers';

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
            atype:'0',
            titletype:[],
            title:'',
            subtitle:null,
            cover:null,
            time:null,
            timeRemarks:null,
            address:null,
            price:[
                {}
            ],
            priceRemarks:null,
            QRcode: null,
            content: null
        },
        oning: false, // false的情况下可以发布
        imgs:[]
    }
  },
  watch:{
    titletypelist(to){
        //this.data.titletype = to?to:[];
    },
    data: {
　　　　handler(newValue) {
            localStorage.releaseData = JSON.stringify(newValue);
　　　　},
　　　　deep: true
　　},
      show(value){
          if(value){
            this.update();
            switch(this.$route.params.type){
                case 'new':
                break;
                default:
                    this.$http.get('/list/getlist.php?id='+this.$route.params.type+'&list=*',{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
                        var data = response.data.list[0];
                        this.online = data.online;
                        this.data = {
                            atype: data.zltype,
                            titletype: data.titletype.split(','),
                            title: data.title,
                            subtitle: data.subtitle,
                            cover: data.cover,
                            time:data.timestart.length==10 && data.timeend.length == 10?[new Date(parseInt(data.timestart + '000')),new Date(parseInt(data.timeend + '000'))]:null,
                            timeRemarks: data.timeDescription,
                            address: data.place,
                            price: data.cost,
                            priceRemarks:data.costDescription,
                            QRcode: data.qrcode,
                            content: data.content
                        }
                        this.$attrs.types[this.data.atype].titletype.list = this.data.titletype;
                    }.bind(this))
                break;
            }
          }
      }
  },
  computed: {
    show() {
　　　　return this.$attrs.show
　　},
    titletypelist() {
        if(this.$attrs.types[this.data.atype].titletype){
　　　　    return this.$attrs.types[this.data.atype].titletype.list
        }
　　}
  },
  methods:{
      contentChange(res){
          this.data.content = res;
      },
      deletes(id){
          this.data.price.splice(id,1);
      },
      inserts(){
          this.data.price.push({})
      },
      update(){
        if(localStorage.releaseData){
            var data = JSON.parse(localStorage.releaseData);
            this.data = data;
        }else{
            this.data = {
                atype:'0',
                title:null,
                titletype:[],
                subtitle:null,
                cover:null,
                time:null,
                timeRemarks:null,
                address:null,
                price:[
                    {}
                ],
                priceRemarks:null,
                QRcode: null,
                content: null
            }
        }
      },
      upimgs:function(type){
        
        console.log(type);

        var file = event.currentTarget.files;
        var reader = [];
        var that = this;
        
        for(var i = 0;i<file.length;i++){
            reader[i] = new FileReader();
            reader[i].readAsDataURL(file[i]);
            
            reader[i].onload = function (a) {
                var basedata = a.target.result.substr(a.target.result.indexOf(',')+1,a.target.result.length);

                that.$http.post('/list/index.php',{
                    imgdata: basedata
                },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then((response) => {
                    that.data[type] = response.data.src;
                })

            }
        }


      },
      release(type){
        /**
         * 判断不能是空的数据
         */
        if(!this.data.title){
            this.$message({
                showClose: true,
                message: '标题不能为空！',
                type: 'error'
            });
            return false;
        }
        if(!this.data.cover){
            this.$message({
                showClose: true,
                message: '封面不能为空！',
                type: 'error'
            });
            return false;
        }
        if(!this.data.content){
            this.$message({
                showClose: true,
                message: '内容不能为空！',
                type: 'error'
            });
            return false;
        }

        var that = this;
        this.imgs = [];
        function guoli(str){
            var index = str.indexOf('http://ph34rw0qj.bkt.clouddn.com/');
            while(index != -1){
                var start = index + 'http://ph34rw0qj.bkt.clouddn.com/'.length;
                var t = str.indexOf('"',index);
                var end = t != -1?t - index - 'http://ph34rw0qj.bkt.clouddn.com/'.length:str.length;
                var p = str.substr(start,end);

                if(that.imgs.indexOf(p) == -1){
                    that.imgs.push(p);
                }
                index = str.indexOf('http://ph34rw0qj.bkt.clouddn.com/',index + 1);
            }
        }
        var data = JSON.parse(JSON.stringify(this.data));
        guoli(data.cover);
        if(data.QRcode)guoli(data.QRcode);
        guoli(data.content);
        // 以上统计所有图片和服务器上传的图片做对比以删除无用的图片
        
        //时间处理成10位的字符串
        if(data.time){
            for(var i=0;i<data.time.length;i++){
                var date = new Date(data.time[i]).getTime() + '';
                date = date.substr(0,10);
                data.time[i] = date;
            }
        }
        //分类处理
        data.titletype = data.titletype.join();

        data.imgs = this.imgs;
        data.type = type;
        
        if(this.oning){
            return false;
        };
        console.log(data);
        this.oning = true;
        this.$http.post('/list/release.php' + (this.$route.params.type!='new'?'?id=' + this.$route.params.type:''),data,{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then((response) => {
            if(response.data.code == 1){
                this.$message({
                    message: '发布成功，即将调转到文章列表页！',
                    type: 'success',
                    duration:1000,
                    onClose:function(){
                        localStorage.releaseData = '';
                        this.oning = false;
                        this.$router.push({params:{id: this.online?parseInt(this.online) + 2:2,type:0}})
                    }.bind(this)
                });
            }else{
                this.oning = false;
            }
            console.log(response.data.code)
        })
      }
  },
  mounted(){
      this.update();
  }
}
</script>