<template>
    <div style="height:100%;width:100%">
        <el-row :gutter="20" style="width:100%">
            <el-col :span="6">
                <div class="grid-content bg-purple">
                    <div class="grid-content bg-purple">
                        <el-date-picker
                        v-model="mermber_search.start_time"
                        type="datetime"
                        placeholder="选择起始时间"
                        align="right"
                        value-format="yyyy-MM-dd HH:mm:ss"
                        :picker-options="pickerOptions">
                        </el-date-picker>
                    </div>
                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">
                    <el-col :span="9">
                        <div class="grid-content bg-purple">
                            <el-date-picker
                            v-model="mermber_search.end_time"
                            type="datetime"
                            value-format="yyyy-MM-dd HH:mm:ss"
                            placeholder="选择截至时间"
                            align="right"
                            :picker-options="pickerOptions">
                            </el-date-picker>
                        </div>
                    </el-col>
                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">

                </div>
            </el-col>
            <el-col :span="6">
                <div class="grid-content bg-purple">
                    <el-button @click="getMembers()" type="primary">搜索</el-button>
                    <!-- <el-button type="primary" @click="dialog=true">新增</el-button> -->
                </div>
            </el-col>
        </el-row>
    
    
        <el-table :data="members" v-loading="loading" style="width:100%;height:100%">
            <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
            <el-table-column align="center" prop="name" label="名称" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="is_disabled" label="状态" style="width:10%">
                <template slot-scope="scope">
                    <span v-if="scope.row.is_disabled == 0">正常</span>
                    <span v-else>禁用</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="updated_at" label="上次登录时间" style="width:25%"> </el-table-column>
            <el-table-column align="center" prop="created_at" label="注册时间" style="width:25%"> </el-table-column>
            <el-table-column align="center" label="操作" style="width:30%"> 
                <template slot-scope="scope">
                    <el-button v-if="scope.row.is_disabled == 0" @click.native.prevent="disabled(scope.row.id,1)" type="text" size="small">禁用</el-button>
                    <el-button v-else @click.native.prevent="disabled(scope.row.id,0)" type="text" size="small">正常</el-button>
                </template>
            </el-table-column>
        </el-table>
        <!-- <el-dialog title="新增/修改爬虫站点" :visible.sync="dialog" @open="getsites" @close="onDialogClose">
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
        </el-dialog> -->
    </div>
</template>

<script>
export default {
    data() {
        return {
            mermber_search:{
                start_time: null,
                end_time: null
            },
            pickerOptions: {
                shortcuts: [{
                    text: '今天',
                    onClick(picker) {
                    picker.$emit('pick', new Date());
                    }
                }, {
                    text: '昨天',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24);
                    picker.$emit('pick', date);
                    }
                }, {
                    text: '一周前',
                    onClick(picker) {
                    const date = new Date();
                    date.setTime(date.getTime() - 3600 * 1000 * 24 * 7);
                    picker.$emit('pick', date);
                    }
                }]
            },
            members:[],
            loading:false
        }
    },
    created(){
        this.getMembers();
    },
    methods:{
        getMembers(){
            this.loading = true
            this.api.get('api/admin/member/members',this.mermber_search).then((ret)=>{
                this.members = ret.data;
                this.loading = false
            })
        },
        disabled(id,status){
            var params = {
                id:id,
                is_disabled:status
            }
            this.api.get('api/admin/member/disabled',params).then((ret)=>{
                this.api.retrunMsg(ret)
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
