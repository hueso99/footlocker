namespace Net_Weave_R.Forms
{
    partial class PMForm
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
            this.carbonTheme1 = new CarbonTheme();
            this.panel1 = new System.Windows.Forms.Panel();
            this.xSendOnEnter = new CarbonCheckBox();
            this.btnSend = new CarbonButton();
            this.txtMessage = new CarbonTextBox();
            this.txtChat = new System.Windows.Forms.RichTextBox();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
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
            this.carbonTheme1.EnableMaximize = true;
            this.carbonTheme1.EnableMinimize = true;
            this.carbonTheme1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonTheme1.Image = null;
            this.carbonTheme1.Location = new System.Drawing.Point(0, 0);
            this.carbonTheme1.Movable = true;
            this.carbonTheme1.Name = "carbonTheme1";
            this.carbonTheme1.NoRounding = false;
            this.carbonTheme1.Sizable = false;
            this.carbonTheme1.Size = new System.Drawing.Size(349, 414);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "PM";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.xSendOnEnter);
            this.panel1.Controls.Add(this.btnSend);
            this.panel1.Controls.Add(this.txtMessage);
            this.panel1.Controls.Add(this.txtChat);
            this.panel1.Location = new System.Drawing.Point(12, 28);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(325, 374);
            this.panel1.TabIndex = 0;
            // 
            // xSendOnEnter
            // 
            this.xSendOnEnter.Checked = true;
            this.xSendOnEnter.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xSendOnEnter.Font = new System.Drawing.Font("Verdana", 8F);
            this.xSendOnEnter.Image = null;
            this.xSendOnEnter.Location = new System.Drawing.Point(3, 352);
            this.xSendOnEnter.Name = "xSendOnEnter";
            this.xSendOnEnter.NoRounding = false;
            this.xSendOnEnter.Size = new System.Drawing.Size(105, 16);
            this.xSendOnEnter.TabIndex = 3;
            this.xSendOnEnter.Text = "Send on Enter";
            this.xSendOnEnter.Transparent = false;
            // 
            // btnSend
            // 
            this.btnSend.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnSend.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnSend.Image = null;
            this.btnSend.Location = new System.Drawing.Point(260, 301);
            this.btnSend.Name = "btnSend";
            this.btnSend.NoRounding = false;
            this.btnSend.Size = new System.Drawing.Size(62, 45);
            this.btnSend.TabIndex = 2;
            this.btnSend.Text = "Send";
            this.btnSend.Transparent = false;
            this.btnSend.Click += new System.EventHandler(this.btnSend_Click);
            // 
            // txtMessage
            // 
            this.txtMessage.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtMessage.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtMessage.Image = null;
            this.txtMessage.Location = new System.Drawing.Point(3, 301);
            this.txtMessage.MaxLength = 32767;
            this.txtMessage.Multiline = true;
            this.txtMessage.Name = "txtMessage";
            this.txtMessage.NoRounding = false;
            this.txtMessage.NumbersOnly = false;
            this.txtMessage.ReadOnly = false;
            this.txtMessage.Size = new System.Drawing.Size(251, 45);
            this.txtMessage.TabIndex = 1;
            this.txtMessage.Transparent = false;
            this.txtMessage.UseSystemPasswordChar = false;
            // 
            // txtChat
            // 
            this.txtChat.Dock = System.Windows.Forms.DockStyle.Top;
            this.txtChat.Location = new System.Drawing.Point(0, 0);
            this.txtChat.Name = "txtChat";
            this.txtChat.Size = new System.Drawing.Size(325, 295);
            this.txtChat.TabIndex = 0;
            this.txtChat.Text = "";
            // 
            // PMForm
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(349, 414);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "PMForm";
            this.Text = "PMForm";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.RichTextBox txtChat;
        private CarbonCheckBox xSendOnEnter;
        private CarbonButton btnSend;
        private CarbonTextBox txtMessage;
    }
}