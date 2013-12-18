using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace Net_Weave_R
{
    class Functions
    {
        public static string FormatBytes(long bytes)
        {
            const int scale = 1024;
            string[] orders = new string[] { "GB", "MB", "KB", "Bytes" };
            long max = (long)Math.Pow(scale, orders.Length - 1);

            foreach (string order in orders)
            {
                if (bytes > max)
                    return string.Format("{0:##.##} {1}", decimal.Divide(bytes, max), order);

                max /= scale;
            }
            return "0 Bytes";
        }
        public static void Center(Form form)
        {
            form.Location = new System.Drawing.Point((Screen.PrimaryScreen.Bounds.Width / 2) - (form.Width / 2), (Screen.PrimaryScreen.Bounds.Height / 2) - (form.Height / 2));
        }

        public static int GetCountryIndex(string countryName, ImageList list)
        {
            for (int i = 0; i < list.Images.Count; i++)
            {
                if (list.Images.Keys[i].ToLower().Contains(countryName.ToLower()))
                    return i;
            }

            return list.Images.Count - 1;
        }
    }
}
