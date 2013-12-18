using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;
using System.IO;
using System.Net.Sockets;
using System.Net;
using System.Text.RegularExpressions;

namespace nProxy
{
    public partial class MainForm : Form
    {
        XPlugin plugin;
        public MainForm(XPlugin xPlugin)
        {
            InitializeComponent();
            plugin = xPlugin;
            plugin.DataReady += new DataReadyEventHandler(plugin_DataReady);
        }

        void plugin_DataReady(object sender, PluginArgs e)
        {
            switch (e.Header)
            {
                case 2:
                    {
                        byte[] buffer = Encoding.Default.GetBytes((string)e.Read(0));
                        string id = e.Read(1).ToString();
                        clients[id].Send(buffer);
                        //clients.Remove(id);
                    }
                    break;
            }
        }
        private void btnRun_Click(object sender, EventArgs e)
        {
            if (Running)
                return;

            port = (int)numPort.Value;


            PluginArgs args = new PluginArgs(plugin.Guid);
            args.Header = 0;
            args.Write(GetIP());
            args.Write((int)numPort.Value);
            plugin.Send(args);

            Start();
        }

        private void btnStop_Click(object sender, EventArgs e)
        {
            if (!Running)
                return;
            Stop();
            //PluginArgs args = new PluginArgs(plugin.Guid);
            //args.Header = 1;
            //plugin.Send(args);
        }

        public string GetIP()
        {
            try
            {
                WebRequest req = WebRequest.Create("http://www.ipchicken.com/");
                WebResponse res = req.GetResponse();
                StreamReader r = new StreamReader(res.GetResponseStream());
                Regex x = new Regex(@"\d+.\d+.\d+.\d+");
                string ip = x.Matches(r.ReadToEnd())[0].Value.ToString();
                r.Close();
                r.Dispose();
                req.Abort();
                res.Close();

                return ip;
            }
            catch
            {
            }
            return string.Empty;
        }

        #region ProxyClient
        Socket listener;
        bool Running = false;
        int port;
        SortedList<string, Socket> clients;
        public void Start()
        {
            listener = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
            listen();
            beginAccept();
            Running = true;
            clients = new SortedList<string, Socket>();
        }

        public void Stop()
        {
            if (Running)
            {
                Running = false;
                listener.Close();
            }
        }

        void listen()
        {
            listener.Bind(new IPEndPoint(IPAddress.Parse("127.0.0.1"), port));
            listener.Listen(0);
        }
        void beginAccept()
        {
            listener.BeginAccept(acceptCallback, null);
        }
        void acceptCallback(IAsyncResult ar)
        {
            try
            {
                Socket client = listener.EndAccept(ar);
                Console.WriteLine("Request being redirected.");
                beginRead(client);
            }
            catch { }
            if (Running)
                beginAccept();
        }
        void beginRead(Socket client)
        {
            ThreadStart starter = delegate
            {
                int rec = 0;
                client.ReceiveTimeout = 900;
                clients.Add(Guid.NewGuid().ToString(), client);
                while (true)
                {
                    byte[] buffer = new byte[8192];
                    try
                    {
                        Console.WriteLine("Reading Request");
                        rec = client.Receive(buffer);
                        if (rec == 0)
                            throw new Exception();
                    }
                    catch
                    {
                        break;
                    }
                    Array.Resize(ref buffer, rec);
                    PluginArgs e = new PluginArgs(plugin.Guid);
                    e.Header = 2;
                    e.Write(Encoding.Default.GetString(buffer));
                    e.Write(clients.Keys[clients.Count - 1]);
                    plugin.Send(e);
                }

                //while (true)
                //{
                //    byte[] buffer = new byte[8192];
                //    try
                //    {
                //        Console.WriteLine("Reading web response");
                //        rec = proxySocket.Receive(buffer);
                //        if (rec == 0)
                //            throw new Exception();
                //    }
                //    catch { break; }
                //    Array.Resize(ref buffer, rec);
                //    try
                //    {
                //        client.Send(buffer);
                //    }
                //    catch { }
                //    Console.WriteLine("Response bytes being sent to server");
                //}

                //try
                //{
                //    client.Disconnect(false);
                //    client.Close();
                //    proxySocket.Disconnect(false);
                //    proxySocket.Close();
                //    Console.WriteLine("Sockets Closed");
                //}
                //catch { }
            };
            new Thread(starter).Start();
        }
        #endregion
    }
}
