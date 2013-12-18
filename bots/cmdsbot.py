#!/usr/bin/env python
#Executes command and prints output in channel
#I don't encourage running this from your computer!!
#Args: !cmdsbot <command>
#Use "cmd" quotes around the commands.

import sys, socket, string, os, commands, getopt, StringIO, time

if len(sys.argv) != 5:
	print "Usage: ./cmdsbot.py <host> <port> <nick> <channel>"
	sys.exit(1)

HOST = sys.argv[1]
PORT = int(sys.argv[2])
NICK = sys.argv[3]
CHAN = sys.argv[4]
print "\nConnecting to",HOST+":"+str(PORT),"\n"
readbuffer = ""
s=socket.socket( )
s.connect((HOST, PORT))
s.send("NICK %s\r\n" % NICK)
s.send("USER %s %s bla :%s\r\n" % (NICK, NICK, NICK))
print "Nickname:",NICK,"\n"
print "Joining:",CHAN,"\n"
s.send("JOIN :%s\r\n" % CHAN)
print "Connected..."

while 1:
	readbuffer=readbuffer+s.recv(20480)
    	temp=string.split(readbuffer, "\n")
    	readbuffer=temp.pop( )

    	for line in temp:
        	line=string.rstrip(line)
        	line=string.split(line)
		try:
			if line[3] == ":!cmdsbot":
				newcmd = ""
				cmd = line[4:]
				if len(cmd) >=2:
					for i in cmd:
						newcmd = newcmd+" "+i.replace('\"',"",1)
				else:
					newcmd = line[4]
				s.send("PRIVMSG %s :%s%s\r\n" % (CHAN,"Executing:",newcmd))
				time.sleep(2)
				output = StringIO.StringIO(commands.getstatusoutput(newcmd)[1]).readlines()
				for line in output:
					time.sleep(1)
					s.send("PRIVMSG %s :%s\r\n" % (CHAN,line))	
		except(IndexError):
			pass
        	if(line[0]=="PING"):
          		s.send("PONG %s\r\n" % line[1])
