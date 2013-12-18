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

namespace Net_Weave_R.Forms
{
    public partial class PMForm : Form
    {
        ChatClient client;
        string username;
        public PMForm(string name, ChatClient client)
        {
            InitializeComponent();
            this.Icon = GlobalProperties.ApplicationIcon;
            this.client = client;
            username = name;

            Text = "PM [" + name + "]";
            txtMessage.Base.KeyDown += new KeyEventHandler(Base_KeyDown);
        }

        void Base_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyData == Keys.Enter && xSendOnEnter.Checked)
            {
                btnSend_Click(null, null);
                e.SuppressKeyPress = true;
            }
        }

        private void btnSend_Click(object sender, EventArgs e)
        {
            PacketWriter w = new PacketWriter();
            w.Write(username);
            w.Write(GlobalProperties.Client.Username + ": " + txtMessage.Text);
            client.Send(new BaseChatPacket(ChatClient.Header.PM, w.ToArray(false)).GetBytes());
            txtMessage.ResetText();
        }

        public void WriteToChat(string text, Color color)
        {
            txtChat.SelectionStart = txtChat.TextLength;
            txtChat.SelectionColor = color;
            txtChat.SelectedText = text + "\n";
            txtChat.SelectionColor = Color.Black;

            txtChat.SelectionLength = txtChat.TextLength;
            txtChat.ScrollToCaret();
        }
    }
}
