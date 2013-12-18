using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.IO;
using System.Runtime.Serialization.Formatters.Binary;
using Microsoft.Win32;
using NetLib.Misc;
namespace Net_Weave_R.Misc
{
    class SettingsWriter
    {
        MemoryStream ms;
        BinaryFormatter formatter;
        string loc;
        SortedList<string, object> items = new SortedList<string, object>();
        public SettingsWriter(string registryLocation)
        {
            loc = registryLocation;
            ms = new MemoryStream();
            formatter = new BinaryFormatter();
        }
        public void Write(object obj, string name)
        {
            items.Add(name, obj);
        }
        public void Close(string name)
        {
            ms = new MemoryStream();
            formatter.Serialize(ms, items);
            formatter = null;
            ms.Close();
            byte[] data = ms.ToArray();
            data = Encryption.Encrypt(data, false);
            Registry.CurrentUser.CreateSubKey(loc).SetValue(name, data, RegistryValueKind.Binary);
        }
    }

    class SettingsReader
    {
        MemoryStream ms;
        BinaryFormatter formatter;
        RegistryKey loc;
        SortedList<string, object> lst;
        public SettingsReader(string registryLocation, string name)
        {
            loc = Registry.CurrentUser.OpenSubKey(registryLocation);
            if (loc == null)
            {
                throw new Exception("Data not found.");
            }
            formatter = new BinaryFormatter();
            ms = new MemoryStream(Encryption.Decrypt(loc.GetValue(name) as byte[], false));
            lst = (SortedList<string, object>)formatter.Deserialize(ms);
            ms.Close();
            ms.Dispose();
        }
        public T Read<T>(string name)
        {
            object obj = lst[name];
            return (T)obj;
        }
        public void Dispose()
        {
            formatter = null;
            loc = null;
            lst = null;
            ms = null;
        }
    }
}
