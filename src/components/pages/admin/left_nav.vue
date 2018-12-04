<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .nav{
        margin: 0;
        padding: 0;
        list-style-type: none;
    }
    .el-menu{
        border-right: 0;
    }
    .el-submenu .el-menu-item{
        min-width: 0;
    }
</style>

<template>
  <div>

    <el-menu :default-active="active" class="el-menu-vertical-demo">

      <el-menu-item v-for="(items,index) in $attrs.value" :key="index" :index="items.id" @click="pageOpen">
        <i :class="items.icon"></i>
        <span slot="title">{{items.text}}</span>
      </el-menu-item>

    </el-menu>

  </div>
</template>

<script>

export default {
  name: 'admin',
  data () {
    return {
        active: '1'
    }
  },
  watch:{
      $route(){
        this.active = '' + this.$route.params.id;
      }
  },
  mounted(){
      this.active = '' + this.$route.params.id;
  },
  methods:{
      pageOpen(e){
          this.$router.push({params:{id:e.index,type:this.$attrs.value[e.index - 1].value}})
      }
  }
}
</script>