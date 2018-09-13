<?php
    namespace App\Services\Site;
    use Illuminate\Support\Facades\Cache;

    use App\Models\Sites;

    use App\Services\BaseService;

    class SiteService extends BaseService{

        public static function  getSiteByName($name){
            
            $site = Sites::where('name',$name)->first();
            if(!$site){
                static::addError('无此网站',0);
                return false;
            }

            return $site;
        }
    }