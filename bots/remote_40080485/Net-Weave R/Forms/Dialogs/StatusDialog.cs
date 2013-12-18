using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace Net_Weave_R.Forms.Dialogs
{
    public partial class StatusDialog : Form
    {
        public StatusDialog()
        {
            InitializeComponent();
        }
        public void SetStatus(string t)
        {
            Invoke((MethodInvoker)delegate
            {
                label1.Text = t;
            });
        }
    }
}
