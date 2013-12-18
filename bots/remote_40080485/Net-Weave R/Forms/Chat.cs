using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.Threading;
using Net_Weave_R.Core;
using Net_Weave_R.Forms.Popups;
using NetLib.Networking;

namespace Net_Weave_R.Forms
{
    public partial class Chat : Form
    {
        ChatClient client;
        int online = 0;
        List<string> blocked;
        SortedList<string, PMForm> pmForms;
        public Chat()
        {
            InitializeComponent();
            Functions.Center(this);
            Icon = GlobalProperties.ApplicationIcon;
            client = new ChatClient();
            Load += new EventHandler(Chat_Load);
            Text += " - " + GlobalProperties.Client.Username;
            carbonTheme1.Text = Text;
            pmForms = new SortedList<string, PMForm>();
            blocked = new List<string>();
            txtMessage.Base.KeyDown += new KeyEventHandler(Base_KeyDown);
        }

        void Base_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyData == Keys.Enter && sendOnEnterToolStripMenuItem.Checked)
            {
                btnSend_Click(null, null);
                e.SuppressKeyPress = true;
            }
        }

        void Chat_Load(object sender, EventArgs e)
        {
            if (!client.Connect())
            {
                MessageBox.Show("Unable to connect to server.", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
                Close();
                return;
            }

            client.Received += new EventHandler<xDataReceivedEventArgs>(client_Received);
            client.Sent += new EventHandler<xSentEventArrgs>(client_Sent);
            client.Disconnected += new EventHandler(client_Disconnected);
            PacketWriter w = new PacketWriter();
            w.Write(GlobalProperties.Client.Username);
            client.Send(new BaseChatPacket(ChatClient.Header.USERNAME, w.ToArray(false)).GetBytes());
            client.BeginRead();
        }

        void client_Disconnected(object sender, EventArgs e)
        {
            Invoke((MethodInvoker)delegate
            {
                btnSend.Enabled = false;
                txtMessage.Enabled = false;

                Text += " [DISCONNECTED]";
                carbonTheme1.Text = Text;
                client.Close();
                client.Dispose();

                MessageBox.Show("The server has been disconnected!", "", MessageBoxButtons.OK, MessageBoxIcon.Error);
            });
        }

        void client_Sent(object sender, xSentEventArrgs e)
        {

        }

        void client_Received(object sender, xDataReceivedEventArgs e)
        {
            ChatClient client = sender as ChatClient;
            PacketReader r = new PacketReader(e.Data, false);
            switch (e.Header)
            {
                case ChatClient.Header.USERNAME:
                    online++;
                    Invoke((MethodInvoker)delegate
                    {
                        lstUsers.Columns[0].Text = "Online (" + online.ToString() + ")";
                        string _username = r.ReadString();
                        lstUsers.Items.Add(_username);
                        if (blocked.Contains(_username))
                            lstUsers.Items[lstUsers.Items.Count - 1].ForeColor = Color.Red;
                        lstUsers.Sort();

                        WriteToChat(_username + ": Connected", Color.Green);

                        if (connectToolStripMenuItem.Checked)
                        {
                            GlobalProperties.SoundPlayer.Stream = Properties.Resources.beep_1;
                            GlobalProperties.SoundPlayer.Play();
                        }
                    });
                    break;

                case ChatClient.Header.USERS:
                    List<string> usernames = new List<string>();
                    int len = r.ReadInt32();
                    for (int i = 0; i < len; i++)
                    {
                        usernames.Add(r.ReadString());
                    }
                    usernames.Sort();
                    Invoke((MethodInvoker)delegate
                    {
                        lstUsers.Items.Clear();
                    });
                    foreach (string name in usernames)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            lstUsers.Items.Add(name);
                            if (blocked.Contains(name))
                                lstUsers.Items[lstUsers.Items.Count - 1].ForeColor = Color.Red;
                        });
                    }
                    online = usernames.Count;
                    Invoke((MethodInvoker)delegate
                    {
                        lstUsers.Columns[0].Text = "Online (" + online.ToString() + ")";
                    });
                    break;

                case ChatClient.Header.MESSAGE:
                    string username = r.ReadString();
                    string message = r.ReadString();
                    int bLen = r.ReadInt32();
                    for (int i = 0; i < bLen; i++)
                    {
                        if (GlobalProperties.Client.Username == r.ReadString())
                        {
                            r.Close();
                            return;
                        }
                    }
                    if (blocked.Contains(username))
                        break;
                    if (soundOnSentReceivedToolStripMenuItem.Checked)
                    {
                        GlobalProperties.SoundPlayer.Stream = Properties.Resources.IM08;
                        GlobalProperties.SoundPlayer.Play();
                    }
                    StringBuilder sb = new StringBuilder();
                    sb.Append(username + ": " + message);
                    Invoke((MethodInvoker)delegate
                    {
                        WriteToChat(sb.ToString(), Color.Black);
                    });
                    break;

                case ChatClient.Header.LEFT:
                    string leftName = r.ReadString();
                    online--;
                    for (int i = 0; i < lstUsers.Items.Count; i++)
                    {
                        Invoke((MethodInvoker)delegate
                        {
                            if (lstUsers.Items[i].Text == leftName)
                            {
                                lstUsers.Items.RemoveAt(i);
                                lstUsers.Columns[0].Text = "Online (" + online.ToString() + ")";
                                r.Close();
                                WriteToChat(leftName + ": Disconnected", Color.Red);

                                if (disconnectToolStripMenuItem.Checked)
                                {
                                    GlobalProperties.SoundPlayer.Stream = Properties.Resources.boing_2;
                                    GlobalProperties.SoundPlayer.Play();
                                }


                                return;
                            }
                        });
                    }
                    break;

                case ChatClient.Header.PM:
                    string user = r.ReadString();
                    if (blocked.Contains(user))
                        break;
                    GlobalProperties.SoundPlayer.Stream = Properties.Resources.IM08;
                    GlobalProperties.SoundPlayer.Play();
                    string msg = r.ReadString();
                    Invoke((MethodInvoker)delegate
                    {
                        if (pmForms.ContainsKey(user))
                        {
                            if (!pmForms[user].IsDisposed)
                                pmForms[user].WriteToChat(msg, Color.Black);
                        }
                        else
                        {
                            PMForm newPM = new PMForm(user, client);
                            pmForms.Add(user, newPM);
                            newPM.Show();
                            newPM.WriteToChat(msg, Color.Black);
                            newPM.FormClosed += (s, E) =>
                            {
                                pmForms.Remove(user);
                            };
                        }
                    });
                    break;
            }
            r.Close();
        }


        #region Fade
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            client.Disconnected -= client_Disconnected;
            client.Received -= client_Received;
            client.Close();
            client.Dispose();
            base.OnFormClosing(e);
        }
        #endregion

        private void btnSend_Click(object sender, EventArgs e)
        {
            if (string.IsNullOrEmpty(txtMessage.Text.Trim()))
            {
                return;
            }
            PacketWriter w = new PacketWriter();
            w.Write(GlobalProperties.Client.Username);
            w.Write(txtMessage.Text);
            w.Write(blocked.Count);
            foreach (string b in blocked)
                w.Write(b);
            client.Send(new BaseChatPacket(ChatClient.Header.MESSAGE, w.ToArray(false)).GetBytes());
            txtMessage.ResetText();
        }

        void WriteToChat(string text, Color color)
        {
            txtChat.SelectionStart = txtChat.TextLength;
            txtChat.SelectionColor = color;
            txtChat.SelectedText = text + "\n";
            txtChat.SelectionColor = Color.Black;

            txtChat.SelectionLength = txtChat.TextLength;
            txtChat.ScrollToCaret();
        }


        private void takeScreenshotToolStripMenuItem_Click(object sender, EventArgs e)
        {
            Rectangle bounds = this.Bounds;
            using (Bitmap bitmap = new Bitmap(bounds.Width, bounds.Height))
            {
                using (Graphics g = Graphics.FromImage(bitmap))
                {
                    g.CopyFromScreen(new Point(bounds.Left, bounds.Top), Point.Empty, bounds.Size);
                }
                using (SaveFileDialog s = new SaveFileDialog())
                {
                    s.Filter = "JPEG |*.jpeg";
                    if (s.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                    {
                        try
                        {
                            bitmap.Save(s.FileName, System.Drawing.Imaging.ImageFormat.Jpeg);
                        }
                        catch { }
                    }
                }
            }
        }

        private void saveChatToolStripMenuItem_Click(object sender, EventArgs e)
        {
            using (SaveFileDialog s = new SaveFileDialog())
            {
                s.Filter = "Text Files |*.txt";
                if (s.ShowDialog() == System.Windows.Forms.DialogResult.OK)
                {
                    try
                    {
                        txtChat.SaveFile(s.FileName);
                    }
                    catch { }
                }
            }
        }

        private void blockToolStripMenuItem_Click(object sender, EventArgs e)
        {
            string userName = lstUsers.SelectedItems[0].Text;
            if (userName != GlobalProperties.Client.Username)
            {
                if (!blocked.Contains(userName))
                {
                    blocked.Add(userName);
                    lstUsers.SelectedItems[0].ForeColor = Color.Red;
                }
                else
                {
                    blocked.Remove(userName);
                    foreach (ListViewItem i in lstUsers.Items)
                        if (i.Text == userName)
                        {
                            i.ForeColor = Color.Black;
                            break;
                        }
                }
            }
        }

        private void pMToolStripMenuItem_Click(object sender, EventArgs e)
        {
            if (!pmForms.ContainsKey(lstUsers.SelectedItems[0].Text) && lstUsers.SelectedItems[0].Text != GlobalProperties.Client.Username)
            {
                string userName = lstUsers.SelectedItems[0].Text;
                PMForm pmForm = new PMForm(lstUsers.SelectedItems[0].Text, client);
                pmForms.Add(lstUsers.SelectedItems[0].Text, pmForm);
                pmForm.Show();
                pmForm.FormClosing += (SENDER, E) =>
                {
                    pmForms.Remove(userName);
                };
            }
        }

        private void sendOnEnterToolStripMenuItem_Click(object sender, EventArgs e)
        {

        }
    }
}
