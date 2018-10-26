<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .po{
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        background: rgba(0, 0, 0, 0.2);
        z-index: 9999;
    }
    .window{
        position: fixed;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        margin: auto;
        width: 800px;
        height: 500px;
        background: #fff;
        border: 1px solid #eee;
        border-radius: 5px;
        z-index: 9999;
        padding: 5px;
    }
    .upload{
        position: absolute;
        right: 5px;
        bottom: 10px;
        overflow: hidden;
    }
    #fileInput{
        position: absolute;
        left: 0;
        right: 0;
        bottom: 0;
        top: 0;
        opacity: 0;
    }
    .windiv{
        position: absolute;
        left: 10px;
        right: 10px;
        bottom: 60px;
        top: 10px;
        border: 1px solid #eee;
        overflow: auto;
    }
    .itfo{
        background: #eee;
    }
    .itas{
        background: #e0fed3;
    }
    .items{
        color: #777;
        font-size: 14px;
        padding: 20px;
    }
    .items+.items{
        border-top: 1px solid #eee;
    }
</style>

<template>
    <div>
        <div class="po" @click="hide" v-if="show">
            <div class="window" @click.stop="a">
                <div class="windiv">
                    <div v-for="(item,index) in downlist" :key="index" class="items" :class="item.up==true?'itas':'itfo'">{{item.name}}</div>
                </div>
                <el-button type="primary" class="upload">上传<i class="el-icon-upload el-icon--right"></i>
                    <input type="file" id="fileInput" @change="upimgs" multiple>
                </el-button>
            </div>
        </div>
        <script id="ueid" type="text/plain" :style="$attrs.ue_style"></script>
    </div>
</template>

<script>


export default {
  name: 'ue',
  data () {
    return {
        show:false,
        downlist:[],
        filelist:[]
    }
  },
  methods:{
    a(){

    },
    upimgs:function(){

        function hebingarray(array1,array2){
            console.log(array2.length);
            for(var i=0;i<array2.length;i++){
                array1.push(array2[i]);
            }
            return array1;
        }

        var file = event.currentTarget.files;
        var reader = [];
        var that = this,imglist = [];
        that.Maximum = file.length;
        var startnb = this.filelist.length;
        that.current = startnb;

        this.filelist = hebingarray(this.filelist,file);

        for(var i = startnb;i<this.filelist.length;i++){
            reader[i] = new FileReader();
            reader[i].readAsDataURL(this.filelist[i]);

            that.downlist.push({name:this.filelist[i].name,up:false})

            reader[i].onload = function (a) {
                
                var basedata = a.target.result.substr(('data:image/jpeg;base64,').length,a.target.result.length);
                that.$http.post('/list/index.php',{
                    imgdata: basedata
                },{'Content-Type':'application/x-www-form-urlencoded; charset=UTF-8'}).then(function(response){
                    console.log(response);
                    //插入图片
                    imglist.push(response.data)
                    //设置下载后的底色为绿色
                    that.downlist[this].up = true;
                    //进度
                    that.current ++;
                    //全部下载完成后自动插入到光标位置
                    if(that.current == that.filelist.length)insertImg(imglist);
                }.bind(this))

            }.bind(i)
        }

        function insertImg(array){
            for(var i=0;i<array.length;i++){
                that.editor.execCommand('inserthtml', '<img src="'+ array[i].src +'"/>');
            }
        }
    },
    hide(){
        this.show = false;
    },
    getUEContent() { // 获取内容方法
        return this.editor.getContent()
    }
  },
  destroyed() {
    this.editor.destroy();
  },
  created(){
        console.log(this);
        const _this = this;

        UE.registerUI('upimg', function(editor, uiName) {
            //注册按钮执行时的command命令，使用命令默认就会带有回退操作
            editor.registerCommand(uiName, {
                execCommand: function() {
                    alert('execCommand:' + uiName)
                }
            });
            //创建一个button
            var btn = new UE.ui.Button({
                //按钮的名字
                name: uiName,
                //提示
                title: "上传图片",
                //添加额外样式，指定icon图标，这里默认使用一个重复的icon
                cssRules: 'background-position: -380px 0;',
                //点击时执行的命令
                onclick: function() {
                    _this.show = true;
                    //这里可以不用执行命令,做你自己的操作也可
                    //editor.execCommand(uiName);
                }
            });
            //当点到编辑内容上时，按钮要做的状态反射
            editor.addListener('selectionchange', function() {
                var state = editor.queryCommandState(uiName);
                if (state == -1) {
                    btn.setDisabled(true);
                    btn.setChecked(false);
                } else {
                    btn.setDisabled(false);
                    btn.setChecked(state);
                }

            });
            //因为你是添加button,所以需要返回这个button
            return btn;
        });

        this.editor = UE.getEditor("ueid", this.config); // 初始化UE
        this.editor.addListener("ready", function () {
            _this.editor.setContent(_this.defaultMsg); // 确保UE加载完成后，放入内容。
        });
  }
}
</script>