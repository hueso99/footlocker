MicroJoiner v1.7 (c) coban2k
----------------------------
http://www.cobans.net

Features
--------

- Joins up to 4096 files 
- Able to join any files (images, icons, pdfs, etc), as the default viewer will be used 
- You can set icon for created executable from an *.ico, *.exe or *.dll file 
- Joined files are encrypted 
- Joined files can be packed with internal packer (ratio is better then zip) 
- Tiny loader stub: 2048 bytes 
- Created file can be packed with any exe-packer (UPX, ASPack, etc) 
- Per-file advanced options, visibility flags, command line arguments, attributes, autorun, etc.
- Posibility to register DLL (OCX) files when using VB applications
- Melting option which allows to ovewrite/delete created executable after all files have been executed
- Works under 95/98/2k/XP/2k3 (tested alot) 
- Project saving/loading (GUI)
- Supports file drag & drop (GUI) 
- Full Windows XP themes support (GUI) 
- English & Russian interface (GUI)
- Opensource (pure MASM32 assembly) 

Help, FAQ
---------

1. Where's the result with joined files, how to choose output file?
Checkout the directory, where you've started MicroJoiner.exe executable,
resulting Joined.exe file will be created in the same folder. If it was
existed before, then it will get overwritten. If you want to specify alternative
output file press Right Mouse Button on "Create" button.

2. What does pack files option mean?
When this option is enabled, MicroJoiner compresses joined files using 
aPlib opensource library by Joergen Ibsen (http://www.ibsensoftware.com).
Loader stub automaticly unpackes them in memory.

3. What does unique filename option mean (advanced options dialog)?
If it's enabled files are created with unique names, eg. ope123.exe, ope332.BMP, 
etc, otherwise real filenames are used (test.exe, photo.bmp). Unique file names 
guarantee you that there will be no problems with file creation. For example,
user can view photo.bmp file from Temp folder the same time you're trying to 
write new one, as it's impossible to overwrite opened file, new photo.bmp will 
remain unviewed.

4. How can I run external programs like command.com, ping.exe within resulting file?
Create a simple dos batch file (.bat) and join it.

5. What does "wait until terminated" option mean(advanced options dialog)?
This option gives a posibility to execute file and wait until it's process 
was terminated. Note: files are executed in reverse order. For example you've
added sequently file1.exe, file2.exe, file3.exe in GUI and file3.exe has "wait
until terminated" option set, in such case Joined.exe will execute file3.exe,
then it waits untill file3.exe was terminated, then it executes at the same time
file2.exe and file1.exe.

Melting help
------------

Melting allows you to perform some actions with resulting (Joined.exe) file 
after all binded files have been executed.

1. You can delete resulting file after execution (self kill).
2. You can replace it with selected file (you may select file from advanced 
options dialog - "select as melting source" option).
3. You can delete resulting file and copy selected file into the same dir
the resulting file was running from.


Changes since 1.6
-------------------
[+] DLL (OCX) registration
[+] Ability to wait until application has been terminated, then process next file
[+] Double click executes per-file options dialogs 
[-] Autorun fixes
[-] Some small cosmetic fixes

Changes since 1.55r
-------------------
[-] Sometimes files didn't run (mostly in win2k), thx to John Smith!

Changes since 1.51
-------------------
[-] Melting didn't work if file was running from current folder
[+] Added autorun option
[+] Saving/Loading project (GUI)
[+] GUI works in only one language now
