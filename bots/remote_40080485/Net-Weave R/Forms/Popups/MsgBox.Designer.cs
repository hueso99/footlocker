namespace Net_Weave_R.Forms.Popups
{
    partial class MsgBox
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
            this.picIcon = new System.Windows.Forms.PictureBox();
            this.lblText = new System.Windows.Forms.Label();
            this.panelYesNo = new System.Windows.Forms.Panel();
            this.carbonButton3 = new CarbonButton();
            this.carbonButton2 = new CarbonButton();
            this.panelYesNoCancel = new System.Windows.Forms.Panel();
            this.carbonButton4 = new CarbonButton();
            this.carbonButton6 = new CarbonButton();
            this.carbonButton5 = new CarbonButton();
            this.panelOk = new System.Windows.Forms.Panel();
            this.carbonButton1 = new CarbonButton();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.picIcon)).BeginInit();
            this.panelYesNo.SuspendLayout();
            this.panelYesNoCancel.SuspendLayout();
            this.panelOk.SuspendLayout();
            this.SuspendLayout();
            // 
            // carbonTheme1
            // 
            this.carbonTheme1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonTheme1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonTheme1.ControlBox = false;
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
            this.carbonTheme1.Size = new System.Drawing.Size(447, 175);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Controls.Add(this.picIcon);
            this.panel1.Controls.Add(this.lblText);
            this.panel1.Controls.Add(this.panelYesNo);
            this.panel1.Controls.Add(this.panelYesNoCancel);
            this.panel1.Controls.Add(this.panelOk);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(423, 136);
            this.panel1.TabIndex = 3;
            // 
            // picIcon
            // 
            this.picIcon.Location = new System.Drawing.Point(6, 22);
            this.picIcon.Name = "picIcon";
            this.picIcon.Size = new System.Drawing.Size(52, 41);
            this.picIcon.SizeMode = System.Windows.Forms.PictureBoxSizeMode.AutoSize;
            this.picIcon.TabIndex = 4;
            this.picIcon.TabStop = false;
            // 
            // lblText
            // 
            this.lblText.ForeColor = System.Drawing.Color.Black;
            this.lblText.Location = new System.Drawing.Point(58, 0);
            this.lblText.Name = "lblText";
            this.lblText.Size = new System.Drawing.Size(362, 92);
            this.lblText.TabIndex = 1;
            this.lblText.Text = "TEXT";
            this.lblText.TextAlign = System.Drawing.ContentAlignment.MiddleCenter;
            // 
            // panelYesNo
            // 
            this.panelYesNo.Controls.Add(this.carbonButton3);
            this.panelYesNo.Controls.Add(this.carbonButton2);
            this.panelYesNo.Location = new System.Drawing.Point(6, 92);
            this.panelYesNo.Name = "panelYesNo";
            this.panelYesNo.Size = new System.Drawing.Size(417, 44);
            this.panelYesNo.TabIndex = 3;
            // 
            // carbonButton3
            // 
            this.carbonButton3.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton3.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton3.Image = null;
            this.carbonButton3.Location = new System.Drawing.Point(258, 4);
            this.carbonButton3.Name = "carbonButton3";
            this.carbonButton3.NoRounding = false;
            this.carbonButton3.Size = new System.Drawing.Size(88, 37);
            this.carbonButton3.TabIndex = 1;
            this.carbonButton3.Text = "No";
            this.carbonButton3.Transparent = false;
            this.carbonButton3.Click += new System.EventHandler(this.carbonButton3_Click);
            // 
            // carbonButton2
            // 
            this.carbonButton2.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton2.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton2.Image = null;
            this.carbonButton2.Location = new System.Drawing.Point(70, 4);
            this.carbonButton2.Name = "carbonButton2";
            this.carbonButton2.NoRounding = false;
            this.carbonButton2.Size = new System.Drawing.Size(88, 37);
            this.carbonButton2.TabIndex = 0;
            this.carbonButton2.Text = "Yes";
            this.carbonButton2.Transparent = false;
            this.carbonButton2.Click += new System.EventHandler(this.carbonButton2_Click);
            // 
            // panelYesNoCancel
            // 
            this.panelYesNoCancel.Controls.Add(this.carbonButton4);
            this.panelYesNoCancel.Controls.Add(this.carbonButton6);
            this.panelYesNoCancel.Controls.Add(this.carbonButton5);
            this.panelYesNoCancel.Location = new System.Drawing.Point(3, 92);
            this.panelYesNoCancel.Name = "panelYesNoCancel";
            this.panelYesNoCancel.Size = new System.Drawing.Size(417, 41);
            this.panelYesNoCancel.TabIndex = 3;
            // 
            // carbonButton4
            // 
            this.carbonButton4.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton4.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton4.Image = null;
            this.carbonButton4.Location = new System.Drawing.Point(6, 1);
            this.carbonButton4.Name = "carbonButton4";
            this.carbonButton4.NoRounding = false;
            this.carbonButton4.Size = new System.Drawing.Size(88, 37);
            this.carbonButton4.TabIndex = 0;
            this.carbonButton4.Text = "Yes";
            this.carbonButton4.Transparent = false;
            this.carbonButton4.Click += new System.EventHandler(this.carbonButton4_Click);
            // 
            // carbonButton6
            // 
            this.carbonButton6.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton6.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton6.Image = null;
            this.carbonButton6.Location = new System.Drawing.Point(326, 1);
            this.carbonButton6.Name = "carbonButton6";
            this.carbonButton6.NoRounding = false;
            this.carbonButton6.Size = new System.Drawing.Size(88, 37);
            this.carbonButton6.TabIndex = 2;
            this.carbonButton6.Text = "Cancel";
            this.carbonButton6.Transparent = false;
            this.carbonButton6.Click += new System.EventHandler(this.carbonButton6_Click);
            // 
            // carbonButton5
            // 
            this.carbonButton5.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton5.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton5.Image = null;
            this.carbonButton5.Location = new System.Drawing.Point(164, 1);
            this.carbonButton5.Name = "carbonButton5";
            this.carbonButton5.NoRounding = false;
            this.carbonButton5.Size = new System.Drawing.Size(88, 37);
            this.carbonButton5.TabIndex = 1;
            this.carbonButton5.Text = "No";
            this.carbonButton5.Transparent = false;
            this.carbonButton5.Click += new System.EventHandler(this.carbonButton5_Click);
            // 
            // panelOk
            // 
            this.panelOk.Controls.Add(this.carbonButton1);
            this.panelOk.Location = new System.Drawing.Point(3, 92);
            this.panelOk.Name = "panelOk";
            this.panelOk.Size = new System.Drawing.Size(417, 44);
            this.panelOk.TabIndex = 2;
            // 
            // carbonButton1
            // 
            this.carbonButton1.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton1.Image = null;
            this.carbonButton1.Location = new System.Drawing.Point(164, 4);
            this.carbonButton1.Name = "carbonButton1";
            this.carbonButton1.NoRounding = false;
            this.carbonButton1.Size = new System.Drawing.Size(88, 37);
            this.carbonButton1.TabIndex = 0;
            this.carbonButton1.Text = "OK";
            this.carbonButton1.Transparent = false;
            this.carbonButton1.Click += new System.EventHandler(this.carbonButton1_Click);
            // 
            // MessageBox
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(447, 175);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "MessageBox";
            this.ShowIcon = false;
            this.ShowInTaskbar = false;
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "Message Box";
            this.TopMost = true;
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.picIcon)).EndInit();
            this.panelYesNo.ResumeLayout(false);
            this.panelYesNoCancel.ResumeLayout(false);
            this.panelOk.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Label lblText;
        private CarbonButton carbonButton1;
        private System.Windows.Forms.Panel panelOk;
        private System.Windows.Forms.Panel panelYesNo;
        private CarbonButton carbonButton3;
        private CarbonButton carbonButton2;
        private System.Windows.Forms.Panel panelYesNoCancel;
        private CarbonButton carbonButton6;
        private CarbonButton carbonButton5;
        private CarbonButton carbonButton4;
        private System.Windows.Forms.PictureBox picIcon;


    }
}