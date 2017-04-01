# WebTorrent Hubzilla Addon

[Hubzilla](http://hubzilla.org) is a powerful platform for creating interconnected websites featuring a decentralized identity, communications, and permissions framework built using common webserver technology. 

This is an addon repository (also known as **plugins**) that extends the functionality of the core Hubzilla installation by providing [WebTorrent](https://webtorrent.io/) player integration into posts.

To add a WebTorrent file to your post, simply add your magnet link between the ``[webtorrent][/webtorrent]`` tags.

## Example

``
[webtorrent]magnet:?xt=urn:btih:6a9759bffd5c0af65319979fb7832189f4f3c35d&dn=sintel.mp4&tr=wss%3A%2F%2Ftracker.btorrent.xyz&tr=wss%3A%2F%2Ftracker.fastcast.nz&tr=wss%3A%2F%2Ftracker.openwebtorrent.com&ws=https%3A%2F%2Fwebtorrent.io%2Ftorrents%2Fsintel-1024-surround.mp4[/webtorrent]
``

## Installation


To install, use the following commands (assuming /var/www/ is your hub's web root):

`cd /var/www/`

`util/add_addon_repo https://github.com/dfstorm/wtplayer.git wtplayer`

`util/update_addon_repo wtplayer`
