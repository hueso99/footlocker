using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Drawing;
using System.Security;
using Net_Weave_R.Core;
using Net_Weave_R.Forms;
using System.Media;
using Net_Weave_R.Misc;
using Mono.Nat;
using System.Windows.Forms;

namespace Net_Weave_R
{
    class GlobalProperties
    {
        public static Main MainForm;

        public static Icon ApplicationIcon;
        //public static List<Client> Clients = new List<Client>();

        public static int Online = 0;
        public static SortedList<Guid, byte[]> RawPlugins = new SortedList<Guid, byte[]>();
        public static SortedList<Guid, XPlugin> InitializedPlugins = new SortedList<Guid, XPlugin>();

        public static IntPtr ConsoleHandle = IntPtr.Zero;

        public static NWR_Client.Client Client = null;

        public static SoundPlayer SoundPlayer = new SoundPlayer();

        public const string Vps = "netweavevps.no-ip.info";

        public static IAssembly BuildAssembly;

        public static List<INatDevice> NatDevices = new List<INatDevice>();

        public static NotifyIcon NI;
    }
}
