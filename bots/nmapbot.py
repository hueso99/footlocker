#!/usr/bin/env python
#Prints open ports
#Args: !nmapbot <host>
#d3hydr8[at]gmail[dot]com

import sys, socket, string, commands, getopt, StringIO, re
	
if len(sys.argv) != 5:
	print "Usage: ./nmapbot.py <host> <port> <nick> <channel>"
	sys.exit(1)

HOST = sys.argv[1]
PORT = int(sys.argv[2])
NICK = sys.argv[3]
CHAN = sys.argv[4]
readbuffer = ""

s=socket.socket( )
s.connect((HOST, PORT))
s.send("NICK %s\r\n" % NICK)
s.send("USER %s %s bla :%s\r\n" % (NICK, NICK, NICK))
s.send("JOIN :%s\r\n" % CHAN)

while 1:
	readbuffer=readbuffer+s.recv(1024)
    	temp=string.split(readbuffer, "\n")
    	readbuffer=temp.pop( )

    	for line in temp:
        	line=string.rstrip(line)
        	line=string.split(line)
		try:
			if line[3] == ":!nmapbot":
				s.send("PRIVMSG %s :%s\r\n" % (CHAN, "Scanning: "+line[4]))
				nmap = StringIO.StringIO(commands.getstatusoutput('nmap -P0 '+line[4])[1]).readlines()
				for x in nmap:
					if re.search("\d+/tcp\s+(?=open)", x):
						s.send("PRIVMSG %s :%s\r\n" % (CHAN, x))
		except(IndexError):
			pass
		

        	if(line[0]=="PING"):
          		s.send("PONG %s\r\n" % line[1])
