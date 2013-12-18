/*
Anti-Emulator (c) crim 2009
Based upon DiskID32 by Lynn McGuire (http://www.winsim.com
/diskid32/)
Affected: Anubis, Threatexpert, VMWare, Maybe more
*/

#include <stdlib.h>
#include <stdio.h>
#include <windows.h>
typedef enum _STORAGE_QUERY_TYPE {PropertyStandardQuery = 0,PropertyExistsQuery,PropertyMaskQuery,PropertyQu eryMaxDefined} STORAGE_QUERY_TYPE, *PSTORAGE_QUERY_TYPE;
typedef enum _STORAGE_PROPERTY_ID {StorageDeviceProperty = 0,StorageAdapterProperty} STORAGE_PROPERTY_ID, *PSTORAGE_PROPERTY_ID;
typedef struct _STORAGE_PROPERTY_QUERY {
STORAGE_PROPERTY_ID PropertyId;
STORAGE_QUERY_TYPE QueryType;
UCHAR AdditionalParameters[1];

} STORAGE_PROPERTY_QUERY, *PSTORAGE_PROPERTY_QUERY;
typedef struct _STORAGE_DEVICE_DESCRIPTOR {
ULONG Version;
ULONG Size;
UCHAR DeviceType;
UCHAR DeviceTypeModifier;
BOOLEAN RemovableMedia;
BOOLEAN CommandQueueing;
ULONG VendorIdOffset;
ULONG ProductIdOffset;
} STORAGE_DEVICE_DESCRIPTOR, *PSTORAGE_DEVICE_DESCRIPTOR;
bool IsSandboxed()
{
HANDLE hPhysicalDriveIOCTL = 0;
int j = 0,k = 0;
char szModel[1000];
char *szDrives[] = {
"qemu",
"virtual",
"vmware",
NULL
};
hPhysicalDriveIOCTL = CreateFile ("\\\\.\\PhysicalDrive0", 0,FILE_SHARE_READ | FILE_SHARE_WRITE, NULL,OPEN_EXISTING, 0, NULL);
if (hPhysicalDriveIOCTL != INVALID_HANDLE_VALUE)
{
STORAGE_PROPERTY_QUERY query;
DWORD cbBytesReturned = 0;
char buffer[10000];
memset ((void *) & query, 0, sizeof (query));
query.PropertyId = StorageDeviceProperty;
memset (buffer, 0, sizeof (buffer));
if (DeviceIoControl(hPhysicalDriveIOCTL, CTL_CODE(IOCTL_STORAGE_BASE, 0x0500, METHOD_BUFFERED, FILE_ANY_ACCESS),& query,sizeof (query),& buffer,sizeof (buffer),& cbBytesReturned, NULL))
{ 
STORAGE_DEVICE_DESCRIPTOR *descrip = (STORAGE_DEVICE_DESCRIPTOR*)&buffer;
int pos = descrip->ProductIdOffset;
const char *str = buffer;
szModel[0] = '\0';
if (pos <= 0)
{
return FALSE;
}
char p = 0;
j = 1;k = 0;
szModel[k] = 0;
for (int x = pos; j && str[x] != '\0'; ++x)
{
char c = tolower(str[x]);
if (isspace(c))
c = '0';
++p;
szModel[k] <<= 4;
if (c >= '0' && c <= '9')
szModel[k] |= (unsigned char) (c - '0');
else if (c >= 'a' && c <= 'f')
szModel[k] |= (unsigned char) (c - 'a' + 10);
else
{
j = 0;
break;
}
if (p == 2)
{
if (szModel[k] != '\0' && ! isprint(szModel[k]))
{
j = 0;
break;
}
++k;
p = 0;
szModel[k] = 0;
}
}
if (!j)
{
j = 1;k = 0;
for (x = pos; j && str[x] != '\0'; ++x)
{
char c = str[x];
if (!isprint(c))
{
j = 0;
break;
}
szModel[k++] = c;
}
}
CharLowerBuff(szModel,strlen(szModel));
for (int i = 0; i < (sizeof(szDrives)/sizeof(LPSTR)) - 1; i++ ) {
if (szDrives[i][0] != 0)
{
if(strstr(szModel,szDrives[i]))
return TRUE;
}
}
}
CloseHandle (hPhysicalDriveIOCTL);
}
return FALSE;
}
int main (int argc, char * argv [])
{
if(IsSandboxed()) { 
printf("Pig is trying to sniff my exe!!\n");
}
else {
printf("It's all good\n");
}
getchar();
return 0;
}
