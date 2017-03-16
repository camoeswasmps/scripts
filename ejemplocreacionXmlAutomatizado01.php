<?php
//-- LECTURA DATOS -->
include ('include-conectar.php');
$lectura = @mysql_query("select * from gestmilar order by id desc");
$numero_filas = mysql_num_rows($lectura);
$row = @mysql_fetch_array($lectura);
$ip = $row["ip"];
@mysql_free_result($lectura);
@mysql_close($con);
//echo "IP: ";
//echo $ip;
?>
<?php
date_default_timezone_set('Europe/Madrid');
$hoy=date("Ymd");
//$hoy='20140422'; //DEV
$hora=date("Hi");
//$hora='1201'; //DEV
$fecha=$hoy.$hora;
//$fecha='201404221201'; //DEV
?>

<?php
//------------------------------------------------------------------------------------------- CREAR FICHERO
$carpeta="/var/www/vhosts/sacse.es/httpdocs/csv/sinersis"; //cron
//$carpeta="csv/vencobaix"; //php
$archivo="productos.xml";
//$ar=fopen('../'.$carpeta.'/'.$archivo,"w"); //php
$ar=fopen($carpeta.'/'.$archivo,"w"); //cron
//------------------------------------------------------------------------------------------- WEBSERVICE
require_once("ntlm/NTLMStream.php");

require_once("ntlm/NTLMSoapClient.php");

stream_wrapper_unregister('http');

stream_wrapper_register('http', 'NTLMStream') or die("Failed to register protocol");

// Initialize Soap Client
//$baseURL = 'http://192.168.1.19:7047/DynamicsNAV/WS/';
$baseURL = $ip;

$client = new NTLMSoapClient($baseURL.'SystemService');

// Buscar la 1a empresa en Empresas
$result = $client->Companies();
$companies = $result->return_value;
//echo "Empresa:<br>";
if (is_array($companies)) {
  foreach($companies as $company) {
    //echo "<b>$company</b><br>";
  }
  $cur = $companies[1];
}
else {
  //echo "<b>$companies</b><br>";
  $cur = $companies;
}
//esto devuelve: CRONUS Espa�a S.A.

// Buscar el cliente CL90501500 y clientes de Country_Region_Code = ES
$pageURL = $baseURL.rawurlencode($cur).'/Page/StockSinersis';

// Initialize Page Soap Client

$page = new NTLMSoapClient($pageURL);

$params = array('filter' => array(
                array('Field' => 'Blocked_Webshop',
                        'Criteria' => '0'),
                /*array('Field' => 'Cliente',
                        'Criteria' => '00000006')*/

                ),

                //'setSize' => 100);
                'setSize' => 0);

$result = $page->ReadMultiple($params);

$customers = $result->ReadMultiple_Result->StockSinersis;

$cabecera="<?xml version=\"1.0\" encoding=\"iso-8859-1\" standalone=\"yes\" ?>\n<PRODUCTOS codigoSocio='4005'>\n";
//primera fila del CSV
fwrite($ar,$cabecera);

if (is_array($customers)) {

foreach($customers as $cust) {

if(isset($cust->Key)) { $Key = $cust->Key; } else { $Key =""; }
if(isset($cust->Item_No)) { $Item_No = $cust->Item_No; } else { $Item_No =""; }
if(isset($cust->Description)) { $Description = $cust->Description; } else { $Description =""; }
if(isset($cust->Blocked_Webshop)) { $Blocked_Webshop = $cust->Blocked_Webshop; } else { $Blocked_Webshop ="0"; }
if(isset($cust->Last_Reported_Inventory)) { $Last_Reported_Inventory = $cust->Last_Reported_Inventory; } else { $Last_Reported_Inventory =""; }
if(isset($cust->Product_Group_Code)) { $Product_Group_Code = $cust->Product_Group_Code; } else { $Product_Group_Code =""; }
if(isset($cust->EAN_1)) { $EAN_1 = $cust->EAN_1; } else { $EAN_1 =""; }
if(isset($cust->EAN_2)) { $EAN_2 = $cust->EAN_2; } else { $EAN_2 =""; }
if(isset($cust->EAN_3)) { $EAN_3 = $cust->EAN_3; } else { $EAN_3 =""; }
if(isset($cust->EAN_4)) { $EAN_4 = $cust->EAN_4; } else { $EAN_4 =""; }
if(isset($cust->EAN_5)) { $EAN_5 = $cust->EAN_5; } else { $EAN_5 =""; }
if(isset($cust->CODIGO_CALBET)) { $CODIGO_CALBET = $cust->CODIGO_CALBET; } else { $CODIGO_CALBET =""; }
if(isset($cust->PROVEEDOR)) { $PROVEEDOR = $cust->PROVEEDOR; } else { $PROVEEDOR =""; }
if(isset($cust->MARCA)) { $MARCA = $cust->MARCA; } else { $MARCA =""; }
if(isset($cust->FAMILIA)) { $FAMILIA = $cust->FAMILIA; } else { $FAMILIA =""; }
if(isset($cust->PRECIO_COMPRA_INTER)) {
$PRECIO_COMPRA_INTER = $cust->PRECIO_COMPRA_INTER;
$PRECIO_COMPRA_INTER=str_replace(".",",",$PRECIO_COMPRA_INTER); //reemplaza puntos . por comas ,
} else {
$PRECIO_COMPRA_INTER ="";
}
if(isset($cust->PRECIO_COMPRA_EMP)) {
$PRECIO_COMPRA_EMP = $cust->PRECIO_COMPRA_EMP;
$PRECIO_COMPRA_EMP=str_replace(".",",",$PRECIO_COMPRA_EMP); //reemplaza puntos . por comas ,
} else {
$PRECIO_COMPRA_EMP ="";
}
if(isset($cust->PVP)) {
$PVP = $cust->PVP;
$PVP=str_replace(".","",$PVP); //reemplaza puntos . por nada
} else {
$PVP ="";
}
if(isset($cust->TIPO_IVA)) { $TIPO_IVA = $cust->TIPO_IVA; } else { $TIPO_IVA =""; }
if(isset($cust->TIPO_PRODUCTO)) { $TIPO_PRODUCTO = $cust->TIPO_PRODUCTO; } else { $TIPO_PRODUCTO =""; }
if(isset($cust->DESCRIPCION_FAMILIA)) { $DESCRIPCION_FAMILIA = $cust->DESCRIPCION_FAMILIA; } else { $DESCRIPCION_FAMILIA =""; }
if(isset($cust->DESCRIPCION_GRUPO_PRODUCTO)) { $DESCRIPCION_GRUPO_PRODUCTO = $cust->DESCRIPCION_GRUPO_PRODUCTO; } else { $DESCRIPCION_GRUPO_PRODUCTO =""; }
if(isset($cust->CANTIDAD_PEDIDOS_COMPRA)) { $CANTIDAD_PEDIDOS_COMPRA = $cust->CANTIDAD_PEDIDOS_COMPRA; } else { $CANTIDAD_PEDIDOS_COMPRA =""; }
if(isset($cust->Fecha_creacion)) { $Fecha_creacion = $cust->Fecha_creacion; } else { $Fecha_creacion =""; }
if(isset($cust->FECHA_CREACION_FICHERO)) { $FECHA_CREACION_FICHERO = $cust->FECHA_CREACION_FICHERO; } else { $FECHA_CREACION_FICHERO =""; }

//$linea=$Item_No.";".$Description.";".$Blocked_Webshop.";".$Last_Reported_Inventory.";".$Product_Group_Code.";".$EAN_1.";".$EAN_2.";".$EAN_3.";".$EAN_4.";".$EAN_5.";".$PROVEEDOR.";".$MARCA.";".$FAMILIA.";".$PRECIO_COMPRA_EMP.";".$PVP.";".$TIPO_IVA.";".$TIPO_PRODUCTO.";".$DESCRIPCION_FAMILIA.";".$DESCRIPCION_GRUPO_PRODUCTO.";".$CANTIDAD_PEDIDOS_COMPRA.";".$Fecha_creacion.";".$FECHA_CREACION_FICHERO."\n";
//imprimimos la línea de datos separada por ";"

$linea="        <PRODUCTO>
                <EANS>
                        <EAN>
                                <![CDATA[$EAN_1]]>
                        </EAN>
                </EANS>
                <MARCA><![CDATA[$MARCA]]></MARCA>
                <DESCRIPCIONES>
                        <ATRIBUTO name='NOMBRE'>
                                <TRADUCCION idioma='ES_Milar'>
                                        <![CDATA[$Description]]>
                                </TRADUCCION>
                        </ATRIBUTO>
                </DESCRIPCIONES>
        </PRODUCTO>
";

//$linea.="</PRODUCTOS>";

fwrite($ar,$linea);
}

}
else {
if(isset($customers->Key)) { $Key = $customers->Key; } else { $Key =""; }
if(isset($customers->Item_No)) { $Item_No = $customers->Item_No; } else { $Item_No =""; }
if(isset($customers->Description)) { $Description = $customers->Description; } else { $Description =""; }
if(isset($customers->Blocked_Webshop)) { $Blocked_Webshop = $customers->Blocked_Webshop; } else { $Blocked_Webshop ="0"; }
if(isset($customers->Last_Reported_Inventory)) { $Last_Reported_Inventory = $customers->Last_Reported_Inventory; } else { $Last_Reported_Inventory =""; }
if(isset($customers->Product_Group_Code)) { $Product_Group_Code = $customers->Product_Group_Code; } else { $Product_Group_Code =""; }
if(isset($customers->EAN_1)) { $EAN_1 = $customers->EAN_1; } else { $EAN_1 =""; }
if(isset($customers->EAN_2)) { $EAN_2 = $customers->EAN_2; } else { $EAN_2 =""; }
if(isset($customers->EAN_3)) { $EAN_3 = $customers->EAN_3; } else { $EAN_3 =""; }
if(isset($customers->EAN_4)) { $EAN_4 = $customers->EAN_4; } else { $EAN_4 =""; }
if(isset($customers->EAN_5)) { $EAN_5 = $customers->EAN_5; } else { $EAN_5 =""; }
if(isset($customers->CODIGO_CALBET)) { $CODIGO_CALBET = $customers->CODIGO_CALBET; } else { $CODIGO_CALBET =""; }
if(isset($customers->PROVEEDOR)) { $PROVEEDOR = $customers->PROVEEDOR; } else { $PROVEEDOR =""; }
if(isset($customers->MARCA)) { $MARCA = $customers->MARCA; } else { $MARCA =""; }
if(isset($customers->FAMILIA)) { $FAMILIA = $customers->FAMILIA; } else { $FAMILIA =""; }
if(isset($customers->PRECIO_COMPRA_INTER)) {
$PRECIO_COMPRA_INTER = $customers->PRECIO_COMPRA_INTER;
$PRECIO_COMPRA_INTER=str_replace(".",",",$PRECIO_COMPRA_INTER); //reemplaza puntos . por comas ,
} else {
$PRECIO_COMPRA_INTER ="";
}
if(isset($customers->PRECIO_COMPRA_EMP)) {
$PRECIO_COMPRA_EMP = $customers->PRECIO_COMPRA_EMP;
$PRECIO_COMPRA_EMP=str_replace(".",",",$PRECIO_COMPRA_EMP); //reemplaza puntos . por comas ,
} else {
$PRECIO_COMPRA_EMP ="";
}
if(isset($customers->PVP)) {
$PVP = $customers->PVP;
$PVP=str_replace(".","",$PVP); //reemplaza puntos . por nada
} else {
$PVP ="";
}
if(isset($customers->TIPO_IVA)) { $TIPO_IVA = $customers->TIPO_IVA; } else { $TIPO_IVA =""; }
if(isset($customers->TIPO_PRODUCTO)) { $TIPO_PRODUCTO = $customers->TIPO_PRODUCTO; } else { $TIPO_PRODUCTO =""; }
if(isset($customers->DESCRIPCION_FAMILIA)) { $DESCRIPCION_FAMILIA = $customers->DESCRIPCION_FAMILIA; } else { $DESCRIPCION_FAMILIA =""; }
if(isset($customers->DESCRIPCION_GRUPO_PRODUCTO)) { $DESCRIPCION_GRUPO_PRODUCTO = $customers->DESCRIPCION_GRUPO_PRODUCTO; } else { $DESCRIPCION_GRUPO_PRODUCTO =""; }
if(isset($customers->CANTIDAD_PEDIDOS_COMPRA)) { $CANTIDAD_PEDIDOS_COMPRA = $customers->CANTIDAD_PEDIDOS_COMPRA; } else { $CANTIDAD_PEDIDOS_COMPRA =""; }
if(isset($customers->Fecha_creacion)) { $Fecha_creacion = $customers->Fecha_creacion; } else { $Fecha_creacion =""; }
if(isset($customers->FECHA_CREACION_FICHERO)) { $FECHA_CREACION_FICHERO = $customers->FECHA_CREACION_FICHERO; } else { $FECHA_CREACION_FICHERO =""; }

//$linea=$Item_No.";".$Description.";".$Blocked_Webshop.";".$Last_Reported_Inventory.";".$Product_Group_Code.";".$EAN_1.";".$EAN_2.";".$EAN_3.";".$EAN_4.";".$EAN_5.";".$PROVEEDOR.";".$MARCA.";".$FAMILIA.";".$PRECIO_COMPRA_EMP.";".$PVP.";".$TIPO_IVA.";".$TIPO_PRODUCTO.";".$DESCRIPCION_FAMILIA.";".$DESCRIPCION_GRUPO_PRODUCTO.";".$CANTIDAD_PEDIDOS_COMPRA.";".$Fecha_creacion.";".$FECHA_CREACION_FICHERO."\n";
//imprimimos la línea de datos separada por ";"
$linea="        <PRODUCTO>
                <EANS>
                        <EAN>
                                <![CDATA[$EAN_1]]>
                        </EAN>
                </EANS>
                <MARCA><![CDATA[$MARCA]]></MARCA>
                <DESCRIPCIONES>
                        <ATRIBUTO name='NOMBRE'>
                                <TRADUCCION idioma='ES_MILAR'>
                                        <![CDATA[$Description]]>
                                </TRADUCCION>
                        </ATRIBUTO>
                </DESCRIPCIONES>
        </PRODUCTO>
";

//$linea.="</PRODUCTOS>";

fwrite($ar,$linea);
}

$pie="</PRODUCTOS>";
fwrite($ar,$pie);

fclose($ar);
stream_wrapper_restore('http');

echo "Archivo XML Creado! http://www.sacse.es/csv/sinersis/productos.xml\n";
?>
<?php
$ftp_server="82.159.245.163";
$ftp_user_name="sacse";
$ftp_user_pass="tAy7oed(dxqFc9s";

$file = '/var/www/vhosts/sacse.es/httpdocs/csv/sinersis/productos.xml';
$remote_file = 'productos.xml';

// establecer una conexión básica
$conn_id = ftp_connect($ftp_server);

// iniciar sesión con nombre de usuario y contraseña
$login_result = ftp_login($conn_id, $ftp_user_name, $ftp_user_pass);

//Enable PASV ( Note: must be done after ftp_login() )
$mode = ftp_pasv($conn_id, TRUE);

// cargar un archivo
if (ftp_put($conn_id, $remote_file, $file, FTP_ASCII)) {
 echo "Se ha cargado $file con exito en el servidor ftp remoto $ftp_server\n";
} else {
 echo "Hubo un problema durante la transferencia de $file\n";
}

// cerrar la conexión ftp
ftp_close($conn_id);
?>