<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Request;

use App\Models\MemberBooks;


class BooksController extends Controller{

    public function memberBooks(Request $request){
        
        $member_id = app()->member['id'];
        $books = MemberBooks::where('member_id',$member_id)->get();

        return ['status'=>1,'msg'=>'','data'=>$books];
    }

    public function addBook(Request $request){
        $data['member_id'] = app()->member['id'];
        $data['novel_id'] = $request->novel_id;
        $data['capter_id'] = $request->capter_id ?: 1;
        $data['is_collection'] = $request->is_collection;
        if(!$data['novel_id'] || !isset($data['is_collection'])){
            return ['status'=>0,'msg'=>'参数不完整'];
        }

        $search = [
            'novel_id' => $data['novel_id'],
            'member_id' => $data['member_id']
        ];
        $check = MemberBooks::where($search)->first();
        if($check){
            return ['status'=>0,'msg'=>'该书已加入书架'];
        }

        $res = $MemberBooks::cteate($data);
        if(!$res){
            return ['status'=>0,'msg'=>'加入书架失败'];
        }

        return ['status'=>1,'msg'=>'加入书架成功'];

    }

    public function delBook(Request $request){
        $book_id = $request->book_id;
        if(!$member_id || !$novel_id){
            return ['status'=>0,'msg'=>'参数不完整'];
        }

        $book = MemberBooks::find($book_id);
        if(!$book){
            return ['status'=>1,'msg'=>'删除成功'];
        }

        $book->delete();
        
        return ['status'=>1,'msg'=>'删除成功'];
    }

}