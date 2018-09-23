<template>
    <div style="height:100%;width:100%">
        <el-row :gutter="20" style="width:100%">
            <el-col :span="5">
                <div class="grid-content bg-purple">
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <div class="grid-content bg-purple">
                                <el-input v-model="search.title" placeholder="小说名称"></el-input>
                            </div>
                        </el-col>
                        <el-col :span="12">
                            <div class="grid-content bg-purple">
                                <el-input v-model="search.author" placeholder="作者名称"></el-input>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
            <el-col :span="5">
                <div class="grid-content bg-purple">
                    <el-row :gutter="20">
                        <el-col :span="12">
                            <div class="grid-content bg-purple">
                                <el-select v-model="search.status" placeholder="小说状态">
                                    <el-option :key="1" :label="'连载'" :value="1"></el-option>
                                    <el-option :key="2" :label="'完本'" :value="2"></el-option>
                                </el-select>
                            </div>
                        </el-col>
                        <el-col :span="12">
                            <div class="grid-content bg-purple">
                                <el-select v-model="search.type" placeholder="小说类型">
                                    <el-option v-for="item in categories" :key="item.id" :label="item.name" :value="item.id"></el-option>
                                </el-select>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
            <el-col :span="8">
                <div class="grid-content bg-purple">
                    <el-row :gutter="20">
                        <el-col :span="8">
                            <div class="grid-content bg-purple">
                                <el-select v-model="search.resource" placeholder="来源网站">
                                    <el-option v-for="item in sites" :key="item.id" :label="item.name" :value="item.id"></el-option>
                                </el-select>
                            </div>
                        </el-col>
                        <el-col :span="8">
                            <div class="grid-content bg-purple">
                                <el-select v-model="search.order_by_clumn" placeholder="排序字段">
                                    <el-option :key="1" :label="'编号'" :value="'id'"></el-option>
                                    <el-option :key="2" :label="'类型'" :value="'type'"></el-option>
                                    <el-option :key="3" :label="'来源'" :value="'site_source'"></el-option>
                                    <el-option :key="4" :label="'字数'" :value="'words'"></el-option>
                                    <el-option :key="5" :label="'章节数'" :value="'total_chapters'"></el-option>
                                    <el-option :key="6" :label="'状态'" :value="'status'"></el-option>
                                    <el-option :key="7" :label="'点击量'" :value="'click_num'"></el-option>
                                    <el-option :key="8" :label="'推荐量'" :value="'recommend_num'"></el-option>
                                    <el-option :key="9" :label="'收藏量'" :value="'collection_num'"></el-option>
                                    <el-option :key="10" :label="'推荐首页'" :value="'is_recommend'"></el-option>
                                    <el-option :key="11" :label="'最后更新'" :value="'last_update'"></el-option>
                                    <el-option :key="12" :label="'是否隐藏'" :value="'is_hide'"></el-option>
                                    <el-option :key="13" :label="'创建时间'" :value="'created_at'"></el-option>
                                </el-select>
                            </div>
                        </el-col>
                        <el-col :span="8">
                            <div class="grid-content bg-purple">
                                <el-select v-model="search.order_by_order" placeholder="排序字段">
                                    <el-option :key="1" :label="'正序'" :value="'asc'"></el-option>
                                    <el-option :key="2" :label="'逆序'" :value="'desc'"></el-option>
                                </el-select>
                            </div>
                        </el-col>
                    </el-row>
                </div>
            </el-col>
            <el-col :span="3">
                <div class="grid-content bg-purple">
                    <el-button @click="getNovels" type="primary">搜索</el-button>
                </div>
            </el-col>
        </el-row>
    
    
        <el-table :data="novels.data" highlight-current-row style="width:100%;height:100%">
            <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
            <el-table-column align="center" prop="title" label="名称" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="author" label="作者" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="type" label="类型" style="width:10%">
                <template slot-scope="scope">
                    <span v-for="item in categories" v-if="item.id==scope.row.type">{{item.name}}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="site_source" label="来源" style="width:15%">
                <template slot-scope="scope">
                    <span v-for="item in sites" v-if="item.id==scope.row.site_source">{{item.name}}</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="total_chapters" label="章节数" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="words" label="字数" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="status" label="状态" style="width:15%">
                <template slot-scope="scope">
                    <span v-if="scope.row.status==1">连载</span>
                    <span v-else>完本</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="click_num" label="点击量" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="collection_num" label="收藏量" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="recommend_num" label="推荐量" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="is_recommend" label="推荐" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="last_update" label="最后更新" style="width:15%"></el-table-column>
            <el-table-column align="center" prop="is_hide" label="隐藏" style="width:15%">
                <template slot-scope="scope">
                    <span v-if="scope.row.is_hide==1">是</span>
                    <span v-else>否</span>
                </template>
            </el-table-column>
            <el-table-column align="center" prop="created_at" label="创建时间" style="width:25%"> </el-table-column>
            <el-table-column align="center" label="操作" style="width:30%" fixed="right"> 
                <template slot-scope="scope">
                    <el-button @click.native.prevent="onDelClicked(scope.row)" type="text" size="small">删除</el-button>
                    <el-button @click.native.prevent="updateRow(scope.row)" type="text" size="small">修改</el-button>
                    <el-button @click.native.prevent="getChapters(scope.row)"  type="text" size="small">章节</el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-pagination @current-change="onPageChange" background layout="prev, pager, next" :total="novels.pages*10"> </el-pagination>
        <el-dialog title="修改小说数据" :visible.sync="dialog">
            <el-form :model="form" :label-position="'right'" label-width="80px">
                <el-form-item label="小说名" style="width:100%">
                    <el-input v-model="form.title" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="作者" style="width:100%">
                    <el-input v-model="form.author" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="章节数" style="width:100%">
                    <el-input type="number" v-model="form.total_chapters" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="字数" style="width:100%">
                    <el-input type="number" v-model="form.words" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="类型" style="width:100%">
                   <el-select v-model="form.type" placeholder="请选择" style="max-width:200px">
                       <el-option
                        :key="0"
                        :label="'无'"
                        :value="0">
                        </el-option>
                        <el-option
                        v-for="item in categories"
                        :key="item.id"
                        :label="item.name"
                        :value="item.id">
                        </el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="状态" style="width:100%">
                    <el-switch
                    style="display: block"
                    active-value="2"
                    inactive-value="1"
                    v-model="form.status"
                    active-color="#13ce66"
                    inactive-color="#ff4949"
                    active-text="完本"
                    inactive-text="连载">
                    </el-switch>
                </el-form-item>
                <!-- <el-form-item label="简介" style="width:100%">
                    <el-input type="textarea" v-model="form.desc" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item> -->
                <el-form-item label="点击量" style="width:100%">
                    <el-input type="number" v-model="form.click_num" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="收藏量" style="width:100%">
                    <el-input type="number" v-model="form.collection_num" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="推荐量" style="width:100%">
                    <el-input type="number" v-model="form.recommend_num" auto-complete="off" style="max-width:200px"></el-input>
                </el-form-item>
                <el-form-item label="首页推荐" style="width:100%">
                    <el-switch
                    style="display: block"
                    active-value="1"
                    inactive-value="0"
                    v-model="form.is_recommend"
                    active-color="#13ce66"
                    inactive-color="#ff4949"
                    active-text="是"
                    inactive-text="否">
                    </el-switch>
                </el-form-item>
                <el-form-item label="是否隐藏" style="width:100%">
                    <el-switch
                    style="display: block"
                    active-value="1"
                    inactive-value="0"
                    v-model="form.is_hide"
                    active-color="#13ce66"
                    inactive-color="#ff4949"
                    active-text="是"
                    inactive-text="否">
                    </el-switch>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click="dialog = false">取 消</el-button>
                <el-button type="primary" @click="updatePost">确 定</el-button>
            </div>
        </el-dialog>
        <el-dialog title="小说章节" :visible.sync="dialog_chapter" width="80%">
            <el-table :data="chapters.data" highlight-current-row style="width:100%;height:100%">
                <el-table-column align="center" prop="id" label="编号" style="width:10%"> </el-table-column>
                <el-table-column align="center" prop="title" label="名称" style="width:15%"></el-table-column>
                <el-table-column align="center" prop="words" label="字数" style="width:15%"></el-table-column>
                <el-table-column align="center" prop="is_update" label="状态" style="width:15%">
                    <template slot-scope="scope">
                        <span v-if="scope.row.is_update==1">已更新</span>
                        <span v-else>未更新</span>
                    </template>
                </el-table-column>
                <el-table-column align="center" prop="create_at" label="发布时间" style="width:15%"></el-table-column>
                <el-table-column align="center" prop="created_at" label="创建时间" style="width:25%"> </el-table-column>
                <el-table-column align="center" label="操作" style="width:30%" fixed="right"> 
                    <template slot-scope="scope">
                        <el-button @click.native.prevent="onDelClicked(scope.row)" type="text" size="small">删除</el-button>
                        <el-button v-if="scope.row.is_update==1" @click.native.prevent="getContent(scope.row)"  type="text" size="small">内容</el-button>
                    </template>
                </el-table-column>
            </el-table>
            
            <div slot="footer" class="dialog-footer">
                <div style="display:flex;flex-direction:row">
                    <el-pagination style="width:50%" @current-change="onChapterPageChange" background layout="prev, pager, next" :total="chapters.pages*7"></el-pagination>
                    <el-switch
                        style="display: block;width:20%"
                        active-value="asc"
                        inactive-value="desc"
                        @change="onChapterPageChange(1)"
                        v-model="search_chapter.order_by"
                        active-text="正序"
                        inactive-text="逆序">
                    </el-switch>
                </div>
                
                <el-button @click="dialog_chapter = false">取 消</el-button>
                <el-button type="primary" @click="dialog_chapter = false">确 定</el-button>
            </div>
            <el-dialog width="80%" title="章节详情" :visible.sync="dialog_content" append-to-body>
                <el-form ref="form" :model="content" label-width="80px">
                    <el-form-item label="章节名称">
                        <el-input :disabled="true" v-model="content.title"></el-input>
                    </el-form-item>
                    
                    <el-form-item label="更新时间">
                        <el-input :disabled="true" v-model="content.update_at"></el-input>
                    </el-form-item>
                    <el-form-item label="创建时间">
                        <el-input :disabled="true" v-model="content.created_at"></el-input>
                    </el-form-item>
                    
                    <el-form-item label="章节内容">
                        <el-input type="textarea" :autosize="{ minRows: 2, maxRows: 16}" v-model="content.content"></el-input>
                    </el-form-item>
                </el-form>
                <div slot="footer" class="dialog-footer">
                    <el-button type="primary">确定</el-button>
                    <el-button @click=" dialog_content=false">取消</el-button>
                </div>
            </el-dialog>
        </el-dialog>
    </div>
</template>

<script>
export default {
    data() {
        return {
            novels:{
                pages:0,
                data:[]
            },
            search:{
                title: '',
                type: '',
                resource: '',
                author: '',
                status: '',
                order_by: '',
                order_by_clumn:'',
                order_by_order:'',
                page:1
            },
            categories:[],
            sites:[],
            chapters:{
                pages:0,
                data:[]
            },
            content:{
            },
            search_chapter:{
                page:1,
                order_by:'asc',
                id:''
            },
            dialog:false,
            dialog_chapter:false,
            dialog_content:false,
            delData:{},
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
            form:{},
        }
    },
    created(){
        this.getNovels()
        this.getCategories()
        this.getSites()
    },
    methods:{
        onPageChange(page){
            this.search.page = page
            this.getNovels()
        },
        getNovels(){
            if(this.search.order_by_clumn && this.search.order_by_order){
                this.search.order_by = this.search.order_by_clumn + ',' + this.search.order_by_order
            }
            this.api.get('api/admin/novel/novels',this.search).then((ret)=>{
                this.novels.data = ret.data.data
                this.novels.pages = ret.data.pages
            })
        },
        getCategories(){
            this.api.get('api/admin/novel/categories',{}).then((ret)=>{
                this.categories = ret.data
            })
        },
        getSites(){
            this.api.get('api/admin/site/sites',{}).then((ret)=>{
                this.sites = ret.data
            })
        },
        updatePost(){
            for(var i in this.form) {
                if(this.form[i] === null || this.form[i] === ''){
                     this.$message({
                        type: 'warning',
                        message: '请填写完整!'
                    })
                    return 
                }
            }
            this.api.post('api/admin/novel/novels-update',this.form).then((ret)=>{
                this.api.retrunMsg(ret)
                if(ret.status) {
                    this.dialog = false
                    this.getNovels()
                }
                
            })
        },
        updateRow(row){
            this.form = row
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
           this.api.post('api/admin/novel/novels-del',this.delData).then((ret)=>{
                this.api.retrunMsg(ret)
                this.getNovels()
           })
        },
        onChapterPageChange(page){
            this.search_chapter.page = page
            this.getChapters(this.search_chapter)
        },
        getChapters(row){
            this.search_chapter.id = row.id
            if(this.search_chapter.id != row.id){
                this.search_chapter.page = 1
            }
            this.api.post('api/admin/novel/novels-chapters',this.search_chapter).then(ret=>{
                this.chapters.data = ret.data.data
                this.chapters.pages = ret.data.pages
                this.dialog_chapter = true
            })
        },

        getContent(row){
            var params = {
                id:row.id
            }

            this.api.post('api/admin/novel/novels-content',params).then(ret=>{
                if(this.api.retrunMsg(ret)) {
                    this.content = ret.data
                    this.content.title = row.title
                    this.content.update_at = row.create_at
                    this.dialog_content = true
                }
            })
        },

        updateContent(){
            this.api.post('api/admin/novel/novels-content-update',this.content).then(ret=>{ 
                if(this.api.retrunMsg(ret)) {
                    this.chapters = ret.data.data
                    this.dialog_chapter = true
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
