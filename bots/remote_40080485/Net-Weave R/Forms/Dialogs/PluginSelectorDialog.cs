using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;

namespace Net_Weave_R.Forms.Dialogs
{
    public partial class PluginSelectorDialog : Form
    {
        List<byte[]> plugins = new List<byte[]>();
        public List<byte[]> RawPluginList { get { return plugins; } }
        public PluginSelectorDialog()
        {
            InitializeComponent();
            Load += new EventHandler(PluginSelectorDialog_Load);
            FormClosing += new FormClosingEventHandler(PluginSelectorDialog_FormClosing);
        }
        void PluginSelectorDialog_FormClosing(object sender, FormClosingEventArgs e)
        {
            if (plugins.Count == 0 || !ready)
                DialogResult = System.Windows.Forms.DialogResult.Cancel;
        }

        void PluginSelectorDialog_Load(object sender, EventArgs e)
        {
            LoadPlugins();
        }

        private void xPlugins_KeyPress(object sender, KeyPressEventArgs e)
        {
            if (((Keys)(int)e.KeyChar) == Keys.Enter)
            {
                foreach (ListViewItem item in lstPlugins.CheckedItems)
                {
                    for (int i = 0; i < GlobalProperties.RawPlugins.Count; i++)
                    {
                        if (GlobalProperties.RawPlugins.Keys[i] == (item.Tag as XPlugin).Guid)
                        {
                            plugins.Add(GlobalProperties.RawPlugins.Values[i]);
                        }
                    }
                }
                DialogResult = System.Windows.Forms.DialogResult.OK;
                readyClose();
            }
        }
        bool ready = false;
        void readyClose()
        {
            ready = true;
            Close();
        }
        void LoadPlugins()
        {
            new Thread(delegate()
                {
                    for (int i = 0; i < GlobalProperties.InitializedPlugins.Count; i++)
                    {
                        XPlugin plugin = GlobalProperties.InitializedPlugins.Values[i];
                        ListViewItem item = new ListViewItem();
                        item.Checked = true;
                        item.Text = plugin.Name;
                        item.SubItems.Add(plugin.Description);
                        item.SubItems.Add(plugin.Version.ToString());
                        item.SubItems.Add(plugin.Author);
                        item.SubItems.Add(Functions.FormatBytes(GlobalProperties.RawPlugins.Values[i].Length));
                        item.Tag = plugin;
                        Invoke((MethodInvoker)delegate
                        {
                            lstPlugins.Items.Add(item);
                        });
                    }
                }).Start();
        }
    }
}
