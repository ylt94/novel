<?php
namespace App\Http\Controllers\Member;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Member\MemberService;

use App\Models\MemberBooks;


class BooksController extends Controller{

    public function memberBooks(Request $request){
        
        $member_id = MemberService::getMemberIdFromCache($request->getClientIp());
        if(!$member_id){
            return redirect('/login');
        }
        $result = MemberService::memberBooks($member_id);

        return my_view('client.bookshelf',['novels' => $result]);
    }

    public function addBook($novel_id,Request $request){
        $data['member_id'] = MemberService::getMemberIdFromCache($request->getClientIp());
        if(!$data['member_id']){
            return redirect('/login');
        }
        $data['novel_id'] = $novel_id;
        $data['capter_id'] = $request->capter_id ?: 1;
        $data['is_collection'] = 1;
        if(!$data['novel_id'] || !isset($data['is_collection'])){
            return my_view('client.error',['status'=>0,'msg'=>'暂时不能加入书架']);
        }

        $search = [
            'novel_id' => $data['novel_id'],
            'member_id' => $data['member_id']
        ];
        $check = MemberBooks::where($search)->first();
        if($check){
            return redirect('/bookshelf');
        }
        
        $res = MemberBooks::create($data);
        if(!$res){
            return my_view('client.error',['status'=>0,'msg'=>'加入书架失败，请重试']);
        }

        return redirect('/bookshelf');

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