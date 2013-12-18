#if !defined(AFX_WEBCAMDLG_H__2E4F0D3D_DB2F_4F45_B543_D5F687A79CC6__INCLUDED_)
#define AFX_WEBCAMDLG_H__2E4F0D3D_DB2F_4F45_B543_D5F687A79CC6__INCLUDED_

#if _MSC_VER > 1000
#pragma once
#endif // _MSC_VER > 1000
// WebCamDlg.h : header file
//

/////////////////////////////////////////////////////////////////////////////
// CWebCamDlg dialog

class CWebCamDlg : public CDialog
{
// Construction
public:
	void OnReceiveComplete();
	CWebCamDlg(CWnd* pParent = NULL, CIOCPServer* pIOCPServer = NULL, ClientContext *pContext = NULL);   // standard constructor

// Dialog Data
	//{{AFX_DATA(CWebCamDlg)
	enum { IDD = IDD_WEBCAM };
		// NOTE: the ClassWizard will add data members here
	//}}AFX_DATA


// Overrides
	// ClassWizard generated virtual function overrides
	//{{AFX_VIRTUAL(CWebCamDlg)
	public:
	virtual BOOL PreTranslateMessage(MSG* pMsg);
	protected:
	virtual void DoDataExchange(CDataExchange* pDX);    // DDX/DDV support
	virtual void PostNcDestroy();
	//}}AFX_VIRTUAL

// Implementation
protected:

	// Generated message map functions
	//{{AFX_MSG(CWebCamDlg)
	afx_msg void OnClose();
	virtual BOOL OnInitDialog();
	afx_msg void OnPaint();
	afx_msg void OnShowWindow(BOOL bShow, UINT nStatus);
	afx_msg void OnSize(UINT nType, int cx, int cy);
	afx_msg void OnTimer(UINT nIDEvent);
	//}}AFX_MSG
	DECLARE_MESSAGE_MAP()
private:
	UINT m_nCount;
	HICON m_hIcon;
	HDC m_hDC;
	HDRAWDIB m_hDD;
	void DrawDIB();

	ClientContext* m_pContext;
	CIOCPServer* m_iocpServer;
	CString m_IPAddress;
	LPVOID m_lpScreenDIB;
	MINMAXINFO m_MMI;
	BITMAPINFOHEADER m_bmih;
	void InitMMI();
	LRESULT OnGetMiniMaxInfo(WPARAM, LPARAM);
	void SendNext();
	void SendException();
};

//{{AFX_INSERT_LOCATION}}
// Microsoft Visual C++ will insert additional declarations immediately before the previous line.

#endif // !defined(AFX_WEBCAMDLG_H__2E4F0D3D_DB2F_4F45_B543_D5F687A79CC6__INCLUDED_)
