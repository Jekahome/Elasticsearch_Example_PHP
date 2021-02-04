<?php
// РЕДАКТИРОВАТЬ / СОЗДАТЬ
// curl -X PUT "localhost:9200/habrahabr/users/8?pretty" -d "{ \"title\" : \"Тридцать четыре богатыря\" }"

// ПОЛУЧИТЬ
// curl -X GET http://127.0.0.1:9200/habrahabr/users/8?pretty=true

// ДОБАВИТЬ
//  curl -X POST http://127.0.0.1:9200/habrahabr/users/8 -d "{ \"title\" : \"Тридцать три богатыря\" }"
// где:
//      tutorial – индекс данных Elasticsearch.
//      one – это тип данных.
//       8 – порядковый номер записи с таким индексом и типом.
//      pretty=true читабельный вид

// УДАЛИТЬ
//  curl -X DELETE  http://127.0.0.1:9200/tutorial/one/8

class ElasticSearch_v234{
    private static $inst;
    public $Indexes=[];
    public $Repository=[];
    public $cur_index;
    public $cur_type;

    const PATH='D:/OpenServer/domains/elasticsearch/serrialize/';
    const DELETE='DELETE';
    const POST='POST';
    const PUT='PUT';
    const GET='GET';

    public static function init(){
        if(!self::$inst instanceof ElasticSearch_v234) self::$inst=new ElasticSearch_v234();
        return self::$inst;
    }

    public function __construct()
    {
        /*if(file_exists(self::PATH.'idexes.txt')) {
            $this->Indexes=unserialize(file_get_contents(self::PATH.'idexes.txt'));
        }*/
        $this->loadIndexSystem();
        if(file_exists(self::PATH.'repository.txt')) {
            $this->Repository=unserialize(file_get_contents(self::PATH.'repository.txt'));
        }

    }

    public function __destruct()
    {
       if(!empty($this->Indexes)) {
           if(!file_exists(self::PATH.'idexes.txt')) fopen(self::PATH.'idexes.txt','w');
           file_put_contents(self::PATH.'idexes.txt', serialize($this->Indexes)) ;
       }
        if(!empty($this->Repository)) {
            if(!file_exists(self::PATH.'repository.txt')) fopen(self::PATH.'repository.txt','w');
            file_put_contents(self::PATH.'repository.txt', serialize($this->Repository)) ;
        }

    }

    public function initial($index,$type){
        if(isset($this->Indexes) && $this->isIndex($index,$type)){
            $this->cur_index=$index;
            $this->cur_type=$type;
            return true;
        }
        return false;
    }

    public function initialNotType($index){
        if(isset($this->Indexes) && isset($this->Indexes[$index])){
            $this->cur_index=$index;
            return true;
        }
        return false;
    }



    public function getType($index){
        if(isset($this->Indexes[$index]))
        echo json_encode($this->Indexes[$index]) ;

    }



    /**
     * @param $index
     * @param $type
     * @return bool
     * isset index and type
     */
    private function isIndex($index,$type){
        foreach($this->Indexes as $index_=>$type_){
           if($index_==$index ){
               foreach ($type_ as $t){
                   if( $t==$type) return true;
               }
               return false;
           }
        }
        return false;
    }


    // ПОЛУЧИТЬ curl -X GET http://127.0.0.1:9200/habrahabr/users/8?pretty=true
    // curl -<REST Verb> <Node>:<Port>/<Index>/<Type>/<ID>
    public function get(){
        try{
         //запустить .bat


         //  pretty=true - итабельный вид
         // fields=user,message -вернуть только эти поля

        //curl  -X GET http://localhost:9200/tutorial/one/_search?q=key:2&pretty=true
        //$search="q=key:2&pretty=true";
        //$search="q=data:Волшебные%20сны&pretty=true";
        //$search="?q=-data:search&pretty=true";// Все сообщения, которые не содержат слово для поиска
        //$search="?q=+data:search%20-data:distributed&pretty=true&fields=data";
            if(empty($_POST['type'])  ){
                if(empty($_POST['fulltext']))throw new Exception('empty fulltext');

                $data=$_POST['fulltext'];

                $data=json_decode($data);


// -d флаг не нужен ?????????????????????????????????????????????????????????????????????????????????
               // $url=  "http://127.0.0.1:9200/{$this->cur_index}/_search?".http_build_query($params).rawurlencode(" -d '".$data."'") ;
                $url=  "http://127.0.0.1:9200/{$this->cur_index}/_search?pretty=true".http_build_query($data) ;

            }else{

                if(!empty($_POST['scalar'])){
                    //  curl -XGET  '127.0.0.1:9200/kinopoisk/film/1?pretty=true&fields=starring,category,rate'
                    // по id -------------------------------------------------
                    $url="http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/".$_POST['scalar'].'?pretty=true&fields=starring,category,rate';
                    //---------------------------------------------------------

                }elseif(!empty($_POST['query'])){

                    $url="http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/_search?pretty=true&q=".$_POST['query'];

                }elseif(!empty($_POST['fulltext'])){

                    $data=$_POST['fulltext'];
                    $data=json_decode($data);

                    /*

                     curl -XGET 'http://127.0.0.1:9200/twitter/tweet/_search?q=user:kimchy&pretty=true'


                     $data='
                    {
                        "query" : {
                            "range" : {
                                "postDate" : { "from" : "1980-01-01", "to" : "2011-12-12" }
                            }
                        }
                    }';*/

                    //$url=  "http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/_search?".http_build_query($params).rawurlencode(" -d '".$data."'") ;
                    $url=  "http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/_search?pretty=true&".http_build_query($data) ;
$e='query%5Bquery_string%5D%5Bquery%5D=%D0%9A%D0%B0%D1%81%D0%BB&query%5Bquery_string%5D%5Bfields%5D%5B0%5D=starring&query%5Bquery_string%5D%5Bfields%5D%5B1%5D=directed&query%5Bquery_string%5D%5Bfields%5D%5B2%5D=name&query%5Bquery_string%5D%5Bfields%5D%5B3%5D=description&query%5Bquery_string%5D%5Bdefault_operator%5D=and';
                    $url=  "http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/_search?pretty=true&".$e;
                    // $url=  "http://127.0.0.1:9200/{$this->cur_index}/_search?".http_build_query($params).rawurlencode(" -d '".$data."'") ;

                    //$url= preg_replace('/%3A/ui', ':', $url);

                    // $url= urlencode("http://127.0.0.1:9200/habrahabr/users/_search?pretty=1 -d '{\"query\":{\"range\":{\"birthDate\":{\"from\":\"1980-01-01\",\"to\":\"2011-12-12\"}}}}'");


                    // получить все документы по дате в индексе habrahabr
                    /* $url='http://127.0.0.1:9200/habrahabr/_search?pretty=1 -d
                    {
                        "query" : {
                            "range" : {
                                "postDate" : { "from" : "1980-01-01", "to" : "2011-12-12" }
                            }
                        }
                    }';

                   curl -XGET 'http://127.0.0.1:9200/habrahabr/users/_search?pretty=true' -d '
                    { "query" :
                        { "match" :
                          { "firstname": "Jeka" }
                        }
                    }'



                   // получить все типы индекса  habrahabr
                   curl -XGET 'http://127.0.0.1:9200/habrahabr/_search?pretty=true' -d '
                    {
                        "query" : {
                            "matchAll" : {}
                        }
                    }'

                   */

                }
                else{
                    $params=[];
                    $params['pretty']=TRUE;// читабельный вид
                    $params['fields']='data';// убрать обую информацию с результата
                    $params['q']=$_POST['search'];
                    $url=  "http://127.0.0.1:9200/{$this->cur_index}/{$this->cur_type}/_search?".http_build_query($params) ;
                    $url= preg_replace('/%3A/ui', ':', $url);
                }
            }



             $curl = curl_init();
             curl_setopt($curl, CURLOPT_URL, $url );
             curl_setopt($curl, CURLOPT_HTTPGET, true );
             curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
           // $response=json_decode($response);  echo  json_encode($response)  ;
            curl_close($curl);

             file_put_contents('log/getGET.txt', $url,FILE_APPEND) ;
          if(!empty($response)){
              echo   $response;
              return;
          }else{
              echo  '{"GET":"0"}';return;
          }



        }catch (Exception $e){
          fwrite(fopen('log/Exception_search.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
            echo  '{"GET":"0"}';return;
        }
        /* RETURN curl_exec (С параметром fields=data общей информации не будет присылаться )
          {
           "_index" : "jekaindex",
          "_type" : "jekatype",
          "_id" : "1",
          "_version" : 1,
          "found" : true,
          "_source" : {
                    "firstname" : "Jeka",
                    "surname" : "Ярошенко",
                    "birthDate" : "1985-02-13",
                    "postDate" : "2009-11-15T14:12:12",
                    "location" : "Moscow, Russian Federation",
                    "skills" : [ "PHP", "HTML", "C++", ".NET", "JavaScript" ]
                  }
        }*/
    }

   // ДОБАВИТЬ curl -X POST http://127.0.0.1:9200/tutorial/one/8 -d "{ \"title\" : \"Тридцать три богатыря\" }"
    public function post( $data){
        try{

            // ДОБАВИТЬ
            //  curl -X POST http://127.0.0.1:9200/tutorial/one/8 -d "{ \"title\" : \"Тридцать три богатыря\" }"
            // где:
            //      tutorial – индекс данных Elasticsearch.
            //      one – это тип данных.
            //       1 – порядковый номер записи с таким индексом и типом. Можно не указывать id огда он сам сгенерируется(в отличии от PUT тут надо указывать что мы редактируем или добавляем)
            //if(!is_numeric($id))throw new Exception('id must be a number');

            $temp= json_decode($_POST['data']);
            $id=''; if(isset($temp->id))$id=$temp->id;

            $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/$id?op_type=create";// or  /_create

/*
            // ОБНОВИТЬ
            $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/$id/_update?pretty";
            $data= '{"script" : "rate += 5"}';//json_encode((json_decode($data))['script']);
             // скрипт для увеличения числа на 5  // "script" : "ctx._source.rate += 5"
            //https://www.elastic.co/guide/en/elasticsearch/reference/current/modules-scripting.html#modules-scripting
*/


             /* Пакетная индексация
                 curl -XPOST 'localhost:9200/index/type/_bulk?pretty
                {"index":{"_id":"1"}}
                {"name": "John Doe" }
                {"index":{"_id":"2"}}
                {"name": "Jane Doe" }

             Обновление и удаление одним запросом
                 curl -XPOST 'localhost:9200/index/type/_bulk?pretty
                {"update":{"_id":"1"}}
                {"doc": { "name": "John Doe becomes Jane Doe" } }
                {"delete":{"_id":"2"}}
             */


            // создаем подключение
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_POST, 1);
            // устанавлваем даные для отправки
            curl_setopt($curl, CURLOPT_POSTFIELDS,  $data /*json_encode(['key'=>$i,'data'=>$data[$i]]) */ );
            // флаг о том, что нужно получить результат
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            // отправляем запрос
            $response = curl_exec($curl);
            //echo "<pre>";var_export($response);
            // закрываем соединение
            curl_close($curl);

             file_put_contents('log/postPOST.txt',$url,FILE_APPEND) ;
           echo $response;

            return;
        }catch (Exception $e){
            fwrite(fopen('log/Exception_post.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
            return;
        }
    /** RETURN curl_exec
     * {"_index":"habrahabr","_type":"users","_id":"6","_version":1,"_shards":{"total":2,"successful":1,"failed":0},"created":true}
     *{"_index":"habrahabr","_type":"users","_id":"6","_version":3,"_shards":{"total":2,"successful":1,"failed":0},"created":false} при добавлении существующий записи
     */
    }

    // УДАЛИТЬ  curl -X DELETE  http://127.0.0.1:9200/tutorial/one/8
    public function delete($is_index=false,$is_type=false){
        try{


                //https://www.elastic.co/guide/en/elasticsearch/reference/current/docs-delete.html

                //curl -XDELETE 'http://localhost:9200/twitter/tweet/1'
                //curl -XDELETE 'http://localhost:9200/twitter/tweet/1?timeout=5m
                //curl -XDELETE 'http://localhost:9200/twitter/tweet/1?routing=kimchy'



                if($is_index==true){
                    // Удаление индекса
                    $url=  "http://127.0.0.1:9200/habrahabr/".$_POST['index'];
                    $curl = curl_init($url );
                    file_put_contents('log/deleteDELETE.txt', $url,FILE_APPEND) ;
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::DELETE);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'/*,"OAuth-Token: $token"*/));

                    // Make the REST call, returning the result
                    $response = curl_exec($curl);
                    curl_close($curl);
                    if (!$response) {
                        echo '{"DELETE": "Connection Failure.n"}';
                    }else{
                        unset($this->Indexes[$_POST['index']]);
                        file_put_contents(self::PATH.'idexes.txt', serialize($this->Indexes)) ;
                        echo $response;//['found'];
                        //   echo '{"DELETE": "successfully"}';//JSON.parse(data)
                        return;
                    }

                }elseif($is_type==true){
                    // Удаление типа
                    $url=  "http://127.0.0.1:9200/habrahabr/".$_POST['index']."/".$_POST['type'];
                    $curl = curl_init($url );
                    file_put_contents('log/deleteDELETE.txt', $url,FILE_APPEND) ;
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::DELETE);
                    curl_setopt($curl, CURLOPT_HEADER, false);
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'/*,"OAuth-Token: $token"*/));

                    // Make the REST call, returning the result
                    $response = curl_exec($curl);
                    curl_close($curl);
                    if (!$response) {
                        echo '{"DELETE": "Connection Failure.n"}';
                    }else{
                        unset($this->Indexes[$_POST['index']][$_POST['type']]);
                        file_put_contents(self::PATH.'idexes.txt', serialize($this->Indexes)) ;
                        echo $response;//['found'];
                        //   echo '{"DELETE": "successfully"}';//JSON.parse(data)
                        return;
                    }


                }else{
                    // Удаление по id
                    if(empty($_POST['delete'])){throw new Exception('empty delete');}
                    if(is_numeric($_POST['delete'])){
                        $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/".$_POST['delete'];
                        $curl = curl_init($url );
                        file_put_contents('log/deleteDELETE.txt', $url,FILE_APPEND) ;
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::DELETE);
                        curl_setopt($curl, CURLOPT_HEADER, false);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'/*,"OAuth-Token: $token"*/));

                        // Make the REST call, returning the result
                        $response = curl_exec($curl);
                        curl_close($curl);
                        //$response=json_decode($response);

                        //file_put_contents('log/deleteDELETE.txt',$response) ;
                        if (!$response) {
                            echo '{"DELETE": "Connection Failure.n"}';
                        }else{
                            echo $response;//['found'];
                            //   echo '{"DELETE": "successfully"}';//JSON.parse(data)
                            return;
                        }

                    }else{
                          /*
                            curl -XDELETE 'localhost:9200/customer/external/_query?pretty' -d '
                           {
                              "query": { "match": { "name": "John" } }
                           }'
                           */
                            // Удаление по результату поиска
                            $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/_query?pretty" ;
                            $curl = curl_init($url );
                            file_put_contents('log/deleteDELETE.txt', $url,FILE_APPEND) ;
                            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::DELETE);
                            curl_setopt($curl, CURLOPT_POSTFIELDS,  $_POST['delete'] /*json_encode(['key'=>$i,'data'=>$data[$i]]) */ );
                            curl_setopt($curl, CURLOPT_HEADER, false);
                            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                            curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'/*,"OAuth-Token: $token"*/));

                            // Make the REST call, returning the result
                            $response = curl_exec($curl);
                            curl_close($curl);
                            //$response=json_decode($response);

                            //file_put_contents('log/deleteDELETE.txt',$response) ;
                            if (!$response) {
                                echo '{"DELETE": "Connection Failure.n"}';
                            }else{
                                echo $response;//['found'];
                                //   echo '{"DELETE": "successfully"}';//JSON.parse(data)
                                return;
                            }




                    }
                }

        }catch (Exception $e){
          fwrite(fopen('log/Exception_delete.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
            echo '{"DELETE": "Exception"}';
        }
        /** RETURN curl_exec
         * {"found":true,"_index":"habrahabr","_type":"users","_id":"6","_version":4,"_shards":{"total":2,"successful":1,"failed":0}}
         * {"found":false,"_index":"habrahabr","_type":"users","_id":"6","_version":5,"_shards":{"total":2,"successful":1,"failed":0}} при удалении не существующей записи
         */
    }

    // РЕДАКТИРОВАТЬ И СОЗДАВАТь curl -X PUT "localhost:9200/tutorial/one/8?pretty" -d "{ \"title\" : \"Тридцать четыре богатыря\" }"
    public function put(){
        try{
            // Формат данных должен быть json
            $temp= json_decode($_POST['data']);

            $_version='';
            if(!empty($_POST['_version']))$_version='?'.$_POST['_version'];
            $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/".$temp->id.$_version;// ?version=2
          //  curl -XPUT "http://localhost:9200/project/_settings?pretty=true"
            // "{\"index\":
                      //{    \"index.analysis.analyzer.english.language\" : \"English\",
                //           \"index.analysis.analyzer.russian.filter.0\" : \"lowercase\",
                //            \"index.analysis.analyzer.russian.filter.1\" : \"russian_morphology\",
                //            \"index.number_of_shards\" : \"1\",
                //            \"index.analysis.analyzer.russian.filter.2\" : \"stop\",
                //           \"index.analysis.analyzer.russian.language\" : \"Russian\",
                //           \"index.analysis.analyzer.russian.tokenizer\" : \"standard\",
                //           \"index.analysis.analyzer.english.type\" : \"snowball\",
                //           \"index.number_of_replicas\" : \"1\"
                //}
            //}"

            /**
             * Если пришел массив то json_encode([...])
             * Если пришела GET строка то разделить на ключ=>значение и создать json
             */
            $curl = curl_init($url );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"*/]);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $_POST['data'] /*json_encode(['key'=>$data[0],'data'=>$data[1]])*/);

            // Make the REST call, returning the result
            $response = curl_exec($curl);
            curl_close($curl);

            file_put_contents('log/putPUT.txt', $url,FILE_APPEND) ;
            if (!$response) {
                echo '{"UPDATE": "Connection Failure."}';
            }else{
                 echo $response;
            }
        }catch (Exception $e){
            fwrite(fopen('log/Exception_put.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
        //RETURN  curl_exec
      /**
       * {"_index":"jekaindex","_type":"jekatype","_id":"1","_version":1,"_shards":{"total":2,"successful":1,"failed":0},"created":true}
       * {"_index":"jekaindex","_type":"jekatype","_id":"1","_version":2,"_shards":{"total":2,"successful":1,"failed":0},"created":false} данные не обновились
       */
    }


    public function CreateRepository()
    {
        try{

         $name=$_POST['name'];
        $data=$_POST['data'];

        $url=  "http://127.0.0.1:9200/_snapshot/$name";//.rawurlencode($data) ;
        $curl = curl_init($url );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"*/]);
         curl_setopt($curl, CURLOPT_POSTFIELDS,  $data /*json_encode(['key'=>$data[0],'data'=>$data[1]])*/);

        // Make the REST call, returning the result
        $response = curl_exec($curl);
        curl_close($curl);
        if(!isset($this->Repository))$this->Repository=[];
        if(!in_array($name, $this->Repository))$this->Repository[]=$name;

        print_r($response);
        /**
         * $ curl -XPUT 'http://localhost:9200/_snapshot/my_backup' -d '{
        "type": "fs",
        "settings": {
        "location": "/es-backup",
        "compress": true
        }
        }'
         * type — тип хранилища, куда они будут складываться. Из коробки есть только файловая система. С помощью дополнительных плагинов можно реализовать заливку на AWS S3, HDFS и Azure Cloud;
        location — куда сохранять новые бэкапы;
        compress — сжимать ли бэкапы. Толку не очень много, так как по факту сжимает только метаинформацию, а файлы данных остаются несжатыми. По умолчанию включено.
         */

       }catch (Exception $e){
           fwrite(fopen('log/Exception_CreateRepository.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
       }
    }



    public  function backup(){
        try{
           // $ curl -XPUT "localhost:9200/_snapshot/my_backup/snapshot_1?wait_for_completion=true"

            $repository=$_POST['repository'];
            $name=$_POST['name'];

            $data=['wait_for_completion'=>true];
            $url=  "http://127.0.0.1:9200/_snapshot/$repository/$name";//.rawurlencode(" -d '".$data."'") ;
            $curl = curl_init($url );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"*/]);
            curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data )/*json_encode(['key'=>$data[0],'data'=>$data[1]])*/);
            $response = curl_exec($curl);
            curl_close($curl);
            print_r($response);

        }catch (Exception $e){
            fwrite(fopen('log/Exception_backup.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }


    public function restore(){
      try{

          $repository=$_POST['repository'];
          $name=$_POST['name'];

          // curl -XPOST "localhost:9200/_snapshot/my_backup/snapshot_1/_restore"
          $url=  "http://127.0.0.1:9200/_snapshot/$repository/$name/_restore";
          $curl = curl_init($url );
          curl_setopt($curl, CURLOPT_POST, 1);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          $response = curl_exec($curl);
          curl_close($curl);
          print_r($response);

      } catch (Exception $e){
          fwrite(fopen('log/Exception_restore.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
      }
    }


    public function mappings()
    {
        try{

            //print_r($_POST);
            $indexbulk=$_POST['indexbulk'];
            $data=$_POST['data'];


            $url=  "http://127.0.0.1:9200/$indexbulk?pretty";//.rawurlencode($data) ;
            $curl = curl_init($url );
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT);
            curl_setopt($curl, CURLOPT_HEADER, false);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"*/]);
            curl_setopt($curl, CURLOPT_POSTFIELDS,   $data  /*json_encode(['key'=>$data[0],'data'=>$data[1]])*/);
            $response = curl_exec($curl);
            curl_close($curl);
            print_r($response);





        }catch (Exception $e){
            fwrite(fopen('log/Exception_bulk.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }

    public function bulk()
    {
        try{

            //localhost:9200/kinopoisk/film/491522
            $url=  "http://127.0.0.1:9200/_bulk";//.rawurlencode($data) ;
            $curl = curl_init($url );
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"*/]);
            curl_setopt($curl, CURLOPT_POSTFIELDS, file_get_contents('D:/OpenServer/domains/elasticsearch/Top.bulk.json')/*json_encode(['key'=>$data[0],'data'=>$data[1]])*/);
            $response = curl_exec($curl);
            curl_close($curl);
            print_r($response);




        }catch (Exception $e){
            fwrite(fopen('log/Exception_bulk.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }

        public function _mapping(){
            try{

                //curl -XGET 'localhost:9200/kinopoisk/_mapping?pretty'
                // curl -XGET  http://localhost:9200/_all/_mapping/tweet,book
                //curl -XGET  http://localhost:9200/_mapping/twitter,kimchy
                //curl -XGET http://localhost:9200/_all/_mapping

                //$url="localhost:9200/$indexbulk/_mapping?pretty";
                $curl = curl_init('http://'.$_POST['url']);
                curl_setopt($curl, CURLOPT_HTTPGET, true );
                curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
                $response = curl_exec($curl);
                // $response=json_decode($response);  echo  json_encode($response)  ;
                curl_close($curl);
                print_r($response);


            }catch (Exception $e){
                fwrite(fopen('log/Exception__mapping.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
            }
        }

    public function _count(){
        try{

//curl -XGET 'localhost:9200/kinopoisk/_mapping?pretty'

            $indexbulk=$_POST['index'];
            $url="localhost:9200/$indexbulk/_count?pretty";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url );
            curl_setopt($curl, CURLOPT_HTTPGET, true );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
            // $response=json_decode($response);  echo  json_encode($response)  ;
            curl_close($curl);
            print_r($response);


        }catch (Exception $e){
            fwrite(fopen('log/Exception__count.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }

    public function _cat(){
        try{

            $curl = curl_init("localhost:9200/_cat/health?v");
            curl_setopt($curl, CURLOPT_HTTPGET, true );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
            // $response=json_decode($response);  echo  json_encode($response)  ;
            curl_close($curl);
            print_r($response);
        }catch (Exception $e){
            fwrite(fopen('log/Exception__cat.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }
    public function _catnodes(){
        try{

            $curl = curl_init("localhost:9200/_cat/nodes?v");
            curl_setopt($curl, CURLOPT_HTTPGET, true );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
            // $response=json_decode($response);  echo  json_encode($response)  ;
            curl_close($curl);
            print_r($response);
        }catch (Exception $e){
            fwrite(fopen('log/Exception__catnodes.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }
    public function _catindicess(){
        try{

            $curl = curl_init("localhost:9200/_cat/indices?v");
            curl_setopt($curl, CURLOPT_HTTPGET, true );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
            // $response=json_decode($response);  echo  json_encode($response)  ;
            curl_close($curl);
            print_r($response);
        }catch (Exception $e){
            fwrite(fopen('log/Exception__catindicess.txt', 'a+'),'Line:'.$e->getLine().' Message:'.$e->getMessage());
        }
    }



    public function loadIndexSystem(){
        $curl = curl_init("localhost:9200/_all/_mapping");
        curl_setopt($curl, CURLOPT_HTTPGET, true );
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        $response = curl_exec($curl);
        $response=json_decode($response);  //echo  json_encode($response)  ;
        $this->Indexes=[];
        foreach ($response as $index=>$res){
            $this->Indexes[$index]=[];
            foreach ($res->mappings  as  $types=>$obj) {
                $this->Indexes[$index][] = $types;
            }
        }
        curl_close($curl);
       //echo "<pre>"; print_r($this->Indexes);
    }


    public function post_( ){
        // ДОБАВИТЬ
        //  curl -X POST http://127.0.0.1:9200/tutorial/one/8 -d "{ \"title\" : \"Тридцать три богатыря\" }"
        // где:
        //      tutorial – индекс данных Elasticsearch.
        //      one – это тип данных.
        //       1 – порядковый номер записи с таким индексом и типом.
        $data = array(
            'Потешки для самых маленьких'  ,
            'Сказки для самых маленьких',
            'Стройка, баюшки-баю',
            'Жители деревни',
            'Волшебные сны'
        );
        $url=  "http://127.0.0.1:9200/$this->cur_index/$this->cur_type/";
        for($i=0;$i<count($data);$i++){
            // создаем подключение
            $ch = curl_init($url.($i+1));
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POST, 1);
            // устанавлваем даные для отправки
            curl_setopt($ch, CURLOPT_POSTFIELDS,   json_encode(['key'=>$i,'data'=>$data[$i]])  );
            // флаг о том, что нужно получить результат
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // отправляем запрос
            $response = curl_exec($ch);
            echo "<pre>";var_export($response);
        }
        // закрываем соединение
        curl_close($ch);
        echo "Добавление данных завершено!";
    }

    public static function  test()
    {

        $curl = curl_init() ;
        curl_setopt($curl, CURLOPT_URL, "http://localhost:92004/" );
        curl_setopt($curl, CURLOPT_VERBOSE, true);
        $response = curl_exec($curl);
        //$response=json_decode($response);
        if($response==false){
            echo 'Start bin\elasticsearch.bat';
            echo $response;
            // shell_exec ('D:\OpenServer\domains\Elasticsearch\elasticsearch-2.3.4\bin\elasticsearch.bat');
        }else{
            echo $response;
        }
        curl_close($curl);
        /*

        //ADD
        $url=  "http://127.0.0.1:9200/twitter/user/kimchy";
        $curl = curl_init($url );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::PUT);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type: application/json'/*,"OAuth-Token: $token"/]);
        curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode(['name'=>'Karandash','data'=>date('Y/m/d H:i:s',time())]) );
        // Make the REST call, returning the result
        $response = curl_exec($curl);
        curl_close($curl);
        var_export($response)  ;

             //GET
            $url=  "http://127.0.0.1:9200/twitter/user/kimchy?pretty=true";
            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url );
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            $response = curl_exec($curl);
            curl_close($curl);
            var_export($response)  ;


                //DELETE
                $url=  "http://127.0.0.1:9200/twitter/user/kimchy";
                $curl = curl_init($url );
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, self::DELETE);
                curl_setopt($curl, CURLOPT_HEADER, false);
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type: application/json'/*,"OAuth-Token: $token"/));
                $response = curl_exec($curl);
                curl_close($curl);
                var_export($response)  ;*/
    }

}



/*
//print_r($_SERVER);
$url=parse_url("http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] );
$temp=explode('/',$url['path']);
$block=$uniq=$query='';
if(isset($temp[1]))$block=$temp[1];
if(isset($temp[2]))$uniq=$temp[2];
if(isset($url['query']))$query=$url['query'];

if(0 && !empty($block)){

    switch($block){
        case 'post':
            post();
            break;
        case 'get':
            get($uniq);
            break;
        case 'delete':
            delete($uniq);
            break;
        case 'put':
            put($uniq,$query);
            break;
    }

}
*/
//print_r($url);


/*
echo sprintf(file_get_contents('view/index.php'), $block." ".$uniq, $block." ".$uniq);
echo "\r\n";
exit;
*/

// ElasticSearch_v234::test();

if(!empty($_POST) && isset($_POST['mod'])){
   // echo json_encode($_POST['name']);

    switch($_POST['mod']){

        case 'create':
            if( !empty($_POST['data'])){
                //echo $_POST['data'];return;
                ElasticSearch_v234::init()->put();
            }
        break;

        case 'update':
            if(ElasticSearch_v234::init()->initial($_POST['index'],$_POST['type'])  && !empty($_POST['data'])){

                ElasticSearch_v234::init()->put();
            }
            break;

        case 'add':

            if(ElasticSearch_v234::init()->initial($_POST['index'],$_POST['type'])){
              // echo  '{"key":"'.$temp->id.'"}';return;

                ElasticSearch_v234::init()->post( $_POST['data']);
            }
            break;

         case 'search':
             if(empty($_POST['type'])){
                  if(ElasticSearch_v234::init()->initialNotType($_POST['index'])){
                      ElasticSearch_v234::init()->get();
                  }
             }else{
                 if(ElasticSearch_v234::init()->initial($_POST['index'],$_POST['type'])  ){
                     ElasticSearch_v234::init()->get();
                 }
             }

             break;

        case 'delete':
            if(ElasticSearch_v234::init()->initial($_POST['index'],$_POST['type'])  && !empty($_POST['delete']) ){
                ElasticSearch_v234::init()->delete();
            }
            break;

        case 'deleteIndex':
                ElasticSearch_v234::init()->delete(true);
            break;
        case 'deleteType':
                ElasticSearch_v234::init()->delete(false,true);
            break;
        case 'getType';
              ElasticSearch_v234::init()->getType($_POST['index']);
            break;
        case 'createrepository':
            ElasticSearch_v234::init()->CreateRepository();
            break;
        case 'backup':
            ElasticSearch_v234::init()->backup();
            break;
        case 'restore';
            ElasticSearch_v234::init()->restore();
            break;
        case 'mappings':
            ElasticSearch_v234::init()->mappings();
            break;
        case 'bulk':
            ElasticSearch_v234::init()->bulk();
            break;
        case '_mapping':
            ElasticSearch_v234::init()->_mapping();
            break;
        case '_count':
            ElasticSearch_v234::init()->_count();
            break;
        case '_cat':
            ElasticSearch_v234::init()->_cat();
            break;
        case '_catnodes':

            ElasticSearch_v234::init()->_catnodes();
            break;
        case '_catindicess':

            ElasticSearch_v234::init()->_catindicess();
            break;

        default:
           // echo json_encode($_POST['test']);
            break;
    }
    return;
}



