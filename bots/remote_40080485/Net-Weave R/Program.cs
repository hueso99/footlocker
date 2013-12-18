using System;
using System.Collections.Generic;
using System.Linq;
using System.Windows.Forms;
using Net_Weave_R.Forms;
using NetLib.Networking;
using NetLib.Process;
using Net_Weave_R.Misc;
using System.Drawing;
using Net_Weave_R.Forms.Popups;
using Net_Weave_R.Forms.Dialogs;
using System.Diagnostics;
using NWR_Client;
using NetLib.API;
using NetLib.Forms.API;
using System.IO;
namespace Net_Weave_R
{
    static class Program
    {
        [STAThread]
        static int Main()
        {
            if (!File.Exists("XPlugin.dll"))
            {
                File.WriteAllBytes("XPlugin.dll", Net_Weave_R.Properties.Resources.XPlugin);
                File.WriteAllBytes("Mono.Cecil.dll", Net_Weave_R.Properties.Resources.Mono_Cecil);
                Application.Restart();
                return 1;
            }

            if (!File.Exists("Mono.Cecil.dll"))
            {
                File.WriteAllBytes("Mono.Cecil.dll", Net_Weave_R.Properties.Resources.Mono_Cecil);
                Application.Restart();
                return 1;
            }

            xMutex mutex = xMutex.CreateMutex("Net-Weave R");
            if (mutex == null)
            {
                MessageBox.Show("An instance of Net-Weave R is already running.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return -1;
            }

            if (!SOCKET.Startup())
            {
                MessageBox.Show("Unable to start winsock. Please try again", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                return -1;
            }

            GlobalProperties.ConsoleHandle = Process.GetCurrentProcess().MainWindowHandle;
            User32.ShowWindow(GlobalProperties.ConsoleHandle, 0);
            GlobalProperties.ApplicationIcon = Icon.ExtractAssociatedIcon(Application.ExecutablePath);
            Application.EnableVisualStyles();
            Application.SetCompatibleTextRenderingDefault(false);

            if (!Settings.ReadToS())
            {
                MessageBox.Show("This appears to be your first time running Net-Weave R. Please agree to the Terms of Service before continuing.", "First time running", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);

                if (!TermsOfService.Show())
                {
                    SOCKET.Cleanup();
                    Environment.Exit(0);
                }
            }

            Application.Run(new Login());
            //SOCKET.Cleanup();

            return 0;
        }
    }
}
