<?php

    include("../../configuration.php");
    include("../../connection.php");

// Action input php
function multisearch($table,$txtfield,$txtparameter,$txtdata){
    
    if($txtparameter == 'like'){
        $like_data = getsearchdata($table,$txtfield,$txtdata);

        if(rtrim($like_data,'|') != ''){
            $datalike = php_permutasi(explode("|",rtrim($like_data,'|')));

            $arr_like = explode("|",rtrim($datalike,'|'));

                foreach ($arr_like as $value) {
                    $where .= " ".$txtfield." like '%".$value."%' or ";
                }

                $sqlWHERE = " and (".rtrim($where,' or ')." ) ";

        }else{
                $sqlWHERE = " and ".$txtfield." like '%".$txtdata."%' ";
        }
    }else{

        $param = array(
                    "equal" => "="
                    ,"notequal" => "<>"
                    ,"less" => "<"
                    ,"lessorequal" => "<="
                    ,"greater" => ">"
                    ,"greaterorequal" => ">="
                    ,"isin" => "in"
                    ,"isnotin" => "not in"
                    ,"isnull" => "is null"
                    ,"isnotnull" => "is not null"
                    );

        if($txtparameter == 'isin' || $txtparameter == 'isnotin'){

            $sqlWHERE = " and ".$txtfield." ".$param[$txtparameter]." (".$txtdata.") ";

        }elseif($txtparameter == 'isnull' || $txtparameter == 'isnotnull'){
            
            if($txtparameter == 'isnull'){
                $xparam2 = " or ".$txtfield." = '' ";
            }else{
                $xparam2 = " or ".$txtfield." != '' ";
            }
            
            $sqlWHERE = " and (".$txtfield." ".$param[$txtparameter]." ".$xparam2.") ";

        }else{

            $sqlWHERE = " and ".$txtfield." ".$param[$txtparameter]." '".$txtdata."' ";

        }

            
    }
    
    return $sqlWHERE;
}
    
function getsearchdata($table,$field,$data){
    $array = explode(" ",$data);
    foreach ($array as $value) {
        
        $res = "select * from ".$table." where ".$field." like '%".$value."%' ";
        $res = mysql_query($res);
        $n = mysql_num_rows($res);

        if($n > 0){
            $new_value .= $value."|";
        }
        
        
        
    }
    
    return $new_value;
}

function php_permutasi($items, $perms = array( )) {
//    $hasil = "";
    if (empty($items)) { 
        
            return join('%', $perms) . "|";
            
    }  else {
        for ($i = count($items) - 1; $i >= 0; --$i) {
             $newitems = $items;
             $newperms = $perms;
             list($foo) = array_splice($newitems, $i, 1);
             array_unshift($newperms, $foo);
             $hasil .= php_permutasi($newitems, $newperms);
             
         }
    }
        return $hasil;
}
// close connection !!!!


?>