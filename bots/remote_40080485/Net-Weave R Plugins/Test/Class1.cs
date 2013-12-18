using System;
using System.Collections.Generic;
using System.Text;
using System.Windows.Forms;

namespace Test
{
    public class Class1 : XPlugin
    {
        public Class1()
            : base()
        {
        }
        public override string Author
        {
            get { return "xSilent"; }
        }

        public override string Description
        {
            get { return "Plugin test"; }
        }

        public override bool ExecuteOnLoad
        {
            get { return true; }
        }

        public override bool HasForm
        {
            get { return true; }
        }

        public override void Initialize()
        {

        }

        public override System.Windows.Forms.Form InputForm
        {
            get { return new MainForm(this); }
        }

        public override string Name
        {
            get { return "Test Plugin"; }
        }

        public override PluginState State
        {
            get { return PluginState.NONE; }
        }

        public override bool StopOnDisconnection
        {
            get { return false; }
        }

        public override Version Version
        {
            get { return new Version(1, 0, 0, 0); }
        }

        public override void Execute(PluginArgs e)
        {
            MessageBox.Show(e.Read(0).ToString(), "", (MessageBoxButtons)(int)e.Read(1), (MessageBoxIcon)(int)e.Read(2));
            PluginArgs args = new PluginArgs(Guid);
            args.Header = 0;
            Send(args);
            base.Execute(e);
        }

        public override void Stop()
        {
            base.Stop();
        }
    }
}
