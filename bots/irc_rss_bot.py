#!/usr/bin/python

import socket, sys, string, time, feedparser
port = 6667
nick = "BotNickhere"
host = 'irc.evilzone.org'
name = "BotNameHere"
channel = '#poison'
ident = 'chronicbot'
woot = socket.socket()
woot.connect ( (host, port) )
woot.send ( 'NICK ' + nick + '\r\n' )
woot.send ( 'USER ' + ident + ' ' + ident + ' ' + ident + ' :chroniczbot\r\n' )

while 1:
data = woot.recv ( 1024 )
print(data)

if data.find ( '376' ) != -1:
woot.send( 'JOIN ' + channel + '\r\n' )

if data.find ( 'PING' ) != -1:
woot.send( 'PONG ' + data.split() [1] + '\r\n')
if data.find ( '!poison' ) != -1:
feedurl = feedparser.parse("http://poison.teamxpc.com/forum/syndication.php?limit=3")
newest = feedurl['items'][0].title
e = feedurl.entries[0]
threadurl = e.link
woot.send ("PRIVMSG #poison :Newest thread: %s\r\n" % newest)
woot.send ("PRIVMSG #poison :URL: %s\r\n" % threadurl)
if data.find ( '!security' ) != -1:
feedurlsophos = feedparser.parse("http://feeds.sophos.com/en/rss2_0-sophos-security-news.xml")
newestsophos = feedurlsophos['items'][0].title
d = feedurlsophos.entries[0]
sophosurl = d.link
woot.send ("PRIVMSG #poison :Newest security title: %s\r\n" % newestsophos)
woot.send ("PRIVMSG #poison :URL: %s\r\n" % sophosurl)
if data.find ( '!exploitdb' ) != -1:
feedurlex = feedparser.parse("https://twitter.com/statuses/user_timeline/89527528.rss")
newestex = feedurlex['items'][0].title
woot.send ("PRIVMSG #poison :Latest exploit: %s\r\n" % newestex)
