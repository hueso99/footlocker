using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Reflection;

namespace Net_Weave_R.Misc
{
    [Serializable()]
    [Obfuscation(Exclude = true)]
    class ProfileData
    {
        public string Host;
        public string BackupHost;
        public string Name;
        public string HkcuKey;
        public string HklmKey;
        public string DirectoryName;
        public string FileName;
        public string PluginRegLocation;
        public string PluginRegName;
        public string Mutex;
        public string ConnectionPassword;
        public string UninstallPassword;
        public string LastModified;

        public bool Install;
        public bool Melt;
        public bool Hkcu;
        public bool Hklm;
        public bool VisibleMode;
        public bool ShowConsole;
        public bool EnableBackupHost;

        public int Port;
        public int BackupPort;

        public Guid ID;
        public ProfileData()
        {
            ID = Guid.NewGuid();
        }
    }
}
