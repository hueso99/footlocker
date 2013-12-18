namespace Net_Weave_R.Forms
{
    partial class BugReport
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
            this.label1 = new System.Windows.Forms.Label();
            this.txtTitle = new CarbonTextBox();
            this.txtMessage = new CarbonTextBox();
            this.label2 = new System.Windows.Forms.Label();
            this.txtCaptcha = new CarbonTextBox();
            this.lblCapa = new System.Windows.Forms.Label();
            this.btnSubmit = new CarbonButton();
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
            this.carbonTheme1.EnableMaximize = false;
            this.carbonTheme1.EnableMinimize = true;
            this.carbonTheme1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonTheme1.Image = null;
            this.carbonTheme1.Location = new System.Drawing.Point(0, 0);
            this.carbonTheme1.Movable = true;
            this.carbonTheme1.Name = "carbonTheme1";
            this.carbonTheme1.NoRounding = false;
            this.carbonTheme1.Sizable = false;
            this.carbonTheme1.Size = new System.Drawing.Size(341, 328);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Bug Report";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.btnSubmit);
            this.panel1.Controls.Add(this.lblCapa);
            this.panel1.Controls.Add(this.txtCaptcha);
            this.panel1.Controls.Add(this.txtMessage);
            this.panel1.Controls.Add(this.label2);
            this.panel1.Controls.Add(this.txtTitle);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(317, 289);
            this.panel1.TabIndex = 3;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(143, 10);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(31, 13);
            this.label1.TabIndex = 0;
            this.label1.Text = "Title";
            // 
            // txtTitle
            // 
            this.txtTitle.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtTitle.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtTitle.Image = null;
            this.txtTitle.Location = new System.Drawing.Point(3, 26);
            this.txtTitle.MaxLength = 32767;
            this.txtTitle.Multiline = false;
            this.txtTitle.Name = "txtTitle";
            this.txtTitle.NoRounding = false;
            this.txtTitle.NumbersOnly = false;
            this.txtTitle.ReadOnly = false;
            this.txtTitle.Size = new System.Drawing.Size(311, 24);
            this.txtTitle.TabIndex = 1;
            this.txtTitle.Transparent = false;
            this.txtTitle.UseSystemPasswordChar = false;
            // 
            // txtMessage
            // 
            this.txtMessage.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtMessage.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtMessage.Image = null;
            this.txtMessage.Location = new System.Drawing.Point(3, 69);
            this.txtMessage.MaxLength = 32767;
            this.txtMessage.Multiline = true;
            this.txtMessage.Name = "txtMessage";
            this.txtMessage.NoRounding = false;
            this.txtMessage.NumbersOnly = false;
            this.txtMessage.ReadOnly = false;
            this.txtMessage.Size = new System.Drawing.Size(311, 181);
            this.txtMessage.TabIndex = 3;
            this.txtMessage.Transparent = false;
            this.txtMessage.UseSystemPasswordChar = false;
            // 
            // label2
            // 
            this.label2.AutoSize = true;
            this.label2.Location = new System.Drawing.Point(130, 53);
            this.label2.Name = "label2";
            this.label2.Size = new System.Drawing.Size(56, 13);
            this.label2.TabIndex = 2;
            this.label2.Text = "Message";
            // 
            // txtCaptcha
            // 
            this.txtCaptcha.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtCaptcha.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtCaptcha.Image = null;
            this.txtCaptcha.Location = new System.Drawing.Point(80, 256);
            this.txtCaptcha.MaxLength = 32767;
            this.txtCaptcha.Multiline = false;
            this.txtCaptcha.Name = "txtCaptcha";
            this.txtCaptcha.NoRounding = false;
            this.txtCaptcha.NumbersOnly = false;
            this.txtCaptcha.ReadOnly = false;
            this.txtCaptcha.Size = new System.Drawing.Size(106, 24);
            this.txtCaptcha.TabIndex = 4;
            this.txtCaptcha.Transparent = false;
            this.txtCaptcha.UseSystemPasswordChar = false;
            // 
            // lblCapa
            // 
            this.lblCapa.AutoSize = true;
            this.lblCapa.Location = new System.Drawing.Point(3, 262);
            this.lblCapa.Name = "lblCapa";
            this.lblCapa.Size = new System.Drawing.Size(0, 13);
            this.lblCapa.TabIndex = 5;
            // 
            // btnSubmit
            // 
            this.btnSubmit.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnSubmit.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnSubmit.Image = null;
            this.btnSubmit.Location = new System.Drawing.Point(192, 256);
            this.btnSubmit.Name = "btnSubmit";
            this.btnSubmit.NoRounding = false;
            this.btnSubmit.Size = new System.Drawing.Size(122, 24);
            this.btnSubmit.TabIndex = 6;
            this.btnSubmit.Text = "Submit";
            this.btnSubmit.Transparent = false;
            this.btnSubmit.Click += new System.EventHandler(this.btnSubmit_Click);
            // 
            // BugReport
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(341, 328);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "BugReport";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Bug Report";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private CarbonButton btnSubmit;
        private System.Windows.Forms.Label lblCapa;
        private CarbonTextBox txtCaptcha;
        private CarbonTextBox txtMessage;
        private System.Windows.Forms.Label label2;
        private CarbonTextBox txtTitle;
        private System.Windows.Forms.Label label1;
    }
}