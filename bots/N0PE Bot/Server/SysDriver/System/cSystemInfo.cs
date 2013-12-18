using System;
using System.Management;
using Microsoft.Win32;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cSystemInfo
    {
        public string getSystemVersion()
        {
            return (getWindowsVersionName() + Convert.ToChar(0x20) + getBitVersion());
        }

        public string getUniqueID()
        {
            string sUID = (getCPUID() + getGraphicDevice() + getMoboSerial()).ToString();
            return cMain.FunctionClass.getMD5Hash(sUID);
        }

        private string getWindowsVersionName()
        {
            ManagementObjectSearcher mSearcher = new ManagementObjectSearcher(@"root\CIMV2", " SELECT * FROM win32_operatingsystem");
            string sData = string.Empty;
            foreach (ManagementObject tObj in mSearcher.Get())
            {
                sData = Convert.ToString(tObj["Name"]);
            }

            try
            {
                sData = sData.Split(new char[] { '|' })[0];
                int iLen = sData.Split(new char[] { ' ' })[0].Length;
                sData = sData.Substring(iLen).TrimStart().TrimEnd();
            }
            catch { sData = "Unknown System"; }

            return sData;
        }

        private string getBitVersion()
        {
            if (Registry.LocalMachine.OpenSubKey(@"HARDWARE\Description\System\CentralProcessor\0").GetValue("Identifier").ToString().Contains("x86"))
            {
                return "(32 Bit)";
            }
            else
            {
                return "(64 Bit)";
            }
        }

        private string getCPUID()
        {
            ManagementObjectSearcher mSearcher = new ManagementObjectSearcher(@"root\CIMV2", "SELECT * FROM Win32_Processor WHERE DeviceID = 'CPU0'");
            string sData = string.Empty;
            foreach (ManagementObject tObj in mSearcher.Get())
            {
                sData = Convert.ToString(tObj["ProcessorId"]);
            }
            return sData;
        }

        private string getMoboSerial()
        {
            ManagementObjectSearcher mSearcher = new ManagementObjectSearcher(@"root\CIMV2", "SELECT * FROM Win32_BaseBoard");
            string sData = string.Empty;
            foreach (ManagementObject tObj in mSearcher.Get())
            {
                sData = Convert.ToString(tObj["SerialNumber"]);
            }
            return sData;
        }

        public string getGraphicDevice()
        {
            ManagementObjectSearcher mSearcher = new ManagementObjectSearcher(@"root\CIMV2", "SELECT * FROM Win32_VideoController");
            string sData = string.Empty;
            foreach (ManagementObject tObj in mSearcher.Get())
            {
                sData = Convert.ToString(tObj["Description"]);
            }
            return sData;
        }
    }
}
