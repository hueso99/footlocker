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

namespace Net_Weave_R.Forms.Popups
{
    public partial class Notify : Form
    {
        public Notify()
        {
            InitializeComponent();
        }
        Thread t, t1;
        Thread s;
        public int sleepTime = 0;
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            if (killed)
            {
                base.OnFormClosing(e);
                return;
            }

            if (Opacity != 0.0)
            {
                e.Cancel = true;
                t1 = new Thread(() =>
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
                });
                t1.Start();
            }
        }
        protected override void OnVisibleChanged(EventArgs e)
        {
            if (Visible)
            {
                Opacity = 0.0;
                t = new Thread(() =>
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
                    Invoke((MethodInvoker)delegate
                    {
                        s = new Thread(() =>
                        {
                            Thread.Sleep(sleepTime);
                            if (!IsDisposed)
                                Invoke((MethodInvoker)delegate
                                {
                                    Close();
                                });
                        });
                        s.Start();
                    });
                });
                t.Start();
            }
        }
        public bool killed = false;
        public void KillThread()
        {
            if (t != null)
                t.Abort();
            if (s != null)
                s.Abort();
            if (t1 != null)
                t1.Abort();
            killed = true;
        }
        static Notify n = null;
        public static void Show(string title, string text, int milliseconds, ToolTipIcon icon)
        {
            if (n != null)
            {
                n.KillThread();
                n.Close();
                n.Dispose();
                n = null;
            }
            n = new Notify();
            n.carbonTheme1.Text = title;
            n.label1.Text = text;
            n.sleepTime = milliseconds;
            switch (icon)
            {
                case ToolTipIcon.Info:
                    {
                        n.boxIcon.Image = new Bitmap(SystemIcons.Information.ToBitmap(), 26, 26);
                    }
                    break;
                case ToolTipIcon.Error:
                    {
                        n.boxIcon.Image = new Bitmap(SystemIcons.Error.ToBitmap(), 26, 26);
                    }
                    break;
                case ToolTipIcon.Warning:
                    {
                        n.boxIcon.Image = new Bitmap(SystemIcons.Exclamation.ToBitmap(), 26, 26);
                    }
                    break;
            }
            n.TopMost = true;
            n.Location = new Point(Screen.PrimaryScreen.WorkingArea.Width - n.Width, Screen.PrimaryScreen.WorkingArea.Bottom - n.Height);
            n.Show();
        }
        public static void KillAndClose()
        {
            if (n != null)
            {
                n.KillThread();
                n.Close();
            }
        }
    }
}
