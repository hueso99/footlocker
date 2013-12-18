#include "../IRC.hpp"

int IRC::CMDServer( string parameter1 ) {
	int success = 0;
	if (((parameter1.c_str()[0] - '0') - 1) > serversnum - 1 || ((parameter1.c_str()[0] - '0') - 1) < 0) {
		success = IRCSend(IRC_MSG, servers[currserver].channel, MSG_SERVER_INCORRECT);
	} else if (((parameter1[0] - '0') - 1) == currserver) {
		success = IRCSend(IRC_MSG, servers[currserver].channel, MSG_SERVER_CURRENT);
	} else if (((parameter1[0] - '0') - 1) != currserver) {
		IRCSend(IRC_QUIT, "", MSG_SERVER_SWITCHING);
		newserver = (parameter1.c_str()[0] - '0') - 1;
	}
	return success;
}