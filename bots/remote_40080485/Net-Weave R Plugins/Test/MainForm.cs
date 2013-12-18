using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;

namespace Test
{
    public partial class MainForm : Form
    {
        XPlugin plugin;
        public MainForm(XPlugin plugin)
        {
            InitializeComponent();
            this.plugin = plugin;


            plugin.Received += new ReceivedEventHandler(plugin_Received);
        }
        protected override void OnFormClosing(FormClosingEventArgs e)
        {
            plugin.Received -= plugin_Received;
            base.OnFormClosing(e);
        }
        private void button1_Click(object sender, EventArgs e)
        {
            PluginArgs args = new PluginArgs(plugin.Guid);
            args.Header = 0;
            args.Write("Hello!");
            args.Write(new Random(54546).Next(0, 5));
            args.Write(new Random(65342).Next(0, 3));
            plugin.Send(args);
        }

        void plugin_Received(object sender, PluginArgs e)
        {
            Invoke((MethodInvoker)delegate
            {
                switch (e.Header)
                {
                    case 0:
                        MessageBox.Show("Message box shown");
                        break;
                }
            });
        }
    }
}
