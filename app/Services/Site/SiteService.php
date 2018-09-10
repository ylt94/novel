<?php
    namespace App\Services\Site;
    use Illuminate\Support\Facades\Cache;
    use App\Models\Sites;

    class SiteService {

        public static function  getSiteByName($name){
            
            return Sites::where('name',$name)->first();
        }
    }