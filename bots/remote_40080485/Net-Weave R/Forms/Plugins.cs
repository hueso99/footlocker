using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Misc;
using System.Threading;
using Net_Weave_R.Core;
using System.IO;
using System.Reflection;
using Net_Weave_R.Forms.Popups;

namespace Net_Weave_R.Forms
{
    public partial class Plugins : Form
    {
        bool modified;
        public Plugins()
        {
            InitializeComponent();
            Functions.Center(this);
            Icon = GlobalProperties.ApplicationIcon;
            Load += new EventHandler(Plugins_Load);
            modified = false;
        }

        void Plugins_Load(object sender, EventArgs e)
        {
            LoadPlugins();
        }
        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            if (modified)
            {
                if (MessageBox.Show("Save Plugins?", "", MessageBoxButtons.YesNo, MessageBoxIcon.Question) == System.Windows.Forms.DialogResult.Yes)
                {
                    save();
                }
            }
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

        private void filessToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog o = new OpenFileDialog())
            {
                o.Filter = "Dynamic Link Libary (*.dll)|*.dll";
                o.Multiselect = true;
                if (o.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    for (int i = 0; i < o.FileNames.Length; i++)
                    {
                        byte[] bytes = File.ReadAllBytes(o.FileNames[i]);
                        LoadPlugin(bytes);
                    }
                    modified = true;
                }
            }
        }

        void LoadPlugins()
        {
            if (GlobalProperties.InitializedPlugins.Count < 1)
                return;
            new Thread(() =>
            {
                foreach (XPlugin plugin in GlobalProperties.InitializedPlugins.Values)
                {
                    ListViewItem item = new ListViewItem();
                    item.Text = plugin.Name;
                    item.SubItems.Add(plugin.Description);
                    item.SubItems.Add(plugin.Version.ToString());
                    item.SubItems.Add(plugin.Author);
                    item.Tag = plugin;
                    Invoke((MethodInvoker)delegate
                    {
                        lstPlugins.Items.Add(item);
                    });
                }
            }).Start();
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (lstPlugins.SelectedItems.Count < 1) return;
            if (MessageBox.Show("Are you sure?\n" + lstPlugins.SelectedItems.Count + " plugin(s) will be removed.", "", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) != System.Windows.Forms.DialogResult.Yes) return;

            foreach (ListViewItem item in lstPlugins.SelectedItems)
            {
                XPlugin plugin = (item.Tag as XPlugin);
                GlobalProperties.RawPlugins.Remove(plugin.Guid);
                GlobalProperties.InitializedPlugins.Remove(plugin.Guid);
                item.Remove();
            }
            modified = true;
            PluginHelper.pluginChanged();
        }

        private void folderToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (FolderBrowserDialog f = new FolderBrowserDialog())
            {
                f.ShowNewFolderButton = false;
                if (f.ShowDialog() != System.Windows.Forms.DialogResult.OK) return;

                string[] files = Directory.GetFiles(f.SelectedPath, "*.*", SearchOption.AllDirectories);
                for (int i = 0; i < files.Length; i++)
                {
                    if (!files[i].Contains(".dll"))
                        continue;
                    byte[] bytes = File.ReadAllBytes(files[i]);
                    LoadPlugin(bytes);
                }
                modified = true;
            }
        }
        void LoadPlugin(byte[] bytes)
        {
            new Thread(() =>
            {
                Assembly asm;
                try
                {
                    asm = Assembly.Load(bytes);
                }
                catch(Exception ex)
                {
                    MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }
                foreach (Type type in asm.GetTypes())
                {
                    if (type.IsSubclassOf(typeof(XPlugin)))
                    {
                        try
                        {
                            XPlugin plugin = Activator.CreateInstance(type) as XPlugin;
                            if (GlobalProperties.InitializedPlugins.ContainsKey(plugin.Guid))
                            {
                                DialogResult res = MessageBox.Show(string.Format("{0} contains the same GUID as {1}. Remove plugin and continue?", plugin.Name, GlobalProperties.InitializedPlugins[plugin.Guid].Name), "", MessageBoxButtons.YesNo, MessageBoxIcon.Warning);
                                if (res == System.Windows.Forms.DialogResult.No)
                                {
                                    plugin = null;
                                    continue;
                                }
                                else
                                {
                                    GlobalProperties.RawPlugins.Remove(plugin.Guid);
                                    GlobalProperties.InitializedPlugins.Remove(plugin.Guid);
                                    for (int i = 0; i < lstPlugins.Items.Count; i++)
                                    {
                                        bool found = false;
                                        Invoke((MethodInvoker)delegate
                                        {
                                            if ((lstPlugins.Items[i].Tag as XPlugin).Guid == plugin.Guid)
                                            {
                                                lstPlugins.Items[i].Remove();
                                                found = true;
                                            }
                                        });
                                        if (found)
                                            break;
                                    }
                                }
                            }
                            GlobalProperties.RawPlugins.Add(plugin.Guid, bytes);
                            GlobalProperties.InitializedPlugins.Add(plugin.Guid, plugin);
                            ListViewItem item = new ListViewItem(new string[] { plugin.Name, plugin.Description, plugin.Version.ToString(), plugin.Author });
                            item.Tag = plugin;
                            Invoke((MethodInvoker)delegate
                            {
                                lstPlugins.Items.Add(item);
                                PluginHelper.pluginChanged();
                            });
                            modified = true;
                        }
                        catch (Exception ex)
                        {
                            MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                            return;
                        }
                    }
                }
            }).Start();
        }

        void save()
        {
            GlobalProperties.NI.ShowBalloonTip(2000, "Saving Plugins...", "The plugins are now being saved.", ToolTipIcon.Info);
            new Thread(delegate()
                {
                    SettingsWriter w = new SettingsWriter(Settings.Reg);
                    w.Write(GlobalProperties.RawPlugins, "Plugins");
                    w.Close("Plugins");
                }).Start();
            modified = false;
        }

        private void saveToolStripMenuItem_Click(object sender, EventArgs e)
        {
            save();
        }
    }
}
