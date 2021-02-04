<?php
//ElasticSearch_v234::init()->loadIndexSystem();exit;

 ?>


<html>
<head>
    <meta charset='utf-8'/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="../js/jquery-2.1.4.min.js"></script>
    <link href="../css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<title>ElasticSearch</title>
<h1 style="margin-left:35%" ><a target="_blank"  href="http://elasticsearch.docwiki.ru/guide/ru/elasticsearch/reference/current/getting-started.html">Start ElasticSearch</a></h1>
<ul class="nav nav-tabs">
    <li role="presentation" class="active"><a href="#">Home</a></li>
    <li role="presentation"><a href="/settings">Settings</a></li>
    <li role="presentation"><a href="#">none</a></li>
</ul>

<!-- //////////////////////////////////////// SELECT INDEX AND TYPE BLOCK /////////////////////////////////////////////////////////////////// -->

<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label">Index</label>
        <div class="col-sm-2">
            <select class="form-control" name="Index" id="selectIndex" ">
            <option disabled>select Index</option>
                <?php
                 foreach (ElasticSearch_v234::init()->Indexes as $index_=>$type_){
                    echo '<option',' value="',$index_,'" >', $index_,'</option>';
                }
                ?>

            </select>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label">Type</label>
        <div class="col-sm-2">
            <select class="form-control" name="Type" id="selectType">
                <option value="">select Type</option>
                <?php
                /*foreach (ElasticSearch_v234::init()->getType() as  $type_){
                    echo '<option', ' value="',$type_,'" >', $type_, '</option>';
                }*/
                ?>
            </select>
        </div>
    </div>
    <button type="button" name="dtndeleteIndex" class="btn btn-info btn-lg btn-block">DELETE INDEX</button>
    <button type="button" name="dtndeleteType" class="btn btn-info btn-lg btn-block">DELETE TYPE</button>
    <br>
</form>
<br>
<?php
if( empty(ElasticSearch_v234::init()->Indexes) ){
    echo '<script>alert("Нет индекса или типа.\nСоздайте индекс и тип для начала работы");</script>';
}

?>

<!-- //////////////////////////////////////// ADD DATA BLOCK /////////////////////////////////////////////////////////////////// -->
<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label  for="Index" class="col-sm-1 control-label"> Data (json)</label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="9" name="Add-data">
{
  "id": 2,
  "name": "Иван Васильевич меняет профессию",
  "description": "Легендарная советская комедия о молодом инженере-изобретателе, которому удалось вернуть из прошлого самого Ивана Грозного.",
  "date": "1973-10-17T21:00:00.000Z",
  "rate": 8.943,
  "starring": [
    "Александр Демьяненко",
    "Юрий Яковлев",
    "Леонид Куравлёв",
    "Наталья Крачковская",
    "Савелий Крамаров"
  ],
  "category": [
    "фантастика"
  ],
  "directed": [
    "Леонид Гайдай"
  ]
}


  {
   "id": 2,
  "script" : "ctx._source.rate += 5"
  }

        </textarea>
        </div>

    </div>
    <button type="button" name="dtnadd" class="btn btn-info btn-lg btn-block">ADD DATA</button>
</form>
<!-- ///////////////////////////////// DELETE BLOCK //////////////////////////////////////////////////////////////////////////// -->



<form style="background-color: #2e6da4" class="form-horizontal"><br>

    <div class="form-group">
        <label class="col-sm-1 control-label" id="Delete-id">id</label>
        <div class="col-xs-6">
            <input type="number" name="Delete-id" min="1" id="Delete-id" class="form-control" placeholder="1">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Delete-search">Search delete</label>
        <div class="col-xs-10">
            <input type="text" name="Delete-search" id="Delete-search" class="form-control" value='{"query": { "match": { "category": "фантастика" } }}' placeholder='{"query": { "match": { "category": "фантастика" } }}'>
        </div>
    </div>
    <button type="button" name="dtndelete" class="btn btn-info btn-lg btn-block">DELETE DOC</button>
</form>

<!-- ///////////////////////////////// CREATE/UPDATE BLOCK //////////////////////////////////////////////////////////////////////////// -->
<br>

<br>
<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Create-index">Index</label>
        <div class="col-xs-2" >
            <input type="text" id="Create-index" name="Create-index"  class="form-control" placeholder="Create Index" >
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Create-type">Type</label>
        <div class="col-xs-2">
            <input type="text" name="Create-type" id="Create-type" class="form-control" placeholder="Create Type">
        </div>
    </div>
<!--    <div class="form-group">-->
<!--        <label class="col-sm-1 control-label" id="id_update">id</label>-->
<!--        <div class="col-xs-6">-->
<!--            <input type="text" name="Update-id" min="1" id="Update-id" class="form-control" placeholder="1">-->
<!--        </div>-->
<!--    </div>-->
    <div class="form-group">
        <label class="col-sm-1 control-label" id="_version">_version</label>
        <div class="col-xs-6">
            <input type="text" name="_version" min="1" id="_version" class="form-control" placeholder="1">
        </div>
    </div>
    <div class="form-group">
        <label  for="Update-data" class="col-sm-1 control-label"> Data (json)</label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="9"  id="Update-data" name="Update-data">
{
  "id": 1,
  "name": "Звездный крейсер Галактика (сериал 2004 – 2009)",
  "description": "Чудом уцелев после нападения Сайлонов...",
  "date": "2004-10-17T21:00:00.000Z",
  "rate": 7.943,
  "starring": [
    "Эдвард Джеймс Олмос",
    "Мэри МакДоннелл",
    "Джейми Бамбер",
    "Джеймс Кэллис",
    "Триша Хелфер",
    "Грейс Пак",
    "Кэти Сакхофф",
    "Майкл Хоган",
    "Аарон Дуглас",
    "Тамо Пеникетт"
  ],
  "category": [
    "фантастика",
    "боевик",
    "драма",
    "приключения"
  ],
  "directed": [
    "Майкл Раймер",
    "Майкл Нанкин",
    "Род Харди"
  ]
}
        </textarea>
        </div>

    </div>
    <button type="button" name="dtnupdate" class="btn btn-info btn-lg btn-block">CREATE/UPDATE</button>
</form>



<!-- ///////////////////////////////// CREATE BULK BLOCK /////////////////////////////////////////////////////////////////////////// -->


<br>
<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Create-index-bulk">Index</label>
        <div class="col-xs-2" >
            <input type="text" id="Create-index-bulk" name="Create-index-bulk"  class="form-control" placeholder="Create Index bulk" >
        </div>
    </div>


    <div class="form-group">
        <label  for="Bulk-data" class="col-sm-1 control-label"> Data (json)</label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="9"  id="Bulk-data" name="Bulk-data">
{
  "mappings": {
    "film" : {
      "properties" : {
        "suggest" : {
          "type" : "completion",
          "analyzer": "standard"
        },
        "category": {
          "type": "string",
          "fields": {
              "raw": {
                  "type": "string",
                  "index": "not_analyzed"
              }
          }
        },
        "directed": {
          "type": "string",
          "fields": {
              "raw": {
                  "type": "string",
                  "index": "not_analyzed"
              }
          }
        },
        "starring": {
          "type": "string",
          "fields": {
              "raw": {
                  "type": "string",
                  "index": "not_analyzed"
              }
          }
        }
      }
    }
  }
}
        </textarea>
        </div>

    </div>
    <button type="button" name="dtnmappings" class="btn btn-info btn-lg btn-block">CREATE BULK</button>
    <button type="button" name="dtnbulk" class="btn btn-info btn-lg btn-block"> BULK </button>
</form>


<!-- ///////////////////////////////// SEARCH BLOCK /////////////////////////////////////////////////////////////////////////// -->
<br>
<form style="background-color: #2e6da4" class="form-horizontal"><br>

    <div class="form-group">
        <label class="col-sm-1 control-label" id="scalar">Search text</label>
        <div class="col-xs-6">
           <input type="text" name="scalar" id="scalar" class="form-control" placeholder="int or string">
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="query">Search text</label>
        <div class="col-xs-6">
            <input type="text" name="query" id="query" class="form-control" placeholder="firstname:Piotr&surname:Petrov">
        </div>
    </div>

    <div class="form-group">
        <label  for="Update-data" class="col-sm-1 control-label"> Data (json) fulltext</label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="9"  id="fulltext" name="fulltext">
{
    "fields" : ["id", "rate"],
    "query" : {
      "query_string" : {
        "query":    "Касл",
        "fields": [ "starring", "directed","name","description" ],
        "default_operator": "and"
      }
    }
}
        </textarea>
        </div>

    </div>
    <button type="button" name="dtnGET" class="btn btn-info btn-lg btn-block">SEARCH</button>
</form>

<div id="result" >

</div>
<style>
    th, td {
        padding: 15px;
        text-align: left;
    }
    th, td {
        border-bottom: 1px solid #ddd;
    }
    tr:hover {background-color: #f5f5f5}
</style>
<br><br><br><br>
<script >
    $(document).ready(function(){
      $("#selectIndex").change();
    });






    /** получение данных */
    $('[name="dtnGET"]').on('click',function (indx,el) {
       var scalar=fulltext=query='';
        if($('[name="scalar"]').val().length)scalar=$('[name="scalar"]').val();
        else if($('[name="query"]').val().length)query=$('[name="query"]').val();
        else if($('[name="fulltext"]').val().length)fulltext=$('[name="fulltext"]').val();
        else {console.log('empty delete param');return;}
        $('#result').html('');
            $.post("/",
                {
                  index: $('[name="Index"]').val(),
                  type: $('[name="Type"]').val(),
                  scalar: scalar,
                  query:query,
                  fulltext: fulltext,
                  mod:'search'
                },
                function(data, status){
                    console.log('response server',data );
                    if(status){
                        if(status=='success'){
                          // console.log( JSON.stringify(data) ); JSON.parse(data)
                            $('#result').append('<pre>'+data+'</pre>');
                            $('#result').append('<b>found</b>:говорит о том что найдено по нашему запросу<br>' +
                                '<b>_source</b>:возвращает полный документ в формате JSON<br>');

                        }else{
                            console.log('error response search');
                        }
                    }else{
                        console.log('error response search not status');
                    }
                });
    });



    /** добавление данных */
    $('[name="dtnadd"]').on('click',function (indx,el) {
        console.log('Послан запрос добавление данных');
        $.post("/",
            {
                index: $('[name="Index"]').val(),
                type: $('[name="Type"]').val(),
                data: $('[name="Add-data"]').val(),
                mod:'add'
            },
            function(data, status){
                console.log('response server',data );
                if(status){
                    if(status=='success'){
                        try{
                            $('#result').html('');
                            $('#result').append('<pre>'+data+'</pre>');
 //data: {"_index":"habrahabr","_type":"users","_id":"1","_version":12,"_shards":{"total":2,"successful":1,"failed":0},"created":false}
                           var response=JSON.parse(data);
                            for(var i in response ){
                                console.log(i,response[i]);
                            }
                        }catch (Exception){
                            console.error('Exception:',Exception);
                        }
                    }else{
                        console.error('error response Add-data',status);
                    }
                }else{
                    console.error('error response Add-data not status');
                }
            });
    });

   /** удаление данных*/
    $('[name="dtndelete"]').on('click',function (indx,el) {

        var param='';
        if($('[name="Delete-id"]').val().length)param=$('[name="Delete-id"]').val();
        else if($('[name="Delete-search"]').val().length)param=$('[name="Delete-search"]').val();
            else {console.log('empty delete param');return;}
        console.log('Послан запрос удаления данных');
        $.post("/",
            {
                index: $('[name="Index"]').val(),
                type: $('[name="Type"]').val(),
                delete: param,
                mod:'delete'
            },
            function(data, status){
                console.log('response server',data );
                if(status){
                    if(status=='success'){
                        // console.log( JSON.stringify(data) ); JSON.parse(data)
                        $('#result').html('');
                        $('#result').append('<pre>'+data+'</pre>');

                    }else{
                        console.log('error response search');
                    }
                }else{
                    console.log('error response search not status');
                }
            });
    });

    /** обновление данных / создание индекса */
    $('[name="dtnupdate"]').on('click',function (indx,el){

        var mod='update';
        var index=$('[name="Index"]').val();
        var type=$('[name="Type"]').val();
        var _version=$('[name="_version"]').val();
        var is_create=false;

        if($('[name="Create-index"]').val().length){
            index=$('[name="Create-index"]').val();
            if($('[name="Create-type"]').val().length)type=$('[name="Create-type"]').val();
            else {console.error('Не выбран тип');return;}
            mod='create';
            is_create=true;
        }
        if(!$('[name="Update-data"]').val().length  ) {console.log('empty delete param');return;}

        if(mod=='create')console.log('Послан запрос обновления данных');
        else console.log('Послан запрос создания индекса');


        $.post("/",
            {
                index: index,
                type: type,
                //id: $('[name="Update-id"]').val(),
                data: $('[name="Update-data"]').val(),
                _version:_version,
                mod:mod
            },
            function(data, status){
                console.log('response server',data );
                if(is_create) {
                  //  window.setTimeout(function(){location.reload();}, 5000);
                }
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                $('#result').append('<b>_version</b>:версия документа (число обновлений)<br>' +
                    '<b>total</b>: сколько копий нужно обновить в primary and replica shards<br>' +
                    '<b>successful</b>: количество shards обновленно <br>' +
                    '<b>failed</b>: массив ошибок репликации');
            });
    });


    /** удаление индекса */
    $('[name="dtndeleteIndex"]').on('click',function (indx,el){
        var mod='deleteIndex';
        var index=$('[name="Index"]').val();
        $.post("/",
            {
                index: index,
                mod:mod
            },
            function(data, status){
                console.log('response server',data );
                location.reload();
            });
    });

    /** удаление типа */
    $('[name="dtndeleteType"]').on('click',function (indx,el){
        var mod='deleteType';
        var index=$('[name="Index"]').val();
        var type=$('[name="Type"]').val();
        $.post("/",
            {
                index: index,
                type: type,
                mod:mod
            },
            function(data, status){
                console.log('response server',data );
                location.reload();
            });
    });


    /** выбор типа по индексу*/
    $('#selectIndex').change(function ( ){
        var index=$('[name="Index"]').val();
        if(index){
            $.post("/",
                {
                    index: index,
                    mod:'getType'
                },
                function(data, status){
                    data=JSON.parse(data);
                    $('#selectType').html('');
                    $('#selectType').append('<option value="">select Type</option>');
                    data.forEach(function (val,i) {
                        if(i==0)$('#selectType').append('<option selected value="'+val+'">'+val+'</option>');
                        else $('#selectType').append('<option value="'+val+'">'+val+'</option>');
                    });
                });
        }
    });



    $('[name="dtnmappings"]').on('click',function (indx,el){
        var indexbulk=$('[name="Create-index-bulk"]').val();
        var data=$('[name="Bulk-data"]').val();
        $.post("/",
            {
                indexbulk: indexbulk,
                data: data,
                mod:'bulk'
            },
            function(data, status){
                console.log('response server',data );
                    window.setTimeout(function(){location.reload();}, 5000);
            });
    });



    $('[name="dtnbulk"]').on('click',function (indx,el){

        $.post("/",
            {

                mod:'bulk'
            },
            function(data, status){
                console.log('response server',data );
              //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });



</script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
