using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Net.Sockets;
using System.Threading;
using System.Net;
using System.IO;
using NetLib.Misc;

namespace Net_Weave_R.Core
{
    public class ChatClient
    {
        public enum Header : int
        {
            NONE = 0xF,
            USERNAME = 0x0,
            USERS = 0x1,
            MESSAGE = 0x2,
            PM = 0x3,
            LEFT = 0x4
        }
        Socket socket;
        public Socket RawSocket
        {
            get { return socket; }
        }
        IPAddress ipAddress = null;
        public IPAddress IPAddress
        {
            get { return ipAddress; }
        }
        bool disposed;
        public bool Disposed
        {
            get { return disposed; }
        }
        Thread readThread;
        public ChatClient()
        {
            socket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
            disposed = false;
        }
        public bool Connect()
        {
            try
            {
                socket.Connect(GlobalProperties.Vps, 2934);
                return true;
            }
            catch { }
            return false;
        }
        public void BeginRead()
        {
            try
            {
                socket.BeginReceive(new byte[0], 0, 0, SocketFlags.None, readCallback, null);
            }
            catch
            {
                Disconnect(true);
                return;
            }
        }
        void readCallback(IAsyncResult ar)
        {
            try
            {
                socket.EndReceive(ar);

                MemoryStream ms = new MemoryStream();
                byte[] buffer;
                while (true)
                {
                    buffer = new byte[socket.ReceiveBufferSize];
                    int rec = socket.Receive(buffer, 0, buffer.Length, SocketFlags.Partial);
                    if (rec <= 0)
                        throw new SocketException((int)SocketError.ConnectionReset);
                    Array.Resize(ref buffer, rec);
                    ms.Write(buffer, 0, rec);
                    string last = char.ConvertFromUtf32((int)buffer[buffer.Length - 1]);
                    if (last == "\n")
                    {
                        break;
                    }
                }

                ms.Close();
                ThreadStart starter = delegate
                {
                    Parse(ms.ToArray());
                    ms.Dispose();
                    ms = null;
                };
                new Thread(starter).Start();
            }
            catch
            {
                Disconnect(true);
                return;
            }

            BeginRead();
        }
        void Parse(byte[] buffer)
        {
            List<byte> data = new List<byte>();
            for (int i = 0; i < buffer.Length; i++)
            {
                if (char.ConvertFromUtf32((int)buffer[i]) != "\n")
                {
                    data.Add(buffer[i]);
                }
                else
                {
                    Process(data.ToArray());
                    data.Clear();
                }
            }
        }
        void Process(byte[] buffer)
        {
            byte[] packet = Encryption.Decrypt(buffer, true);

            MemoryStream ms = new MemoryStream(packet);
            Header header;
            byte[] data;
            byte[] bHeader = new byte[4];
            ms.Read(bHeader, 0, bHeader.Length);
            header = (Header)BitConverter.ToInt32(bHeader, 0);
            data = new byte[ms.Length - 4];
            ms.Read(data, 0, data.Length);
            ms.Close();
            ms.Dispose();
            if (Received != null)
            {
                Received(this, new xDataReceivedEventArgs(data, data.Length, header));
            }
            data = null;
            buffer = null;
            packet = null;
            ms = null;
        }
        public int Send(byte[] data)
        {
            int sent = 0;
            try
            {
                new Thread(() =>
                {
                    try
                    {
                        sent = socket.Send(data, data.Length, SocketFlags.Partial);
                        sent += socket.Send(DataEnd, SocketFlags.Partial);
                        if (Sent != null)
                        {
                            if (sent != 0)
                            {
                                Sent(this, new xSentEventArrgs(sent));
                            }
                        }
                    }
                    catch
                    {
                        Disconnect(true);
                        return;
                    }
                }).Start();
                return sent;
            }
            catch { return 0; }
        }
        byte[] DataEnd
        {
            get
            {
                return Encoding.ASCII.GetBytes("\n");
            }
        }
        public bool Disconnect(bool callEvent)
        {
            Close();
            if (callEvent)
            {
                if (Disconnected != null)
                {
                    Disconnected(this, null);
                }
            }
            Dispose();
            return true;
        }
        public void Dispose()
        {
            try
            {
                socket = null;
            }
            catch { }
            try
            {
                readThread = null;
            }
            catch { }
            disposed = true;
        }
        public void Close()
        {
            try
            {
                socket.Close();
            }
            catch { }
            try
            {
                readThread.Abort();
            }
            catch { }
        }
        public event EventHandler Disconnected;
        public event EventHandler<xSentEventArrgs> Sent;
        public event EventHandler<xDataReceivedEventArgs> Received;
    }
    #region EventArgs
    public class xDataReceivedEventArgs : EventArgs
    {
        byte[] data;
        public byte[] Data
        {
            get { return data; }
            set { data = value; }
        }
        int length;
        public int Length
        {
            get { return length; }
            set { length = value; }
        }
        ChatClient.Header header;
        public ChatClient.Header Header
        {
            get { return header; }
            set { header = value; }
        }
        public xDataReceivedEventArgs(byte[] data, int len, ChatClient.Header header)
        {
            Data = data;
            Length = len;
            Header = header;
        }
    }
    public class xSentEventArrgs : EventArgs
    {
        int length;
        public int Length
        {
            get { return length; }
        }
        public xSentEventArrgs(int sent)
        {
            length = sent;
        }
    }
    #endregion
}
