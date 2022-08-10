<?php

session_start();
ob_start();
$_SESSION['TypeConsult'] = 
[
    'produccion',//0 
    'rehabilitacion_pozo',//1 
    'fugas',//2 
    'tomas_ilegales',//3 
    'reparaciones_brippas',//4
    'afectaciones',//5 
    'operatividad_abastecimiento',//6
    'pozo',//7
    'brippas',//8
    'sistemas'//9
];

$_SESSION['Meses'] = 
[
    ["ENERO",0],
    ["FEBRERO",0],
    ["MARZO",0],
    ["ABRIL",0],
    ["MAYO",0],
    ["JUNIO",0],
    ["JULIO",0],
    ["AGOSTO",0],
    ["SEPTIEMBRE",0],
    ["OCTUBRE",0],
    ["NOVIEMBRE",0],
    ["DICIEMBRE",0]
];


$_SESSION['Estados'] = [
    ["AMAZONAS",0],
    ["ANZOATEGUI",0],
    ["APURE",0],
    ["ARAGUA",0],
    ["BARINAS",0],
    ["BOLIVAR",0],
    ["CARABOBO",0],
    ["COJEDES",0],
    ["DELTA AMACURO",0],
    ["FALCON",0],
    ["GUARICO",0],
    ["LARA",0],
    ["MERIDA",0],
    ["MIRANDA",0],
    ["MONAGAS",0],
    ["NUEVA ESPARTA",0],
    ["PORTUGUESA",0],
    ["SUCRE",0],
    ["TACHIRA",0],
    ["TRUJILLO",0],
    ["VARGAS",0], 
    ["YARACUY",0],
    ["ZULIA",0],
    ["DISTRITO CAPITAL",0]
];

$_SESSION['EstadosMapa'] = [
    ["VE-Z",0],
    ["VE-B",0],
    ["VE-C",0],
    ["VE-D",0],
    ["VE-E",0],
    ["VE-F",0],
    ["VE-G",0],
    ["VE-H",0],
    ["VE-Y",0],
    ["VE-I",0],
    ["VE-J",0],
    ["VE-K",0],
    ["VE-L",0],
    ["VE-M",0],
    ["VE-N",0],
    ["VE-O",0],
    ["VE-P",0],
    ["VE-R",0],
    ["VE-S",0],
    ["VE-T",0],
    ["VE-X",0], 
    ["VE-U",0],
    ["VE-V",0],
    ["VE-A",0]
];