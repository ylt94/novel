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
    
    
        <el-table :data="sites" style="width:100%;height:100%">
            <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
            <el-table-column align="center" prop="name" label="名称" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="base_url" label="基础地址" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="detail_url" label="章节地址" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="content_url" label="内容地址" style="width:10%"></el-table-column>
            <el-table-column align="center" prop="created_at" label="创建时间" style="width:25%"> </el-table-column>
            <el-table-column align="center" label="操作" style="width:30%"> 
                <template slot-scope="scope">
                    <el-button @click.native.prevent="onDelClicked(scope.row)" type="text" size="small">删除</el-button>
                    <el-button @click.native.prevent="updateRow(scope.row)" type="text" size="small">修改</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="新增/修改爬虫站点" :visible.sync="dialog" @open="getsites" @close="onDialogClose">
            <el-form :model="form">
                <el-form-item label="站点名称" style="width:100%">
                    <el-input v-model="form.name" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="基础地址" style="width:100%">
                    <el-input v-model="form.base_url" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="章节地址" style="width:100%">
                    <el-input v-model="form.detail_url" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="内容地址" style="width:100%">
                    <el-input v-model="form.content_url" auto-complete="off" style="max-width:200px"></el-input>
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
        sites:[],
        searchCate:[],
        dialog:false,
        delData:{},
        lastId:null,
        novelType:[
            {
                value:1,
                label:'男生'
            },
            {
                value:2,
                label:'女生'
            }
        ],
        form:{
            id:'',
            name:'',
            base_url:'',
            detail_url:'',
            content_url:''
        },
        }
    },
    created(){
        this.getsites();
    },
    methods:{
        onDialogClose(){
            this.form={
                id:'',
                name:'',
                type_id:1,
                pid:0
            }
        },
        getsites(){
            var params = {}
            console.log(params)
            this.api.get('api/admin/site/sites',params).then((ret)=>{
                if(this.dialog) {
                    this.searchCate = ret.data
                }else{
                    this.sites = ret.data;
                }
                
            })
        },
        addOrUpdatePost(){
            if(!this.form.name) {
                this.$message({
                    type: 'warning',
                    message: '请填写完整!'
                })
                return 
            }
            if(this.form.id){
                this.api.post('api/admin/site/sites-update',this.form).then((ret)=>{
                    this.api.retrunMsg(ret)
                    if(ret.status) {
                        this.dialog = false
                        this.getsites()
                    } 
                })
            }else{
                this.api.post('api/admin/site/sites-add',this.form).then((ret)=>{
                    this.api.retrunMsg(ret)
                    if(ret.status) {
                        this.dialog = false
                        this.getsites()
                    } 
                })
            }
            
        },
        updateRow(row){
            this.form = {
                id:row.id,
                name: row.name,
                base_url:row.base_url,
                detail_url:row.detail_url,
                content_url:row.content_url
            }
            this.dialog =true;
        },
        onDelClicked(row){
            this.delData = row
            this.$confirm('此操作将永久删除该条数据, 是否继续?', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消',
                type: 'warning'
            }).then(() => {
                this.delItem()
            }).catch(() => {
                this.delData = {}
            })
        },
        delItem(){
           this.api.post('api/admin/site/sites-del',this.delData).then((ret)=>{
                this.api.retrunMsg(ret)
                this.getsites()
           })
        }
        
    }
}
</script>

<style>
    .container{
        height: 100%;
        width:100%;
        background-image:url('../assets/timg.jpg');
        background-size:cover;
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
