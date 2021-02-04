<?php
/*$url=  "http://127.0.0.1:9200/habrahabr/users/_search?pretty=1%20-d%20%27{%22query%22%20:%20{%22range%22%20:%20{%22birthDate%22%20:%20{%20%22from%22%20:%20%221980-01-01%22,%20%22to%22%20:%20%222011-12-12%22%20}}}}%27";

$url= "http://127.0.0.1:9200/habrahabr/users/_search?pretty=1 -d  '{\"query\" : {\"range\" : {\"birthDate\" : { \"from\" : \"1980-01-01\", \"to\" : \"2011-12-12\" }}}}'";

//$url=json_decode('{"query" : {"range" : {"birthDate" : { "from" : "1980-01-01", "to" : "2011-12-12" }}}}');
//echo urlencode($url);
echo rawurlencode($url);
exit;*/
// %20 пробел

if(isset($_POST['mod'])){
     include_once 'backend/server.php';

}else{

     include_once 'backend/server.php';

     if(!empty($_SERVER['REQUEST_URI']) && $_SERVER['REQUEST_URI']!='/'){
        $REQUEST_URI=explode('/',$_SERVER['REQUEST_URI']);

          switch ($REQUEST_URI[1]){
               case 'settings':
                    include_once 'frontend/settings.php';
                    break;
               case 'view':
                    include_once 'frontend/view.php';
                    break;
               default:
                    include_once 'frontend/view.php';
                    break;
          }
     }else {

          include_once 'frontend/view.php';
     }

}



?>

