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

namespace Net_Weave_R.Forms.Dialogs
{
    public partial class TermsOfService : Form
    {
        public TermsOfService()
        {
            InitializeComponent();

            Functions.Center(this);

            new Thread(() =>
                {
                    int timeLeft = 10;

                    while (timeLeft > 0)
                    {
                        timeLeft -= 1;
                        if (IsDisposed)
                        {
                            break;
                        }
                        Invoke((MethodInvoker)delegate
                        {
                            carbonButton1.Text = "Agree (" + timeLeft.ToString() + ")";
                        });
                        Thread.Sleep(1000);
                    }
                    if (IsDisposed)
                    {
                        return;
                    }
                    Invoke((MethodInvoker)delegate
                    {
                        carbonButton1.Text = "Agree";
                        carbonButton1.Enabled = true;
                        carbonCheckBox1.Visible = true;
                    });
                }).Start();
        }
        public bool Result;
        public bool Remember;
        public static new bool Show()
        {
            TermsOfService t = new TermsOfService();
            t.ShowDialog();
            bool res = t.Result;
            bool rem = t.Remember;
            t.Dispose();
            t = null;

            Settings.WriteTosAnswer(rem);

            return res;
        }

        private void carbonButton1_Click(object sender, EventArgs e)
        {
            Result = true;
            Remember = carbonCheckBox1.Checked;
            Close();
        }

        private void carbonButton2_Click(object sender, EventArgs e)
        {
            Result = false;
            Remember = carbonCheckBox1.Checked;
            Close();
        }
    }
}
