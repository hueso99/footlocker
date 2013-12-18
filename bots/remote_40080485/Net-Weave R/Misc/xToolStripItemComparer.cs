using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace Net_Weave_R.Misc
{
    class xToolStripItemComparer : IComparer<ToolStripMenuItem>
    {
        public int Compare(ToolStripMenuItem x, ToolStripMenuItem y)
        {
            return (string.Compare(((XPlugin)x.Tag).Guid.ToString(), ((XPlugin)y.Tag).Guid.ToString()));
        }
    }
}
