using System;
using System.Threading;
using System.Diagnostics;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    class cAntis
    {
        public void checkAntis()
        {
            if (cMain.ConfigClass.bAntiDebugger)
            {
                try
                {
                    if (Debugger.IsAttached) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiSandboxie)
            {
                try
                {
                    foreach (string sModul in Process.GetCurrentProcess().Modules)
                    {
                        if (sModul.Contains("sbiedll.dll")) { Terminate(); return; }
                    }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiEmulator)
            {
                try
                {
                    long lTicks = DateTime.Now.Ticks;
                    Thread.Sleep(10);
                    if ((DateTime.Now.Ticks - lTicks) < 10L) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiNetstat)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("NETSTAT")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiFilemon)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("FILEMON")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiProcessmon)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("PROCMON")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiRegmon)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("REGMON")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiCain)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("CAIN")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiNetworkmon)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("NETMON")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiTCPView)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("TCPVIEW")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiWireshark)
            {
                try
                {
                    if (cMain.FunctionClass.checkProcess("WIRESHARK")) { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiParallelsDesktop)
            {
                try
                {
                    if (cMain.SystemInfoClass.getGraphicDevice() == "Parallels Video Adapter") { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiVMWare)
            {
                try
                {
                    if (cMain.SystemInfoClass.getGraphicDevice() == "VMware SVGA II") { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiVirtualBox)
            {
                try
                {
                    if (cMain.SystemInfoClass.getGraphicDevice() == "VirtualBox Graphics Adapter") { Terminate(); return; }
                }
                catch { }
            }

            if (cMain.ConfigClass.bAntiVirtualPC)
            {
                try
                {
                    string[] sArray = new string[] { "VM Additions S3 Trio32/64", "S3 Trio32/64" };
                    for (int i = 0; i < sArray.Length; i++)
                    {
                        if (cMain.SystemInfoClass.getGraphicDevice() == sArray[i]) { Terminate(); return; }
                    }
                }
                catch { }
            }
        }

        private void Terminate()
        {
            Environment.Exit(0);
        }
    }
}