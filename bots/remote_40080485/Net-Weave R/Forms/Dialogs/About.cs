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
    public partial class About : Form
    {
        public About()
        {
            InitializeComponent();
            Icon = GlobalProperties.ApplicationIcon;
            label1.Text = "Version: " + Application.ProductVersion;
            expandAll();
            //xTree.Nodes[2].ExpandAll();
        }

        private void xTree_AfterSelect(object sender, TreeViewEventArgs e)
        {
            xTree.SelectedImageIndex = xTree.SelectedNode.ImageIndex;
            expandAll();
        }

        void expandAll()
        {
            xTree.Nodes[0].ExpandAll();
            xTree.Nodes[0].Nodes[0].ExpandAll();
            xTree.Nodes[1].ExpandAll();
            xTree.Nodes[2].ExpandAll();
            xTree.Nodes[3].ExpandAll();
        }
    }
}
