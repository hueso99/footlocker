using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading;
using NetLib.Networking;
using NetLib.API;

namespace Net_Weave_R.Core
{
    class Pinger
    {
        static List<Client> clients;
        static Thread t;
        public static void Start(ref List<Client> Clients)
        {
            if (t != null)
                return;
            clients = Clients;
            t = new Thread(delegate()
                {
                    while (true)
                    {
                        if (clients.Count == 0)
                        {
                            Kernel32.Sleep(1000);
                            continue;
                        }

                        //for (int i = 0; i < clients.Count; i++)
                        //{
                        //    try
                        //    {
                        //        clients[i].SendPing();
                        //    }
                        //    catch
                        //    {
                        //    }
                        //}

                        //Kernel32.Sleep(5000);

                        //for (int i = 0; i < clients.Count; i++)
                        //{
                        //    if (clients[i] == null)
                        //        continue;
                        //    if (!clients[i].FullyConnected)
                        //    {
                        //        clients[i].RaiseDisconnected();
                        //        i--;
                        //        continue;
                        //    }
                        //    if (!clients[i].Alive)
                        //    {
                        //        clients[i].RaiseDisconnected();
                        //        i--;
                        //    }
                        //    else
                        //    {
                        //        clients[i].Alive = false;
                        //    }
                        //}

                        Kernel32.Sleep(10000);
                    }
                });
            t.Start();
        }
        public static void Stop()
        {
            if (t == null)
                return;

            t.Abort();
            t = null;
            clients = null;
        }
    }
}
