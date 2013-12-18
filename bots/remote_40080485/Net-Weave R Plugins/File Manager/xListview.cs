using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Collections;
using System.Windows.Forms;
using System.Runtime.InteropServices;
using System.Drawing;

namespace File_Manager
{
    public class xListview : ListView
    {
        #region Interop-Defines
        [DllImport("user32.dll")]
        private static extern IntPtr SendMessage(IntPtr hWnd, int msg, IntPtr wPar, IntPtr lPar);
        private const int LVM_FIRST = 0x1000;
        private const int LVM_GETCOLUMNORDERARRAY = (LVM_FIRST + 59);
        private const int WM_PAINT = 0x000F;
        #endregion
        #region Controls
        private struct EmbeddedControl
        {
            public Control Control;
            public int Column;
            public int Row;
            public DockStyle Dock;
            public ListViewItem Item;
        }

        private ArrayList _embeddedControls = new ArrayList();


        protected int[] GetColumnOrder()
        {
            IntPtr lPar = Marshal.AllocHGlobal(Marshal.SizeOf(typeof(int)) * Columns.Count);

            IntPtr res = SendMessage(Handle, LVM_GETCOLUMNORDERARRAY, new IntPtr(Columns.Count), lPar);
            if (res.ToInt32() == 0)
            {
                Marshal.FreeHGlobal(lPar);
                return null;
            }

            int[] order = new int[Columns.Count];
            Marshal.Copy(lPar, order, 0, Columns.Count);

            Marshal.FreeHGlobal(lPar);

            return order;
        }
        protected Rectangle GetSubItemBounds(ListViewItem Item, int SubItem)
        {
            Rectangle subItemRect = Rectangle.Empty;

            if (Item == null)
                throw new ArgumentNullException("Item");

            int[] order = GetColumnOrder();
            if (order == null)
                return subItemRect;

            if (SubItem >= order.Length)
                throw new IndexOutOfRangeException("SubItem " + SubItem + " out of range");
            Rectangle lviBounds = Item.GetBounds(ItemBoundsPortion.Entire);
            int subItemX = lviBounds.Left;
            ColumnHeader col;
            int i;
            for (i = 0; i < order.Length; i++)
            {
                col = this.Columns[order[i]];
                if (col.Index == SubItem)
                    break;
                subItemX += col.Width;
            }

            subItemRect = new Rectangle(subItemX, lviBounds.Top, this.Columns[order[i]].Width, lviBounds.Height);

            return subItemRect;
        }
        public void AddEmbeddedControl(Control c, int col, int row)
        {
            AddEmbeddedControl(c, col, row, DockStyle.Fill);
        }
        public void AddEmbeddedControl(Control c, int col, int row, DockStyle dock)
        {
            if (c == null)
                throw new ArgumentNullException();
            if (col >= Columns.Count || row >= Items.Count)
                throw new ArgumentOutOfRangeException();

            EmbeddedControl ec;
            ec.Control = c;
            ec.Column = col;
            ec.Row = row;
            ec.Dock = dock;
            ec.Item = Items[row];

            _embeddedControls.Add(ec);

            c.Click += new EventHandler(_embeddedControl_Click);

            this.Controls.Add(c);
            Invalidate();
        }

        public void RemoveEmbeddedControl(Control c)
        {
            if (c == null)
                throw new ArgumentNullException();

            for (int i = 0; i < _embeddedControls.Count; i++)
            {
                EmbeddedControl ec = (EmbeddedControl)_embeddedControls[i];
                if (ec.Control == c)
                {
                    c.Click -= new EventHandler(_embeddedControl_Click);
                    this.Controls.Remove(c);
                    _embeddedControls.RemoveAt(i);
                    return;
                }
            }
            throw new Exception("Control not found!");
        }

        public Control GetEmbeddedControl(int col, int row)
        {
            foreach (EmbeddedControl ec in _embeddedControls)
                if (ec.Row == row && ec.Column == col)
                    return ec.Control;

            return null;
        }

        private void _embeddedControl_Click(object sender, EventArgs e)
        {
            foreach (EmbeddedControl ec in _embeddedControls)
            {
                if (ec.Control == (Control)sender)
                {
                    this.SelectedItems.Clear();
                    ec.Item.Selected = true;
                }
            }
        }
        #endregion

        [DllImport("uxtheme", CharSet = CharSet.Unicode)]
        public static extern int SetWindowTheme(IntPtr hWnd, string textSubAppName, string textSubIdList);
        public xListview()
        {
            this.DoubleBuffered = true;
        }
        protected override void OnColumnClick(ColumnClickEventArgs e)
        {
            if (Items.Count == 0)
                return;
            ListViewItemSorter = new ListViewItemComparer(e.Column);
            Sort();
            ListViewItemSorter = null;
            base.OnColumnClick(e);
            switch (Sorting)
            {
                case SortOrder.None:
                case SortOrder.Ascending:
                    Sorting = SortOrder.Descending;
                    break;

                case SortOrder.Descending:
                    Sorting = SortOrder.Ascending;
                    break;
            }
        }
        protected override bool ShowFocusCues
        {
            get
            {
                return false;
            }
        }
        protected override void OnHandleCreated(EventArgs e)
        {
            try
            {
                SetWindowTheme(Handle, "explorer", null);
            }
            catch { }
            base.OnHandleCreated(e);
        }
        protected override void WndProc(ref Message m)
        {
            switch (m.Msg)
            {
                case WM_PAINT:
                    if (View != View.Details)
                        break;

                    // Calculate the position of all embedded controls
                    foreach (EmbeddedControl ec in _embeddedControls)
                    {
                        Rectangle rc = this.GetSubItemBounds(ec.Item, ec.Column);

                        if ((this.HeaderStyle != ColumnHeaderStyle.None) &&
                            (rc.Top < this.Font.Height)) // Control overlaps ColumnHeader
                        {
                            ec.Control.Visible = false;
                            continue;
                        }
                        else
                        {
                            ec.Control.Visible = true;
                        }

                        switch (ec.Dock)
                        {
                            case DockStyle.Fill:
                                break;
                            case DockStyle.Top:
                                rc.Height = ec.Control.Height;
                                break;
                            case DockStyle.Left:
                                rc.Width = ec.Control.Width;
                                break;
                            case DockStyle.Bottom:
                                rc.Offset(0, rc.Height - ec.Control.Height);
                                rc.Height = ec.Control.Height;
                                break;
                            case DockStyle.Right:
                                rc.Offset(rc.Width - ec.Control.Width, 0);
                                rc.Width = ec.Control.Width;
                                break;
                            case DockStyle.None:
                                rc.Size = ec.Control.Size;
                                break;
                        }

                        // Set embedded control's bounds
                        ec.Control.Bounds = rc;
                    }
                    break;
            }
            base.WndProc(ref m);
        }
    }
    class ListViewItemComparer : IComparer
    {
        private int col;
        public ListViewItemComparer()
        {
            col = 0;
        }
        public ListViewItemComparer(int column)
        {
            col = column;
        }
        public int Compare(object x, object y)
        {
            int returnVal = -1;
            returnVal = String.Compare(((ListViewItem)x).SubItems[col].Text,
            ((ListViewItem)y).SubItems[col].Text);
            return returnVal;
        }
    }
}
