using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;

namespace Net_Weave_R.Forms
{
    public partial class GUI_PluginDatabase : Form
    {
        public GUI_PluginDatabase()
        {
            InitializeComponent();
            Functions.Center(this);
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
    }
}
