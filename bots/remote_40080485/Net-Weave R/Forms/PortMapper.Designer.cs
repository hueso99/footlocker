namespace Net_Weave_R.Forms
{
    partial class PortMapper
    {
        /// <summary>
        /// Required designer variable.
        /// </summary>
        private System.ComponentModel.IContainer components = null;

        /// <summary>
        /// Clean up any resources being used.
        /// </summary>
        /// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
        protected override void Dispose(bool disposing)
        {
            if (disposing && (components != null))
            {
                components.Dispose();
            }
            base.Dispose(disposing);
        }

        #region Windows Form Designer generated code

        /// <summary>
        /// Required method for Designer support - do not modify
        /// the contents of this method with the code editor.
        /// </summary>
        private void InitializeComponent()
        {
            this.components = new System.ComponentModel.Container();
            this.carbonTheme1 = new CarbonTheme();
            this.panel1 = new System.Windows.Forms.Panel();
            this.carbonGroupBox1 = new CarbonGroupBox();
            this.btnTestCon = new CarbonButton();
            this.label5 = new System.Windows.Forms.Label();
            this.cbTestProtocol = new System.Windows.Forms.ComboBox();
            this.label4 = new System.Windows.Forms.Label();
            this.txtTestPort = new CarbonTextBox();
            this.label3 = new System.Windows.Forms.Label();
            this.label2 = new System.Windows.Forms.Label();
            this.label1 = new System.Windows.Forms.Label();
            this.btnAdd = new CarbonButton();
            this.txtEx = new CarbonTextBox();
            this.txtIn = new CarbonTextBox();
            this.cbProtocol = new System.Windows.Forms.ComboBox();
            this.lstPorts = new NetLib.Forms.xListview();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader2 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.columnHeader3 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.menuMain = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.removeToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.refreshToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripSeparator();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
            this.carbonGroupBox1.SuspendLayout();
            this.menuMain.SuspendLayout();
            this.SuspendLayout();
            // 
            // carbonTheme1
            // 
            this.carbonTheme1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonTheme1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonTheme1.ControlBox = true;
            this.carbonTheme1.Controls.Add(this.panel1);
            this.carbonTheme1.Customization = "wMDA/8DAwP96enr/09PT/0ZGRv+Wlpb/AAAA/////27///8e////AAAAAP9WVlb/";
            this.carbonTheme1.Dock = System.Windows.Forms.DockStyle.Fill;
            this.carbonTheme1.DrawHatch = true;
            this.carbonTheme1.EnableExit = true;
            this.carbonTheme1.EnableMaximize = false;
            this.carbonTheme1.EnableMinimize = true;
            this.carbonTheme1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonTheme1.Image = null;
            this.carbonTheme1.Location = new System.Drawing.Point(0, 0);
            this.carbonTheme1.Movable = true;
            this.carbonTheme1.Name = "carbonTheme1";
            this.carbonTheme1.NoRounding = false;
            this.carbonTheme1.Sizable = false;
            this.carbonTheme1.Size = new System.Drawing.Size(301, 347);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Port Mapper";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.carbonGroupBox1);
            this.panel1.Controls.Add(this.label3);
            this.panel1.Controls.Add(this.label2);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.btnAdd);
            this.panel1.Controls.Add(this.txtEx);
            this.panel1.Controls.Add(this.txtIn);
            this.panel1.Controls.Add(this.cbProtocol);
            this.panel1.Controls.Add(this.lstPorts);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(277, 308);
            this.panel1.TabIndex = 3;
            // 
            // carbonGroupBox1
            // 
            this.carbonGroupBox1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonGroupBox1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonGroupBox1.Controls.Add(this.btnTestCon);
            this.carbonGroupBox1.Controls.Add(this.label5);
            this.carbonGroupBox1.Controls.Add(this.cbTestProtocol);
            this.carbonGroupBox1.Controls.Add(this.label4);
            this.carbonGroupBox1.Controls.Add(this.txtTestPort);
            this.carbonGroupBox1.Customization = "09PT/6mpqf+pqan/////Rv///x7AwMD/4ODg/2xsbP8AAAD/qamp/w==";
            this.carbonGroupBox1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonGroupBox1.Image = null;
            this.carbonGroupBox1.Location = new System.Drawing.Point(14, 213);
            this.carbonGroupBox1.Movable = true;
            this.carbonGroupBox1.Name = "carbonGroupBox1";
            this.carbonGroupBox1.NoRounding = false;
            this.carbonGroupBox1.Sizable = true;
            this.carbonGroupBox1.Size = new System.Drawing.Size(249, 86);
            this.carbonGroupBox1.SmartBounds = true;
            this.carbonGroupBox1.TabIndex = 8;
            this.carbonGroupBox1.Text = "Connection Testing";
            this.carbonGroupBox1.TransparencyKey = System.Drawing.Color.Empty;
            this.carbonGroupBox1.Transparent = false;
            // 
            // btnTestCon
            // 
            this.btnTestCon.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnTestCon.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnTestCon.Image = null;
            this.btnTestCon.Location = new System.Drawing.Point(156, 48);
            this.btnTestCon.Name = "btnTestCon";
            this.btnTestCon.NoRounding = false;
            this.btnTestCon.Size = new System.Drawing.Size(72, 24);
            this.btnTestCon.TabIndex = 10;
            this.btnTestCon.Text = "Test";
            this.btnTestCon.Transparent = false;
            this.btnTestCon.Click += new System.EventHandler(this.btnTestCon_Click);
            // 
            // label5
            // 
            this.label5.AutoSize = true;
            this.label5.Location = new System.Drawing.Point(89, 32);
            this.label5.Name = "label5";
            this.label5.Size = new System.Drawing.Size(53, 13);
            this.label5.TabIndex = 9;
            this.label5.Text = "Protocol";
            // 
            // cbTestProtocol
            // 
            this.cbTestProtocol.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.cbTestProtocol.FormattingEnabled = true;
            this.cbTestProtocol.Items.AddRange(new object[] {
            "TCP",
            "UDP"});
            this.cbTestProtocol.Location = new System.Drawing.Point(81, 51);
            this.cbTestProtocol.Name = "cbTestProtocol";
            this.cbTestProtocol.Size = new System.Drawing.Size(69, 21);
            this.cbTestProtocol.TabIndex = 8;
            // 
            // label4
            // 
            this.label4.AutoSize = true;
            this.label4.Location = new System.Drawing.Point(32, 32);
            this.label4.Name = "label4";
            this.label4.Size = new System.Drawing.Size(30, 13);
            this.label4.TabIndex = 7;
            this.label4.Text = "Port";
            // 
            // txtTestPort
            // 
            this.txtTestPort.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtTestPort.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtTestPort.Image = null;
            this.txtTestPort.Location = new System.Drawing.Point(20, 48);
            this.txtTestPort.MaxLength = 32767;
            this.txtTestPort.Multiline = false;
            this.txtTestPort.Name = "txtTestPort";
            this.txtTestPort.NoRounding = false;
            this.txtTestPort.NumbersOnly = false;
            this.txtTestPort.ReadOnly = false;
            this.txtTestPort.Size = new System.Drawing.Size(55, 24);
            this.txtTestPort.TabIndex = 6;
            this.txtTestPort.Transparent = false;
            this.txtTestPort.UseSystemPasswordChar = false;
            // 
            // label3
            // 
            this.label3.AutoSize = true;
            this.label3.Location = new System.Drawing.Point(133, 167);
            this.label3.Name = "label3";
            this.label3.Size = new System.Drawing.Size(53, 13);
            this.label3.TabIndex = 7;
            this.label3.Text = "Protocol";
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(66, 167);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(54, 13);
            this.label2.TabIndex = 6;
            this.label2.Text = "External";
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(6, 167);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(52, 13);
            this.label1.TabIndex = 5;
            this.label1.Text = "Internal";
            // 
            // btnAdd
            // 
            this.btnAdd.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnAdd.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnAdd.Image = null;
            this.btnAdd.Location = new System.Drawing.Point(202, 183);
            this.btnAdd.Name = "btnAdd";
            this.btnAdd.NoRounding = false;
            this.btnAdd.Size = new System.Drawing.Size(72, 24);
            this.btnAdd.TabIndex = 4;
            this.btnAdd.Text = "Add";
            this.btnAdd.Transparent = false;
            this.btnAdd.Click += new System.EventHandler(this.btnAdd_Click);
            // 
            // txtEx
            // 
            this.txtEx.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtEx.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtEx.Image = null;
            this.txtEx.Location = new System.Drawing.Point(66, 183);
            this.txtEx.MaxLength = 32767;
            this.txtEx.Multiline = false;
            this.txtEx.Name = "txtEx";
            this.txtEx.NoRounding = false;
            this.txtEx.NumbersOnly = false;
            this.txtEx.ReadOnly = false;
            this.txtEx.Size = new System.Drawing.Size(55, 24);
            this.txtEx.TabIndex = 3;
            this.txtEx.Transparent = false;
            this.txtEx.UseSystemPasswordChar = false;
            // 
            // txtIn
            // 
            this.txtIn.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtIn.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtIn.Image = null;
            this.txtIn.Location = new System.Drawing.Point(5, 183);
            this.txtIn.MaxLength = 32767;
            this.txtIn.Multiline = false;
            this.txtIn.Name = "txtIn";
            this.txtIn.NoRounding = false;
            this.txtIn.NumbersOnly = false;
            this.txtIn.ReadOnly = false;
            this.txtIn.Size = new System.Drawing.Size(55, 24);
            this.txtIn.TabIndex = 2;
            this.txtIn.Transparent = false;
            this.txtIn.UseSystemPasswordChar = false;
            // 
            // cbProtocol
            // 
            this.cbProtocol.DropDownStyle = System.Windows.Forms.ComboBoxStyle.DropDownList;
            this.cbProtocol.FormattingEnabled = true;
            this.cbProtocol.Items.AddRange(new object[] {
            "TCP",
            "UDP"});
            this.cbProtocol.Location = new System.Drawing.Point(127, 185);
            this.cbProtocol.Name = "cbProtocol";
            this.cbProtocol.Size = new System.Drawing.Size(69, 21);
            this.cbProtocol.TabIndex = 1;
            // 
            // lstPorts
            // 
            this.lstPorts.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1,
            this.columnHeader2,
            this.columnHeader3});
            this.lstPorts.ContextMenuStrip = this.menuMain;
            this.lstPorts.Dock = System.Windows.Forms.DockStyle.Top;
            this.lstPorts.FullRowSelect = true;
            this.lstPorts.Location = new System.Drawing.Point(0, 0);
            this.lstPorts.Name = "lstPorts";
            this.lstPorts.Size = new System.Drawing.Size(277, 159);
            this.lstPorts.TabIndex = 0;
            this.lstPorts.UseCompatibleStateImageBehavior = false;
            this.lstPorts.View = System.Windows.Forms.View.Details;
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "Internal Port";
            this.columnHeader1.Width = 87;
            // 
            // columnHeader2
            // 
            this.columnHeader2.Text = "External Port";
            this.columnHeader2.Width = 89;
            // 
            // columnHeader3
            // 
            this.columnHeader3.Text = "Protocol";
            this.columnHeader3.Width = 73;
            // 
            // menuMain
            // 
            this.menuMain.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.removeToolStripMenuItem,
            this.toolStripMenuItem1,
            this.refreshToolStripMenuItem});
            this.menuMain.Name = "menuMain";
            this.menuMain.Size = new System.Drawing.Size(153, 76);
            // 
            // removeToolStripMenuItem
            // 
            this.removeToolStripMenuItem.Name = "removeToolStripMenuItem";
            this.removeToolStripMenuItem.Size = new System.Drawing.Size(152, 22);
            this.removeToolStripMenuItem.Text = "Remove";
            this.removeToolStripMenuItem.Click += new System.EventHandler(this.removeToolStripMenuItem_Click);
            // 
            // refreshToolStripMenuItem
            // 
            this.refreshToolStripMenuItem.Name = "refreshToolStripMenuItem";
            this.refreshToolStripMenuItem.Size = new System.Drawing.Size(152, 22);
            this.refreshToolStripMenuItem.Text = "Refresh";
            this.refreshToolStripMenuItem.Click += new System.EventHandler(this.refreshToolStripMenuItem_Click);
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(149, 6);
            // 
            // PortMapper
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(301, 347);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "PortMapper";
            this.Text = "PortMapper";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.carbonGroupBox1.ResumeLayout(false);
            this.carbonGroupBox1.PerformLayout();
            this.menuMain.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private NetLib.Forms.xListview lstPorts;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private System.Windows.Forms.ColumnHeader columnHeader2;
        private System.Windows.Forms.ColumnHeader columnHeader3;
        private CarbonGroupBox carbonGroupBox1;
        private System.Windows.Forms.Label label3;
        private System.Windows.Forms.Label label2;
        private System.Windows.Forms.Label label1;
        private CarbonButton btnAdd;
        private CarbonTextBox txtEx;
        private CarbonTextBox txtIn;
        private System.Windows.Forms.ComboBox cbProtocol;
        private CarbonButton btnTestCon;
        private System.Windows.Forms.Label label5;
        private System.Windows.Forms.ComboBox cbTestProtocol;
        private System.Windows.Forms.Label label4;
        private CarbonTextBox txtTestPort;
        private System.Windows.Forms.ContextMenuStrip menuMain;
        private System.Windows.Forms.ToolStripMenuItem removeToolStripMenuItem;
        private System.Windows.Forms.ToolStripSeparator toolStripMenuItem1;
        private System.Windows.Forms.ToolStripMenuItem refreshToolStripMenuItem;
    }
}