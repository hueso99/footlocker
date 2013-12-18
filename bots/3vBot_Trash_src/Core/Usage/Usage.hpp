#ifndef USAGE_HPP
#define USAGE_HPP

#include "../core.hpp"

HQUERY hQuery = NULL;
HCOUNTER hCPUCounter;
HCOUNTER hNetworkInCounter;
HCOUNTER hNetworkOutCounter;

bool InitPDHCounters			( API *api );
long GetCPUUsage				( API *api );
long GetNetworkInboundStatus	( API *api );
long GetNetworkOutboundStatus	( API *api );

#endif