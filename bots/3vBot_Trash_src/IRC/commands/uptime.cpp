#include "../IRC.hpp"

int IRC::CMDUptime( void ) {
	DWORD now = api->GetTickCount();
	DWORD seconds = ((now - api->beginning) / 1000), minutes = 0, hours = 0, days = 0, weeks = 0;
	if (seconds >= 60) {
		minutes = seconds / 60;
		seconds %= 60;
	}
	if (minutes >= 60) {
		hours = minutes / 60;
		minutes %= 60;
	}
	if (hours >= 24) {
		days = hours / 24;
		hours %= 24;
	}
	if (days >= 7) {
		weeks = days / 7;
		days %= 7;
	}
	char buffer[255] = {0};
	api->wsprintf(buffer, MSG_UPTIME, weeks, days, hours, minutes, seconds);
	return(IRCSend(IRC_MSG, servers[currserver].channel, buffer));
}