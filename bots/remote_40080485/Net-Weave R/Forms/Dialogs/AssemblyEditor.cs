using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;

using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Diagnostics;
using Net_Weave_R.Misc;
namespace Net_Weave_R.Forms.Dialogs
{
    public partial class AssemblyEditor : Form
    {
        public AssemblyEditor()
        {
            InitializeComponent();
            Load += new EventHandler(AssemblyEditor_Load);
            tv.AfterSelect +=new TreeViewEventHandler(tv_AfterSelect);
            txtIconPath.Tag = string.Empty;
            tv.Nodes[7].Nodes[0].Text = Guid.NewGuid().ToString();
        }

        void tv_AfterSelect(object sender, TreeViewEventArgs e)
        {
            if (e.Node.Parent == null)
                return;
            e.Node.BeginEdit();
        }

        void AssemblyEditor_Load(object sender, EventArgs e)
        {
            tv.ExpandAll();
            if (GlobalProperties.BuildAssembly != null)
            {
                IAssembly asm = GlobalProperties.BuildAssembly;
                tv.Nodes[0].Nodes[0].Text = asm.Title;
                tv.Nodes[1].Nodes[0].Text = asm.Description;
                tv.Nodes[2].Nodes[0].Text = asm.Configuration;
                tv.Nodes[3].Nodes[0].Text = asm.Company;
                tv.Nodes[4].Nodes[0].Text = asm.Copyright;
                tv.Nodes[5].Nodes[0].Text = asm.Trademark;
                tv.Nodes[6].Nodes[0].Text = asm.Culture;
                tv.Nodes[7].Nodes[0].Text = asm.Guid;
                tv.Nodes[8].Nodes[0].Text = asm.AssemblyVersion;
                tv.Nodes[9].Nodes[0].Text = asm.AssemblyFileVersion;
                if (!string.IsNullOrEmpty(asm.IconPath))
                {
                    txtIconPath.Text = Path.GetFileName(asm.IconPath);
                    txtIconPath.Tag = asm.IconPath;
                    pBox.Image = Icon.ExtractAssociatedIcon(asm.IconPath).ToBitmap();
                }
                //tv.Nodes[10].Nodes[0].Text = asm.
            }
        }
        //264, 480

        private void contextMenuStrip1_Opening(object sender, CancelEventArgs e)
        {
            if (tv.SelectedNode != null)
            {
                if (tv.SelectedNode.Parent == null)
                    return;
                if (tv.SelectedNode.Parent.Text != "Guid")
                {
                    e.Cancel = true;
                }
            }
            else
            {
                e.Cancel = true; 
            }
        }

        private void tv_AfterLabelEdit(object sender, NodeLabelEditEventArgs e)
        {
            e.Node.EndEdit(false);
        }

        private void generateGUIDToolStripMenuItem_Click(object sender, EventArgs e)
        {
            tv.Nodes[7].Nodes[0].Text = Guid.NewGuid().ToString();
        }

        private void btnOpenIcon_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog o = new OpenFileDialog())
            {
                Icon icon;
                o.Filter = "Icon Sources (*.ico, *.exe) |*.ico;*.exe";
                if (o.ShowDialog() != System.Windows.Forms.DialogResult.OK) return;
                txtIconPath.Text = o.SafeFileName;
                txtIconPath.Tag = o.FileName;
                icon = Icon.ExtractAssociatedIcon(o.FileName);
                pBox.Image = icon.ToBitmap();
            }
        }

        private void btnClone_Click(object sender, EventArgs e)
        {
            using (OpenFileDialog o = new OpenFileDialog())
            {
                o.Filter = "Executables |*.exe";
                if (o.ShowDialog() != System.Windows.Forms.DialogResult.OK)
                    return;

                txtIconPath.Text = o.SafeFileName;
                txtIconPath.Tag = o.FileName;
                pBox.Image = Icon.ExtractAssociatedIcon(o.FileName).ToBitmap();

                FileVersionInfo info = FileVersionInfo.GetVersionInfo(o.FileName);
                tv.Nodes[0].Nodes[0].Text = info.InternalName;
                tv.Nodes[1].Nodes[0].Text = info.FileDescription;
                tv.Nodes[2].Nodes[0].Text = "";
                tv.Nodes[3].Nodes[0].Text = info.CompanyName;
                tv.Nodes[4].Nodes[0].Text = info.LegalCopyright;
                tv.Nodes[5].Nodes[0].Text = info.LegalTrademarks;
                tv.Nodes[6].Nodes[0].Text = "";
                tv.Nodes[7].Nodes[0].Text = Guid.NewGuid().ToString();

                string version = string.Empty;
                try
                {
                    info.FileVersion.ToString().Replace(",", ".");
                }
                catch
                {
                    version = "1.0.0.0";
                }
                int len = version.Split('.').Length;
                if (len != 4)
                    for (int i = 0; i < 4 - len; i++)
                    {
                        version += ".0";
                    }

                tv.Nodes[8].Nodes[0].Text = version;

                try
                {
                    version = info.ProductVersion.ToString().Replace(",", ".");
                }
                catch
                {
                    version = "1.0.0.0";
                }
                len = version.Split('.').Length;
                if (len != 4)
                    for (int i = 0; i < 4 - len; i++)
                    {
                        version += ".0";
                    }

                tv.Nodes[9].Nodes[0].Text = version;
                //tv.Nodes[8].Nodes[0].Text = info.FileVersion.ToString().Replace(",", ".");
                //tv.Nodes[9].Nodes[0].Text = info.ProductVersion.ToString().Replace(",", ".");
            }
        }

        private void carbonButton1_Click(object sender, EventArgs e)
        {
            IAssembly asm = new IAssembly(tv.Nodes[0].Nodes[0].Text, tv.Nodes[1].Nodes[0].Text, tv.Nodes[2].Nodes[0].Text, tv.Nodes[3].Nodes[0].Text,
    tv.Nodes[4].Nodes[0].Text, tv.Nodes[5].Nodes[0].Text, tv.Nodes[6].Nodes[0].Text, tv.Nodes[7].Nodes[0].Text, tv.Nodes[8].Nodes[0].Text,
    tv.Nodes[9].Nodes[0].Text, txtIconPath.Tag.ToString());
            GlobalProperties.BuildAssembly = asm;
            DialogResult = System.Windows.Forms.DialogResult.OK;
            this.Close();
        }

        private void carbonButton2_Click(object sender, EventArgs e)
        {
            txtIconPath.Tag = string.Empty;
            txtIconPath.ResetText();
            pBox.Image = null;
        }

        private void carbonButton3_Click(object sender, EventArgs e)
        {
            GlobalProperties.BuildAssembly = null;
            DialogResult = System.Windows.Forms.DialogResult.OK;
            this.Close();
        }
    }
}
