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
    public partial class FloodPanelTypeDialog : Form
    {
        public bool Single = true;
        public FloodPanelTypeDialog()
        {
            InitializeComponent();
            FormClosing += new FormClosingEventHandler(FloodPanelTypeDialog_FormClosing);
        }

        void FloodPanelTypeDialog_FormClosing(object sender, FormClosingEventArgs e)
        {

        }

        private void carbonRadioButton1_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)(int)(Keys.Enter))
            {
                DialogResult = System.Windows.Forms.DialogResult.OK;
                Single = carbonRadioButton1.Checked;
                Close();
            }
        }

        private void carbonRadioButton2_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)(int)(Keys.Enter))
            {
                DialogResult = System.Windows.Forms.DialogResult.OK;
                Single = carbonRadioButton1.Checked;
                Close();
            }
        }

        private void carbonTheme1_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (e.KeyChar == (char)(int)(Keys.Enter))
            {
                Single = carbonRadioButton1.Checked;
                Close();
            }
        }

        private void carbonButton1_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.OK;
            Single = carbonRadioButton1.Checked;
            Close();
        }
    }
}
