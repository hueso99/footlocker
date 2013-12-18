#include "Usage.hpp"

bool InitPDHCounters(API *api) {
	PDH_STATUS Status;
	Status = api->PdhOpenQuery(NULL, NULL, &hQuery);
	if (Status != ERROR_SUCCESS) {		
		return false;
	}

	Status = api->PdhAddCounter(hQuery, "\\Processor(_Total)\\% Processor Time", 0, &hCPUCounter);
	if (Status != ERROR_SUCCESS) return false;
	Status = api->PdhAddCounter(hQuery, "\\Network Interface(*)\\Bytes Sent/sec", 0, &hNetworkOutCounter);
	if (Status != ERROR_SUCCESS) return false;
	Status = api->PdhAddCounter(hQuery, "\\Network Interface(*)\\Bytes Received/sec", 0, &hNetworkInCounter);
	if (Status != ERROR_SUCCESS) return false;

	Status = api->PdhCollectQueryData(hQuery);
	if (Status != ERROR_SUCCESS) return false;
	return true;
}


long GetCPUUsage(API *api) {
	PDH_STATUS Status;
	PDH_FMT_COUNTERVALUE DisplayValue;
	DWORD CounterType;

	Status = api->PdhCollectQueryData(hQuery);
	if (Status != ERROR_SUCCESS) return -1;
	Status = api->PdhGetFormattedCounterValue(hCPUCounter, PDH_FMT_LONG, &CounterType, &DisplayValue);

	return DisplayValue.longValue;
}

long GetNetworkOutboundStatus(API *api) {

	PDH_STATUS Status;
	PDH_FMT_COUNTERVALUE DisplayValue;
	DWORD CounterType;

	Status = api->PdhCollectQueryData(hQuery);
	if (Status != ERROR_SUCCESS) return -1;

	Status = api->PdhGetFormattedCounterValue(hNetworkOutCounter, PDH_FMT_LONG, &CounterType, &DisplayValue);	
	long Value = DisplayValue.longValue;

	if (Value > 1000) {
		return Value / 1000;
	}
	return 0;
}

long GetNetworkInboundStatus(API *api) {
	PDH_STATUS Status;
	PDH_FMT_COUNTERVALUE DisplayValue;
	DWORD CounterType;

	Status = api->PdhCollectQueryData(hQuery);
	if (Status != ERROR_SUCCESS) return -1;

	Status = api->PdhGetFormattedCounterValue(hNetworkInCounter,	PDH_FMT_LONG, &CounterType,	&DisplayValue);
	long Value = DisplayValue.longValue;

	if(Value > 1000) {
		return Value / 1000;
	}
	return 0;
}


