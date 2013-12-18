using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Misc;
using System.IO;

namespace Net_Weave_R.Forms.Dialogs
{
    public partial class DownloadEx : Form
    {
        public DownloadEx()
        {
            InitializeComponent();
            Icon = GlobalProperties.ApplicationIcon;
        }
        public bool ExecuteOnly
        {
            get;
            private set;
        }
        public string UpdatePassword
        {
            get;
            private set;
        }

        public string FileLocation
        {
            get;
            private set;
        }

        public bool IsUrl
        {
            get;
            private set;
        }
        private void btnFromFile_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog o = new OpenFileDialog())
            {
                o.Filter = "All Files (*.*)|*.*";

                if (o.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    txtUrl.Text = o.FileName;
                }
            }
        }

        private void btnExecute_Click(object sender, EventArgs e)
        {
            ExecuteOnly = !xUpdate.Checked;

            FileLocation = txtUrl.Text;

            IsUrl = !File.Exists(FileLocation);

            UpdatePassword = txtPassword.Text;

            DialogResult = System.Windows.Forms.DialogResult.OK;

            Close();
        }
    }
}
