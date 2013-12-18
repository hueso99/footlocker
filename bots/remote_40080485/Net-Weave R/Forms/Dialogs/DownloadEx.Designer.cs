namespace Net_Weave_R.Forms.Dialogs
{
    partial class DownloadEx
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
            this.xUpdate = new CarbonCheckBox();
            this.txtUrl = new CarbonTextBox();
            this.label1 = new System.Windows.Forms.Label();
            this.btnFromFile = new CarbonButton();
            this.btnExecute = new CarbonButton();
            this.txtPassword = new CarbonTextBox();
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
            this.carbonTheme1.Size = new System.Drawing.Size(382, 107);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Download\\Execute";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.txtPassword);
            this.panel1.Controls.Add(this.btnExecute);
            this.panel1.Controls.Add(this.btnFromFile);
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.txtUrl);
            this.panel1.Controls.Add(this.xUpdate);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(358, 68);
            this.panel1.TabIndex = 3;
            // 
            // xUpdate
            // 
            this.xUpdate.Checked = false;
            this.xUpdate.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv9qamr/AAAA/w==";
            this.xUpdate.Font = new System.Drawing.Font("Verdana", 8F);
            this.xUpdate.Image = null;
            this.xUpdate.Location = new System.Drawing.Point(170, 42);
            this.xUpdate.Name = "xUpdate";
            this.xUpdate.NoRounding = false;
            this.xUpdate.Size = new System.Drawing.Size(66, 16);
            this.xUpdate.TabIndex = 0;
            this.xUpdate.Text = "Update";
            this.xUpdate.Transparent = false;
            // 
            // txtUrl
            // 
            this.txtUrl.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtUrl.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtUrl.Image = null;
            this.txtUrl.Location = new System.Drawing.Point(65, 8);
            this.txtUrl.MaxLength = 32767;
            this.txtUrl.Multiline = false;
            this.txtUrl.Name = "txtUrl";
            this.txtUrl.NoRounding = false;
            this.txtUrl.NumbersOnly = false;
            this.txtUrl.ReadOnly = false;
            this.txtUrl.Size = new System.Drawing.Size(290, 24);
            this.txtUrl.TabIndex = 1;
            this.txtUrl.Transparent = false;
            this.txtUrl.UseSystemPasswordChar = false;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(6, 14);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(53, 13);
            this.label1.TabIndex = 2;
            this.label1.Text = "Url\\Path";
            // 
            // btnFromFile
            // 
            this.btnFromFile.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnFromFile.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnFromFile.Image = null;
            this.btnFromFile.Location = new System.Drawing.Point(6, 38);
            this.btnFromFile.Name = "btnFromFile";
            this.btnFromFile.NoRounding = false;
            this.btnFromFile.Size = new System.Drawing.Size(76, 23);
            this.btnFromFile.TabIndex = 3;
            this.btnFromFile.Text = "From File";
            this.btnFromFile.Transparent = false;
            this.btnFromFile.Click += new System.EventHandler(this.btnFromFile_Click);
            // 
            // btnExecute
            // 
            this.btnExecute.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnExecute.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnExecute.Image = null;
            this.btnExecute.Location = new System.Drawing.Point(88, 38);
            this.btnExecute.Name = "btnExecute";
            this.btnExecute.NoRounding = false;
            this.btnExecute.Size = new System.Drawing.Size(76, 23);
            this.btnExecute.TabIndex = 4;
            this.btnExecute.Text = "Execute";
            this.btnExecute.Transparent = false;
            this.btnExecute.Click += new System.EventHandler(this.btnExecute_Click);
            // 
            // txtPassword
            // 
            this.txtPassword.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtPassword.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtPassword.Image = null;
            this.txtPassword.Location = new System.Drawing.Point(241, 38);
            this.txtPassword.MaxLength = 32767;
            this.txtPassword.Multiline = false;
            this.txtPassword.Name = "txtPassword";
            this.txtPassword.NoRounding = false;
            this.txtPassword.NumbersOnly = false;
            this.txtPassword.ReadOnly = false;
            this.txtPassword.Size = new System.Drawing.Size(114, 24);
            this.txtPassword.TabIndex = 5;
            this.txtPassword.Transparent = false;
            this.txtPassword.UseSystemPasswordChar = true;
            // 
            // DownloadEx
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(382, 107);
            this.Controls.Add(this.carbonTheme1);
            this.DoubleBuffered = true;
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "DownloadEx";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Download\\Execute";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private CarbonTextBox txtPassword;
        private CarbonButton btnExecute;
        private CarbonButton btnFromFile;
        private System.Windows.Forms.Label label1;
        private CarbonTextBox txtUrl;
        private CarbonCheckBox xUpdate;
    }
}