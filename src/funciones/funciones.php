<?php 


function Token ($header) {
    $auth = new Auth();
    $token = explode('"',$header);
    $newToken = $token[1];
    $valor = $auth->Check($newToken);

    if ($valor === false) {
        return "token vacio";
    }
    
    return $auth->GetData($newToken);
}



//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//||||||||||||||||||||||||||||||||||||Consultas usuarios_m_soluciones||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||


function EliminarBarrasURL ($array) {
    return explode('/', $array);
}

function consultasUserWhereNick($sql, $nick){
    $db = new DB();
    $db=$db->connection('usuarios_m_soluciones');
    $stmt = $db->prepare($sql); 
    $stmt->bind_param("s", $nick);
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado = $resultado->fetch_object();
}
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//||||||||||||||||||||||||||||||||||||Consultas Mapa_Solucines|||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||
//|||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||


function updateConDosID($sql,$valor1, $valor2){
    $db = new DB();
    $db=$db->connection('mapa_soluciones');
    $stmt = $db->prepare($sql); 
    $stmt->bind_param("si", $valor1, $valor2 );
    $stmt->execute();
    if ($stmt->affected_rows>0) {
        return true;
    }else{
        return false;
    }
    
    
}

function consultaTresValoresEnteros($sql, $parametro1 , $parametro2 , $parametro3){
    $db = new DB();
    $db=$db->connection('mapa_soluciones');
    $stmt = $db->prepare($sql); 
    $stmt->bind_param("iii", $parametro1 , $parametro2 , $parametro3 );
    $stmt->execute();
    $resultado = $stmt->get_result();
    return $resultado = $resultado->fetch_all(MYSQLI_ASSOC);    

}

function ExtraerConsultaParametro ($valor, $tipo = null) {
    $tipoConsulta = array('', 'datos_mta.nombre_mta',  'municipio', 'parroquia', 'estatus.estatus', 'datos_mta.codigo_mta', );//"proyectos.id_estado"
    if ($valor === "busqueda") {
        if ($tipo === 'id') {
            $typoConsultaBusqueda = [$tipoConsulta[6]];
            return $typoConsultaBusqueda;
        }
        $typoConsultaBusqueda = ['datos_mta.nombre_mta',  'municipio', 'parroquia', 'estatus.estatus', 'datos_mta.codigo_mta'];
        return $typoConsultaBusqueda;
    }
    return $tipoConsulta[$valor];
}

function userVerification  ($scope) {
    return in_array("ADpermisos",$scope);
}

function generar_password_complejo($largo){
    $cadena_base =  'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
    $cadena_base .= '0123456789' ;
    $cadena_base .= '$%';
  
    $password = '';
    $limite = strlen($cadena_base) - 1;
  
    for ($i=0; $i < $largo; $i++)
      $password .= $cadena_base[rand(0, $limite)];
    return $password;
}

function CondicionalMYSQL ($idPrimerRender, $campoCondicional=null,  $id = null, $scope = null){
    if (gettype($campoCondicional) === "array") {
        $where = "";

        for ($i=0; $i < count($campoCondicional); $i++) { 
            $whereNew = count($campoCondicional)>1?"{$campoCondicional[$i]} LIKE ? OR ":"{$campoCondicional[$i]} = ?";
            $where = $where.$whereNew;
        }
        
         if($idPrimerRender !== 25 && userVerification($scope) === false){

            if (count($campoCondicional)>1) {
                $where = "WHERE datos_mta.id_usuario = ? AND (".$where;
                $where = substr($where, 0, -4);
                $where = $where. ")";
            } else{
                $where = "WHERE datos_mta.id_usuario = ? AND (".$where;
                $where = $where. ")";
            }

        } else if ($idPrimerRender !== 25) {

            if (count($campoCondicional)>1) {
                $where = "WHERE datos_geograficos.id_estado = ? AND ".$where;
                $where = substr($where, 0, -4);
            } else{
                $where = "WHERE datos_geograficos.id_estado = ? AND ".$where;
            }

        }
        else {
            
            if (count($campoCondicional)>1) {
                $where = "WHERE ".$where;
                
                $where = substr($where, 0, -4);
            } else{
                $where = "WHERE ".$where;
            }
            
        } 
    } else{
        if ($idPrimerRender !== 25 && !$campoCondicional && userVerification($scope)=== false) {
            $where = "WHERE datos_mta.id_usuario = ?";
        }
        else if ($idPrimerRender !== 25 && !$campoCondicional) {
            $where = "WHERE datos_geograficos.id_estado = ?";
        }
        else if (!$campoCondicional) {
            return "";
        } 
        else if($idPrimerRender !== 25 && $id !== 0){
            $where ="WHERE datos_geograficos.id_estado = ? AND {$campoCondicional} = ?";
        }else {
            $where = "WHERE {$campoCondicional} = ?";
        }
    }
 
    return $where;
}


function typesConsultas ($array){
    $types = "";
    $newArray = [];
    
    foreach ($array as $key => $value) {
        if (gettype($array) === 'object') {
            $array = $object = (array) $array;
        }
        if (is_numeric($value) === true) {
            $types = $types."i";
            $array["$key"] = $array["$key"]+0;
            array_push($newArray, $array["$key"]);
        } else {
            $types = $types."s";
            array_push($newArray, $array["$key"]);
        }
    }
       
    return array($types, $newArray);
}


function decodeJsonArray($array, $type) {
    if ($type === 'sector') {
        for ($i=0; $i <count($array) ; $i++) { 
            $array[$i]['sector'] = json_decode($array[$i]['sector']);
        }
        
    } else if ($type === 'obra') {
        for ($i=0; $i <count($array) ; $i++) { 
            $array[$i]['obras'] = json_decode($array[$i]['obras']);
        }
    } else {
        for ($i=0; $i <count($array) ; $i++) { 
            $array[$i]['obras'] = json_decode($array[$i]['obras']);
            $array[$i]['sector'] = json_decode($array[$i]['sector']);
        }
    }

    return $array;
}


function generarSqlRegistro($tablaRegistrar,$tipoFormulario,$nombreTabla) { //genera un sql de registro con los valores de la tabla a registrar en la BD y el tipo de formulario enviado
    
    $insertInto = "INSERT INTO $nombreTabla (`id` ";
    $valores = " VALUES (NULL,";

    for ($i=0; $i < count($tablaRegistrar); $i++) { 
      $insertInto = substr($insertInto,0,-1).",".$tablaRegistrar[$i].")";
    }

    
    
    for ($x=0; $x < count($tablaRegistrar); $x++) { 
        $valores = substr($valores,0,-1).",?)";
    }
    return $insertInto.$valores;
}



function validarDatosFormulario($datosValidar,$tipoValidacion, $tipoDatos) { 
    
    //ENVIAR LOS DATOS A VALIDAR EN UN ARRAY
if (isset($tipoValidacion) && is_numeric($tipoValidacion) && (gettype($datosValidar) === "array")) {
   
        
        if (count($tipoDatos) === count($datosValidar)) {

            for ($i=0; $i < count($datosValidar); $i++) { 
                if ( (!isset($datosValidar[$i])) && (gettype($datosValidar[$i]) !== $tipoDatos[$i])) {
                    return 'ERROR EN EL DATO'.$datosValidar[$i]; 
                }
            }

         return 'OK';
   
}else {
    return 'PARAMETROS DE BUSQUEDA NO VALIDOS';
}

    var_dump(gettype($datosValidar));
    
}
}

function enviarCods($cod, $alert, $info, $array , $response= null) { 

    return  $response->withJson($array, $cod)
                    ->withHeader('Cod', $alert)
                    ->withHeader('Information', $info);
}

function validarDatosReturn($returnValidar, $response= null) { 

    if (count($returnValidar) === 0) {
        $array = [
            "cod" => "error",
            "cont" => "LA CONSULTA NO TIENE RESULTADOS" 
        ];
        return  $response->withJson([], 200)
                        ->withHeader('Cod', 'warning')
                        ->withHeader('Information', 'LA CONSULTA NO TIENE RESULTADOS');
    }else {   
        return  $response->withJson($returnValidar)
                        ->withHeader('Cod', 'success')
                        ->withHeader('Information', 'SE COMPLETO CON EXITO LA PETICION');
    }
}




function validarReporteDia($id_estado, $id_tipo_formulario, $fecha){#VALIDA QUE EN EL DIA SOLO SE HAYA HECHO UN REPORTE POR ESTADO AL DIA
  
    $db =  $db = new DB();
    $sql = "SELECT `reporte`.* FROM `reporte` WHERE reporte.id_estado = ? AND reporte.id_tabla = ? AND reporte.fecha = ?";
    $consulta = $db->consultaAll('mapa', $sql, [$id_estado, $id_tipo_formulario, $fecha]);
    
    if (count($consulta) === 0) {
        return 'OK';
    }
}





