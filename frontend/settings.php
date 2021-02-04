<?php

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
    <li role="presentation" ><a href="/view">Home</a></li>
    <li role="presentation" class="active"><a href="#">Settings</a></li>
    <li role="presentation"><a href="#">none</a></li>
</ul>





<!-- ///////////////////////////////// BACKUP BLOCK //////////////////////////////////////////////////////////////////////////// -->
<p style="margin-left:35%" >  ----------------------- BACKUP BLOCK ---------------------  </p>
<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label">Repository</label>
        <div class="col-sm-2">
            <select class="form-control" name="selectRepository" id="selectRepository" ">
            <option disabled>select Repository</option>
            <?php
            foreach (ElasticSearch_v234::init()->Repository as  $repository_){
                echo '<option',' value="',$repository_,'" >', $repository_,'</option>';
            }
            ?>

            </select>
        </div>
    </div>
    <br>
</form>



<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Repository-name">Name</label>
        <div class="col-xs-2">
            <input type="text" name="Repository-name" id="Repository-name" class="form-control" placeholder="Create Type">
        </div>
    </div>
    <div class="form-group">
        <label  for="Backup-data" class="col-sm-1 control-label"> Data (json)</label>
        <div class="col-sm-8">
        <textarea class="form-control" rows="9"  id="Repository-data" name="Repository-data" title=" config\elasticsearch.yml path.repo: D:/OpenServer/domains/elasticsearch/es-backup">
{
    "type": "fs",
    "settings": {
        "location": "D:/OpenServer/domains/elasticsearch/es-backup",
        "compress": true
    }
}
        </textarea>
        </div>
    </div>
    <button type="button" name="dtncreaterepository" class="btn btn-info btn-lg btn-block">CREATE REPOSITORY</button>
</form>



<form style="background-color: #2e6da4" class="form-horizontal"><br>
    <div class="form-group">
        <label class="col-sm-1 control-label" id="Backup-name">Name</label>
        <div class="col-xs-2">
            <input type="text" name="Backup-name" id="Backup-name" class="form-control" placeholder="backup name">
        </div>
    </div>
    <button type="button" name="dtnbackup" class="btn btn-info btn-lg btn-block">BACKUP</button>
</form>



<form style="background-color: #2e6da4" class="form-horizontal"><br>

    <div class="form-group">
        <label class="col-sm-1 control-label" id="restore">Name</label>
        <div class="col-xs-2">
            <input type="text" name="restore" id="restore" class="form-control" placeholder="backup name"  title="name backup -> folder_repository/index">
        </div>
    </div>


    <button type="button" name="dtnrestore" class="btn btn-info btn-lg btn-block">RESTORE</button>
</form>



<p style="margin-left:35%" >  -----------------------  host:port/{index}/_mapping/{type}  ---------------------  </p>



<form class="form-inline">
    <div class="form-group">
        <label for="_mapping3">_all _mapping</label>
        <input type="text" class="form-control" size="100" id="_mapping3" name="_mapping3" value="localhost:9200/_all/_mapping">
    </div>
    <button type="button" name="dtn_mapping3" class="btn btn-info">_all _mapping</button>

    <div class="form-group">
        <label for="_mapping4">_all _mapping type</label>
        <input type="text" class="form-control" size="100" id="_mapping4" name="_mapping4" value="localhost:9200/_all/_mapping/tweet,book">
    </div>
    <button type="button" name="dtn_mapping4" class="btn btn-info">_all _mapping type</button>


    <div class="form-group">
        <label for="dtn_mapping2">_mapping</label>
        <input type="text" class="form-control" size="100" id="dtn_mapping2" name="dtn_mapping2" value="localhost:9200/_mapping">
    </div>
    <button type="button" name="dtn_mapping2" class="btn btn-info">_mapping</button>

    <div class="form-group">
        <label for="_mapping5">_mapping Index </label>
        <input type="text" class="form-control" size="100" id="_mapping5" name="_mapping5" value="localhost:9200/_mapping/twitter,kimchy">
    </div>
    <button type="button" name="dtn_mapping5" class="btn btn-info">  _mapping Index</button>



    <div class="form-group">
        <label for="_mapping1">_mapping Index</label>
        <input type="text" class="form-control" size="100" id="_mapping1" name="_mapping1" value="localhost:9200/twitter/_mapping?pretty">
    </div>
    <button type="button" name="dtn_mapping1" class="btn btn-info"> _mapping Index </button>



</form>



<button type="button" name="dtn_count" class="btn btn-info"> _count </button>
<button type="button" name="dtn_cat" class="btn btn-info"> _cat health</button>
<button type="button" name="dtn_catnodes" class="btn btn-info"> _cat nodes</button>
<button type="button" name="dtn_catindicess" class="btn btn-info" title="список наших индексов"> _cat indices</button>



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



     $('[name="dtnbackup"]').on('click',function (indx,el){
         var name=$('[name="Backup-name"]').val();
         var data=$('[name="Backup-data"]').val();
         var repository=$('[name="selectRepository"]').val();
         if(name){
             console.log('Запрос послан Create Repository');
             $.post("/",
                 {
                     repository:repository,
                     name: name,
                     data:data,
                     mod:'backup'
                 },
                 function(data, status){
                     console.log('response server',data );

                 });
         }
     });


    $('[name="dtnrestore"]').on('click',function (indx,el){
        var name=$('[name="restore"]').val();

        var repository=$('[name="selectRepository"]').val();
        if(name){
            console.log('Запрос послан RESTORE');
            $.post("/",
                {
                    repository:repository,
                    name: name,
                    mod:'restore'
                },
                function(data, status){
                    console.log('response server',data );

                });
        }
    });





    $('[name="dtncreaterepository"]').on('click',function (indx,el){
        var name=$('[name="Repository-name"]').val();
        var data=$('[name="Repository-data"]').val();
        if(name){
            console.log('Запрос послан Create Repository');
            $.post("/",
                {
                    name: name,
                    data:data,
                    mod:'createrepository'
                },
                function(data, status){
                    console.log('response server',data );
                    window.setTimeout(function(){location.reload();}, 0);
                });
        }
    });





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

    //********************** _mapping ***********************************************

    $('[name="dtn_mapping1"]').on('click',function (indx,el){

        $.post("/",
            {
                url:$('[name="_mapping1"]').val(),
                mod:'_mapping'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });

    $('[name="dtn_mapping2"]').on('click',function (indx,el){
        $.post("/",
            {
                url:$('[name="_mapping2"]').val(),
                mod:'_mapping'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });
    $('[name="dtn_mapping3"]').on('click',function (indx,el){
        $.post("/",
            {
                url:$('[name="_mapping3"]').val(),
                mod:'_mapping'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+ data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });
    $('[name="dtn_mapping4"]').on('click',function (indx,el){
        $.post("/",
            {
                url:$('[name="_mapping4"]').val(),
                mod:'_mapping'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });

    $('[name="dtn_mapping5"]').on('click',function (indx,el){
        $.post("/",
            {
                url:$('[name="_mapping5"]').val(),
                mod:'_mapping'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });

//*************************************************************



    $('[name="dtn_count"]').on('click',function (indx,el){
        var index=$('[name="Index"]').val();
        $.post("/",
            {
                index:index,
                mod:'_count'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                //  window.setTimeout(function(){location.reload();}, 5000);
            });
    });
    $('[name="dtn_cat"]').on('click',function (indx,el){

        $.post("/",
            {

                mod:'_cat'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                $('#result').append('<b>status </b>: Green (зелёный) означает что всё хорошо (кластер полностью работоспособен), yellow (жёлтый) означает, что все данные доступны, но некоторые реплики ещё не размещены (кластер полностью функционален) и red (красный) означает, что некоторые данные недоступны по какой-либо причине. Обратите внимание, что даже если кластер находится в состоянии red, он продолжает работать (т.е. будет продолжать обслуживать поисковые запросы для доступных шардов), но вам будет необходимо починить ASAP, поскольку у вас есть потерянные данные.<br>' +
                    '<b>total</b>: общее количество узлов в кластере<br>' +
                    '<b>shards</b>: шарды <br>' +
                    '');
            });
    });
    $('[name="dtn_catnodes"]').on('click',function (indx,el){

        $.post("/",
            {

                mod:'_catnodes'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                $('#result').append('<b>name</b>: узел')
            }); ;
    });
    $('[name="dtn_catindicess"]').on('click',function (indx,el){

        $.post("/",
            {

                mod:'_catindicess'
            },
            function(data, status){
                console.log('response server',data );
                $('#result').html('');
                $('#result').append('<pre>'+data+'</pre>');
                $('#result').append('<b>index</b>:название индекса<br>' +
                    '<b>pri</b>:шарды<br>' +
                    '<b>rep</b>:реплики<br>' +
                    '<b>docs.count</b>:количетсво документов<br>' +
                    '<p>При создании индекса он имеет status:yellow поскольку у нас, в данный момент, запущен только один узел, то эта реплика не может быть пока размещена (для высокой доступности) до тех пор, пока в дальнейшем к кластеру не присоединится ещё один узел. Как только эта реплика разместится на втором узле, статус для этого индекса станет зелёным.</p>');

            }); ;
    });
</script>
<script src="../js/bootstrap.min.js"></script>
</body>
</html>
