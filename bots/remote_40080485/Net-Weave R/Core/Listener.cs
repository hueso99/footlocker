using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NetLib;
using NetLib.API;
using NetLib.Networking;
using System.Threading;
namespace Net_Weave_R.Core
{
    public class Listener
    {
        bool listening;
        SOCKET socket;
        Thread t;
        public bool Running
        {
            get
            {
                return listening;
            }
        }
        public int Port
        {
            get;
            private set;
        }
        public Listener()
        {
            listening = false;
            socket = null;
            t = null;
        }

        public bool Listen(int port)
        {
            if (listening)
                return false;

            socket = new SOCKET(ws2_32.AddressFamily.AF_INET, ws2_32.SocketType.SOCK_STREAM, ws2_32.SocketProtocol.IPPROTO_TCP);
            if (!socket.Bind(port) || !socket.Listen(0))
            {
                socket.Close();
                return false;
            }
            listening = true;
            t = new Thread(accept);
            t.Start();
            Port = port;
            return true;
        }

        public void Stop()
        {
            t.Abort();
            t = null;
            socket.Close();
            socket = null;
            listening = false;
        }

        void accept()
        {
            while (listening)
            {
                SOCKET acc = socket.Accept();
                if (acc != null && listening)
                    if (SocketAccepted != null)
                        SocketAccepted(this, new SocketConnectedEventArgs(acc));
                if (!listening)
                    break;
            }
        }

        #region Events
        public event EventHandler<SocketConnectedEventArgs> SocketAccepted;
        #endregion
    }
}
