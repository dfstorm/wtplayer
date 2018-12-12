<?php
/**
 *
 * Name: Webtorrent player
 * Description: A Webtorrent player for hubzilla. Alpha. Unstable. For testing.
 * Version: 0.3
 * Depends: Core
 * Recommends: None
 * Category: Torrents
 * Author: dfstorm <dfstorm@riseup.net>
 * Maintainer: dfstorm <dfstorm@riseup.net>
 */


function wtplayer_load(){
	register_hook('prepare_body', 'addon/wtplayer/wtplayer.php', 'wtplayer_prepare_body');
}


function wtplayer_unload(){
	unregister_hook('prepare_body', 'addon/wtplayer/wtplayer.php', 'wtplayer_prepare_body');
}

function wtplayer_prepare_body(&$a,&$b) {
    $sStartTag = '[webtorrent]';
    $sEndTag = '[/webtorrent]';
    $sBody = $b['html'];


    $iLastStartIndex = strpos($b['html'], $sStartTag);
    if($iLastStartIndex === false) {
        return;
    }


    while($iLastStartIndex !== false)
    {
        $iStartIdx = $iLastStartIndex;
        $iEndIdx = strpos($sBody, $sEndTag, $iStartIdx + 1);
        $magnetLink = substr($sBody,$iStartIdx+strlen($sStartTag),$iEndIdx-(strlen($sEndTag)-1));

        if(strpos($magnetLink, $sStartTag) !== false)
        {
            // nested webtorrent tags, return gracefully
            return;
        }

        $encodedMagnetLink = base64_encode($magnetLink);
        $uId = uniqid();

        $sReplacement = wtplayer_get_replacement_block($uId, $encodedMagnetLink);

        $sStartString = "";
        if($iStartIdx > 0)
        {
            $sStartString = substr($sBody, 0, $iStartIdx);
        }
        $sEndString = substr($sBody, $iEndIdx + strlen($sEndTag));

        $sBody = $sStartString . $sReplacement . $sEndString;
        $iLastStartIndex = strpos($sBody, $sStartTag, $iLastStartIndex+1);
    }

    $b['html'] = $sBody;
}

function wtplayer_get_replacement_block($uId, $encodedLink)
{
    $sPlayerblock = <<<HTMLRENDER
        <div id="wtplayer_{$uId}" style="background:black; color:#fff; height: 300px; width: 100%; text-align:center;">
            <p>Magnet link detected. <a onclick="wtplayerActivate_{$uId}();" class="">Launch it!</a><br/>
            Powered by webtorrent.io</p>
       </div>
       <script>
        function wtplayerActivate_{$uId}() {
            var htmlString = '<iframe src="/addon/wtplayer/view/tpl/index.php?magnet={$encodedLink}&uId={$uId}" ' +
                'style="width: 100%; height: 400px; border:none;"></iframe>';
            $('#wtplayer_{$uId}').html(htmlString);
        }
       </script>
HTMLRENDER;

    return $sPlayerblock;
}









