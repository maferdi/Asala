<?php

/*
ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);
*/

$onome = $_SESSION["vestou"];

include "assets/conectar.php";

session_start();

$vuser = $_SESSION["nomedousuario"]; //USUÁRIO CONECTADO

$h = "3"; 
$hm = $h * 60;
$ms = $hm * 60;
$gmdata = gmdate("d/m/Y", time()-($ms)); 
$gmhora = gmdate("H:i:s", time()-($ms)); 

$agii = "$gmdata $gmhora";

$titulok = $_POST['titulok'];
$capacidadek = $_POST['capacidadek'];
$infok = $_POST['infok'];
$trancar = $_POST['novocod'];
$xmotivo = "Sala Reportada";
$xdetalhes = $_POST['xdetalhes'];
$descTodos = $_POST['descTodos'];

//CARREGANDO INFO DA SALA
// "SELECT * FROM salas WHERE tag='$onome'"
  $sql="SELECT * FROM salas WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'";
  $res= mysqli_query($con,$sql);
  while($vreg=mysqli_fetch_row($res)){
      $vdono = $vreg[1];
      $vtag = $vreg[2];
      $vtitulo = $vreg[3];
      $vemblema = $vreg[4];
      $vcor = $vreg[5];
      $vcapacidade = $vreg[6];
      $vinfo = $vreg[7];
      $vcriado = $vreg[8];
      $vchat = $vreg[9];
      $vpub = $vreg[12];
      $vpin = $vreg[13];
      $vimg = $vreg[14];
      $vvid = $vreg[15];
      $vsuspender = $vreg[20];
      $nomepub = "pub";
      $um = "1";
      $nomepv = "pv";
      $dct = "dct";
      $zero = "0";
      $on = "on";
}

//ENCURTANDO TITULO DA SALA NA BARRA
$vtituloCurto = substr("$vtitulo", 0, 15); 
$tituloCurto = "$vtituloCurto...";


//
//--- QUANDO O DONO DELETAR A SUA SALA ----
//
$deletar = $_POST['deletar'];

if(!empty($deletar) && ($vuser == $vdono)){
//COLOCANDO TODOS DA SALA EM ZERO E COM DESCONECTAR
$sqlawu="UPDATE mem SET status='" . mysqli_real_escape_string($con, $dct) . "', estou='" . mysqli_real_escape_string($con, $zero) . "' WHERE estou='" . mysqli_real_escape_string($con, $onome) . "'";
$resaw=mysqli_query($con,$sqlawu);

//ZERANDO DONO DA SALA PARA VOLTAR PARA ESTOU="0"
$sqluu="UPDATE mem SET status='" . mysqli_real_escape_string($con, $um) . "' WHERE usuario='" . mysqli_real_escape_string($con, $vdono) . "'";
$resuu=mysqli_query($con,$sqluu);

//COLOCANDO STATUS DE 'DELETADO' NA SALA
$infostatus = "Sala excluida por $vuser em $agii";
$sqlgg="UPDATE salas SET status='deletado', infostatus='" . mysqli_real_escape_string($con, $sqlgg) . "' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'";
$resgg=mysqli_query($con,$sqlgg);

//VERIFICANDO SE A SALA FOI REPORTADA ANTES DE DELETÁ-LA DE FACTO
// "SELECT * FROM report WHERE reportado='$onome'"
$sqlzz="SELECT * FROM report WHERE reportado='" . mysqli_real_escape_string($con, $onome) . "'";
$reszz= mysqli_query($con,$sqlzz);
$linzz= mysqli_num_rows($reszz);

if($linzz == 0){
//DELETANDO SALA NA TABELA DE SALAS SE NÃO HOUVER REPORTACOES
// "DELETE from salas WHERE tag='$onome' AND dono='$vuser'"
$sql11="DELETE from salas WHERE tag='" . mysqli_real_escape_string($con, $onome) . "' AND dono='" . mysqli_real_escape_string($con, $vuser) . "'";
$res11= mysqli_query($con,$sql11);

//DELETANDO TAMBÉM A TABELA DO CHAT NA OUTRA DB
//$sql66="DROP TABLE `$onome`"; // <- antes
$sql66="DROP TABLE '" . mysqli_real_escape_string($con, $onome) . "'"; // <- sql seguro
$res66= mysqli_query($conChat,$sql66);
}

?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/sair.php'"/>
<?php
}



//VERIFICANDO SE A SALA ESTÁ ATIVA OU SUSPENSA
if($vsuspender != $zero){
?>
</div>
<center>
  
<div style="width: 80%; max-width: 450px; overflow: auto; position: absolute; top: 41%; left: 50%;	transform: translate(-50%, -50%);">

<img src="../../../images/logocor.png" width="110px"></img>

<h1 style="font-size: 3.3vh; padding: 0px 10px 0px 10px">
  Sala Indisponível.
</h1>

<div style="font-size: 14px; line-height: 1.2rem">
<b style="font-weight: 900">
  A Sala Não Está Mais Disponível no Twibb.me
</b>

<?php
if($vuser == $vdono){
?>
<br><br>
Para Continuar Usando a Plataforma Corretamente, Consulte Nossos  <a href="#" data-toggle="modal" data-target="#PanelRight">
    Termos de Uso</a> e <a href="#" data-toggle="modal" data-target="#PanelLeft">Política de Privacidade</a>. 
<br><br>
Agradecemos a Sua Compreensão.
<br>
<i>Equipe Twibb.me</i>
</div>
<br><br>
<form method="post" action="" target="_parent">  
  <button type="submit" name="deletar" value="deletar" class="btn btn-text-danger rounded shadowed mr-1 mb-1">
     <font style="font-weight: 600;"> 
     EXCLUIR SALA
     </font> 
   </button>
</form>
<?php
}
?>
</div>
</center>

<?php
}else{
  
  
  
//--- DONO DESCONECTAR TODOS DA SALA ----
if(!empty($descTodos) && ($vuser == $vdono)){
//COLOCANDO TODOS DA SALA EM ZERO E COM DESCONECTAR
$sqlawu="UPDATE mem SET status='" . mysqli_real_escape_string($con, $dct) . "', estou='" . mysqli_real_escape_string($con, $zero) . "' WHERE estou='" . mysqli_real_escape_string($con, $onome) . "'";
$resaw=mysqli_query($con,$sqlawu);

//COLOCANDO APENAS O DONO NA SALA
$sqla1="UPDATE mem SET status='" . mysqli_real_escape_string($con, $um) . "', estou='" . mysqli_real_escape_string($con, $onome) . "' WHERE usuario='" . mysqli_real_escape_string($con, $vdono) . "'";
$resa1=mysqli_query($con,$sqla1);

?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>
<?php
}else{

//
//ENVIANDO DENUNCIA DA SALA
//
if(!empty($xdetalhes)){
$stmt = mysqli_stmt_init($con);
$sqlbbc= "INSERT INTO report (user, reportado, motivo, detalhes, data, status, tratado) VALUES (?,?,?,?,?,'0','0')";
mysqli_stmt_prepare($stmt, $sqlbbc);
mysqli_stmt_bind_param($stmt, "sssss", $vuser, $onome, $xmotivo, $xdetalhes, $agii);
mysqli_stmt_execute($stmt);
$resbbc= mysqli_stmt_get_result($stmt);

//NOTIFICANDO O AUTOR DO REPORT
$sqlpp = "INSERT INTO notif VALUES (NULL,'$vuser','rp','twibbme','$agii')";
mysqli_stmt_prepare($stmt, $sqlpp);
mysqli_stmt_bind_param($stmt, "ss", $vuser, $agii);
mysqli_stmt_execute($stmt);
$respp = mysqli_stmt_get_result($stmt);

?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>
<?php
}

//
//TRANCANDO SALA COM CÓDIGO
//
if(!empty($trancar) && ($vuser == $vdono)){
$sqla="UPDATE salas SET pin='" . mysqli_real_escape_string($con, $trancar) . "' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'";
$resa=mysqli_query($con,$sqla);
?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>
<?php
}

//
//EDITANDO SALA COM NOVOS DADOS
//
if(!empty($titulok) && ($vuser == $vdono)){
if(isset($_POST['privadok']))
{
    $privadok = "pv";
}
else
{
    $privadok = "pub";
}
// $sqly="UPDATE salas SET titulo='$titulok', capacidade='$capacidadek', info='$infok', privado='$privadok' WHERE tag='$onome'"; // <- sql não seguro
$sqly="UPDATE salas SET titulo='" . mysqli_real_escape_string($con, $titulok) . "', capacidade='" . mysqli_real_escape_string($con, $capacidadek) . "', info='" . mysqli_real_escape_string($con, $infok) . "', privado='" . mysqli_real_escape_string($con, $privadok) . "' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'"; // <- sql seguro
$resy=mysqli_query($con,$sqly);

?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>
<?php   
}

//
//VERIFICANDO SE A SALA ESTA TRANCADA PARA EXIBIR "SALA TRANCADA"
//
if($vpin == $zero){
  $est = "Trancar Sala";
}else{
  $est = "Sala Trancada";
}

//
//VERIFICANDO SE A SALA É PUBLICA
//
if($vpub == $nomepub){
  $vpub = '<ion-icon name="chatbubble-ellipses-outline"></ion-icon>
           Público';
  $rrd = "pub";
}else{
  $vpub = '<ion-icon name="eye-off-outline"></ion-icon>
           Privado';
  $rrd = "checked";
}

//
//ADICIONAR FRASE SE NÃO TIVER DESCRICAO NA SALA
//
if(empty($vinfo)){
  $vinfo= "Nenhuma Informação disponível.";
}
?>

<script>$(document).ready(function() { // Carregar Solicitações em 3segs
var carregarsolicitacoes = setInterval(function () {// Pega o Nome de Usuário de quem envia
if($("#pegamsgsdiv")){
var lastid = $( ".lastmsgidget:last")
.val();$.post("assets/sala/pegarmsgs.php", {lastid: lastid},function(data){$("#pegamsgsdiv article").last().append(data);}, "html");
}},2500);}
);
</script>

<script language="javascript">
//
// BLOQUEAR CARACTERES ESPECIAIS QUANDO EDITAR A SALA
//
function validaox( frm )
{
	var apelidoox = frm.apelidoox.value ;
	var msg = "" ;

	if ( apelidoox.search( /[^a-z- 0123456789àáãāäëéêèìïíõóòúùçćč,:)(?!]/i ) != -1 )
	{
		msg += "Caracteres especiais não permitido." ;
		apelidoox = apelidoox.replace( /[^a-z- 0123456789àáãäëéêèìïíõóòúùçćč,:)(?!]/gi , "" ) ;
	}
	if ( msg )
	{
		alert( msg ) ;
		frm.apelidoox.value = apelidoox ;
		return false ;
	}
	return true ;	
}
</script>

<script language="javascript">
// BLOQUEAR CARACTERES ESPECIAIS QUANDO REPORTAR SALA

function validam( frm )
{
	var apelidom = frm.apelidom.value ;
	var msg = "" ;
	if ( apelidom.search( /[^a-z- 0123456789àáãāäëéêèìïíõóòúùçćč)(?!)]/i ) != -1 )
	{
		msg += "Caracteres especiais não permitido." ;
		apelidom = apelidom.replace( /[^a-z- 0123456789àáãäëéêèìïíõóòúùçćč)(?!)]/gi , "" ) ;
	}
	if ( msg )
	{
		alert( msg ) ;
		frm.apelidom.value = apelidom ;
		return false ;
	}
	return true ;	
}
</script>

<script language="javascript">
function validaf( frm )
{
	var inf = frm.inf.value ;
	var msg = "" ;
	if ( inf.search( /[^a-z- àáãāäëéêèìïíõóòúùçćč!?)(,.]/i ) != -1 )
	{
		msg += "Caracteres especiais não permitido." ;
		inf = inf.replace( /[^a-z- àáãäëéêèìïíõóòúùçćč!?)(,.]/gi , "" ) ;
	}
	if ( msg )
	{
		alert( msg ) ;
		frm.inf.value = inf ;
		return false ;
	}
	return true ;	
}
</script>

<script language="javascript">
function validad( frm )
{
	var senhad = frm.senhad.value ;
	var msg = "" ;
	if ( senhad.search( /\s/g ) != -1 )
	{
		msg+= "Não é permitido espaço no Código de Acesso.\n" ;
		senhad = senhad.replace( /\s/g , "" ) ;
	}	
	if ( senhad.search( /[^a-z0-9-áâãàéêèíìïóôõòúüùç]/i ) != -1 )
	{
msg += "Caracteres especiais não permitido." ;
senhad = senhad.replace( /[^a-z0-9-áâãàéêèíìïóôõòúüùç]/gi , "" ) ;
	}
	if ( msg )
	{
		alert( msg ) ;
		frm.senhad.value = senhad ;
		return false ;
	}
	return true ;	
}

</script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

<script>
$(document).ready(function () {
   $('input').keypress(function (e) {
        var code = null;
        code = (e.keyCode ? e.keyCode : e.which);                
        return (code == 13) ? false : true;
   });
});
</script>



<!-- BARRA SUPERIOR DA SALA -->    

<div class="appHeader text-light" style="background: linear-gradient(45deg, rgb(0,64,139), rgb(0,64,139,0.5)); height: auto;">  

<div class="left">
<div style="position: fixed; top: 5px; width: 30vh; height: 20vh; z-index: 9999999999999999999999999;">
<iframe style="border-radius: 10px;" frameborder="0" width="100%" height="100%" src="assets/sala/asala-exibir.php"; ?>"></iframe>
</div>
</div> 
<div class="right">   
<a href="#" data-toggle="modal" data-target="#info">   
<div class="pageTitle">
<?php echo "$tituloCurto"; ?>  
</div>
</a>

<?php
if($vdono == $vuser){
  //EXIBIR BOTAO DE + SE FOR DONO DA SALA
?>
<a href="#" data-toggle="modal" data-target="#addActionSheet" style="padding-right: 10px">    
   <font color="white">
      <ion-icon name="add-circle-outline"></ion-icon>
   </font>
</a>
<?php
}
?>

<a href="#" data-toggle="modal" data-target="#conq">            
<font color="white">
  <ion-icon name="eye-outline"></ion-icon>
</font>
</a>
<iframe style="margin-left: -2px; margin-top: -20px;" frameborder="0" width="41px" height="25px" src="assets/sala/asala-num.php"; ?>"></iframe>
</div>    
</div>

<div style="position: fixed; bottom: 60px; left: 17px; width: 99%;">

<div style="position: fixed; bottom: 70px; left: 20px;">
<a href="javascript:;" class="btn btn-icon btn-secondary rounded" style="width: 35px; height: 35px;" data-toggle="modal" data-target="#addActionSheet">                  
<ion-icon name="add"></ion-icon>    
</a>
</div>
<?php
//VERIFICANDO SE O USER TEM ALGUM AVISO ADMINISTRATIVO 
//NÃO EXIBIR FALE AQUI SE HOUVER AVISOS
// $sqlsp="SELECT * FROM infos WHERE user='$vuser' AND status='$zero'"; // <- sql não seguro
$sqlsp="SELECT * FROM infos WHERE user='" . mysqli_real_escape_string($con, $vuser) . "' AND status='" . mysqli_real_escape_string($con, $zero) . "'"; // <- sql seguro
  $resp= mysqli_query($con,$sqlsp);
  while($vreg=mysqli_fetch_row($resp)){
      $oaviso = $vreg[2];
  }
if(empty($oaviso)){
?>
<iframe style="margin-left: -10px; padding-top: 2px" width="100%" height="50px;" scrolling="no" frameborder="0" src="assets/sala/asala-fale.php"></iframe>
<?php
}
?>
</div>

<div class="message-item" id="pegamsgsdiv" style="height: 100%;  flex-direction: column-reverse; overflow: auto; overflow-x:hidden;"><?php require 'pegarmsgs.php' ; ?>              
</div>


<!-- INFORMAÇÕES DA SALA -->  

<div class="modal fade action-sheet inset" id="info" tabindex="-1" role="dialog" style="z-index: 999999999999999999999;">
 <div class="modal-dialog" role="document">
 <div class="modal-content" style="max-height: 70vh; overflow:auto;">
  <div class="modal-header">
   <h5 class="modal-title">
   <ion-icon name="information-circle-outline"></ion-icon> 
   <span style="margin-left: 5px;">Informações</span></h5>
  </div>
               
<div style="padding: 15px;">
             
<center>
<div class="card">
 <div class="card-body d-flex justify-content-between align-items-end">
<div>
 <div style="margin-left: 0px; margin-top: 5px; text-align: left;">
   <h4 class="card-subtitle" style="font-weight: 800; width: 100%">
    <?php echo "$vpub"; ?> <br> 
    
    <?php
    if($vpin == $zero){
    ?>
          <ion-icon name="earth-outline"></ion-icon>
          <font color="#00EE76" style="font-weight: 700;">
          SALA ABERTA 
          </font>
    <?php
    }else{
    ?>    
         <ion-icon name="lock-closed-outline"></ion-icon>
         <font color="#FF6A6A" style="font-weight: 800;">
         SALA TRANCADA 
          </font>
    <?php 
    }
    ?>
     </h4>    
<h3>
    <?php echo "$vtitulo"; ?>
</h3>
<h4 class="card-subtitle" style="padding-top: 5px">
<font style="font-weight: 800;">
CÓDIGO DA SALA
<ion-icon name="information-circle-outline"></ion-icon>
</font>
<br>
<font color="#1874CD" size="2"><?php echo "$vtag"; ?>
</font>
</h4>
</div>
</div>
<div class="custom-control custom-switch">
<div style="margin-top: -60px; background: <?php echo "$vcor"; ?>; width: 75px; border-radius: 100px;">
 <img src="../../../images/emblemas/<?php echo "$vemblema"; ?>.png" alt="avatar" class="imaged rounded" style="width: 70px; height: 70px;">
</div>
</div>
</div>
</div>
</center>

<center>
<div style="padding: 20px">
  <p style="font-weight: 600">
    <ion-icon name="share-social-outline"></ion-icon>
    Compartilhar Sala
  </p>
                <a href="javascript:;" class="btn btn-icon btn-xl btn-facebook">
                    <ion-icon name="logo-facebook"></ion-icon>
                </a>
                <a href="javascript:;" class="btn btn-icon btn-xl btn-twitter">
                    <ion-icon name="logo-twitter"></ion-icon>
                </a>
                <a href="javascript:;" class="btn btn-icon btn-xl btn-instagram">
                    <ion-icon name="logo-instagram"></ion-icon>
                </a>
                <a href="javascript:;" class="btn btn-icon btn-xl btn-whatsapp">
                    <ion-icon name="logo-whatsapp"></ion-icon>
                </a>
     </div>
</center>
  
<div id="accordionExample3" style="border: 1px solid transparent">
      <div style="margin-left: -20px">
          <button class="btn collapsed" type="button" data-toggle="collapse" data-target="#accordion002">
          <h4 style="font-size: 17px; opacity: 0.9">
         <ion-icon name="help-circle-outline"></ion-icon>
            Ver Detalhes
         </h4>
          </button>
      </div>
                    
      <div id="accordion002" class="accordion-body collapse" style="padding-left: 40px; padding-bottom: 10px" data-parent="#accordionExample3">
           <div class="accordion-content">
              <font size="2">                       
              Sala iniciada por <b>@<?php echo "$vdono"; ?></b>.
               <br>
             Capacidade: <b><?php echo "$vcapacidade"; ?></b> Usuários.
              </font>         
           </div>
      </div>
          
    <div style="margin-left: -20px">
    <button class="btn" type="button" data-toggle="collapse" data-target="#accordion003">
       <h4 style="font-size: 15px; opacity: 0.9">
          <ion-icon name="chatbox-ellipses-outline"></ion-icon>
         Informações
         </h4>
     </button>
    </div>
    <div id="accordion003" class="accordion-body collapse show" style="padding-left: 40px" data-parent="#accordionExample3">
            <div class="accordion-content">
              <font size="2">                       
               <?php echo "$vinfo"; ?>
              </font>     
<?php              
if($vrank > 2){
?>
<br><br>
<font size="2">
<b>Notificações:</b> (0) <br>
<b>Reportado:</b> (0x)
</font>

<?php
}
?>
            </div>
    </div>
</div>
            
<ul class="action-button-list" style="padding-top: 10px; margin-left: -10px">     
<li>     
<a href="pag/ent/sair.php" class="btn btn-list">        
<span style="color: #d80d0ddd; font-weight: 800">  
<ion-icon name="arrow-undo-outline"></ion-icon>
<b> Sair da Sala </b>
</span>              
</a>      
</li>
</ul>
</div>
</div>              
</div>
</div>

<?php 
if($vuser == $vdono){
include "fileupload.php"; //<!--M3-->
   
$imageFile = $_FILES["imageUpload"]; //<!--M3-->
$videoFile = $_FILES["videoUpload"]; //<!--M3-->

$retire = $_POST['retire'];

if(!empty($retire)){
//RETIRANDO IMAGEM EXIBIDA DA SALA
//$sqlxx="UPDATE salas SET imgx='0', vid='0' WHERE tag='$onome'"; // <- sql não seguro
$sqlxx="UPDATE salas SET imgx='0', vid='0' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'"; // <- sql seguro
$resxx=mysqli_query($con,$sqlxx);
?>

<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>

<?php
}

$destrancar = $_POST['destrancar'];

if(!empty($destrancar)){
  
// 
//DESTRANCAR SALA
//

//$sqlm="UPDATE salas SET pin='0' WHERE tag='$onome'"; // <- sql não seguro
$sqlm="UPDATE salas SET pin='0' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'"; // <- sql seguro
$resm=mysqli_query($con,$sqlm);
?>

<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>

<?php
}



//
//EXIBINDO IMAGEM NA SALA POR MEIO DO UPLOAD
//
if(count($imageFile) > 0 && ($vuser == $vdono)){
echo 'WILL START MY NEW UPLOAD';
$file_path = uploadFile($_POST, $_FILES, "imageUpload", $onome);
echo 'WILL FINISH MY NEW UPLOAD WITH ' . $file_path .' AS FILE PATH';
if ($file_path !== 0) {
  echo 'FILEPATH IS NOT NULL.';
  $sqlxx="UPDATE salas SET imgx='/" . mysqli_real_escape_string($con, $file_path) . "' WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'";
    $resxx=mysqli_query($con,$sqlxx); 
}

?>
<meta http-equiv="refresh" content="0; URL='../../../pag/ent/nv.php'"/>
<?php
}

if(count($videoFile) > 0 && ($vuser == $vdono)){//<!--M3-->
$file_path = uploadFile($_POST, $_FILES, "videoUpload", $onome); //<!--M3-->
if ($file_path !== 0) {
    $sqlxx="UPDATE salas SET vid='/" . mysqli_real_escape_string($con, $file_path) . "', media_uploaded_at=now(), vid_begins_at=0, vid_status=true WHERE tag='" . mysqli_real_escape_string($con, $onome) . "'";
    $resxx=mysqli_query($con,$sqlxx); //<!--M3-->
}
}
}

if($vuser != $vdono){
?>
<div class="modal fade action-sheet" id="xreport" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
 <div class="modal-content">
  <div class="modal-header">
   <h5 class="modal-title">Reportar Sala</h5>
  </div>
  
<div class="modal-body" style="padding: 10px;">
<div class="action-sheet-content">
    
<?php
//VERIFICANDO SE O USUARIO DENUNCIOU A SALA
$sqlxs="SELECT * FROM report WHERE reportado='" . mysqli_real_escape_string($con, $onome) . "' AND user='" . mysqli_real_escape_string($con, $vuser) . "'";
$resxs= mysqli_query($con,$sqlxs);
$lixs= mysqli_num_rows($resxs);

if($lixs > 0){
?>
<center>
<b>Recebemos a Sua Denúncia.</b>
<br>
<font style="font-weight: 700; color: rgb(238, 59, 59, 0.8)">
Você Reportou Esta Sala.
</font>
</center>

<?php
}else{
?>

<form name="form1" action="" method="post">
<div class="form-group basic">
<div class="input-wrapper">
<label class="label" for="name3">
  <font size="3" style="color: rgb(238, 59, 59, 0.8)">
   <ion-icon name="alert-circle-outline"></ion-icon>
   Você está denunciando essa sala.
  </font>
<br><br>
<ion-icon name="checkmark-circle-outline"></ion-icon>
Apenas a equipe <b>Twibb.me</b> receberá sua informação.
</label>
<br>
<input type="text" name="xdetalhes" id="apelidom" onblur="validam(document.form1);" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" autocomplete="off" maxlength="380" class="form-control" id="name3" placeholder="Descreva o que está acontecendo:" required="">     
<i class="clear-input">
 <ion-icon name="close-circle"></ion-icon>
</i>
</div>
</div>

<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>

<br>
                              
<div class="form-group basic">
  <button type="submit" 
  class="btn btn-secondary btn-block btn-lg">
    Reportar
  </button>
</div>
                                
</form>

<?php
}
?>
</div>
</div>
</div>
</div>
</div>

<?php     
}

//
//VERIFICANDO SE O USER É DONO DA SALA
//
if($vuser == $vdono){
?>

<div class="modal fade action-sheet" id="ximg" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
  <div class="modal-content">
  <div class="modal-header">
    <h5 class="modal-title">Exibir Imagem Para Todos</h5>
  </div>
                    
<div class="modal-body" style="padding: 10px;">
 <div class="action-sheet-content">

<?php
 if($vimg == $zero){
?>
   
<!--M3 SUBSTITUIDO
<form name="form1" action="" method="post">
<div class="form-group basic">
<div class="input-wrapper">
<label class="label" for="name3">
  Envie uma imagem online por URL.
</label>
<input type="text" name="ourl" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" autocomplete="off" maxlength="280" class="form-control" id="name3" placeholder="https://www..." required="">         
  <i class="clear-input">
   <ion-icon name="close-circle"></ion-ico>
  </i>
</div>
</div>

<div class="custom-control custom-checkbox mb-1">
 <input type="checkbox" class="custom-control-input" id="customCheckb99" required="">
  <label class="custom-control-label" for="customCheckb99" style="line-height: 1rem; font-size: 13px;">
  A imagem está de acordo com  os <a href="#" data-toggle="modal" data-target="#PanelRight">
    Termos de Uso</a> e <a href="#" data-toggle="modal" data-target="#PanelLeft">Política de Privacidade</a>.
  </label>
 </input>          
</div>
  
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  <br>
  <div class="form-group basic">
  <button type="submit" class="btn btn-secondary btn-block btn-lg">
      Exibir
  </button>
  </div>
                                
</form>
-->

<!--M3 BEGINS-->
<form name="form1" action="" method="post" enctype="multipart/form-data"> 
<div class="form-group basic">
<div class="input-wrapper">
<input type="file" class="custom-file-input" id="imageUpload" name="imageUpload">
<label class="custom-file-label" for="imageUpload">Escolha uma Imagem</label>
  <i class="clear-input">
   <ion-icon name="close-circle"></ion-ico>
  </i>
</div>
</div>
<div class="custom-control custom-checkbox mb-1" style="margin-top: 10px;">
 <input type="checkbox" class="custom-control-input" id="customCheckb99" required="">
  <label class="custom-control-label" for="customCheckb99" style="line-height: 1rem; font-size: 13px;">
  A imagem está de acordo com  os <a href="#" data-toggle="modal" data-target="#PanelRight">
    Termos de Uso</a> e <a href="#" data-toggle="modal" data-target="#PanelLeft">Política de Privacidade</a>.
  </label>
 </input>          
</div>
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  <div class="form-group basic">
  <button type="submit" value="Upload" class="btn btn-secondary btn-block btn-lg">
      Exibir Imagem
  </button>
  </div>
</form>
<!--M3 ENDS-->

<?php
}else{
?>
<form name="form1" action="" method="post">
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
<div class="form-group basic">
  <button type="submit" name="retire" value="retire" class="btn btn-secondary btn-block btn-lg">
    Retirar Imagem
  </button>
</div>
</form>
<?php  
}
?>
</div>
</div>
</div>
</div>
</div>
        
<div class="modal fade action-sheet" id="vid" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content">
<div class="modal-header">
  <h5 class="modal-title">Reproduzir Vídeo ao Vivo</h5>
</div>
<div class="modal-body" style="padding: 10px;">
  <div class="action-sheet-content">
   <?php
   if($vvid == $zero){
   ?>
<form name="form1" 
	action=""
	method="post"
	enctype="multipart/form-data"
	id="vid-form"> <!--M5-->
<div class="form-group basic">
<div class="input-wrapper">
<label class="label" for="name3">
 Envie um video para exibir.
</label>
 <input type="file" class="custom-file-input" id="videoUpload" name="videoUpload">
 <label class="custom-file-label" for="videoUpload">Selecione um Vídeo...</label>     
   <i class="clear-input">
    <ion-icon name="close-circle"></ion-icon>
   </i>
			<div id="vid-prog" class="progress active" style="height: 5px; display: none;"> <!--M5-->
				<div id="vid-prog-bar" class="progress-bar btn-primary" style="width: 0%;"></div> <!--M5-->
			</div> <!--M5-->
 </div>
</div>

<center>

<div class="form-group basic">
<button type="submit" value="Upload" class="btn btn-primary" style="width: 55%">
     INICIAR TRANSMISSÃO
</button>
<a href="../../../pag/ent/nv.php" target="_parent" class="btn btn-secondary" style="width: 30%">
      CANCELAR
</a>
 
</div>

  <label style="width: 70%; max-width: 450px; line-height: 1rem; padding-top: 10px; font-size: 13px;">
 Ao '<b>Iniciar Transmissão</b>' Você Confirma Que o Vídeo Está de Acordo Com os <a href="#" data-toggle="modal" data-target="#PanelRight">Termos de Uso</a>  e <a href="#" data-toggle="modal" data-target="#PanelLeft">Política de Privacidade</a>.
 </label>

</center>
<!--M3-ENDS-->

<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  
<!--M5 STARTS-->
<script>
    var bar = document.getElementById('vid-prog-bar');
    $('#vid-form').submit(function(e) {
        e.preventDefault();
        document.getElementById('vid-prog').style.display = 'block';
        $.ajax({
            url: location.href,
            type: 'post',
            enctype: 'multipart/form-data',
            data: new FormData(document.getElementById('vid-form')),
            processData: false,
            contentType: false,            
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener("progress", function(evt) {
                    if (evt.lengthComputable) {
                        var percentComplete = (evt.loaded / evt.total) * 100;
				        bar.style = 'width: ' + percentComplete + '%;';
                    }
               }, false);
               return xhr;
            },
			success: function() {
				bar.style = 'width: 100%;';
                window.location = window.location.href;
			}
        });
    });
</script>
<!--M5 ENDS-->

<?php
}else{
?>

<form name="form1" action="" method="post">
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
<center>
  <p style="font-size: 13px; font-weight: 600; color: #00d15bff">
    Transmitindo Para Todos 
  </p>
</center>
<div class="form-group basic">
<button type="submit" name="retire" value="retire" class="btn btn-secondary btn-block btn-lg">
Encerrar Transmissão
</button>
</div>
</form>
                            
<?php  
}
?>
</div>
</div>
</div>
</div>
</div>
        
<div class="modal fade action-sheet inset" id="edsala" tabindex="-1" role="dialog" style="z-index: 99999999999999999999;">
  <div class="modal-dialog" role="document">
  <div class="modal-content" style="max-height: 70vh; overflow:auto;">
  <div class="modal-header">
   <h5 class="modal-title">
     Editar Sala
    </h5>
  </div>
            
<div class="modal-body" style="padding-top: 10px; padding-left: 5%; padding-right: 5%">
   <div class="action-sheet-content">
      
    <form name="form5" action="" method="post">
    <ul class="listview image-listview" style="padding-top: 10px; border: none;">

  <div class="input-wrapper">
  <label class="label">Título da Sala:</label>
  <input type="text" name="titulok" id="apelidoox" onblur="validaox(document.form5);" class="form-control" maxlength="30" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" autocomplete="off" value='<?php echo "$vtitulo"; ?>' rows="2" class="form-control" style="font-size: 13px; border-radius: 20px"></input>
  </div>
                 
<br>  
     
<div class="input-wrapper">
    <label class="label">Informações:</label>
  <textarea rows="2" name="infok" id="inf" onblur="validaf(document.form5);" class="form-control" maxlength="250" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" autocomplete="off" class="form-control" style="font-size: 13px; font-align: left; border-radius: 20px">
    <?php echo "$vinfo"; ?>
  </textarea>
</div>

<br>

<div class="form-group boxed">
<div class="input-wrapper">
    <label class="label" for="city5">
      Capacidade de Usuários:
    </label>
<select name="capacidadek" class="form-control custom-select" id="city5" style="border-radius: 20px" required="">
   <option selected value="10">10</option>
   <option value="30">30</option>
   <option value="50">50</option>
   <option value="100">100</option>
   <option value="500">500</option>
   <option value="1000">1.000</option>
</select>
</div>
</div>
                  
<div class="custom-control custom-checkbox mb-1">
  <input type="checkbox" name="privadok" value="pv" class="custom-control-input" id="customCheckb4" <?php echo "$rrd"; ?>>
  </input>
                    
  <label class="custom-control-label" for="customCheckb4">
  Sala Privada: (Não será exibida na lista de Salas Públicas do 
  <b>TWIBB.ME</b>).
  </label>
</div>
				
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  
<br>

<center>
<div class="form-group basic">
<button type="submit" class="btn btn-secondary btn-block" style="width: 50%; border-radius: 30px">
  Salvar Alterações
</button>
</div>
</center>
<br>
</ul>
</ul>
</form>
 </div>
 </div>
 </div>
 </div>
</div>
        
<div class="modal fade action-sheet" id="trancar" tabindex="-1" role="dialog">
 <div class="modal-dialog" role="document">
 <div class="modal-content">
<div class="modal-header">
   <h5 class="modal-title"><?php echo "$est"; ?></h5>
</div>
<div class="modal-body" style="padding: 10px;">
<div class="action-sheet-content">

<?php
if($vpin == $zero){
?>

<form name="form8" action="" method="post">
<div class="form-group basic">
<div class="input-wrapper">
<label class="label" for="name3">Crie um Código de Acesso:</label>
<input type="text" name="novocod" onpaste="return false;" autocorrect="off" autocapitalize="off" spellcheck="false" data-gramm="false" autocomplete="off"  maxlength="8" class="form-control" id="senhad" onblur="validad( document.form8 );" placeholder="Máximo 8 caracteres..." required="">      
<i class="clear-input">
 <ion-icon name="close-circle"></ion-icon>
</i>
</div>
</div>
  
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  
<br>
                              
<div class="form-group basic">
   <button type="submit" class="btn btn-secondary btn-block btn-lg">
     Trancar Sala
   </button>
</div>
</form>

<?php
}else{
?>

<form name="form1" action="" method="post">
<div class="form-group basic">
<div class="input-wrapper">
<label class="label" for="name3">Código de Acesso:</label>
<input type="text" name="ourl" maxlength="280" class="form-control" id="name3" value='<?php echo "$vpin"; ?>' disabled="">
</div>
</div>
           
<input type="hidden" value='<?php echo "$vuser"; ?>' name="ouser"></input>
  
<br>
                              
<div class="form-group basic">
<button type="submit" name="destrancar" value="destrancar" class="btn btn-secondary btn-block btn-lg">Destrancar Sala
</button>
</div>
                                
</form>
                            
<?php  
}
?>
          
</div>
</div>
</div>
</div>
</div>

<div class="modal fade dialogbox" id="pausar" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content" style="padding-top:  20px;">
    <div class="modal-header" style="padding-bottom: 15px;">
       <h5 class="modal-title">
       Pausar
       </h5>
    </div>
<div class="modal-body" style="line-height: 1rem; padding-left: 20px; padding-right: 20px">
  
<?php 
if($vchat == $on){
?>
Pausar Chat da Sala?
<?php
}else{
?>
O Chat Está Pausado.
<?php
}
?>
</div>
<form action="../../../pag/ent/nv.php"  method="post">
<input type="hidden" value='<?php echo "$vuser"; ?>' name='ouser'> 
<div class="modal-footer">
<div class="btn-inline">
<?php 
if($vchat == $on){
?>
<button type="submit" name="pausar" value='<?php echo "$onome"; ?>' href="" class="btn btn-text-primary btn-block">
 PAUSAR CHAT
</button>
<?php 
}else{
?>
<button type="submit" name="despausar" value='<?php echo "$onome"; ?>' href="" class="btn btn-text-primary btn-block">
LIBERAR CHAT
</button>
<?php
}
?>
</div>
</div>
</form>
</div>
</div>
</div>
 
<div class="modal fade dialogbox" id="deletar" tabindex="-1" role="dialog">
<div class="modal-dialog" role="document">
  <div class="modal-content" style="padding-top:  20px;">
    <div class="modal-header" style="padding-bottom: 15px;">
       <h5 class="modal-title">
       Excluir Sala
       </h5>
    </div>
<div class="modal-body" style="line-height: 1rem; padding-left: 20px; padding-right: 20px">
  Deletar a Sala Totalmente?
</div>
<form action="" method="post">
<input type="hidden" value='<?php echo "$vuser"; ?>' name='ouser'> 
<div class="modal-footer">
<div class="btn-inline">
<a href=""  class="btn btn-text-primary" data-dismiss="modal">
 CANCELAR
</a>
<button type="submit" name="deletar" value="deletar" href="" class="btn btn-text-danger btn-block">
 DELETAR AGORA
</button>
</div>
</div>
</form>
</div>
</div>
</div>
        
<?php
}
}
}
?>
