using NetLib.Forms;
namespace Net_Weave_R.Forms.Dialogs
{
    partial class AssemblyEditor
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
            System.Windows.Forms.TreeNode treeNode21 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode22 = new System.Windows.Forms.TreeNode("Title", new System.Windows.Forms.TreeNode[] {
            treeNode21});
            System.Windows.Forms.TreeNode treeNode23 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode24 = new System.Windows.Forms.TreeNode("Description", new System.Windows.Forms.TreeNode[] {
            treeNode23});
            System.Windows.Forms.TreeNode treeNode25 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode26 = new System.Windows.Forms.TreeNode("Configuration", new System.Windows.Forms.TreeNode[] {
            treeNode25});
            System.Windows.Forms.TreeNode treeNode27 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode28 = new System.Windows.Forms.TreeNode("Company", new System.Windows.Forms.TreeNode[] {
            treeNode27});
            System.Windows.Forms.TreeNode treeNode29 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode30 = new System.Windows.Forms.TreeNode("Copyright", new System.Windows.Forms.TreeNode[] {
            treeNode29});
            System.Windows.Forms.TreeNode treeNode31 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode32 = new System.Windows.Forms.TreeNode("Trademark", new System.Windows.Forms.TreeNode[] {
            treeNode31});
            System.Windows.Forms.TreeNode treeNode33 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode34 = new System.Windows.Forms.TreeNode("Culture", new System.Windows.Forms.TreeNode[] {
            treeNode33});
            System.Windows.Forms.TreeNode treeNode35 = new System.Windows.Forms.TreeNode("");
            System.Windows.Forms.TreeNode treeNode36 = new System.Windows.Forms.TreeNode("Guid", new System.Windows.Forms.TreeNode[] {
            treeNode35});
            System.Windows.Forms.TreeNode treeNode37 = new System.Windows.Forms.TreeNode("1.0.0.0");
            System.Windows.Forms.TreeNode treeNode38 = new System.Windows.Forms.TreeNode("Assembly Version", new System.Windows.Forms.TreeNode[] {
            treeNode37});
            System.Windows.Forms.TreeNode treeNode39 = new System.Windows.Forms.TreeNode("1.0.0.0");
            System.Windows.Forms.TreeNode treeNode40 = new System.Windows.Forms.TreeNode("Assembly File Version", new System.Windows.Forms.TreeNode[] {
            treeNode39});
            this.pBox = new System.Windows.Forms.PictureBox();
            this.tv = new NetLib.Forms.xTreeView();
            this.contextMenuStrip1 = new System.Windows.Forms.ContextMenuStrip(this.components);
            this.generateGUIDToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
            this.carbonTheme1 = new CarbonTheme();
            this.panel1 = new System.Windows.Forms.Panel();
            this.carbonGroupBox1 = new CarbonGroupBox();
            this.btnOpenIcon = new CarbonButton();
            this.txtIconPath = new CarbonTextBox();
            this.carbonButton1 = new CarbonButton();
            this.carbonButton2 = new CarbonButton();
            this.carbonButton3 = new CarbonButton();
            this.btnClone = new CarbonButton();
            ((System.ComponentModel.ISupportInitialize)(this.pBox)).BeginInit();
            this.contextMenuStrip1.SuspendLayout();
            this.carbonTheme1.SuspendLayout();
            this.panel1.SuspendLayout();
            this.carbonGroupBox1.SuspendLayout();
            this.SuspendLayout();
            // 
            // pBox
            // 
            this.pBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
            this.pBox.Location = new System.Drawing.Point(211, 27);
            this.pBox.Name = "pBox";
            this.pBox.Size = new System.Drawing.Size(36, 36);
            this.pBox.TabIndex = 0;
            this.pBox.TabStop = false;
            // 
            // tv
            // 
            this.tv.ContextMenuStrip = this.contextMenuStrip1;
            this.tv.FullRowSelect = true;
            this.tv.LabelEdit = true;
            this.tv.Location = new System.Drawing.Point(3, 3);
            this.tv.Name = "tv";
            treeNode21.Name = "Node16";
            treeNode21.Text = "";
            treeNode22.Name = "Node0";
            treeNode22.Text = "Title";
            treeNode23.Name = "Node17";
            treeNode23.Text = "";
            treeNode24.Name = "Node1";
            treeNode24.Text = "Description";
            treeNode25.Name = "Node18";
            treeNode25.Text = "";
            treeNode26.Name = "Node2";
            treeNode26.Text = "Configuration";
            treeNode27.Name = "Node19";
            treeNode27.Text = "";
            treeNode28.Name = "Node9";
            treeNode28.Text = "Company";
            treeNode29.Name = "Node20";
            treeNode29.Text = "";
            treeNode30.Name = "Node10";
            treeNode30.Text = "Copyright";
            treeNode31.Name = "Node21";
            treeNode31.Text = "";
            treeNode32.Name = "Node11";
            treeNode32.Text = "Trademark";
            treeNode33.Name = "Node22";
            treeNode33.Text = "";
            treeNode34.Name = "Node12";
            treeNode34.Text = "Culture";
            treeNode35.Name = "Node23";
            treeNode35.Text = "";
            treeNode36.Name = "Node13";
            treeNode36.Text = "Guid";
            treeNode37.Name = "Node24";
            treeNode37.Text = "1.0.0.0";
            treeNode38.Name = "Node14";
            treeNode38.Text = "Assembly Version";
            treeNode39.Name = "Node25";
            treeNode39.Text = "1.0.0.0";
            treeNode40.Name = "Node15";
            treeNode40.Text = "Assembly File Version";
            this.tv.Nodes.AddRange(new System.Windows.Forms.TreeNode[] {
            treeNode22,
            treeNode24,
            treeNode26,
            treeNode28,
            treeNode30,
            treeNode32,
            treeNode34,
            treeNode36,
            treeNode38,
            treeNode40});
            this.tv.ShowLines = false;
            this.tv.Size = new System.Drawing.Size(258, 327);
            this.tv.TabIndex = 0;
            this.tv.AfterLabelEdit += new System.Windows.Forms.NodeLabelEditEventHandler(this.tv_AfterLabelEdit);
            // 
            // contextMenuStrip1
            // 
            this.contextMenuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.generateGUIDToolStripMenuItem});
            this.contextMenuStrip1.Name = "contextMenuStrip1";
            this.contextMenuStrip1.Size = new System.Drawing.Size(152, 26);
            this.contextMenuStrip1.Opening += new System.ComponentModel.CancelEventHandler(this.contextMenuStrip1_Opening);
            // 
            // generateGUIDToolStripMenuItem
            // 
            this.generateGUIDToolStripMenuItem.Name = "generateGUIDToolStripMenuItem";
            this.generateGUIDToolStripMenuItem.Size = new System.Drawing.Size(151, 22);
            this.generateGUIDToolStripMenuItem.Text = "Generate GUID";
            this.generateGUIDToolStripMenuItem.Click += new System.EventHandler(this.generateGUIDToolStripMenuItem_Click);
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
            this.carbonTheme1.Sizable = true;
            this.carbonTheme1.Size = new System.Drawing.Size(287, 508);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 8;
            this.carbonTheme1.Text = "Assembly";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.btnClone);
            this.panel1.Controls.Add(this.carbonButton3);
            this.panel1.Controls.Add(this.carbonButton2);
            this.panel1.Controls.Add(this.carbonButton1);
            this.panel1.Controls.Add(this.carbonGroupBox1);
            this.panel1.Controls.Add(this.tv);
            this.panel1.Location = new System.Drawing.Point(12, 27);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(263, 469);
            this.panel1.TabIndex = 3;
            // 
            // carbonGroupBox1
            // 
            this.carbonGroupBox1.BackColor = System.Drawing.Color.FromArgb(((int)(((byte)(211)))), ((int)(((byte)(211)))), ((int)(((byte)(211)))));
            this.carbonGroupBox1.BorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.carbonGroupBox1.Controls.Add(this.txtIconPath);
            this.carbonGroupBox1.Controls.Add(this.btnOpenIcon);
            this.carbonGroupBox1.Controls.Add(this.pBox);
            this.carbonGroupBox1.Customization = "09PT/6mpqf+pqan/////Rv///x7AwMD/4ODg/2xsbP8AAAD/qamp/w==";
            this.carbonGroupBox1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonGroupBox1.Image = null;
            this.carbonGroupBox1.Location = new System.Drawing.Point(3, 336);
            this.carbonGroupBox1.Movable = true;
            this.carbonGroupBox1.Name = "carbonGroupBox1";
            this.carbonGroupBox1.NoRounding = false;
            this.carbonGroupBox1.Sizable = true;
            this.carbonGroupBox1.Size = new System.Drawing.Size(258, 70);
            this.carbonGroupBox1.SmartBounds = true;
            this.carbonGroupBox1.TabIndex = 8;
            this.carbonGroupBox1.Text = "Icon";
            this.carbonGroupBox1.TransparencyKey = System.Drawing.Color.Empty;
            this.carbonGroupBox1.Transparent = false;
            // 
            // btnOpenIcon
            // 
            this.btnOpenIcon.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnOpenIcon.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnOpenIcon.Image = null;
            this.btnOpenIcon.Location = new System.Drawing.Point(166, 33);
            this.btnOpenIcon.Name = "btnOpenIcon";
            this.btnOpenIcon.NoRounding = false;
            this.btnOpenIcon.Size = new System.Drawing.Size(39, 24);
            this.btnOpenIcon.TabIndex = 1;
            this.btnOpenIcon.Text = "...";
            this.btnOpenIcon.Transparent = false;
            this.btnOpenIcon.Click += new System.EventHandler(this.btnOpenIcon_Click);
            // 
            // txtIconPath
            // 
            this.txtIconPath.Customization = "AAAA/+Dg4P+pqan/qamp/////wD///8A";
            this.txtIconPath.Font = new System.Drawing.Font("Verdana", 8F);
            this.txtIconPath.Image = null;
            this.txtIconPath.Location = new System.Drawing.Point(12, 33);
            this.txtIconPath.MaxLength = 32767;
            this.txtIconPath.Multiline = false;
            this.txtIconPath.Name = "txtIconPath";
            this.txtIconPath.NoRounding = false;
            this.txtIconPath.NumbersOnly = false;
            this.txtIconPath.ReadOnly = false;
            this.txtIconPath.Size = new System.Drawing.Size(148, 24);
            this.txtIconPath.TabIndex = 2;
            this.txtIconPath.Transparent = false;
            this.txtIconPath.UseSystemPasswordChar = false;
            // 
            // carbonButton1
            // 
            this.carbonButton1.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton1.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton1.Image = null;
            this.carbonButton1.Location = new System.Drawing.Point(15, 441);
            this.carbonButton1.Name = "carbonButton1";
            this.carbonButton1.NoRounding = false;
            this.carbonButton1.Size = new System.Drawing.Size(75, 23);
            this.carbonButton1.TabIndex = 9;
            this.carbonButton1.Text = "Done";
            this.carbonButton1.Transparent = false;
            this.carbonButton1.Click += new System.EventHandler(this.carbonButton1_Click);
            // 
            // carbonButton2
            // 
            this.carbonButton2.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton2.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton2.Image = null;
            this.carbonButton2.Location = new System.Drawing.Point(96, 441);
            this.carbonButton2.Name = "carbonButton2";
            this.carbonButton2.NoRounding = false;
            this.carbonButton2.Size = new System.Drawing.Size(75, 23);
            this.carbonButton2.TabIndex = 10;
            this.carbonButton2.Text = "Clear Icon";
            this.carbonButton2.Transparent = false;
            this.carbonButton2.Click += new System.EventHandler(this.carbonButton2_Click);
            // 
            // carbonButton3
            // 
            this.carbonButton3.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.carbonButton3.Font = new System.Drawing.Font("Verdana", 8F);
            this.carbonButton3.Image = null;
            this.carbonButton3.Location = new System.Drawing.Point(177, 441);
            this.carbonButton3.Name = "carbonButton3";
            this.carbonButton3.NoRounding = false;
            this.carbonButton3.Size = new System.Drawing.Size(75, 23);
            this.carbonButton3.TabIndex = 11;
            this.carbonButton3.Text = "Clear All";
            this.carbonButton3.Transparent = false;
            this.carbonButton3.Click += new System.EventHandler(this.carbonButton3_Click);
            // 
            // btnClone
            // 
            this.btnClone.Customization = "gICA/6mpqf/T09P/////AICAgP+pqan/aWlp/9PT0//AwMD/AAAA/6mpqf8=";
            this.btnClone.Font = new System.Drawing.Font("Verdana", 8F);
            this.btnClone.Image = null;
            this.btnClone.Location = new System.Drawing.Point(3, 412);
            this.btnClone.Name = "btnClone";
            this.btnClone.NoRounding = false;
            this.btnClone.Size = new System.Drawing.Size(258, 23);
            this.btnClone.TabIndex = 12;
            this.btnClone.Text = "Clone";
            this.btnClone.Transparent = false;
            this.btnClone.Click += new System.EventHandler(this.btnClone_Click);
            // 
            // AssemblyEditor
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(287, 508);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.MaximizeBox = false;
            this.Name = "AssemblyEditor";
            this.ShowIcon = false;
            this.ShowInTaskbar = false;
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "AssemblyEditor";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            ((System.ComponentModel.ISupportInitialize)(this.pBox)).EndInit();
            this.contextMenuStrip1.ResumeLayout(false);
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.carbonGroupBox1.ResumeLayout(false);
            this.ResumeLayout(false);

        }

        #endregion

        private xTreeView tv;
        private System.Windows.Forms.PictureBox pBox;
        private System.Windows.Forms.ContextMenuStrip contextMenuStrip1;
        private System.Windows.Forms.ToolStripMenuItem generateGUIDToolStripMenuItem;
        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private CarbonButton btnClone;
        private CarbonButton carbonButton3;
        private CarbonButton carbonButton2;
        private CarbonButton carbonButton1;
        private CarbonGroupBox carbonGroupBox1;
        private CarbonTextBox txtIconPath;
        private CarbonButton btnOpenIcon;

    }
}