using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;
using NetLib.Networking;
using NWR_Client;
using Net_Weave_R.Forms.Popups;

namespace Net_Weave_R.Forms
{
    public partial class BugReport : Form
    {
        public BugReport()
        {
            InitializeComponent();
            Functions.Center(this);
            GenerateCapa();
            Icon = GlobalProperties.ApplicationIcon;
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
        const string chars = "ABCDEGGHIJKLMNOPQRSTUVWXYZ0123456789";
        void GenerateCapa()
        {
            Random r = new Random();
            int len = lblCapa.Text.Length;
            lblCapa.ResetText();
            for (int i = 0; i < 8; i++)
            {
                lblCapa.Text += chars[r.Next(0, chars.Length - 1)].ToString();
                Thread.Sleep(100);
            }
        }
        private void btnSubmit_Click(object sender, EventArgs e)
        {
            if (txtCaptcha.Text != lblCapa.Text)
            {
                MessageBox.Show("Invalid Captcha.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            PacketWriter w = new PacketWriter();
            w.Write((int)Header.BUG);
            w.Write(txtTitle.Text);
            w.Write(txtMessage.Text);
            w.Write(GlobalProperties.Client.Username);
            w.Write(DateTime.Now.ToString("d").Replace("/", "-"));
            GlobalProperties.Client.Send(w.ToArray(true));
            GenerateCapa();

            MessageBox.Show("The bug report has been submitted.", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }
    }
}
