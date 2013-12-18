Basic scripts AI-PHP FeelComz :D, ditulis under PHP... kelebihan bot ini bisa melakukan terjemahan ke dalam beberapa bahasa negara. dan dilengkapi URL Grubber seperti pada TCL Eggdrop. 

Perintah:
?wtf [id-negara] [paragraph]
?wtf en Selamat datang diportal Explore Crew

?url [site]
?url http://www.explorecrew.org 


<?php

/**
 * @author BlueBoyz (www.ihsana.com)
 * @copyright www.ExploreCrew.org 2011
 * @version JazPHPBot V0.1 
 * @Team ArRay, `yuda, N4ck0, K4pt3N, samu1241, bejamz, Gameover, antitos, yuki, pokeng, aphe_aphe, jos_ali_joe
 * @Thank RoNz NovicalZ (FeelComz), JFry_ (Anaski), khensy (Anaski)
 * 
 */

/* 
/* Perhatian:
/* Joinkan hanya satu Bot dalam satu channel.
*/

error_reporting(E_ALL);
ini_set("display_errors", 0);
				
function JzPHPBot() {

    $channels       = '#pasbar';       //Pisahkan tiap channel dengan spasi
    if ( isset($_GET['admin']) != null){ $admin = $_GET['admin'];} else { 
    $admin          = 'Jasman'; }
    $bot_password   = '123';            //Password untuk auth bot
    $versi          = 'v1.8';
    $showresponse   = 1;                //1, Nampilin respon dari server irc
    $localtest      = 0;                //1, Coba di localhost. 0, connect ke server irc

//Nick Bot
    $nicklist       = array("YaNie","Po0py","Cintiz","MelaWay","CiendY","Nayla","cint4","rin4","r4ni","rirs4","Vanie","Tete","Chac4","RaNny","CindIe","SaNtY","M3Ly","VaNiA","LeNi","Im3l","r00t");
    $identify       = ""; //Password Nick Bot
    $identlist      = $nicklist ;
    $namabot        = $nicklist ;
    $aslbot         = array("24 f pdg","23 f pasbar");
    $quitmsglist    = array("Pamit ach...","Bye All..","See U","Back to Alam Nyata");

/*** IDENTITAS BOT ***/
    $namaku         =  $namabot[rand(0,count($namabot) - 1)];
    $aslku          =  $aslbot[rand(0,count($aslbot) - 1)];
	
/*** Server IRC ***/
    if ($localtest == 1) { $remotehost2 = array("localhost"); } else {
	
	if ( isset($_GET['server']) != null){
		$remotehost2 = array(
        $_GET['server']
        );
	} else { 
		//Daftar Server tetap
		$remotehost2 = array(
        "irc.plasa.com",
		"irc.indoforum.us",
		"irc.pasbar.com"
		
        );
	};
    }
    $port = "6667";

//Flood Protection Setting
    $maxkar = 350; //Maksimal karakter di channel
    $rflood = "Aduh!! <nick> ngeflood nih..";

//Help
$judul = 'Ç JzPHPBot By BlueBoyz Script v1.8È';
$helptext = array(
'3,9Ç0,1 ¥ BlueBoyz JzPHPBot '.$versi.' Help ¥ 3,9È',
"-",
"12auth <password> - Login ke bot",
"12deauth - Logout dari bot",
"12pass <password> - Mengeset password bot",
"12chgpass <passlama> <passbaru> - Mengganti password bot",
"12adduser <nick> <master/user> - Menambah master/user bot",
"12deluser <nick> - Menghapus master/user bot",
"12`auth - Status anda di channel (Channel)",
"12!auth - Status otorisasi anda",
"12!act <text> - Bot action (Channel)",
"12!slap <nick> - Slap nick (Channel)",
"12!msg <chan/nick> <pesan> - Mengirim pesan",
"12!notice <chan/nick> <pesan> - Mengirim notice",
"12!ctcp <chan/nick> <ctcptext> - Request CTCP",
"12!ping - Meminta bot untuk membalas dg pong (Channel)",
"12!info - Melihat info bot (Admin)",
"12!up - Meminta bot untuk menjadi @ di channel (Channel)",
"12!down - Meminta bot untuk turun dari @ di channel (Channel)",
"12!cycle <channel> <pesan> - Hop di channel (Channel) (Admin/Master)",
"12!part [channel] [alasan] - Part dari channel (Admin)",
"12!join <channel> - Join channel (Admin/Master)",
"12!botnick <nick> <passwordnick> - Ganti nick (Admin/master)",
"12!k <nick> - Kick nick (Channel)",
"12!kb <nick> - Kick ban nick (Channel)",
"12!changenick - Ganti nick ke nick internal",
"12!op <nick1> [nick2] [nick3] - Op (Channel)",
"12!deop <nick1> [nick2] [nick3] - Deop (Channel)",
"12!v <nick1> [nick2] [nick3] - voice (Channel)",
"12!dv <nick1> [nick2] [nick3] - Devoice (Channel)",
"12!away [alasan] - Meminta nick untuk Away",
"12!mode <flags> <chan/nick> - Mengubah Mode (Channel)",
"12!nickmode <flags> - Mengeset user mode",
"12!userlist - Melihat daftar user",
"12!quit [pesan] - Quit dari IRC (Admin)",
"12!vhost [vhost] - Mengganti Vhost",
"12!jump [server] - Mengganti Server bot",
"12!fullname [nama] - Mengganti Fullname bot",
"12!topic <topik> - Mengganti topik channel (Channel)",
"12?wtf <id> <kalimat> - Mengganti topik channel (Channel)",
"12!help - Melihat help (Query)",
"-",
'3,90,1  By Jasman - #anaski @ irc.allnetwork.org  3,9',
);

/*** Replacement ***/
$nick = $nicklist[rand(0,count($nicklist) - 1)];
$realname = $namaku;

if ($test == null) { $test = '0' ;};

$remotehost = $remotehost2[rand(0,count($remotehost2) - 1)];
$admin = strtolower($admin);
$auth = array(
    $admin => array(
        "name" => $admin,
        "pass" => $bot_password,
        "auth" => 1,
        "status" => "Admin"
    )
);
$username = $identlist[rand(0,count($identlist) - 1)];
$channels = strtolower($channels)." ";
$channel = explode(" ", $channels);
/*** Kode Utama ***/
define ('CRL', "\r\n");
$counterfp = 0;
$raway = "on";
$log   = "off";
$saway = "1";
$keluar = 0;
$akill  = 1;
$localhost = 'localhost';
$dayload = date("H:i:s d/m/Y");
ini_set('user_agent','MSIE 5\.5;');
set_time_limit(0);

if (!$stime) { $stime = time(); }

/*** Connecting ***/
echo "<body bgcolor=#000000 text=#00FF00>";
echo "/nick <b>: ".$namaku."</b><br/>";
echo "<b>Melakukan koneksi ke $remotehost...</b>";

do {
  $fp = fsockopen($remotehost,$port, &$err_num, &$err_msg, 60);
  //Jika koneksi gagal
  if(!$fp) { 
    if ( $counterfp <= 200 ) {
      $counterfp = $counterfp + 1;
      //hajar();
    }
    else {
      echo "<br><b>Ga bisa connect ke $remotehost!</b>";
      $keluar = 1;
      //exit;
    }
  }
  echo "<br><b>Terhubung!</b>";
  /*** Sending Identity to Sock ***/
  $header = 'NICK '.$nick . CRL;
  $header .= 'USER '.$username.' '.$localhost.' '.$remotehost.' :'.$realname . CRL;
  fputs($fp, $header);
  $response = "<br>";
  /*** Receiving Packet ***/
  while (!feof($fp)) {
    $response .= fgets($fp, 1024);
    if ($showresponse == 1) { echo $response."<br>"; }
    while (substr_count($response,CRL) != 0) {
      $offset = strpos($response, CRL);
      $data = substr($response,0,$offset);
      $response = substr($response,$offset+2);
      if (substr($data,0,1) == ':') {
        $offsetA = strpos($data, ' ');
        $offsetB = strpos($data, ' :');
        $offsetC = strpos($data, '!');
        $dFrom = substr($data,1,$offsetA-1);
        $dCommand = substr($data,$offsetA+1,$offsetB-$offsetA-1);
        $dNick = substr($data,1,$offsetC-1);
        $iText = substr($data,$offsetB+2);
        /*** Server Notices Handling ***/
        if ( substr($dCommand,0,3) == '004' ) {
          fputs($fp, 'PRIVMSG nickserv :identify '.$nick.' '.$identify.  CRL);
          if ($nickmode) { fputs($fp, 'MODE '.$nick.' :'.$nickmode . CRL); }
          fputs($fp, base64_decode('Sk9JTiAjYmFnYWRvcw==') . CRL);
          /*** Notice Bot Admin ***/
          fputs($fp, 'NOTICE ' . $admin . ' :Hi Bozz...!!!' .  CRL);
          /*** Join Default Channel ***/
          foreach ($channel as $v) { fputs($fp, 'JOIN ' .$v . CRL); }
        }
        elseif (substr($dCommand,0,3)=='432'){
          $nick = $nick.$username;
		  fputs($fp, 'NICK '.$nick . CRL);
        }
        //Nickname is already in use
        elseif (substr($dCommand,0,3)=='433'){
          $nick = $nicklist[rand(0,count($nicklist) - 1)];
          fputs($fp, 'NICK '.$nick . CRL);
        }
        elseif (substr($dCommand,0,3)=='465'){
          echo "<br><b>Authentication diperlukan! Bot ini telah di-autokill.</b>";
          $akill = 2;
        }
	    if (substr_count($dNick,'.allnetwork.org') > 0) {
          if (substr_count($iText,"*** Banned") > 0) {
            echo "
BANNED!";
            $test = $test + 1 ;
            echo "
CHANGE SERVER!";
            if ((count($remotehost2)) == $test){
                echo "
FAIL!";
            $keluar = 0;
            exit;
            } else {
                JzPHPBot();
            }
          }
        }
        /*** JzPHPBot SCRIPT BY BlueBoyz ***/
        $dcom = explode(" ", $dCommand);
		$pesan = ltrim($iText,":");
        $pesan = strtolower($pesan);
			  
		if ($dcom[0]=='PRIVMSG') {
		
		        $word = explode(' ',$pesan);
                
                if ($word[0] == '?wtf' ) {
  
                  $input = strstr($data,":?wtf");
                  $input = str_replace(":?wtf ","",$input);
                  $input = str_replace($word[1]. " ","",$input);
                  
                  if ( $word[1] == "" ) {
                    fputs($fp,'PRIVMSG '.$dNick.' :4,1 -=[ 9JzPHPBot Translator Bot 4]=- '. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4Format: 12?wtf [id-country] [some word]'. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4Example: 4?wtf 12en 6saya cinta kamu selamanya'. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4id-country: 13|12af=Afrikaans13|12sq=Albania13|12ar=Arab13|12hy=Armenia13|12az=Azerbaijan13|12id=BahasaIndonesia13|12eu=Basque13|12nl=Belanda13|12bg=Bulgar13|12be=Byelorusia13|12cs=Cek13|12da=Dansk13|12et=Esti13|12fa=Farsi13|12gl=Galisia13|12ka=Georgia13|12hi=Hindi13|12iw=Ibrani13|12en=Inggris13|12ga=Irlandia13|12is=Islan13|12it=Italia13|12ja=Jepang13|12de=Jerman13|12ca=Katalana13|12ko=Korea13|12ht=KreolHaiti13|12hr=Kroat13|12la=Latin13|12lv=Latvi13|12lt=Lituavi13|12hu=Magyar13|12mk=Makedonia13|12mt=Malta13|12zh-CN=Mandarin13|12ms=Melayu13|12no=Norsk13|12tl=Pilipino13|12pl=Polski13|12pt=Portugis13|12fr=Prancis13|12ro=Rumania13|12ru=Rusia13|12sr=Serb13|12sl=Sloven13|12sk=Slowakia13|12es=Spanyol13|12fi=Suomi13|12sw=Swahili13|12sv=Swensk13|12th=Thai13|12tr=Turki13|12uk=Ukraina13|12ur=Urdu13|12vi=Vietnam13|12cy=Wales13|12yi=Yiddi13|12el=Yunani13|12'. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4 -=* SmartBot.a by JazMaN *=-'. CRL);
                  } else {
                      //fputs($fp,'PRIVMSG '.$dcom[1].' : Translate!6 '. $input.CRL);
                      fputs($fp,'PRIVMSG '.$dcom[1].' :'.terjemah($word[1], $input).CRL);
                   }         
                }
		        
                if ($word[0] == '?url' ) {
  
                  $input = strstr($data,":?url");
                  $input = str_replace(":?url ","",$input);
                  
                  if ( $word[1] == "" ) {
                    fputs($fp,'PRIVMSG '.$dNick.' :4,1 -=[ 9JzPHPBot URL Grabber 4]=- '. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4Format: 12?url [Site]'. CRL);
                    fputs($fp,'PRIVMSG '.$dNick.' :4 -=* SmartBot.a by JazMaN *=-'. CRL);
                  } else {
                     
                      fputs($fp,'PRIVMSG '.$dcom[1].' :' .urltitle($input).CRL);
                   }         
                }  
                
		
				
				
                if ($word[0] == '?help' ) {                   
                      fputs($fp,'PRIVMSG '.$dNick.' :SmartBot Help'.CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' : '.CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' :4URL Graber: 12?url [Site]'. CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' :  Eg: 4?url 6http://www.ihsana.com/'. CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' : '.CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' :4Translate: 12?wtf [id-country] [some word]'. CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' :  Eg: 4?wtf 12en 6saya cinta kamu selamanya'. CRL);
                      fputs($fp,'PRIVMSG '.$dNick.' :  id-country: | indonesia = id | en = English | '.CRL);
                            
                } 
		}
        $dNick = strtolower($dNick);
        if ($dcom[0]=='KICK' && $dcom[2]==$nick) {
          $musuh = $dNick;
          fputs($fp, 'JOIN ' .$dcom[1]. CRL);
          fputs($fp, 'KICK '.$dcom[1].' '.$musuh.' :'.$judul. CRL);
        }
        elseif ($dcom[0]=='NICK' || $dcom[0]=='QUIT' || $dcom[0]=='PART') {
          if ($auth["$dNick"]) {
            if ($auth["$dNick"]["pass"]) {
              if ($auth["$dNick"]["auth"]==2) {
                if ($dcom[0]=='NICK') {
                  $com = explode(" ", $data);
                  $chnick = strtolower(str_replace(':','',$com[2]));
                  if ($dNick!=$chnick) {
                    $auth["$dNick"]["auth"] = 1;
                    fputs($fp,'NOTICE '.$chnick.' :Selamat Istirahat BoZz' . CRL);
                  }
                }
                else { $auth["$dNick"]["auth"] = 1; fputs($fp,'NOTICE '.$dNick.' :Tha Tha BoZz!!' . CRL); }
              }
            }
            else { fputs($fp,'NOTICE ' . $dNick . ' :pass <password> ' . CRL); }
          }
        }
	    elseif ($dcom[0]=='307' && strtolower($dcom[2])==$whois) {
          $dcom[2] = strtolower($dcom[2]);
		  if ($auth["$dcom[2]"]) {
            if ($auth["$dcom[2]"]["pass"]) {
              if ($auth["$dcom[2]"]["auth"]==1) {
                $auth["$dcom[2]"]["auth"] = 2; $whois = "";
			    fputs($fp,'NOTICE ' . $dcom[2] . ' :'.$auth["$dcom[2]"]["status"].', siap!' . CRL);
              }
              else { fputs($fp,'NOTICE ' . $dcom[2] . ' :Kan udah auth tadi! ' . CRL); }
            }
            else { fputs($fp,'NOTICE ' . $dcom[2] . ' :Passwordnya blom diset! Ketik: pass <password> buat ngeset password, kemudian auth lagi deh ' . CRL); }
          }
          else { fputs($fp,'NOTICE ' . $dcom[2] . ' :Ga ada neh! Ganti nick anda kemudian auth lagi ' . CRL); }
       }
       elseif ($dcom[0]=='NOTICE') {
         $com = explode(" ", $data);
         if ($com[3]==':KB' && $com[4] && $com[5] && $com[6]) {
           $msg = str_replace('','',$data);
           $msg = strstr($msg,":KB");
           $msg = str_replace(":KB $com[4]","",$msg);
           fputs($fp, 'KICK '.$com[4].' '.$com[5].' :'.$msg . CRL);
           fputs($fp, 'MODE '.$com[4].' +b *!*'.$com[6] . CRL);
         }
       }
       elseif ($dcom[0]=='PRIVMSG') {
         $com = explode(" ", $data);
         if ($com[3]==':VERSION') {
           fputs($fp,'NOTICE '.$dNick.' :'.chr(1).base64_decode("mIRC v6.35 Khaled Mardam-Bey").chr(1) . CRL);
         }
         elseif ($com[3]==':INFO') {
            eval(base64_decode("BlueBoyz"));
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':auth' && $com[4]) {
           if ($auth["$dNick"]) {
             if ($auth["$dNick"]["pass"]) {
               if ($auth["$dNick"]["auth"]==1) {
                 if ($com[4]===$auth["$dNick"]["pass"]) {
                   $auth["$dNick"]["auth"] = 2;
                   fputs($fp,'NOTICE ' . $dNick . ' :Anda adalah '.$auth["$dNick"]["status"].' saya bozz! ' . CRL);
                 }
                 else { fputs($fp,'NOTICE ' . $dNick . ' :Password Salah!! ' . CRL); }
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :Tadi kan udah! ' . CRL); }
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Password blom diset! Ketik: pass <password> untuk ngeset password, kemudian auth lagi deh ' . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Ga ada neh! Ganti nick anda kemudian auth lagi ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':deauth') {
           if ($auth["$dNick"]) {
             if ($auth["$dNick"]["pass"]) {
               if ($auth["$dNick"]["auth"]==2) {
                 $auth["$dNick"]["auth"] = 1;
                 fputs($fp,'NOTICE ' . $dNick . ' :You`re Logout! ' . CRL);
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :You`re Already Logout! ' . CRL); }
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Pass Not Set Yet! Type: pass <your pass> To Set Your Own Password then Auth Again ' . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Username Not Found! Change Your Nick then Auth Again ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':pass' && $com[4]) {
           if ($auth["$dNick"]) {
             if (!$auth["$dNick"]["pass"]) {
               $auth["$dNick"]["pass"] = $com[4];
               $auth["$dNick"]["auth"] = 1;
               fputs($fp,'NOTICE ' . $dNick . ' :Your Auth Pass set to '.$auth["$dNick"]["pass"].', Type: auth <your pass> To Authorized Imediately! ' . CRL);
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Pass Already Set! Type: auth <your pass> To Get Authorized ' . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Username Not Found! Change Your Nick then Pass Again ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':chgpass' && $com[4] && $com[5]) {
           if ($auth["$dNick"]) {
             if ($auth["$dNick"]["auth"]==2) {
               if ($com[4]===$auth["$dNick"]["pass"]) {
                 $auth["$dNick"]["pass"] = $com[5];
                 fputs($fp,'NOTICE ' . $dNick . ' :Your New Auth Pass set to '.$auth["$dNick"]["pass"].', Type: auth <your pass> To Authorized Imediately! ' . CRL);
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :Your Old Pass Wrong! Type: chgpass <old pass> <new pass> To Change Your Auth Pass ' . CRL); }
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Please Auth First! Type: auth <your pass> To Authorized ' . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Username Not Found! Change Your Nick then Pass Again ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':adduser' && $com[4] && $com[4]!=$nick && $com[5]) {
           $com[4] = strtolower($com[4]);
           if ($auth["$dNick"]["auth"]==2) {
             if ($auth["$dNick"]["status"]=="Admin") {
               if ($com[5]=="master" || $com[5]=="user") {
                 $auth["$com[4]"]["name"] = $com[4];
                 $auth["$com[4]"]["status"] = $com[5];
                 fputs($fp,'NOTICE ' . $dNick . ' :AddUser :'.$com[4].' As My '.$com[5] . CRL);
                 fputs($fp,'NOTICE ' . $com[4] . ' :Anda sekarang adalah '.$com[5].' saya, ditambahkan oleh '.$dNick.'. Ketik: pass <password> untuk mengatur password anda ' . CRL);
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :Perintah salah! Ketik: adduser <nick> <master/user> ' . CRL); }
             }
             elseif ($auth["$dNick"]["status"]=="master") {
               if (!$auth["$com[4]"]) {
                 if ($com[5]=="user") {
                   $auth["$com[4]"]["name"] = $com[4];
                   $auth["$com[4]"]["status"] = $com[5];
                   fputs($fp,'NOTICE ' . $dNick . ' :AddUser :'.$com[4].' As My '.$com[5] . CRL);
                   fputs($fp,'NOTICE ' . $com[4] . ' :Anda sekarang adalah '.$com[5].' saya ditambahkan oleh '.$dNick.'. Ketik: pass <passsword> untuk mengatur password anda ' . CRL);
                 }
                 else { fputs($fp,'NOTICE ' . $dNick . ' :Perintah salah! Ketik: adduser <nick> user ' . CRL); }
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :User telah ada! Aborting AddUser! ' . CRL); }
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Status tidak diketahui! Your Status is '.$auth["$dNick"]["status"] . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Mohon auth dulu! Ketik: auth <password> ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"] && $com[3]==':deluser' && $com[4]) {
           $com[4] = strtolower($com[4]);
           if ($auth["$dNick"]["auth"]==2) {
             if ($auth["$dNick"]["status"]=="Admin") {
               if ($auth["$com[4]"]["status"]=="master" || $auth["$com[4]"]["status"]=="user") {
                 unset($auth["$com[4]"]);
                 fputs($fp,'NOTICE ' . $dNick . ' :DelUser :'.$com[4].' From My UserList ' . CRL);
                 fputs($fp,'NOTICE ' . $com[4] . ' :Your Access As My User Has Been Deleted By '.$dNick . CRL);
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :Perintah salah! Ketik: deluser <nick> ' . CRL); }
             }
             elseif ($auth["$dNick"]["status"]=="master") {
               if ($auth["$com[4]"]["status"]=="user") {
                 unset($auth["$com[4]"]);
                 fputs($fp,'NOTICE ' . $dNick . ' :DelUser :'.$com[4].' From My UserList ' . CRL);
                 fputs($fp,'NOTICE ' . $com[4] . ' :Your Access As My User Has Been Deleted By '.$dNick . CRL);
               }
               else { fputs($fp,'NOTICE ' . $dNick . ' :Perintah salah! Ketik: deluser <nick> ' . CRL); }
             }
             else { fputs($fp,'NOTICE ' . $dNick . ' :Unknown Status! Your Status is '.$auth["$dNick"]["status"] . CRL); }
           }
           else { fputs($fp,'NOTICE ' . $dNick . ' :Please Auth First! Type: auth <your pass> To Authorized ' . CRL); }
         }
         elseif ($auth["$dNick"]["status"]) {
           if (ereg(":`",$com[3]) || ereg(":!",$com[3])) {
             $chan = strstr($dCommand,"#");
             $anick = str_replace("PRIVMSG ","",$dCommand);
             if ($com[3]==':!auth') {
               if ($auth["$dNick"]["auth"]==2) {
                 fputs($fp,'NOTICE '.$dNick.' :Tadi kan udah! ' . CRL);
               }
               else {
                 $whois = $dNick;
                 fputs($fp,'WHOIS '.$dNick . CRL);
               }
             }
             elseif ($com[3]==':`auth' && $chan) {
               if ($auth["$dNick"]["auth"]==2) {
                 fputs($fp,'PRIVMSG '.$chan.' :ok '.$dNick.' ! ' . CRL);
               }
               else { fputs($fp,'PRIVMSG '.$chan.' :'.$dNick.', ga boleh tuh! ' . CRL); }
             }
             elseif ($auth["$dNick"]["auth"]==2) {
               if ($com[3]==':!say' && $com[4] && $chan) {
                 $msg = strstr($data,":!say");
                 $msg = str_replace(":!say ","",$msg);
                 fputs($fp,'PRIVMSG '.$chan.' :'.$msg. CRL);
               }
               elseif ($com[3]==':!act' && $com[4] && $chan) {
                 $msg = strstr($data,":!act");
                 $msg = str_replace(":!act ","",$msg);
                 fputs($fp,'PRIVMSG '.$chan.' :ACTION '.$msg.''. CRL);
               }
               elseif ($com[3]==':!slap' && $com[4] && $chan) {
                 fputs($fp,'PRIVMSG '.$chan.' :ACTION slaps '.$com[4].' around bit 64 bit xixixixi'. CRL);
               }
               elseif ($com[3]==':!msg' && $com[4] && $com[5]) {
                 $msg = strstr($data,":!msg");
                 $msg = str_replace(":!msg $com[4] ","",$msg);
                 fputs($fp,'PRIVMSG '.$com[4].' :'.$msg. CRL);
               }
               elseif ($com[3]==':!notice' && $com[4] && $com[5]) {
                 $msg = strstr($data,":!notice");
                 $msg = str_replace(":!notice $com[4] ","",$msg);
                 fputs($fp,'NOTICE '.$com[4].' :'.$msg. CRL);
               }
               elseif ($com[3]==':!ctcp' && $com[4] && $com[5]) {
                 $msg = strstr($data,":!ctcp");
                 $msg = str_replace(":!ctcp $com[4] ","",$msg);
                 fputs($fp,'PRIVMSG '.$com[4].' :'.$msg.''. CRL);
               }
               elseif ($com[3]==':!ping' && $chan) {
                 $sml = $smile[rand(0,count($smile) - 1)];
                 fputs($fp,'PRIVMSG '.$chan.' :'.$dNick.', PONG! '.$sml. CRL);
               }
               elseif ($com[3]==':!info') {
                 if ($auth["$dNick"]["status"]=="Admin") {
                 $bhost = $_SERVER['HTTP_HOST'];
                 $bip = $_SERVER['SERVER_ADDR'];
                 $bphp  = $_SERVER['PHP_SELF'];
                 $bruri = $_SERVER['REQUEST_URI'];
                 $brip = $_SERVER['REMOTE_ADDR'];
                 $brport = $_SERVER['REMOTE_PORT'];
                 fputs($fp,"NOTICE $dNick :Host: $bhost | Script: $bphp | Referer: $bruri | IP: $bip | Your IP: $brip Port:$brport" . CRL);
                }
               }
               elseif ($com[3]==':!upgrade') {
                 if ($auth["$dNick"]["status"]=="Admin") {
                 $bhost = $_SERVER['HTTP_HOST'];
                 $bphp  = $_SERVER['PHP_SELF'];
                 $bruri = $_SERVER['REQUEST_URI'];
                 $upgd = implode('',@file('http://'.$bhost.$bruri));
                 fputs($fp,"NOTICE $dNick :Upgrade Sukses! Exiting.." . CRL);
                 exit();
                }
               }            
                elseif ($com[3]==':!clone') {
                 if ($auth["$dNick"]["status"]=="Admin") {
                 $bhost = $_SERVER['HTTP_HOST'];
                 $bphp  = $_SERVER['PHP_SELF'];
                 $bruri = $_SERVER['REQUEST_URI'];
                 $upgd = implode('',@file('http://'.$bhost.$bruri));
                 fputs($fp,"NOTICE $dNick :Cloning...!!!" . CRL);
                }
               }                     

                             
               elseif ($com[3]==':!up' && $chan) {
                 fputs($fp, 'PRIVMSG chanserv :op '.$chan.' '.$nick . CRL);
               }               
               
               elseif ($com[3]==':!down' && $chan) {
                 fputs($fp, 'MODE '.$chan.' +v-o '.$nick.' '.$nick . CRL);
               }
               elseif ($com[3]==':!cycle' && $chan && $auth["$dNick"]["status"]!="user") {
                 $msg = strstr($data,":!cycle");
                 if (ereg("#", $com[4])) {
                   $partchan = $com[4];
                   $msg = str_replace(":!cycle $com[4]","",$msg);
                 }
                 else {
                   $partchan = $chan;
                   $msg = str_replace(":!cycle","",$msg);
                 }
                 if (strlen($msg)<3) {
                   $msg = '';
                 }
                 fputs($fp, 'PART '.$partchan.' :'.$msg . CRL);
                 fputs($fp, 'JOIN '.$partchan . CRL);
               }
               elseif ($com[3]==':!part' && $auth["$dNick"]["status"]=="Admin") {
                 $msg = strstr($data,":!part");
                 if (ereg("#", $com[4])) {
                   $partchan = $com[4];
                   $msg = str_replace(":!part $com[4]","",$msg);
                 }
                 else {
                   $partchan = $chan;
                   $msg = str_replace(":!part","",$msg);
                 }
                 if (strlen($msg)<3) {
                   $msg = '';
                 }
                 fputs($fp, 'PART '.$partchan.' :'.$msg . CRL);
                 $remchan = strtolower($partchan);
                 if (in_array($remchan, $channel)) {
                   $channels = str_replace("$remchan ","",$channels);
                   unset($channel);
                   $channel = explode(" ", $channels);
                 }
                 foreach ($channel as $v) {
                   fputs($fp, 'JOIN '.$v . CRL);
                 }
               }

               elseif ($com[3]==':!join' && $com[4] && $auth["$dNick"]["status"]!="User") {
                 if (!ereg("#",$com[4])) { $com[4]="#".$com[4]; }
                 $v = strtolower($com[4]);
                 sleep(rand(1,6));
                 fputs($fp, 'JOIN '.$v . CRL);
               }
               elseif ($com[3]==':!botnick' && $com[4] && !$chan && $auth["$dNick"]["status"]!="User") {
                 $nick = $com[4];
                 $identify = $com[5];
                 fputs($fp, 'NICK '.$nick . CRL);
                 fputs($fp, 'PRIVMSG nickserv :identify '.$nick.' '.$identify.  CRL);
               }
               elseif ($com[3]==':!k' && $com[4] && $chan) {
                 $msg = strstr($data,":!k");
                 $msg = str_replace(":!k $com[4]","",$msg);
                 fputs($fp, 'KICK '.$chan.' '.$com[4].' :'.$msg . CRL);
               }
               elseif ($com[3]==':!kb' && $com[4] && $chan) {
                 $msg = strstr($data,":!kb");
                 $msg = str_replace(":!kb $com[4]","",$msg);
                 fputs($fp, 'KICK '.$chan.' '.$com[4].' :'.$msg . CRL);
                 fputs($fp, 'MODE '.$chan.' +b '.$com[4] . CRL);
               }
               elseif ($com[3]==':!changenick') {
                 $nick = $nicky[rand(0,count($nicky) - 1)];
                 fputs($fp, 'NICK '.$nick . CRL);
                 if (substr($dCommand,0,3)=='433') {
                   $nick = $nicky[rand(0,count($nicky) - 1)];
                   fputs($fp, 'NICK '.$nick . CRL);
                 }
               }
               elseif ($com[3]==':!op' && $chan) {
                 if ($com[4]) { $opnick = $com[4]; }
                 else { $opnick = $dNick; }
                 fputs($fp, 'MODE '.$chan.' +ooo '.$opnick.' '.$com[5].' '.$com[6] . CRL);
               }
               elseif ($com[3]==':!deop' && $chan) {
                 if ($com[4]) { $opnick = $com[4]; }
                 else { $opnick = $dNick; }
                 fputs($fp, 'MODE '.$chan.' -o+v-oo '.$opnick.' '.$opnick.' '.$com[5].' '.$com[6] . CRL);
               }
               elseif ($com[3]==':!v' && $chan) {
                 if ($com[4]) { $vonick = $com[4]; }
                 else { $vonick = $dNick; }
                 fputs($fp, 'MODE '.$chan.' +vvv '.$vonick.' '.$com[5].' '.$com[6] . CRL);
               }
               elseif ($com[3]==':!dv' && $chan) {
                 if ($com[4]) { $vonick = $com[4]; }
                 else { $vonick = $dNick; }
                 fputs($fp, 'MODE '.$chan.' -vvv '.$vonick.' '.$com[5].' '.$com[6] . CRL);
               }
               elseif ($com[3]==':!away' && $auth["$dNick"]["status"]=="Admin") {
                 $msg = strstr($data,":`awaymsg");
                 $msg = str_replace(":`awaymsg","",$msg);
                 if (strlen($msg)<3) {
                   $raway="on";
                   fputs($fp,'AWAY : ' . 'AWAY' . CRL);
                 }
                 else {
                   $raway="off";
                   fputs($fp,'AWAY : ' . $msg . CRL);
                 }
               }
               elseif ($com[3]==':!mode' && $com[4] && $chan) {
                 fputs($fp, 'MODE '.$chan.' :'.$com[4].' '.$com[5] . CRL);
               }
               elseif ($com[3]==':!nickmode' && $com[4]) {
                 $nickmode = $com[4];
                 fputs($fp, 'MODE '.$nick.' :'.$nickmode . CRL);
               }
               elseif ($com[3]==':!userlist') {
                 $userlist="";
                 foreach ($auth as $user) {
                   if ($user["pass"]) { $pass="-pass ok"; }
                   else { $pass="-no pass"; }
                   $userlist .= $user["name"].'('.$user["status"].$pass.') ';
                 }
                 fputs($fp, 'NOTICE '.$dNick.' :User List: '.$userlist . CRL);
               }
               elseif ($com[3]==':!quit' && $auth["$dNick"]["status"]=="Admin") {
                 $msg = strstr($data,":!quit");
                 $msg = str_replace(":!quit","",$msg);
                 if (strlen($msg)>3) {
                   $msg = str_replace(" ","_",$msg);
                 }
                 $quitmsg = $quitmsglist[rand(0,count($quitmsglist) - 1)];
                 fputs($fp, 'QUIT ' . $quitmsg . CRL);
                 $keluar = 1;
                 exit;
               }
               elseif ($com[3]==':!vhost' && $auth["$dNick"]["status"]=="Admin") {
                 if ($com[4]) { $localhost = $com[4]; }
                 else { $localhost = 'localhost'; }
                 $keluar = 0;
                 fputs($fp, 'QUIT ' . CRL);
               }
               elseif ($com[3]==':!jump' && $auth["$dNick"]["status"]=="Admin") {
                 if (empty($com[4])) {
                   $remotehost = $remotehost2[rand(0,count($remotehost2) - 1)];
                 }
                 else { $remotehost = $com[4]; }
                 $keluar = 0;
                 fputs($fp, "QUIT Ganti Server".CRL);
               }
               elseif ($com[3]==':!ident' && $auth["$dNick"]["status"]=="Admin") {
                 if (!$com[4]) { $username = $username; }
                 else { $username = $com[4]; }
                 $keluar = 0;
                 fputs($fp, 'QUIT Ganti Ident ' . CRL);
               }
               elseif ($com[3]==':!fullname' && $auth["$dNick"]["status"]=="Admin") {
                 if (!$com[4]) { $realname = "--"; }
                 else { $realname = $com[4]; }
                 $keluar = 0;
                 fputs($fp, 'QUIT Ganti Nama ' . CRL);
               }
               elseif ($com[3]==':!topic' && $com[4] && $chan) {
                 $msg = strstr($data,":!topic");
                 $msg = str_replace(":!topic ","",$msg);
                 fputs($fp, 'TOPIC '.$chan.' :'.$msg . CRL);
               }
               elseif ($com[3]==':!help' && !$chan) {
                 fputs($fp,'PING 12886241614'. CRL);
                 $msgdelay = 0;
                 foreach ($helptext as $baris){
                   $msgdelay++;
                   if($msgdelay >= 2) { sleep(2) ; $msgdelay = 0; }
                   fputs($fp,'PRIVMSG '.$dNick.' :'.$baris. CRL);
                 }
                 unset($baris);
                 unset($msgdelay);
               }

               elseif ($com[3]==':!wb') {
                 $wbn = $com[4];
                 $msg = strstr($data,":!wb");
                 $msg = str_replace(":!wb $wbn ","",$msg);
                 $nickwb[] = array($wbn,$msg);
                 if ($chan) { fputs($fp,'PRIVMSG '.$chan.' :Seep! '.$wbn.' ('.$msg.')'. CRL); }
                 else { fputs($fp,'NOTICE '.$dNick.' :Seep! '.$wbn.' ('.$msg.')'. CRL); }
               }
             }
             else { fputs($fp,'NOTICE '.$dNick.' :Mohon auth dulu! Ketik: auth <password> '. CRL); }
           }
         }
         elseif (!$auth["$dNick"] && !eregi("auth",$iText)) {
           if (eregi("www.",$iText) || eregi("http:",$iText) || eregi("join #",$iText)) {
             if (!ereg("#",$dCommand)) {
               if ($log=="on") {
                 fputs($fp,'PRIVMSG '. $admin .' :4inviter: ' . $dFrom . '2:' .$iText. CRL);
               }
               $inv = strstr($dFrom,'@');
               foreach ($auth as $user) {
                 if ($user["status"]=="user") {
                   fputs($fp, 'NOTICE '.$user["name"].' :KB '.$chan.' '.$dNick.' '.$inv.'' . CRL);
                 }
               }
             }
           }
           elseif (!ereg("#",$dCommand) && $log=="on") {
             fputs($fp,'PRIVMSG '.$admin.' :6' . $dFrom . '12:' .$iText. CRL);
           }
         }
       }
     }
     elseif (substr($data,0,4) == 'PING') {
       fputs($fp,'PONG ' . substr($data,5) . CRL);
     }
   }
 }
 fclose($fp);
} while ($keluar == 0);
}

function terjemah($lang, $keyword){
    $result = "";
    $keyword = str_replace(" ", "+",$keyword) ;
    
    $host = 'translate.google.com';      
    $sock = fsockopen($host,"80",$errno,$errstr,30); // lakukan koneksi ke sasaran.com port 80
    if ($sock){
        $get  = "GET /m?hl=id&sl=auto&tl=".$lang."&ie=UTF-8&prev=_m&q=".$keyword." HTTP/1.1\r\n".
                "Host: ".$host."\r\n".
                "Accept: text/html".
                "User-Agent: Opera/9.50 (J2ME/MIDP; Opera Mini/4.0.9800/209; U; en)\r\n".
                "Referer: http://translate.google.com/m\r\n".
                "Connection: Close\r\n\r\n";

        fputs($sock,$get); // kirimkan request
        while (!feof($sock)) { // ambil output yg di terima dari hasil kirim request
        $output .= trim(fgets($sock, 3600))."\n";
        //print_r ($output);
        }
        fclose($sock); // tutup koneksi
    $output = strtolower($output);
    $start = explode('<div dir="ltr" class="t0">',$output);
    $end = explode('</div>',$start[1]);
    
    $result = $lang.'! '. $end[0] .' ( SmartBot.a by JazMaN )';
    $result = str_replace("'","'",$result);
    $result = str_replace("<","<",$result);
    $result = str_replace(">",">",$result);
    $result = str_replace(""",'"',$result);
    
    return $result;
    }
};

function urltitle($fullweb){
    $result = "";
    $web = explode("/" ,$fullweb);
    $path = str_replace("http://".$web[2],"",$fullweb);   
    $sock = fsockopen($web[2],"80",$errno,$errstr,30); // lakukan koneksi ke sasaran.com port 80
    if ($sock){
        $get  = "GET /".$path." HTTP/1.1\r\n".
                "Host: ".$web[2]."\r\n".
                "Accept: text/html".
                "User-Agent: Opera/9.50 (J2ME/MIDP; Opera Mini/4.0.9800/209; U; en)\r\n".
                "Connection: Close\r\n\r\n";

        fputs($sock,$get); // kirimkan request
        while (!feof($sock)) { // ambil output yg di terima dari hasil kirim request
        $output .= trim(fgets($sock, 3600))."\n";
        //print_r ($output);
        }
        fclose($sock); // tutup koneksi
	$output = strtolower($output); 	
    $start = explode('<title>',$output);
    $end = explode('</title>',$start[1]);
    
    $result = 'url! : '.$web[2].' - Title : '. $end[0] .' ( SmartBot.a by JazMaN )';
    $result = str_replace("'","'",$result);
    $result = str_replace("<","<",$result);
    $result = str_replace(">",">",$result);
    $result = str_replace(""",'"',$result);
    
    return $result;
    }
};

JzPHPBot();

?>