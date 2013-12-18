namespace Net_Weave_R.Forms.Dialogs
{
    partial class FloodPanelTypeDialog
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
            this.carbonRadioButton2 = new CarbonRadioButton();
            this.carbonRadioButton1 = new CarbonRadioButton();
            this.carbonButton1 = new CarbonButton();
            this.carbonTheme1.SuspendLayout();
            this.SuspendLayout();
            // 
            // carbonTheme1
            // 
            this.carbonTheme1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonTheme1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonTheme1.ControlBox = true;
            this.carbonTheme1.Controls.Add(this.carbonButton1);
            this.carbonTheme1.Controls.Add(this.carbonRadioButton2);
            this.carbonTheme1.Controls.Add(this.carbonRadioButton1);
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
            this.carbonTheme1.Size = new System.Drawing.Size(262, 75);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "Select Type";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            this.carbonTheme1.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.carbonTheme1_KeyPress);
            // 
            // carbonRadioButton2
            // 
            this.carbonRadioButton2.Checked = false;
            this.carbonRadioButton2.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv8AAAD/";
            this.carbonRadioButton2.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonRadioButton2.Image = null;
            this.carbonRadioButton2.Location = new System.Drawing.Point(102, 37);
            this.carbonRadioButton2.Name = "carbonRadioButton2";
            this.carbonRadioButton2.NoRounding = false;
            this.carbonRadioButton2.Size = new System.Drawing.Size(56, 16);
            this.carbonRadioButton2.TabIndex = 4;
            this.carbonRadioButton2.Text = "Multi";
            this.carbonRadioButton2.Transparent = false;
            this.carbonRadioButton2.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.carbonRadioButton2_KeyPress);
            // 
            // carbonRadioButton1
            // 
            this.carbonRadioButton1.Checked = true;
            this.carbonRadioButton1.Customization = "wMDA/1VVVf+AgID/QEBA/83Nzf+goKD/Wlpa/35+fv8AAAD/";
            this.carbonRadioButton1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonRadioButton1.Image = null;
            this.carbonRadioButton1.Location = new System.Drawing.Point(29, 37);
            this.carbonRadioButton1.Name = "carbonRadioButton1";
            this.carbonRadioButton1.NoRounding = false;
            this.carbonRadioButton1.Size = new System.Drawing.Size(67, 16);
            this.carbonRadioButton1.TabIndex = 3;
            this.carbonRadioButton1.Text = "Single";
            this.carbonRadioButton1.Transparent = false;
            this.carbonRadioButton1.KeyPress += new System.Windows.Forms.KeyPressEventHandler(this.carbonRadioButton1_KeyPress);
            // 
            // carbonButton1
            // 
            this.carbonButton1.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton1.Image = null;
            this.carbonButton1.Location = new System.Drawing.Point(164, 33);
            this.carbonButton1.Name = "carbonButton1";
            this.carbonButton1.NoRounding = false;
            this.carbonButton1.Size = new System.Drawing.Size(75, 23);
            this.carbonButton1.TabIndex = 5;
            this.carbonButton1.Text = "Select";
            this.carbonButton1.Transparent = false;
            this.carbonButton1.Click += new System.EventHandler(this.carbonButton1_Click);
            // 
            // FloodPanelTypeDialog
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(262, 75);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "FloodPanelTypeDialog";
            this.ShowIcon = false;
            this.ShowInTaskbar = false;
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private CarbonRadioButton carbonRadioButton2;
        private CarbonRadioButton carbonRadioButton1;
        private CarbonButton carbonButton1;
    }
}