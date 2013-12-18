using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using Microsoft.Win32;
using Net_Weave_R.Core;

namespace Net_Weave_R.Misc
{
    class Settings
    {
        public const string Reg = "Software\\Net-Weave R";
        public static List<string> Passwords = new List<string>() { };
        public static List<int> Ports = new List<int>() { };

        //public static CarbonTheme.ThemeType Theme = CarbonTheme.ThemeType.Dark;

        public static bool DupPrevnt = false;
        public static bool JoinDos = false;
        public static bool LogConnected = false;
        public static bool LogDisconnected = false;
        public static bool NotifyConnected = false;
        public static bool NotifyDisconnected = false;
        public static bool HideConsole = true;

        public static int Limit = 0;

        public static void Load()
        {
            try
            {
                SettingsReader r = new SettingsReader(Reg, "Settings");
                Settings.Ports = r.Read<List<int>>("Ports");
                Settings.Passwords = r.Read<List<string>>("Passwords");
                Settings.DupPrevnt = r.Read<bool>("Dup");
                Settings.LogConnected = r.Read<bool>("LogConnect");
                Settings.LogDisconnected = r.Read<bool>("LogDis");
                Settings.NotifyConnected = r.Read<bool>("NotifyCon");
                Settings.NotifyDisconnected = r.Read<bool>("NotifyDis");
                r.Dispose();
            }
            catch { }

            try
            {
                SettingsReader r = new SettingsReader(Reg, "Plugins");
                GlobalProperties.RawPlugins = r.Read<SortedList<Guid, byte[]>>("Plugins");
                r.Dispose();
                PluginHelper.InitializePlugins();
                PluginHelper.pluginChanged();
            }
            catch { }
        }

        public static void Save()
        {
            try
            {
                SettingsWriter w = new SettingsWriter(Reg);
                w.Write(Ports, "Ports");
                w.Write(Passwords, "Passwords");
                w.Write(DupPrevnt, "Dup");
                w.Write(LogConnected, "LogConnect");
                w.Write(LogDisconnected, "LogDis");
                w.Write(NotifyConnected, "NotifyCon");
                w.Write(NotifyDisconnected, "NotifyDis");
                w.Close("Settings");
            }
            catch { }

            if (GlobalProperties.RawPlugins.Count > 0)
            {
                try
                {
                    SettingsWriter w = new SettingsWriter(Reg);
                    w.Write(GlobalProperties.RawPlugins, "List");
                    w.Close("Plugins");
                }
                catch { }
            }
        }

        public static bool ReadToS()
        {
            try
            {
                return Convert.ToBoolean(Registry.CurrentUser.OpenSubKey(Reg).GetValue("ToS"));
            }
            catch { }
            return false;
        }

        public static void WriteTosAnswer(bool answer)
        {
            try
            {
                Registry.CurrentUser.CreateSubKey(Reg).SetValue("ToS", answer);
            }
            catch { }
        }

        public static int GetTotal()
        {
            try
            {
                SettingsReader r = new SettingsReader(Reg, "Total");
                int res = r.Read<int>("TOTAL");
                r.Dispose();
                return res;
            }
            catch { }
            return 0;
        }
    }
}
