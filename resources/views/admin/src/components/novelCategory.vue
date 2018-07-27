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
                    <el-button type="primary">搜索</el-button>
                    <el-button type="primary" @click="dialog=true">新增</el-button>
                </div>
            </el-col>
        </el-row>
    
    
        <el-table :data="categories" style="width:100%;height:100%">
            <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
            <el-table-column align="center" prop="name" label="名称" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="name" label="类型" style="width:10%">
                <template slot-scope="scope">
                   <span>{{scope.row.type_id==1?'男生':'女生'}}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="name" label="父级" style="width:10%">
                <template slot-scope="scope">
                    <span v-if="scope.row.pid==0">无</span>
                    <span v-else v-for="item in categories" v-if="item.id==scope.row.pid">{{item.name}}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="created_at" label="创建时间" style="width:25%"> </el-table-column>
            <el-table-column align="center" label="操作" style="width:30%"> 
                <template slot-scope="scope">
                    <el-button @click.native.prevent="onDelClicked(scope.row)" type="text" size="small">删除</el-button>
                    <el-button @click.native.prevent="updateRow(scope.row)" type="text" size="small">修改</el-button>
                    <el-button @click.native.prevent="sortItem(scope.row)" type="text" size="small">排序</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog title="新增小说类型" :visible.sync="dialog" @open="getCategories" @close="onDialogClose">
            <el-form :model="form">
                <el-form-item label="类型" style="width:100%">
                   <el-select v-model="form.type_id" @change="getCategories" placeholder="请选择" style="max-width:200px">
                        <el-option
                        v-for="item in novelType"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="父级" style="width:100%">
                    <el-select v-model="form.pid" placeholder="请选择" style="max-width:200px">
                        <el-option
                        :key="0"
                        :label="'无'"
                        :value="0">
                        </el-option>
                        <el-option
                        v-for="item in searchCate"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="名称" style="width:100%">
                    <el-input v-model="form.name" auto-complete="off" style="max-width:200px"></el-input>
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
        categories:[],
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
            type_id:1,
            pid:0
        },
        }
    },
    created(){
        this.getCategories();
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
        getCategories(){
            var params = {}
            if(this.dialog){
                params = {
                    type_id:this.form.type_id
                }
            }
            console.log(params)
            this.api.get('api/admin/novel/categories',params).then((ret)=>{
                if(this.dialog) {
                    this.searchCate = ret.data
                }else{
                    this.categories = ret.data;
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

            this.api.post('api/admin/novel/categories-addorupdate',this.form).then((ret)=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getCategories()
                }
                
            })
        },
        updateRow(row){
            this.form = {
                id:row.id,
                pid:row.pid,
                type_id:row.type_id,
                name:row.name
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
           this.api.post('api/admin/novel/categories-del',this.delData).then((ret)=>{
                this.api.retrunMsg(ret)
                this.getCategories()
           })
        },
        sortItem(item){
            this.lastId = item.id
            this.$prompt('请输入此条数据要插入的位置的编号(XX之后)', '提示', {
                confirmButtonText: '确定',
                cancelButtonText: '取消'
            }).then(({ value }) => {
                this.sortPost(value)
            }).catch(() => {
              
            });
        },
        sortPost(font_id){
            var params = {
                last_id:this.lastId,
                font_id:font_id
            }
            this.api.post('api/admin/novel/categories-sort',params).then(ret=>{
                this.api.retrunMsg(ret)
                this.getCategories()
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
