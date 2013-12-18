using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;
using Net_Weave_R.Misc;

namespace Net_Weave_R.Forms
{
    public partial class Log : Form
    {
        public Size minSize;
        int numLog;
        Main main;
        public Log(Main main)
        {
            InitializeComponent();
            this.main = main;
            EventLogger.EventLogged += new EventHandler<EventLoggerEventArgs>(EventLogger_EventLogged);
            Text = "Log (0)";
            carbonTheme1.Text = Text;
            numLog = 0;
            Height = main.Height;
            main.LocationChanged += new EventHandler(main_LocationChanged);
            main.SizeChanged += new EventHandler(main_SizeChanged);
            main.AddOwnedForm(this);
            Location = new Point((main.Location.X + main.Width) + 3, main.Location.Y);
            Icon = GlobalProperties.ApplicationIcon;
            xListview1.Columns[0].Width = 137;
            xListview1.Columns[1].Width = 195;
            xListview1.Columns[2].Width = 145;
        }
        protected override void SetVisibleCore(bool value)
        {
            if (value)
            {
                base.SetVisibleCore(value);
            }
            else
            {
                Opacity = 1.0;
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
                        base.SetVisibleCore(value);
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
        void main_SizeChanged(object sender, EventArgs e)
        {
            if (main.WindowState == FormWindowState.Minimized)
            {
                this.WindowState = FormWindowState.Minimized;
            }
            else
                this.WindowState = FormWindowState.Normal;

            Height = main.Height;
        }

        void main_LocationChanged(object sender, EventArgs e)
        {
            Location = new Point((main.Location.X + main.Width) + 3, main.Location.Y);
        }

        void EventLogger_EventLogged(object sender, EventLoggerEventArgs e)
        {
            if (!IsDisposed)
            {
                Invoke((MethodInvoker)delegate
                {
                    xListview1.Items.Add(new ListViewItem(new string[] { e.Event, e.Description, e.Time.ToString() }));
                    numLog++;
                    Text = "Log (" + numLog.ToString() + ")";
                    carbonTheme1.Text = Text;
                    xListview1.Items[numLog - 1].EnsureVisible();
                });
            }
        }

        private void clearToolStripMenuItem_Click(object sender, EventArgs e)
        {
            xListview1.Items.Clear();
            numLog = 0;
            Text = "Log (0)";
            carbonTheme1.Text = Text;
        }

        public void SetRecv(string t)
        {
            lblRecv.Text = "Data Received: " + t;
        }

        public void SetSent(string t)
        {
            lblSent.Text = "Data Sent: " + t;
        }
    }
}
