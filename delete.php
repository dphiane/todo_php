<?php

$filename=__DIR__."/todo.json";

$_GET=filter_input_array(INPUT_GET,FILTER_VALIDATE_INT);
$id=$_GET['id']?? '';

if($id){
    $data = file_get_contents($filename);
    $todos = json_decode($data, true) ?? [];
    if(count($todos)){
        $toDoIndex=array_search($id,array_column($todos,'id'));
        array_splice($todos,$toDoIndex,1);
        file_put_contents($filename,json_encode($todos));
    }
}
header('location:/');