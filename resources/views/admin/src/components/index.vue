<template>
  <el-container style="height: 100%; border: 1px solid #eee">
    <el-aside width="201px">
      <el-menu style="height:100%;margin-top:60px;" :default-openeds="['1', '3']">
        <el-submenu index="1" style="height:100%;">
          <template slot="title"><i class="el-icon-document"></i>小说管理</template>
          <el-menu-item index="1-1">玄幻</el-menu-item>
          <el-menu-item index="1-2">仙侠</el-menu-item>
          <el-menu-item index="1-3">都市</el-menu-item>
          <el-menu-item index="1-4">武侠</el-menu-item>
          <el-menu-item index="1-5">奇幻</el-menu-item>
          <el-menu-item index="1-6">军事</el-menu-item>
        </el-submenu>
        <el-submenu index="2">
          <template slot="title"><i class="el-icon-download"></i>爬文管理</template>
          <el-menu-item index="2-1">站点管理</el-menu-item>
        </el-submenu>
        <el-submenu index="3">
          <template slot="title"><i class="el-icon-setting"></i>导航三</template>
          <el-menu-item-group>
            <template slot="title">分组一</template>
            <el-menu-item index="3-1">选项1</el-menu-item>
            <el-menu-item index="3-2">选项2</el-menu-item>
          </el-menu-item-group>
          <el-menu-item-group title="分组2">
            <el-menu-item index="3-3">选项3</el-menu-item>
          </el-menu-item-group>
          <el-submenu index="3-4">
            <template slot="title">选项4</template>
            <el-menu-item index="3-4-1">选项4-1</el-menu-item>
          </el-submenu>
        </el-submenu>
      </el-menu>
    </el-aside>
    
    <el-container>
      <el-header style="text-align: right; font-size: 12px">
        <el-dropdown>
          <i class="el-icon-setting" style="margin-right: 15px"></i>
          <el-dropdown-menu slot="dropdown">
            <el-dropdown-item>修改账户</el-dropdown-item>
            <el-dropdown-item>安全退出</el-dropdown-item>
            <!-- <el-dropdown-item>删除</el-dropdown-item> -->
          </el-dropdown-menu>
        </el-dropdown>
        <span>admin</span>
      </el-header>
      
      <el-main>
        <el-table :data="tableData">
          <el-table-column prop="date" label="日期" width="140">
          </el-table-column>
          <el-table-column prop="name" label="姓名" width="120">
          </el-table-column>
          <el-table-column prop="address" label="地址">
          </el-table-column>
        </el-table>
      </el-main>
      <el-footer>Footer</el-footer>
    </el-container>
  </el-container>
</template>

<script>
export default {
  data() {
    const item = {
      date: '2016-05-02',
      name: '王小虎',
      address: '上海市普陀区金沙江路 1518 弄'
    };
    return {
      tableData: Array(20).fill(item)
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
