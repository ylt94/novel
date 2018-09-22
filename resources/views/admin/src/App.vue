  <template>
  <div id="app">
    <router-view>  
    </router-view>
  </div>
</template>

<script>
export default {
  name: 'App',
  data(){
    return {
      is_display: false
    } 
  },
  created(){
    this.loginCheck()
  },
  methods: {
    loginCheck: function(){
      if(localStorage.getItem('access_token')){
        this.is_display = true
      }
    },
    novelCategory: function(){
      this.$router.push({path:'/novel/category'});
    },
    loginout: function(){
      console.log(1111111)
      this.api.get('auth/logout',{}).then((ret)=>{
          console.log(ret)
      })
    }
  }
}
</script>

<style>
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  height: 100%;
  width: 100%;
}
.el-header {
    background-color:#409EFF;
    color: #333;
    line-height: 60px;
  }
  
  .el-aside {
    color: #333;
    box-sizing: border-box !important;
    background-color:white;
    border-right: 1px solid #e6e6e6;
  }
  .el-menu{
    border:none !important;
    width:100%;
    height: 100%;
  }

  .el-footer{
    background-color: #409EFF;
    text-align: center;
    line-height: 60px;
  }

  .el-submenu .el-menu-item{
    height: 35px;
    line-height: 35px;
  }
</style>
