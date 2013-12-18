using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NetLib.API;
using NetLib.Networking;
namespace Net_Weave_R
{
    public class SocketConnectedEventArgs : EventArgs
    {
        public SOCKET AcceptedSocket
        {
            get;
            private set;
        }

        public SocketConnectedEventArgs(SOCKET sck)
        {
            AcceptedSocket = sck;
        }
    }

    public class DataReceivedEventArgs : EventArgs
    {
        public int Header
        {
            get;
            private set;
        }

        public int Length
        {
            get;
            private set;
        }

        public PacketReader Reader
        {
            get;
            private set;
        }

        public DataReceivedEventArgs(byte[] data)
        {
            Reader = new PacketReader(data, true);
            Length = data.Length;
            Header = Reader.ReadInt32();
        }
    }

    public class DataSentEventArgs : EventArgs
    {
        public int Sent
        {
            get;
            private set;
        }

        public DataSentEventArgs(int sent)
        {
            Sent = sent;
        }
    }
}
