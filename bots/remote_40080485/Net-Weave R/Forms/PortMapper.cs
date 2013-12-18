using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Mono.Nat;
using Net_Weave_R.Forms.Popups;
using System.Threading;
using System.Net;
using System.IO;
using System.Net.Sockets;
namespace Net_Weave_R.Forms
{
    public partial class PortMapper : Form
    {
        List<INatDevice> devices;
        public PortMapper()
        {
            InitializeComponent();
            this.Icon = GlobalProperties.ApplicationIcon;
            devices = GlobalProperties.NatDevices;
            cbProtocol.SelectedIndex = 0;
            cbTestProtocol.SelectedIndex = 0;

            Functions.Center(this);

            Load += new EventHandler(PortMapper_Load);
        }

        void PortMapper_Load(object sender, EventArgs e)
        {
            if (devices.Count > 0)
                refresh();
        }

        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            //devices.Clear();
            //NatUtility.DeviceFound -= NatUtility_DeviceFound;
            //NatUtility.DeviceLost -= NatUtility_DeviceLost;
            //NatUtility.StopDiscovery();
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
                        Close();
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

        private void btnAdd_Click(object sender, EventArgs e)
        {
            if (devices.Count > 0)
            {
                forwardPort(int.Parse(txtIn.Text), int.Parse(txtEx.Text), cbProtocol.SelectedIndex);
            }
            else
                MessageBox.Show("Devices not yet found.", "Devices Not Found", MessageBoxButtons.OK, MessageBoxIcon.Error);
        }

        void forwardPort(int internalPort, int externalPort, int protocol)
        {
            new Thread(() =>
                {
                    bool mod = false;
                    for (int i = 0; i < devices.Count; i++)
                    {
                        try
                        {
                            Protocol p = protocol == 0 ? Protocol.Tcp : Protocol.Udp;
                            devices[i].CreatePortMap(new Mapping(p, internalPort, externalPort, 0));
                            mod = true;
                        }
                        catch (Exception ex)
                        {
                            MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                        }
                    }
                    if (mod)
                        refresh();
                }).Start();
        }

        void refresh()
        {
            if (devices.Count == 0)
            {
                MessageBox.Show("Devices not yet found.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }
            Invoke((MethodInvoker)delegate
            {
                lstPorts.Items.Clear();

                for (int i = 0; i < devices.Count; i++)
                {
                    INatDevice device = devices[i];
                    Mapping[] maps = device.GetAllMappings();
                    foreach (Mapping map in maps)
                    {
                        ListViewItem item = new ListViewItem();
                        item.Text = map.PrivatePort.ToString();
                        item.SubItems.Add(map.PublicPort.ToString());
                        item.SubItems.Add(map.Protocol.ToString());
                        item.Tag = device;
                        lstPorts.Items.Add(item);
                    }                    
                }
            });
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            foreach (ListViewItem i in lstPorts.SelectedItems)
            {
                INatDevice device = (INatDevice)i.Tag;
                int inPort, exPort, protocol;
                inPort = int.Parse(i.Text);
                exPort = int.Parse(i.SubItems[1].Text);
                protocol = (i.SubItems[2].Text == "Tcp" ? 0 : 1);
                Protocol p = (protocol == 0) ? Protocol.Tcp : Protocol.Udp;
                device.DeletePortMap(new Mapping(p, inPort, exPort));
            }
            if (lstPorts.SelectedItems.Count > 0)
                refresh();
        }
        private void btnTestCon_Click(object sender, EventArgs e)
        {
            System.Windows.Forms.DialogResult res = MessageBox.Show("An active firewall may render this test useless.\n"
+ "Continue?", "", MessageBoxButtons.YesNo, MessageBoxIcon.Warning);

            if (res != System.Windows.Forms.DialogResult.Yes) return;
            List<object> obj = new List<object>();
            obj.Add(int.Parse(txtTestPort.Text));
            obj.Add((cbTestProtocol.SelectedIndex == 0) ? Protocol.Tcp : Protocol.Udp);
            new Thread(new ParameterizedThreadStart(check)).Start(obj);
        }

        void check(object obj)
        {
            List<object> l = (List<object>)obj;
            int port = (int)l[0];
            Protocol proto = (Protocol)l[1];
            switch (proto)
            {
                case Protocol.Tcp:
                    checkTcp(port);
                    break;

                case Protocol.Udp:
                    checkUdp(port);
                    break;
            }
        }
        void checkTcp(int port)
        {
            try
            {
                Socket listener = null;
                Socket sck = new Socket(AddressFamily.InterNetwork, SocketType.Dgram, ProtocolType.Udp);
                listener = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);

                MemoryStream ms = new MemoryStream();
                BinaryWriter w = new BinaryWriter(ms);
                w.Write(port);
                w.Close();
                ms.Close();
                sck.SendTo(ms.ToArray(), new IPEndPoint(
                    Dns.GetHostEntry(GlobalProperties.Vps).AddressList[0], 89));
                sck.Close();
                listener.Bind(new IPEndPoint(0, port));
                listener.Listen(1);
                bool con = false;
                new Thread(() =>
                {
                    try
                    {
                        Socket acc = listener.Accept();
                        acc.Close();
                        acc = null;
                        con = true;
                    }
                    catch { }
                }).Start();

                Thread.Sleep(3000);
                sck.Close();

                listener.Close();
                if (!con)
                {
                    MessageBox.Show(string.Format("Connections are not being accepted through port {0} via {1}."
                        , port.ToString(), "TCP"), "FAILED", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }
                MessageBox.Show(string.Format("Connections are being accepted through port {0} via {1}.", port.ToString(), "TCP"), "SUCCESS", MessageBoxButtons.OK, MessageBoxIcon.Information);
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }
        void checkUdp(int port)
        {
            try
            {
                Socket udpListener = new Socket(AddressFamily.InterNetwork, SocketType.Dgram, ProtocolType.Udp);
                byte[] received = new byte[12];
                udpListener.Bind(new IPEndPoint(IPAddress.Any, port));
                EndPoint any = new IPEndPoint(IPAddress.Any, port);
                new Thread(() =>
                {
                    try
                    {
                        MemoryStream ms = new MemoryStream();
                        BinaryWriter w = new BinaryWriter(ms);
                        w.Write(port);
                        w.Close();
                        ms.Close();
                        udpListener.SendTo(ms.ToArray(), new IPEndPoint(
                            Dns.GetHostEntry(GlobalProperties.Vps).AddressList[0], 89));
                        udpListener.ReceiveTimeout = 2000;
                        udpListener.ReceiveFrom(received, ref any);
                    }
                    catch { }
                }).Start();
                Thread.Sleep(2000);
                if (Encoding.ASCII.GetString(received) == "Hello World!")
                {
                    MessageBox.Show(string.Format("Data can be received through port {0} via UDP.", port.ToString()), "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                }
                else
                {
                    MessageBox.Show(string.Format("Data could not be received through port {0} via UDP.", port.ToString()), "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                }
                udpListener.Close();
                udpListener = null;
                received = null;
            }
            catch (Exception ex)
            {
                MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void refreshToolStripMenuItem_Click(object sender, EventArgs e)
        {
            refresh();
        }
    }
}
