using System;
using System.Diagnostics;
using System.Text;
using System.IO;
using System.Security.Cryptography;
using System.Runtime.InteropServices;
using System.Security.Principal;

namespace SysDriver
{
    class cFunctions
    {
        /* Copyright © 2010 w!cked */

        public void FlushMemory()
        {
            GC.Collect();
            GC.WaitForPendingFinalizers();

            if (Environment.OSVersion.Platform == PlatformID.Win32NT)
            {
                SetProcessWorkingSetSize(Process.GetCurrentProcess().Handle, -1, -1);
            }
        }

        public bool checkProcess(string sProcessName)
        {
            return (Process.GetProcessesByName(sProcessName).Length > 0);
        }

        private string FileMD5(string sFileName)
        {
            FileStream fMD5Stream = File.OpenRead(sFileName);
            MD5 mMD5 = new MD5CryptoServiceProvider();
            byte[] bMD5Hash = mMD5.ComputeHash(fMD5Stream);
            fMD5Stream.Close();
            string sChecksum = BitConverter.ToString(bMD5Hash).Replace("-", "").ToUpper();
            return sChecksum;
        }

        public string getMD5Hash(string sString)
        {
            MD5 mMD5 = new MD5CryptoServiceProvider();
            byte[] bMD5Hash = mMD5.ComputeHash(Encoding.Default.GetBytes(sString));
            string sChecksum = BitConverter.ToString(bMD5Hash).Replace("-", "").ToUpper();
            return sChecksum;
        }

        public string genString(int iLen)
        {
            Random rRand = new Random();
            string sBuffer = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
            string sResult = string.Empty;

            for (int i = 0; i < iLen; i++)
            {
                sResult += sBuffer.Substring(rRand.Next(0, sBuffer.Length), 1);
            }

            return sResult;
        }

        public bool checkFile(string FilePath)
        {
            if (!File.Exists(FilePath))
            {
                return false;
            }
            else
            {
                if (FileMD5(FilePath) != FileMD5(Process.GetCurrentProcess().MainModule.FileName))
                {
                    File.Delete(FilePath);
                    return false;
                }
                else
                {
                    return true;
                }
            }
        }

        public bool getAdminStatus()
        {
            try
            {
                WindowsIdentity wUser = WindowsIdentity.GetCurrent();
                WindowsPrincipal wPrincipal = new WindowsPrincipal(wUser);
                return wPrincipal.IsInRole(WindowsBuiltInRole.Administrator);
            }
            catch
            {
                return false;
            }
        }

        [DllImport("kernel32.dll")]
        private static extern int SetProcessWorkingSetSize(IntPtr process, int minimumWorkingSetSize, int maximumWorkingSetSize);
    }
}
