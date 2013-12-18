using System;
using System.Windows.Forms;

namespace Builder
{
    /* Copyright © 2010 w!cked */

    static class cMain
    {
        [STAThread]
        static void Main()
        {
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);
            Application.Run(new fMain());
        }
    }
}
