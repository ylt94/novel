<?php
    namespace App\Services\Member;

    use App\Models\Member;
    use App\Models\MemberBooks;
    use App\Models\NovelBase;
    use App\Models\NovelDetail;
    use App\Models\NovelContent;
    use Cache;

    use App\Services\BaseService;

    class MemberService extends BaseService {


        public static function memberRegister($data){
            $data['last_login_ip'] = $data['register_ip'];

            $data['password'] = password_hash($data['password'],PASSWORD_BCRYPT);
            if(!$data['password']) {
                static::addError('注册失败，请重试',0);
                return false;
            }
            unset($data['password_confirm']);

            try{
                $member = Member::create($data);
            }catch(\Exception $e){
                static::addError('注册失败，请稍后再试',0);
                return false;
            }
            return $member;
        }

        public static function loginCheck($user_name,$password,$login_ip){
            $user = Member::where('user_name',$user_name)->first();
            if(!$user) {
                static::addError('该用户不存在',0);
                return false;
            }

            if(!password_verify($password,$user->password)){
                static::addError('密码错误',0);
                return false;
            }
            
            $user->last_login_ip = $login_ip;
            $user->save();
            return $user;
        }

        public static function memberBooks($member_id){
            if(!$member_id) {
                static::addError('参数不完整',0);
                return false;
            }

            $search = [
                'member_book.member_id' => $member_id,
                'member_book.is_collection' => 1
            ];
            $novels = MemberBooks::leftJoin('novel_base','member_book.novel_id','=','novel_base.id')
                        ->where($search)->orderBy('member_book.created_at','asc')->select(
                            'novel_base.id',
                            'novel_base.img_url',
                            'novel_base.title'
                        )->get();
            return $novels ?: [];
        }

        public static function memberBook($member_id,$novel_id){
            if(!$member_id || !$novel_id) {
                static::addError('参数不完整',0);
                return false;
            }

            $search = [
                'member_id' => $member_id,
                'is_collection' => 1,
                'novel_id' => $novel_id
            ];
            $novel = MemberBooks::where($search)->first();
            if(!$novel) {
                return [];
            }
            return $novel;
        }


        public static function memberReadBookCapter($novel_id){
            $read_record = MemberBooks::where('novel_id',$novel_id)->first();
            if(!$read_record) {
                static::addError('注册失败，请重试',0);
                return false;
            }

            $novel_detail = NovelDetail::find($read_record->capter_id);
            if(!$novel_detail || !$novel_detail->is_update){
                static::addError('该章节还未更新',0);
                return false;
            }

            $content = NovelContent::where('capter_id',$novel_detail->id)->first();
            if(!$content) {
                static::addError('该章节还未更新',0);
                return false;
            }

            $novel_detail->content = $content->content;
            return $novel_detail;
            
        }

        /**
         * 设置登录缓存
         */
        public static function setLoginCache($user_ip,$member_id){
            if(!$user_ip){
                static::addError('您的ip成谜，暂时无法登录',0);
                return false;
            }

            $result = Cache::put($user_ip,$member_id,60*24*7);

            return true;
        }

        /**
         * 清除登录缓存
         */
        public static function delMemberCache($user_ip){
            if(!$user_ip){
                static::addError('ip获取异常',0);
                return false;
            }

            $result = Cache::forget($user_ip);

            return true;
        }

        /**
         * 检查是否登录
         */
        public static function isLogin($user_ip){
            if(!$user_ip){
                return false;
            }
            
            return Cache::has($user_ip);
        }

        /**
         * 获取登录缓存的member_id
         */
        public static function getMemberIdFromCache($user_ip){
            if(!$user_ip){
                return false;
            }

            $result = Cache::get($user_ip);

            return $result;
        }

        /**
         * 更新会员收藏书籍的阅读章节记录
         */
        public static function updateMemeberBookChapter($member_id,$novel_id,$chapter_id){
            if(!$member_id || !$novel_id || !$chapter_id){
                return true;
            }
            $search = [
                'member_id' => $member_id,
                'novel_id' => $novel_id,
                'is_collection' => 1
            ];
            MemberBooks::where($search)->update(['capter_id' => $chapter_id]);
            return true;
        }
       
    }