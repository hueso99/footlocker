namespace Builder
{
    partial class fMain
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
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(fMain));
            this.gInformation = new System.Windows.Forms.GroupBox();
            this.gVersion = new System.Windows.Forms.GroupBox();
            this.txtInformation = new System.Windows.Forms.TextBox();
            this.lstMenu = new System.Windows.Forms.ListBox();
            this.gBuilder = new System.Windows.Forms.GroupBox();
            this.gBuilding = new System.Windows.Forms.GroupBox();
            this.bBuild = new System.Windows.Forms.Button();
            this.gConfig = new System.Windows.Forms.GroupBox();
            this.lblTemp_5 = new System.Windows.Forms.Label();
            this.nuInterval = new System.Windows.Forms.NumericUpDown();
            this.lblTemp_4 = new System.Windows.Forms.Label();
            this.bGenerateMutex = new System.Windows.Forms.Button();
            this.txtMutex = new System.Windows.Forms.TextBox();
            this.lblTemp_3 = new System.Windows.Forms.Label();
            this.txtAuthCode = new System.Windows.Forms.TextBox();
            this.lblTemp_2 = new System.Windows.Forms.Label();
            this.txtServerAddress = new System.Windows.Forms.TextBox();
            this.lblTemp_1 = new System.Windows.Forms.Label();
            this.gInformation.SuspendLayout();
            this.gVersion.SuspendLayout();
            this.gBuilder.SuspendLayout();
            this.gBuilding.SuspendLayout();
            this.gConfig.SuspendLayout();
            ((System.ComponentModel.ISupportInitialize)(this.nuInterval)).BeginInit();
            this.SuspendLayout();
            // 
            // gInformation
            // 
            this.gInformation.Controls.Add(this.gVersion);
            this.gInformation.Location = new System.Drawing.Point(155, 7);
            this.gInformation.Name = "gInformation";
            this.gInformation.Size = new System.Drawing.Size(548, 272);
            this.gInformation.TabIndex = 0;
            this.gInformation.TabStop = false;
            this.gInformation.Text = "Information";
            // 
            // gVersion
            // 
            this.gVersion.Controls.Add(this.txtInformation);
            this.gVersion.Location = new System.Drawing.Point(6, 19);
            this.gVersion.Name = "gVersion";
            this.gVersion.Size = new System.Drawing.Size(536, 120);
            this.gVersion.TabIndex = 0;
            this.gVersion.TabStop = false;
            this.gVersion.Text = "Current Version Information";
            // 
            // txtInformation
            // 
            this.txtInformation.Cursor = System.Windows.Forms.Cursors.Default;
            this.txtInformation.HideSelection = false;
            this.txtInformation.Location = new System.Drawing.Point(6, 19);
            this.txtInformation.Multiline = true;
            this.txtInformation.Name = "txtInformation";
            this.txtInformation.ReadOnly = true;
            this.txtInformation.Size = new System.Drawing.Size(524, 95);
            this.txtInformation.TabIndex = 0;
            this.txtInformation.Text = "Version: 1.0.5.0\r\n\r\nBuild time: 20:02 04.06.2010 GMT +1\r\n\r\nCopyright © w!cKed 201" +
                "0\r\nAll rights reserved.";
            // 
            // lstMenu
            // 
            this.lstMenu.FormattingEnabled = true;
            this.lstMenu.Location = new System.Drawing.Point(12, 12);
            this.lstMenu.Name = "lstMenu";
            this.lstMenu.Size = new System.Drawing.Size(137, 264);
            this.lstMenu.TabIndex = 1;
            this.lstMenu.SelectedIndexChanged += new System.EventHandler(this.lstMenu_SelectedIndexChanged);
            // 
            // gBuilder
            // 
            this.gBuilder.BackColor = System.Drawing.Color.Transparent;
            this.gBuilder.Controls.Add(this.gBuilding);
            this.gBuilder.Controls.Add(this.gConfig);
            this.gBuilder.Location = new System.Drawing.Point(155, 8);
            this.gBuilder.Name = "gBuilder";
            this.gBuilder.Size = new System.Drawing.Size(550, 271);
            this.gBuilder.TabIndex = 5;
            this.gBuilder.TabStop = false;
            this.gBuilder.Text = "Builder";
            // 
            // gBuilding
            // 
            this.gBuilding.Controls.Add(this.bBuild);
            this.gBuilding.Location = new System.Drawing.Point(8, 213);
            this.gBuilding.Name = "gBuilding";
            this.gBuilding.Size = new System.Drawing.Size(534, 53);
            this.gBuilding.TabIndex = 3;
            this.gBuilding.TabStop = false;
            this.gBuilding.Text = "Building";
            // 
            // bBuild
            // 
            this.bBuild.Location = new System.Drawing.Point(7, 19);
            this.bBuild.Name = "bBuild";
            this.bBuild.Size = new System.Drawing.Size(118, 23);
            this.bBuild.TabIndex = 0;
            this.bBuild.Text = "Build Bot Binary";
            this.bBuild.UseVisualStyleBackColor = true;
            this.bBuild.Click += new System.EventHandler(this.bBuild_Click);
            // 
            // gConfig
            // 
            this.gConfig.Controls.Add(this.lblTemp_5);
            this.gConfig.Controls.Add(this.nuInterval);
            this.gConfig.Controls.Add(this.lblTemp_4);
            this.gConfig.Controls.Add(this.bGenerateMutex);
            this.gConfig.Controls.Add(this.txtMutex);
            this.gConfig.Controls.Add(this.lblTemp_3);
            this.gConfig.Controls.Add(this.txtAuthCode);
            this.gConfig.Controls.Add(this.lblTemp_2);
            this.gConfig.Controls.Add(this.txtServerAddress);
            this.gConfig.Controls.Add(this.lblTemp_1);
            this.gConfig.Location = new System.Drawing.Point(6, 19);
            this.gConfig.Name = "gConfig";
            this.gConfig.Size = new System.Drawing.Size(536, 188);
            this.gConfig.TabIndex = 2;
            this.gConfig.TabStop = false;
            this.gConfig.Text = "Config";
            // 
            // lblTemp_5
            // 
            this.lblTemp_5.AutoSize = true;
            this.lblTemp_5.Location = new System.Drawing.Point(115, 155);
            this.lblTemp_5.Name = "lblTemp_5";
            this.lblTemp_5.Size = new System.Drawing.Size(127, 13);
            this.lblTemp_5.TabIndex = 12;
            this.lblTemp_5.Text = "(Best Value: 60 Seconds)";
            // 
            // nuInterval
            // 
            this.nuInterval.Increment = new decimal(new int[] {
            2,
            0,
            0,
            0});
            this.nuInterval.Location = new System.Drawing.Point(10, 153);
            this.nuInterval.Maximum = new decimal(new int[] {
            120,
            0,
            0,
            0});
            this.nuInterval.Minimum = new decimal(new int[] {
            10,
            0,
            0,
            0});
            this.nuInterval.Name = "nuInterval";
            this.nuInterval.Size = new System.Drawing.Size(99, 20);
            this.nuInterval.TabIndex = 11;
            this.nuInterval.Value = new decimal(new int[] {
            10,
            0,
            0,
            0});
            // 
            // lblTemp_4
            // 
            this.lblTemp_4.AutoSize = true;
            this.lblTemp_4.Location = new System.Drawing.Point(7, 137);
            this.lblTemp_4.Name = "lblTemp_4";
            this.lblTemp_4.Size = new System.Drawing.Size(150, 13);
            this.lblTemp_4.TabIndex = 10;
            this.lblTemp_4.Text = "Connection Interval(Seconds):";
            // 
            // bGenerateMutex
            // 
            this.bGenerateMutex.Location = new System.Drawing.Point(413, 109);
            this.bGenerateMutex.Name = "bGenerateMutex";
            this.bGenerateMutex.Size = new System.Drawing.Size(117, 21);
            this.bGenerateMutex.TabIndex = 8;
            this.bGenerateMutex.Text = "Generate";
            this.bGenerateMutex.UseVisualStyleBackColor = true;
            this.bGenerateMutex.Click += new System.EventHandler(this.bGenerateMutex_Click);
            // 
            // txtMutex
            // 
            this.txtMutex.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.txtMutex.Location = new System.Drawing.Point(9, 110);
            this.txtMutex.Name = "txtMutex";
            this.txtMutex.Size = new System.Drawing.Size(398, 20);
            this.txtMutex.TabIndex = 7;
            // 
            // lblTemp_3
            // 
            this.lblTemp_3.AutoSize = true;
            this.lblTemp_3.Location = new System.Drawing.Point(6, 94);
            this.lblTemp_3.Name = "lblTemp_3";
            this.lblTemp_3.Size = new System.Drawing.Size(81, 13);
            this.lblTemp_3.TabIndex = 6;
            this.lblTemp_3.Text = "Program Mutex:";
            // 
            // txtAuthCode
            // 
            this.txtAuthCode.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.txtAuthCode.Location = new System.Drawing.Point(9, 71);
            this.txtAuthCode.Name = "txtAuthCode";
            this.txtAuthCode.Size = new System.Drawing.Size(521, 20);
            this.txtAuthCode.TabIndex = 5;
            // 
            // lblTemp_2
            // 
            this.lblTemp_2.AutoSize = true;
            this.lblTemp_2.Location = new System.Drawing.Point(6, 55);
            this.lblTemp_2.Name = "lblTemp_2";
            this.lblTemp_2.Size = new System.Drawing.Size(106, 13);
            this.lblTemp_2.TabIndex = 4;
            this.lblTemp_2.Text = "Authentication Code:";
            // 
            // txtServerAddress
            // 
            this.txtServerAddress.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.txtServerAddress.Location = new System.Drawing.Point(9, 32);
            this.txtServerAddress.Name = "txtServerAddress";
            this.txtServerAddress.Size = new System.Drawing.Size(521, 20);
            this.txtServerAddress.TabIndex = 3;
            // 
            // lblTemp_1
            // 
            this.lblTemp_1.AutoSize = true;
            this.lblTemp_1.Location = new System.Drawing.Point(6, 16);
            this.lblTemp_1.Name = "lblTemp_1";
            this.lblTemp_1.Size = new System.Drawing.Size(82, 13);
            this.lblTemp_1.TabIndex = 2;
            this.lblTemp_1.Text = "Server Address:";
            // 
            // fMain
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.BackColor = System.Drawing.SystemColors.Control;
            this.ClientSize = new System.Drawing.Size(717, 284);
            this.Controls.Add(this.gBuilder);
            this.Controls.Add(this.lstMenu);
            this.Controls.Add(this.gInformation);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.FixedDialog;
            this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
            this.MaximizeBox = false;
            this.Name = "fMain";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "N0PE Bot Builder";
            this.Load += new System.EventHandler(this.fMain_Load);
            this.gInformation.ResumeLayout(false);
            this.gVersion.ResumeLayout(false);
            this.gVersion.PerformLayout();
            this.gBuilder.ResumeLayout(false);
            this.gBuilding.ResumeLayout(false);
            this.gConfig.ResumeLayout(false);
            this.gConfig.PerformLayout();
            ((System.ComponentModel.ISupportInitialize)(this.nuInterval)).EndInit();
            this.ResumeLayout(false);

        }

        #endregion

        private System.Windows.Forms.GroupBox gInformation;
        private System.Windows.Forms.ListBox lstMenu;
        private System.Windows.Forms.GroupBox gVersion;
        private System.Windows.Forms.TextBox txtInformation;
        private System.Windows.Forms.GroupBox gBuilder;
        private System.Windows.Forms.GroupBox gBuilding;
        private System.Windows.Forms.Button bBuild;
        private System.Windows.Forms.GroupBox gConfig;
        private System.Windows.Forms.Label lblTemp_5;
        private System.Windows.Forms.NumericUpDown nuInterval;
        private System.Windows.Forms.Label lblTemp_4;
        private System.Windows.Forms.Button bGenerateMutex;
        private System.Windows.Forms.TextBox txtMutex;
        private System.Windows.Forms.Label lblTemp_3;
        private System.Windows.Forms.TextBox txtAuthCode;
        private System.Windows.Forms.Label lblTemp_2;
        private System.Windows.Forms.TextBox txtServerAddress;
        private System.Windows.Forms.Label lblTemp_1;
    }
}

