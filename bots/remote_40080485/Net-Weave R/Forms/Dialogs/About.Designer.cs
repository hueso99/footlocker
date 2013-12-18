namespace Net_Weave_R.Forms.Dialogs
{
    partial class About
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
            System.Windows.Forms.TreeNode treeNode1 = new System.Windows.Forms.TreeNode("Developer - xSilent");
            System.Windows.Forms.TreeNode treeNode2 = new System.Windows.Forms.TreeNode("Selller - badhackz8t");
            System.Windows.Forms.TreeNode treeNode3 = new System.Windows.Forms.TreeNode("sienk01");
            System.Windows.Forms.TreeNode treeNode4 = new System.Windows.Forms.TreeNode("badhackz8t");
            System.Windows.Forms.TreeNode treeNode5 = new System.Windows.Forms.TreeNode("Support", new System.Windows.Forms.TreeNode[] {
            treeNode3,
            treeNode4});
            System.Windows.Forms.TreeNode treeNode6 = new System.Windows.Forms.TreeNode("Staff", new System.Windows.Forms.TreeNode[] {
            treeNode1,
            treeNode2,
            treeNode5});
            System.Windows.Forms.TreeNode treeNode7 = new System.Windows.Forms.TreeNode("xMercuryx");
            System.Windows.Forms.TreeNode treeNode8 = new System.Windows.Forms.TreeNode("sienk01");
            System.Windows.Forms.TreeNode treeNode9 = new System.Windows.Forms.TreeNode("Testers", new System.Windows.Forms.TreeNode[] {
            treeNode7,
            treeNode8});
            System.Windows.Forms.TreeNode treeNode10 = new System.Windows.Forms.TreeNode("DragonHunter");
            System.Windows.Forms.TreeNode treeNode11 = new System.Windows.Forms.TreeNode("GREENEXXX (Theme)");
            System.Windows.Forms.TreeNode treeNode12 = new System.Windows.Forms.TreeNode("The Mono Team");
            System.Windows.Forms.TreeNode treeNode13 = new System.Windows.Forms.TreeNode("Special Thanks", new System.Windows.Forms.TreeNode[] {
            treeNode10,
            treeNode11,
            treeNode12});
            System.Windows.Forms.TreeNode treeNode14 = new System.Windows.Forms.TreeNode("v2.0");
            System.Windows.Forms.TreeNode treeNode15 = new System.Windows.Forms.TreeNode("Framework", new System.Windows.Forms.TreeNode[] {
            treeNode14});
            System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(About));
            this.carbonTheme1 = new CarbonTheme();
            this.panel1 = new System.Windows.Forms.Panel();
            this.label1 = new System.Windows.Forms.Label();
            this.xTree = new NetLib.Forms.xTreeView();
            this.imageList1 = new System.Windows.Forms.ImageList(this.components);
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
            this.carbonTheme1.Size = new System.Drawing.Size(258, 321);
            this.carbonTheme1.SmartBounds = true;
            this.carbonTheme1.TabIndex = 0;
            this.carbonTheme1.Text = "About";
            this.carbonTheme1.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.Transparent = false;
            // 
            // panel1
            // 
            this.panel1.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
            this.panel1.Controls.Add(this.label1);
            this.panel1.Controls.Add(this.xTree);
            this.panel1.Location = new System.Drawing.Point(12, 28);
            this.panel1.Name = "panel1";
            this.panel1.Size = new System.Drawing.Size(234, 281);
            this.panel1.TabIndex = 3;
            // 
            // label1
            // 
            this.label1.AutoSize = true;
            this.label1.Location = new System.Drawing.Point(3, 261);
            this.label1.Name = "label1";
            this.label1.Size = new System.Drawing.Size(103, 13);
            this.label1.TabIndex = 1;
            this.label1.Text = "Version: X.X.X.X";
            // 
            // xTree
            // 
            this.xTree.Dock = System.Windows.Forms.DockStyle.Top;
            this.xTree.ImageIndex = 0;
            this.xTree.ImageList = this.imageList1;
            this.xTree.Location = new System.Drawing.Point(0, 0);
            this.xTree.Name = "xTree";
            treeNode1.ImageIndex = 2;
            treeNode1.Name = "Node1";
            treeNode1.Text = "Developer - xSilent";
            treeNode2.ImageIndex = 6;
            treeNode2.Name = "Node3";
            treeNode2.Text = "Selller - badhackz8t";
            treeNode3.ImageIndex = 4;
            treeNode3.Name = "Node14";
            treeNode3.Text = "sienk01";
            treeNode4.ImageIndex = 4;
            treeNode4.Name = "Node19";
            treeNode4.Text = "badhackz8t";
            treeNode5.ImageIndex = 3;
            treeNode5.Name = "Node13";
            treeNode5.Text = "Support";
            treeNode6.ImageIndex = 5;
            treeNode6.Name = "Node0";
            treeNode6.Text = "Staff";
            treeNode7.ImageIndex = 8;
            treeNode7.Name = "Node17";
            treeNode7.Text = "xMercuryx";
            treeNode8.ImageIndex = 8;
            treeNode8.Name = "Node18";
            treeNode8.Text = "sienk01";
            treeNode9.ImageIndex = 8;
            treeNode9.Name = "Node16";
            treeNode9.Text = "Testers";
            treeNode10.ImageIndex = 1;
            treeNode10.Name = "Node8";
            treeNode10.Text = "DragonHunter";
            treeNode11.ImageIndex = 1;
            treeNode11.Name = "Node9";
            treeNode11.Text = "GREENEXXX (Theme)";
            treeNode12.ImageIndex = 1;
            treeNode12.Name = "Node10";
            treeNode12.Text = "The Mono Team";
            treeNode13.ImageIndex = 1;
            treeNode13.Name = "Node6";
            treeNode13.Text = "Special Thanks";
            treeNode14.ImageIndex = 7;
            treeNode14.Name = "Node12";
            treeNode14.Text = "v2.0";
            treeNode15.ImageIndex = 7;
            treeNode15.Name = "Node11";
            treeNode15.Text = "Framework";
            this.xTree.Nodes.AddRange(new System.Windows.Forms.TreeNode[] {
            treeNode6,
            treeNode9,
            treeNode13,
            treeNode15});
            this.xTree.SelectedImageIndex = 5;
            this.xTree.Size = new System.Drawing.Size(234, 258);
            this.xTree.TabIndex = 0;
            this.xTree.AfterSelect += new System.Windows.Forms.TreeViewEventHandler(this.xTree_AfterSelect);
            // 
            // imageList1
            // 
            this.imageList1.ImageStream = ((System.Windows.Forms.ImageListStreamer)(resources.GetObject("imageList1.ImageStream")));
            this.imageList1.TransparentColor = System.Drawing.Color.Transparent;
            this.imageList1.Images.SetKeyName(0, "Apps-users-icon.png");
            this.imageList1.Images.SetKeyName(1, "Emblems-emblem-favorite-icon.png");
            this.imageList1.Images.SetKeyName(2, "Categories-applications-engineering-icon.png");
            this.imageList1.Images.SetKeyName(3, "Apps-preferences-desktop-notification-icon.png");
            this.imageList1.Images.SetKeyName(4, "Apps-preferences-desktop-user-icon.png");
            this.imageList1.Images.SetKeyName(5, "Apps-system-users-icon.png");
            this.imageList1.Images.SetKeyName(6, "Actions-resource-group-icon.png");
            this.imageList1.Images.SetKeyName(7, "Categories-applications-system-icon.png");
            this.imageList1.Images.SetKeyName(8, "Actions-view-process-users-icon.png");
            // 
            // About
            // 
            this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
            this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
            this.ClientSize = new System.Drawing.Size(258, 321);
            this.Controls.Add(this.carbonTheme1);
            this.FormBorderStyle = System.Windows.Forms.FormBorderStyle.None;
            this.Name = "About";
            this.StartPosition = System.Windows.Forms.FormStartPosition.CenterScreen;
            this.Text = "About";
            this.TransparencyKey = System.Drawing.Color.Fuchsia;
            this.carbonTheme1.ResumeLayout(false);
            this.panel1.ResumeLayout(false);
            this.panel1.PerformLayout();
            this.ResumeLayout(false);

        }

        #endregion

        private CarbonTheme carbonTheme1;
        private System.Windows.Forms.Panel panel1;
        private System.Windows.Forms.Label label1;
        private NetLib.Forms.xTreeView xTree;
        private System.Windows.Forms.ImageList imageList1;
    }
}