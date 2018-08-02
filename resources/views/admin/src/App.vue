  <template>
  <div id="app">
    <el-container style="height: 100%; border: 1px solid #eee">
      <el-aside style="width:15%">
        <el-menu style="height:100%;margin-top:60px;" :default-openeds="['1', '3']">
          <el-submenu index="1">
            <template slot="title"><i class="el-icon-tickets"></i>小说管理</template>
            <el-menu-item index="1-1">小说管理</el-menu-item>
            <el-menu-item v-on:click="novelCategory" index="1-2">类目设置</el-menu-item>
            
          </el-submenu>
          <el-submenu index="2">
            <template slot="title"><i class="el-icon-download"></i>爬文管理</template>
            <el-menu-item index="2-1">站点配置</el-menu-item>
          </el-submenu>
          <el-submenu index="3">
            <template slot="title"><i class="el-icon-document"></i>阅读统计</template>
            <el-menu-item index="3-1">会员管理</el-menu-item>
            <el-menu-item index="3-2">阅读统计</el-menu-item>
            <el-menu-item index="3-3">听文统计</el-menu-item>
          </el-submenu>
        </el-menu>
      </el-aside>
      
      <el-container style="width:85%">
        <el-header style="text-align: right; font-size: 12px">
          <el-dropdown>
            <i class="el-icon-setting" style="margin-right: 15px"></i>
            <el-dropdown-menu slot="dropdown">
              <el-dropdown-item>修改账户</el-dropdown-item>
              <el-dropdown-item>安全退出</el-dropdown-item>
            </el-dropdown-menu>
          </el-dropdown>
          <span>admin</span>
        </el-header>
        
        <el-main>
          <router-view/>
        </el-main>
        <el-footer>Footer</el-footer>
      </el-container>
    </el-container>
  </div>
</template>

<script>
export default {
  name: 'App',
  methods: {
    novelCategory: function(){
      this.$router.push({path:'/novel/category'});
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
