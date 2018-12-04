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
        overflow: hidden;
        display: inline-block;
        width: 50%;
        cursor: pointer;
    }
    .item-view:hover .cover{
        transform: scale3d(1.02,1.02,1);
    }
    .cover{
        transform: scale3d(1,1,1);
        transition: transform .5s;
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
      <ul class="nav" v-if="this.$route.params.type == 'now' || this.$route.params.type == 'soon' || this.$route.params.type == 'past'">
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
      <ul class="nav">
          <li v-for="(item,index) in navlist" :key="index">
              <router-link class="navsub" :style="navshow==index?'color:#000':''" :to='{name:"exhibition",params:{type:"{\"page\":\"" + navpage + "\",\"type\":\""+index+"\"}"}}'>{{item}}</router-link>
          </li>
      </ul>
      <div class="item-box">
        <div class="item-view" v-for="(item,index) in data" :key="index" @click="topage(item.id)">
            <div style="overflow:hidden;padding: 5px;">
                <img class="cover" :src="item.cover">
                <span class="item-title">
                    {{item.title}} {{item.subtitle?'——':''}} {{item.subtitle}}
                </span>
            </div>
        </div>
      </div>

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
        pageidnex:0,
        pagemax:0,
        project:{name:'公共项目',titletype:{name:['公共艺术','公共活动','大千学'],list:['0']}},
        record:{name:'记录',titletype:{name:['学术研究','视频'],list:['0']}},
        pw:{name:'公益',titletype:{name:['幸福工程','未来项目'],list:['0']}},
        navlist:null,
        navpage:null,
        navshow:[],
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
                case 'now':
                    this.navlist = null;
                    this.$http.get('list/getlist.php?time=now&type=0&online=0&pageindex=' + this.pageidnex).then(function(res){
                        this.data = res.data.list;
                        this.pagemax = res.data.count;
                        console.log(res);
                    }.bind(this));
                    this.nav.now = "#000";
                break;
                case "soon":
                    this.navlist = null;
                    this.$http.get('list/getlist.php?time=soon&type=0&online=0').then(function(res){
                        this.data = res.data.list;
                        this.pagemax = res.data.count;
                        console.log(res);
                    }.bind(this));
                    this.nav.soon = "#000"
                break;
                case "past":
                    this.navlist = null;
                    this.$http.get('list/getlist.php?time=past&type=0&online=0').then(function(res){
                        this.data = res.data.list;
                        this.pagemax = res.data.count;
                        console.log(res);
                    }.bind(this));
                    this.nav.past = "#000"
                break;
                default:
                    this.navlist = [];
                    if(this.$route.params.type.indexOf('{') != -1){
                        this.$route.params.type = JSON.parse(this.$route.params.type);
                    }
                    this.navpage = '' + (this.$route.params.type.page || this.$route.params.type);
                    var type = '' + (this.$route.params.type.type || '0');
                    if(this[this.navpage])this.navlist = this[this.navpage].titletype.name;
                    switch(this.navpage){
                        case 'project':
                            this.$http.get('list/getlist.php?subtype='+type+'&type=2&online=0').then(function(res){
                                this.data = res.data.list;
                                this.pagemax = res.data.count;
                                console.log(res);
                            }.bind(this));
                            this.navshow = type;
                            console.log(this.navshow);
                        break;
                        case 'record':
                            this.$http.get('list/getlist.php?subtype='+type+'&type=5&online=0').then(function(res){
                                this.data = res.data.list;
                                this.pagemax = res.data.count;
                                console.log(res);
                            }.bind(this));
                            this.navshow = type;
                        break;
                        case 'pw':
                            this.$http.get('list/getlist.php?subtype='+type+'&type=1&online=0').then(function(res){
                                this.data = res.data.list;
                                this.pagemax = res.data.count;
                                console.log(res);
                            }.bind(this));
                            this.navshow = type;
                        break;
                    }
                break;
            }

            
        }
    }
  },
  methods:{
    pagechange(e){
        this.pageidnex = e - 1;
        this.update();
        console.log(this.pageidnex);
    }
  },
  created(){
      this.update();
  },
  watch: {
    "$route"(to,from){
        this.pageidnex = 0;
        this.update();
    }
  }
}
</script>