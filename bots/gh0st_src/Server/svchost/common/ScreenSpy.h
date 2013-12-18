// ScreenSpy.h: interface for the CScreenSpy class.
//
//////////////////////////////////////////////////////////////////////

#if !defined(AFX_SCREENSPY_H__6600B30F_A7E3_49D4_9DE6_9C35E71CE3EE__INCLUDED_)
#define AFX_SCREENSPY_H__6600B30F_A7E3_49D4_9DE6_9C35E71CE3EE__INCLUDED_
#include <windows.h>

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000

class CScreenSpy  
{
public:
	CScreenSpy(int biBitCount= 8, bool bIsGray= false, UINT nMaxFrameRate= 50);
	virtual ~CScreenSpy();
	LPVOID getFirstScreen();
	LPVOID getNextScreen(LPDWORD lpdwBytes);

	LPBITMAPINFO getBI();
	UINT	getBISize();
	UINT	getFirstImageSize();
private:
	UINT m_nMaxFrameRate;
	bool m_bIsGray;
	DWORD m_dwLastCapture;
	DWORD m_dwSleep;
	LPBYTE m_rectBuffer;
	UINT m_rectBufferOffset;
	BYTE m_nIncSize;
	int m_nFullWidth, m_nFullHeight, m_nStartLine;
	RECT m_changeRect;
	HDC m_hFullDC, m_hLineMemDC, m_hFullMemDC, m_hRectMemDC;
	HBITMAP m_hLineBitmap, m_hFullBitmap;
	LPVOID m_lpvLineBits, m_lpvFullBits;
	LPBITMAPINFO m_lpbmi_line, m_lpbmi_full, m_lpbmi_rect;
	int	m_biBitCount;
	LPBITMAPINFO ConstructBI(int biBitCount, int biWidth, int biHeight);
	void CopyRect(LPRECT lpRect);
	bool SelectInputWinStation();
	HWND m_hDeskTopWnd;
};

#endif // !defined(AFX_SCREENSPY_H__6600B30F_A7E3_49D4_9DE6_9C35E71CE3EE__INCLUDED_)
