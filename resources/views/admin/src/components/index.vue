<template>
  <el-container style="height: 100%; border: 1px solid #eee">
    <el-aside style="width:15%;">
      <div style="width:100%;height:60px;background-color:#409eff"></div>
      <el-menu style="height:93%" :default-active="$route.path" class="el-menu-vertical-demo" @open="handleopen" @close="handleclose" @select="handleselect"
          unique-opened router>
        <template v-for="(item,index) in $router.options.routes" v-if="!item.hidden">
          <el-submenu :index="index+''" v-if="!item.leaf">
            <template slot="title"><i :class="item.icon"></i>{{item.name}}</template>
            <el-menu-item v-for="child in item.children" :index="child.path" :key="child.path" v-if="!child.hidden">{{child.name}}</el-menu-item>
          </el-submenu>
          <!-- <el-menu-item v-if="item.leaf&&item.children.length>0" :index="item.children[0].path"><i :class="item.icon"></i>{{item.children[0].name}}</el-menu-item> -->
        </template>
      </el-menu>
    </el-aside>
    
    <el-container style="width:85%">
      <el-header style="text-align: right; font-size: 12px">
        <span>admin</span>
        <el-button @click="loginout" type="text" style="color:#333" size="small">安全退出</el-button>
      </el-header>
      <el-main>
        <router-view>
      
        </router-view>
      </el-main>
      <el-footer>@cfces</el-footer>
    </el-container>
  </el-container>
</template>

<script>
export default {
  data() {
    return {
      
    }
  },
  methods: {
    loginCheck: function(){
      if(localStorage.getItem('access_token')){
        this.is_display = true
      }
    },
    novelCategory: function(){
      this.$router.push({path:'/admin/novel/category'})
    },
    loginout: function(){
      localStorage.removeItem('access_token')
      this.$router.push({path:'/login'});
      
    },
    onSubmit() {
				console.log('submit!');
			},
    handleopen() {
      console.log('handleopen');
    },
    handleclose() {
      console.log('handleclose');
    },
    handleselect: function (a, b) {
    },
    //折叠导航栏
    collapse:function(){
      this.collapsed=!this.collapsed;
    },
    showMenu(i,status){
      this.$refs.menuCollapsed.getElementsByClassName('submenu-hook-'+i)[0].style.display=status?'block':'none';
    },
		mounted() {
			var user = sessionStorage.getItem('user');
			if (user) {
				user = JSON.parse(user);
				this.sysUserName = user.name || '';
				this.sysUserAvatar = user.avatar || '';
			}

		}
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
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
