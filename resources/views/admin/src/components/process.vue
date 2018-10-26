<template>
    <div style="height:100%;width:100%">
        <el-row :gutter="20" style="width:100%">
            <el-col :span="6">
                <div class="grid-content bg-purple">

                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">

                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">

                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">
                    <!-- <el-button type="primary">搜索</el-button> -->
                    <el-button type="primary" @click="dialog=true">新增</el-button>
                </div>
            </el-col>
        </el-row>
    
    
        <el-table :data="process" v-loading="loading" style="width:100%;height:100%">
            <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
            <el-table-column align="center" prop="type" label="进程类型" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="sleep_time" label="更新间隔" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="update_time" label="更新范围" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="pid" label="进程pid" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="exec_command" label="进程命令" style="width:25%"> </el-table-column>
            <el-table-column align="center" prop="created_at" label="创建时间" style="width:25%"> </el-table-column>  
            <el-table-column align="center" label="操作" style="width:30%"> 
                <template slot-scope="scope">
                    <el-button @click.native.prevent="del(scope.row)" type="text" size="small">删除</el-button>
                    <el-button @click.native.prevent="updateRow(scope.row)" type="text" size="small">修改</el-button>
                    <el-button v-if ="scope.row.pid==0" @click.native.prevent="startProcess(scope.row)" type="text" size="small">启动</el-button>
                    <el-button v-else @click.native.prevent="stopProcess(scope.row)" type="text" size="small">停止</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="新增/修改进程" :visible.sync="dialog" @close="onDialogClose">
            <el-form :model="form">
                <el-form-item label="进程描述" style="width:100%">
                    <el-input v-model="form.description" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="进程类型" style="width:100%">
                    <el-input v-model="form.type" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="更新范围" style="width:100%">
                    <el-input v-model="form.update_time" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="更新间隔" style="width:100%">
                    <el-input v-model="form.sleep_time" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="进程编号" style="width:100%">
                    <el-input v-model="form.pid" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="进程命令" style="width:100%">
                    <el-input v-model="form.exec_command" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialog = false">取 消</el-button>
                <el-button type="primary" @click="addOrUpdatePost">确 定</el-button>
            </div>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            process:[],
            dialog:false,
            loading:false,
            form:{},
        }
    },
    created(){
        this.getProcess();
    },
    methods:{
        onDialogClose(){
            this.form = {}
        },
        getProcess(){
            var params = {}
            this.loading = true
            this.api.get('api/admin/process/processes',params).then((ret)=>{
                this.process = ret.data;
                this.loading = false
            })
        },
        updateRow(item){
            this.form = item
            console.log(this.form)
            this.dialog = true
        },
        addOrUpdatePost(){
            this.loading = true
            var url = 'api/admin/process/process-update'
            if(this.form.id == undefined){//add
                url = 'api/admin/process/process-add'  
            }
            this.api.post(url,this.form).then((ret)=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getProcess()
                } 
            })
            this.loading = false
        },
        del(item){
            if(item.pid){
                this.$message({
                    type: 'warning',
                    message: '请先停止进程!'
                })
                return 
            }
            params = {
                id:item.id
            }
            this.loading = true
            this.api.get('api/admin/process/process-del',params).then(ret=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getProcess()
                } 
            })
        },
        startProcess(item){
            var params = {
                id:item.id
            }
            this.loading = true
            this.api.get('api/admin/process/process-start',params).then(ret=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getProcess()
                } 
            })
        },
        stopProcess(item){
            var params = {
                id:item.id
            }
            this.loading = true
            this.api.get('api/admin/process/process-stop',params).then(ret=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getProcess()
                } 
            })
        }
        
    }
}
</script>

<style>
    .container{
        height: 100%;
        width:100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .main{
        background-color: white;
        box-sizing: border-box;
        border:1px solid grey;
        border-radius: 5px;
        height: 600px;
        width:400px;
        margin-left:300px;
        opacity: 0.8;
        display: flex;
        flex-direction: column;
        position: absolute;
    }

    .main-input{
        position: relative;
        left:300px;
        top:50px;
        width: 350px;
        height: 300px;
    }

    .password{
        margin-top:50px;
    }

    .btn{
        margin-top: 130px;
    }
    .el-row {
    margin-bottom: 20px;
  }
  .el-row:last-child{
      margin-bottom: 0;
  }
  .el-col {
    border-radius: 4px;
  }
  .bg-purple-dark {
    background: white;
  }
  .bg-purple {
    background: white;
  }
  .bg-purple-light {
    background: #e5e9f2;
  }
  .grid-content {
    border-radius: 4px;
    min-height: 36px;
  }
  .row-bg {
    padding: 10px 0;
    background-color: #f9fafc;
  }

</style>
