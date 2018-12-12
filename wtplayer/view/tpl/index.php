<html>
    <body>

    </body>
    <script src="../js/webtorrent.min.js"></script>
    <script>
        var client = new WebTorrent();
        var torrentId = '<?php if(isset($_GET["magnet"])) { echo str_replace("&amp;","&",base64_decode($_GET["magnet"])); } ?>';
        var uId = '<?php if(isset($_GET["uId"])) { echo str_replace("&amp;","&",base64_decode($_GET["uId"])); } ?>';
        client.add(torrentId, function (torrent) {
            var file = null;
            for (var idx in torrent.files)
            {
                if(!torrent.files.hasOwnProperty(idx))
                {
                    continue;
                }

                // assume that the largest file in files is the video
                if(!file || torrent.files[idx].length > file.length)
                {
                    file = torrent.files[idx];
                }
            }

            torrent.on('error', function(err) {
                $("#wtplayer_" + uId).html('<em>An error occurred trying to play this video: ' + err + '</em>');
            });

            torrent.on('noPeers', function(err) {
                $("#wtplayer_" + uId).html('<em>No peers were found for this video</em>');
            });

            file.appendTo('body');
        });
    </script>
    <style>
        body {
            margin: 0px;
            padding: 0px;
            background: #000;
            color: #fff;
        }
        video {
            height: 300px;
            width:100%;
        }
    </style>
</html>
