using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Misc;
namespace Net_Weave_R.Forms.Popups
{
    public partial class MsgBox : Form
    {
        public MsgBox()
        {
            InitializeComponent();
            Functions.Center(this);
        }
        public static DialogResult Show(string text, string title, MessageBoxButtons buttons, MessageBoxIcon icon)
        {
            MsgBox b = new MsgBox();
            b.lblText.Text = text;
            b.carbonTheme1.Text = title;
            int soundType = 0;
            switch (icon)
            {
                case MessageBoxIcon.Information:
                    b.picIcon.Image = SystemIcons.Information.ToBitmap();
                    break;

                case MessageBoxIcon.Exclamation:
                    b.picIcon.Image = SystemIcons.Exclamation.ToBitmap();
                    soundType = 1;
                    break;

                case MessageBoxIcon.Error:
                    b.picIcon.Image = SystemIcons.Error.ToBitmap();
                    soundType = 2;
                    break;
            }

            if (soundType == 0)
                System.Media.SystemSounds.Asterisk.Play();
            if (soundType == 1)
                System.Media.SystemSounds.Exclamation.Play();
            if (soundType == 2)
                System.Media.SystemSounds.Hand.Play();

            switch (buttons)
            {
                case MessageBoxButtons.OK:
                    b.panelOk.BringToFront();
                    break;
                case MessageBoxButtons.YesNo:
                    b.panelYesNo.BringToFront();
                    break;
                case MessageBoxButtons.YesNoCancel:
                    b.panelYesNoCancel.BringToFront();
                    break;
            }


            b.ShowDialog();
            DialogResult res = b.DialogResult;
            b.Dispose();
            b = null;
            return res;
        }

        private void carbonButton1_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.OK;
            Close();
        }

        private void carbonButton2_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.Yes;
            Close();
        }

        private void carbonButton3_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.No;
            Close();
        }

        private void carbonButton4_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.Yes;
            Close();
        }

        private void carbonButton5_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.No;
            Close();
        }

        private void carbonButton6_Click(object sender, EventArgs e)
        {
            DialogResult = System.Windows.Forms.DialogResult.Cancel;
            Close();
        }    
    }
}
