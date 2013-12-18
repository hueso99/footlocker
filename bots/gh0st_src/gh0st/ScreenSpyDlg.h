#if !defined(AFX_SCREENSPYDLG_H__8C27AA31_1C2A_428A_A937_BC00F2519DB1__INCLUDED_)
#define AFX_SCREENSPYDLG_H__8C27AA31_1C2A_428A_A937_BC00F2519DB1__INCLUDED_


#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000
// ScreenSpyDlg.h : header file
//

/////////////////////////////////////////////////////////////////////////////
// CScreenSpyDlg dialog


class CScreenSpyDlg : public CDialog
{
// Construction
public:
	void OnReceiveComplete();
	CScreenSpyDlg(CWnd* pParent = NULL, CIOCPServer* pIOCPServer = NULL, ClientContext *pContext = NULL);   // standard constructor
// Dialog Data
	//{{AFX_DATA(CScreenSpyDlg)
	enum { IDD = IDD_SCREENSPY };
		// NOTE: the ClassWizard will add data members here
	//}}AFX_DATA


// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CScreenSpyDlg)
	public:
	virtual BOOL PreTranslateMessage(MSG* pMsg);
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	virtual void PostNcDestroy();
	//}}AFX_VIRTUAL

// Implementation
protected:

	// Generated message map functions
	//{{AFX_MSG(CScreenSpyDlg)
	virtual BOOL OnInitDialog();
	afx_msg void OnSysCommand(UINT nID, LPARAM lParam);
	afx_msg void OnPaint();
	afx_msg void OnSize(UINT nType, int cx, int cy);
	afx_msg void OnClose();
	afx_msg void OnTimer(UINT nIDEvent);
	afx_msg void OnHScroll(UINT nSBCode, UINT nPos, CScrollBar* pScrollBar);
	afx_msg void OnVScroll(UINT nSBCode, UINT nPos, CScrollBar* pScrollBar);
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
private:
	HICON m_hIcon;
	void InitMMI();
	MINMAXINFO m_MMI;
	void DrawTipString(CString str);
	HDRAWDIB m_hDD;
	HDC m_hDC, m_hMemDC, m_hPaintDC;
	HBITMAP	m_hFullBitmap;
	LPVOID m_lpScreenDIB;
	LPBITMAPINFO m_lpbmi, m_lpbmi_rect;
	UINT m_nCount;
	UINT m_HScrollPos, m_VScrollPos;
	HCURSOR	m_hRemoteCursor;
	ICONINFO m_CursorInfo;
	POINT	m_RemoteCursorPos;
	void ResetScreen();
	void DrawFirstScreen();
	void DrawNextScreen();
	void SendResetScreen(int nBitCount);
	void UpdateLocalClipboard(char *buf, int len);
	void SendLocalClipboard();
	int	m_nBitCount;
	bool m_bIsFirst;
	bool m_bIsTraceCursor;
	bool m_bIsBlockInput;
	bool m_bIsBlankScreen;
	ClientContext* m_pContext;
	CIOCPServer* m_iocpServer;
	CString m_IPAddress;
	bool m_bIsCtrl;
	void SendNext();
	void SendCommand(DWORD dwCtrlID, BOOL bMove, int x, int y, UINT uChar = 0, UINT nFlags = 0);
	LRESULT OnGetMiniMaxInfo(WPARAM, LPARAM);
};

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_SCREENSPYDLG_H__8C27AA31_1C2A_428A_A937_BC00F2519DB1__INCLUDED_)
