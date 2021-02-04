<?php

// Сайт проекта http://www.elasticsearch.org/
//Добавление информации в индекс и поиск по индексу производятся с помощью простых HTTP запросов.

/*
Установка

	1. Скачиваем архив (http://www.elasticsearch.org/download/) и распаковываем его
	2. Запускаем сервер
		Unix :   bin/elasticsearch –f
		Windows :  bin/elasticsearch.bat
    JAVA_HOME или путь к Java должен быть
	3. Проверяем сервер
		curl -X GET http://localhost:9200/
	Если все работает, сервер вернет вам JSON массив с какой-то информацией.

*/

/**
 * Заметки
 * Можно создавать в качестве идентификатора числа и строки
 * Запросом PUT создание и редактирование .Создавать индекс и тип надо уже с данными (No handler found for uri)
 *  (Если небыло индекса или типа то он создастся и сохранится информация в него Если был то он редактируется)
 * Название индекса в нижнем регистре
 *
 */







if(1){
   // shell_exec ('D:\OpenServer\domains\Elasticsearch\elasticsearch-2.3.4\bin\elasticsearch.bat');
    $curl = curl_init() ;
    curl_setopt($curl, CURLOPT_URL, "http://localhost:92004/" );



    curl_setopt($curl, CURLOPT_VERBOSE, true);
    $response = curl_exec($curl);
    //$response=json_decode($response);
if($response==false){
    //echo 'Start bin\elasticsearch.bat';
   echo $response;

}else{
    echo $response;
}
    curl_close($curl);





    /*
     * stdClass Object
(
    [name] => My First Node
    [cluster_name] => elasctic
    [version] => stdClass Object
        (
            [number] => 2.3.2
            [build_hash] => b9e4a6acad4008027e4038f6abed7f7dba346f94
            [build_timestamp] => 2016-04-21T16:03:47Z
            [build_snapshot] =>
            [lucene_version] => 5.5.0
        )

    [tagline] => You Know, for Search
)
     */
}
