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
    public partial class IconSelecterDialog : Form
    {
        int selected = -1;
        ImageList icons;
        public int Selected
        {
            get
            {
                return selected;
            }
        }
        public IconSelecterDialog(SortedList<int, Icon> iconList)
        {
            InitializeComponent();
            icons = new ImageList();
            icons.ColorDepth = ColorDepth.Depth32Bit;
            icons.ImageSize = new System.Drawing.Size(64, 64);
            lstIcons.LargeImageList = icons;
            foreach (KeyValuePair<int, Icon> icon in iconList)
            {
                ListViewItem i = new ListViewItem();
                i.Text = icon.Value.Width + " x " + icon.Value.Height;
                i.Tag = icon.Key;
                icons.Images.Add(icon.Value);
                i.ImageIndex = icons.Images.Count - 1;
                lstIcons.Items.Add(i);
            }
        }
        private void lstIcons_DoubleClick(object sender, EventArgs e)
        {
            if (lstIcons.SelectedItems.Count != 1)
            {
                MessageBox.Show("Select an icon!", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return;
            }

            selected = (int)lstIcons.SelectedItems[0].Tag;
            DialogResult = System.Windows.Forms.DialogResult.OK;
            Close();
        }
    }
}
