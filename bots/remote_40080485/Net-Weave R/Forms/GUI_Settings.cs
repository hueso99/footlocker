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
using NetLib.API;
using NetLib.Forms.API;
using Net_Weave_R.Forms.Popups;
using System.Security;
using NetLib.Misc;

namespace Net_Weave_R.Forms
{
    public partial class GUI_Settings : Form
    {
        List<int> portCopy;
        List<string> passwordCopy;
        public GUI_Settings()
        {
            InitializeComponent();
            Functions.Center(this);
            Icon = GlobalProperties.ApplicationIcon;
            Load += new EventHandler(GUI_Settings_Load);
            portCopy = new List<int>();
            passwordCopy = new List<string>();
            portCopy.AddRange(Settings.Ports.ToArray());
            passwordCopy.AddRange(Settings.Passwords.ToArray());
        }

        void GUI_Settings_Load(object sender, EventArgs e)
        {
            loadUI();
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

        private void btnShowConsole_Click(object sender, EventArgs e)
        {
            if (Settings.HideConsole)
            {
                User32.ShowWindow(GlobalProperties.ConsoleHandle, 5);
                Settings.HideConsole = !Settings.HideConsole;
            }
            else
            {
                User32.ShowWindow(GlobalProperties.ConsoleHandle, 0);
                Settings.HideConsole = !Settings.HideConsole;
            }
        }

        private void btnSaveSettings_Click(object sender, EventArgs e)
        {
            set();
            Settings.Save();
            
            //ni.("Saved.", "Settings have been saved.", 2000, ToolTipIcon.Info);
            Close();
        }

        void loadUI()
        {
            foreach (string s in Settings.Passwords)
            {
                ListViewItem lvi = new ListViewItem();
                lvi.Text = new string('*', s.Length);
                lvi.Tag = s;
                lstPasswords.Items.Add(lvi);
            }

            foreach (int i in Settings.Ports)
            {
                lstPorts.Items.Add(i.ToString());
            }

            xDup.Checked = Settings.DupPrevnt;
            xLogCon.Checked = Settings.LogConnected;
            xLogDis.Checked = Settings.LogDisconnected;
            xNoteCon.Checked = Settings.NotifyConnected;
            xNoteDis.Checked = Settings.NotifyDisconnected;
            txtLimit.Text = Settings.Limit.ToString();
        }

        void set()
        {
            bool portMod = false;
            for (int i = 0; i < portCopy.Count; i++)
            {
                if (!Settings.Ports.Contains(portCopy[i]))
                {
                    Settings.Ports = portCopy;
                    portMod = true;
                    GlobalProperties.MainForm.RestartListeners();
                    break;
                }
            }

            if (!portMod)
            {
                if (portCopy.Count != Settings.Ports.Count)
                {
                    Settings.Ports = portCopy;
                    portMod = true;
                    GlobalProperties.MainForm.RestartListeners();
                }
            }

            Settings.Passwords = passwordCopy;

            Settings.DupPrevnt = xDup.Checked;
            Settings.LogConnected = xLogCon.Checked;
            Settings.LogDisconnected = xLogDis.Checked;
            Settings.NotifyConnected = xNoteCon.Checked;
            Settings.NotifyDisconnected = xNoteDis.Checked;

            try
            {
                int lim = (int)double.Parse(txtLimit.Text);
                if (lim > -1)
                    Settings.Limit = lim;
            }
            catch
            {
                Settings.Limit = 0;
            }
        }

        private void viewToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (lstPasswords.SelectedItems.Count < 1)
            {
                MessageBox.Show("Invalid Selection.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            MessageBox.Show(lstPasswords.SelectedItems[0].Tag.ToString());
        }

        private void toolStripMenuItem1_Click(object sender, EventArgs e)
        {
            foreach (ListViewItem i in lstPasswords.SelectedItems)
            {
                passwordCopy.Remove(i.Tag.ToString());
                
                i.Remove();
            }
        }

        private void carbonButton2_Click(object sender, EventArgs e)
        {
            int port = (int)double.Parse(txtPort.Text);

            if (portCopy.Contains(port))
            {
                return;
            }

            portCopy.Add(port);
            lstPorts.Items.Add(port.ToString());

            txtPort.ResetText();
        }

        private void carbonButton3_Click(object sender, EventArgs e)
        {
            if (passwordCopy.Contains(txtPasswords.Text))
                return;
            ListViewItem lvi = new ListViewItem();
            lvi.Text = new string('*', txtPasswords.Text.Length);
            lvi.Tag = txtPasswords.Text;
            lstPasswords.Items.Add(lvi);
            passwordCopy.Add(txtPasswords.Text);
            txtPasswords.ResetText();
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            foreach (ListViewItem i in lstPorts.SelectedItems)
            {
                portCopy.Remove(int.Parse(i.Text));
                i.Remove();
            }
        }

        private void btnResetTotal_Click(object sender, EventArgs e)
        {
            if (MessageBox.Show("Are you sure?", "", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) != System.Windows.Forms.DialogResult.Yes)
                return;

            try
            {
                SettingsWriter w = new SettingsWriter(Settings.Reg);
                w.Write(0, "TOTAL");
                w.Close("Total");
                GlobalProperties.MainForm.ResetTotal();
            }
            catch
            {
            }
        }
    }
}
