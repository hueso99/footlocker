using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;
using System.Net.Sockets;
using System.Net;
using System.IO;

namespace nProxy
{
    public class Class1 : XPlugin
    {
        public override string Author
        {
            get { return "xSilent"; }
        }

        public override string Description
        {
            get { return "An HTTP proxy."; }
        }

        public override bool ExecuteOnLoad
        {
            get { return false; }
        }

        public override bool HasForm
        {
            get { return true; }
        }

        public override void Initialize()
        {
            state = PluginState.NONE;
        }
        Form form;
        public override System.Windows.Forms.Form InputForm
        {
            get { if (form != null) return form; else return form = new MainForm(this); }
        }

        public override string Name
        {
            get { return "nProxy"; }
        }
        PluginState state;
        public override PluginState State
        {
            get { return state; }
        }

        public override bool StopOnDisconnection
        {
            get { return true; }
        }

        public override Version Version
        {
            get { return new Version(1, 0, 0, 0); }
        }
        public override void Execute(PluginArgs e)
        {
            switch (e.Header)
            {
                case 0:
                    {
                    }
                    break;
                case 1:
                    {
                    }
                    break;
                case 2:
                    {
                        run((string)e.Read(0), (string)e.Read(1));
                    }
                    break;
            }
            base.Execute(e);
        }

        public override void Stop()
        {
            if (state == PluginState.RUNNING)
            {
                state = PluginState.NONE;
            }
            base.Stop();
        }

        void run(string data, string id)
        {
            ThreadStart starter = delegate
                        {
                            int rec = 0;
                            string host = string.Empty;
                            string[] lines = data.Split('\n');
                            foreach (string line in lines)
                                if (line.Contains("Host: "))
                                {
                                    host = line.Replace("Host: ", string.Empty).Trim();
                                    break;
                                }
                            lines = null;

                            Socket webSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
                            int port = 80;
                            if (host.Contains("https"))
                                port = 443;
                            try
                            {
                                webSocket.Connect(Dns.GetHostEntry(host).AddressList[0], port);
                            }
                            catch
                            {
                                webSocket.Close();
                                return;
                            }

                            webSocket.Send(Encoding.Default.GetBytes(data));

                            webSocket.ReceiveTimeout = 900;
                            while (true)
                            {
                                byte[] buffer = new byte[8192];
                                try
                                {
                                    rec = webSocket.Receive(buffer);
                                    if (rec == 0)
                                        throw new Exception();
                                }
                                catch { break; }
                                Array.Resize(ref buffer, rec);
                                PluginArgs args = new PluginArgs(Guid);
                                args.Header = 2;
                                args.Write(Encoding.Default.GetString(buffer));
                                args.Write(id);
                                Send(args);
                                Console.WriteLine("DATA READ FROM RESPONSE: {0}, HOST: {1}", buffer.Length, host);
                            }
                            webSocket.Disconnect(false);
                            webSocket.Close();

                            Console.WriteLine("CONNECTION CLOSED");
                        };
            new Thread(starter).Start();
        }
    }

    //class ProxyServer
    //{
    //    int port;
    //    Socket listener;
    //    public bool Running;
    //    public ProxyServer(int Port)
    //    {
    //        port = Port;
    //        listener = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);
    //    }

    //    public void Start()
    //    {
    //        listen();
    //        beginAccept();
    //        Running = true;
    //    }

    //    public void Stop()
    //    {

    //    }

    //    void listen()
    //    {
    //        listener.Bind(new IPEndPoint(0, port));
    //        listener.Listen(0);
    //    }
    //    void beginAccept()
    //    {
    //        listener.BeginAccept(acceptCallback, null);
    //    }
    //    void acceptCallback(IAsyncResult ar)
    //    {
    //        try
    //        {
    //            Socket client = listener.EndAccept(ar);
    //            Console.WriteLine("CONNECTED ACCEPTED");
    //            beginRead(client);
    //        }
    //        catch { }
    //        beginAccept();
    //    }
    //    void beginRead(Socket client)
    //    {
    //        ThreadStart starter = delegate
    //        {
    //            int rec = 0;
    //            MemoryStream full = new MemoryStream();
    //            client.ReceiveTimeout = 900;
    //            while (true)
    //            {
    //                byte[] buffer = new byte[8192];
    //                try
    //                {
    //                    rec = client.Receive(buffer);
    //                    if (rec == 0)
    //                        throw new Exception();
    //                }
    //                catch { break; }
    //                Array.Resize(ref buffer, rec);
    //                full.Write(buffer, 0, buffer.Length);
    //                Console.WriteLine("DATA READ FROM REQUEST: {0}", buffer.Length);
    //            }

    //            full.Close();
    //            byte[] data = full.ToArray();

    //            string host = string.Empty;
    //            string[] lines = Encoding.ASCII.GetString(data).Split('\n');
    //            foreach (string line in lines)
    //                if (line.Contains("Host: "))
    //                {
    //                    host = line.Replace("Host: ", string.Empty).Trim();
    //                    break;
    //                }

    //            Socket webSocket = new Socket(AddressFamily.InterNetwork, SocketType.Stream, ProtocolType.Tcp);

    //            try
    //            {
    //                webSocket.Connect(Dns.GetHostEntry(host).AddressList[0], 80);
    //            }
    //            catch
    //            {
    //                webSocket.Close();

    //                client.Close();

    //                Console.WriteLine("CONNECTION ABORTED");

    //                return;
    //            }

    //            webSocket.Send(data);

    //            webSocket.ReceiveTimeout = 900;
    //            while (true)
    //            {
    //                byte[] buffer = new byte[8192];
    //                try
    //                {
    //                    rec = webSocket.Receive(buffer);
    //                    if (rec == 0)
    //                        throw new Exception();
    //                }
    //                catch { break; }
    //                Array.Resize(ref buffer, rec);
    //                try
    //                {
    //                    client.Send(buffer);
    //                }
    //                catch { break; }
    //                Console.WriteLine("DATA READ FROM RESPONSE: {0}, HOST: {1}", buffer.Length, host);
    //            }
    //            webSocket.Disconnect(false);
    //            webSocket.Close();

    //            client.Disconnect(false);
    //            client.Close();

    //            full.Dispose();

    //            Console.WriteLine("CONNECTION CLOSED");
    //        };
    //        new Thread(starter).Start();
    //    }
    //}
}
