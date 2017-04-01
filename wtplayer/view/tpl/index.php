<html>
    <body>
       
    </body>
    <script src="/addon/wtplayer/view/js/webtorrent.min.js"></script>
    <script>
        var client = new WebTorrent()
        var torrentId = '<?php if(isset($_GET["magnet"])) { echo str_replace("&amp;","&",base64_decode($_GET["magnet"])); } ?>';
        client.add(torrentId, function (torrent) {
          var file = torrent.files[0];
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
