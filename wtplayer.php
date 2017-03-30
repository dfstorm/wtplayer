<?php
/**
 *
 * Name: Webtorrent player
 * Description: A Webtorrent player for hubzilla. Alpha. Unstable. For testing.
 * Version: 0.1
 * Depends: Core
 * Recommends: None
 * Category: Torrents
 * Author: dfstorm <dfstorm@riseup.net>
 * Maintainer: dfstorm <dfstorm@riseup.net>
 */


function wtplayer_load(){
	register_hook('prepare_body', 'addon/wtplayer/wtplayer.php', 'wtplayer_prepare_body', 10);
}


function wtplayer_unload(){
	unregister_hook('prepare_body', 'addon/wtplayer/wtplayer.php', 'wtplayer_prepare_body');
}

function wtplayer_prepare_body(&$a,&$b) {
    /*
        Please note: this is not a finished work. It was a "speed coding"
        thing. I will make it more clean overtime. If you wish to help me,
        just do a pull request at https://github.com/dfstorm/wtplayer-hubzilla
    
    */
    
    $sStartTag = '[webtorrent]';
    $sEndTag = '[/webtorrent]';
    $sBody = $b['html'];
    $uId = uniqid();
    
    if(strpos($b['html'],$sStartTag) === false) {
        return;
    }
    
	$iStart = strpos($sBody,$sStartTag);
	$iEnd = strpos($sBody,$sEndTag,$iStart+1);
    
    $magnetLink = substr($sBody,$iStart+strlen($sStartTag),$iEnd-(strlen($sEndTag)-1));
    $encodedMagnetLink = base64_encode($magnetLink);

   $sPlayerblock = <<<HTMLRENDER
   <div id="wtplayer" style="background:black; color:#fff; height: 300px; width: 100%; text-align:center;">
    <br /><br />Magnet link detected.
    <a onclick="wtplayerActivate_{$uId}();" class="">launch it</a>
    <br />Powerded by webtorrent.io<br /><br />
    {$magnetLink}
   </div>
   <script>
    function wtplayerActivate_{$uId}() {
        $('#wtplayer').html('<iframe src="/addon/wtplayer/wtplayer/?magnet={$encodedMagnetLink}" style="width: 100%;height: 400px; border:none;"></iframe>');
    }
   </script>
   
   
HTMLRENDER;
    
    $b['html'] .= $sPlayerblock;    
}









