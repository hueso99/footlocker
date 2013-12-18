Gets "displayName" from "AntiVirusProduct" in the SecurityCenter using WMI and saves the result in the char array "av_name".


#include "includes.h"

#include <comdef.h>
#include <Wbemidl.h>

char av_name[256] = {0};

bool getavname()
{
HRESULT hres;

hres = CoInitializeEx(0, COINIT_MULTITHREADED); 
if (FAILED(hres))
{
return false; // fail
}

hres = CoInitializeSecurity(
NULL, 
-1, // COM authentication
NULL, // Authentication services
NULL, // Reserved
RPC_C_AUTHN_LEVEL_DEFAULT, // Default authentication 
RPC_C_IMP_LEVEL_IMPERSONATE, // Default Impersonation 
NULL, // Authentication info
EOAC_NONE, // Additional capabilities 
NULL // Reserved
);


if (FAILED(hres))
{
CoUninitialize();
return false; // fail
}


IWbemLocator *pLoc = NULL;

hres = CoCreateInstance(
CLSID_WbemLocator, 
0, 
CLSCTX_INPROC_SERVER, 
IID_IWbemLocator, (LPVOID *) &pLoc
);

if (FAILED(hres))
{
CoUninitialize();
return false; // fail
}



IWbemServices *pSvc = NULL;

OSVERSIONINFO osVI;
osVI.dwOSVersionInfoSize=sizeof(OSVERSIONINFO);
GetVersionEx(&osVI);

//SecurityCenter2 if Vista or Win7
if(osVI.dwMajorVersion==6)
{
hres = pLoc->ConnectServer(
_bstr_t(L"ROOT\\SecurityCenter2"), // Object path of WMI namespace
NULL, // User name. NULL = current user
NULL, // User password. NULL = current
0, // Locale. NULL indicates current
NULL, // Security flags.
0, // Authority (e.g. Kerberos)
0, // Context object 
&pSvc // pointer to IWbemServices proxy
);
}
else //SecurityCenter if XP
{
hres = pLoc->ConnectServer(
_bstr_t(L"ROOT\\SecurityCenter"), // Object path of WMI namespace
NULL, // User name. NULL = current user
NULL, // User password. NULL = current
0, // Locale. NULL indicates current
NULL, // Security flags.
0, // Authority (e.g. Kerberos)
0, // Context object 
&pSvc // pointer to IWbemServices proxy
);
}
if (FAILED(hres))
{
pLoc->Release(); 
CoUninitialize();
return false; // fail
}



hres = CoSetProxyBlanket(
pSvc, // Indicates the proxy to set
RPC_C_AUTHN_WINNT, // RPC_C_AUTHN_xxx
RPC_C_AUTHZ_NONE, // RPC_C_AUTHZ_xxx
NULL, // Server principal name 
RPC_C_AUTHN_LEVEL_CALL, // RPC_C_AUTHN_LEVEL_xxx 
RPC_C_IMP_LEVEL_IMPERSONATE, // RPC_C_IMP_LEVEL_xxx
NULL, // client identity
EOAC_NONE // proxy capabilities 
);

if (FAILED(hres))
{
pSvc->Release();
pLoc->Release(); 
CoUninitialize();
return false; // fail
}

IEnumWbemClassObject* pEnumerator = NULL;
hres = pSvc->ExecQuery(
bstr_t("WQL"), 
bstr_t("SELECT * FROM AntiVirusProduct"),
WBEM_FLAG_FORWARD_ONLY | WBEM_FLAG_RETURN_IMMEDIATELY, 
NULL,
&pEnumerator
);

if (FAILED(hres))
{
pSvc->Release();
pLoc->Release();
CoUninitialize();
return false; // fail
}

IWbemClassObject *pclsObj;
ULONG uReturn = 0;

while (pEnumerator)
{
HRESULT hr = pEnumerator->Next(WBEM_INFINITE, 1, 
&pclsObj, &uReturn);

if(0 == uReturn)
{
break;
}

VARIANT vtProp;
hr = pclsObj->Get(L"displayName", 0, &vtProp, 0, 0);

//Save in av_name
sprintf_s(av_name,sizeof(av_name),"%S",vtProp.bstrVal);
VariantClear(&vtProp);

pclsObj->Release();
}

pSvc->Release();
pLoc->Release();
pEnumerator->Release();
CoUninitialize();

//No Antivirus detected
if(av_name[1] == NULL)
sprintf_s(av_name,sizeof(av_name),"No-Antivirus (R)");

return true; // success
}
