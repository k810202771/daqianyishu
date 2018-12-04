<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
    .userbj{
        font-size: 14px;
        margin: 16px auto;
    }
    .userbox{
        box-shadow: 0 0 10px #ddd;
        border-radius: 10px;
        padding: 10px 40px 50px;
        width: 300px;
        margin: 200px auto;
    }
    .login{
        width: 100%;
    }
</style>

<template>
  <div class="box">
        <div class="userbox">
            <div class="userbj">账号：</div>
            <el-input v-model="user" placeholder="请输入账号"></el-input>
            <div class="userbj">密码：</div>
            <el-input v-model="password" type="password" placeholder="请输入密码"></el-input>
            <div class="userbj"></div>
            <el-button type="warning" class="login" @click="login">登陆</el-button>
        </div>
  </div>
</template>

<script>

export default {
  name: '',
  data () {
    return {
        user:'',
        password:''
    }
  },
  created(){
      var loginsign = cookie.get('loginsign');
      if(loginsign){
        this.$http.post('list/login.php',{loginsign:loginsign}).then(function(res){
            switch(res.data.code){
                case 0:
                    cookie.delete('loginsign');
                break;
                case 1:
                    this.$router.push({name:'admin',params:{id:2,type:0}})
                break;
            };
        })
      }
  },
  methods:{
      login(){
          this.$http.post('list/login.php',{user:this.user,password:this.password}).then(function(res){
            switch(res.data.code){
                case 0:
                    this.$message.error(res.data.msg);
                break;
                case 1:
                    this.$message({
                        message: res.data.msg,
                        type: 'success'
                    });
                    cookie.set('loginsign',res.data.loginsign);
                    this.$router.push({name:'admin',params:{id:2,type:0}})
                break;
            };
          })
      }
  }
}
</script>